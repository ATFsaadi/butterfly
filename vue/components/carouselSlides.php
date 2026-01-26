<?php if(!empty($slides)): ?>
<div id="mainCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <?php foreach($slides as $i => $slide): ?>
            <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="<?= $i ?>" 
                    class="<?= $i === 0 ? 'active' : '' ?>" 
                    aria-current="<?= $i === 0 ? 'true' : 'false' ?>"></button>
        <?php endforeach; ?>
    </div>

    <div class="carousel-inner">
        <?php foreach($slides as $i => $slide): ?>
        <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
            <img src="/projet-ecole/agence/images/slides/<?= htmlspecialchars($slide['image'], ENT_QUOTES, 'UTF-8') ?>" 
                 class="d-block w-100 carousel-image" 
                 alt="<?= htmlspecialchars($slide['titre'], ENT_QUOTES, 'UTF-8') ?>"
                 style="max-height: 500px; object-fit: cover;">

            <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                <div class="text-center text-white">
                    <h6><?= htmlspecialchars($slide['titre'], ENT_QUOTES, 'UTF-8') ?></h6>
                    <p class="d-none d-md-block"><?= htmlspecialchars($slide['description'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php if(!empty($slide['lien'])): ?>
                        <a href="<?= htmlspecialchars($slide['lien'], ENT_QUOTES, 'UTF-8') ?>" 
                           class="btn btn-outline-light rounded-pill px-4 mt-2">Découvrir</a>
                    <?php else: ?>
                        <button class="btn btn-outline-light rounded-pill px-4 mt-2">Découvrir</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

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
