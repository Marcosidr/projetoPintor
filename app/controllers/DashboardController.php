<?php
namespace App\Controllers;

use App\Core\Auth; use App\Core\Controller; use App\Core\Session;

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        $usuario = (Session::get('usuario')['nome'] ?? 'Usuário');
        $this->view('painel/dashboard', compact('usuario'));
    }
}