<?php
// Redireciona sempre para a aplicação MVC em /public
$scriptDir = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'])), '/');
$target = $scriptDir . '/public/';
if (strpos($_SERVER['REQUEST_URI'], '/public/') === false) {
    header('Location: ' . $target, true, 302);
    exit;
}
require __DIR__ . '/public/index.php';