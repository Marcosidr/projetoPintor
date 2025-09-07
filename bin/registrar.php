<?php
session_start();
require_once __DIR__ . "/config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";
    $tipo = "cliente"; // padrão é cliente

    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION["erro"] = "Preencha todos os campos.";
        header("Location: ../painel/register.php");
        exit;
    }

    try {
        $sql = "SELECT id FROM usuarios WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["email" => $email]);

        if ($stmt->rowCount() > 0) {
            $_SESSION["erro"] = "E-mail já está cadastrado.";
            header("Location: ../painel/register.php");
            exit;
        }

        $sql = "INSERT INTO usuarios (nome, email, senha, tipo, criado_em) 
                VALUES (:nome, :email, :senha, :tipo, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "nome" => $nome,
            "email" => $email,
            "senha" => md5($senha),
            "tipo" => $tipo
        ]);

        $_SESSION["sucesso"] = "Cadastro realizado! Faça login.";
        header("Location: ../painel/login.php");
        exit;
    } catch (Exception $e) {
        $_SESSION["erro"] = "Erro: " . $e->getMessage();
        header("Location: ../painel/register.php");
        exit;
    }
}
