<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

header('Content-Type: application/json');

// Bloqueia acesso se não for admin
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    echo json_encode(["status" => "error", "msg" => "Acesso negado"]);
    exit;
}

$id = intval($_GET["id"] ?? 0);
if ($id <= 0) {
    echo json_encode(["status" => "error", "msg" => "ID inválido"]);
    exit;
}

// Verifica se o usuário existe
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
$stmt->execute(["id" => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo json_encode(["status" => "error", "msg" => "Usuário não encontrado"]);
    exit;
}

// Define nova senha
$novaSenha = "123456";
$hash = md5($novaSenha);

$stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
$stmt->execute([
    "senha" => $hash,
    "id" => $id
]);

echo json_encode([
    "status" => "success",
    "msg"    => "Senha do usuário '{$user["nome"]}' foi resetada para '{$novaSenha}'"
]);
