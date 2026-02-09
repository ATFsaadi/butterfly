<?php
$offres = $offres ?? [];
?>

<div id="voyageBar">
    <?php require_once __DIR__ . "/components/searchOffres.php"; ?>
</div>

<div class="container mt-4">

    <h3 class="section-title text-center mt-5">Offres en cours</h3>

    <?php if (empty($offres)): ?>
        <div class="alert alert-info">aucune offre trouvée.</div>
    <?php else: ?>

        <div class="row g-3">

            <?php foreach ($offres as $o): ?>

                <?php
                $reduc = (int)($o["pourcentage_reduction"] ?? 0);
                $prixBase = (float)($o["prix_base"] ?? 0);
                $prixRemise = $prixBase;

                if ($prixBase > 0 && $reduc > 0) {
                    $prixRemise = $prixBase * (1 - ($reduc / 100));
                }

                $idDest = (int)($o["id_destination"] ?? 0);
                $image = (string)($o["image_url"] ?? "");
                $lieu = trim((string)($o["pays"] ?? "") . " - " . (string)($o["ville"] ?? ""), " -");
                ?>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">

                        <?php if ($image !== ""): ?>
                            <img
                                src="<?= htmlspecialchars($image) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars($lieu) ?>"
                                style="height:180px; object-fit:cover;"
                            >
                        <?php else: ?>
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height:180px;">
                                <span class="text-muted">aucune image</span>
                            </div>
                        <?php endif; ?>

                        <div class="card-body">

                            <?php if ($lieu !== ""): ?>
                                <div class="text-muted small mb-1"><?= htmlspecialchars($lieu) ?></div>
                            <?php endif; ?>

                            <h5 class="card-title"><?= htmlspecialchars((string)($o["titre"] ?? "")) ?></h5>

                            <div class="mb-2">
                                <?php if ($reduc > 0): ?>
                                    <span class="badge bg-success">-<?= $reduc ?>%</span>
                                <?php endif; ?>
                                <small class="text-muted">
                                    du <?= htmlspecialchars((string)($o["date_debut"] ?? "")) ?>
                                    au <?= htmlspecialchars((string)($o["date_fin"] ?? "")) ?>
                                </small>
                            </div>

                            <?php if ($prixBase > 0): ?>
                                <?php if ($reduc > 0): ?>
                                    <div>
                                        <del class="text-muted"><?= number_format($prixBase, 2, ",", " ") ?> €</del>
                                        <strong><?= number_format($prixRemise, 2, ",", " ") ?> €</strong>
                                    </div>
                                <?php else: ?>
                                    <div><strong><?= number_format($prixBase, 2, ",", " ") ?> €</strong></div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="mt-3 d-flex justify-content-center gap-2">

    <a
        class="btn btn-outline-primary btn-sm flex-fill text-center px-3"
        style="max-width:160px"
        href="index.php?page=destination_detail&id_destination=<?= $idDest ?>"
    >
        voir destination
    </a>

    <a
        class="btn btn-success btn-sm flex-fill text-center px-3"
        style="max-width:160px"
        href="index.php?page=destination_detail&id_destination=<?= $idDest ?>"
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
