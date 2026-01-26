<?php if(!empty($offres)): ?>
<div id="offresCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
<h3 class="section-title">Nos offres</h3>
        <p class="section-subtitle">Meilleures offres pour vos aventures</p>
    <!-- Indicateurs -->
    <div class="carousel-indicators">
        
        <?php foreach($offres as $i => $offre): ?>
            <button type="button"
                    data-bs-target="#offresCarousel"
                    data-bs-slide-to="<?= $i ?>"
                    class="<?= $i === 0 ? 'active' : '' ?>"
                    aria-current="<?= $i === 0 ? 'true' : 'false' ?>">
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Slides -->
    <div class="carousel-inner">
        <?php foreach($offres as $i => $offre): ?>

            <?php
                $reduc = (int)($offre['reduction'] ?? 0);
                $coef = (100 - $reduc) / 100;

                $prixAdulte = isset($offre['prix_adulte']) ? (float)$offre['prix_adulte'] : 0;
                $prixEnfant = isset($offre['prix_enfant']) ? (float)$offre['prix_enfant'] : 0;
                $prixBebe   = isset($offre['prix_bebe']) ? (float)$offre['prix_bebe'] : 0;

                $prixAdulteRemise = $prixAdulte * $coef;
                $prixEnfantRemise = $prixEnfant * $coef;
                $prixBebeRemise   = $prixBebe * $coef;
            ?>

            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">

                <img src="/projet-ecole/agence/images/voyages/<?= htmlspecialchars((string)($offre['voyage_image'] ?? ''), ENT_QUOTES, 'UTF-8') ?>"
                     class="d-block w-100 carousel-image"
                     alt="<?= htmlspecialchars((string)($offre['titre'] ?? 'Offre'), ENT_QUOTES, 'UTF-8') ?>"
                     style="max-height: 500px; object-fit: cover;">

                <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                    <div class="text-center text-white">
                        <h6>
                            <?= htmlspecialchars((string)($offre['titre'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            <?php if($reduc > 0): ?> (-<?= $reduc ?>%)<?php endif; ?>
                        </h6>

                        <p class="d-none d-md-block">
                            <?= htmlspecialchars((string)($offre['voyage_titre'] ?? ''), ENT_QUOTES, 'UTF-8') ?><br>
                            <small>
                                Valable du <?= htmlspecialchars((string)($offre['date_debut'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                                au <?= htmlspecialchars((string)($offre['date_fin'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                            </small>
                        </p>

                        <p class="d-none d-md-block">
                            Prix adulte : <?= number_format($prixAdulteRemise, 2, ',', ' ') ?> € |
                            Enfant : <?= number_format($prixEnfantRemise, 2, ',', ' ') ?> € |
                            Bébé : <?= number_format($prixBebeRemise, 2, ',', ' ') ?> €
                        </p>

                        <a href="#" class="btn btn-outline-light rounded-pill px-4 mt-2">Réserver</a>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- Contrôles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#offresCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Précédent</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#offresCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Suivant</span>
    </button>

</div>
<?php endif; ?>
