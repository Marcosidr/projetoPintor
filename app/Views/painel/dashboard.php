<?php

require_once ROOT_PATH . 'app/Models/User.php';
require_once ROOT_PATH . 'app/Models/Orcamento.php';
require_once ROOT_PATH . 'app/Models/Log.php';
require_once ROOT_PATH . 'app/Middleware/AuthMiddleware.php';

class DashboardController {
    public function index() {
        AuthMiddleware::requireLogin(); // ou requireAdmin se quiser só admin

        // MESMA IDEIA DO ANTIGO DASHBOARD
        $totalUsuarios   = User::count();
        $totalOrcamentos = Orcamento::count();
        $totalLogsHoje   = Log::countHoje();
        $totalAdmins     = User::countAdmins();
        $grafico         = Orcamento::ultimos7Dias();
        $usuarios        = User::all();
        $logsRecentes    = Log::recentes(5);

        view('painel/dashboard', compact(
            'totalUsuarios',
            'totalOrcamentos',
            'totalLogsHoje',
            'totalAdmins',
            'grafico',
            'usuarios',
            'logsRecentes'
        ));
    }
}
?>
<div class="container my-5">
    <h1 class="text-center mb-4">Dashboard</h1>

    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6 class="mb-1 text-muted">Usuários</h6>
                <h3><?= $totalUsuarios ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6 class="mb-1 text-muted">Orçamentos</h6>
                <h3><?= $totalOrcamentos ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6 class="mb-1 text-muted">Logs Hoje</h6>
                <h3><?= $totalLogsHoje ?></h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 shadow-sm">
                <h6 class="mb-1 text-muted">Admins</h6>
                <h3><?= $totalAdmins ?></h3>
            </div>
        </div>
    </div>

    <h5 class="mt-4">Orçamentos (últimos 7 dias)</h5>
    <div class="card p-3 mb-4">
        <div class="d-flex flex-wrap gap-3">
            <?php foreach ($grafico as $dia => $qt): ?>
                <div class="text-center">
                    <div class="fw-bold"><?= date('d/m', strtotime($dia)) ?></div>
                    <div><?= $qt ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <h5>Logs Recentes</h5>
    <div class="card p-3 mb-4">
        <ul class="mb-0">
            <?php foreach ($logsRecentes as $l): ?>
                <li><?= htmlspecialchars($l['datahora']) ?> - <?= htmlspecialchars($l['acao'] ?? '') ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <h5>Usuários</h5>
    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Criado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['nome']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['tipo']) ?></td>
                        <td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>