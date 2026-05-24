<?php

// sécurité des données

$destination = $destination ?? null;

?>

<!-- détail destination -->

<?php if (empty($destination)): ?>

    <!-- destination introuvable -->

    <div class="container mt-4">
        <div class="alert alert-danger">
            destination introuvable.
        </div>
    </div>

<?php else: ?>

    <?php
    // données destination

    $id = (int) ($destination["id_destination"] ?? 0);
    $pays = (string) ($destination["pays"] ?? "");
    $ville = (string) ($destination["ville"] ?? "");
    $continent = (string) ($destination["continent"] ?? "");
    $description = (string) ($destination["description"] ?? "");
    $prixBase = (float) ($destination["prix_base"] ?? 0);
    $image = (string) ($destination["image_url"] ?? "");

    $titre = trim($pays . " - " . $ville, " -");
    $reservationUrl = "index.php?page=reservation&id_destination=" . $id;

    if (!isset($_SESSION["user"])) {
        $reservationUrl = "index.php?page=login&redirect=reservation&id_destination=" . $id;
    }
    ?>

    <!-- titre destination -->

    <h3 class="section-title text-center mt-5">
        <?= htmlspecialchars($titre) ?>
    </h3>

    <!-- carte destination -->

    <div class="container mt-4 detail-wrap">
        <div class="card detail-card">
            <div class="card-body detail-body">

                <!-- continent -->

                <?php if ($continent !== ""): ?>
                    <p class="text-muted mb-2 detail-sub">
                        <?= htmlspecialchars($continent) ?>
                    </p>
                <?php endif; ?>

                <!-- prix -->

                <div class="detail-list">
                    <div class="detail-row">
                        <span class="detail-label">prix base :</span>
                        <span class="detail-value">
                            <?= number_format($prixBase, 2, ",", " ") ?> €
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
                        alt="image destination"
                        class="img-fluid detail-img"
                    >
                <?php else: ?>
                    <div class="alert alert-secondary mb-3">
                        aucune image disponible.
                    </div>
                <?php endif; ?>

                <!-- actions -->

                <div class="detail-actions d-flex justify-content-center gap-2 mt-3">
                    <a
                        class="btn btn-success btn-sm flex-fill text-center px-3 detail-btn"
                        href="<?= htmlspecialchars($reservationUrl) ?>"
                    >
                        réserver
                    </a>

                    <a
                        class="btn btn-outline-primary btn-sm flex-fill text-center px-3 detail-btn"
                        href="index.php?page=destinations"
                    >
                        retour
                    </a>
                </div>

            </div>
        </div>
    </div>

<?php endif; ?>
