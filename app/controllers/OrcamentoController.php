<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Core\Response;
use App\Services\OrcamentoService;
use App\Services\LoggerService;

class OrcamentoController extends Controller
{
    private LoggerService $logger;
    public function __construct(private OrcamentoService $service = new OrcamentoService()) { $this->logger = new LoggerService(); }

    public function store(): void
    {
        if (!Csrf::validate($_POST['_csrf'] ?? '')) { http_response_code(419); exit('CSRF inválido'); }
        $res = $this->service->criar($_POST);
        if (!$res['ok']) {
            Session::set('erro_orcamento', $res['error']);
            $this->logger->info(null, 'orcamento_falha', ['erro'=>$res['error']]);
        } else {
            Session::set('sucesso_orcamento', 'Orçamento enviado com sucesso!');
            $this->logger->info(null, 'orcamento_sucesso', ['dados'=>[ 'nome'=>$_POST['nome'] ?? null, 'email'=>$_POST['email'] ?? null, 'telefone'=>$_POST['telefone'] ?? null ]]);
        }
        Response::redirect(BASE_URL . '/');
    }
}
