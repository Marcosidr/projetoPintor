<?php
// LEGACY: prefira UsuarioRepository para novo código.
class User {
    public static function count(): int {
        try { return (int) db()->query("SELECT COUNT(*) FROM usuarios")?->fetchColumn(); } catch (Throwable) { return 0; }
    }
    public static function countAdmins(): int {
        try { $st = db()->query("SELECT COUNT(*) FROM usuarios WHERE tipo='admin'"); return (int)$st?->fetchColumn(); } catch (Throwable) { return 0; }
    }
    public static function all(): array {
        try { return db()->query("SELECT id,nome,email,tipo,created_at FROM usuarios ORDER BY id DESC")?->fetchAll(PDO::FETCH_ASSOC) ?: []; } catch (Throwable) { return []; }
    }
    public static function findByEmail(string $email): ?array {
        try { $st = db()->prepare("SELECT * FROM usuarios WHERE email=:e LIMIT 1"); $st->execute(['e'=>$email]); $r=$st->fetch(PDO::FETCH_ASSOC); return $r?:null; } catch (Throwable) { return null; }
    }
}