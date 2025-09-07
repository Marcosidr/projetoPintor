<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    header("Location: ../painel/login.php");
    exit;
}

// Se houver exclusão
if (isset($_GET["excluir"])) {
    $id = intval($_GET["excluir"]);

    // Impede excluir a si mesmo
    if ($id !== $_SESSION["usuario"]["id"]) {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute(["id" => $id]);
        header("Location: gerenciar.php?msg=Usuário excluído com sucesso!");
        exit;
    } else {
        header("Location: gerenciar.php?msg=Você não pode excluir sua própria conta!");
        exit;
    }
}

// Busca todos os usuários
$stmt = $pdo->query("SELECT id, nome, email, tipo, criado_em FROM usuarios ORDER BY id ASC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-4">
    <h3>Gerenciamento - Admin</h3>
    <p>Aqui você poderá criar, editar, excluir ou resetar senha dos usuários.</p>

    <?php if (!empty($_GET["msg"])): ?>
      <div class="alert alert-info"><?= htmlspecialchars($_GET["msg"]) ?></div>
    <?php endif; ?>

    <a href="../painel/dashboard.php" class="btn btn-secondary mb-3">Voltar</a>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nome</th>
          <th>Email</th>
          <th>Tipo</th>
          <th>Criado em</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($usuarios as $u): ?>
          <tr>
            <td><?= $u["id"] ?></td>
            <td><?= htmlspecialchars($u["nome"]) ?></td>
            <td><?= htmlspecialchars($u["email"]) ?></td>
            <td><?= $u["tipo"] ?></td>
            <td><?= $u["criado_em"] ?></td>
            <td>
              <a href="editar.php?id=<?= $u["id"] ?>" class="btn btn-sm btn-warning">Editar</a>
              <?php if ($u["id"] !== $_SESSION["usuario"]["id"]): ?>
                <a href="gerenciar.php?excluir=<?= $u["id"] ?>" 
                   onclick="return confirm('Tem certeza que deseja excluir este usuário?')" 
                   class="btn btn-sm btn-danger">Excluir</a>
                <a href="resetar.php?id=<?= $u["id"] ?>" 
                   onclick="return confirm('Deseja realmente resetar a senha deste usuário?')" 
                   class="btn btn-sm btn-info">Resetar Senha</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
