<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . "/../bin/config.php";
require_once __DIR__ . "/../classes/Logger.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome  = trim($_POST["nome"] ?? "");
    $email = strtolower(trim($_POST["email"] ?? ""));
    $senha = $_POST["senha"] ?? "";

    if (empty($nome) || empty($email) || empty($senha)) {
        $_SESSION["erro"] = "Preencha todos os campos.";
        header("Location: register.php");
        exit;
    }

    if (strlen($senha) < 6) {
        $_SESSION["erro"] = "A senha deve ter pelo menos 6 caracteres.";
        header("Location: register.php");
        exit;
    }

    try {
        // Verifica se email já existe
        $check = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email LIMIT 1");
        $check->execute(["email" => $email]);

        if ($check->rowCount() > 0) {
            $_SESSION["erro"] = "Este e-mail já está registrado.";
            Logger::registrar("REGISTRO FALHOU (E-MAIL EXISTE): {$email}", "register.php", "WARNING");
            header("Location: register.php");
            exit;
        }

        // Cria hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Insere no banco
        $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (:nome, :email, :senha, 'user')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "nome"  => $nome,
            "email" => $email,
            "senha" => $senhaHash
        ]);

        Logger::registrar("REGISTRO OK: {$email}", "register.php", "INFO");
        Logger::registrar("REGISTRO FALHOU: {$email}", "register.php", "WARNING");
        Logger::registrar("ERRO REGISTRO: {$e->getMessage()}", "register.php", "ERRO");

        $_SESSION["sucesso"] = "Usuário registrado com sucesso!";
        header("Location: login.php");
        exit;

    } catch (Exception $e) {
        $_SESSION["erro"] = "Erro: " . $e->getMessage();
        Logger::registrar("REGISTRO ERRO: {$email} - {$e->getMessage()}", "register.php", "ERROR");
        header("Location: register.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Registrar - Painel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow p-4" style="width: 350px;">
    <h4 class="text-center mb-3">Registrar</h4>

    <?php if (!empty($_SESSION["erro"])): ?>
      <div class="alert alert-danger"><?= $_SESSION["erro"]; unset($_SESSION["erro"]); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION["sucesso"])): ?>
      <div class="alert alert-success"><?= $_SESSION["sucesso"]; unset($_SESSION["sucesso"]); ?></div>
    <?php endif; ?>

    <form action="register.php" method="POST">
      <div class="mb-3">
        <label>Nome</label>
        <input type="text" class="form-control" name="nome" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label>Senha</label>
        <input type="password" class="form-control" name="senha" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>
    <p class="text-center mt-3">Já tem conta? <a href="login.php">Entrar</a></p>
  </div>
</body>
</html>
