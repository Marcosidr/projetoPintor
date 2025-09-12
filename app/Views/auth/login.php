<?php
session_start();
$erro     = $_SESSION["erro"]     ?? null;
$sucesso  = $_SESSION["sucesso"]  ?? null;
unset($_SESSION["erro"], $_SESSION["sucesso"]);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login - Painel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

  <div class="card shadow-lg p-4 border-0 rounded-4 animate__animated animate__fadeIn" style="width: 380px;">
    <div class="text-center mb-4">
      <i class="bi bi-person-circle text-success" style="font-size: 3rem;"></i>
      <h4 class="mt-2">Login</h4>
      <p class="text-muted small">Acesse seu painel</p>
    </div>

    <?php if ($erro): ?>
      <div class="alert alert-danger d-flex align-items-center">
        <i class="bi bi-x-circle-fill me-2"></i> <?= $erro ?>
      </div>
    <?php endif; ?>

    <?php if ($sucesso): ?>
      <div class="alert alert-success d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i> <?= $sucesso ?>
      </div>
    <?php endif; ?>

    <form action="../bin/autenticar.php" method="POST">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control" name="email" autocomplete="username" required>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" name="senha" autocomplete="current-password" required>
        </div>
      </div>
      <button type="submit" class="btn btn-success w-100 rounded-pill">Entrar</button>
    </form>
    
    <p class="text-center mt-3 small">Não tem conta? <a href="register.php">Cadastrar</a></p>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
