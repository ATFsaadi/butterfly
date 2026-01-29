<?php

if (!isset($voyages)) $voyages = [];
?>

<div class="container py-4">
    <h3 class="section-title text-center mt-5">Nos Voyages</h3>

    <!-- vide -->
    <?php if (empty($voyages)): ?>
        <div class="alert alert-info">Aucun voyage disponible.</div>
    <?php else: ?>

        <!-- grille -->
        <div class="row g-4">

            <?php foreach ($voyages as $v): ?>
                <div class="col-12 col-md-6 col-lg-4">

                    <!-- carte -->
                    <div class="card h-100 shadow-sm">

                        <!-- image -->
                        <?php if (!empty($v['image'])): ?>
                            <img src="images/voyages/<?= htmlspecialchars((string)$v['image']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars((string)$v['titre']) ?>"
                                 style="height:220px; object-fit:cover;">
                        <?php endif; ?>

                        <!-- contenu -->
                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= htmlspecialchars((string)$v['titre']) ?></h5>

                            <!-- destination -->
                            <div class="text-muted mb-2" style="font-size: 0.95rem;">
                                <?= htmlspecialchars((string)($v['destination_nom'] ?? '')) ?>
                            </div>

                            <!-- description -->
                            <p class="card-text">
                                <?= nl2br(htmlspecialchars((string)($v['description'] ?? ''))) ?>
                            </p>

                            <!-- prix -->
                            <?php if (isset($v['prix_adulte'])): ?>
                                <p class="mb-0">
                                    <strong>Prix adulte :</strong>
                                    <?= number_format((float)$v['prix_adulte'], 2, ',', ' ') ?> €
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- action -->
                        <div class="card-footer bg-white border-0">
                            <a href="index.php?page=voyage_detail&id=<?= (int)$v['id_voyage'] ?>"
   class="btn btn-outline-primary w-100">
   Voir plus
</a>

                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
