<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CL Pinturas - Quem Somos</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <!-- AOS Animation -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />

  <style>
    body {
      background-color: #f5f5dc;
      color: #2e2e2e;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    h1, h2 {
      color: #2e7d32;
      font-weight: bold;
    }

    p {
      font-size: 1.1rem;
      line-height: 1.7;
    }

    .card {
      transition: all 0.3s ease;
      border: none;
      border-radius: 20px;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background-color: #2e7d32;
      border: none;
      border-radius: 30px;
      padding: 10px 25px;
      font-weight: 600;
    }

    .btn-primary:hover {
      background-color: #256428;
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

  <div class="container py-5">
    <h1 class="mb-4 text-center" data-aos="fade-down">Quem Somos</h1>

    <div class="mb-5" data-aos="fade-right">
      <p>
        A <strong>CLPinturas</strong> nasceu do sonho de transformar ambientes comuns em espaços únicos e cheios de vida, através da arte da pintura.
        Fundada como uma pequena empresa familiar, trilhamos um caminho de crescimento sólido, sempre guiados por três pilares:
        <strong>qualidade</strong>, <strong>confiança</strong> e <strong>excelência no atendimento</strong>.
      </p>
      <p>
        Nossa história é construída com dedicação e trabalho honesto. Ao longo dos anos, realizamos milhares de projetos — de lares acolhedores
        a grandes empreendimentos comerciais — sempre com o compromisso de superar expectativas.
      </p>
      <p>
        Hoje, a CLPinturas é referência no mercado, reconhecida pela qualidade dos serviços, pontualidade e profissionalismo de sua equipe.
        Transformar espaços é mais do que um trabalho — é nossa missão.
      </p>
    </div>

    <h2 class="mb-4 text-center" data-aos="fade-up">Nossos Valores</h2>
    <div class="row text-center">
      <div class="col-md-4 mb-4" data-aos="zoom-in">
        <div class="card p-4 shadow-sm h-100">
          <i class="fas fa-check-circle fa-2x text-success mb-3"></i>
          <h5>Qualidade</h5>
          <p>Materiais de primeira linha e técnicas modernas.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="100">
        <div class="card p-4 shadow-sm h-100">
          <i class="fas fa-handshake fa-2x text-primary mb-3"></i>
          <h5>Confiança</h5>
          <p>Relacionamento transparente e duradouro com o cliente.</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
        <div class="card p-4 shadow-sm h-100">
          <i class="fas fa-headset fa-2x text-warning mb-3"></i>
          <h5>Excelência no Atendimento</h5>
          <p>Atendimento personalizado, com atenção aos detalhes.</p>
        </div>
      </div>
    </div>

    <div class="mt-5" data-aos="fade-left">
      <h2>Nosso Compromisso</h2>
      <p>
        Cada projeto é uma nova história. Estamos comprometidos em transformar sonhos em realidade,
        oferecendo soluções de pintura que superam expectativas.
      </p>
    </div>

    <div class="mt-4" data-aos="fade-up">
      <h2>Venha nos conhecer!</h2>
      <p>
        Convidamos você a fazer parte da nossa história. Entre em contato e veja como podemos transformar seu espaço com a arte da pintura.
        Aqui, cada pincelada é feita com amor e dedicação.
      </p>
    </div>

    <div class="text-center mt-5" data-aos="zoom-in-up">
      <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
        FAÇA SEU ORÇAMENTO
      </a>
    </div>
  </div>

 <?php include './modal-orcamento.php'; ?>
 
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
            <li><a href="index.php" class="text-decoration-none" style="color: var(--verde-clp);">HOME</a></li>
            <li><a href="páginas/contato.php" class="text-decoration-none" style="color: var(--verde-clp);">CONTATO</a></li>
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#orcamentoModal" class="text-decoration-none" style="color: var(--verde-clp);">ORÇAMENTO</a></li>
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
  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init();
  </script>

</body>
</html>
