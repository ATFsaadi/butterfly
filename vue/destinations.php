<?php

// sécurité des données

$destinations = $destinations ?? [];

// affichage progressif

$step = 9;
$limit = max($step, (int) ($_GET["limit"] ?? $step));

$total = count($destinations);
$items = array_slice(array_values($destinations), 0, $limit);

// paramètres afficher plus

$params = $_GET;
$params["limit"] = $limit + $step;

$queryMore = http_build_query($params);

?>

<!-- barre recherche destinations -->

<div id="voyageBar">
    <?php require_once __DIR__ . "/components/searchDestinations.php"; ?>
</div>

<!-- liste destinations -->

<div class="container mt-4">
    <h3 class="section-title text-center mt-5">destinations en cours</h3>

    <!-- aucune destination -->

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">
            aucune destination trouvée.
        </div>
    <?php else: ?>

        <!-- cartes destinations -->

        <div class="row g-3">
            <?php foreach ($items as $destination): ?>
                <?php
                $id = (int) ($destination["id_destination"] ?? 0);
                $pays = (string) ($destination["pays"] ?? "");
                $ville = (string) ($destination["ville"] ?? "");
                $prixBase = (float) ($destination["prix_base"] ?? 0);
                $image = (string) ($destination["image_url"] ?? "");

                $titre = trim($pays . " - " . $ville, " -");
                $alt = trim($pays . " " . $ville);
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

                            <?php if ($prixBase > 0): ?>
                                <span class="grid-price-badge">
                                    <?= number_format($prixBase, 0, ",", " ") ?> €
                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- actions destination -->

                        <div class="card-body grid-body">
                            <?php if ($id > 0): ?>
                                <div class="grid-actions">

                                    <?php if (!empty($_SESSION["user"])): ?>
                                        <a
                                            class="btn btn-outline-primary btn-sm grid-btn"
                                            href="index.php?page=destination_detail&id_destination=<?= $id ?>"
                                        >
                                            voir détail
                                        </a>

                                        <a
                                            class="btn btn-success btn-sm grid-btn"
                                            href="index.php?page=destination_detail&id_destination=<?= $id ?>"
                                        >
                                            réserver
                                        </a>
                                    <?php else: ?>
                                        <a
                                            class="btn btn-outline-primary btn-sm grid-btn"
                                            href="index.php?page=login&redirect=destination_detail&id_destination=<?= $id ?>"
                                        >
                                            voir détail
                                        </a>

                                        <a
                                            class="btn btn-success btn-sm grid-btn"
                                            href="index.php?page=login&redirect=destination_detail&id_destination=<?= $id ?>"
                                        >
                                            réserver
                                        </a>
                                    <?php endif; ?>

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