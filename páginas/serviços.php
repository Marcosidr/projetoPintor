<?php
require_once '../classes/ServicoManager.php';

// Instancia o gerenciador
$manager = new ServicoManager();

// Adiciona serviços
$manager->adicionarServico(new Servico(
    'bi bi-house-door',
    'Pinturas Gerais',
    'Pintura residencial e comercial com acabamento impecável',
    ['Pintura interna e externa', 'Preparação completa da superfície', 'Tintas de alta qualidade', 'Acabamento profissional']
));

$manager->adicionarServico(new Servico(
    'bi bi-palette',
    'Pinturas Versáteis',
    'Técnicas especiais para ambientes únicos e personalizados',
    ['Técnicas decorativas', 'Efeitos especiais', 'Cores personalizadas', 'Consultoria em design']
));

$manager->adicionarServico(new Servico(
    'bi bi-wrench',
    'Tratamento de Superfícies',
    'Preparação especializada para maior durabilidade',
    ['Lixamento e preparação', 'Correção de imperfeições', 'Aplicação de primers', 'Seladores especiais']
));

// Renderiza todos os serviços
$manager->renderTodos();
?>
