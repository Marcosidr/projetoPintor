<?php
class User {
    public static function findByEmail($email) {
        $pdo = db();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public static function create($nome, $email, $senha) {
        $pdo = db();
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, 'user')");
        $stmt->execute([
            'nome' => $nome,
            'email' => strtolower($email),
            'senha' => password_hash($senha, PASSWORD_DEFAULT)
        ]);
    }

    public static function count() {
        return (int) db()->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
    }

    public static function countAdmins() {
        return (int) db()->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'admin'")->fetchColumn();
    }

    public static function all() {
        return db()->query("SELECT id, nome, email, tipo FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
    }
}
