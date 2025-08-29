<?php
require_once 'classes/ServicoManager.php';
require_once 'classes/Servico.php';

// Criar gerenciador
$manager = new ServicoManager();

// Adicionar serviços
$manager->addServico(new Servico(
    'bi bi-house-door',
    'Pinturas Gerais',
    'Pintura residencial e comercial com acabamento impecável',
    ['Pintura interna e externa', 'Preparação completa da superfície', 'Tintas de alta qualidade', 'Acabamento profissional']
));

$manager->addServico(new Servico(
    'bi bi-palette',
    'Pinturas Versáteis',
    'Técnicas especiais para ambientes únicos e personalizados',
    ['Técnicas decorativas', 'Efeitos especiais', 'Cores personalizadas', 'Consultoria em design']
));

// ...adicione os outros serviços da mesma forma
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/servicos.css">
  <title>Serviços</title>
</head>
<body>

<?php include 'páginas/modal-orcamento.php'; ?>

<div class="container my-5">
  <h1 class="text-center mb-4">Nossos Serviços</h1>
  <p class="text-center lead">
    Na CLPinturas, oferecemos uma vasta gama de serviços para atender todas as suas necessidades de pintura e acabamento.
    Nossa equipe especializada está pronta para transformar seu ambiente com qualidade e eficiência.
  </p>

<?php
// Renderizar todos os cards via POO
$manager->renderTodos();
?>

  <div class="text-center mt-5">
    <p class="lead">Precisa de um serviço específico que não está listado? Entre em contato conosco!</p>
    <a href="index.php?param=contato" class="btn btn-success btn-lg">Fale Conosco</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
