<?php
// Define o caminho absoluto para a raiz do seu projeto
define('ROOT_PATH', __DIR__ . '/');

// Certifique-se de que o caminho abaixo esteja CORRETO para onde você salvou o arquivo seguro
require_once __DIR__ . '/../credenciais.php'; 

$host = DB_HOST; 
$db  = DB_NAME;
$user = DB_USER; 
$pass = DB_PASS; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
 PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
$pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
 die("Erro ao conectar ao banco: " . $e->getMessage());
}