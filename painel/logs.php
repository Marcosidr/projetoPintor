<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

// Se quiser restringir só para admin
if ($_SESSION["usuario"]["tipo"] !== "admin") {
    die("Acesso negado!");
}

// Filtros
$filtroUsuario = $_GET["usuario_id"] ?? "";
$filtroAcao    = $_GET["acao"] ?? "";
$filtroDataIni = $_GET["data_ini"] ?? "";
$filtroDataFim = $_GET["data_fim"] ?? "";

// Monta SQL
$sql = "SELECT l.*, u.nome AS usuario_nome 
        FROM logs l
        LEFT JOIN usuarios u ON u.id = l.usuario_id
        WHERE 1=1";

$params = [];

if (!empty($filtroUsuario)) {
    $sql .= " AND l.usuario_id = :usuario_id";
    $params["usuario_id"] = $filtroUsuario;
}

if (!empty($filtroAcao)) {
    $sql .= " AND l.acao LIKE :acao";
    $params["acao"] = "%" . $filtroAcao . "%";
}

if (!empty($filtroDataIni)) {
    $sql .= " AND DATE(l.criado_em) >= :data_ini";
    $params["data_ini"] = $filtroDataIni;
}

if (!empty($filtroDataFim)) {
    $sql .= " AND DATE(l.criado_em) <= :data_fim";
    $params["data_fim"] = $filtroDataFim;
}

$sql .= " ORDER BY l.criado_em DESC LIMIT 200";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Pega todos usuários para filtro
$usuarios = $pdo->query("SELECT id, nome FROM usuarios ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Logs do Sistema</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-4">
    <h3 class="mb-4">📜 Logs do Sistema</h3>

    <!-- Formulário de filtros -->
    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <label class="form-label">Usuário</label>
        <select name="usuario_id" class="form-select">
          <option value="">Todos</option>
          <?php foreach ($usuarios as $u): ?>
            <option value="<?= $u["id"] ?>" <?= $filtroUsuario == $u["id"] ? "selected" : "" ?>>
              <?= htmlspecialchars($u["nome"]) ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-3">
        <label class="form-label">Ação</label>
        <input type="text" name="acao" class="form-control" value="<?= htmlspecialchars($filtroAcao) ?>">
      </div>

      <div class="col-md-2">
        <label class="form-label">Data início</label>
        <input type="date" name="data_ini" class="form-control" value="<?= htmlspecialchars($filtroDataIni) ?>">
      </div>

      <div class="col-md-2">
        <label class="form-label">Data fim</label>
        <input type="date" name="data_fim" class="form-control" value="<?= htmlspecialchars($filtroDataFim) ?>">
      </div>

      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Filtrar</button>
      </div>
    </form>

    <!-- Tabela de logs -->
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Usuário</th>
            <th>Ação</th>
            <th>Página</th>
            <th>IP</th>
            <th>Data/Hora</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($logs)): ?>
            <tr><td colspan="6" class="text-center">Nenhum log encontrado.</td></tr>
          <?php else: ?>
            <?php foreach ($logs as $log): ?>
              <tr>
                <td><?= $log["id"] ?></td>
                <td><?= $log["usuario_nome"] ?? "Visitante" ?></td>
                <td><?= htmlspecialchars($log["acao"]) ?></td>
                <td><?= htmlspecialchars($log["pagina"]) ?></td>
                <td><?= $log["ip"] ?></td>
                <td><?= $log["criado_em"] ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
