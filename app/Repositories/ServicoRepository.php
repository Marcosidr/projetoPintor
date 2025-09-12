<?php
namespace App\Repositories;

use Servico; // classe legacy sem namespace (DTO temporário)

/**
 * Repository mock: enquanto não há tabela `servicos`, retorna array em memória.
 * Futuro: substituir por SELECT * FROM servicos e mapear para objetos/arrays.
 */
class ServicoRepository {
    /**
     * Retorna lista mock (enquanto sem tabela `servicos`).
     * @deprecated substituir por leitura do banco e retorno de arrays (sem método render) após refatorar view.
     * @return Servico[]
     */
    public function all(): array {
        if (!class_exists('ServicoManager')) {
            require_once ROOT_PATH . 'app/models/ServicoManager.php';
        }
        return \ServicoManager::getServicos();
    }
}
