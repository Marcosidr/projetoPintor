<?php
session_start();
require_once __DIR__ . "/../bin/config.php";
header("Content-Type: application/json; charset=utf-8");

// Segurança
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    echo json_encode(["status"=>"error","msg"=>"Acesso negado"]); exit;
}

$method = $_SERVER["REQUEST_METHOD"];

if ($method === "GET") {
    $id = intval($_GET["id"] ?? 0);
    if ($id <= 0) { echo json_encode(["status"=>"error","msg"=>"ID inválido"]); exit; }

    $stmt = $pdo->prepare("SELECT id, nome, email, tipo FROM usuarios WHERE id = :id LIMIT 1");
    $stmt->execute(["id"=>$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$user) { echo json_encode(["status"=>"error","msg"=>"Usuário não encontrado"]); exit; }

    echo json_encode($user); exit;
}

if ($method === "POST") {
    $id    = intval($_POST["id"] ?? 0);
    $nome  = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $tipo  = $_POST["tipo"] ?? "cliente";

    if ($id<=0 || $nome==="" || $email==="") {
        echo json_encode(["status"=>"error","msg"=>"Dados inválidos"]); exit;
    }

    $stmt = $pdo->prepare("UPDATE usuarios SET nome = :n, email = :e, tipo = :t WHERE id = :id");
    $stmt->execute(["n"=>$nome, "e"=>$email, "t"=>$tipo, "id"=>$id]);

    echo json_encode(["status"=>"success","msg"=>"Usuário atualizado com sucesso"]); exit;
}

echo json_encode(["status"=>"error","msg"=>"Método não suportado"]);
