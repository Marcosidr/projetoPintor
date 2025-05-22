<?php
// Processar o POST do formulário de contato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $formulario = $_POST['formulario'] ?? '';
  if ($formulario === 'contato') {
    // Aqui você pode processar os dados: salvar no banco, enviar email etc.
  }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>CLPinturas - CONTATO</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>

<!-- NAVBAR IGUAL AO PRINCIPAL -->
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

        <!-- Botão Orçamento -->
        <li class="nav-item ms-2">
          <button type="button" class="btn btn-success rounded-pill px-4 fw-bold text-white" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
            ORÇAMENTO
          </button>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- CONTEÚDO DA PÁGINA CONTATO -->
<main class="container py-5">
  <h1 class="text-center mb-4">Fale Conosco</h1>
  <p class="text-center mb-5">Preencha o formulário abaixo e entraremos em contato o mais breve possível.</p>

  <!-- Formulário direto na página -->
  <div class="row justify-content-center">
    <div class="col-md-8">
      <form method="post">
        <input type="hidden" name="formulario" value="contato" />
        
        <div class="mb-3">
          <label for="nomeContato" class="form-label">Nome Completo *</label>
          <input type="text" class="form-control" name="nome" id="nomeContato" required />
        </div>

        <div class="mb-3">
          <label for="emailContato" class="form-label">Email *</label>
          <input type="email" class="form-control" name="email" id="emailContato" required />
        </div>

        <div class="mb-3">
          <label for="mensagemContato" class="form-label">Mensagem *</label>
          <textarea class="form-control" name="mensagem" id="mensagemContato" rows="4" required></textarea>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-success btn-lg">Enviar Mensagem</button>
        </div>
      </form>
    </div>
  </div>
</main>

<!-- OPCIONAL: MODAL DE CONTATO (caso queira deixar o botão do menu funcionando) -->
<div class="modal fade" id="contatoModal" tabindex="-1" aria-labelledby="contatoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form method="post">
        <input type="hidden" name="formulario" value="contato">
        <div class="modal-header">
          <h5 class="modal-title" id="contatoModalLabel">Formulário de Contato</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nome Completo *</label>
            <input type="text" class="form-control" name="nome" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" class="form-control" name="email" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Mensagem *</label>
            <textarea class="form-control" name="mensagem" rows="3" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL DE ORÇAMENTO (reaproveitado do seu código original) -->
<!-- Inclua aqui se quiser que apareça também na página de contato -->

<!-- BOOTSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>