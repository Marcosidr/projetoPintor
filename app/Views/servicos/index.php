<!-- Seção Serviços -->
<section class="container py-5">
  <h2 class="text-center mb-5 text-paint-green-700 fw-bold">Nossos Serviços</h2>
  
  <div class="row g-4">
    <?php foreach ($servicos as $servico): ?>
      <div class="col-md-4 d-flex">
        <?= $servico->render(); ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Nova seção: Chamada para ação -->
<section class="container text-center my-5">
  <div class="p-5 bg-success text-white rounded-3 shadow">
    <h2 class="fw-bold text-black" style="font-size: 2rem;">Pronto para transformar seu ambiente?</h2>
    <p class="lead mb-4">Solicite já um orçamento sem compromisso e descubra como podemos ajudar você!</p>
    <button class="btn btn-light btn-lg rounded-pill px-5 fw-bold" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
      Solicitar Orçamento
    </button>
  </div>
</section>

<!-- Seção Serviços em Destaque -->
<section class="container my-5">
  <h2 class="text-center mb-5 text-paint-green-700 fw-bold">Serviços em Destaque</h2>
  
  <div class="row g-4">
    <?php foreach (array_slice($servicos, 0, 3) as $servico): ?> <!-- Mostra só 3 -->
      <div class="col-md-4 d-flex">
        <?= $servico->render(); ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<!-- Nova seção: Processo de Trabalho -->
<section class="bg-light py-5">
  <div class="container">
    <h2 class="text-center mb-5 text-paint-green-700 fw-bold">Como Trabalhamos</h2>
    <div class="row text-center">
      <div class="col-md-3">
        <i class="bi bi-telephone-fill fs-1 text-success mb-3"></i>
        <h5>1. Contato</h5>
        <p class="text-muted">Você entra em contato e explica sua necessidade.</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-clipboard-check fs-1 text-success mb-3"></i>
        <h5>2. Orçamento</h5>
        <p class="text-muted">Enviamos um orçamento transparente e sem compromisso.</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-paint-bucket fs-1 text-success mb-3"></i>
        <h5>3. Execução</h5>
        <p class="text-muted">Realizamos o serviço com qualidade e dentro do prazo.</p>
      </div>
      <div class="col-md-3">
        <i class="bi bi-emoji-smile fs-1 text-success mb-3"></i>
        <h5>4. Satisfação</h5>
        <p class="text-muted">Garantimos sua satisfação e oferecemos suporte após o serviço.</p>
      </div>
    </div>
  </div>
</section>
