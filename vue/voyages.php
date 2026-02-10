<?php
$voyages = $voyages ?? [];
?>

<div id="voyageBar">
    <?php require_once __DIR__ . "/components/searchVoyages.php"; ?>
</div>

<div class="container mt-4">

    <h3 class="section-title text-center mt-5">Voyages organisés</h3>

    <?php if (empty($voyages)): ?>
        <div class="alert alert-info">aucun voyage trouvé.</div>
    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($voyages as $v): ?>

                <?php
                $id = (int)($v["id_voyage"] ?? 0);
                $titre = (string)($v["titre"] ?? "");
                $pays = (string)($v["pays"] ?? "");
                $ville = (string)($v["ville"] ?? "");
                $continent = (string)($v["continent"] ?? "");
                $dateDepart = (string)($v["date_depart"] ?? "");
                $dateRetour = (string)($v["date_retour"] ?? "");
                $prix = (float)($v["prix"] ?? 0);
                $places = (int)($v["nb_places_restantes"] ?? 0);
                $statut = (string)($v["statut"] ?? "");
                $imgVoyage = (string)($v["image_url"] ?? "");
                $imgDest = (string)($v["destination_image_url"] ?? "");
                $img = $imgVoyage !== "" ? $imgVoyage : $imgDest;

                $lieu = trim($pays . " - " . $ville, " -");
                $alt = trim($titre . " " . $lieu);
                ?>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">

                        <?php if ($img !== ""): ?>
                            <img
                                src="<?= htmlspecialchars($img) ?>"
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

                            <?php if ($lieu !== ""): ?>
                                <div class="text-muted small mb-1"><?= htmlspecialchars($lieu) ?></div>
                            <?php endif; ?>

                            <?php if ($continent !== ""): ?>
                                <div class="text-muted small mb-2"><?= htmlspecialchars($continent) ?></div>
                            <?php endif; ?>

                            <div class="mb-1">
                                <?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?>
                            </div>

                            <div class="mb-2">
                                <strong><?= number_format($prix, 2, ",", " ") ?> €</strong>
                            </div>

                            <div class="mb-2">
                                <?= $places ?> place(s) restante(s)
                            </div>
<div class="d-flex justify-content-center gap-2">

    <!-- BOUTON VOIR DÉTAIL -->
    <?php if (!empty($_SESSION["user"])): ?>
        <a
            class="btn btn-outline-primary btn-sm px-3 flex-fill text-center"
            href="index.php?page=voyage_detail&id_voyage=<?= (int)$id ?>"
            style="max-width:140px"
        >
            voir détail
        </a>
    <?php else: ?>
        <a
            class="btn btn-outline-primary btn-sm px-3 flex-fill text-center"
            href="index.php?page=login&redirect=voyage_detail&id_voyage=<?= (int)$id ?>"
            style="max-width:140px"
        >
            voir détail
        </a>
    <?php endif; ?>


    <!-- BOUTON RÉSERVER -->
    <?php if ($statut === "actif" && $places > 0): ?>

        <?php if (!empty($_SESSION["user"])): ?>
            <a
                class="btn btn-success btn-sm px-3 flex-fill text-center"
                href="index.php?page=reservation&id_voyage=<?= (int)$id ?>"
                style="max-width:140px"
            >
                réserver
            </a>
        <?php else: ?>
            <a
                class="btn btn-success btn-sm px-3 flex-fill text-center"
                href="index.php?page=login&redirect=reservation&id_voyage=<?= (int)$id ?>"
                style="max-width:140px"
            >
                réserver
            </a>
        <?php endif; ?>

    <?php else: ?>
        <button
            class="btn btn-secondary btn-sm px-3 flex-fill text-center"
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

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
