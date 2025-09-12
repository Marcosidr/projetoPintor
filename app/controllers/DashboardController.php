<?php
require_once ROOT_PATH . 'app/Models/User.php';
require_once ROOT_PATH . 'app/Models/Orcamento.php';
require_once ROOT_PATH . 'app/Models/Log.php';

class DashboardController {
    public function index() {
        session_start();
        if (empty($_SESSION['usuario']) || $_SESSION['usuario']['tipo'] !== 'admin') {
            header("Location: /login");
            exit;
        }

        $totalUsuarios   = User::count();
        $totalOrcamentos = Orcamento::count();
        $totalLogsHoje   = Log::countHoje();
        $totalAdmins     = User::countAdmins();

        $grafico = Orcamento::ultimos7Dias();
        $usuarios = User::all();

        view('painel/dashboard', compact('totalUsuarios', 'totalOrcamentos', 'totalLogsHoje', 'totalAdmins', 'grafico', 'usuarios'));
    }
}
