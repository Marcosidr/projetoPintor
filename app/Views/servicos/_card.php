<?php
// Partial de cartão de serviço. Variável esperada: $servico (array associativo vindo do banco)
$icone = $servico['icone'] ?? '';
$titulo = $servico['titulo'] ?? '';
$descricao = $servico['descricao'] ?? '';
$caracteristicas = $servico['caracteristicas'] ?? [];
?>
<div class="card mb-4 flex-fill shadow-sm h-100">
  <div class="card-body d-flex flex-column">
    <h3 class="card-title h5"><i class="<?= htmlspecialchars($icone) ?> me-2"></i><?= htmlspecialchars($titulo) ?></h3>
    <p class="card-text small flex-grow-1 mb-3 text-muted"><?= htmlspecialchars($descricao) ?></p>
    <?php if (!empty($caracteristicas)): ?>
      <ul class="list-unstyled small mb-0">
        <?php foreach ($caracteristicas as $item): ?>
          <li class="mb-1"><i class='bi bi-check-circle-fill text-success me-2'></i><?= htmlspecialchars($item) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </div>
</div>