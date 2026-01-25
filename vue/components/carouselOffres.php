<?php if(!empty($voyages)): ?>
<section class="offers-section mt-5 py-5">
    <div class="container text-center">
        <h3 class="section-title">Nos offres</h3>
        <p class="section-subtitle">Meilleures offres pour vos aventures</p>
        <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach ($voyages as $i => $voyage): ?>
                    <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                        <div class="card big-card mx-auto shadow-lg" style="max-width: 500px;">
                            <img src="slides/<?= htmlspecialchars($voyage['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($voyage['titre']) ?>">
                            <div class="card-body text-center">
                                <h6 class="card-title"><?= htmlspecialchars($voyage['titre']) ?></h6>
                                <p class="card-text"><?= htmlspecialchars($voyage['description']) ?></p>
                                <p class="mb-2">Prix adulte : <?= number_format($voyage['prix_adulte'], 2, ',', ' ') ?> €</p>
                                <p class="mb-2">Prix enfant : <?= number_format($voyage['prix_enfant'], 2, ',', ' ') ?> €</p>
                                <p class="mb-2">Prix bébé : <?= number_format($voyage['prix_bebe'], 2, ',', ' ') ?> €</p>
                                <a href="#" class="btn btn-outline-dark rounded-pill mt-2">Réserver maintenant</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>
<?php endif; ?>
