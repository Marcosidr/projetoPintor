<?php
// Inclui o autoload do Composer para carregar o PHPMailer
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Processar envio do formulário
$mensagemEnviada = false;
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');

    // Validações básicas
    if (empty($nome) || empty($email) || empty($mensagem)) {
        $erro = "Por favor, preencha todos os campos.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = "Por favor, insira um e-mail válido.";
    } else {
        // Monta o corpo da mensagem
        $corpo = "Você recebeu uma nova mensagem pelo formulário de contato.\n\n";
        $corpo .= "Nome: $nome\n";
        $corpo .= "E-mail: $email\n";
        $corpo .= "Mensagem:\n$mensagem\n";

        // Configura e envia com PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configurações SMTP (exemplo Gmail)
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';              // SMTP do Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'marcosincio556@gmail.com';
            $mail->Password = 'zgwu wfpq ngfg nqvf'; 
              
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom('marcosincio556@gmail.com', 'CLPinturas');
            $mail->addAddress('marcosincio556@gmail.com', 'Marcos'); // Destinatário

            // Conteúdo da mensagem
            $mail->isHTML(false);
            $mail->Subject = "Nova mensagem do site CLPinturas";
            $mail->Body = $corpo;

            // Enviar e-mail
            $mail->send();
            $mensagemEnviada = true;
        } catch (Exception $e) {
            $erro = "Erro ao enviar a mensagem: " . $mail->ErrorInfo;
        }
    }
}

// Aqui começa seu HTML do formulário e conteúdo (sem alteração)
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
                        <input 
                            type="text" 
                            class="form-control" 
                            id="nome" 
                            name="nome" 
                            placeholder="Seu nome completo"
                            required
                            value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">E-mail:</label>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            placeholder="seuemail@exemplo.com"
                            required
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                        >
                    </div>
                    <div class="mb-4">
                        <label for="mensagem" class="form-label fw-bold">Mensagem:</label>
                        <textarea 
                            class="form-control" 
                            id="mensagem" 
                            name="mensagem" 
                            rows="7" 
                            placeholder="Descreva seu projeto ou dúvida..."
                            required
                        ><?= htmlspecialchars($_POST['mensagem'] ?? '') ?></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-paper-plane me-2"></i> Enviar Mensagem
                        </button>
                    </div>
                </form>

                <!-- Resto do seu HTML permanece igual -->

            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const formContato = document.getElementById('form-contato');

    if (formContato) {
        formContato.addEventListener('submit', function(e) {
            const emailField = document.getElementById('email');
            const email = emailField.value.trim();

            if (!email.includes('@') || email.indexOf('.', email.indexOf('@')) === -1) {
                e.preventDefault();
                alert("Por favor, insira um e-mail válido.");
                emailField.focus();
            }
        });
    }
});
</script>
