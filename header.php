<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CLPinturas - ORÇAMENTO</title>

  <!-- Bootstrap e ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />

  <!-- Estilos personalizados -->
  <style>
    :root {
      --verde-clp:#2e7d32;
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
    <a class="navbar-brand fw-bold" href="index.php">
      <i class="bi bi-brush"></i> CLPINTURAS
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
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
