<!-- MODAL DE ORÇAMENTO -->
<div class="modal fade" id="orcamentoModal" tabindex="-1" aria-labelledby="orcamentoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!-- action atualizado -->
      <form id="formOrcamento" method="POST" action="banco/enviar_orcamento.php">
        <input type="hidden" name="formulario" value="orcamento">
        <div class="modal-header">
          <h5 class="modal-title" id="orcamentoModalLabel">Quer um orçamento sem compromisso?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">

          <!-- Área de mensagem -->
          <div id="alertaEnvio" class="alert d-none" role="alert"></div>

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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Validação e envio via AJAX -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('formOrcamento');
  const alerta = document.getElementById('alertaEnvio');

  if (!form) return;

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    // caminho ajustado
    fetch('banco/enviar_orcamento.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        alerta.className = "alert alert-success";
        alerta.textContent = "✅ Enviado com sucesso! Aguarde nosso contato.";
        alerta.classList.remove("d-none");

        // Abre WhatsApp
        const numeroWhats = '5544998008156';
        const mensagemURL = encodeURIComponent(data.mensagem);
        window.open(`https://api.whatsapp.com/send?phone=${numeroWhats}&text=${mensagemURL}`, '_blank');

        form.reset();

        setTimeout(() => {
          const modalElement = document.getElementById('orcamentoModal');
          if (bootstrap && bootstrap.Modal.getInstance(modalElement)) {
            bootstrap.Modal.getInstance(modalElement).hide();
          }
          alerta.classList.add("d-none");
        }, 3000);
      } else {
        alerta.className = "alert alert-danger";
        alerta.textContent = "❌ Erro: " + data.error;
        alerta.classList.remove("d-none");
      }
    })
    .catch(err => {
      alerta.className = "alert alert-danger";
      alerta.textContent = "❌ Erro inesperado: " + err;
      alerta.classList.remove("d-none");
    });
  });
});
</script>

<style>
  .invalid-feedback { display: none; color: red; font-size: 0.875em; }
  .is-invalid + .invalid-feedback { display: block; }
</style>
