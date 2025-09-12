<?php /* View: painel/dashboard - nova UI moderna */ ?>
<div class="dashboard-wrapper">
  <header class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-2">
      <div>
          <h1 class="h3 mb-0 fw-semibold">Painel</h1>
          <small class="text-muted">Bem-vindo, <?= htmlspecialchars($usuario ?? 'Usuário') ?></small>
      </div>
      <div class="d-flex gap-2">
          <?php if(\App\Core\Auth::checkAdmin()): ?>
              <span class="badge bg-danger align-self-start">Admin</span>
              <button class="btn btn-sm btn-primary" id="btnNovoUsuario"><i class="bi bi-person-plus"></i> Novo Usuário</button>
          <?php endif; ?>
      </div>
  </header>

  <div class="row g-3 mb-4">
      <div class="col-6 col-lg-3">
          <div class="card metric-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center gap-3">
                  <div class="icon-circle bg-primary-subtle text-primary"><i class="bi bi-people-fill"></i></div>
                  <div>
                      <div class="small text-muted">Usuários</div>
                      <div class="fs-4 fw-semibold" id="metricTotalUsuarios"><?= $totalUsuarios ?></div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-6 col-lg-3">
          <div class="card metric-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center gap-3">
                  <div class="icon-circle bg-warning-subtle text-warning"><i class="bi bi-shield-lock-fill"></i></div>
                  <div>
                      <div class="small text-muted">Admins</div>
                      <div class="fs-4 fw-semibold" id="metricTotalAdmins"><?= $totalAdmins ?></div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-6 col-lg-3">
          <div class="card metric-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center gap-3">
                  <div class="icon-circle bg-success-subtle text-success"><i class="bi bi-file-earmark-text-fill"></i></div>
                  <div>
                      <div class="small text-muted">Orçamentos</div>
                      <div class="fs-4 fw-semibold" id="metricTotalOrcamentos"><?= $totalOrcamentos ?></div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-6 col-lg-3">
          <div class="card metric-card border-0 shadow-sm h-100">
              <div class="card-body d-flex align-items-center gap-3">
                  <div class="icon-circle bg-info-subtle text-info"><i class="bi bi-clock-history"></i></div>
                  <div>
                      <div class="small text-muted">Logs Hoje</div>
                      <div class="fs-4 fw-semibold" id="metricTotalLogsHoje"><?= $totalLogsHoje ?></div>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="row g-4 mb-4">
      <div class="col-lg-8">
          <div class="card shadow-sm h-100">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
                  <h6 class="mb-0 fw-semibold"><i class="bi bi-graph-up-arrow me-1"></i> Orçamentos (últimos 7 dias)</h6>
              </div>
              <div class="card-body">
                  <canvas id="chartOrcamentos7d" height="140" aria-label="Gráfico de orçamentos últimos 7 dias" role="img"></canvas>
                  <script id="graficoData" type="application/json"><?= json_encode($grafico, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) ?></script>
                  <noscript><p class="text-muted small">Ative JavaScript para ver o gráfico.</p></noscript>
              </div>
          </div>
      </div>
      <div class="col-lg-4">
          <div class="card shadow-sm h-100">
              <div class="card-header bg-transparent py-2">
                  <h6 class="mb-0 fw-semibold"><i class="bi bi-journal-text me-1"></i> Logs Recentes</h6>
              </div>
              <div class="card-body p-0">
                  <ul class="list-group list-group-flush small" id="listaLogsRecentes">
                      <?php if (!empty($logsRecentes)): ?>
                          <?php foreach ($logsRecentes as $l): $dh = $l['datahora'] ?? $l['ts'] ?? $l['created_at'] ?? ''; ?>
                              <li class="list-group-item d-flex justify-content-between align-items-start">
                                  <span class="text-truncate" style="max-width: 70%" title="<?= htmlspecialchars($l['acao'] ?? '') ?>"><?= htmlspecialchars($l['acao'] ?? '') ?></span>
                                  <span class="text-muted ms-2 small"><?= htmlspecialchars($dh) ?></span>
                              </li>
                          <?php endforeach; ?>
                      <?php else: ?>
                          <li class="list-group-item text-muted">Sem logs</li>
                      <?php endif; ?>
                  </ul>
              </div>
          </div>
      </div>
  </div>

  <div class="card shadow-sm mb-5" id="cardUsuarios">
      <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
          <h6 class="mb-0 fw-semibold"><i class="bi bi-people me-1"></i> Usuários</h6>
          <?php if(\App\Core\Auth::checkAdmin()): ?><button class="btn btn-sm btn-outline-primary" id="btnNovoUsuario2"><i class="bi bi-plus-circle"></i> Novo</button><?php endif; ?>
      </div>
      <div class="card-body p-0">
          <div class="table-responsive">
              <table class="table table-hover table-sm align-middle mb-0" id="tabelaUsuarios">
                  <thead class="table-light">
                      <tr>
                          <th>ID</th>
                          <th>Nome</th>
                          <th>Email</th>
                          <th>Tipo</th>
                          <th>Criado</th>
                          <?php if(\App\Core\Auth::checkAdmin()): ?><th class="text-center" style="width:160px">Ações</th><?php endif; ?>
                      </tr>
                  </thead>
                  <tbody>
                      <?php if (!empty($usuarios)): ?>
                          <?php foreach ($usuarios as $u): ?>
                              <tr data-user-id="<?= $u['id'] ?>">
                                  <td><?= $u['id'] ?></td>
                                  <td class="user-nome"><?= htmlspecialchars($u['nome']) ?></td>
                                  <td class="user-email"><?= htmlspecialchars($u['email']) ?></td>
                                  <td><span class="badge bg-<?= $u['tipo']==='admin'?'danger':'secondary' ?> user-tipo"><?= htmlspecialchars($u['tipo']) ?></span></td>
                                  <td class="small text-muted user-criado"><?= htmlspecialchars($u['created_at'] ?? '') ?></td>
                                  <?php if(\App\Core\Auth::checkAdmin()): ?>
                                  <td class="text-center">
                                      <div class="btn-group btn-group-sm" role="group">
                                          <button class="btn btn-outline-secondary btn-edit" title="Editar"><i class="bi bi-pencil-square"></i></button>
                                          <button class="btn btn-outline-warning btn-toggle" title="Toggle Admin"><i class="bi bi-shield-lock"></i></button>
                                          <button class="btn btn-outline-secondary btn-reset" title="Reset Senha"><i class="bi bi-key"></i></button>
                                          <button class="btn btn-outline-danger btn-delete" title="Excluir"><i class="bi bi-trash"></i></button>
                                      </div>
                                  </td>
                                  <?php endif; ?>
                              </tr>
                          <?php endforeach; ?>
                      <?php else: ?>
                          <tr><td colspan="6" class="text-center text-muted py-3">Nenhum usuário.</td></tr>
                      <?php endif; ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<?php if(\App\Core\Auth::checkAdmin()): ?>
