<?php
// Parâmetro da URL para controle de página
$param = $_GET["param"] ?? "home";
$pagina = "páginas/{$param}.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/servicos.css">

  <title>Serviços</title>
  
  <style>
    .card i {
      font-size: 2rem;
    }
    .card ul li {
      margin-bottom: 0.5rem;
    }
  </style>
</head>
<body>

<!-- Modal de Orçamento -->
<?php include 'páginas/modal-orcamento.php'; ?>

<!-- CONTEÚDO DA PÁGINA -->
<div class="container my-5">
  <h1 class="text-center mb-4">Nossos Serviços</h1>
  <p class="text-center lead">
    Na CLPinturas, oferecemos uma vasta gama de serviços para atender todas as suas necessidades de pintura e acabamento.
    Nossa equipe especializada está pronta para transformar seu ambiente com qualidade e eficiência.
  </p>

  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-5">
    
    <!-- Pinturas Gerais -->
    <div class="col">
      <div class="card h-100 p-4 border-0 shadow-sm">
        <div class="text-success mb-3"><i class="bi bi-house-door"></i></div>
        <h5 class="fw-bold">Pinturas Gerais</h5>
        <p>Pintura residencial e comercial com acabamento impecável</p>
        <ul class="list-unstyled text-muted small">
          <li><i class="bi bi-check-circle text-success me-2"></i>Pintura interna e externa</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Preparação completa da superfície</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Tintas de alta qualidade</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Acabamento profissional</li>
        </ul>
      </div>
    </div>

    <!-- Pinturas Versáteis -->
    <div class="col">
      <div class="card h-100 p-4 border-0 shadow-sm">
        <div class="text-success mb-3"><i class="bi bi-palette"></i></div>
        <h5 class="fw-bold">Pinturas Versáteis</h5>
        <p>Técnicas especiais para ambientes únicos e personalizados</p>
        <ul class="list-unstyled text-muted small">
          <li><i class="bi bi-check-circle text-success me-2"></i>Técnicas decorativas</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Efeitos especiais</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Cores personalizadas</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Consultoria em design</li>
        </ul>
      </div>
    </div>

    <!-- Tratamento de Superfícies -->
    <div class="col">
      <div class="card h-100 p-4 border-0 shadow-sm">
        <div class="text-success mb-3"><i class="bi bi-wrench"></i></div>
        <h5 class="fw-bold">Tratamento de Superfícies</h5>
        <p>Preparação especializada para maior durabilidade</p>
        <ul class="list-unstyled text-muted small">
          <li><i class="bi bi-check-circle text-success me-2"></i>Lixamento e preparação</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Correção de imperfeições</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Aplicação de primers</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Seladores especiais</li>
        </ul>
      </div>
    </div>

    <!-- Pintura Comercial -->
    <div class="col">
      <div class="card h-100 p-4 border-0 shadow-sm">
        <div class="text-success mb-3"><i class="bi bi-building"></i></div>
        <h5 class="fw-bold">Pintura Comercial</h5>
        <p>Projetos corporativos com prazos e qualidade garantidos</p>
        <ul class="list-unstyled text-muted small">
          <li><i class="bi bi-check-circle text-success me-2"></i>Grandes áreas</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Prazos otimizados</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Trabalho noturno/finais de semana</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Mínimo impacto nas atividades</li>
        </ul>
      </div>
    </div>

    <!-- Impermeabilização -->
    <div class="col">
      <div class="card h-100 p-4 border-0 shadow-sm">
        <div class="text-success mb-3"><i class="bi bi-shield-check"></i></div>
        <h5 class="fw-bold">Impermeabilização</h5>
        <p>Proteção definitiva contra umidade e infiltrações</p>
        <ul class="list-unstyled text-muted small">
          <li><i class="bi bi-check-circle text-success me-2"></i>Sistemas impermeabilizantes</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Tratamento de lajes</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Proteção de fachadas</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Garantia estendida</li>
        </ul>
      </div>
    </div>

    <!-- Revestimentos e Texturas -->
    <div class="col">
      <div class="card h-100 p-4 border-0 shadow-sm">
        <div class="text-success mb-3"><i class="bi bi-pencil"></i></div>
        <h5 class="fw-bold">Revestimentos e Texturas</h5>
        <p>Acabamentos especiais para valorizar seu espaço</p>
        <ul class="list-unstyled text-muted small">
          <li><i class="bi bi-check-circle text-success me-2"></i>Texturas decorativas</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Revestimentos especiais</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Grafiatos e relevos</li>
          <li><i class="bi bi-check-circle text-success me-2"></i>Acabamentos rústicos</li>
        </ul>
      </div>
    </div>
  </div>

  <div class="text-center mt-5">
    <p class="lead">Precisa de um serviço específico que não está listado? Entre em contato conosco! 
  </p>
    <a href="index.php?param=contato" class="btn btn-success btn-lg">Fale Conosco</a>
  </div>
</div>

<!-- Bootstrap Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
