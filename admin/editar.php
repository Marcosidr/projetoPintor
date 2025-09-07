<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

// Bloqueia acesso se não for admin
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    header("Location: ../painel/login.php");
    exit;
}

$id = intval($_GET["id"] ?? 0);

// Buscar usuário
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
$stmt->execute(["id" => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Usuário não encontrado!");
}

// Atualizar usuário
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $tipo = $_POST["tipo"] ?? "cliente";

    $sql = "UPDATE usuarios SET nome = :nome, email = :email, tipo = :tipo WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        "nome" => $nome,
        "email" => $email,
        "tipo" => $tipo,
        "id" => $id
    ]);

    header("Location: gerenciar.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Usuário</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
  <h3>Editar Usuário</h3>
  <a href="gerenciar.php" class="btn btn-secondary mb-3">⬅ Voltar</a>

  <form method="POST">
    <div class="mb-3">
      <label>Nome</label>
      <input type="text" class="form-control" name="nome" value="<?= htmlspecialchars($user["nome"]) ?>" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user["email"]) ?>" required>
    </div>
    <div class="mb-3">
      <label>Tipo</label>
      <select class="form-select" name="tipo">
        <option value="cliente" <?= $user["tipo"] === "cliente" ? "selected" : "" ?>>Cliente</option>
        <option value="admin" <?= $user["tipo"] === "admin" ? "selected" : "" ?>>Admin</option>
      </select>
    </div>
    <button type="submit" class="btn btn-success">Salvar</button>
  </form>
</div>
</body>
</html>
