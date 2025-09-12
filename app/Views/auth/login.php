<?php
use App\Core\Session; use App\Core\Csrf;
if (!function_exists('csrf_field')) {
  function csrf_field(): string { return '<input type="hidden" name="_csrf" value="'.htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8').'">'; }
}
// Variáveis $erro e $sucesso são fornecidas pelo controller.
?>
<div class="d-flex align-items-center justify-content-center vh-100 bg-light">
  <div class="card shadow-lg p-4 border-0 rounded-4" style="width: 380px;">
    <div class="text-center mb-4">
      <i class="bi bi-person-circle text-success" style="font-size: 3rem;"></i>
      <h4 class="mt-2">Login</h4>
      <p class="text-muted small">Acesse seu painel</p>
    </div>

    <?php if (!empty($erro)): ?>
      <div class="alert alert-danger d-flex align-items-center">
        <i class="bi bi-x-circle-fill me-2"></i> <?= htmlspecialchars($erro) ?>
      </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)): ?>
      <div class="alert alert-success d-flex align-items-center">
        <i class="bi bi-check-circle-fill me-2"></i> <?= htmlspecialchars($sucesso) ?>
      </div>
    <?php endif; ?>

  <form action="<?= BASE_URL ?>/login" method="POST" novalidate>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-envelope"></i></span>
          <input type="email" class="form-control" name="email" required autocomplete="username">
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Senha</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" class="form-control" name="senha" required autocomplete="current-password">
        </div>
      </div>
      <?= csrf_field(); ?>
      <button type="submit" class="btn btn-success w-100 rounded-pill">Entrar</button>
    </form>

    <p class="text-center mt-3 small">Não tem conta? <a href="<?= BASE_URL ?>/register">Cadastrar</a></p>
  </div>
</div>