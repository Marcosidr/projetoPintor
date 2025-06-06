<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CLPinturas - Serviços</title>

  <!-- Bootstrap e ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Estilos personalizados -->
  <style>
    :root {
      --verde-clp: #2e7d32;
      --creme-clp: #f5f5dc;
      --marrom-clp: #5D4037;
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
  </style>
</head>

<body>
  
  <!-- NAVBAR -->
<nav class="navbar navbar-expand-lg shadow-sm py-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="../index.php">
            <i class="bi bi-brush"></i> CLPINTURAS
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="../index.php">HOME</a></li>
                <li class="nav-item"><a class="nav-link" href="páginas/quem-somos.php">QUEM SOMOS</a></li>
                <li class="nav-item"><a class="nav-link" href="páginas/servicos.php">SERVIÇOS</a></li>
                <li class="nav-item"><a class="nav-link" href="páginas/contato.php">CONTATO</a></li>
                <li class="nav-item ms-2">
                    <button type="button" class="btn btn-success rounded-pill px-4 fw-bold text-white" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
                        ORÇAMENTO
                    </button>
                </li>
            </ul>
        </div>
    </div>
</nav>
  <!-- Modal de Orçamento -->
<?php
 include 'modal-orcamento.php';
  ?>


  <!-- CONTEÚDO DA PÁGINA -->
  <div class="container my-5">
    <h1 class="text-center mb-4">Nossos Serviços</h1>
    <p class="text-center lead">
      Na CLPinturas, oferecemos uma vasta gama de serviços para atender todas as suas necessidades de pintura e acabamento.
      Nossa equipe especializada está pronta para transformar seu ambiente com qualidade e eficiência.
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-5">
      <!-- Cards dos serviços -->
      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Pintura Interna</h5>
            <p class="card-text">Transformamos seus ambientes internos com cores e texturas que refletem sua personalidade e estilo.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Pintura Externa</h5>
            <p class="card-text">Proteção e beleza para a fachada do seu imóvel, utilizando tintas resistentes às intempéries e técnicas avançadas.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Impermeabilização</h5>
            <p class="card-text">Soluções completas para proteger seu imóvel contra umidade, infiltrações e mofo, garantindo durabilidade e saúde.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Texturas e Grafiatos</h5>
            <p class="card-text">Adicione um toque de sofisticação e personalidade às suas paredes com uma variedade de texturas e grafiatos.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Restauração de Fachadas</h5>
            <p class="card-text">Recuperamos a beleza original de fachadas antigas, corrigindo imperfeições e aplicando acabamentos de alta qualidade.</p>
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h5 class="card-title text-success">Pintura Comercial</h5>
            <p class="card-text">Serviços de pintura para escritórios, lojas e outros espaços comerciais, minimizando interrupções e garantindo um resultado profissional.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="text-center mt-5">
      <p class="lead">Precisa de um serviço específico que não está listado? Entre em contato conosco!</p>
      <a href="./contato.php" class="btn btn-success btn-lg">Fale Conosco</a>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="mt-5" style="background-color: var(--creme-clp); color: var(--marrom-clp);">
    <div class="container py-4">
      <div class="row text-center text-md-start align-items-center">

        <!-- Coluna 1: Nome e slogan -->
        <div class="col-md-4 mb-4 mb-md-0">
          <h5 class="fw-bold" style="color: var(--marrom-clp);">CLPinturas</h5>
          <p style="color: var(--verde-clp);">
            Transformando espaços com<br>cores e qualidade desde 1995.
          </p>
        </div>

        <!-- Coluna 2: Links úteis -->
        <div class="col-md-4 mb-4 mb-md-0">
          <h5 class="fw-bold" style="color: var(--marrom-clp);">links úteis</h5>
          <ul class="list-unstyled">
            <li><a href="../index.php" class="text-decoration-none" style="color: var(--verde-clp);">HOME</a></li>
            <li><a href="páginas/contato.php" class="text-decoration-none" style="color: var(--verde-clp);">CONTATO</a></li>
            <li><a href="páginas/servicos.php" class="text-decoration-none" style="color: var(--verde-clp);">SERVIÇOS</a></li>
          </ul>
        </div>

        <!-- Coluna 3: Redes sociais -->
        <div class="col-md-4">
          <h6 class="fw-bold text-md-end mb-3 mb-md-2" style="color: var(--marrom-clp);">Perfis</h6>
          <div class="d-flex justify-content-center justify-content-md-end gap-3">
            <a href="#" class="text-success fs-4"><i class="bi bi-whatsapp"></i></a>
            <a href="#" class="text-danger fs-4"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-dark fs-4"><i class="bi bi-paint-bucket"></i></a>
          </div>
        </div>

      </div>

      <!-- Rodapé inferior -->
      <div class="text-center mt-4 small" style="color: var(--marrom-clp);">
        © 2025 CL Pinturas. Todos os direitos reservados
      </div>
    </div>
  </footer>

  <!-- Bootstrap script ao final -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
