<?php
$destination = $destination ?? null;
$voyages = $voyages ?? [];
?>

<?php if (empty($destination)): ?>
    <div class="container py-5">
        <div class="alert alert-danger">Destination introuvable.</div>
    </div>
    <?php return; ?>
<?php endif; ?>

<div class="container py-5">

    <h2 class="section-title text-center mb-4">
        <?= htmlspecialchars((string)$destination['nom']) ?>
    </h2>

    <div class="row align-items-center g-4">

        <div class="col-md-6">
            <?php if (!empty($destination['image'])): ?>
                <img
                    src="images/destinations/<?= htmlspecialchars((string)$destination['image']) ?>"
                    class="img-fluid rounded shadow-sm"
                    alt="<?= htmlspecialchars((string)$destination['nom']) ?>"
                    style="width:100%; max-height:420px; object-fit:cover;"
                >
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h5 class="mb-2">
                <?= htmlspecialchars((string)($destination['ville'] ?? '')) ?>
                <?php if (!empty($destination['continent_nom'])): ?>
                    — <?= htmlspecialchars((string)$destination['continent_nom']) ?>
                <?php endif; ?>
            </h5>

            <?php if (!empty($destination['description'])): ?>
                <p><?= nl2br(htmlspecialchars((string)$destination['description'])) ?></p>
            <?php endif; ?>

            <div class="mt-4">
                <a href="index.php?page=destinations" class="btn btn-outline-secondary px-4">
                    Retour aux destinations
                </a>
            </div>
        </div>

    </div>

    <hr class="my-5">

    <h4 class="mb-3">Voyages disponibles</h4>

    <?php if (empty($voyages)): ?>
        <div class="alert alert-info">Aucun voyage disponible pour cette destination.</div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach ($voyages as $v): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">

                        <?php if (!empty($v['image'])): ?>
                            <img
                                src="images/voyages/<?= htmlspecialchars((string)$v['image']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars((string)$v['titre']) ?>"
                                style="height:220px; object-fit:cover;"
                            >
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title mb-1"><?= htmlspecialchars((string)$v['titre']) ?></h5>

                            <div class="small text-muted mb-2">
                                📅 <?= htmlspecialchars((string)($v['date_depart'] ?? '')) ?>
                                → <?= htmlspecialchars((string)($v['date_retour'] ?? '')) ?>
                            </div>

                            <ul class="list-unstyled small mb-0">
                                <li>👤 Adulte : <strong><?= number_format((float)$v['prix_adulte'], 2, ',', ' ') ?> €</strong></li>
                                <li>🧒 Enfant : <strong><?= number_format((float)$v['prix_enfant'], 2, ',', ' ') ?> €</strong></li>
                                <li>👶 Bébé : <strong><?= number_format((float)$v['prix_bebe'], 2, ',', ' ') ?> €</strong></li>
                            </ul>
                        </div>

                        <div class="card-footer bg-white border-0">
                            <a
                                href="index.php?page=voyage_detail&id=<?= (int)$v['id_voyage'] ?>"
                                class="btn btn-outline-primary w-100"
                            >
                                Voir plus
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

</div>
