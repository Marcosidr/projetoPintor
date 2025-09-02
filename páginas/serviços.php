<?php
declare(strict_types=1);

namespace App\Services;

/**
 * Classe que representa um serviço oferecido pela empresa.
 */
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

    /**
     * @return string[]
     */
    public function getCaracteristicas(): array
    {
        return $this->caracteristicas;
    }

    /**
     * Renderiza o serviço em HTML.
     */
    public function render(): string
    {
        $lista = '';
        foreach ($this->caracteristicas as $item) {
            $lista .= "<li>{$item}</li>";
        }

        return <<<HTML
            <div class="card shadow-sm p-3 mb-4 rounded-3">
                <div class="card-body">
                    <i class="{$this->icone} fs-2 text-primary"></i>
                    <h5 class="card-title mt-2">{$this->titulo}</h5>
                    <p class="card-text">{$this->descricao}</p>
                    <ul>{$lista}</ul>
                </div>
            </div>
        HTML;
    }
}
