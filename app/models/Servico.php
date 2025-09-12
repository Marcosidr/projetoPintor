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
        /**
         * Modelo simples usado apenas como DTO temporário para mock de serviços.
         * @deprecated Será removido quando Serviços vierem do banco e o HTML for movido para partial (ver tarefa 'Refatorar Servico::render').
         */

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

    // Método render removido: responsabilidade movida para partial de view `servicos/_card.php`.
}
