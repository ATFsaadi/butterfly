<?php
$destination = $destination ?? null;
?>

<?php if (empty($destination)): ?>

    <div class="container mt-4">
        <div class="alert alert-danger">destination introuvable.</div>
    </div>

<?php else: ?>

    <?php
    $id = (int)($destination["id_destination"] ?? 0);
    $pays = (string)($destination["pays"] ?? "");
    $ville = (string)($destination["ville"] ?? "");
    $continent = (string)($destination["continent"] ?? "");
    $description = (string)($destination["description"] ?? "");
    $prixBase = (float)($destination["prix_base"] ?? 0);
    $image = (string)($destination["image_url"] ?? "");

    $titre = trim($pays . " - " . $ville, " -");
    ?>

    <h3 class="section-title text-center mt-5">
        <?= htmlspecialchars($titre) ?>
    </h3>

    <div class="container mt-4" style="max-width:700px;">

        <div class="card">
            <div class="card-body">

                <?php if ($continent !== ""): ?>
                    <p class="text-muted mb-2"><?= htmlspecialchars($continent) ?></p>
                <?php endif; ?>

                <p class="mb-2">
                    <strong>prix base :</strong>
                    <?= number_format($prixBase, 2, ",", " ") ?> €
                </p>

                <?php if ($description !== ""): ?>
                    <p><?= nl2br(htmlspecialchars($description)) ?></p>
                <?php endif; ?>

                <?php if ($image !== ""): ?>
                    <img
                        src="<?= htmlspecialchars($image) ?>"
                        alt="image destination"
                        class="img-fluid mb-3"
                        style="width:100%; max-height:380px; object-fit:cover; border:1px solid #ccc; padding:2px; border-radius:10px;"
                    >
                <?php else: ?>
                    <div class="alert alert-secondary mb-3">aucune image disponible.</div>
                <?php endif; ?>

                <div class="d-flex justify-content-center gap-2 mt-3">

                    <a
                        class="btn btn-success btn-sm flex-fill text-center px-3"
                        style="max-width:140px"
                        href="index.php?page=reservation&id_destination=<?= $id ?>"
                    >
                        réserver
                    </a>

                    <a
                        class="btn btn-outline-primary btn-sm flex-fill text-center px-3"
                        style="max-width:140px"
                        href="index.php?page=destinations"
                    >
                        retour
                    </a>

                </div>

            </div>
        </div>

    </div>

<?php endif; ?>
