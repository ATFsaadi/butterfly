<?php
if (!isset($offres)) $offres = [];
?>

<div class="container py-4">

    <h3 class="section-title text-center mt-5">Nos Offres</h3>

    <?php if (empty($offres)): ?>
        <div class="alert alert-info">Aucune offre active pour le moment.</div>
    <?php else: ?>

        <div class="row g-4">

            <?php foreach ($offres as $o): ?>
                <?php
                    $reduc = (int) ($o['pourcentage_reduction'] ?? 0);
                    $coef  = (100 - $reduc) / 100;

                    $prixBase = (float) ($o['prix_base'] ?? 0);
                    $prixFinal = round($prixBase * $coef, 2);

                    $destLabel = trim(($o['ville'] ?? '') . ' — ' . ($o['pays'] ?? ''));
                ?>

                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm">

                        <?php if (!empty($o['image_url'])): ?>
                            <img
                                src="images/destinations/<?= htmlspecialchars((string) $o['image_url']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($destLabel ?: 'Destination') ?>"
                                style="height:220px; object-fit:cover;"
                            >
                        <?php endif; ?>

                        <div class="card-body">

                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars((string) ($o['titre'] ?? '')) ?>
                                <?php if ($reduc > 0): ?>
                                    (-<?= (int) $reduc ?>%)
                                <?php endif; ?>
                            </h5>

                            <div class="text-muted mb-2" style="font-size:0.95rem;">
                                <?= htmlspecialchars($destLabel) ?>
                            </div>

                            <div class="small">
                                <div>Prix de base : <s><?= number_format($prixBase, 2, ',', ' ') ?> €</s></div>
                                <div>Prix promo : <strong><?= number_format($prixFinal, 2, ',', ' ') ?> €</strong></div>

                                <div class="text-muted mt-2">
                                    Valable du <?= htmlspecialchars((string) ($o['date_debut'] ?? '')) ?>
                                    au <?= htmlspecialchars((string) ($o['date_fin'] ?? '')) ?>
                                </div>
                            </div>

                        </div>

                        <div class="card-footer bg-white border-0">
                            <a href="index.php?page=destination_detail&id=<?= (int)($o['id_destination'] ?? 0) ?>"
                               class="btn btn-outline-dark w-100">
                                Voir l'offre
                            </a>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
