<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

header('Content-Type: application/json');

// Bloqueia acesso se não for admin
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    echo json_encode(["status" => "error", "msg" => "Acesso negado"]);
    exit;
}

// Pega os dados do POST
$id = intval($_POST["id"] ?? 0);
$novaSenha = trim($_POST["senha"] ?? "");

// Validações
if ($id <= 0) {
    echo json_encode(["status" => "error", "msg" => "ID inválido"]);
    exit;
}

if (empty($novaSenha)) {
    echo json_encode(["status" => "error", "msg" => "Senha não informada"]);
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

// Criptografa a senha de forma segura
$hash = password_hash($novaSenha, PASSWORD_DEFAULT);

// Atualiza no banco
$stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
$stmt->execute([
    "senha" => $hash,
    "id"    => $id
]);

echo json_encode([
    "status" => "success",
    "msg"    => "Senha do usuário '{$user["nome"]}' foi redefinida com sucesso!"
]);
