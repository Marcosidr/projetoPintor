<?php
// Inclui o cabeçalho
include '../header.php';

// Array de serviços
$servicos = [
  [
    'titulo' => 'Pintura Interna',
    'descricao' => 'Transformamos seus ambientes internos com cores e texturas que refletem sua personalidade e estilo.'
  ],
  [
    'titulo' => 'Pintura Externa',
    'descricao' => 'Proteção e beleza para a fachada do seu imóvel, utilizando tintas resistentes às intempéries e técnicas avançadas.'
  ],
  [
    'titulo' => 'Impermeabilização',
    'descricao' => 'Soluções completas para proteger seu imóvel contra umidade, infiltrações e mofo, garantindo durabilidade e saúde.'
  ],
  [
    'titulo' => 'Texturas e Grafiatos',
    'descricao' => 'Adicione um toque de sofisticação e personalidade às suas paredes com uma variedade de texturas e grafiatos.'
  ],
  [
    'titulo' => 'Restauração de Fachadas',
    'descricao' => 'Recuperamos a beleza original de fachadas antigas, corrigindo imperfeições e aplicando acabamentos de alta qualidade.'
  ],
  [
    'titulo' => 'Pintura Comercial',
    'descricao' => 'Serviços de pintura para escritórios, lojas e outros espaços comerciais, minimizando interrupções e garantindo um resultado profissional.'
  ],
];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CLPinturas - Serviços</title>
</head>
<body>
  <div class="container my-5">
    <h1 class="text-center mb-4">Nossos Serviços</h1>
    <p class="text-center lead">
      Na CLPinturas, oferecemos uma vasta gama de serviços para atender todas as suas necessidades de pintura e acabamento.
      Nossa equipe especializada está pronta para transformar seu ambiente com qualidade e eficiência.
    </p>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-5">
      <?php foreach ($servicos as $servico): ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <h5 class="card-title text-success"><?= $servico['titulo'] ?></h5>
              <p class="card-text"><?= $servico['descricao'] ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-5">
      <p class="lead">Precisa de um serviço específico que não está listado? Entre em contato conosco!</p>
      <a href="./contato.php" class="btn btn-success btn-lg">Fale Conosco</a>
    </div>
  </div>
</body>
</html>

<?php
// Inclui o rodapé
include '../footer.php';
?>
