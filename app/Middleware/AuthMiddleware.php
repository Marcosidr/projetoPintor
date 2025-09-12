<?php
namespace App\Middleware;

use App\Core\Auth;
use App\Core\Response;

class AuthMiddleware {
    public function __construct(private bool $adminOnly = false) {}
    public function handle(): bool {
        if (!Auth::check()) { Response::redirect(BASE_URL.'/login'); return false; }
        if ($this->adminOnly && !Auth::checkAdmin()) { Response::redirect(BASE_URL.'/painel'); return false; }
        return true;
    }
    public static function onlyAdmin(): self { return new self(true); }
}
