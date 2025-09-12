<?php
namespace App\Core;

class Csrf {
    public const KEY = '_csrf';

    public static function token(): string {
        $t = Session::get(self::KEY);
        if (!$t) { $t = bin2hex(random_bytes(16)); Session::set(self::KEY, $t); }
        return $t;
    }

    public static function validate(?string $token): bool {
        return hash_equals(Session::get(self::KEY,''), $token ?? '');
    }
}
