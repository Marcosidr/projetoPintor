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
        <th class="text-end">Ações</th>
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
              <button type="button" class="btn btn-sm btn-outline-primary me-1 btn-edit-catalogo"
                      data-id="<?= (int)$item['id'] ?>"
                      data-titulo="<?= htmlspecialchars($item['titulo'], ENT_QUOTES,'UTF-8') ?>"
                      data-arquivo="<?= htmlspecialchars($item['arquivo'], ENT_QUOTES,'UTF-8') ?>"
                      data-bs-toggle="modal" data-bs-target="#modalEditarCatalogo">Editar</button>
              <form method="post" action="<?= BASE_URL . '/admin/catalogos/delete/' . (int)$item['id'] ?>" onsubmit="return confirm('Remover este item?')" class="d-inline">
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

<!-- Modal Editar Catálogo -->
<div class="modal fade" id="modalEditarCatalogo" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form method="post" id="formEditarCatalogo" action="#" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title">Editar Catálogo</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8') ?>">
          <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" id="editarTitulo" class="form-control" maxlength="160" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Substituir Arquivo (opcional)</label>
            <input type="file" name="arquivo" accept=".pdf,.png,.jpg,.jpeg" class="form-control">
            <div class="form-text" id="arquivoAtualInfo"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button class="btn btn-primary">Salvar Alterações</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  const form = document.getElementById('formEditarCatalogo');
  let baseUrl = '<?= BASE_URL ?>';
  document.querySelectorAll('.btn-edit-catalogo').forEach(btn => {
    btn.addEventListener('click', () => {
      const id = btn.getAttribute('data-id');
      const titulo = btn.getAttribute('data-titulo');
      const arquivo = btn.getAttribute('data-arquivo');
      form.action = baseUrl + '/admin/catalogos/update/' + id;
      form.querySelector('#editarTitulo').value = titulo;
      const info = form.querySelector('#arquivoAtualInfo');
      info.textContent = 'Arquivo atual: ' + arquivo;
    });
  });
});
</script>
