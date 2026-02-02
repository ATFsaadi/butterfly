<?php
$offres = $offres ?? [];
?>

<div class="container mt-4">

    <h2 class="mb-3">Offres en cours</h2>

    <?php if (empty($offres)): ?>
        <div class="alert alert-info">Aucune offre active pour le moment.</div>
    <?php else: ?>

        <div class="row g-3">
            <?php foreach ($offres as $o): ?>

                <?php
                $reduc = (int)($o['pourcentage_reduction'] ?? 0);
                $prixBase = (float)($o['prix_base'] ?? 0);
                $prixRemise = $prixBase;

                if ($prixBase > 0 && $reduc > 0) {
                    $prixRemise = $prixBase * (1 - ($reduc / 100));
                }
                ?>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">

                        <?php if (!empty($o['image_url'])): ?>
                            <img src="<?= htmlspecialchars($o['image_url']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars(($o['pays'] ?? '').' '.($o['ville'] ?? '')) ?>"
                                 style="height:180px; object-fit:cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <div class="text-muted small">
                                <?= htmlspecialchars(($o['pays'] ?? '').' - '.($o['ville'] ?? '')) ?>
                            </div>

                            <h5 class="card-title"><?= htmlspecialchars($o['titre'] ?? '') ?></h5>

                            <div class="mb-2">
                                <?php if ($reduc > 0): ?>
                                    <span class="badge bg-success">-<?= $reduc ?>%</span>
                                <?php endif; ?>
                                <small class="text-muted">
                                    Du <?= htmlspecialchars($o['date_debut'] ?? '') ?>
                                    au <?= htmlspecialchars($o['date_fin'] ?? '') ?>
                                </small>
                            </div>

                            <?php if ($prixBase > 0): ?>
                                <?php if ($reduc > 0): ?>
                                    <div>
                                        <del class="text-muted"><?= number_format($prixBase, 2, ',', ' ') ?> €</del>
                                        <strong><?= number_format($prixRemise, 2, ',', ' ') ?> €</strong>
                                    </div>
                                <?php else: ?>
                                    <div><strong><?= number_format($prixBase, 2, ',', ' ') ?> €</strong></div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="mt-3 d-flex gap-2">
                                <!-- ✅ paramètre "id" pour être compatible avec ton routing -->
                                <a class="btn btn-outline-primary"
                                   href="index.php?page=destination_detail&id=<?= (int)$o['id_destination'] ?>">
                                    Voir destination
                                </a>

                                <!-- ✅ paramètre "id" (gestion_reservations.php lit $_GET["id"]) -->
                                <a class="btn btn-primary"
                                   href="index.php?page=reservation&id=<?= (int)$o['id_destination'] ?>">
                                    Réserver
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
