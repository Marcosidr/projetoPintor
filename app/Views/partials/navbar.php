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
          <button class="nav-link dropdown-toggle d-flex align-items-center bg-transparent border-0 p-0" id="userDropdown"
             type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true" data-bs-auto-close="outside">
            <i class="bi bi-person-circle fs-4 text-paint-green-700"></i>
            <span class="visually-hidden">Menu do usuário</span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end shadow rounded-3 border-0 p-2"
              aria-labelledby="userDropdown" style="min-width: 14rem;">
            <?php if (!empty($_SESSION['usuario'])): ?>
              <li class="px-3 py-2 small text-muted d-flex flex-column">
                <span class="fw-semibold">
                  <?= htmlspecialchars($_SESSION['usuario']['nome'] ?? 'Usuário') ?>
                </span>
                <span class="text-muted"><?= htmlspecialchars($_SESSION['usuario']['email'] ?? '') ?></span>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/painel"><i class="bi bi-speedometer2 me-2"></i>Painel</a></li>
              <?php if (!empty($_SESSION['usuario']['tipo']) && $_SESSION['usuario']['tipo'] === 'admin'): ?>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin"><i class="bi bi-people me-2"></i>Gerenciar Usuários</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/admin/catalogos"><i class="bi bi-images me-2"></i>Catálogos</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL ?>/painel/logs"><i class="bi bi-journal-text me-2"></i>Logs</a></li>
                <li><hr class="dropdown-divider"></li>
              <?php endif; ?>
              <li>
                <form action="<?= BASE_URL ?>/logout" method="POST" class="m-0">
                  <?php if (function_exists('csrf_field')) echo csrf_field(); ?>
                  <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Sair</button>
                </form>
              </li>
            <?php else: ?>
              <li class="px-3 py-2 small text-muted">Bem-vindo! Faça login ou crie conta.</li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/login"><i class="bi bi-box-arrow-in-right me-2"></i>Entrar</a></li>
              <li><a class="dropdown-item" href="<?= BASE_URL ?>/register"><i class="bi bi-person-plus me-2"></i>Registrar</a></li>
            <?php endif; ?>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>