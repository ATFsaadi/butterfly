<?php

// valeurs par defaut

$destinations = $destinations ?? [];

?>

<div class="container-fluid">

    <!-- composant recherche destinations -->
    <?php require_once __DIR__ . "/components/searchDestinations.php"; ?>

</div>

<div class="container mt-4">

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">aucune destination trouvée.</div>
    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($destinations as $d): ?>

                <?php
                $id = (int) ($d["id_destination"] ?? 0);
                $pays = $d["pays"] ?? "";
                $ville = $d["ville"] ?? "";
                $continent = $d["continent"] ?? "";
                $prixBase = (float) ($d["prix_base"] ?? 0);
                $image = $d["image_url"] ?? "";

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
                        <?php endif; ?>

                        <div class="card-body">

                            <h5 class="card-title">
                                <?= htmlspecialchars($titre) ?>
                            </h5>

                            <?php if ($continent !== ""): ?>
                                <div class="text-muted small mb-2">
                                    <?= htmlspecialchars($continent) ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-2">
                                <strong><?= number_format($prixBase, 2, ",", " ") ?> €</strong>
                                <span class="text-muted">(prix base)</span>
                            </div>

                            <a
                                class="btn btn-outline-primary"
                                href="index.php?page=destination_detail&id_destination=<?= $id ?>"
                            >
                                voir détail
                            </a>

                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
