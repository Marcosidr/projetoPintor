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

        return "
        <div class='card mb-4'>
            <div class='card-body'>
                <h3 class='card-title'><i class='{$this->icone} me-2'></i>{$this->titulo}</h3>
                <p class='card-text'>{$this->descricao}</p>
                <ul class='list-unstyled'>{$lista}</ul>
            </div>
        </div>
        ";
    }
}
