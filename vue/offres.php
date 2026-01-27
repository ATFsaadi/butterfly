<?php

if (!isset($offres)) $offres = [];
?>

<div class="container py-4">
    <h3 class="section-title text-center mt-5">Nos Offres</h3>

    <!-- vide -->
    <?php if (empty($offres)): ?>
        <div class="alert alert-info">Aucune offre active pour le moment.</div>
    <?php else: ?>

        <!-- grille -->
        <div class="row g-4">

            <?php foreach ($offres as $o): ?>
                <?php
                /* calculs */
                $reduc = (int)($o['reduction'] ?? 0);
                $coef = (100 - $reduc) / 100;

                $prixAdulte = (float)($o['prix_adulte'] ?? 0);
                $prixEnfant = (float)($o['prix_enfant'] ?? 0);
                $prixBebe   = (float)($o['prix_bebe'] ?? 0);
                ?>
                <div class="col-12 col-md-6 col-lg-4">

                    <!-- carte -->
                    <div class="card h-100 shadow-sm">

                        <!-- image -->
                        <?php if (!empty($o['voyage_image'])): ?>
                            <img src="images/voyages/<?= htmlspecialchars((string)$o['voyage_image']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars((string)$o['voyage_titre']) ?>"
                                 style="height:220px; object-fit:cover;">
                        <?php endif; ?>

                        <!-- contenu -->
                        <div class="card-body">
                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars((string)$o['titre']) ?> (-<?= $reduc ?>%)
                            </h5>

                            <!-- voyage -->
                            <div class="text-muted mb-2" style="font-size: 0.95rem;">
                                <?= htmlspecialchars((string)($o['voyage_titre'] ?? '')) ?>
                            </div>

                            <!-- description -->
                            <p class="card-text">
                                <?= nl2br(htmlspecialchars((string)($o['voyage_description'] ?? ''))) ?>
                            </p>

                            <!-- prix -->
                            <div class="small">
                                <div>Adulte : <strong><?= number_format($prixAdulte * $coef, 2, ',', ' ') ?> €</strong></div>
                                <div>Enfant : <strong><?= number_format($prixEnfant * $coef, 2, ',', ' ') ?> €</strong></div>
                                <div>Bébé : <strong><?= number_format($prixBebe * $coef, 2, ',', ' ') ?> €</strong></div>

                                <!-- dates -->
                                <div class="text-muted mt-2">
                                    Valable du <?= htmlspecialchars((string)$o['date_debut']) ?>
                                    au <?= htmlspecialchars((string)$o['date_fin']) ?>
                                </div>
                            </div>
                        </div>

                        <!-- action -->
                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn btn-outline-dark w-100">Réserver maintenant</a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
