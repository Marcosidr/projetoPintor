<div class="container my-5">
  <h1 class="mb-4">Gerenciar Catálogos</h1>

  <?php if (!empty($_SESSION['flash_error'])): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['flash_error']); unset($_SESSION['flash_error']); ?></div>
  <?php endif; ?>
  <?php if (!empty($_SESSION['flash_success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['flash_success']); unset($_SESSION['flash_success']); ?></div>
  <?php endif; ?>

  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <form method="post" action="<?= BASE_URL ?>/admin/catalogos" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8') ?>">
        <div class="col-md-6">
          <label class="form-label">Título</label>
          <input type="text" name="titulo" maxlength="160" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Arquivo (PDF/JPG/PNG)</label>
          <input type="file" name="arquivo" accept=".pdf,.png,.jpg,.jpeg" class="form-control" required>
        </div>
        <div class="col-12 text-end">
          <button class="btn btn-success px-4">Enviar</button>
        </div>
      </form>
    </div>
  </div>

  <table class="table table-sm table-striped align-middle shadow-sm">
    <thead class="table-light">
      <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Arquivo</th>
        <th>Criado em</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($itens)): ?>
        <tr><td colspan="5" class="text-center text-muted">Nenhum catálogo cadastrado.</td></tr>
      <?php else: ?>
        <?php foreach ($itens as $item): ?>
          <tr>
            <td><?= (int)$item['id'] ?></td>
            <td><?= htmlspecialchars($item['titulo']) ?></td>
            <td><a target="_blank" href="<?= BASE_URL . '/uploads/catalogo/' . rawurlencode($item['arquivo']) ?>">Abrir</a></td>
            <td><?= htmlspecialchars($item['created_at']) ?></td>
            <td class="text-end">
              <form method="post" action="<?= BASE_URL . '/admin/catalogos/delete/' . (int)$item['id'] ?>" onsubmit="return confirm('Remover este item?')">
                <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8') ?>">
                <button class="btn btn-sm btn-outline-danger">Excluir</button>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</div>
