<?php

/* valeurs par defaut */
$offre  = $offre ?? null;
$voyage = $voyage ?? null;

/* verification offre */
if (!$offre) {
    echo '<div class="container py-5"><div class="alert alert-danger">Offre introuvable.</div></div>';
    return;
}

/* calcul reduction */
$reduc = (int) ($offre['reduction'] ?? 0);
$coef  = (100 - $reduc) / 100;

/* prix (voyage prioritaire, sinon offre) */
$prixAdulte = $voyage ? (float) ($voyage['prix_adulte'] ?? 0) : (float) ($offre['prix_adulte'] ?? 0);
$prixEnfant = $voyage ? (float) ($voyage['prix_enfant'] ?? 0) : (float) ($offre['prix_enfant'] ?? 0);
$prixBebe   = $voyage ? (float) ($voyage['prix_bebe'] ?? 0)   : (float) ($offre['prix_bebe'] ?? 0);

/* prix avec remise */
$prixAdulteRemise = $prixAdulte * $coef;
$prixEnfantRemise = $prixEnfant * $coef;
$prixBebeRemise   = $prixBebe * $coef;

?>

<!-- page offre detail -->
<div class="container py-5">

    <!-- titre offre -->
    <h2 class="section-title text-center mb-2">
        <?= htmlspecialchars((string) $offre['titre']) ?>

        <?php if ($reduc > 0): ?>
            <span style="font-size:0.9em;">(-<?= (int) $reduc ?>%)</span>
        <?php endif; ?>
    </h2>

    <!-- dates offre -->
    <p class="text-center text-muted mb-4">
        Valable du <?= htmlspecialchars((string) ($offre['date_debut'] ?? '')) ?>
        au <?= htmlspecialchars((string) ($offre['date_fin'] ?? '')) ?>
    </p>

    <!-- grille contenu -->
    <div class="row g-4 align-items-stretch">

        <!-- bloc image -->
        <div class="col-md-6">

            <?php if (!empty($voyage['image'])): ?>
                <img
                    src="images/voyages/<?= htmlspecialchars((string) $voyage['image']) ?>"
                    class="img-fluid w-100"
                    alt="<?= htmlspecialchars((string) ($voyage['titre'] ?? 'Voyage')) ?>"
                    style="border-radius:16px; object-fit:cover; max-height:420px;"
                >
            <?php else: ?>
                <div class="p-5 bg-light text-center" style="border-radius:16px;">
                    Aucune image
                </div>
            <?php endif; ?>

        </div>

        <!-- bloc details -->
        <div class="col-md-6">
            <div class="p-4 h-100" style="border:1px solid var(--border-color); border-radius:16px;">

                <!-- titre voyage -->
                <h4 class="mb-2">
                    <?= htmlspecialchars((string) ($voyage['titre'] ?? $offre['voyage_titre'] ?? 'Voyage')) ?>
                </h4>

                <!-- destination -->
                <?php if (!empty($voyage['destination_nom'])): ?>
                    <div class="text-muted mb-3">
                        Destination : <?= htmlspecialchars((string) $voyage['destination_nom']) ?>
                    </div>
                <?php endif; ?>

                <!-- description offre -->
                <?php if (!empty($offre['description'])): ?>
                    <p><?= nl2br(htmlspecialchars((string) $offre['description'])) ?></p>
                <?php endif; ?>

                <!-- description voyage -->
                <?php if (!empty($voyage['description'])): ?>
                    <p class="text-muted">
                        <?= nl2br(htmlspecialchars((string) $voyage['description'])) ?>
                    </p>
                <?php endif; ?>

                <!-- separation -->
                <hr>

                <!-- prix remises -->
                <div class="mb-3">
                    <div>Adulte : <strong><?= number_format((float) $prixAdulteRemise, 2, ',', ' ') ?> €</strong></div>
                    <div>Enfant : <strong><?= number_format((float) $prixEnfantRemise, 2, ',', ' ') ?> €</strong></div>
                    <div>Bébé : <strong><?= number_format((float) $prixBebeRemise, 2, ',', ' ') ?> €</strong></div>
                </div>

                <!-- actions -->
                <div class="d-flex gap-2 flex-wrap">

                    <?php if (!empty($voyage['id_voyage'])): ?>

                        <!-- voir voyage -->
                        <a href="index.php?page=voyage_detail&id=<?= (int) $voyage['id_voyage'] ?>"
                           class="btn btn-outline-secondary">
                            Voir le voyage
                        </a>

                        <!-- reserver avec offre -->
                        <a href="index.php?page=reservation&id_voyage=<?= (int) $voyage['id_voyage'] ?>&id_offre=<?= (int) $offre['id_offre'] ?>"
                           class="btn btn-primary">
                            Réserver avec cette offre
                        </a>

                    <?php else: ?>

                        <!-- reserver offre seule -->
                        <a href="index.php?page=reservation&offre=<?= (int) $offre['id_offre'] ?>"
                           class="btn btn-primary">
                            Réserver avec l’offre
                        </a>

                    <?php endif; ?>

                </div>

            </div>
        </div>

    </div>

</div>
