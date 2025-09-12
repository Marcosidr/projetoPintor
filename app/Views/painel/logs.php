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

    <!-- Filtros -->
    <form method="GET" class="row g-3 mb-4">
      <div class="col-md-3">
        <label class="form-label">Usuário</label>
        <input type="text" name="usuario" class="form-control" value="<?= htmlspecialchars($filtroUsuario ?? '') ?>">
      </div>
      <div class="col-md-3">
        <label class="form-label">Ação</label>
        <input type="text" name="acao" class="form-control" value="<?= htmlspecialchars($filtroAcao ?? '') ?>">
      </div>
      <div class="col-md-2">
        <label class="form-label">Nível</label>
        <select name="nivel" class="form-select">
          <option value="">Todos</option>
          <option value="INFO" <?= ($filtroNivel ?? '')=="INFO"?"selected":"" ?>>INFO</option>
          <option value="WARNING" <?= ($filtroNivel ?? '')=="WARNING"?"selected":"" ?>>WARNING</option>
          <option value="ERROR" <?= ($filtroNivel ?? '')=="ERROR"?"selected":"" ?>>ERROR</option>
        </select>
      </div>
      <div class="col-md-2">
        <label class="form-label">Data início</label>
        <input type="date" name="data_ini" class="form-control" value="<?= htmlspecialchars($filtroDataIni ?? '') ?>">
      </div>
      <div class="col-md-2">
        <label class="form-label">Data fim</label>
        <input type="date" name="data_fim" class="form-control" value="<?= htmlspecialchars($filtroDataFim ?? '') ?>">
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-success w-100">Filtrar</button>
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
                  <span class="badge 
                    <?= $log['nivel'] === 'ERROR' ? 'bg-danger' : ($log['nivel'] === 'WARNING' ? 'bg-warning text-dark' : 'bg-success') ?>">
                    <?= htmlspecialchars($log['nivel']) ?>
                  </span>
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
  </div>
</body>
</html>