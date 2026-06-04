<?php

// Vue voyages : affiche les voyages actifs et les actions de reservation.

// sécurité des données

$voyages = $voyages ?? [];

// affichage progressif

$step = 9;
$limit = max($step, (int) ($_GET["limit"] ?? $step));

$total = count($voyages);
$items = array_slice(array_values($voyages), 0, $limit);

// paramètres afficher plus

$params = $_GET;
$params["limit"] = $limit + $step;

$queryMore = http_build_query($params);

?>

<!-- barre recherche voyages -->

<div id="voyageBar">
    <?php require_once __DIR__ . "/components/searchVoyages.php"; ?>
</div>

<!-- liste voyages -->

<div class="container mt-4">
    <h3 class="section-title text-center mt-5">Voyages organisés</h3>

    <!-- aucun voyage -->

    <?php if (empty($voyages)): ?>
        <div class="alert alert-info">
            aucun voyage trouvé.
        </div>
    <?php else: ?>

        <!-- cartes voyages -->

        <div class="row g-3">
            <?php foreach ($items as $voyage): ?>
                <?php
                $id = (int) ($voyage["id_voyage"] ?? 0);
                $titre = (string) ($voyage["titre"] ?? "");
                $prix = (float) ($voyage["prix"] ?? 0);
                $places = (int) ($voyage["nb_places_restantes"] ?? 0);
                $statut = (string) ($voyage["statut"] ?? "");

                $imageVoyage = (string) ($voyage["image_url"] ?? "");
                $imageDestination = (string) ($voyage["destination_image_url"] ?? "");
                $image = $imageVoyage !== "" ? $imageVoyage : $imageDestination;

                $pays = (string) ($voyage["pays"] ?? "");
                $ville = (string) ($voyage["ville"] ?? "");
                $lieu = trim($pays . " - " . $ville, " -");
                $alt = trim($titre . " " . $lieu);

                $bloque = ($statut !== "actif" || $places <= 0);
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
                                    alt="<?= htmlspecialchars($alt) ?>"
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

                        <!-- actions voyage -->

                        <div class="card-body grid-body">
                            <div class="grid-actions">

                                <!-- détail voyage -->

                                <?php if (!empty($_SESSION["user"])): ?>
                                    <a
                                        class="btn btn-outline-primary btn-sm grid-btn"
                                        href="index.php?page=voyage_detail&id_voyage=<?= $id ?>"
                                    >
                                        voir détail
                                    </a>
                                <?php else: ?>
                                    <a
                                        class="btn btn-outline-primary btn-sm grid-btn"
                                        href="index.php?page=login&redirect=voyage_detail&id_voyage=<?= $id ?>"
                                    >
                                        voir détail
                                    </a>
                                <?php endif; ?>

                                <!-- réservation voyage -->

                                <?php if (!$bloque): ?>
                                    <?php if (!empty($_SESSION["user"])): ?>
                                        <a
                                            class="btn btn-success btn-sm grid-btn"
                                            href="index.php?page=reservation&id_voyage=<?= $id ?>"
                                        >
                                            réserver
                                        </a>
                                    <?php else: ?>
                                        <a
                                            class="btn btn-success btn-sm grid-btn"
                                            href="index.php?page=login&redirect=reservation&id_voyage=<?= $id ?>"
                                        >
                                            réserver
                                        </a>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm grid-btn" disabled>
                                        non réservable
                                    </button>
                                <?php endif; ?>

                            </div>
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
