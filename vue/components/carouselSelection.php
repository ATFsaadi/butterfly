<?php if(!empty($slides)): ?>
<section class="selection-section mt-5 py-5 bg-light">
    <div class="container text-center">
        <h3 class="section-title">Notre sélection</h3>
        <p class="section-subtitle">Découvrez nos destinations préférées</p>
        <div id="selectionCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php foreach($slides as $i => $slide): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <img src="slides/<?= htmlspecialchars($slide['image']) ?>" class="d-block w-100" alt="<?= htmlspecialchars($slide['titre']) ?>">
                    <div class="carousel-caption d-none d-md-block">
                        <h5><?= htmlspecialchars($slide['titre']) ?></h5>
                        <p><?= htmlspecialchars($slide['description']) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#selectionCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#selectionCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
</section>
<?php endif; ?>
