<?php
namespace App\Middleware;

use App\Core\Auth;
use App\Core\Response;

class AdminMiddleware {
    public function handle(): bool {
        if (!Auth::checkAdmin()) { Response::redirect(BASE_URL . '/painel'); return false; }
        return true;
    }
}
