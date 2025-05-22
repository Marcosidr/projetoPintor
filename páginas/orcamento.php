<?php
// processar o POST antes do HTML
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formulario = $_POST['formulario'] ?? '';

  if ($formulario === 'orcamento') {
    // Processar orçamento
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CLPinturas - CONTATO e ORÇAMENTO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold text-success" href="#"><i class="bi bi-brush"></i> CLPINTURAS</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="#">HOME</a></li>
        <li class="nav-item"><a class="nav-link" href="#">QUEM SOMOS</a></li>
        <li class="nav-item"><a class="nav-link" href="#">SERVIÇOS</a></li>

        <!-- Link Contato abre modal contato -->
        <li class="nav-item"><a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#contatoModal">CONTATO</a></li>

        <!-- Botão Orçamento abre modal orçamento -->
        <li class="nav-item ms-2">
          <button type="button" class="btn btn-success rounded-pill px-4 fw-bold text-white" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
            ORÇAMENTO
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- CONTEÚDO PRINCIPAL -->
<main class="container py-5 text-center">
  <h1 class="mb-4">Bem-vindo à CLPinturas</h1>
  <p class="lead">Transformamos espaços com qualidade e profissionalismo. Clique em "Orçamento" no topo para solicitar o seu!</p>
</main>


<!-- MODAL DE ORÇAMENTO -->
 <input type="hidden" name="formulario" value="orcamento">

  <div class="modal fade" id="orcamentoModal" tabindex="-1" aria-labelledby="orcamentoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="orcamentoModalLabel">Formulário de Orçamento</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
          </div>
          <div class="modal-body">
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

<!-- SCRIPTS DO BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
