<?php
session_start();
if (empty($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION["usuario"];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-4">
    <h3>Bem-vindo, <?= htmlspecialchars($user["nome"]) ?>!</h3>
    <p><strong>Tipo de conta:</strong> <?= $user["tipo"] ?></p>

    <?php if ($user["tipo"] === "admin"): ?>
      <a href="../admin/gerenciar.php" class="btn btn-warning">Área Administrativa</a>
    <?php endif; ?>

    <a href="logout.php" class="btn btn-danger">Sair</a>
  </div>
</body>
</html>
