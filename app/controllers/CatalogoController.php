<?php
require_once ROOT_PATH . 'app/Models/CatalogoManager.php';

class CatalogoController
{
    public function index()
    {
        $itens = CatalogoManager::getItens();
        view('catalogos/index', compact('itens'));
    }
}
