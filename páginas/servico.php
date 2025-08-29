<?php
class Servico {
    public $icone;
    public $titulo;
    public $descricao;
    public $itens; // array de strings

    public function __construct($icone, $titulo, $descricao, $itens = []) {
        $this->icone = $icone;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->itens = $itens;
    }

    // Renderiza o card HTML
    public function renderCard() {
        echo "<div class='col'>
                <div class='card h-100 p-4 border-0 shadow-sm'>
                    <div class='text-success mb-3'><i class='{$this->icone}'></i></div>
                    <h5 class='fw-bold'>{$this->titulo}</h5>
                    <p>{$this->descricao}</p>
                    <ul class='list-unstyled text-muted small'>";
        foreach ($this->itens as $item) {
            echo "<li><i class='bi bi-check-circle text-success me-2'></i>$item</li>";
        }
        echo "</ul>
                </div>
              </div>";
    }
}
