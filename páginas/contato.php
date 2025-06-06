<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CLPinturas - Contato</title>

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
        <a class="navbar-brand fw-bold" href="./index.php">
            <i class="bi bi-brush"></i> CLPINTURAS
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item"><a class="nav-link" href="./index.php">HOME</a></li>
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
  ?>>

  <!-- Conteúdo da Página de Contato -->
  <div class="container mt-5">
    <h2 class="text-center mb-4">Fale Conosco</h2>
    <form>
      <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" required>
      </div>
      <div class="mb-3">
        <label for="mensagem" class="form-label">Mensagem</label>
        <textarea class="form-control" id="mensagem" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-success">Enviar</button>
    </form>
  </div>

  <!-- Modal de Orçamento -->
  <?php include './modal-orcamento.php'; ?>

  <!-- FOOTER -->
  <footer class="mt-5" style="background-color: #f5f5dc; color: #5D4037;">
    <div class="container py-4">
      <div class="row text-center text-md-start align-items-center">

        <!-- Coluna 1: Nome e slogan -->
        <div class="col-md-4 mb-4 mb-md-0">
          <h5 class="fw-bold" style="color: #5D4037;">CLPinturas</h5>
          <p style="color: #2e7d32;">Transformando espaços com<br>cores e qualidade desde 1995.</p>
        </div>

        <!-- Coluna 2: Links úteis -->
        <div class="col-md-4 mb-4 mb-md-0">
          <h5 class="fw-bold" style="color: #5D4037;">links úteis</h5>
          <ul class="list-unstyled">
            <li><a href="index.php" class="text-decoration-none" style="color: #2e7d32;">HOME</a></li>
            <li><a href="páginas/contato.php" class="text-decoration-none" style="color: #2e7d32;">CONTATO</a></li>
            <li><a href="#" data-bs-toggle="modal" data-bs-target="#orcamentoModal" class="text-decoration-none" style="color: #2e7d32;">ORÇAMENTO</a></li>
            <li><a href="páginas/servicos.php" class="text-decoration-none" style="color: #2e7d32;">SERVIÇOS</a></li>
          </ul>
        </div>

        <!-- Coluna 3: Redes sociais -->
        <div class="col-md-4">
          <h6 class="fw-bold text-md-end mb-3 mb-md-2" style="color: #5D4037;">Perfis</h6>
          <div class="d-flex justify-content-center justify-content-md-end gap-3">
            <a href="#" class="text-success fs-4"><i class="bi bi-whatsapp"></i></a>
            <a href="#" class="text-danger fs-4"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-dark fs-4"><i class="bi bi-paint-bucket"></i></a>
          </div>
        </div>

      </div>

      <!-- Rodapé inferior -->
      <div class="text-center mt-4 small" style="color: #5D4037;">
        © 2025 CL Pinturas. Todos os direitos reservados
      </div>
    </div>
  </footer>

  <!-- Bootstrap script ao final -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
