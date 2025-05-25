<?php
// Define o caminho absoluto para a raiz do seu projeto
define('ROOT_PATH', __DIR__ . '/');

// ... seu código PHP para roteamento e outras coisas

// Dados para a seção de Recursos (Features)
$features = [
    [
        'icon' => '<i class="bi bi-check-circle-fill h-8 w-8 text-paint-green-600"></i>', // Usando Bootstrap Icons para simular lucide-react
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
        'link' => "index.php?page=servicos" // Ajuste para o seu sistema de roteamento PHP
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
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
  <link rel="stylesheet" href=" css/style.css">
  <title>HOME</title>
</head>
<body>
  
<div class="min-h-screen bg-white">
    
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
   <div class="absolute left-10 top-1/4 float-animation opacity-20">
    <img
        src="/img/lovable-uploads/9b6a64e8-ea29-457a-b23c-cbd2ed466387.png"
        alt="Paint tools"
        class="w-32 h-32 object-contain"
    />
</div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 text-center">
            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-8 shadow-2xl">
                <h1 class="text-4xl md:text-6xl font-bold text-paint-green-700 mb-4">
                    CLPINTURAS
                </h1>
                <p class="text-xl md:text-2xl text-gray-600 mb-8">
                    Transformando espaços com cores e qualidade
                </p>
                <a href="index.php?page=orcamento" class="btn bg-paint-green-600 hover:bg-paint-green-700 text-white px-8 py-4 text-lg rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                    FAÇA SEU ORÇAMENTO
                    <i class="bi bi-arrow-right ml-2 h-5 w-5"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-paint-green-700 mb-4">
                    Sua Escolha em Qualidade e Confiança
                </h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <?php foreach ($features as $feature): ?>
                    <div class="card text-center p-6 hover:shadow-lg transition-shadow duration-300">
                        <div class="card-body p-0">
                            <div class="mb-4 flex justify-center"><?= $feature['icon'] ?></div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?= $feature['title'] ?></h3>
                            <p class="text-gray-600 text-sm"><?= $feature['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="py-20 bg-paint-cream-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-paint-green-700 mb-4">
                    Principais Serviços
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($services as $service): ?>
                    <div class="card group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="card-body p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-paint-green-600 transition-colors">
                                <?= $service['title'] ?>
                            </h3>
                            <p class="text-gray-600 mb-4"><?= $service['description'] ?></p>
                            <a
                                href="<?= $service['link'] ?>"
                                class="text-paint-green-600 hover:text-paint-green-700 font-medium inline-flex items-center"
                            >
                                Saiba mais <i class="bi bi-arrow-right ml-1 h-4 w-4"></i>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-paint-green-700 mb-4">
                    REPRESENTANTES
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="card p-8 bg-paint-cream-50">
                    <div class="card-body p-0 text-center">
                        <div class="w-16 h-16 bg-paint-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">MN</span>
                        </div>
                        <p class="text-gray-600 mb-4 italic">
                            "Há 6 anos este é meu principal fornecedor. Foi sem dúvida uma das melhores escolhas que já fizemos por entregar um produto final sempre dentro das nossas expectativas."
                        </p>
                        <h4 class="font-semibold text-gray-900">MARCOS INÁCIO</h4>
                    </div>
                </div>

                <div class="card p-8 bg-paint-cream-50">
                    <div class="card-body p-0 text-center">
                        <div class="w-16 h-16 bg-paint-green-600 rounded-full mx-auto mb-4 flex items-center justify-center">
                            <span class="text-white font-bold text-xl">FF</span>
                        </div>
                        <p class="text-gray-600 mb-4 italic">
                            "Contratei a empresa da Cidade de São Paulo que veio fazer o serviço aqui na Bahia. Desde 2022, trabalho sempre com eles. São os únicos que fazem um trabalho de excelência."
                        </p>
                        <h4 class="font-semibold text-gray-900">BRUNO TEILOR</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>

    <?php
    // Inclui o rodapé da página
    // Você precisará criar o arquivo footer.php
    include 'footer.php';
    ?>
</div>