<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\CatalogoRepository;

class CatalogoController extends Controller
{
    public function index(): void
    {
        $repo = new CatalogoRepository();
        $itens = $repo->all();
        $this->view('catalogos/index', compact('itens'));
    }
}
