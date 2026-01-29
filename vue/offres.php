<?php

/* valeurs par defaut */
if (!isset($offres)) {
    $offres = [];
}

?>

<!-- page offres -->
<div class="container py-4">

    <!-- titre page -->
    <h3 class="section-title text-center mt-5">Nos Offres</h3>

    <!-- aucune offre -->
    <?php if (empty($offres)): ?>
        <div class="alert alert-info">Aucune offre active pour le moment.</div>
    <?php else: ?>

        <!-- grille offres -->
        <div class="row g-4">

            <?php foreach ($offres as $o): ?>
                <?php
                    /* calcul reduction */
                    $reduc = (int) ($o['reduction'] ?? 0);
                    $coef  = (100 - $reduc) / 100;

                    /* prix de base */
                    $prixAdulte = (float) ($o['prix_adulte'] ?? 0);
                    $prixEnfant = (float) ($o['prix_enfant'] ?? 0);
                    $prixBebe   = (float) ($o['prix_bebe'] ?? 0);
                ?>

                <div class="col-12 col-md-6 col-lg-4">

                    <!-- carte offre -->
                    <div class="card h-100 shadow-sm">

                        <!-- image voyage -->
                        <?php if (!empty($o['voyage_image'])): ?>
                            <img
                                src="images/voyages/<?= htmlspecialchars((string) $o['voyage_image']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars((string) ($o['voyage_titre'] ?? 'Voyage')) ?>"
                                style="height:220px; object-fit:cover;"
                            >
                        <?php endif; ?>

                        <!-- contenu carte -->
                        <div class="card-body">

                            <!-- titre offre -->
                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars((string) ($o['titre'] ?? '')) ?>
                                <?php if ($reduc > 0): ?>
                                    (-<?= (int) $reduc ?>%)
                                <?php endif; ?>
                            </h5>

                            <!-- titre voyage -->
                            <div class="text-muted mb-2" style="font-size:0.95rem;">
                                <?= htmlspecialchars((string) ($o['voyage_titre'] ?? '')) ?>
                            </div>

                            <!-- description voyage -->
                            <p class="card-text">
                                <?= nl2br(htmlspecialchars((string) ($o['voyage_description'] ?? ''))) ?>
                            </p>

                            <!-- prix remises -->
                            <div class="small">
                                <div>Adulte : <strong><?= number_format((float) ($prixAdulte * $coef), 2, ',', ' ') ?> €</strong></div>
                                <div>Enfant : <strong><?= number_format((float) ($prixEnfant * $coef), 2, ',', ' ') ?> €</strong></div>
                                <div>Bébé : <strong><?= number_format((float) ($prixBebe * $coef), 2, ',', ' ') ?> €</strong></div>

                                <!-- dates offre -->
                                <div class="text-muted mt-2">
                                    Valable du <?= htmlspecialchars((string) ($o['date_debut'] ?? '')) ?>
                                    au <?= htmlspecialchars((string) ($o['date_fin'] ?? '')) ?>
                                </div>
                            </div>

                        </div>

                        <!-- actions carte -->
                        <div class="card-footer bg-white border-0">
                            <a href="#" class="btn btn-outline-dark w-100">Réserver maintenant</a>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
