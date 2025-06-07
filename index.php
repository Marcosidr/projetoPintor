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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
    font-family: 'Arial', sans-serif; /* Adicionado para consistência */
    color: #343a40; /* Cor de texto padrão para o corpo */
}

/* Header */
.navbar {
    background-color: #fff;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05); /* Sombra mais sutil */
}

.navbar .nav-link {
    color: var(--marrom-clp);
    font-weight: 500;
    transition: color 0.3s;
}

.navbar .nav-link:hover,
.navbar .nav-link.active {
    color: var(--verde-clp);
}

.navbar-brand {
    color: var(--verde-clp);
    font-size: 1.5rem; /* Ajustado para um tamanho mais comum */
    display: flex; /* Para alinhar o ícone e o texto */
    align-items: center;
}

.navbar-brand .bi-brush {
    font-size: 1.8rem; /* Tamanho do ícone */
    margin-right: 8px; /* Espaço entre ícone e texto */
}


.btn-success {
    background-color: var(--verde-clp);
    border: none;
    border-radius: 0.5rem; /* Levemente arredondado */
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.btn-success:hover {
    background-color: var(--paint-green-700);
    transform: translateY(-2px); /* Efeito de elevação ao passar o mouse */
}

.card {
    border: none;
    background-color: #fff;
    border-radius: 0.75rem;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

/* Specific to Contact Page */
.form-label {
    color: var(--marrom-clp); /* Cor para as labels do formulário */
}

.form-control {
    border-radius: 0.4rem; /* Arredondamento para os campos */
    border: 1px solid #ced4da;
    padding: 0.75rem 1rem;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.form-control:focus {
    border-color: var(--verde-clp);
    box-shadow: 0 0 0 0.25rem rgba(46, 125, 50, 0.25); /* Sombra do foco Bootstrap no seu verde */
    outline: none;
}

.alert {
    border-radius: 0.5rem;
}

.contact-info .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.contact-info .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.btn-social {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    transition: all 0.3s ease;
    border: 1px solid var(--verde-clp); /* Borda da cor do seu verde */
    color: var(--verde-clp); /* Cor do ícone */
}

.btn-social:hover {
    background-color: var(--verde-clp);
    color: white !important;
    transform: translateY(-2px); /* Efeito sutil ao passar o mouse */
}

/* Footer (já tem bastante estilo, mas pode adicionar mais) */
.main-footer { 
    background-color: var(--marrom-clp) !important; /* Cor mais escura para o footer */
    color: #e0e0e0; /* Texto mais claro */
}

.main-footer h5 {
    color: var(--verde-clp); /* Títulos do footer em verde */
}

.main-footer a {
    color: #e0e0e0; /* Links do footer */
    transition: color 0.3s ease;
}

.main-footer a:hover {
    color: var(--verde-clp); /* Links do footer hover */
}

.main-footer .social-icons a { /* Se tiver ícones dentro de uma div com essa classe */
    color: #e0e0e0;
}

.main-footer .social-icons a:hover {
    color: var(--verde-clp);
}


/* Outros estilos globais do seu index.php */
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
    transform: scale(1.03); /* Ajustado para um zoom mais suave */
    transition: transform 0.3s ease, box-shadow 0.3s ease; /* Adicionado box-shadow na transição */
    box-shadow: 0 8px 15px rgba(0,0,0,0.1); /* Sombra ao passar o mouse */
}

.btn-shadow {
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-10px); } /* Flutuação um pouco menor */
}

.float-animation {
    animation: float 4s ease-in-out infinite; /* Velocidade ajustada */
}

/* Ajustes para dispositivos menores */
@media (max-width: 768px) {
    .contact-info .card {
        margin-bottom: 1.5rem;
    }
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
          <a href="https://www.instagram.com/marcos_inacion/" class="text-white me-4"><i class="fab fa-instagram"></i></a>
          <a href="https://api.whatsapp.com/send?phone=5544998008156" class="text-white me-4"><i class="fab fa-whatsapp"></i></a>
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
