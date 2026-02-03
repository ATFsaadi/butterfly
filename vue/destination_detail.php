<?php

$destination = $destination ?? null;
$offreActive = $offreActive ?? null;

?>

<?php if (empty($destination)): ?>

    <div class="container mt-4">
        <div class="alert alert-danger">destination introuvable.</div>
    </div>

<?php else: ?>

    <?php
    $id = (int) ($destination["id_destination"] ?? 0);
    $pays = $destination["pays"] ?? "";
    $ville = $destination["ville"] ?? "";
    $continent = $destination["continent"] ?? "";
    $description = $destination["description"] ?? "";
    $prixBase = (float) ($destination["prix_base"] ?? 0);
    $image = $destination["image_url"] ?? "";

    $titre = trim($pays . " - " . $ville, " -");
    ?>

    <!-- titre page -->
    <h3 class="section-title text-center mt-5">
        <?= htmlspecialchars($titre) ?>
    </h3>

    <div class="container mt-4">

        <!-- bloc infos -->
        <div class="row">

            <!-- image -->
            <div class="col-md-6 mb-3">
                <?php if ($image !== ""): ?>
                    <img
                        src="<?= htmlspecialchars($image) ?>"
                        alt="image destination"
                        class="img-fluid"
                        style="width:100%; max-height:380px; object-fit:cover; border:1px solid #ccc; padding:2px;"
                    >
                <?php else: ?>
                    <div class="alert alert-secondary">aucune image disponible.</div>
                <?php endif; ?>
            </div>

            <!-- contenu -->
            <div class="col-md-6 mb-3">

                <?php if ($continent !== ""): ?>
                    <p class="text-muted mb-2"><?= htmlspecialchars($continent) ?></p>
                <?php endif; ?>

                <?php if ($description !== ""): ?>
                    <p><?= nl2br(htmlspecialchars($description)) ?></p>
                <?php endif; ?>

                <p>
                    <strong>prix base :</strong>
                    <?= number_format($prixBase, 2, ",", " ") ?> €
                </p>

                <?php if (!empty($offreActive)): ?>
                    <?php
                    $offreTitre = $offreActive["titre"] ?? "";
                    $offreReduc = (int) ($offreActive["pourcentage_reduction"] ?? 0);
                    $offreDebut = $offreActive["date_debut"] ?? "";
                    $offreFin = $offreActive["date_fin"] ?? "";
                    ?>
                    <div class="alert alert-success">
                        offre active :
                        <strong><?= htmlspecialchars($offreTitre) ?></strong>
                        (<?= $offreReduc ?>%)
                        <br>
                        du <?= htmlspecialchars($offreDebut) ?>
                        au <?= htmlspecialchars($offreFin) ?>
                    </div>
                <?php endif; ?>

                <!-- bouton reserver -->
                <div class="d-flex justify-content-center mt-3">
                    <a class="btn btn-sm btn-success" href="index.php?page=reservation&id_destination=<?= $id ?>">
                        réserver
                    </a>
                </div>

            </div>

        </div>
    </div>

<?php endif; ?>
