<?php
namespace App\Services;

use App\Repositories\UsuarioRepository;
use App\Repositories\LoginAttemptRepository;

/**
 * Serviço de autenticação responsável por:
 *  - Login com proteção de lockout (brute force) baseada em tentativas falhas por e-mail/IP em janela de 15 minutos.
 *  - Registro de novo usuário com hash seguro (Argon2id quando disponível, fallback para algoritmo default).
 *  - Retorno padronizado de estrutura ['ok'=>bool, 'error'? , 'user'?].
 *
 * Motivações de segurança:
 *  - Normalização de e-mail (lowercase + trim) para evitar duplicidade.
 *  - Lockout após 5 falhas reduz viabilidade de ataques de força bruta.
 *  - Uso de Argon2id com parâmetros configurados (memória, tempo, threads) melhora resistência.
 */
class AuthService {
    /** @var object Repositório de usuários (contrato: findByEmail(string):?array, create(array):int) */
    private $users; 
    private LoginAttemptRepository $attempts;

    public function __construct($users = null, ?LoginAttemptRepository $attempts = null) {
        $this->users = $users ?? new UsuarioRepository();
        $this->attempts = $attempts ?? new LoginAttemptRepository();
    }

    /** Realiza login com verificação de lockout e registra tentativa */
    public function login(string $email, string $senha): array {
        $email = strtolower(trim($email));
        if ($email === '' || $senha === '') return ['ok'=>false,'error'=>'Campos obrigatórios.'];

        // Lockout: 5 falhas nos últimos 15 minutos bloqueiam novas tentativas
        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $since = new \DateTimeImmutable('-15 minutes');
        $falhas = $this->attempts->countRecentFailures($email, $ip, $since);
        if ($falhas >= 5) {
            return ['ok'=>false,'error'=>'Muitas tentativas. Aguarde alguns minutos.'];
        }

        $user = $this->users->findByEmail($email);
        if (!$user || !password_verify($senha, $user['senha'])) {
            $this->attempts->record($email, $ip, false); // registra falha
            return ['ok'=>false,'error'=>'Credenciais inválidas.'];
        }

        // Sucesso: registra sucesso e limpa histórico de falhas para esse e-mail
        $this->attempts->record($email, $ip, true);
        $this->attempts->clearFailures($email);
        return ['ok'=>true,'user'=>['id'=>$user['id'],'nome'=>$user['nome'],'email'=>$user['email'],'tipo'=>$user['tipo']]];
    }

    /** Registra novo usuário garantindo unicidade de e-mail e força mínima de senha */
    public function register(string $nome, string $email, string $senha): array {
        $nome = trim($nome); $email = strtolower(trim($email));
        if ($nome===''||$email===''||$senha==='') return ['ok'=>false,'error'=>'Preencha todos os campos.'];
        if (strlen($senha) < 6) return ['ok'=>false,'error'=>'Senha mínima de 6 caracteres.'];
        if ($this->users->findByEmail($email)) return ['ok'=>false,'error'=>'E-mail já registrado.'];
        $hash = $this->hashSenha($senha);
        $id = $this->users->create(['nome'=>$nome,'email'=>$email,'senha'=>$hash,'tipo'=>'user']);
        // Retorna estrutura contendo ID e bloco user para consumo unificado pelo controller
        return ['ok'=>true,'id'=>$id,'user'=>['id'=>$id,'nome'=>$nome,'email'=>$email,'tipo'=>'user']];
    }

    /** Gera hash privilegiando Argon2id (quando PHP suporta) */
    private function hashSenha(string $senha): string {
        if (defined('PASSWORD_ARGON2ID')) {
            return password_hash($senha, PASSWORD_ARGON2ID, [
                'memory_cost' => 1<<16, // 64MB
                'time_cost' => 3,       // iterações
                'threads' => 2,         // paralelismo
            ]);
        }
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}
