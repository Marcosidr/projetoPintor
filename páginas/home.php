<?php
$features = [
    [
        'icon' => '<i class="bi bi-check-circle-fill fs-1 text-paint-green-600"></i>',
        'title' => "Experiência Comprovada",
        'description' => "Mais de 25 anos transformando espaços com qualidade"
    ],
    [
        'icon' => '<i class="bi bi-star-fill fs-1 text-paint-green-600"></i>',
        'title' => "Qualidade Garantida",
        'description' => "Utilizamos apenas tintas e materiais de primeira linha"
    ],
    [
        'icon' => '<i class="bi bi-people-fill fs-1 text-paint-green-600"></i>',
        'title' => "Compromisso com o Cliente",
        'description' => "Atendimento personalizado do orçamento à entrega"
    ],
    [
        'icon' => '<i class="bi bi-award-fill fs-1 text-paint-green-600"></i>',
        'title' => "Alto Atendimento Personalizado",
        'description' => "Equipe especializada em diversos tipos de superfície"
    ]
];
?>

<!-- Seção principal com imagem e chamada -->
<section class="container my-5">
  <div class="row align-items-center">
    <div class="col-12 col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
      <h1 class="fw-bold mb-4 text-paint-green-700 fs-2 fs-lg-1">
        Transforme seu ambiente com <br class="d-none d-lg-block" />
        a qualidade CLPinturas
      </h1>
      <p class="lead text-muted mb-4">
        Profissionais especializados com mais de 25 anos de experiência, utilizando materiais de alta qualidade para garantir o melhor acabamento.
      </p>
      <a href="?param=servicos" class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow-sm">
        Veja nossos serviços
      </a>
    </div>
    <div class="col-12 col-lg-6 text-center">
      <img src="img/image.png" alt="Ilustração de pintura" class="img-fluid rounded shadow w-100" style="max-width: 400px;" />
    </div>
  </div>
</section>

<!-- Seção de Features -->
<section class="container py-5 bg-paint-cream-50 rounded-4 shadow-sm my-5">
  <h2 class="text-center mb-5 text-paint-green-700 fw-bold">Por que escolher a CLPinturas?</h2>
  <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
    <?php foreach ($features as $feature): ?>
      <div class="col text-center">
        <div class="card p-4 h-100 border-0">
          <div class="mb-3"><?= $feature['icon'] ?></div>
          <h5 class="fw-bold text-paint-green-700 mb-2"><?= $feature['title'] ?></h5>
          <p class="text-muted"><?= $feature['description'] ?></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Seção Representantes -->
<section class="container my-5">
  <h2 class="text-center text-paint-green-700 mb-4">Representantes</h2>
  <div class="row g-4">
    <!-- Clodoaldo -->
    <div class="col-12 col-md-6">
      <div class="card text-center h-100 border border-paint-green-600">
        <div class="card-body">
          <img src="img/pai.jpg" alt="Clodoaldo Inácio" class="rounded-circle mb-3 img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
          <h5 class="fw-bold text-paint-green-700">Clodoaldo Inácio</h5>
          <p class="text-muted fst-italic">
            Clodoaldo Inácio iniciou sua jornada na pintura aos 19 anos como ajudante, aprendendo na prática a arte e a responsabilidade do ofício. Aos 23, já com experiência e confiança, começou a atuar de forma independente, conquistando seus próprios clientes e moldando sua reputação com base em qualidade, seriedade e comprometimento.
          </p>
        </div>
      </div>
    </div>

    <!-- Bruno -->
    <div class="col-12 col-md-6">
      <div class="card text-center h-100">
        <div class="card-body">
          <img src="img/bruno.jpg" alt="Bruno Teilor" class="rounded-circle mb-3 img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
          <h5 class="fw-bold text-paint-green-600">Bruno Teilor</h5>
          <p class="text-muted fst-italic">
            Começou como ajudante de Clodoaldo e, pela dedicação e competência, tornou-se sócio desde 2024. Bruno traz energia, inovação e compromisso para o crescimento da empresa e a satisfação dos clientes.
          </p>
        </div>
      </div>
    </div>
  </div>
  <?php
require_once __DIR__ . '/../classes/ServicoManager.php';
$servicos = ServicoManager::getServicos();
?>


</section>
