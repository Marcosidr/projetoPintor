<?php
// Define o caminho absoluto para a raiz do seu projeto
define('ROOT_PATH', __DIR__ . '/');

// Dados para a seção de Recursos (Features)
$features = [
    [
        'icon' => '<i class="bi bi-check-circle-fill h-8 w-8 text-paint-green-600"></i>',
        'title' => "Experiência Comprovada",
        'description' => "Mais de 25 anos transformando espaços com qualidade"
    ],
    [
        'icon' => '<i class="bi bi-star-fill h-8 w-8 text-paint-green-600"></i>',
        'title' => "Qualidade Garantida",
        'description' => "Utilizamos apenas tintas e materiais de primeira linha"
    ],
    [
        'icon' => '<i class="bi bi-people-fill h-8 w-8 text-paint-green-600"></i>',
        'title' => "Compromisso com o Cliente",
        'description' => "Atendimento personalizado do orçamento à entrega"
    ],
    [
        'icon' => '<i class="bi bi-award-fill h-8 w-8 text-paint-green-600"></i>',
        'title' => "Alto Atendimento Personalizado",
        'description' => "Equipe especializada em diversos tipos de superfície"
    ]
];

// Dados para a seção de Serviços
$services = [
    [
        'title' => "Pinturas Gerais",
        'description' => "Pintura residencial e predial com acabamento perfeito",
        'link' => "index.php?page=servicos"
    ],
    [
        'title' => "Pinturas Versáteis",
        'description' => "Técnicas especiais para ambientes únicos",
        'link' => "index.php?page=servicos"
    ],
    [
        'title' => "Tratamento de Superfícies",
        'description' => "Preparação completa para maior durabilidade",
        'link' => "index.php?page=servicos"
    ],
    [
        'title' => "Pintura Comercial",
        'description' => "Projetos corporativos com acabamento profissional",
        'link' => "index.php?page=servicos"
    ],
    [
        'title' => "Impermeabilização",
        'description' => "Proteção definitiva contra umidade e infiltrações",
        'link' => "index.php?page=servicos"
    ],
    [
        'title' => "Revestimentos e Texturas",
        'description' => "Acabamentos especiais para valorizar seu espaço",
        'link' => "index.php?page=servicos"
    ]
];
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

        /* Card styles */
        .card {
            border: none;
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .card-body {
            padding: 1rem;
        }

        /* Custom text colors */
        .text-paint-green-600 {
            color: var(--paint-green-600);
        }

        .text-paint-green-700 {
            color: var(--paint-green-700);
        }

        .bg-paint-cream-50 {
            background-color: var(--paint-cream-50);
        }

        /* Hover scale */
        .hover-scale:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
        }

        /* Button shadow */
        .btn-shadow {
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        /* Float animation for the image */
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

<!-- MODAL DE ORÇAMENTO -->
<div class="modal fade" id="orcamentoModal" tabindex="-1" aria-labelledby="orcamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="">
                <input type="hidden" name="formulario" value="orcamento">
                <div class="modal-header">
                    <h5 class="modal-title" id="orcamentoModalLabel">Formulário de Orçamento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nome Completo *</label>
                        <input type="text" class="form-control" name="nome" required>
                    </div>

                    <div class="mb-3">
                        <label>Email *</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label>Telefone *</label>
                        <input type="tel" class="form-control" name="telefone" required>
                    </div>

                    <div class="mb-3">
                        <label>Endereço da Obra *</label>
                        <input type="text" class="form-control" name="endereco" required>
                    </div>

                    <div class="mb-3">
                        <label>Tipo de Imóvel *</label>
                        <select class="form-select" name="tipoImovel" required>
                            <option value="">Selecione</option>
                            <option>Residencial - Casa</option>
                            <option>Residencial - Apartamento</option>
                            <option>Comercial - Escritório</option>
                            <option>Comercial - Loja</option>
                            <option>Industrial</option>
                            <option>Outro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Tipo de Serviço *</label>
                        <select class="form-select" name="tipoServico" required>
                            <option value="">Selecione</option>
                            <option>Pintura Interna</option>
                            <option>Pintura Externa</option>
                            <option>Pintura Interna e Externa</option>
                            <option>Impermeabilização</option>
                            <option>Revestimentos e Texturas</option>
                            <option>Outro</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Área Aproximada (m²) *</label>
                        <input type="number" class="form-control" name="area" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label>Observações</label>
                        <textarea class="form-control" name="observacoes" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success px-4 fw-bold">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- HERO SECTION -->
<section class="container my-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-4 text-paint-green-700">Transforme seu ambiente com <br />a qualidade CLPinturas</h1>
            <p class="lead text-muted mb-4">
                Profissionais especializados com mais de 25 anos de experiência, utilizando materiais de alta qualidade para garantir o melhor acabamento.
            </p>
            <a href="#servicos" class="btn btn-success btn-lg rounded-pill px-5 fw-bold btn-shadow">Veja nossos serviços</a>
        </div>
        <div class="col-lg-6 text-center">
            <img src="img/home/paint_illustration.webp" alt="Ilustração de pintura" class="img-fluid float-animation" style="max-width: 400px;" />
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="container py-5 bg-paint-cream-50 rounded-4 shadow-sm my-5">
    <h2 class="text-center mb-5 text-paint-green-700 fw-bold">Por que escolher a CLPinturas?</h2>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        <?php foreach ($features as $feature): ?>
            <div class="col text-center">
                <div class="card p-4 h-100 border-0">
                    <div class="mb-3">
                        <?= $feature['icon'] ?>
                    </div>
                    <h5 class="fw-bold text-paint-green-700 mb-2"><?= $feature['title'] ?></h5>
                    <p class="text-muted"><?= $feature['description'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

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

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Inclui o rodapé