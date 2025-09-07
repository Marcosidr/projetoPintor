<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

// Bloqueia acesso se não for admin
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    header("Location: ../painel/login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);

// Verifica se o usuário existe
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
$stmt->execute(["id" => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado!");
}

// Define uma nova senha padrão
$novaSenha = "123456";
$hash = md5($novaSenha); // ⚠️ Recomendo trocar para password_hash em produção

$stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE id = :id");
$stmt->execute([
    "senha" => $hash,
    "id" => $id
]);

// Redireciona de volta
header("Location: gerenciar.php?msg=Senha do usuário '{$user["nome"]}' foi resetada para '{$novaSenha}'");
exit;
