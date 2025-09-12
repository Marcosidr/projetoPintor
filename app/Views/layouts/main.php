<?php
// filepath: c:\xampp\htdocs\projetoPintor\app\Views\layouts\main.php
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= APP_NAME ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap e ícones primeiro -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Seu CSS por último -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/css/style.css">
</head>
<body>
    <!-- Modal Orçamento -->
    <?php include __DIR__ . '/../partials/modal-orcamento.php'; ?>

    <!-- Navbar -->
    <?php include __DIR__ . '/../partials/navbar.php'; ?>

    <main class="container my-4">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer -->
    <?php include __DIR__ . '/../partials/footer.php'; ?>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>