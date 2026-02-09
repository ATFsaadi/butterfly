<?php if (!empty($voyages)): ?>

<h3 class="section-title text-center mt-5">Coup de cœur</h3>

<div id="mainCarousel" class="carousel slide mt-4" data-bs-ride="carousel" data-bs-interval="6000">

    <div class="carousel-indicators">
        <?php foreach ($voyages as $i => $v): ?>
            <button
                type="button"
                data-bs-target="#mainCarousel"
                data-bs-slide-to="<?= (int)$i ?>"
                class="<?= $i === 0 ? "active" : "" ?>"
                aria-current="<?= $i === 0 ? "true" : "false" ?>"
                aria-label="Slide <?= (int)($i + 1) ?>"
            ></button>
        <?php endforeach; ?>
    </div>

    <div class="carousel-inner">

        <?php foreach ($voyages as $i => $v): ?>

            <?php
            $idVoyage = (int)($v["id_voyage"] ?? 0);
            $titre = (string)($v["titre"] ?? "");
            $imgVoyage = (string)($v["image_url"] ?? "");
            $imgDest = (string)($v["destination_image_url"] ?? "");
            $img = $imgVoyage !== "" ? $imgVoyage : $imgDest;

            $pays = (string)($v["pays"] ?? "");
            $ville = (string)($v["ville"] ?? "");
            $continent = (string)($v["continent"] ?? "");
            $lieu = trim($pays . " - " . $ville, " -");
            $dateDepart = (string)($v["date_depart"] ?? "");
            $dateRetour = (string)($v["date_retour"] ?? "");
            $prix = (float)($v["prix"] ?? 0);
            $places = (int)($v["nb_places_restantes"] ?? 0);
            $statut = (string)($v["statut"] ?? "");
            ?>

            <div class="carousel-item <?= $i === 0 ? "active" : "" ?>">

                <?php if ($img !== ""): ?>
                    <img
                        src="<?= htmlspecialchars($img) ?>"
                        class="d-block w-100 carousel-image"
                        alt="<?= htmlspecialchars($titre) ?>"
                        style="max-height:500px; object-fit:cover;"
                    >
                <?php else: ?>
                    <div class="d-flex align-items-center justify-content-center bg-light" style="height:500px;">
                        <span class="text-muted">image non disponible</span>
                    </div>
                <?php endif; ?>

                <div class="carousel-caption d-flex h-100 align-items-center justify-content-center">
                    <div class="text-center text-white" style="text-shadow:0 2px 10px rgba(0,0,0,.6);">

                        <?php if ($titre !== ""): ?>
                            <h6 class="mb-2"><?= htmlspecialchars($titre) ?></h6>
                        <?php endif; ?>

                        <p class="d-none d-md-block mb-3">
                            <?= htmlspecialchars($lieu) ?>
                            <?php if ($continent !== ""): ?>
                                · <?= htmlspecialchars($continent) ?>
                            <?php endif; ?>
                            <br>
                            <small>
                                <?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?>
                            </small>
                            <?php if ($prix > 0): ?>
                                <br>
                                <strong><?= number_format($prix, 2, ",", " ") ?> €</strong>
                            <?php endif; ?>
                        </p>

                        <div class="d-flex justify-content-center gap-2">

    <a
        href="index.php?page=voyage_detail&id_voyage=<?= $idVoyage ?>"
        class="btn btn-outline-light rounded-pill px-4 mt-2"
    >
        détails
    </a>

    <?php if ($statut === "actif" && $places > 0): ?>

        <?php if (!empty($_SESSION["user"])): ?>
            <a
                href="index.php?page=reservation&id_voyage=<?= $idVoyage ?>"
                class="btn btn-light rounded-pill px-4 mt-2"
            >
                réserver
            </a>
        <?php else: ?>
            <a
                href="index.php?page=login&redirect=reservation&id_voyage=<?= $idVoyage ?>"
                class="btn btn-light rounded-pill px-4 mt-2"
            >
                réserver
            </a>
        <?php endif; ?>

    <?php endif; ?>

</div>


                    </div>
                </div>

            </div>

        <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Précédent</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Suivant</span>
    </button>

</div>

<?php endif; ?>
