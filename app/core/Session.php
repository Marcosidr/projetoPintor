<?php
namespace App\Core;

class Session {
    private static bool $started = false;
    private static function ensure(): void {
        if (!self::$started) {
            if (session_status() !== PHP_SESSION_ACTIVE) {
                @session_start();
            }
            self::$started = true;
        }
    }
    public static function get(string $key, $default = null): mixed { self::ensure(); return $_SESSION[$key] ?? $default; }
    public static function set(string $key, $value): void { self::ensure(); $_SESSION[$key] = $value; }
    public static function remove(string $key): void { self::ensure(); unset($_SESSION[$key]); }
    public static function regenerate(): void { self::ensure(); session_regenerate_id(true); }
}
