<?php
require_once __DIR__ . "/../classes/Logger.php";


$host = "localhost";   // ou 127.0.0.1
$db   = "CLPinturas";      // nome do banco que você criou
$user = "root";        // usuário do MySQL
$pass = "";            // senha do MySQL (no XAMPP geralmente fica vazio)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
