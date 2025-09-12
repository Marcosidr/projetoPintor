<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Response;

class AdminServicoController extends Controller
{
    private function guard(): void {
        if(!Auth::checkAdmin()) { Response::redirect(BASE_URL.'/painel'); }
    }

    public function index(): void
    {
        $this->guard();
        // A view já carrega via JS os dados pela API; não precisamos passar dados iniciais.
        $this->view('admin/servicos');
    }
}
