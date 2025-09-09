<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

// Proteção
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    die("Acesso negado!");
}

// Puxa lista de usuários
$stmt = $pdo->query("SELECT id, nome, email, tipo FROM usuarios ORDER BY id DESC");
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Gerenciar Usuários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="p-4">

  <h2>Gerenciar Usuários</h2>

  <!-- Botão adicionar -->
  <button id="btnAdicionar" class="btn btn-success mb-3">+ Adicionar Usuário</button>

  <!-- Tabela -->
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>Nome</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $u): ?>
        <tr>
          <td><?= $u["id"] ?></td>
          <td><?= htmlspecialchars($u["nome"]) ?></td>
          <td><?= htmlspecialchars($u["email"]) ?></td>
          <td><?= ucfirst($u["tipo"]) ?></td>
          <td>
            <button class="btn btn-primary btn-sm btnEditar" data-id="<?= $u["id"] ?>">Editar</button>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Adicionar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="formUsuario">
            <input type="hidden" id="idUsuario" name="id">

            <div class="mb-3">
              <label>Nome</label>
              <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Email</label>
              <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label>Tipo</label>
              <select id="tipo" name="tipo" class="form-control">
                <option value="admin">Admin</option>
                <option value="cliente">Cliente</option>
              </select>
            </div>

            <div class="mb-3">
              <label>Senha</label>
              <input type="password" id="senha" name="senha" class="form-control">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnSalvar" class="btn btn-primary">Salvar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

<script>
$(document).ready(function() {

    // Abre modal no modo "Adicionar"
    $("#btnAdicionar").on("click", function() {
        $("#formUsuario")[0].reset();
        $("#idUsuario").val("");
        $("#modalUsuario .modal-title").text("Adicionar Usuário");
        $("#modalUsuario").modal("show");
    });

    // Abre modal no modo "Editar"
    $(document).on("click", ".btnEditar", function() {
        let id = $(this).data("id");

        $.get("adicionar_user.php", { id: id }, function(res) {
            if (res.status === "error") {
                alert(res.msg);
                return;
            }

            $("#formUsuario")[0].reset();
            $("#idUsuario").val(res.id);
            $("#nome").val(res.nome);
            $("#email").val(res.email);
            $("#tipo").val(res.tipo);
            $("#senha").val("");
            $("#modalUsuario .modal-title").text("Editar Usuário");
            $("#modalUsuario").modal("show");
        }, "json");
    });

    // Salvar (Adicionar ou Editar)
    $("#btnSalvar").on("click", function() {
        let dados = $("#formUsuario").serialize();

        $.post("adicionar_user.php", dados, function(res) {
            if (res.status === "success") {
                alert(res.msg);
                $("#modalUsuario").modal("hide");
                location.reload();
            } else {
                alert("Erro: " + res.msg);
            }
        }, "json")
        .fail(function(xhr, status, error) {
            alert("Falha na requisição: " + error);
        });
    });

});
</script>

</body>
</html>
