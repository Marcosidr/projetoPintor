<?php /* View: admin/servicos - gerenciamento de serviços */ ?>
<?php $isAdmin = \App\Core\Auth::checkAdmin(); ?>
<div class="admin-servicos-wrapper" id="painelRoot" data-is-admin="<?= $isAdmin ? '1':'0' ?>">
  <header class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-4 gap-2">
      <div>
          <h1 class="h4 mb-0 fw-semibold" style="margin-bottom: 0; color: #2e7d32;">Serviços</h1>
          <span><small class="text-muted">Gerencie os serviços exibidos no site</small></span>
      </div>
      <div class="d-flex gap-2">
          
      </div>
  </header>

  <div class="card shadow-sm mb-5" id="cardServicos">
      <div class="card-header bg-transparent d-flex justify-content-between align-items-center py-2">
          <h6 class="mb-0 fw-semibold"><i class="bi bi-list-task me-1"></i> Lista de Serviços</h6>
          <?php if($isAdmin): ?><button class="btn btn-sm btn-success" id="btnNovoServico2"><i class="bi bi-plus-circle"></i> Novo</button><?php endif; ?>
      </div>
      <div class="card-body p-0">
          <div class="table-responsive">
              <table class="table table-hover table-sm align-middle mb-0" id="tabelaServicos">
                  <thead class="table-light">
                      <tr>
                          <th>ID</th>
                          <th>Ícone</th>
                          <th>Título</th>
                          <th>Descrição</th>
                          <th>Características</th>
                          <th style="width:140px;" class="text-center">Ações</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr><td colspan="6" class="text-center text-muted py-3">Carregando...</td></tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>

<?php if($isAdmin): ?>
<!-- Modal Form Serviço -->
<div class="modal fade" id="modalServico" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
          <form id="formServico" novalidate>
              <div class="modal-header">
                  <h5 class="modal-title" id="tituloModalServico">Novo Serviço</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
              </div>
              <div class="modal-body">
                  <input type="hidden" name="id" id="servicoId">
                  <input type="hidden" name="_csrf" value="<?= htmlspecialchars(\App\Core\Csrf::token()) ?>">
                  <div class="row g-3">
                    <div class="col-sm-4">
                        <label class="form-label">Ícone (classe)</label>
                        <input type="text" name="icone" id="servicoIcone" class="form-control" placeholder="bi bi-paint-bucket">
                        <div class="form-text small">Use classes Bootstrap Icons ou FontAwesome.</div>
                    </div>
                    <div class="col-sm-8">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" id="servicoTitulo" class="form-control" required maxlength="120">
                        <div class="invalid-feedback">Informe o título</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" id="servicoDescricao" class="form-control" rows="3" required></textarea>
                        <div class="invalid-feedback">Descrição obrigatória</div>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Características (uma por linha)</label>
                        <textarea name="caracteristicas" id="servicoCaracteristicas" class="form-control" rows="4" placeholder="Durabilidade\nAcabamento profissional\nGarantia ..."></textarea>
                    </div>
                  </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" class="btn btn-success" id="btnSalvarServico"><i class="bi bi-check2"></i> Salvar</button>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- Toast Container (reutiliza se já existir) -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index:1080" id="toastStack" aria-live="polite" aria-atomic="true"></div>
<?php endif; ?>

<?php if($isAdmin): ?>
<?php // Modal confirmação (caso usuário acesse esta view sem passar pelo dashboard que já tem o modal) ?>
<?php if (!isset($modalConfirmAdded)): $modalConfirmAdded=true; ?>
<div class="modal fade" id="modalConfirmacao" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold" id="tituloConfirmacao">Confirmar Ação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
            </div>
            <div class="modal-body pt-2">
                <div class="d-flex align-items-start gap-3">
                    <div id="iconConfirmacao" class="confirm-icon flex-shrink-0"></div>
                    <div>
                        <p class="mb-2" id="mensagemConfirmacao">Tem certeza?</p>
                        <p class="text-muted small mb-0" id="detalheConfirmacao"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger d-none" id="btnExecutarDelete"><i class="bi bi-trash me-1"></i>Excluir</button>
                <button type="button" class="btn btn-warning d-none" id="btnExecutarReset"><i class="bi bi-key me-1"></i>Resetar Senha</button>
            </div>
        </div>
    </div>
 </div>
<style>
 #modalConfirmacao .confirm-icon { width:46px; height:46px; border-radius:14px; display:flex; align-items:center; justify-content:center; font-size:1.4rem; }
 #modalConfirmacao .confirm-icon.delete { background:rgba(220,53,69,.12); color:#dc3545; }
 #modalConfirmacao .confirm-icon.reset { background:rgba(255,193,7,.18); color:#b58100; }
 #modalConfirmacao .modal-content { border-radius:1rem; }
 #modalConfirmacao .btn-warning { color:#5a4100; font-weight:600; }
 #modalConfirmacao .btn-danger { font-weight:600; }
</style>
<?php endif; ?>
<?php endif; ?>

<style>
  .admin-servicos-wrapper { animation: fadeIn .35s ease; }
  @keyframes fadeIn { from { opacity:0; transform: translateY(4px);} to { opacity:1; transform: translateY(0);} }
  #tabelaServicos td { vertical-align: top; }
  #tabelaServicos .caracts-list { list-style: disc; padding-left: 1.1rem; margin:0; }
  #tabelaServicos .caracts-list li { line-height:1.2; }
</style>
