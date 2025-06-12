<!-- MODAL DE ORÇAMENTO -->
<div class="modal fade" id="orcamentoModal" tabindex="-1" aria-labelledby="orcamentoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formOrcamento">
        <input type="hidden" name="formulario" value="orcamento">
        <div class="modal-header">
          <h5 class="modal-title" id="orcamentoModalLabel">Quer um orçamento sem compromisso? </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <!-- Seus campos (igual ao que você enviou) -->
          <!-- ... -->
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
            <input type="tel" class="form-control" name="telefone" required>
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

<script>
document.getElementById('formOrcamento').addEventListener('submit', function(e) {
  e.preventDefault();

  const form = e.target;

  // Pega os valores dos campos
  const nome = form.nome.value.trim();
  const email = form.email.value.trim();
  const telefone = form.telefone.value.trim();
  const endereco = form.endereco.value.trim();
  const tipoImovel = form.tipoImovel.value;
  const tipoServico = form.tipoServico.value;
  const area = form.area.value.trim();
  const urgencia = form.urgencia.value;
  const observacoes = form.observacoes.value.trim();

  // Pega os checkbox marcados de necessidades
  const necessidadesChecked = Array.from(form.querySelectorAll('input[name="necessidades[]"]:checked'))
    .map(checkbox => checkbox.value);

  // Monta a mensagem para o WhatsApp
  let mensagem = `*Pedido de Orçamento*\n\n`;
  mensagem += `*Nome:* ${nome}\n`;
  mensagem += `*Email:* ${email}\n`;
  mensagem += `*Telefone:* ${telefone}\n`;
  mensagem += `*Endereço da Obra:* ${endereco}\n`;
  mensagem += `*Tipo de Imóvel:* ${tipoImovel}\n`;
  mensagem += `*Tipo de Serviço:* ${tipoServico}\n`;
  mensagem += `*Área Aproximada (m²):* ${area || 'Não informado'}\n`;
  mensagem += `*Urgência:* ${urgencia || 'Não informado'}\n`;

  if (necessidadesChecked.length > 0) {
    mensagem += `*Necessidades Adicionais:*\n- ${necessidadesChecked.join('\n- ')}\n`;
  } else {
    mensagem += `*Necessidades Adicionais:* Nenhuma\n`;
  }

  mensagem += `*Observações:* ${observacoes || 'Nenhuma'}\n\n`;
  mensagem += `Enviado via site CLPinturas.`;

  // Codifica a mensagem para URL
  const mensagemURL = encodeURIComponent(mensagem);

  // Número do WhatsApp com código do Brasil (55) + DDD + número (44 99800 8156)
  const numeroWhats = '5544998008156';

  // URL do WhatsApp para envio da mensagem
  const url = `https://api.whatsapp.com/send?phone=${numeroWhats}&text=${mensagemURL}`;

  // Abre o WhatsApp em nova aba/janela
  window.open(url, '_blank');

  // Fecha o modal (Bootstrap 5)
  const modalElement = document.getElementById('orcamentoModal');
  const modalInstance = bootstrap.Modal.getInstance(modalElement);
  if (modalInstance) {
    modalInstance.hide();
  }

  // Opcional: limpa o formulário após o envio
  form.reset();
});
</script>
