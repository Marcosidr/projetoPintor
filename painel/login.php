<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - Painel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">
  <div class="card shadow p-4" style="width: 350px;">
    <h4 class="text-center mb-3">Login</h4>

    <?php if (!empty($_SESSION["erro"])): ?>
      <div class="alert alert-danger"><?= $_SESSION["erro"]; unset($_SESSION["erro"]); ?></div>
    <?php endif; ?>

    <?php if (!empty($_SESSION["sucesso"])): ?>
      <div class="alert alert-success"><?= $_SESSION["sucesso"]; unset($_SESSION["sucesso"]); ?></div>
    <?php endif; ?>

    <form action="../bin/autenticar.php" method="POST">
      <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label>Senha</label>
        <input type="password" class="form-control" name="senha" required>
      </div>
      <button type="submit" class="btn btn-success w-100">Entrar</button>
    </form>
    <p class="text-center mt-3">Não tem conta? <a href="register.php">Cadastrar</a></p>
  </div>
</body>
</html>
