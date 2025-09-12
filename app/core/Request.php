<?php
namespace App\Core;

class Request {
    public function method(): string { return $_SERVER['REQUEST_METHOD'] ?? 'GET'; }
    public function uri(): string { return parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/'; }
    public function input(string $key, $default = null): mixed { return $_POST[$key] ?? $_GET[$key] ?? $default; }
    public function all(): array { return array_merge($_GET, $_POST); }
    public function isPost(): bool { return $this->method() === 'POST'; }
    public function isGet(): bool { return $this->method() === 'GET'; }
}
