<?php
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
<section class="container my-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h1 class="display-4 fw-bold mb-4 text-paint-green-700">Transforme seu ambiente com <br />a qualidade CLPinturas</h1>
            <p class="lead text-muted mb-4">
                Profissionais especializados com mais de 25 anos de experiência, utilizando materiais de alta qualidade para garantir o melhor acabamento.
            </p>
            <a href="?param=servicos" class="btn btn-success btn-lg rounded-pill px-5 fw-bold btn-shadow">Veja nossos serviços</a>
        </div>
        <div class="col-lg-6 text-center">
            <img src="img/home/paint_illustration.webp" alt="Ilustração de pintura" class="img-fluid float-animation" style="max-width: 400px;" />
        </div>
    </div>
</section>

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