<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

$allowed_pages = ['contato', 'orcamento', 'servicos', 'quem-somos'];

if ($page === 'home') {
    // Home é esta própria index.php
    $conteudo = '<h1>Bem-vindo à página Home</h1><p>Conteúdo da página inicial.</p>';
} else {
    $arquivo = "paginas/{$page}.php";
    if (in_array($page, $allowed_pages) && file_exists($arquivo)) {
        $conteudo = file_get_contents($arquivo);
    } else {
        $conteudo = file_get_contents("paginas/erro.php");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CLPinturas - <?= ucfirst(str_replace('-', ' ', $page)) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success" href="index.php"><i class="bi bi-brush"></i> CLPINTURAS</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
        <li class="nav-item"><a class="nav-link" href="páginas/quem-somos.php">QUEM SOMOS</a></li>
        <li class="nav-item"><a class="nav-link" href="páginas/servicos.php">SERVIÇOS</a></li>

        <!-- Link Contato abre modal contato -->
        <li class="nav-item"><a class="nav-link" href="páginas/contato.php" data-bs-toggle="modal" data-bs-target="#contatoModal">CONTATO</a></li>

        <!-- Botão Orçamento abre modal orçamento -->
        <li class="nav-item ms-2">
          <button type="button" class="btn btn-success rounded-pill px-4 fw-bold text-white" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
            ORÇAMENTO
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-4">
  <?= $conteudo ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
