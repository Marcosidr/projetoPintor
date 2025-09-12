<?php
// Carrega autoload e prepara ambiente de teste (DB em memória se aplicável futuramente)
require __DIR__ . '/../vendor/autoload.php';
define('ROOT_PATH', __DIR__ . '/../');
// Poderíamos configurar uma conexão de teste separada via variáveis .env específicas no futuro.
