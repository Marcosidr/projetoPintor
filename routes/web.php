<?php
// routes/web.php

function view($path, $data = []) {
    extract($data);
    ob_start();
    require ROOT_PATH . "app/Views/{$path}.php";
    $content = ob_get_clean();
    require ROOT_PATH . "app/Views/layouts/main.php";
}

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Normaliza URI (remove /projetoPintor/public e /index.php)
$base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$uri = preg_replace('#^' . $base . '#', '', $uri);
$uri = '/' . trim($uri, '/');

switch ($uri) {
    case '/':
        require ROOT_PATH . 'app/Controllers/HomeController.php';
        (new HomeController())->index();
        break;

    case '/servicos':
        require ROOT_PATH . 'app/Controllers/ServicoController.php';
        (new ServicoController())->index();
        break;

    case '/catalogos':
        require ROOT_PATH . 'app/Controllers/CatalogoController.php';
        (new CatalogoController())->index();
        break;

    case '/quem-somos':
        require ROOT_PATH . 'app/Controllers/QuemSomosController.php';
        (new QuemSomosController())->index();
        break;

    default:
        view('errors/404');
        break;
}
