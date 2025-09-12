<?php
namespace App\Core;

class Auth {
    public static function user(): ?array { return Session::get('usuario'); }
    public static function check(): bool { return (bool) self::user(); }
    public static function requireLogin(): void { if (!self::check()) { Response::redirect(BASE_URL . '/login'); } }
    public static function requireAdmin(): void { $u = self::user(); if (!$u || ($u['tipo'] ?? '') !== 'admin') { Response::redirect(BASE_URL . '/painel'); } }
    public static function checkAdmin(): bool { $u = self::user(); return $u && ($u['tipo'] ?? '') === 'admin'; }
}
