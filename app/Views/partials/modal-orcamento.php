<?php
// app/Views/partials/modal-orcamento.php
?>
<!-- MODAL DE ORÇAMENTO -->
<div class="modal fade" id="orcamentoModal" tabindex="-1" aria-labelledby="orcamentoModalLabel" role="dialog" aria-modal="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formOrcamento" method="POST" action="<?= BASE_URL ?>/orcamento">
        <?php if (!function_exists('csrf_field')) { function csrf_field(): string { return '<input type="hidden" name="_csrf" value="'.htmlspecialchars(\App\Core\Csrf::token(), ENT_QUOTES,'UTF-8').'">'; } } ?>
        <?= csrf_field(); ?>
        <div class="modal-header">
          <h5 class="modal-title" id="orcamentoModalLabel">Quer um orçamento sem compromisso?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">

          <!-- Área de mensagem -->
          <?php
            use App\Core\Session;
            $erroOrc = Session::get('erro_orcamento');
            $okOrc = Session::get('sucesso_orcamento');
            if ($erroOrc) { echo '<div class="alert alert-danger">'.htmlspecialchars($erroOrc).'</div>'; Session::remove('erro_orcamento'); }
            if ($okOrc) { echo '<div class="alert alert-success">'.htmlspecialchars($okOrc).'</div>'; Session::remove('sucesso_orcamento'); }
          ?>

          <!-- Campos do formulário -->
          <div class="mb-3">
            <label>Nome Completo *</label>
            <input type="text" class="form-control" name="nome" required>
          </div>

          <div class="mb-3">
            <label>Email *</label>
            <input type="email" class="form-control" name="email" required>
          </div>

          <div class="mb-3">
            <label>Telefone *</label>
            <input type="tel" class="form-control" name="telefone" required placeholder="Ex: 44998008156">
          </div>

          <div class="mb-3">
            <label>Endereço da Obra *</label>
            <input type="text" class="form-control" name="endereco" required>
          </div>

          <div class="mb-3">
            <label>Tipo de Imóvel *</label>
            <select class="form-select" name="tipoImovel" required>
              <option value="">Selecione</option>
              <option>Residencial - Casa</option>
              <option>Residencial - Apartamento</option>
              <option>Comercial - Escritório</option>
              <option>Comercial - Loja</option>
              <option>Industrial</option>
              <option>Outro</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Tipo de Serviço *</label>
            <select class="form-select" name="tipoServico" required>
              <option value="">Selecione</option>
              <option>Pintura Interna</option>
              <option>Pintura Externa</option>
              <option>Pintura Interna e Externa</option>
              <option>Impermeabilização</option>
              <option>Textura/Grafiato</option>
              <option>Revestimento Especial</option>
              <option>Restauração</option>
              <option>Manutenção</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Área Aproximada (m²)</label>
            <input type="number" class="form-control" name="area">
          </div>

          <div class="mb-3">
            <label>Urgência</label>
            <select class="form-select" name="urgencia">
              <option value="">Selecione</option>
              <option value="baixa">Baixa - Posso aguardar</option>
              <option value="media">Média - Até 30 dias</option>
              <option value="alta">Alta - Até 15 dias</option>
              <option value="urgente">Urgente - Até 7 dias</option>
            </select>
          </div>

          <div class="mb-3">
            <label>Necessidades Adicionais</label><br>
            <?php
              $opcoes = [
                "Preparação de superfície",
                "Remoção de papel de parede",
                "Correção de rachaduras",
                "Aplicação de massa corrida",
                "Proteção de móveis",
                "Limpeza pós-obra",
                "Consultoria de cores",
                "Projeto de acabamento"
              ];
              foreach ($opcoes as $opt) {
                echo "<div class='form-check'>
                        <input class='form-check-input' type='checkbox' name='necessidades[]' value='$opt'>
                        <label class='form-check-label'>$opt</label>
                      </div>";
              }
            ?>
          </div>

          <div class="mb-3">
            <label>Observações</label>
            <textarea class="form-control" name="observacoes" rows="4"></textarea>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Solicitar Orçamento</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Overlay de sucesso -->
<div id="sucessoOverlay">
  <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
    <path class="checkmark__check" fill="none" d="M14 27l7 7 16-16"/>
  </svg>
  <p>✅ Enviado com sucesso!</p>
</div>

<!-- Estilos e scripts foram movidos para arquivos centrais (style.css / layout) para reduzir inline e respeitar CSP -->
