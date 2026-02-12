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

            $href = "index.php?page=voyage_detail&id_voyage=" . (int)$idVoyage;
            ?>

            <div class="carousel-item <?= $i === 0 ? "active" : "" ?>">
                <div class="row g-0 voyage-row">

                    <!-- IMAGE À GAUCHE -->
                    <div class="col-md-9">
                        <?php if ($img !== ""): ?>
                            <img
                                src="<?= htmlspecialchars($img) ?>"
                                class="d-block w-100 carousel-image"
                                alt="<?= htmlspecialchars($titre) ?>"
                            >
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light voyage-noimg">
                                <span class="text-muted">image non disponible</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- PANNEAU À DROITE CLIQUABLE (COMME OFFRES) -->
                    <a href="<?= htmlspecialchars($href) ?>" class="col-md-3 d-flex align-items-stretch voyage-link">
                        <div class="carousel-caption d-flex h-100 w-100 align-items-center justify-content-center"
                             style="position: static; padding: 20px;">
                            <div class="text-center text-white">

                                <?php if ($titre !== ""): ?>
                                    <h6 class="mb-2"><?= htmlspecialchars($titre) ?></h6>
                                <?php endif; ?>

                                <?php if ($lieu !== "" || $continent !== "" || $dateDepart !== "" || $dateRetour !== ""): ?>
                                    <p class="d-none d-md-block mb-3">
                                        <?= htmlspecialchars($lieu) ?>
                                        <?php if ($continent !== ""): ?>
                                            <br><small><?= htmlspecialchars($continent) ?></small>
                                        <?php endif; ?>
                                        <br>
                                        <small>
                                            <?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?>
                                        </small>
                                    </p>
                                <?php endif; ?>

                                <?php if ($prix > 0): ?>
                                    <p class="d-none d-md-block mb-0">
                                        <strong><?= number_format($prix, 2, ",", " ") ?> €</strong>
                                        <br><small>prix</small>
                                    </p>
                                <?php endif; ?>

                            </div>
                        </div>
                    </a>

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
