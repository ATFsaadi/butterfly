<?php

$destinations = $destinations ?? [];
$voyages = $voyages ?? [];
$offres = $offres ?? [];
$successRegister = $successRegister ?? "";
$openLoginAfterRegister = $openLoginAfterRegister ?? false;

$q = trim((string)($_GET["q"] ?? ""));
$pageActuelle = $_GET["page"] ?? "home";
$isRecherche = ($pageActuelle === "recherche");

$totalRecherche = count($destinations) + count($voyages) + count($offres);

?>

<div id="voyageBar" class="w-100 bg-white" style="border-bottom:1px solid #eee;">
    <?php require_once __DIR__ . "/components/searchTout.php"; ?>
</div>

<?php if ($isRecherche): ?>

    <div class="container mt-4">

        <h3 class="section-title text-center mt-5">
            Recherche dans tout le site
        </h3>

        <?php if ($q === ""): ?>

            <div class="alert alert-info">
                Tapez un mot-clé pour rechercher une destination, un voyage ou une offre.
            </div>

        <?php elseif ($totalRecherche === 0): ?>

            <div class="alert alert-info">
                Aucun résultat trouvé pour « <?= htmlspecialchars($q) ?> ».
            </div>

        <?php else: ?>

            <p class="text-center text-muted">
                <?= $totalRecherche ?> résultat(s) trouvé(s) pour « <?= htmlspecialchars($q) ?> ».
            </p>

            <?php if (!empty($destinations)): ?>
                <h4 class="mt-5 mb-3">Destinations</h4>

                <div class="row g-3">
                    <?php foreach ($destinations as $d): ?>
                        <?php
                        $id = (int)($d["id_destination"] ?? 0);
                        $pays = (string)($d["pays"] ?? "");
                        $ville = (string)($d["ville"] ?? "");
                        $prixBase = (float)($d["prix_base"] ?? 0);
                        $image = (string)($d["image_url"] ?? "");
                        $titre = trim($pays . " - " . $ville, " -");
                        ?>

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 grid-card">
                                <div class="grid-media">
                                    <?php if ($image !== ""): ?>
                                        <img src="<?= htmlspecialchars($image) ?>" class="grid-img" alt="<?= htmlspecialchars($titre) ?>">
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

                                <div class="card-body grid-body">
                                    <div class="grid-actions">
                                        <a class="btn btn-outline-primary btn-sm grid-btn"
                                           href="index.php?page=destination_detail&id_destination=<?= $id ?>">
                                            voir détail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


            <?php if (!empty($voyages)): ?>
                <h4 class="mt-5 mb-3">Voyages</h4>

                <div class="row g-3">
                    <?php foreach ($voyages as $v): ?>
                        <?php
                        $id = (int)($v["id_voyage"] ?? 0);
                        $titre = (string)($v["titre"] ?? "");
                        $prix = (float)($v["prix"] ?? 0);
                        $image = (string)($v["image_url"] ?? "");
                        $imageDest = (string)($v["destination_image_url"] ?? "");
                        $img = $image !== "" ? $image : $imageDest;
                        ?>

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 grid-card">
                                <div class="grid-media">
                                    <?php if ($img !== ""): ?>
                                        <img src="<?= htmlspecialchars($img) ?>" class="grid-img" alt="<?= htmlspecialchars($titre) ?>">
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

                                <div class="card-body grid-body">
                                    <div class="grid-actions">
                                        <a class="btn btn-outline-primary btn-sm grid-btn"
                                           href="index.php?page=voyage_detail&id_voyage=<?= $id ?>">
                                            voir détail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


            <?php if (!empty($offres)): ?>
                <h4 class="mt-5 mb-3">Offres</h4>

                <div class="row g-3">
                    <?php foreach ($offres as $o): ?>
                        <?php
                        $idDest = (int)($o["id_destination"] ?? 0);
                        $titre = (string)($o["titre"] ?? "");
                        $image = (string)($o["image_url"] ?? "");
                        $pays = (string)($o["pays"] ?? "");
                        $ville = (string)($o["ville"] ?? "");
                        $lieu = trim($pays . " - " . $ville, " -");

                        $prixBase = (float)($o["prix_base"] ?? 0);
                        $reduc = (int)($o["pourcentage_reduction"] ?? 0);
                        $prixAffiche = $prixBase;

                        if ($prixBase > 0 && $reduc > 0) {
                            $prixAffiche = $prixBase * (1 - ($reduc / 100));
                        }
                        ?>

                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card h-100 grid-card">
                                <div class="grid-media">
                                    <?php if ($reduc > 0): ?>
                                        <span class="grid-sale" data-sale="-<?= $reduc ?>%"></span>
                                    <?php endif; ?>

                                    <?php if ($image !== ""): ?>
                                        <img src="<?= htmlspecialchars($image) ?>" class="grid-img" alt="<?= htmlspecialchars($lieu) ?>">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center bg-light grid-noimg">
                                            <span class="text-muted">aucune image</span>
                                        </div>
                                    <?php endif; ?>

                                    <div class="grid-title-overlay">
                                        <?= htmlspecialchars($titre !== "" ? $titre : $lieu) ?>
                                    </div>

                                    <?php if ($prixAffiche > 0): ?>
                                        <span class="grid-price-badge">
                                            <?= number_format($prixAffiche, 0, ",", " ") ?> €
                                        </span>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body grid-body">
                                    <div class="grid-actions">
                                        <a class="btn btn-outline-primary btn-sm grid-btn"
                                           href="index.php?page=destination_detail&id_destination=<?= $idDest ?>">
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

    <?php if (!empty($voyages)): ?>
        <?php require_once __DIR__ . "/components/carouselVoyages.php"; ?>
    <?php endif; ?>

    <?php if (!empty($offres)): ?>
        <?php require_once __DIR__ . "/components/carouselOffres.php"; ?>
    <?php endif; ?>

<?php endif; ?>


<?php if ($successRegister !== ""): ?>
    <div class="container mt-4">
        <div class="alert alert-success text-center">
            <?= htmlspecialchars($successRegister) ?>
        </div>
    </div>
<?php endif; ?>