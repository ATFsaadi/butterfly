<?php if (!empty($offres)): ?>

<h3 class="section-title text-center mt-5">Nos offres</h3>
<p class="section-subtitle text-center mb-4">Meilleures offres pour vos aventures</p>

<div id="offresCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="6000">

    <div class="carousel-indicators">
        <?php foreach ($offres as $i => $offre): ?>
            <button
                type="button"
                data-bs-target="#offresCarousel"
                data-bs-slide-to="<?= (int)$i ?>"
                class="<?= $i === 0 ? "active" : "" ?>"
                aria-current="<?= $i === 0 ? "true" : "false" ?>"
                aria-label="Slide <?= (int)($i + 1) ?>"
            ></button>
        <?php endforeach; ?>
    </div>

    <div class="carousel-inner">

        <?php foreach ($offres as $i => $offre): ?>

            <?php
            $reduc = (int)($offre["pourcentage_reduction"] ?? 0);
            $prixBase = (float)($offre["prix_base"] ?? 0);
            $prixRemise = $prixBase;

            if ($prixBase > 0 && $reduc > 0 && $reduc <= 100) {
                $prixRemise = $prixBase * (1 - ($reduc / 100));
            }

            $img = (string)($offre["image_url"] ?? "");
            $titre = (string)($offre["titre"] ?? "offre");
            $pays = (string)($offre["pays"] ?? "");
            $ville = (string)($offre["ville"] ?? "");
            $dateDebut = (string)($offre["date_debut"] ?? "");
            $dateFin = (string)($offre["date_fin"] ?? "");
            $idDestination = (int)($offre["id_destination"] ?? 0);

            $lieu = trim($pays . " - " . $ville, " -");
            ?>

            <div class="carousel-item <?= $i === 0 ? "active" : "" ?>">
                <div class="row g-0" style="min-height:500px;">

                    <div class="col-md-9">
                        <?php if ($img !== ""): ?>
                            <img
                                src="<?= htmlspecialchars($img) ?>"
                                class="d-block w-100 carousel-image"
                                alt="<?= htmlspecialchars($titre) ?>"
                                style="height:500px; object-fit:cover;"
                            >
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:500px;">
                                <span class="text-muted">image non disponible</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-3 d-flex align-items-stretch" style="background: var(--secondary-color);">
                        <div class="carousel-caption d-flex h-100 w-100 align-items-center justify-content-center" style="position: static; padding: 20px;">
                            <div class="text-center text-white">

                                <h6 class="mb-2">
                                    <?= htmlspecialchars($titre) ?>
                                    <?php if ($reduc > 0): ?>
                                        (-<?= $reduc ?>%)
                                    <?php endif; ?>
                                </h6>

                                <?php if ($lieu !== "" || $dateDebut !== "" || $dateFin !== ""): ?>
                                    <p class="d-none d-md-block mb-3">
                                        <?= htmlspecialchars($lieu) ?><br>
                                        <small>
                                            du <?= htmlspecialchars($dateDebut) ?>
                                            au <?= htmlspecialchars($dateFin) ?>
                                        </small>
                                    </p>
                                <?php endif; ?>

                                <?php if ($prixBase > 0): ?>
                                    <p class="d-none d-md-block mb-3">
                                        <?php if ($reduc > 0): ?>
                                            <del><?= number_format($prixBase, 2, ",", " ") ?> €</del><br>
                                            <strong><?= number_format($prixRemise, 2, ",", " ") ?> €</strong>
                                        <?php else: ?>
                                            <strong><?= number_format($prixBase, 2, ",", " ") ?> €</strong>
                                        <?php endif; ?>
                                        <br><small>prix base</small>
                                    </p>
                                <?php endif; ?>

                                <?php if ($idDestination > 0): ?>
                                    <a
  href="index.php?page=destination_detail&id_destination=<?= $idDestination ?>"
  class="btn btn-outline-light rounded-pill px-4 mt-2 position-relative"
  style="z-index: 9999;"
>
  voir
</a>

                                <?php else: ?>
                                    <a
                                        href="index.php?page=offres"
                                        class="btn btn-outline-light rounded-pill px-4 mt-2"
                                    >
                                        voir les offres
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>

                </div>
            </div>

        <?php endforeach; ?>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#offresCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Précédent</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#offresCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Suivant</span>
    </button>

</div>

<?php endif; ?>
