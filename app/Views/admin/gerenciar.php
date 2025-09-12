<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Usuários</h1>
    <a href="<?= BASE_URL ?>/admin/create" class="btn btn-success">Novo</a>
  </div>
  <?php include __DIR__.'/../partials/flash.php'; ?>
  <table class="table table-striped align-middle">
    <thead><tr><th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Ações</th></tr></thead>
    <tbody>
    <?php foreach(($users ?? []) as $u): ?>
      <tr>
        <td><?= htmlspecialchars($u['id']) ?></td>
        <td><?= htmlspecialchars($u['nome']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><span class="badge bg-<?= $u['tipo']==='admin'?'danger':'secondary' ?>"><?= htmlspecialchars($u['tipo']) ?></span></td>
        <td class="d-flex gap-1 flex-wrap">
          <a class="btn btn-sm btn-primary" href="<?= BASE_URL ?>/admin/edit/<?= $u['id'] ?>">Editar</a>
          <form method="POST" action="<?= BASE_URL ?>/admin/toggle-admin/<?= $u['id'] ?>" onsubmit="return confirm('Alterar privilégio?')">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
            <button class="btn btn-sm btn-warning">Toggle Admin</button>
          </form>
          <form method="POST" action="<?= BASE_URL ?>/admin/reset-senha/<?= $u['id'] ?>" onsubmit="return confirm('Resetar senha para reset123?')">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
            <button class="btn btn-sm btn-secondary">Reset Senha</button>
          </form>
          <form method="POST" action="<?= BASE_URL ?>/admin/destroy/<?= $u['id'] ?>" onsubmit="return confirm('Remover usuário?')">
            <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
            <button class="btn btn-sm btn-outline-danger">Excluir</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
