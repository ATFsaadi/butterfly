<?php
$destinations = $destinations ?? [];
?>

<div id="voyageBar">
    <?php require_once __DIR__ . "/components/searchDestinations.php"; ?>
</div>

<div class="container mt-4">

    <h3 class="section-title text-center mt-5">destinations en cours</h3>

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">aucune destination trouvée.</div>
    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($destinations as $d): ?>

                <?php
                $id = (int)($d["id_destination"] ?? 0);
                $pays = (string)($d["pays"] ?? "");
                $ville = (string)($d["ville"] ?? "");
                $continent = (string)($d["continent"] ?? "");
                $prixBase = (float)($d["prix_base"] ?? 0);
                $image = (string)($d["image_url"] ?? "");

                $titre = trim($pays . " - " . $ville, " -");
                $alt = trim($pays . " " . $ville);
                ?>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">

                        <?php if ($image !== ""): ?>
                            <img
                                src="<?= htmlspecialchars($image) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($alt) ?>"
                                style="height:180px; object-fit:cover;"
                            >
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:180px;">
                                <span class="text-muted">aucune image</span>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">

                            <h5 class="card-title"><?= htmlspecialchars($titre) ?></h5>

                            <?php if ($continent !== ""): ?>
                                <div class="text-muted small mb-2">
                                    <?= htmlspecialchars($continent) ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-2">
                                <strong><?= number_format($prixBase, 2, ",", " ") ?> €</strong>
                                <span class="text-muted">(prix base)</span>
                            </div>

                            <?php if ($id > 0): ?>
    <div class="d-flex justify-content-center gap-2">

    <?php if (!empty($_SESSION["user"])): ?>
        <!-- UTILISATEUR CONNECTÉ -->
        <a
            class="btn btn-outline-primary btn-sm flex-fill text-center px-3"
            style="max-width:140px"
            href="index.php?page=destination_detail&id_destination=<?= (int)$id ?>"
        >
            voir détail
        </a>

        <a
            class="btn btn-success btn-sm flex-fill text-center px-3"
            style="max-width:140px"
            href="index.php?page=destination_detail&id_destination=<?= (int)$id ?>"
        >
            réserver
        </a>

    <?php else: ?>
        <!-- UTILISATEUR NON CONNECTÉ -->
        <a
            class="btn btn-outline-primary btn-sm flex-fill text-center px-3"
            style="max-width:140px"
            href="index.php?page=login&redirect=destination_detail&id_destination=<?= (int)$id ?>"
        >
            voir détail
        </a>

        <a
            class="btn btn-success btn-sm flex-fill text-center px-3"
            style="max-width:140px"
            href="index.php?page=login&redirect=destination_detail&id_destination=<?= (int)$id ?>"
        >
            réserver
        </a>
    <?php endif; ?>

</div>

<?php else: ?>
    <div class="d-flex justify-content-center">
        <button class="btn btn-secondary btn-sm px-3" disabled>
            indisponible
        </button>
    </div>
<?php endif; ?>


                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
