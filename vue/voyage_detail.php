<?php
$voyage = $voyage ?? null;
?>

<?php if (empty($voyage)): ?>

    <div class="container mt-4">
        <div class="alert alert-danger">voyage introuvable.</div>
    </div>

<?php else: ?>

    <?php
    $idVoyage = (int)($voyage["id_voyage"] ?? 0);
    $titre = (string)($voyage["titre"] ?? "");
    $description = (string)($voyage["description"] ?? "");
    $dateDepart = (string)($voyage["date_depart"] ?? "");
    $dateRetour = (string)($voyage["date_retour"] ?? "");
    $prix = (float)($voyage["prix"] ?? 0);
    $placesRestantes = (int)($voyage["nb_places_restantes"] ?? 0);
    $statut = (string)($voyage["statut"] ?? "");
    $imageVoyage = (string)($voyage["image_url"] ?? "");

    $pays = (string)($voyage["pays"] ?? "");
    $ville = (string)($voyage["ville"] ?? "");
    $continent = (string)($voyage["continent"] ?? "");
    $imageDestination = (string)($voyage["destination_image_url"] ?? "");

    $titreLieu = trim($pays . " - " . $ville, " -");
    $img = $imageVoyage !== "" ? $imageVoyage : $imageDestination;

    $idDest = (int)($voyage["id_destination"] ?? 0);
    $bloque = ($statut !== "actif" || $placesRestantes <= 0);
    ?>

    <h3 class="section-title text-center mt-5"><?= htmlspecialchars($titre) ?></h3>

    <div class="container mt-4" style="max-width:700px;">

        <div class="card">
            <div class="card-body">

                <?php if ($titreLieu !== ""): ?>
                    <p class="text-muted mb-1"><?= htmlspecialchars($titreLieu) ?></p>
                <?php endif; ?>

                <?php if ($continent !== ""): ?>
                    <p class="text-muted mb-3"><?= htmlspecialchars($continent) ?></p>
                <?php endif; ?>

                <p class="mb-2">
                    <strong>dates :</strong>
                    <?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?>
                </p>

                <p class="mb-2">
                    <strong>prix :</strong>
                    <?= number_format($prix, 2, ",", " ") ?> €
                </p>

                <p class="mb-2">
                    <strong>places restantes :</strong>
                    <?= $placesRestantes ?>
                </p>

                <p class="mb-3">
                    <strong>statut :</strong>
                    <?= htmlspecialchars($statut) ?>
                </p>

                <?php if ($description !== ""): ?>
                    <p><?= nl2br(htmlspecialchars($description)) ?></p>
                <?php endif; ?>

                <?php if ($img !== ""): ?>
                    <img
                        src="<?= htmlspecialchars($img) ?>"
                        alt="image voyage"
                        class="img-fluid mb-3"
                        style="width:100%; max-height:380px; object-fit:cover; border:1px solid #ccc; padding:2px; border-radius:10px;"
                    >
                <?php else: ?>
                    <div class="alert alert-secondary mb-3">aucune image disponible.</div>
                <?php endif; ?>

                <div class="d-flex justify-content-center gap-2 mt-3">

                    <?php if ($idDest > 0): ?>
                        <a
                            class="btn btn-outline-primary btn-sm flex-fill text-center px-3"
                            style="max-width:140px"
                            href="index.php?page=destination_detail&id_destination=<?= $idDest ?>"
                        >
                            voir destination
                        </a>
                    <?php endif; ?>

                    <?php if (!$bloque): ?>
                       <a
                            class="btn btn-success btn-sm flex-fill text-center px-3"
                            style="max-width:140px"
                            href="index.php?page=reservation&id=<?= $idVoyage ?>"
                        >
                            réserver
                        </a>

                    <?php else: ?>
                        <button
                            class="btn btn-secondary btn-sm flex-fill text-center px-3"
                            style="max-width:140px"
                            disabled
                        >
                            non réservable
                        </button>
                    <?php endif; ?>

                </div>

            </div>
        </div>

    </div>

<?php endif; ?>
