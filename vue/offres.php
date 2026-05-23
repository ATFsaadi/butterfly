<?php

// sécurité des données

$offres = $offres ?? [];

// affichage progressif

$step = 9;
$limit = max($step, (int) ($_GET["limit"] ?? $step));

$total = count($offres);
$items = array_slice(array_values($offres), 0, $limit);

// paramètres afficher plus

$params = $_GET;
$params["limit"] = $limit + $step;

$queryMore = http_build_query($params);

?>

<!-- barre recherche offres -->

<div id="voyageBar">
    <?php require_once __DIR__ . "/components/searchOffres.php"; ?>
</div>

<!-- liste offres -->

<div class="container mt-4">
    <h3 class="section-title text-center mt-5">Offres en cours</h3>

    <!-- aucune offre -->

    <?php if (empty($offres)): ?>
        <div class="alert alert-info">
            aucune offre trouvée.
        </div>
    <?php else: ?>

        <!-- cartes offres -->

        <div class="row g-3">
            <?php foreach ($items as $offre): ?>
                <?php
                $reduc = (int) ($offre["pourcentage_reduction"] ?? 0);
                $prixBase = (float) ($offre["prix_base"] ?? 0);
                $prixRemise = $prixBase;

                if ($prixBase > 0 && $reduc > 0) {
                    $prixRemise = $prixBase * (1 - ($reduc / 100));
                }

                $idDestination = (int) ($offre["id_destination"] ?? 0);
                $image = (string) ($offre["image_url"] ?? "");
                $titre = (string) ($offre["titre"] ?? "");

                $pays = (string) ($offre["pays"] ?? "");
                $ville = (string) ($offre["ville"] ?? "");
                $lieu = trim($pays . " - " . $ville, " -");

                $hrefDetail = !empty($_SESSION["user"])
                    ? "index.php?page=destination_detail&id_destination=" . $idDestination
                    : "index.php?page=login&redirect=destination_detail&id_destination=" . $idDestination;

                $hrefReserver = !empty($_SESSION["user"])
                    ? "index.php?page=reservation&id_destination=" . $idDestination
                    : "index.php?page=login&redirect=reservation&id_destination=" . $idDestination;

                $prixAffiche = $reduc > 0 ? $prixRemise : $prixBase;
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

                        <!-- actions offre -->

                        <div class="card-body grid-body">
                            <?php if ($idDestination > 0): ?>
                                <div class="grid-actions">
                                    <a
                                        class="btn btn-outline-primary btn-sm grid-btn"
                                        href="<?= htmlspecialchars($hrefDetail) ?>"
                                    >
                                        voir détail
                                    </a>

                                    <a
                                        class="btn btn-success btn-sm grid-btn"
                                        href="<?= htmlspecialchars($hrefReserver) ?>"
                                    >
                                        réserver
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- bouton afficher plus -->

        <?php if ($limit < $total): ?>
            <div class="d-flex justify-content-center mt-4">
                <a
                    class="btn btn-outline-primary btn-sm grid-btn"
                    href="?<?= htmlspecialchars($queryMore) ?>"
                >
                    afficher plus
                </a>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</div>