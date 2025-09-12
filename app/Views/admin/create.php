<div class="container py-4">
  <h1>Novo Usuário</h1>
  <?php include __DIR__.'/../partials/flash.php'; ?>
  <form method="POST" action="<?= BASE_URL ?>/admin/store">
    <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
    <div class="mb-3">
      <label class="form-label">Nome</label>
      <input name="nome" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input name="email" type="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label class="form-label">Senha</label>
      <input name="senha" type="password" class="form-control" required minlength="6">
    </div>
    <div class="mb-3">
      <label class="form-label">Tipo</label>
      <select name="tipo" class="form-select">
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
    </div>
    <button class="btn btn-success">Salvar</button>
    <a href="<?= BASE_URL ?>/admin" class="btn btn-secondary">Voltar</a>
  </form>
</div>
