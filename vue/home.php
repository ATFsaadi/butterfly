<?php

// sécurité des données

$destinations = $destinations ?? [];
$voyages = $voyages ?? [];
$offres = $offres ?? [];
$successRegister = $successRegister ?? "";
$openLoginAfterRegister = $openLoginAfterRegister ?? false;

// paramètres de recherche

$q = trim((string) ($_GET["q"] ?? ""));
$pageActuelle = $_GET["page"] ?? "home";
$isRecherche = ($pageActuelle === "recherche");

$totalRecherche = count($destinations) + count($voyages) + count($offres);

?>

<!-- barre recherche globale -->

<div id="voyageBar" class="w-100" style="border-bottom:1px solid #eee;">
    <?php require_once __DIR__ . "/components/searchTout.php"; ?>
</div>

<?php if ($isRecherche): ?>

    <!-- résultats recherche -->

    <div class="container mt-4">
        <h3 class="section-title text-center mt-5">
            Recherche dans tout le site
        </h3>

        <!-- aucun mot-clé -->

        <?php if ($q === ""): ?>
            <div class="alert alert-info">
                Tapez un mot-clé pour rechercher une destination, un voyage ou une offre.
            </div>

        <!-- aucun résultat -->

        <?php elseif ($totalRecherche === 0): ?>
            <div class="alert alert-info">
                Aucun résultat trouvé pour « <?= htmlspecialchars($q) ?> ».
            </div>

        <?php else: ?>

            <!-- nombre résultats -->

            <p class="text-center text-muted">
                <?= (int) $totalRecherche ?> résultat(s) trouvé(s) pour « <?= htmlspecialchars($q) ?> ».
            </p>

            <!-- résultats destinations -->

            <?php if (!empty($destinations)): ?>
                <h4 class="mt-5 mb-3">Destinations</h4>

                <div class="row g-3">
                    <?php foreach ($destinations as $destination): ?>
                        <?php
                        $id = (int) ($destination["id_destination"] ?? 0);
                        $pays = (string) ($destination["pays"] ?? "");
                        $ville = (string) ($destination["ville"] ?? "");
                        $prixBase = (float) ($destination["prix_base"] ?? 0);
                        $image = (string) ($destination["image_url"] ?? "");

                        $titre = trim($pays . " - " . $ville, " -");
                        ?>

                        <!-- carte destination -->

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 grid-card">

                                <!-- image destination -->

                                <div class="grid-media">
                                    <?php if ($image !== ""): ?>
                                        <img
                                            src="<?= htmlspecialchars($image) ?>"
                                            class="grid-img"
                                            alt="<?= htmlspecialchars($titre) ?>"
                                        >
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light grid-noimg">
                                            <span class="text-muted">aucune image</span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="grid-title-overlay">
                                        <?= htmlspecialchars($titre) ?>
                                    </div>

                                    <?php if ($prixBase > 0): ?>
                                        <span class="grid-price-badge">
                                            <?= number_format($prixBase, 0, ",", " ") ?> €
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- action destination -->

                                <div class="card-body grid-body">
                                    <div class="grid-actions">
                                        <a
                                            class="btn btn-outline-primary btn-sm grid-btn"
                                            href="index.php?page=destination_detail&id_destination=<?= $id ?>"
                                        >
                                            voir détail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- résultats voyages -->

            <?php if (!empty($voyages)): ?>
                <h4 class="mt-5 mb-3">Voyages</h4>

                <div class="row g-3">
                    <?php foreach ($voyages as $voyage): ?>
                        <?php
                        $id = (int) ($voyage["id_voyage"] ?? 0);
                        $titre = (string) ($voyage["titre"] ?? "");
                        $prix = (float) ($voyage["prix"] ?? 0);

                        $imageVoyage = (string) ($voyage["image_url"] ?? "");
                        $imageDestination = (string) ($voyage["destination_image_url"] ?? "");
                        $image = $imageVoyage !== "" ? $imageVoyage : $imageDestination;
                        ?>

                        <!-- carte voyage -->

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 grid-card">

                                <!-- image voyage -->

                                <div class="grid-media">
                                    <?php if ($image !== ""): ?>
                                        <img
                                            src="<?= htmlspecialchars($image) ?>"
                                            class="grid-img"
                                            alt="<?= htmlspecialchars($titre) ?>"
                                        >
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light grid-noimg">
                                            <span class="text-muted">aucune image</span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="grid-title-overlay">
                                        <?= htmlspecialchars($titre) ?>
                                    </div>

                                    <?php if ($prix > 0): ?>
                                        <span class="grid-price-badge">
                                            <?= number_format($prix, 0, ",", " ") ?> €
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- action voyage -->

                                <div class="card-body grid-body">
                                    <div class="grid-actions">
                                        <a
                                            class="btn btn-outline-primary btn-sm grid-btn"
                                            href="index.php?page=voyage_detail&id_voyage=<?= $id ?>"
                                        >
                                            voir détail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- résultats offres -->

            <?php if (!empty($offres)): ?>
                <h4 class="mt-5 mb-3">Offres</h4>

                <div class="row g-3">
                    <?php foreach ($offres as $offre): ?>
                        <?php
                        $idDestination = (int) ($offre["id_destination"] ?? 0);
                        $titre = (string) ($offre["titre"] ?? "");
                        $image = (string) ($offre["image_url"] ?? "");

                        $pays = (string) ($offre["pays"] ?? "");
                        $ville = (string) ($offre["ville"] ?? "");
                        $lieu = trim($pays . " - " . $ville, " -");

                        $prixBase = (float) ($offre["prix_base"] ?? 0);
                        $reduc = (int) ($offre["pourcentage_reduction"] ?? 0);
                        $prixAffiche = $prixBase;

                        if ($prixBase > 0 && $reduc > 0) {
                            $prixAffiche = $prixBase * (1 - ($reduc / 100));
                        }

                        $titreAffiche = $titre !== "" ? $titre : $lieu;
                        ?>

                        <!-- carte offre -->

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 grid-card">

                                <!-- image offre -->

                                <div class="grid-media">
                                    <?php if ($reduc > 0): ?>
                                        <span class="grid-sale" data-sale="-<?= (int) $reduc ?>%"></span>
                                    <?php endif; ?>

                                    <?php if ($image !== ""): ?>
                                        <img
                                            src="<?= htmlspecialchars($image) ?>"
                                            class="grid-img"
                                            alt="<?= htmlspecialchars($lieu) ?>"
                                        >
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light grid-noimg">
                                            <span class="text-muted">aucune image</span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="grid-title-overlay">
                                        <?= htmlspecialchars($titreAffiche) ?>
                                    </div>

                                    <?php if ($prixAffiche > 0): ?>
                                        <span class="grid-price-badge">
                                            <?= number_format($prixAffiche, 0, ",", " ") ?> €
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <!-- action offre -->

                                <div class="card-body grid-body">
                                    <div class="grid-actions">
                                        <a
                                            class="btn btn-outline-primary btn-sm grid-btn"
                                            href="index.php?page=destination_detail&id_destination=<?= $idDestination ?>"
                                        >
                                            voir détail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>

<?php else: ?>

    <!-- accueil carrousels -->

    <?php if (!empty($voyages)): ?>
        <?php require_once __DIR__ . "/components/carouselVoyages.php"; ?>
    <?php endif; ?>

    <?php if (!empty($offres)): ?>
        <?php require_once __DIR__ . "/components/carouselOffres.php"; ?>
    <?php endif; ?>

<?php endif; ?>

<!-- message inscription -->

<?php if ($successRegister !== ""): ?>
    <div class="container mt-4">
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($successRegister) ?>
        </div>
    </div>
<?php endif; ?>
