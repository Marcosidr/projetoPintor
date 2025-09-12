<?php
namespace App\Services;

use App\Repositories\PasswordResetRepository;
use App\Repositories\UsuarioRepository;

class PasswordResetService {
    public function __construct(
        private PasswordResetRepository $resets = new PasswordResetRepository(),
        private UsuarioRepository $users = new UsuarioRepository()
    ) {}

    private function hashToken(string $raw): string {
        return hash('sha256', $raw);
    }

    public function generate(string $email, int $ttlMinutes = 60): ?array {
        $email = strtolower(trim($email));
        if ($email === '') return null;
        $user = $this->users->findByEmail($email);
        if (!$user) return null; // não revelar
        $raw = bin2hex(random_bytes(32));
        $hash = $this->hashToken($raw);
        $expires = (new \DateTimeImmutable('+'.max(1,$ttlMinutes).' minutes'));
        $ip = $_SERVER['REMOTE_ADDR'] ?? null; $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;
        $this->resets->invalidatePrevious($email);
        $this->resets->create($email, $hash, $expires, $ip, $ua);
        return [
            'rawToken' => $raw,
            'email' => $email,
            'expires_at' => $expires,
        ];
    }

    public function validate(string $email, string $rawToken): ?array {
        $email = strtolower(trim($email)); if($email==='') return null;
        if ($rawToken === '' || !preg_match('/^[a-f0-9]{64}$/',$rawToken)) return null;
        $hash = $this->hashToken($rawToken);
        $now = new \DateTimeImmutable();
        return $this->resets->findValid($email, $hash, $now);
    }

    public function consume(string $email, string $rawToken, string $novaSenha): bool {
        $row = $this->validate($email, $rawToken);
        if(!$row) return false;
        $user = $this->users->findByEmail($email); if(!$user) return false;
        $hashSenha = $this->hashSenha($novaSenha);
        $this->users->update($user['id'], ['senha'=>$hashSenha]);
        $this->resets->markUsed($row['id']);
        return true;
    }

    private function hashSenha(string $senha): string {
        if (defined('PASSWORD_ARGON2ID')) {
            return password_hash($senha, PASSWORD_ARGON2ID, [
                'memory_cost' => 1<<17,
                'time_cost' => 4,
                'threads' => 2,
            ]);
        }
        return password_hash($senha, PASSWORD_DEFAULT);
    }
}
