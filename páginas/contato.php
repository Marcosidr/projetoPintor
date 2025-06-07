<?php
// Parâmetro da URL para controle de página
$param = $_GET["param"] ?? "home";
$pagina = "páginas/{$param}.php";

// Processar envio do formulário
$mensagemEnviada = false;
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    // Validações básicas no backend (duplicando a validação JS)
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || 
              strpos($email, '@') === false || 
              strpos($email, '.com') === false) {
        $erro = "Por favor, insira um e-mail válido contendo '@' e '.com'.";
    } else {
        $mensagemEnviada = true;
     
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Contato - CLPinturas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/contato.css" />
</head>
<body>

  <div class="container mt-5">
    <h2 class="text-center mb-4">Fale Conosco</h2>

    <?php if ($mensagemEnviada): ?>
        <div class="alert alert-success text-center" role="alert">
            Obrigado pelo contato! Em breve responderemos.
        </div>
    <?php else: ?>
        <?php if ($erro): ?>
            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form id="form-contato" method="POST" action="">
          <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input 
              type="text" 
              class="form-control" 
              id="nome" 
              name="nome" 
              required
              value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
            >
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input 
              type="email" 
              class="form-control" 
              id="email" 
              name="email" 
              required
              value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            >
          </div>
          <div class="mb-3">
            <label for="mensagem" class="form-label">Mensagem</label>
            <textarea 
              class="form-control" 
              id="mensagem" 
              name="mensagem" 
              rows="5" 
              required
            ><?= htmlspecialchars($_POST['mensagem'] ?? '') ?></textarea>
          </div>
          <button type="submit" class="btn btn-success">Enviar</button>
        </form>
    <?php endif; ?>
  </div>

  <!-- Modal de Orçamento -->
  <?php include 'páginas/modal-orcamento.php'; ?>

  <!-- Scripts Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Validação extra com JS -->
  <script>
    document.getElementById('form-contato').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value.trim();
      if (!email.includes('@') || !email.includes('.com')) {
        e.preventDefault();
        alert("Por favor, insira um e-mail válido contendo '@' e '.com'.");
      }
    });
  </script>

</body>
</html>
