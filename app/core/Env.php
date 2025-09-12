<?php
namespace App\Core;

class Env {
    private static array $cache = [];

    public static function load(string $path): void {
        if (!is_file($path)) return;
        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            if (str_starts_with(trim($line), '#')) continue;
            [$k,$v] = array_pad(explode('=', $line, 2), 2, '');
            $k = trim($k); $v = trim($v);
            if ($k==='') continue;
            self::$cache[$k] = $v;
            if (!array_key_exists($k, $_ENV)) $_ENV[$k] = $v;
            if (!array_key_exists($k, $_SERVER)) $_SERVER[$k] = $v;
        }
    }

    public static function get(string $key, ?string $default = null): ?string {
        return self::$cache[$key] ?? $_ENV[$key] ?? $default;
    }
}
