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
            $mail->Password = 'zgwu wfpq ngfg nqvf'; // Troque por sua senha real de app
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
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Validação em tempo real com Bootstrap -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form-contato');
    const nome = document.getElementById('nome');
    const email = document.getElementById('email');
    const mensagem = document.getElementById('mensagem');

    const nomeValido = /^[A-Za-zÀ-ÿ\s]{3,}$/;
    const emailValido = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    function exibirErro(campo, mensagem) {
        campo.classList.add('is-invalid');
        if (!campo.nextElementSibling || !campo.nextElementSibling.classList.contains('invalid-feedback')) {
            const erro = document.createElement('div');
            erro.className = 'invalid-feedback';
            erro.innerText = mensagem;
            campo.parentNode.appendChild(erro);
        }
    }

    function removerErro(campo) {
        campo.classList.remove('is-invalid');
        const proximo = campo.nextElementSibling;
        if (proximo && proximo.classList.contains('invalid-feedback')) {
            proximo.remove();
        }
    }

    nome.addEventListener('input', function () {
        if (!nomeValido.test(nome.value.trim())) {
            exibirErro(nome, 'O nome deve ter pelo menos 3 letras e conter apenas letras e espaços.');
        } else {
            removerErro(nome);
        }
    });

    email.addEventListener('input', function () {
        if (!emailValido.test(email.value.trim())) {
            exibirErro(email, 'Por favor, insira um e-mail válido.');
        } else {
            removerErro(email);
        }
    });

    mensagem.addEventListener('input', function () {
        if (mensagem.value.trim().length < 10) {
            exibirErro(mensagem, 'A mensagem deve ter pelo menos 10 caracteres.');
        } else {
            removerErro(mensagem);
        }
    });

    form.addEventListener('submit', function (e) {
        if (!nomeValido.test(nome.value.trim())) {
            exibirErro(nome, 'O nome deve ter pelo menos 3 letras e conter apenas letras e espaços.');
            e.preventDefault();
        }

        if (!emailValido.test(email.value.trim())) {
            exibirErro(email, 'Por favor, insira um e-mail válido.');
            e.preventDefault();
        }

        if (mensagem.value.trim().length < 10) {
            exibirErro(mensagem, 'A mensagem deve ter pelo menos 10 caracteres.');
            e.preventDefault();
        }
    });
});
</script>
