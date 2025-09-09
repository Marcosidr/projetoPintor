<?php
session_start();
require_once __DIR__ . "/../bin/config.php";

// Proteção
if (empty($_SESSION["usuario"]) || $_SESSION["usuario"]["tipo"] !== "admin") {
    header("Location: login.php");
    exit;
}

/* ===== CARDS ===== */
$totalUsuarios   = (int)$pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$totalOrcamentos = (int)$pdo->query("SELECT COUNT(*) FROM orcamentos")->fetchColumn();
$totalLogsHoje   = (int)$pdo->query("SELECT COUNT(*) FROM logs WHERE DATE(datahora) = CURDATE()")->fetchColumn();
$totalAdmins     = (int)$pdo->query("SELECT COUNT(*) FROM usuarios WHERE tipo = 'admin'")->fetchColumn();

/* ===== GRÁFICO (últimos 7 dias de orçamentos) ===== */
$stmt = $pdo->query("
    SELECT DATE(criado_em) AS dia, COUNT(*) AS total
    FROM orcamentos
    WHERE criado_em >= CURDATE() - INTERVAL 6 DAY
    GROUP BY DATE(criado_em)
    ORDER BY dia ASC
");
$labels = [];
$valores = [];
$periodo = new DatePeriod(new DateTime('-6 days'), new DateInterval('P1D'), new DateTime('+1 day'));
$map = [];
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) { $map[$row['dia']] = (int)$row['total']; }
foreach ($periodo as $data) {
    $dia = $data->format('Y-m-d');
    $labels[]  = $data->format('d/m');
    $valores[] = $map[$dia] ?? 0;
}

