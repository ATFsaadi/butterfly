<?php
if (!isset($destinations)) $destinations = [];
?>

<div class="container py-4">
    <h2 class="mb-4">Nos Destinations</h2>

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">Aucune destination disponible.</div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($destinations as $d): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">

                        <?php if (!empty($d['image'])): ?>
                            <img src="images/destinations/<?= htmlspecialchars((string)$d['image']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars((string)$d['nom']) ?>"
                                 style="height: 220px; object-fit: cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= htmlspecialchars((string)$d['nom']) ?></h5>

                            <div class="text-muted mb-2" style="font-size: 0.95rem;">
                                <?= htmlspecialchars((string)($d['continent_nom'] ?? '')) ?>
                            </div>

                            <p class="card-text">
                                <?= nl2br(htmlspecialchars((string)($d['description'] ?? ''))) ?>
                            </p>
                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn btn-outline-primary w-100 disabled">Voir plus</a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
