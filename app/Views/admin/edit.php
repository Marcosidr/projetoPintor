<div class="container py-4">
  <h1>Editar Usuário #<?= htmlspecialchars($user['id']) ?></h1>
  <?php include __DIR__.'/../partials/flash.php'; ?>
  <form method="POST" action="<?= BASE_URL ?>/admin/update/<?= htmlspecialchars($user['id']) ?>">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
    <div class="mb-3">
      <label class="form-label">Nome</label>
      <input name="nome" class="form-control" value="<?= htmlspecialchars($user['nome']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input name="email" type="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Nova Senha (opcional)</label>
      <input name="senha" type="password" class="form-control" minlength="6">
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <select name="tipo" class="form-select">
        <option value="user" <?= $user['tipo']==='user'? 'selected':'' ?>>User</option>
        <option value="admin" <?= $user['tipo']==='admin'? 'selected':'' ?>>Admin</option>
      </select>
    </div>
    <button class="btn btn-primary">Atualizar</button>
    <a href="<?= BASE_URL ?>/admin" class="btn btn-secondary">Voltar</a>
  </form>
</div>
