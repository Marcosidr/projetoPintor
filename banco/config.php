<?php
// ================================
// CONFIGURAÇÃO DE CONEXÃO COM O BANCO
// ================================

// Define o caminho absoluto para a raiz do projeto
define('ROOT_PATH', __DIR__ . '/');

// Inclui as credenciais do banco
require_once __DIR__ . '/../banco/credenciais.php';

// Configuração de conexão
$host    = DB_HOST;      // Host do banco
$db      = DB_NAME;      // Nome do banco (CLPinturas)
$user    = DB_USER;      // Usuário do banco
$pass    = DB_PASS;      // Senha do banco
$charset = 'utf8mb4';    // Charset recomendado

// DSN para PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Opções do PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna arrays associativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Usa prepared statements reais
];

// Conexão PDO
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
   
} catch (PDOException $e) {
    // Mensagem de erro detalhada
    die("Erro ao conectar ao banco de dados CLPinturas: " . $e->getMessage());
}
