<?php
// Inclui o cabeçalho (já deve conter DOCTYPE, html, head e início do body)
include '../header.php';
?>

<!-- Conteúdo da Página de Contato -->
<div class="container mt-5">
  <h2 class="text-center mb-4">Fale Conosco</h2>
  <form>
    <div class="mb-3">
      <label for="nome" class="form-label">Nome</label>
      <input type="text" class="form-control" id="nome" required>
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" class="form-control" id="email" required>
    </div>
    <div class="mb-3">
      <label for="mensagem" class="form-label">Mensagem</label>
      <textarea class="form-control" id="mensagem" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-success">Enviar</button>
  </form>
</div>

<!-- Modal de Orçamento -->
<?php include '../páginas/modal-orcamento.php'; ?>

<?php
// Inclui o rodapé (deve fechar o body e o html)
include '../footer.php';
?>
