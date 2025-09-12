<?php
use App\Core\Env;

// Fragmento 404 - renderizado dentro do layout principal
if (!isset($error_code)) { $error_code = 404; }
switch((string)$error_code) {
    case '403': $error_message = 'Acesso proibido'; break;
    case '500': $error_message = 'Erro interno do servidor'; break;
    default:    $error_message = 'Página não encontrada';
}
?>
<style>
    .error-section { text-align:center; padding:80px 20px; }
    .error-section h1 { font-size:70px; color:#dc3545; }
    .error-section h2 { font-size:34px; color:#343a40; }
    .error-section p  { font-size:17px; color:#6c757d; }
    .btn-verde { background:#27652b; border:none; color:#fff; padding:12px 22px; border-radius:8px; text-decoration:none; display:inline-block; }
    .btn-verde:hover { background:#1e4f22; }
    .error-actions a + a { margin-left:15px; }
</style>
<section class="error-section">
    <div class="container">
        <div class="error-content">
            <h1>Erro <?= htmlspecialchars($error_code) ?></h1>
            <h2><?= htmlspecialchars($error_message) ?></h2>
            <p>Desculpe, a página solicitada não existe ou foi movida.</p>
            <div class="error-actions mt-4">
                <a href="<?= BASE_URL ?>/" class="btn-verde">Voltar para a Home</a>
                <a href="<?= BASE_URL ?>/servicos" class="btn-verde">Serviços</a>
            </div>
        </div>
    </div>
</section>
