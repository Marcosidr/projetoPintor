<?php
namespace App\Controllers;

use App\Core\Controller;

use App\Repositories\ServicoRepository;
use App\Core\Env;

class ServicoController extends Controller
{
    public function index(): void
    {
        $repo = new ServicoRepository();
        $erroServicos = null;
        try {
            $servicos = $repo->all();
            if (!$servicos) {
                $servicos = [];
            }
        } catch (\Throwable $e) {
            // Possíveis causas: tabela inexistente (seed não executado), erro de conexão ou versão MySQL sem suporte JSON
            $debug = Env::get('APP_DEBUG', 'false') === 'true';
            if ($debug) {
                throw $e; // Em modo debug, re-lança para facilitar diagnóstico
            }
            $servicos = [];
            $erroServicos = 'Serviços temporariamente indisponíveis. Tente novamente mais tarde.';
        }
        $this->view('servicos/index', compact('servicos', 'erroServicos'));
    }
}
