<?php
namespace App\Repositories;

use App\Core\Database; use PDO;

class LoginAttemptRepository {
    private PDO $db; public function __construct(?PDO $c=null){ $this->db = $c ?: Database::connection(); }

    public function record(?string $email, ?string $ip, bool $sucesso): void {
        $stmt = $this->db->prepare('INSERT INTO login_attempts (email, ip, sucesso) VALUES (:e,:ip,:s)');
        $stmt->execute(['e'=>$email,'ip'=>$ip,'s'=>$sucesso?1:0]);
    }

    public function countRecentFailures(?string $email, ?string $ip, \DateTimeInterface $since): int {
        $conds = ['sucesso=0','created_at >= :since']; $params=['since'=>$since->format('Y-m-d H:i:s')];
        if ($email) { $conds[]='email = :e'; $params['e']=$email; }
        if ($ip) { $conds[]='ip = :ip'; $params['ip']=$ip; }
        $sql = 'SELECT COUNT(*) FROM login_attempts WHERE '.implode(' AND ', $conds);
        $stmt = $this->db->prepare($sql); $stmt->execute($params); return (int)$stmt->fetchColumn();
    }

    public function clearFailures(?string $email): void {
        if(!$email) return; $stmt = $this->db->prepare('DELETE FROM login_attempts WHERE email=:e'); $stmt->execute(['e'=>$email]);
    }
}
