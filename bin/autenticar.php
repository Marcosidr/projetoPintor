<?php
session_start();
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/../classes/logger.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"] ?? "";
    $senha = $_POST["senha"] ?? "";

    if (empty($email) || empty($senha)) {
        $_SESSION["erro"] = "Preencha todos os campos.";
        Logger::registrar("LOGIN FALHOU - campos vazios", "WARNING", "autenticar.php");
        header("Location: ../painel/login.php");
        exit;
    }

    try {
        $sql = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(["email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($senha, $user["senha"])) {
            $_SESSION["usuario"] = [
                "id"    => $user["id"],
                "nome"  => $user["nome"],
                "email" => $user["email"],
                "tipo"  => $user["tipo"]
            ];
            Logger::registrar("LOGIN OK: {$user["email"]}", "INFO", "autenticar.php");
            header("Location: ../painel/dashboard.php");
            exit;
        } else {
            $_SESSION["erro"] = "E-mail ou senha inválidos.";
            Logger::registrar("LOGIN FALHOU: {$email}", "WARNING", "autenticar.php");
            header("Location: ../painel/login.php");
            exit;
        }
    } catch (Exception $e) {
        $_SESSION["erro"] = "Erro: " . $e->getMessage();
        Logger::registrar("ERRO LOGIN: {$e->getMessage()}", "ERROR", "autenticar.php");
        header("Location: ../painel/login.php");
        exit;
    }
}
