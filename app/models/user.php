<?php

class User {
    public static function count() {
        return (int) db()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    }

    public static function countAdmins() {
        $stmt = db()->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'admin'");
        return (int) $stmt->fetchColumn();
    }

    public static function all() {
        return db()->query("SELECT id, nome, email, tipo, created_at FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findByEmail($email) {
        $stmt = db()->prepare("SELECT * FROM usuarios WHERE email = :e LIMIT 1");
        $stmt->execute(['e' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}