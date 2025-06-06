<?php
// Define o caminho absoluto para a raiz do seu projeto
define('ROOT_PATH', __DIR__ . '/');

// Parâmetro da URL para controle de página
$param = $_GET["param"] ?? "home";
$pagina = "páginas/{$param}.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CLPinturas - Home</title>

    <!-- Bootstrap e ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Estilos personalizados -->
    <style>
        :root {
            --verde-clp: #2e7d32;
            --creme-clp: #f5f5dc;
            --marrom-clp: #5D4037;
            --paint-green-600: #2e7d32;
            --paint-green-700: #27652b;
            --paint-cream-50: #f5f5dc;
        }

        body {
            background-color: var(--creme-clp);
        }

        .navbar {
            background-color: #fff;
        }

        .navbar .nav-link {
            color: var(--marrom-clp);
            font-weight: 500;
            transition: color 0.3s;
        }

        .navbar .nav-link:hover {
            color: var(--verde-clp);
        }

        .navbar-brand {
            color: var(--verde-clp);
        }

        .btn-success {
            background-color: var(--verde-clp);
            border: none;
        }

        .btn-success:hover {
            background-color: #27652b;
        }

        .card {
            border: none;
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-body {
            padding: 1rem;
        }

        .text-paint-green-600 {
            color: var(--paint-green-600);
        }

        .text-paint-green-700 {
            color: var(--paint-green-700);
        }

        .bg-paint-cream-50 {
            background-color: var(--paint-cream-50);
        }

        .hover-scale:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        .btn-shadow {
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="./index.php">
            <i class="bi bi-brush"></i> CLPINTURAS
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?param=quem-somos">QUEM SOMOS</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?param=servicos">SERVIÇOS</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php?param=contato">CONTATO</a></li>
                <li class="nav-item ms-2">
                    <button type="button" class="btn btn-success rounded-pill px-4 fw-bold text-white" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
                        ORÇAMENTO
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php include 'páginas/modal-orcamento.php'; ?>

<main>
<?php
// Inclui a página conforme o parâmetro, se existir
if (file_exists($pagina)) {
    include $pagina;
} else {
    include "páginas/erro.php";
}
?>
</main>

<!-- FOOTER -->
<footer class="mt-5" style="background-color: #f5f5dc; color: #5D4037;">
  <div class="container py-4">
    <div class="row text-center text-md-start align-items-center">
      <div class="col-md-4 mb-4 mb-md-0">
        <h5 class="fw-bold" style="color: #5D4037;">CLPinturas</h5>
        <p style="color: #2e7d32;">Transformando espaços com<br>cores e qualidade desde 1995.</p>
      </div>

      <div class="col-md-4 mb-4 mb-md-0">
        <h5 class="fw-bold" style="color: #5D4037;">links úteis</h5>
        <ul class="list-unstyled">
          <li><a href="index.php" class="text-decoration-none" style="color: #2e7d32;">HOME</a></li>
          <li><a href="index.php?param=contato" class="text-decoration-none" style="color: #2e7d32;">CONTATO</a></li>
          <li><a href="#" data-bs-toggle="modal" data-bs-target="#orcamentoModal" class="text-decoration-none" style="color: #2e7d32;">ORÇAMENTO</a></li>
          <li><a href="index.php?param=servicos" class="text-decoration-none" style="color: #2e7d32;">SERVIÇOS</a></li>
        </ul>
      </div>
    </div>
  </div>
</footer>

<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
