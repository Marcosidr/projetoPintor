<?php
require_once __DIR__ . '/../classes/CatalogoManager.php';
$itens = CatalogoManager::getItens();
?>

<div class="container my-5">
    <h1 class="text-center mb-5 display-5 fw-bold text-paint-green-700">Catálogo de Tintas e Acabamentos</h1>
    
    <div class="row g-4">
        <?php foreach ($itens as $item): ?>
            <?= $item->render(); ?>
        <?php endforeach; ?>
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
                </div>
            </div>
        </div>
    </div>
</div>
