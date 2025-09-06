<?php
declare(strict_types=1);

require_once __DIR__ . '/Servico.php';

class Tinta extends Servico
{
    public function __construct(
        string $icone,
        string $titulo,
        string $descricao,
        array $caracteristicas = [],
        private string $background = '#ffffff'
    ) {
        parent::__construct($icone, $titulo, $descricao, $caracteristicas);
    }

    public function render(): string
    {
        $lista = '';
        foreach ($this->getCaracteristicas() as $item) {
            $lista .= "<li><i class='bi bi-check-circle-fill text-success me-2'></i>{$item}</li>";
        }

        return "
        <div class='col-12 col-md-6 col-lg-4'>
            <div class='card h-100 shadow-sm border-0' style='background-color: {$this->background};'>
                <div class='card-body text-center'>
                    <i class='{$this->getIcone()} mb-3' style='font-size: 2.5rem;'></i>
                    <h5 class='card-title fw-bold'>{$this->getTitulo()}</h5>
                    <p class='card-text'>{$this->getDescricao()}</p>
                    <ul class='list-unstyled text-start'>{$lista}</ul>
                </div>
            </div>
        </div>
        ";
    }
}
