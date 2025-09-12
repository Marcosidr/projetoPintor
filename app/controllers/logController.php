<?php
// app/controllers/LogController.php

class LogController
{
    public function index() {
        AuthMiddleware::requireAdmin(); // Protege a rota
        $filtros = $_GET;
        $logs = LogRepository::buscarComFiltros($filtros);
        view('painel/logs', [
            'logs' => $logs,
            'filtroUsuario' => $filtros['usuario'] ?? '',
            'filtroAcao' => $filtros['acao'] ?? '',
            'filtroNivel' => $filtros['nivel'] ?? '',
            'filtroDataIni' => $filtros['data_ini'] ?? '',
            'filtroDataFim' => $filtros['data_fim'] ?? '',
        ]);
    }
}