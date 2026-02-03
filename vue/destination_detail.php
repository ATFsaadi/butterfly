<?php
$destination = $destination ?? null;
$offreActive = $offreActive ?? null;
?>

<?php if (!$destination): ?>

    <div class="container mt-4">
        <div class="alert alert-danger">Destination introuvable.</div>
    </div>

<?php else: ?>

    <!-- titre page (style école) -->
    <h3 class="section-title text-center mt-5">
        <?= htmlspecialchars(($destination['pays'] ?? '').' - '.($destination['ville'] ?? '')) ?>
    </h3>

    <div class="container mt-4">

        <!-- bloc infos -->
        <div class="row">

            <!-- image -->
            <div class="col-md-6 mb-3">
                <?php if (!empty($destination['image_url'])): ?>
                    <img src="<?= htmlspecialchars($destination['image_url']) ?>"
                         alt="image"
                         class="img-fluid"
                         style="width:100%; max-height:380px; object-fit:cover; border:1px solid #ccc; padding:2px;">
                <?php else: ?>
                    <div class="alert alert-secondary">Aucune image disponible.</div>
                <?php endif; ?>
            </div>

            <!-- contenu -->
            <div class="col-md-6 mb-3">

                <?php if (!empty($destination['continent'])): ?>
                    <p class="text-muted mb-2"><?= htmlspecialchars($destination['continent']) ?></p>
                <?php endif; ?>

                <?php if (!empty($destination['description'])): ?>
                    <p><?= nl2br(htmlspecialchars($destination['description'])) ?></p>
                <?php endif; ?>

                <p>
                    <strong>Prix base :</strong>
                    <?= number_format((float)($destination['prix_base'] ?? 0), 2, ',', ' ') ?> €
                </p>

                <?php if (!empty($offreActive)): ?>
                    <div class="alert alert-success">
                        Offre active :
                        <strong><?= htmlspecialchars($offreActive['titre'] ?? '') ?></strong>
                        (<?= (int)($offreActive['pourcentage_reduction'] ?? 0) ?>%)
                        <br>
                        Du <?= htmlspecialchars($offreActive['date_debut'] ?? '') ?>
                        au <?= htmlspecialchars($offreActive['date_fin'] ?? '') ?>
                    </div>
                <?php endif; ?>

                <!-- bouton centré style "exemple école" -->
                <div class="d-flex justify-content-center mt-3">
                    <a class="btn btn-sm btn-success"
                       href="index.php?page=reservation&id_destination=<?= (int)$destination['id_destination'] ?>">
                        Réserver
                    </a>
                </div>

            </div>

        </div>
    </div>

<?php endif; ?>
