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

<!-- footer -->
<footer class="bg-dark text-white pt-5 pb-4">
  <div class="container text-md-left">
    <div class="row text-md-left">
      <!-- Coluna 1 -->
      <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold text-success">CLPinturas</h5>
        <p>
          Transformando ambientes com excelência em pintura há mais de 25 anos.
        </p>
      </div>

      <!-- Coluna 2 -->
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold text-success">Links</h5>
        <p><a href="?param=home" class="text-white text-decoration-none">Home</a></p>
        <p><a href="?param=servicos" class="text-white text-decoration-none">Serviços</a></p>
        <p><a href="?param=quem-somos" class="text-white text-decoration-none">Quem somos</a></p>
        <p><a href="?param=contato" class="text-white text-decoration-none">Contato</a></p>
      </div>

      <!-- Coluna 3 -->
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold text-success">Redes Sociais</h5>
        <p><a href="#" class="text-white text-decoration-none">Facebook</a></p>
        <p><a href="#" class="text-white text-decoration-none">Instagram</a></p>
        <p><a href="#" class="text-white text-decoration-none">WhatsApp</a></p>
      </div>

      <!-- Coluna 4 -->
      <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
        <h5 class="text-uppercase mb-4 font-weight-bold text-success">Contato</h5>
        <p><i class="fas fa-home mr-3"></i> Rua Belo horizonte, 3 -Boa esperança Paraná</p>
        <p><i class="fas fa-envelope mr-3"></i> clpinturas@email.com</p>
        <p><i class="fas fa-phone mr-3"></i> (44) 99800-8156</p>
      </div>
    </div>

    <!-- Linha horizontal -->
    <hr class="mb-4">

    <!-- Parte inferior -->
    <div class="row align-items-center">
      <div class="col-md-7 col-lg-8">
        <p class="text-white">
          © 2025 CLPinturas. Todos os direitos reservados.
        </p>
      </div>

      <div class="col-md-5 col-lg-4">
        <div class="text-center text-md-right">
          <a href="#" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="text-white me-4"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-white me-4"><i class="fab fa-whatsapp"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>
<style>
.footer-simples {
  background-color: #ffffff;
  border-top: 1px solid #ddd;
  font-size: 0.9rem;
  color: #5D4037; /* marrom escuro */
}

.footer-simples a {
  color: #5D4037;
  text-decoration: none;
  font-weight: 500;
  letter-spacing: 0.5px;
  transition: color 0.3s;
}

.footer-simples a:hover {
  color: #2e7d32; /* verde escuro no hover */
}

.footer-simples .btn-success {
  background-color: #2e7d32;
  border: none;
  font-size: 0.85rem;
}

</style>


<!-- Scripts Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
