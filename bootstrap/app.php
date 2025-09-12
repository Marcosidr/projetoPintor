<?php
use App\Core\Env; use App\Core\Router; use App\Core\Session;

// Sessão
Session::set('__boot', true); // garante start preguiçoso

// Config básica
require ROOT_PATH . 'app/Core/Config.php';

// Carrega .env (se existir)
Env::load(ROOT_PATH . '.env');

// Helper db() legacy (usado por antigos models) - evita fatal error
if (!function_exists('db')) {
	function db(): PDO {
		static $pdo = null; if ($pdo) return $pdo;
		$pdo = \App\Core\Database::connection();
		return $pdo;
	}
}

// Helper de view legado (enquanto Controllers não migrados)
if (!function_exists('view')) {
	function view($path, $data = []) { extract($data); ob_start(); require ROOT_PATH . 'app/Views/' . $path . '.php'; $content = ob_get_clean(); require ROOT_PATH . 'app/Views/layouts/main.php'; }
}

// Router novo
$router = new Router();
require ROOT_PATH . 'routes/web.php';
// Middleware global de segurança (headers)
try {
	(new \App\Middleware\SecurityHeadersMiddleware())->handle();
} catch (\Throwable $e) {
	// silencioso: headers já podem ter sido enviados em algum edge case
}

// Normaliza URI removendo BASE_URL (caso app esteja em subdiretório)
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$parsed = parse_url($requestUri, PHP_URL_PATH) ?: '/';
$base = rtrim(BASE_URL, '/');
if ($base !== '' && $base !== '/' && str_starts_with($parsed, $base)) {
	$parsed = substr($parsed, strlen($base)) ?: '/';
}
$router->dispatch($method, $parsed);
