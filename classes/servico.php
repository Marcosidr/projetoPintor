<?php
declare(strict_types=1);

class Servico
{
    public function __construct(
        private string $icone,
        private string $titulo,
        private string $descricao,
        private array $caracteristicas
    ) {}

    public function getIcone(): string
    {
        return $this->icone;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }

    public function getCaracteristicas(): array
    {
        return $this->caracteristicas;
    }

    public function render(): string
    {
        $lista = '';
        foreach ($this->caracteristicas as $item) {
            $lista .= "<li><i class='bi bi-check-circle-fill text-success me-2'></i>{$item}</li>";
        }



        return <<<HTML
        <div class="card shadow-sm p-3 mb-4 rounded-3 hover-scale flex-fill">
            <div class="card-body d-flex flex-column">
                <div class="text-center mb-3">
                    <i class="{$this->icone} fs-1 text-success"></i>
                </div>
                <h5 class="card-title text-center">{$this->titulo}</h5>
                <p class="card-text text-muted text-center">{$this->descricao}</p>
                <ul class="list-unstyled small flex-grow-1">{$lista}</ul>
                <div class="text-center mt-3">
                    <button class="btn btn-success rounded-pill px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
                        Solicitar Orçamento
                    </button>
                </div>
            </div>
        </div>
        HTML;
    }
}
