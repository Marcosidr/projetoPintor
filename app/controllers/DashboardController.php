<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Session;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();
        $usuario = (Session::get('usuario')['nome'] ?? 'Usuário');
        $service = new DashboardService();
        $totais = $service->getTotals();
    $logsRecentes = $service->getLogsRecentes();
    $usuarios = $service->getUsuarios();
    $grafico = $service->getGraficoUltimos7Dias();
    $totalUsuarios   = $totais['totalUsuarios'];
    $totalAdmins     = $totais['totalAdmins'];
    $totalOrcamentos = $totais['totalOrcamentos'];
    $totalLogsHoje   = $totais['totalLogsHoje'];

        $this->view('painel/dashboard', compact(
            'usuario',
            'totalUsuarios',
            'totalAdmins',
            'totalOrcamentos',
            'totalLogsHoje',
            'logsRecentes',
            'usuarios',
            'grafico'
        ));
    }
}