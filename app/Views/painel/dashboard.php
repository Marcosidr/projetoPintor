<?php /* View: painel/dashboard - recebe variáveis do DashboardController */ ?>
<div class="container my-5">
    <h1 class="text-center mb-2">Dashboard</h1>
    <p class="text-center text-muted mb-4">Bem-vindo, <?= htmlspecialchars($usuario ?? 'Usuário') ?></p>

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
            <?php if (!empty($logsRecentes)): ?>
                <?php foreach ($logsRecentes as $l): ?>
                    <li><?= htmlspecialchars($l['datahora']) ?> - <?= htmlspecialchars($l['acao'] ?? '') ?></li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="text-muted">Sem logs recentes.</li>
            <?php endif; ?>
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
                <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?= $u['id'] ?></td>
                        <td><?= htmlspecialchars($u['nome']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><?= htmlspecialchars($u['tipo']) ?></td>
                        <td><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr><td colspan="5" class="text-center text-muted">Nenhum usuário encontrado.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>