<?php
namespace App\Services;

use App\Repositories\UsuarioRepository;

class AuthService {
    /** @var object repo com métodos findByEmail(string):?array e create(array):int */
    private $users;
    public function __construct($users = null) {
        $this->users = $users ?? new UsuarioRepository();
    }

    public function login(string $email, string $senha): array {
        $email = strtolower(trim($email));
        if ($email === '' || $senha === '') return ['ok'=>false,'error'=>'Campos obrigatórios.'];
        $user = $this->users->findByEmail($email);
        if (!$user || !password_verify($senha, $user['senha'])) return ['ok'=>false,'error'=>'Credenciais inválidas.'];
        return ['ok'=>true,'user'=>['id'=>$user['id'],'nome'=>$user['nome'],'email'=>$user['email'],'tipo'=>$user['tipo']]];
    }

    public function register(string $nome, string $email, string $senha): array {
        $nome = trim($nome); $email = strtolower(trim($email));
        if ($nome===''||$email===''||$senha==='') return ['ok'=>false,'error'=>'Preencha todos os campos.'];
        if (strlen($senha) < 6) return ['ok'=>false,'error'=>'Senha mínima de 6 caracteres.'];
        if ($this->users->findByEmail($email)) return ['ok'=>false,'error'=>'E-mail já registrado.'];
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $id = $this->users->create(['nome'=>$nome,'email'=>$email,'senha'=>$hash,'tipo'=>'user']);
        return ['ok'=>true,'id'=>$id];
    }
}
