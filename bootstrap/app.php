<?php
use App\Core\Env; use App\Core\Router; use App\Core\Session;

// Sessão
Session::set('__boot', true); // garante start preguiçoso

// Config básica
require ROOT_PATH . 'app/Core/Config.php';

// Carrega .env (se existir)
Env::load(ROOT_PATH . '.env');

// Helper de view legado (enquanto Controllers não migrados)
if (!function_exists('view')) {
	function view($path, $data = []) { extract($data); ob_start(); require ROOT_PATH . 'app/Views/' . $path . '.php'; $content = ob_get_clean(); require ROOT_PATH . 'app/Views/layouts/main.php'; }
}

// Router novo
$router = new Router();
require ROOT_PATH . 'routes/web.php';
$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
