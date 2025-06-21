<!-- MODAL DE ORÇAMENTO -->
<div class="modal fade" id="orcamentoModal" tabindex="-1" aria-labelledby="orcamentoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formOrcamento" novalidate>
        <input type="hidden" name="formulario" value="orcamento">
        <div class="modal-header">
          <h5 class="modal-title" id="orcamentoModalLabel">Quer um orçamento sem compromisso?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nome Completo *</label>
            <input type="text" class="form-control" name="nome" required>
            <div class="invalid-feedback">Digite um nome com no mínimo 3 letras (somente letras).</div>
          </div>

          <div class="mb-3">
            <label>Email *</label>
            <input type="email" class="form-control" name="email" required>
            <div class="invalid-feedback">Digite um e-mail válido (ex: nome@email.com).</div>
          </div>

          <div class="mb-3">
            <label>Telefone *</label>
            <input type="tel" class="form-control" name="telefone" required placeholder="Ex: 44998008156">
            <div class="invalid-feedback">Digite um telefone válido com DDD. Ex: 44998008156</div>
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

<!-- Script com DOMContentLoaded -->
<script>
document.addEventListener('DOMContentLoaded', function () {
  const form = document.getElementById('formOrcamento');
  if (!form) return;

  form.addEventListener('submit', function(e) {
    e.preventDefault();

    const nomeInput = form.nome;
    const emailInput = form.email;
    const telefoneInput = form.telefone;

    const nome = nomeInput.value.trim();
    const email = emailInput.value.trim();
    const telefone = telefoneInput.value.trim();

    const regexNome = /^[A-Za-zÀ-ÿ\s]{3,}$/;
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const regexTelefone = /^(\d{10,11})$/;

    let valido = true;

    if (!regexNome.test(nome)) {
      nomeInput.classList.add('is-invalid');
      valido = false;
    } else {
      nomeInput.classList.remove('is-invalid');
    }

    if (!regexEmail.test(email) || !email.includes('@') || !email.includes('.com')) {
      emailInput.classList.add('is-invalid');
      valido = false;
    } else {
      emailInput.classList.remove('is-invalid');
    }

    if (!regexTelefone.test(telefone)) {
      telefoneInput.classList.add('is-invalid');
      valido = false;
    } else {
      telefoneInput.classList.remove('is-invalid');
    }

    if (!valido) return;

    const endereco = form.endereco.value.trim();
    const tipoImovel = form.tipoImovel.value;
    const tipoServico = form.tipoServico.value;
    const area = form.area.value.trim();
    const urgencia = form.urgencia.value;
    const observacoes = form.observacoes.value.trim();
    const necessidadesChecked = Array.from(form.querySelectorAll('input[name="necessidades[]"]:checked'))
      .map(cb => cb.value);

    let mensagem = `*Pedido de Orçamento*\n\n`;
    mensagem += `*Nome:* ${nome}\n`;
    mensagem += `*Email:* ${email}\n`;
    mensagem += `*Telefone:* ${telefone}\n`;
    mensagem += `*Endereço da Obra:* ${endereco}\n`;
    mensagem += `*Tipo de Imóvel:* ${tipoImovel}\n`;
    mensagem += `*Tipo de Serviço:* ${tipoServico}\n`;
    mensagem += `*Área Aproximada (m²):* ${area || 'Não informado'}\n`;
    mensagem += `*Urgência:* ${urgencia || 'Não informado'}\n`;
    mensagem += `*Necessidades Adicionais:* ${
      necessidadesChecked.length > 0 ? '\n- ' + necessidadesChecked.join('\n- ') : 'Nenhuma'
    }\n`;
    mensagem += `*Observações:* ${observacoes || 'Nenhuma'}\n\n`;
    mensagem += `Enviado via site CLPinturas.`;

    const mensagemURL = encodeURIComponent(mensagem);
    const numeroWhats = '5544998008156';
    const url = `https://api.whatsapp.com/send?phone=${numeroWhats}&text=${mensagemURL}`;
    window.open(url, '_blank');

    const modalElement = document.getElementById('orcamentoModal');
    if (bootstrap && bootstrap.Modal.getInstance(modalElement)) {
      bootstrap.Modal.getInstance(modalElement).hide();
    }

    form.reset();
  });
});
</script>

<!-- Bootstrap 5 JS (caso não tenha ainda) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Estilo para feedback de validação -->
<style>
  .invalid-feedback {
    display: none;
    color: red;
    font-size: 0.875em;
  }
  .is-invalid + .invalid-feedback {
    display: block;
  }
</style>
