<?php
// filepath: c:/xampp/htdocs/projetoPintor/app/Views/partials/navbar.php
?>
<nav class="navbar navbar-expand-lg shadow-sm py-3 sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="<?= BASE_URL ?>/"><i class="bi bi-brush"></i> CLPINTURAS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/">HOME</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/quem-somos">QUEM SOMOS</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/servicos">SERVIÇOS</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= BASE_URL ?>/catalogos">CATÁLOGO</a></li>
        <!-- Itens de painel/logs removidos conforme solicitação -->
        <li class="nav-item ms-2">
          <button type="button" class="btn btn-success rounded-pill px-4 fw-bold text-white"
            data-bs-toggle="modal" data-bs-target="#orcamentoModal">
            ORÇAMENTO
          </button>
        </li>
        <li class="nav-item dropdown ms-3">
          <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
             role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="bi bi-person-circle fs-4 text-paint-green-700"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 border-0 p-2"
              aria-labelledby="userDropdown">
            <?php if (!empty($_SESSION['usuario'])): ?>
              <li class="px-3 py-2 small text-muted">
                <?= htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário') ?>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <form action="<?= BASE_URL ?>/logout" method="POST">
                  <?php if (function_exists('csrf_field')) echo csrf_field(); ?>
                  <button type="submit" class="dropdown-item text-danger">Sair</button>
                </form>
              </li>
            <?php else: ?>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/login">Entrar</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/register">Registrar</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>