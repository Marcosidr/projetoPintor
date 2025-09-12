<div class="container my-5">
    <h1 class="text-center mb-5 display-5 fw-bold text-paint-green-700">Catálogo de Tintas</h1>

    <div class="row g-4">
        <?php if (empty($itens)): ?>
            <div class="col-12 text-center text-muted">Nenhum catálogo enviado ainda.</div>
        <?php else: ?>
            <?php foreach ($itens as $item): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="bi bi-file-earmark-pdf mb-3" style="font-size: 2.5rem;"></i>
                            <h5 class="card-title fw-bold"><?= htmlspecialchars($item['titulo']) ?></h5>
                            <p class="card-text small text-muted mb-3">Arquivo: <?= htmlspecialchars(basename($item['arquivo'])) ?></p>
                            <a href="<?= BASE_URL . '/uploads/catalogo/' . rawurlencode($item['arquivo']) ?>" class="btn btn-outline-success btn-sm" target="_blank">Abrir</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background-color: #e0f7fa;">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-paint-green-700">Qual tinta escolher?</h4>
                    <p class="mb-0">
                        A escolha da tinta ideal depende do ambiente e da superfície a ser pintada.
                        Para áreas internas, tintas látex (PVA) e acrílicas são ótimas opções.
                        Ambientes externos exigem tintas mais resistentes, como a acrílica ou texturizada.
                        Para metais e madeiras, prefira esmalte sintético. Já para pisos, azulejos ou locais que exigem alta resistência, a tinta epóxi é a mais indicada.
                        Em caso de dúvida, consulte um profissional para garantir o melhor resultado!
                    </p>
                    <button class="btn btn-success btn-lg rounded-pill px-5 fw-bold mt-4" data-bs-toggle="modal" data-bs-target="#orcamentoModal">
                        Sua dúvida
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
