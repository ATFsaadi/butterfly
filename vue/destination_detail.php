<?php
$destination = $destination ?? null;
$offreActive = $offreActive ?? null;
?>

<div class="container mt-4">

    <?php if (!$destination): ?>
        <div class="alert alert-danger">Destination introuvable.</div>
    <?php else: ?>

        <h2 class="mb-3">
            <?= htmlspecialchars(($destination['pays'] ?? '').' - '.($destination['ville'] ?? '')) ?>
        </h2>

        <div class="row g-3">
            <div class="col-md-6">
                <?php if (!empty($destination['image_url'])): ?>
                    <img src="<?= htmlspecialchars($destination['image_url']) ?>"
                         alt="image"
                         class="img-fluid rounded"
                         style="width:100%; max-height:380px; object-fit:cover;">
                <?php endif; ?>
            </div>

            <div class="col-md-6">
                <?php if (!empty($destination['continent'])): ?>
                    <div class="text-muted mb-2"><?= htmlspecialchars($destination['continent']) ?></div>
                <?php endif; ?>

                <?php if (!empty($destination['description'])): ?>
                    <p><?= nl2br(htmlspecialchars($destination['description'])) ?></p>
                <?php endif; ?>

                <p><strong>Prix base :</strong> <?= number_format((float)($destination['prix_base'] ?? 0), 2, ',', ' ') ?> €</p>

                <?php if ($offreActive): ?>
                    <div class="alert alert-success">
                        Offre active : <strong><?= htmlspecialchars($offreActive['titre'] ?? '') ?></strong>
                        (<?= (int)($offreActive['pourcentage_reduction'] ?? 0) ?>%)
                        <br>
                        Du <?= htmlspecialchars($offreActive['date_debut'] ?? '') ?> au <?= htmlspecialchars($offreActive['date_fin'] ?? '') ?>
                    </div>
                <?php endif; ?>

                <a class="btn btn-primary"
                   href="index.php?page=reservation&id_destination=<?= (int)$destination['id_destination'] ?>">
                    Réserver
                </a>
            </div>
        </div>

    <?php endif; ?>
</div>
