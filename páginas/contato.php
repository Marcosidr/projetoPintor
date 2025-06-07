<?php
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
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // filter_var já valida '@' e '.'
        $erro = "Por favor, insira um e-mail válido.";
    } else {
        // Aqui você faria o envio do e-mail ou salvaria no banco de dados
        // Exemplo: mail("seuemail@dominio.com", "Nova mensagem do site", $mensagem . "\nDe: " . $nome . " (" . $email . ")");
        $mensagemEnviada = true;
    }
}

// Define o título da página, se necessário para o <title> no index.php
// Se você quiser que o <title> seja dinâmico, passe essa variável para o header no index.php
// Neste caso, seu index.php já tem um <title> fixo, então esta linha é mais para clareza
$pageTitle = "Contato - CLPinturas";

// Como o header e o footer estão no index.php, não precisamos incluí-los aqui.
// Apenas o conteúdo da página vai dentro da tag <main> do index.php.
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

                <div class="contact-info text-center mt-5">
                    <h3 class="mb-4 text-paint-green-700">Ou entre em contato diretamente:</h3>
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card p-3 shadow-sm h-100 hover-scale">
                                <i class="fas fa-phone-alt fa-2x text-paint-green-600 mb-3"></i>
                                <h4>Telefone</h4>
                                <p>(44) 99800-8156</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card p-3 shadow-sm h-100 hover-scale">
                                <i class="fas fa-envelope fa-2x text-paint-green-600 mb-3"></i>
                                <h4>E-mail</h4>
                                <p>clpinturas@email.com</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card p-3 shadow-sm h-100 hover-scale">
                                <i class="fas fa-map-marker-alt fa-2x text-paint-green-600 mb-3"></i>
                                <h4>Endereço</h4>
                                <p>Rua Belo Horizonte, 3 - Boa Esperança, Paraná</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="mb-3 text-paint-green-700">Siga-nos nas Redes Sociais:</h3>
                        <a href="#" class="btn btn-outline-success btn-social mx-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="btn btn-outline-success btn-social mx-2"><i class="fab fa-instagram"></i></a>
                        <a href="https://api.whatsapp.com/send?phone=5544998008156" target="_blank" class="btn btn-outline-success btn-social mx-2"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

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

                // Basic validation: check for '@' and at least one '.' after '@'
                if (!email.includes('@') || email.indexOf('.', email.indexOf('@')) === -1) {
                    e.preventDefault();
                    alert("Por favor, insira um e-mail válido.");
                    emailField.focus();
                }
            });
        }
    });
</script>