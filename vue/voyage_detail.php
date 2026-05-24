<?php

// sécurité des données

$voyage = $voyage ?? null;

?>

<!-- détail voyage -->

<?php if (empty($voyage)): ?>

    <!-- voyage introuvable -->

    <div class="container mt-4">
        <div class="alert alert-danger">
            voyage introuvable.
        </div>
    </div>

<?php else: ?>

    <?php
    // données voyage

    $idVoyage = (int) ($voyage["id_voyage"] ?? 0);
    $titre = (string) ($voyage["titre"] ?? "");
    $description = (string) ($voyage["description"] ?? "");
    $dateDepart = (string) ($voyage["date_depart"] ?? "");
    $dateRetour = (string) ($voyage["date_retour"] ?? "");
    $prix = (float) ($voyage["prix"] ?? 0);
    $placesRestantes = (int) ($voyage["nb_places_restantes"] ?? 0);
    $statut = (string) ($voyage["statut"] ?? "");
    $imageVoyage = (string) ($voyage["image_url"] ?? "");

    $pays = (string) ($voyage["pays"] ?? "");
    $ville = (string) ($voyage["ville"] ?? "");
    $continent = (string) ($voyage["continent"] ?? "");
    $imageDestination = (string) ($voyage["destination_image_url"] ?? "");

    $titreLieu = trim($pays . " - " . $ville, " -");
    $image = $imageVoyage !== "" ? $imageVoyage : $imageDestination;

    $idDestination = (int) ($voyage["id_destination"] ?? 0);
    $bloque = ($statut !== "actif" || $placesRestantes <= 0);
    $reservationUrl = "index.php?page=reservation&id_voyage=" . $idVoyage;

    if (!isset($_SESSION["user"])) {
        $reservationUrl = "index.php?page=login&redirect=reservation&id_voyage=" . $idVoyage;
    }
    ?>

    <!-- titre voyage -->

    <h3 class="section-title text-center mt-5">
        <?= htmlspecialchars($titre) ?>
    </h3>

    <!-- carte voyage -->

    <div class="container mt-4 detail-wrap">
        <div class="card detail-card">
            <div class="card-body detail-body">

                <!-- localisation -->

                <?php if ($titreLieu !== ""): ?>
                    <p class="text-muted mb-1 detail-sub">
                        <?= htmlspecialchars($titreLieu) ?>
                    </p>
                <?php endif; ?>

                <?php if ($continent !== ""): ?>
                    <p class="text-muted mb-3 detail-sub">
                        <?= htmlspecialchars($continent) ?>
                    </p>
                <?php endif; ?>

                <!-- informations voyage -->

                <div class="detail-list">

                    <div class="detail-row">
                        <span class="detail-label">dates :</span>
                        <span class="detail-value">
                            <?= htmlspecialchars($dateDepart) ?> au <?= htmlspecialchars($dateRetour) ?>
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">prix :</span>
                        <span class="detail-value">
                            <?= number_format($prix, 2, ",", " ") ?> €
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">places restantes :</span>
                        <span class="detail-value">
                            <?= (int) $placesRestantes ?>
                        </span>
                    </div>

                    <div class="detail-row">
                        <span class="detail-label">statut :</span>
                        <span class="detail-value">
                            <span class="detail-badge <?= $bloque ? "is-closed" : "is-open" ?>">
                                <?= htmlspecialchars($statut) ?>
                            </span>
                        </span>
                    </div>

                </div>

                <!-- description -->

                <?php if ($description !== ""): ?>
                    <div class="detail-desc">
                        <?= nl2br(htmlspecialchars($description)) ?>
                    </div>
                <?php endif; ?>

                <!-- image -->

                <?php if ($image !== ""): ?>
                    <img
                        src="<?= htmlspecialchars($image) ?>"
                        alt="image voyage"
                        class="img-fluid detail-img"
                    >
                <?php else: ?>
                    <div class="alert alert-secondary mb-3">
                        aucune image disponible.
                    </div>
                <?php endif; ?>

                <!-- actions -->

                <div class="detail-actions d-flex justify-content-center gap-2 mt-3">

                    <?php if ($idDestination > 0): ?>
                        <a
                            class="btn btn-outline-primary btn-sm flex-fill text-center px-3 detail-btn"
                            href="index.php?page=destination_detail&id_destination=<?= $idDestination ?>"
                        >
                            voir destination
                        </a>
                    <?php endif; ?>

                    <?php if (!$bloque): ?>
                        <a
                            class="btn btn-success btn-sm flex-fill text-center px-3 detail-btn"
                            href="<?= htmlspecialchars($reservationUrl) ?>"
                        >
                            réserver
                        </a>
                    <?php else: ?>
                        <button
                            class="btn btn-secondary btn-sm flex-fill text-center px-3 detail-btn"
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
