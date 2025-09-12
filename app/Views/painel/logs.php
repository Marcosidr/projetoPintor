<?php
// filepath: c:\xampp\htdocs\projetoPintor\app\Views\painel\logs.php
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

    <!-- Filtros mínimos (ação, data) -->
    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label">Ação contém</label>
        <input type="text" name="acao" class="form-control" value="<?= htmlspecialchars($filtroAcao ?? '') ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Data</label>
        <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($filtroData ?? '') ?>">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-success w-100">Filtrar</button>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <a href="?" class="btn btn-outline-secondary w-100">Limpar</a>
      </div>
    </form>

    <!-- Tabela de logs -->
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-success">
          <tr>
            <th>Data/Hora</th>
            <th>Usuário</th>
            <th>Ação</th>
            <th>Nível</th>
            <th>Detalhes</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $log): ?>
              <tr>
                <td><?= htmlspecialchars($log['datahora']) ?></td>
                <td><?= htmlspecialchars($log['usuario']) ?></td>
                <td><?= htmlspecialchars($log['acao']) ?></td>
                <td>
                  <span class="badge bg-success">INFO</span>
                </td>
                <td><?= htmlspecialchars($log['detalhes']) ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center text-muted">Nenhum log encontrado.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Paginação -->
    <?php if (!empty($paginacao) && $paginacao['totalPages'] > 1): ?>
      <nav class="mt-4">
        <ul class="pagination">
          <?php for ($p=1; $p <= $paginacao['totalPages']; $p++): ?>
            <?php
              $qs = http_build_query([
                'acao' => $filtroAcao,
                'data' => $filtroData,
                'page' => $p,
              ]);
            ?>
            <li class="page-item <?= $paginacao['page']===$p?'active':'' ?>">
              <a class="page-link" href="?<?= $qs ?>"><?= $p ?></a>
            </li>
          <?php endfor; ?>
        </ul>
        <p class="text-muted small">Exibindo <?= count($logs) ?> de <?= $paginacao['total'] ?> registros (<?= $paginacao['totalPages'] ?> páginas)</p>
      </nav>
    <?php endif; ?>
  </div>
</body>
</html>