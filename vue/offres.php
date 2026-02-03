<?php
$offres = $offres ?? [];
?>

<div class="container mt-4">

    <h2 class="mb-3">offres en cours</h2>

    <?php if (empty($offres)): ?>
        <div class="alert alert-info">aucune offre active pour le moment.</div>
    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($offres as $o): ?>

                <?php
                // calculs prix

                $reduc = (int) ($o["pourcentage_reduction"] ?? 0);
                $prixBase = (float) ($o["prix_base"] ?? 0);

                $prixRemise = $prixBase;
                if ($prixBase > 0 && $reduc > 0) {
                    $prixRemise = $prixBase * (1 - ($reduc / 100));
                }

                // donnees destination

                $idDestination = (int) ($o["id_destination"] ?? 0);
                $pays = $o["pays"] ?? "";
                $ville = $o["ville"] ?? "";
                $titre = $o["titre"] ?? "";

                $dateDebut = $o["date_debut"] ?? "";
                $dateFin = $o["date_fin"] ?? "";

                $img = $o["image_url"] ?? "";
                $texteLieu = trim($pays . " - " . $ville, " -");
                $alt = trim($pays . " " . $ville);
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
                        <?php endif; ?>

                        <div class="card-body">

                            <div class="text-muted small">
                                <?= htmlspecialchars($texteLieu) ?>
                            </div>

                            <h5 class="card-title"><?= htmlspecialchars($titre) ?></h5>

                            <div class="mb-2">
                                <?php if ($reduc > 0): ?>
                                    <span class="badge bg-success">-<?= $reduc ?>%</span>
                                <?php endif; ?>

                                <small class="text-muted">
                                    du <?= htmlspecialchars($dateDebut) ?>
                                    au <?= htmlspecialchars($dateFin) ?>
                                </small>
                            </div>

                            <?php if ($prixBase > 0): ?>
                                <?php if ($reduc > 0): ?>
                                    <div>
                                        <del class="text-muted"><?= number_format($prixBase, 2, ",", " ") ?> €</del>
                                        <strong><?= number_format($prixRemise, 2, ",", " ") ?> €</strong>
                                    </div>
                                <?php else: ?>
                                    <div>
                                        <strong><?= number_format($prixBase, 2, ",", " ") ?> €</strong>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="mt-3 d-flex gap-2">

                                <!-- lien destination -->
                                <a
                                    class="btn btn-outline-primary"
                                    href="index.php?page=destination_detail&id_destination=<?= $idDestination ?>"
                                >
                                    voir destination
                                </a>

                                <!-- lien reservation -->
                                <a
                                    class="btn btn-primary"
                                    href="index.php?page=reservation&id_destination=<?= $idDestination ?>"
                                >
                                    réserver
                                </a>

                            </div>

                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>
