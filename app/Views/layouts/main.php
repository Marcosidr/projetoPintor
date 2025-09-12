<?php
// filepath: c:\xampp\htdocs\projetoPintor\app\Views\layouts\main.php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title><?= APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
    <meta name="base-url" content="<?= htmlspecialchars(BASE_URL) ?>">

    <!-- Bootstrap e ícones primeiro -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome (todo: adicionar SRI) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.2/css/all.min.css"
        crossorigin="anonymous">
    <!-- Chart.js (todo: adicionar SRI) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js" defer></script>
    <!-- Seu CSS por último -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>

<body>
    <!-- Modal Orçamento -->
    <?php include __DIR__ . '/../partials/modal-orcamento.php'; ?>

    <!-- Navbar -->
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <main class="container my-4">
        <?php include __DIR__.'/../partials/flash.php'; ?>
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <!-- Scripts Bootstrap + inicialização custom -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL ?>/js/app.js"></script>
    <?php
    $uriPath = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH) ?? '';
    $normalized = $uriPath;
    $base = rtrim(BASE_URL,'/');
    if ($base !== '' && str_starts_with($normalized, $base)) {
        $normalized = substr($normalized, strlen($base));
        if ($normalized === false) $normalized = '/';
    }
    // Carrega o script do painel para /painel e qualquer subrota futura (/painel/logs, /painel/usuarios, etc.)
    if ($normalized === '/painel' || str_starts_with($normalized, '/painel/')) :
        echo '<script src="'.BASE_URL.'/js/painel.js" defer></script>';
    endif;          
    ?>
</body>

</html>