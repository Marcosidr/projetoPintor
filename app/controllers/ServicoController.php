<?php
require_once ROOT_PATH . 'app/Models/ServicoManager.php';

class ServicoController
{
    public function index()
    {
        $servicos = ServicoManager::getServicos();
        view('servicos/index', compact('servicos'));
    }
}
