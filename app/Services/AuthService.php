<?php
namespace App\Services;

use App\Repositories\UsuarioRepository;
use App\Repositories\LoginAttemptRepository;

class AuthService {
    /** @var object repo com métodos findByEmail(string):?array e create(array):int */
    private $users; private LoginAttemptRepository $attempts;
    public function __construct($users = null, ?LoginAttemptRepository $attempts = null) {
        $this->users = $users ?? new UsuarioRepository();
        $this->attempts = $attempts ?? new LoginAttemptRepository();
    }

    public function login(string $email, string $senha): array {
        $email = strtolower(trim($email));
        if ($email === '' || $senha === '') return ['ok'=>false,'error'=>'Campos obrigatórios.'];
    // Lockout: após 5 falhas em 15 min (email ou IP). Contamos falhas anteriores e bloqueamos se já existem 5.
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $since = new \DateTimeImmutable('-15 minutes');
        $falhas = $this->attempts->countRecentFailures($email, $ip, $since);
        if ($falhas >= 5) {
            return ['ok'=>false,'error'=>'Muitas tentativas. Aguarde alguns minutos.'];
        }
        $user = $this->users->findByEmail($email);
        if (!$user || !password_verify($senha, $user['senha'])) {
            $this->attempts->record($email, $ip, false);
            return ['ok'=>false,'error'=>'Credenciais inválidas.'];
        }
        // sucesso -> limpa falhas
        $this->attempts->record($email, $ip, true);
        $this->attempts->clearFailures($email);
        return ['ok'=>true,'user'=>['id'=>$user['id'],'nome'=>$user['nome'],'email'=>$user['email'],'tipo'=>$user['tipo']]];
    }

    public function register(string $nome, string $email, string $senha): array {
        $nome = trim($nome); $email = strtolower(trim($email));
        if ($nome===''||$email===''||$senha==='') return ['ok'=>false,'error'=>'Preencha todos os campos.'];
        if (strlen($senha) < 6) return ['ok'=>false,'error'=>'Senha mínima de 6 caracteres.'];
        if ($this->users->findByEmail($email)) return ['ok'=>false,'error'=>'E-mail já registrado.'];
        $hash = $this->hashSenha($senha);
        $id = $this->users->create(['nome'=>$nome,'email'=>$email,'senha'=>$hash,'tipo'=>'user']);
        // Mantém assinatura simples mas já retorna estrutura parecida com login para padronização
        return ['ok'=>true,'id'=>$id,'user'=>['id'=>$id,'nome'=>$nome,'email'=>$email,'tipo'=>'user']];
    }

    private function hashSenha(string $senha): string {
        if (defined('PASSWORD_ARGON2ID')) {
            return password_hash($senha, PASSWORD_ARGON2ID, [
                'memory_cost' => 1<<16,
                'time_cost' => 3,
                'threads' => 2,
            ]);
        }
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}
