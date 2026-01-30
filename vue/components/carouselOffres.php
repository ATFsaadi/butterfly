<?php if (!empty($offres)): ?>

<h3 class="section-title text-center mt-5">Nos offres</h3>
<p class="section-subtitle text-center mb-4">Meilleures offres pour vos aventures</p>

<div id="offresCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">

    <!-- indicateurs -->
    <div class="carousel-indicators">
        <?php foreach ($offres as $i => $offre): ?>
            <button type="button"
                    data-bs-target="#offresCarousel"
                    data-bs-slide-to="<?= $i ?>"
                    class="<?= $i === 0 ? 'active' : '' ?>"
                    aria-current="<?= $i === 0 ? 'true' : 'false' ?>">
            </button>
        <?php endforeach; ?>
    </div>

    <!-- contenu -->
    <div class="carousel-inner">

        <?php foreach ($offres as $i => $offre): ?>

            <?php
            $reduc = (int)($offre['pourcentage_reduction'] ?? 0);
            $coef  = (100 - $reduc) / 100;

            $prixBase  = (float)($offre['prix_base'] ?? 0);
            $prixPromo = round($prixBase * $coef, 2);

            $destLabel = trim(($offre['ville'] ?? '') . ' — ' . ($offre['pays'] ?? ''));
            ?>

            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">

                <div class="row g-0" style="min-height:500px;">

                    <!-- image -->
                    <div class="col-md-9">
                        <img src="/projet-ecole/agence/images/destinations/<?= htmlspecialchars($offre['image_url'] ?? '') ?>"
                             class="d-block w-100 carousel-image"
                             alt="<?= htmlspecialchars($offre['titre'] ?? 'Offre') ?>"
                             style="height:500px; object-fit:cover;">
                    </div>

                    <!-- details -->
                    <div class="col-md-3 d-flex align-items-stretch"
                         style="background: var(--secondary-color);">

                        <div class="carousel-caption d-flex h-100 w-100 align-items-center justify-content-center"
                             style="position: static; padding: 20px;">

                            <div class="text-center text-white">

                                <h6>
                                    <?= htmlspecialchars($offre['titre'] ?? '') ?>
                                    <?php if ($reduc > 0): ?>
                                        (-<?= $reduc ?>%)
                                    <?php endif; ?>
                                </h6>

                                <p class="d-none d-md-block">
                                    <?= htmlspecialchars($destLabel) ?><br>
                                    <small>
                                        Du <?= htmlspecialchars($offre['date_debut'] ?? '') ?>
                                        au <?= htmlspecialchars($offre['date_fin'] ?? '') ?>
                                    </small>
                                </p>

                                <p class="d-none d-md-block">
                                    Prix de base : <s><?= number_format($prixBase, 2, ',', ' ') ?> €</s><br>
                                    Prix promo : <strong><?= number_format($prixPromo, 2, ',', ' ') ?> €</strong>
                                </p>

                                <a href="index.php?page=reservation&id=<?= (int)($offre['id_destination'] ?? 0) ?>"
                                   class="btn btn-outline-light rounded-pill px-4 mt-2">
                                    Réserver
                                </a>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <!-- controles -->
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
