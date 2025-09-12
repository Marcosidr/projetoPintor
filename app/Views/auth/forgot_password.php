<?php if(!function_exists('csrf_field')) { function csrf_field(): string { return '<input type="hidden" name="_csrf" value="'.htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8').'">'; }} ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Esqueci a Senha</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height:100vh;">
<div class="container" style="max-width:480px;">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="mb-3">Recuperar Senha</h4>
      <?php if(!empty($msg)): ?><div class="alert alert-info py-2"><?= htmlspecialchars($msg) ?></div><?php endif; ?>
      <form method="POST" action="<?= BASE_URL ?>/forgot-password">
        <?= csrf_field() ?>
        <div class="mb-3">
          <label class="form-label">E-mail</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Enviar Link</button>
      </form>
      <div class="mt-3 text-center">
        <a href="<?= BASE_URL ?>/login">Voltar ao login</a>
      </div>
    </div>
  </div>
</div>
</body>
</html>
