<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensagemEnviada = false;
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif (!preg_match("/^[\p{L} ]{3,}$/u", $nome)) {
        $erro = "O nome deve ter pelo menos 3 letras e conter apenas letras e espaços.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um e-mail válido.";
    } elseif (strlen($mensagem) < 10) {
        $erro = "A mensagem deve ter pelo menos 10 caracteres.";
    } else {
        $corpo = "Você recebeu uma nova mensagem pelo formulário de contato.\n\n";
        $corpo .= "Nome: $nome\n";
        $corpo .= "E-mail: $email\n";
        $corpo .= "Mensagem:\n$mensagem\n";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'marcosincio556@gmail.com';
            $mail->Password = 'zgwu wfpq ngfg nqvf';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('marcosincio556@gmail.com', 'CLPinturas');
            $mail->addAddress('marcosincio556@gmail.com', 'Marcos');

            $mail->isHTML(false);
            $mail->Subject = "Nova mensagem do site CLPinturas";
            $mail->Body = $corpo;

            $mail->send();
            $mensagemEnviada = true;
        } catch (Exception $e) {
            $erro = "Erro ao enviar a mensagem: " . $mail->ErrorInfo;
        }
    }
}
?>

<div class="container my-5">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <h1 class="text-center mb-5 display-4 fw-bold text-paint-green-700">Fale Conosco</h1>
      <p class="text-center mb-5 text-muted">Estamos prontos para te ajudar a transformar o seu ambiente! Preencha o formulário abaixo ou entre em contato pelos nossos canais.</p>

      <?php if ($mensagemEnviada): ?>
        <div class="alert alert-success text-center" role="alert">
          <i class="fas fa-check-circle me-2"></i> Obrigado pelo contato! Em breve responderemos.
        </div>
      <?php else: ?>
        <?php if ($erro): ?>
          <div class="alert alert-danger" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i> <?= htmlspecialchars($erro) ?>
          </div>
        <?php endif; ?>

        <form id="form-contato" method="POST" action="" class="p-4 border rounded shadow-sm bg-white">
          <div class="mb-3">
            <label for="nome" class="form-label fw-bold">Nome:</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Seu nome completo" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
            <div class="invalid-feedback">Nome com no mínimo 3 letras (somente letras e espaços).</div>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-bold">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="seuemail@exemplo.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            <div class="invalid-feedback">Insira um e-mail válido.</div>
          </div>

          <div class="mb-4">
            <label for="mensagem" class="form-label fw-bold">Mensagem:</label>
            <textarea class="form-control" id="mensagem" name="mensagem" rows="7" placeholder="Descreva seu projeto ou dúvida..." required><?= htmlspecialchars($_POST['mensagem'] ?? '') ?></textarea>
            <div class="invalid-feedback">A mensagem deve ter no mínimo 10 caracteres.</div>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-success btn-lg">
              <i class="fas fa-paper-plane me-2"></i> Enviar Mensagem
            </button>
          </div>
        </form>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('form-contato');
  const nome = document.getElementById('nome');
  const email = document.getElementById('email');
  const mensagem = document.getElementById('mensagem');

  const regexNome = /^[A-Za-zÀ-ÿ\s]{3,}$/;
  const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

  function validarCampo(campo, valido, mensagem) {
    if (!valido) {
      campo.classList.add('is-invalid');
    } else {
      campo.classList.remove('is-invalid');
    }
  }

  nome.addEventListener('input', () => validarCampo(nome, regexNome.test(nome.value.trim())));
  email.addEventListener('input', () => validarCampo(email, regexEmail.test(email.value.trim())));
  mensagem.addEventListener('input', () => validarCampo(mensagem, mensagem.value.trim().length >= 10));

  form.addEventListener('submit', function (e) {
    let valido = true;
    if (!regexNome.test(nome.value.trim())) { nome.classList.add('is-invalid'); valido = false; }
    if (!regexEmail.test(email.value.trim())) { email.classList.add('is-invalid'); valido = false; }
    if (mensagem.value.trim().length < 10) { mensagem.classList.add('is-invalid'); valido = false; }
    if (!valido) e.preventDefault();
  });
});
</script>