<!-- Modal Form Usuário -->
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <form id="formUsuario" novalidate>
              <div class="modal-header">
                  <h5 class="modal-title" id="tituloModalUsuario">Novo Usuário</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id" id="usuarioId">
                  <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
                  <div class="mb-3">
                      <label class="form-label">Nome</label>
                      <input type="text" name="nome" id="usuarioNome" class="form-control" required minlength="2" maxlength="100">
                      <div class="invalid-feedback">Informe o nome (mínimo 2 caracteres)</div>
                  </div>
                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" id="usuarioEmail" class="form-control" required maxlength="150">
                      <div class="invalid-feedback">Email inválido.</div>
                  </div>
                  <div class="row g-2">
                      <div class="col-sm-6">
                          <label class="form-label">Tipo</label>
                          <select name="tipo" id="usuarioTipo" class="form-select">
                              <option value="user">User</option>
                              <option value="admin">Admin</option>
                          </select>
                      </div>
                      <div class="col-sm-6">
                          <label class="form-label">Senha <small class="text-muted" id="labelSenhaHint">(mín. 6)</small></label>
                          <input type="password" name="senha" id="usuarioSenha" class="form-control" minlength="6" autocomplete="new-password">
                          <div class="invalid-feedback">Senha muito curta.</div>
                      </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-primary" id="btnSalvarUsuario"><i class="bi bi-check2"></i> Salvar</button>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- Toast Container -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1080" id="toastStack" aria-live="polite" aria-atomic="true"></div>
<?php endif; ?>

<style>
  .metric-card .icon-circle { width:48px; height:48px; display:flex; align-items:center; justify-content:center; font-size:1.3rem; border-radius:50%; }
  .dashboard-wrapper { animation: fadeIn .35s ease; }
  @keyframes fadeIn { from { opacity:0; transform: translateY(4px);} to { opacity:1; transform: translateY(0);} }
</style>