/* ===== LISTA DE USUÁRIOS ===== */
$usuarios = $pdo->query("SELECT id, nome, email, tipo FROM usuarios ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Painel Administrativo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
        margin: 0;
        background: #f5f5f5;
        display: flex;
        font-family: Arial, sans-serif;
    }
    .sidebar {
        width: 240px;
        background: #2e7d32;
        color: #fff;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        padding: 20px 0;
    }
    .sidebar h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .sidebar a {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 12px 20px;
        color: #fff;
        text-decoration: none;
        cursor: pointer;
    }
    .sidebar a:hover {
        background: rgba(255, 255, 255, .15);
    }
    .sidebar .bottom {
        margin-top: auto;
    }
    .content {
        margin-left: 240px;
        flex: 1;
        padding: 20px;
        min-height: 100vh;
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }
    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
    }
    .dashboard-card {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
    }
    .dashboard-card i {
        font-size: 32px;
        color: #2e7d32;
        margin-bottom: 10px;
    }
    .dashboard-card div {
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .grafico-container {
        background: #fff;
        border-radius: 12px;
        padding: 20px;
        margin: 20px 0;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
    }
    table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
    }
    th, td {
        padding: 12px 15px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    th {
        background: #2e7d32;
        color: #fff;
    }
    tr:hover { background: #f9f9f9; }
    #sucessoOverlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, .7);
        justify-content: center;
        align-items: center;
        z-index: 2000;
        flex-direction: column;
        color: #fff;
        text-align: center;
    }
    .checkmark { animation: pop .25s ease-out; }
    @keyframes pop {
        from { transform: scale(.8); opacity: 0 }
        to   { transform: scale(1); opacity: 1 }
    }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>CLPinturas</h2>
        <a onclick="showTab('dashboard')"><i class="bi bi-speedometer2"></i><span>Dashboard</span></a>
        <a onclick="showTab('usuarios')"><i class="bi bi-gear"></i><span>Gerenciar Usuários</span></a>
        <div class="bottom">
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i><span>Sair</span></a>
        </div>
    </div>

    <!-- Conteúdo -->
    <div class="content">
        <!-- Botão canto superior direito -->
        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalAdicionar">
                <i class="bi bi-person-plus"></i> Adicionar Usuário
            </button>
        </div>

        <!-- DASHBOARD -->
        <div id="dashboard" class="tab-content active">
            <div class="dashboard">
                <div class="dashboard-card"><i class="bi bi-people"></i>
                    <div><?= $totalUsuarios ?></div><small>Usuários cadastrados</small>
                </div>
                <div class="dashboard-card"><i class="bi bi-file-earmark-text"></i>
                    <div><?= $totalOrcamentos ?></div><small>Orçamentos</small>
                </div>
                <div class="dashboard-card"><i class="bi bi-bar-chart"></i>
                    <div><?= $totalLogsHoje ?></div><small>Acessos hoje</small>
                </div>
                <div class="dashboard-card"><i class="bi bi-person-badge"></i>
                    <div><?= $totalAdmins ?></div><small>Administradores</small>
                </div>
            </div>
            <div class="grafico-container">
                <h4>Orçamentos últimos 7 dias</h4>
                <canvas id="grafico" style="max-height:350px"></canvas>
            </div>
        </div>

        <!-- GERENCIAR USUÁRIOS -->
        <div id="usuarios" class="tab-content">
            <h3 class="mb-3">Gerenciar Usuários</h3>
            <table>
                <thead>
                    <tr>
                        <th style="width:80px">ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th style="width:140px">Tipo</th>
                        <th style="width:280px">Ações</th>
                    </tr>
                </thead>
                <tbody id="tbodyUsuarios">
                    <?php foreach ($usuarios as $u): ?>
                    <tr data-id="<?= $u['id'] ?>">
                        <td><?= $u['id'] ?></td>
                        <td class="col-nome"><?= htmlspecialchars($u['nome']) ?></td>
                        <td class="col-email"><?= htmlspecialchars($u['email']) ?></td>
                        <td class="col-tipo"><?= ucfirst($u['tipo']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning me-2" onclick="abrirEditar(<?= $u['id'] ?>)">
                                <i class="bi bi-pencil-square"></i> Editar
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="resetarSenha(<?= $u['id'] ?>)">
                                <i class="bi bi-arrow-counterclockwise"></i> Resetar Senha
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Editar Usuário -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;">
          <form id="formEditar">
            <div class="modal-header" style="background:#2e7d32;color:#fff;">
              <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Editar Usuário</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <input type="hidden" name="id" id="editId">
              <div class="mb-3"><label class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" id="editNome" required>
              </div>
              <div class="mb-3"><label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="editEmail" required>
              </div>
              <div class="mb-3"><label class="form-label">Tipo</label>
                <select class="form-select" name="tipo" id="editTipo">
                  <option value="cliente">Cliente</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #e0e0e0;">
              <button class="btn btn-success" type="submit"><i class="bi bi-check-circle"></i> Salvar</button>
              <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Adicionar Usuário -->
    <div class="modal fade" id="modalAdicionar" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;">
          <form id="formAdicionar">
            <div class="modal-header" style="background:#2e7d32;color:#fff;">
              <h5 class="modal-title"><i class="bi bi-person-plus"></i> Adicionar Usuário</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3"><label class="form-label">Nome</label>
                <input type="text" class="form-control" name="nome" required>
              </div>
              <div class="mb-3"><label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="mb-3"><label class="form-label">Tipo</label>
                <select class="form-select" name="tipo">
                  <option value="cliente">Cliente</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
              <div class="mb-3"><label class="form-label">Senha</label>
                <input type="password" class="form-control" name="senha" required>
              </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid #e0e0e0;">
              <button class="btn btn-success" type="submit"><i class="bi bi-check-circle"></i> Salvar</button>
              <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Overlay de sucesso -->
    <div id="sucessoOverlay">
        <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" width="100" height="100">
            <circle cx="26" cy="26" r="25" fill="none" stroke="#4CAF50" stroke-width="4" />
            <path fill="none" stroke="#4CAF50" stroke-width="4" d="M14 27l7 7 16-16" />
        </svg>
        <p id="overlayMsg" class="mt-3 fs-4 fw-bold"></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function showTab(tab) {
        document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
        document.getElementById(tab).classList.add('active');
    }
    const ctx = document.getElementById('grafico').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: [{
                label: 'Orçamentos',
                data: <?= json_encode($valores) ?>,
                fill: true,
                borderColor: 'rgba(46,125,50,1)',
                backgroundColor: 'rgba(46,125,50,0.1)',
                tension: .3,
                pointBackgroundColor: 'rgba(46,125,50,1)',
                pointRadius: 5
            }]
        },
        options: { plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true,grid:{color:'#eee'}},x:{grid:{color:'#f5f5f5'}} } }
    });
    function mostrarOverlay(msg) {
        document.getElementById('overlayMsg').innerText = msg || 'Operação concluída!';
        const ov = document.getElementById('sucessoOverlay');
        ov.style.display = 'flex';
        setTimeout(() => { ov.style.display = 'none'; }, 1600);
    }
    async function fetchJSON(url, options = {}) {
        const res = await fetch(url, options);
        const ct = res.headers.get('content-type') || '';
        if (!ct.includes('application/json')) {
            const text = await res.text();
            throw new Error('Resposta não JSON: ' + text.slice(0, 200));
        }
        const data = await res.json();
        if (data.status && data.status !== 'success') throw new Error(data.msg || 'Erro');
        return data;
    }
    const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
    async function abrirEditar(id) {
        try {
            const user = await fetchJSON(`../admin/editar.php?id=${id}`);
            document.getElementById('editId').value = user.id;
            document.getElementById('editNome').value = user.nome;
            document.getElementById('editEmail').value = user.email;
            document.getElementById('editTipo').value = user.tipo;
            modalEditar.show();
        } catch (e) { alert('Erro ao carregar usuário: ' + e.message); }
    }
    document.getElementById('formEditar').addEventListener('submit', async (e) => {
        e.preventDefault();
        try {
            const form = e.target;
            await fetchJSON('../admin/editar.php', { method: 'POST', body: new FormData(form) });
            modalEditar.hide();
            const id = form.editId ? form.editId.value : document.getElementById('editId').value;
            const tr = document.querySelector(`tr[data-id="${id}"]`);
            if (tr) {
                tr.querySelector('.col-nome').innerText = document.getElementById('editNome').value;
                tr.querySelector('.col-email').innerText = document.getElementById('editEmail').value;
                tr.querySelector('.col-tipo').innerText = (document.getElementById('editTipo').value || '').replace(/^./, c => c.toUpperCase());
            }
            mostrarOverlay('Usuário atualizado com sucesso!');
        } catch (e) { alert('Erro ao salvar: ' + e.message); }
    });
    let modalResetar = null, resetarId = null;
    function criarModalResetar() {
      if (modalResetar) return;
      const modalHtml = `
      <div class="modal fade" id="modalResetar" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:12px;">
        <div class="modal-header" style="background:#2e7d32;color:#fff;">
          <h5 class="modal-title"><i class="bi bi-arrow-counterclockwise"></i> Resetar Senha</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>Digite a nova senha para o usuário:</p>
          <input type="password" id="novaSenha" class="form-control" placeholder="Nova senha">
        </div>
        <div class="modal-footer">
          <button class="btn btn-success" id="confirmResetar"><i class="bi bi-check-circle"></i> Confirmar</button>
          <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
        </div>
        </div></div></div>`;
      document.body.insertAdjacentHTML('beforeend', modalHtml);
      modalResetar = new bootstrap.Modal(document.getElementById('modalResetar'));
      document.getElementById('confirmResetar').addEventListener('click', async () => {
        const senha = document.getElementById('novaSenha').value;
        if (!senha) return alert('Informe a nova senha');
        try {
          await fetchJSON('../admin/resetar.php', { method: 'POST', body: new URLSearchParams({ id: resetarId, senha }) });
          modalResetar.hide();
          mostrarOverlay('Senha redefinida!');
        } catch (e) { alert('Erro: ' + e.message); }
      });
    }
    function resetarSenha(id) { resetarId = id; criarModalResetar(); modalResetar.show(); }
    const formAdicionar = document.getElementById('formAdicionar');
    formAdicionar.addEventListener('submit', async (e) => {
      e.preventDefault();
      try {
        const dados = new FormData(formAdicionar);
        const resp = await fetchJSON('../admin/adicionar.php', { method: 'POST', body: dados });
        const novo = resp.usuario;
        const tbody = document.getElementById('tbodyUsuarios');
        const tr = document.createElement('tr');
        tr.setAttribute('data-id', novo.id);
        tr.innerHTML = `
          <td>${novo.id}</td>
          <td class="col-nome">${novo.nome}</td>
          <td class="col-email">${novo.email}</td>
          <td class="col-tipo">${(novo.tipo||'').replace(/^./, c=>c.toUpperCase())}</td>
          <td>
            <button class="btn btn-sm btn-warning me-2" onclick="abrirEditar(${novo.id})">
              <i class="bi bi-pencil-square"></i> Editar
            </button>
            <button class="btn btn-sm btn-danger" onclick="resetarSenha(${novo.id})">
              <i class="bi bi-arrow-counterclockwise"></i> Resetar Senha
            </button>
          </td>`;
        tbody.prepend(tr);
        bootstrap.Modal.getInstance(document.getElementById('modalAdicionar')).hide();
        formAdicionar.reset();
        mostrarOverlay('Usuário adicionado com sucesso!');
      } catch (e) { alert('Erro ao adicionar: ' + e.message); }
    });
    </script>
</body>
</html>
