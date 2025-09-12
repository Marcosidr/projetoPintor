<?php if(!function_exists('csrf_field')) { function csrf_field(): string { return '<input type="hidden" name="_csrf" value="'.htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8').'">'; }} ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Redefinir Senha</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
<div class="container" style="max-width:480px;">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">Redefinir Senha</h4>
      <?php if(!empty($erro)): ?><div class="alert alert-danger py-2"><?= htmlspecialchars($erro) ?></div><?php endif; ?>
      <form method="POST" action="<?= BASE_URL ?>/reset-password">
        <?= csrf_field() ?>
        <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
        <div class="mb-3">
          <label class="form-label">Nova Senha</label>
          <input type="password" name="senha" minlength="6" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirmar Nova Senha</label>
          <input type="password" name="senha_confirmation" minlength="6" class="form-control" required>
        </div>
        <button class="btn btn-success w-100" type="submit">Salvar Nova Senha</button>
      </form>
      <div class="mt-3 text-center">
        <a href="<?= BASE_URL ?>/login">Voltar ao login</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
