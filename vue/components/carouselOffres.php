<?php if(!empty($voyages)): ?>
<section class="offers-section mt-5 py-5 bg-light">
    <div class="container text-center">
        <h3 class="section-title">Nos offres</h3>
        <p class="section-subtitle">Meilleures offres pour vos aventures</p>

        <div id="offerCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">
            <div class="carousel-inner">
                <?php foreach ($voyages as $i => $voyage): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <div class="card big-card mx-auto shadow-lg" style="max-width: 500px;">
                        <img src="slides/<?= htmlspecialchars($voyage['image'], ENT_QUOTES, 'UTF-8') ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($voyage['titre'], ENT_QUOTES, 'UTF-8') ?>" 
                             style="height:300px; object-fit:cover;">
                        <div class="card-body text-center">
                            <h6 class="card-title"><?= htmlspecialchars($voyage['titre'], ENT_QUOTES, 'UTF-8') ?></h6>
                            <p class="card-text"><?= htmlspecialchars($voyage['description'], ENT_QUOTES, 'UTF-8') ?></p>
                            <div class="pricing mb-2">
                                <p class="mb-1">Prix adulte : <?= number_format($voyage['prix_adulte'], 2, ',', ' ') ?> €</p>
                                <p class="mb-1">Prix enfant : <?= number_format($voyage['prix_enfant'], 2, ',', ' ') ?> €</p>
                                <p class="mb-1">Prix bébé : <?= number_format($voyage['prix_bebe'], 2, ',', ' ') ?> €</p>
                            </div>
                            <a href="#" class="btn btn-outline-dark rounded-pill mt-2">Réserver maintenant</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Contrôles -->
            <button class="carousel-control-prev" type="button" data-bs-target="#offerCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#offerCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Suivant</span>
            </button>

            <!-- Indicateurs -->
            <div class="carousel-indicators mt-3">
                <?php foreach($voyages as $i => $voyage): ?>
                    <button type="button" data-bs-target="#offerCarousel" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>" aria-current="<?= $i === 0 ? 'true' : 'false' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>
