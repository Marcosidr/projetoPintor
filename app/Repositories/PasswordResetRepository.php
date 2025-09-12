<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

class PasswordResetRepository {
    private PDO $db;
    public function __construct(?PDO $conn = null) { $this->db = $conn ?: Database::connection(); }

    public function invalidatePrevious(string $email): void {
        $stmt = $this->db->prepare('UPDATE password_resets SET used_at = NOW() WHERE email = :e AND used_at IS NULL');
        $stmt->execute(['e'=>$email]);
    }

    public function create(string $email, string $tokenHash, \DateTimeInterface $expiresAt, ?string $ip, ?string $ua): int {
        $stmt = $this->db->prepare('INSERT INTO password_resets (email, token_hash, expires_at, ip, user_agent) VALUES (:e,:t,:x,:ip,:ua)');
        $stmt->execute([
            'e'=>$email,
            't'=>$tokenHash,
            'x'=>$expiresAt->format('Y-m-d H:i:s'),
            'ip'=>$ip,
            'ua'=>substr((string)$ua,0,255)
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function findValid(string $email, string $tokenHash, \DateTimeInterface $now): ?array {
        $stmt = $this->db->prepare('SELECT * FROM password_resets WHERE email=:e AND token_hash=:t AND used_at IS NULL AND expires_at > :n LIMIT 1');
        $stmt->execute(['e'=>$email,'t'=>$tokenHash,'n'=>$now->format('Y-m-d H:i:s')]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC); return $r ?: null;
    }

    public function markUsed(int $id): void {
        $stmt = $this->db->prepare('UPDATE password_resets SET used_at = NOW() WHERE id=:i');
        $stmt->execute(['i'=>$id]);
    }

    public function cleanupExpired(\DateTimeInterface $now): int {
        $stmt = $this->db->prepare('DELETE FROM password_resets WHERE (used_at IS NOT NULL) OR (expires_at <= :n)');
        $stmt->execute(['n'=>$now->format('Y-m-d H:i:s')]);
        return $stmt->rowCount();
    }
}
