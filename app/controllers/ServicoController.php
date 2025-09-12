<?php
namespace App\Controllers;

use App\Core\Controller;

use App\Repositories\ServicoRepository;

class ServicoController extends Controller
{
    public function index(): void
    {
        $repo = new ServicoRepository();
        $servicos = $repo->all();
        $this->view('servicos/index', compact('servicos'));
    }
}
