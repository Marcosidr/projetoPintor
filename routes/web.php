<?php
use App\Controllers\HomeController;
use App\Controllers\ServicoController;
use App\Controllers\CatalogoController;
use App\Controllers\AuthController;
use App\Controllers\DashboardController;
use App\Controllers\QuemSomosController;
use App\Controllers\LogController;
use App\Controllers\OrcamentoController;
use App\Controllers\AdminUserApiController;

/* Públicas */
$router->get('/', [HomeController::class, 'index']);
$router->get('/servicos', [ServicoController::class, 'index']);
$router->get('/catalogos', [CatalogoController::class, 'index']);
$router->get('/quem-somos', [HomeController::class, 'about']);
$router->post('/orcamento', [OrcamentoController::class, 'store']);

/* Auth */
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);
$router->get('/forgot-password', [AuthController::class, 'forgotPassword']);
$router->post('/forgot-password', [AuthController::class, 'sendReset']);
$router->get('/reset-password', [AuthController::class, 'showResetForm']);
$router->post('/reset-password', [AuthController::class, 'processReset']);
$router->post('/logout', [AuthController::class, 'logout']);

/* Painel */
$router->get('/painel', [DashboardController::class, 'index'], [\App\Middleware\AuthMiddleware::class]);
$router->get('/painel/logs', [LogController::class, 'index'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/log', [LogController::class, 'store']);

/* Admin Usuarios */
$router->get('/admin', [\App\Controllers\AdminController::class, 'index'], [\App\Middleware\AdminMiddleware::class]);
$router->get('/admin/create', [\App\Controllers\AdminController::class, 'create'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/admin/store', [\App\Controllers\AdminController::class, 'store'], [\App\Middleware\AdminMiddleware::class]);
$router->get('/admin/edit/{id}', [\App\Controllers\AdminController::class, 'edit'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/admin/update/{id}', [\App\Controllers\AdminController::class, 'update'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/admin/destroy/{id}', [\App\Controllers\AdminController::class, 'destroy'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/admin/toggle-admin/{id}', [\App\Controllers\AdminController::class, 'toggleAdmin'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/admin/reset-senha/{id}', [\App\Controllers\AdminController::class, 'resetSenha'], [\App\Middleware\AdminMiddleware::class]);

/* Admin Catálogos */
$router->get('/admin/catalogos', [\App\Controllers\CatalogoAdminController::class, 'index'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/admin/catalogos', [\App\Controllers\CatalogoAdminController::class, 'store'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/admin/catalogos/delete/{id}', [\App\Controllers\CatalogoAdminController::class, 'delete'], [\App\Middleware\AdminMiddleware::class]);

// TODO: adicionar rotas admin, orcamento e logs detalhados.

/* API Admin Users (JSON) */
$router->get('/api/admin/users', [AdminUserApiController::class, 'index'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/api/admin/users', [AdminUserApiController::class, 'store'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/api/admin/users/update/{id}', [AdminUserApiController::class, 'update'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/api/admin/users/delete/{id}', [AdminUserApiController::class, 'destroy'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/api/admin/users/reset/{id}', [AdminUserApiController::class, 'resetSenha'], [\App\Middleware\AdminMiddleware::class]);
$router->post('/api/admin/users/toggle/{id}', [AdminUserApiController::class, 'toggleAdmin'], [\App\Middleware\AdminMiddleware::class]);