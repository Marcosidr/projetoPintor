<?php
/**
 * Partial de exibição de mensagens flash.
 * Uso: include __DIR__.'/flash.php';
 * Reconhece chaves padronizadas definidas nos controllers/services.
 */

use App\Core\Session;

$flashKeys = [
    'erro_orcamento' => 'danger',
    'sucesso_orcamento' => 'success',
    'erro_login' => 'danger',
    'sucesso_login' => 'success',
    'erro_register' => 'danger',
    'sucesso_register' => 'success',
];

foreach ($flashKeys as $key => $type) {
    $msg = Session::get($key);
    if ($msg) {
        echo '<div class="alert alert-' . htmlspecialchars($type) . ' alert-dismissible fade show" role="alert">'
           . htmlspecialchars($msg) .
           '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
           . '</div>';
        Session::remove($key);
    }
}