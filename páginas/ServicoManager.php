<?php
require_once 'Servico.php';

class ServicoManager {
    private $servicos = [];

    public function addServico(Servico $servico) {
        $this->servicos[] = $servico;
    }

    public function renderTodos() {
        echo "<div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mt-5'>";
        foreach ($this->servicos as $servico) {
            $servico->renderCard();
        }
        echo "</div>";
    }
}
