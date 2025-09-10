<?php
// public/index.php

// Ativa exibição de erros (temporário no desenvolvimento)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Caminho raiz
define('ROOT_PATH', dirname(__DIR__) . '/');

// Autoload do Composer
require ROOT_PATH . 'vendor/autoload.php';

// Bootstrap da aplicação
require ROOT_PATH . 'bootstrap/app.php';
