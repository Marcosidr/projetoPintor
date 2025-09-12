<?php
use App\Core\Session; use App\Core\Csrf;
if (!function_exists('csrf_field')) {
  function csrf_field(): string { return '<input type="hidden" name="_csrf" value="'.htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8').'">'; }
}
$erro = Session::get('erro');
$sucesso = Session::get('sucesso');
Session::remove('erro');
Session::remove('sucesso');
?>

<div class="d-flex align-items-center justify-content-center vh-100 bg-light">
  <div class="card shadow p-4 rounded-4" style="width: 380px;">
    <h4 class="text-center mb-3">Registrar</h4>

    <?php if (!empty($erro)): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
      <div class="alert alert-success"><?= htmlspecialchars($sucesso) ?></div>
    <?php endif; ?>

  <form action="<?= BASE_URL ?>/register" method="POST" novalidate>
      <div class="mb-3">
        <label>Nome</label>
        <input type="text" class="form-control" name="nome" required>
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" class="form-control" name="email" required>
      </div>
      <div class="mb-3">
        <label>Senha</label>
        <input type="password" class="form-control" name="senha" required>
      </div>
      <?= csrf_field(); ?>
      <button type="submit" class="btn btn-success w-100">Cadastrar</button>
    </form>
    <p class="text-center mt-3 small">Já tem conta? <a href="<?= BASE_URL ?>/login">Entrar</a></p>
  </div>
</div>