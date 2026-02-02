<?php if (!empty($slides)): ?>

<h3 class="section-title text-center mt-5">Coup de Cœur</h3>

<div id="mainCarousel" class="carousel slide mt-4" data-bs-ride="carousel" data-bs-interval="6000">

    <!-- indicateurs -->
    <div class="carousel-indicators">
        <?php foreach ($slides as $i => $slide): ?>
            <button type="button"
                    data-bs-target="#mainCarousel"
                    data-bs-slide-to="<?= $i ?>"
                    class="<?= $i === 0 ? 'active' : '' ?>"
                    aria-current="<?= $i === 0 ? 'true' : 'false' ?>">
            </button>
        <?php endforeach; ?>
    </div>

    <!-- contenu -->
    <div class="carousel-inner">

        <?php foreach ($slides as $i => $slide): ?>

            <?php
            $titre = $slide['titre'] ?? '';
            $sousTitre = $slide['sous_titre'] ?? '';
            $img = $slide['image_url'] ?? '';
            ?>

            <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">

                <!-- image -->
                <?php if (!empty($img)): ?>
                    <img src="<?= htmlspecialchars($img, ENT_QUOTES, 'UTF-8') ?>"
                         class="d-block w-100 carousel-image"
                         alt="<?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?>"
                         style="max-height: 500px; object-fit: cover;">
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center bg-light"
                         style="height:500px;">
                        <span class="text-muted">Image non disponible</span>
                    </div>
                <?php endif; ?>

                <!-- caption -->
                <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                    <div class="text-center text-white">

                        <?php if (!empty($titre)): ?>
                            <h6><?= htmlspecialchars($titre, ENT_QUOTES, 'UTF-8') ?></h6>
                        <?php endif; ?>

                        <?php if (!empty($sousTitre)): ?>
                            <p class="d-none d-md-block"><?= htmlspecialchars($sousTitre, ENT_QUOTES, 'UTF-8') ?></p>
                        <?php endif; ?>

                        <!-- bouton (comme tu n'as pas de champ lien dans ta table) -->
                        <a href="index.php?page=destinations"
                           class="btn btn-outline-light rounded-pill px-4 mt-2">
                            Découvrir
                        </a>

                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

    <!-- contrôles -->
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Précédent</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Suivant</span>
    </button>

</div>

<?php endif; ?>
