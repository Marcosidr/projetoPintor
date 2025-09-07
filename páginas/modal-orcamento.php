<!-- MODAL DE ORÇAMENTO -->
<div class="modal fade" id="orcamentoModal" tabindex="-1" aria-labelledby="orcamentoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
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

<!-- Overlay de sucesso -->
<div id="sucessoOverlay">
  <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
    <path class="checkmark__check" fill="none" d="M14 27l7 7 16-16"/>
  </svg>
  <p>✅ Enviado com sucesso!</p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('formOrcamento');
  const alerta = document.getElementById('alertaEnvio');
  const submitBtn = form.querySelector("button[type='submit']");
  const overlay = document.getElementById('sucessoOverlay');

  if (!form) return;

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    // Ativa animação de carregamento no botão
    submitBtn.disabled = true;
    submitBtn.classList.add("btn-loading");

    const formData = new FormData(form);

    fetch('bin/enviar_orcamento.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      submitBtn.classList.remove("btn-loading");
      submitBtn.disabled = false;

      if (data.success) {
        form.reset();

        // Mostra overlay com check animado
        overlay.style.display = "flex";

        setTimeout(() => {
          overlay.style.display = "none";
          const modalElement = document.getElementById('orcamentoModal');
          if (bootstrap && bootstrap.Modal.getInstance(modalElement)) {
            bootstrap.Modal.getInstance(modalElement).hide();
          }
        }, 3000);

      } else {
        alerta.className = "alert alert-danger";
        alerta.textContent = "❌ Erro: " + data.error;
        alerta.classList.remove("d-none");
      }
    })
    .catch(err => {
      submitBtn.classList.remove("btn-loading");
      submitBtn.disabled = false;

      alerta.className = "alert alert-danger";
      alerta.textContent = "❌ Erro inesperado: " + err;
      alerta.classList.remove("d-none");
    });
  });
});
</script>

<!-- CSS exclusivo do modal -->
<style>

/* Botão com animação de carregamento */
.btn-loading {
  position: relative;
  color: transparent !important;
  background-color: #198754 !important; 
}
.btn-loading::after {
  content: '...';
  position: absolute;
  left: 50%;
  transform: translateX(-50%);
  animation: blink 1s infinite;
  color: white; /* pontinhos em branco */
}
@keyframes blink {
  0%, 50%, 100% { opacity: 1; }
  25%, 75% { opacity: 0; }
}


/* Tela de sucesso (overlay) */
#sucessoOverlay {
  display: none;
  position: fixed;
  top: 0; left: 0;
  width: 100%; height: 100%;
  background: rgba(0,0,0,0.7);
  z-index: 9999;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  color: white;
  font-size: 1.5rem;
  animation: fadeIn 0.5s ease-in-out;
}
#sucessoOverlay .checkmark {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  display: block;
  stroke-width: 4;
  stroke: #fff;
  stroke-miterlimit: 10;
  margin: 20px auto;
  box-shadow: inset 0px 0px 0px #28a745;
  animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both;
}
#sucessoOverlay .checkmark__circle {
  stroke-dasharray: 166;
  stroke-dashoffset: 166;
  stroke-width: 4;
  stroke-miterlimit: 10;
  stroke: #28a745;
  fill: none;
  animation: stroke .6s cubic-bezier(.65,0,.45,1) forwards;
}
#sucessoOverlay .checkmark__check {
  transform-origin: 50% 50%;
  stroke-dasharray: 48;
  stroke-dashoffset: 48;
  animation: stroke .3s cubic-bezier(.65,0,.45,1) .8s forwards;
}
@keyframes stroke { 100% { stroke-dashoffset: 0; } }
@keyframes scale {
  0%, 100% { transform: none; }
  50% { transform: scale3d(1.1, 1.1, 1); }
}
@keyframes fill { 100% { box-shadow: inset 0px 0px 0px 40px #28a745; } }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
</style>
