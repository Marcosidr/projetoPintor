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

<!-- Seção principal com imagem responsiva -->
<section class="container my-5">
    <div class="row align-items-center">
        <div class="col-12 col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
            <h1 class="display-4 fw-bold mb-4 text-paint-green-700">Transforme seu ambiente com <br />a qualidade CLPinturas</h1>
            <p class="lead text-muted mb-4">
                Profissionais especializados com mais de 25 anos de experiência, utilizando materiais de alta qualidade para garantir o melhor acabamento.
            </p>
            <a href="?param=servicos" class="btn btn-success btn-lg rounded-pill px-5 fw-bold btn-shadow">Veja nossos serviços</a>
        </div>
        <div class="col-12 col-lg-6 text-center">
            <img src="img/image.png" alt="Ilustração de pintura" class="img-fluid rounded shadow" style="max-width: 400px; height: auto;" />
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

<!-- Seção de Representantes -->
<div class="container my-5">
    <h2 class="text-center text-paint-green-700 mb-4">Representantes</h2>
    <div class="row g-4">
        <!-- Marcos Inácio -->
        <div class="col-12 col-md-6">
            <div class="card hover-scale text-center">
                <div class="card-body">
                    <img src="img/eu.jpeg" alt="Marcos Inácio" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="fw-bold text-paint-green-600">Marcos Inácio</h5>
                    <p class="text-muted fst-italic">
                        Filho de Clodoaldo, cresceu acompanhando de perto o trabalho de seu pai e carrega consigo toda a experiência e dedicação da família.
                        Sempre atento às tendências e necessidades dos clientes, é o responsável por manter a qualidade e confiança da marca.
                    </p>
                </div>
            </div>
        </div>

        <!-- Bruno Teilor -->
        <div class="col-12 col-md-6">
            <div class="card hover-scale text-center">
                <div class="card-body">
                    <img src="img/bruno.jpg" alt="Bruno Teilor" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="fw-bold text-paint-green-600">Bruno Teilor</h5>
                    <p class="text-muted fst-italic">
                        Começou como ajudante de Clodoaldo e, pela dedicação e competência, tornou-se sócio desde 2024.
                        Bruno traz energia, inovação e compromisso para o crescimento da empresa e a satisfação dos clientes.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
