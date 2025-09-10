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

switch ($uri) {
    case '/':
    case '/index.php':
        view('home/index');
        break;
    case '/servicos':
        view('servicos/index');
        break;
    case '/catalogos':
        view('catalogos/index');
        break;
    case '/quem-somos':
        view('quem_somos/index');
        break;
    default:
        view('errors/404');
        break;
}
