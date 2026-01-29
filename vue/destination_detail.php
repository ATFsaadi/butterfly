<?php

/* valeurs par defaut */
$destination = $destination ?? null;
$voyages = $voyages ?? [];

?>

<!-- verification destination -->
<?php if (empty($destination)): ?>
    <div class="container py-5">
        <div class="alert alert-danger">Destination introuvable.</div>
    </div>
    <?php return; ?>
<?php endif; ?>

<!-- page destination -->
<div class="container py-5">

    <!-- titre destination -->
    <h2 class="section-title text-center mb-4">
        <?= htmlspecialchars((string) $destination['nom']) ?>
    </h2>

    <!-- bloc infos destination -->
    <div class="row align-items-center g-4">

        <!-- image destination -->
        <div class="col-md-6">
            <?php if (!empty($destination['image'])): ?>
                <img
                    src="images/destinations/<?= htmlspecialchars((string) $destination['image']) ?>"
                    class="img-fluid rounded shadow-sm"
                    alt="<?= htmlspecialchars((string) $destination['nom']) ?>"
                    style="width:100%; max-height:420px; object-fit:cover;"
                >
            <?php endif; ?>
        </div>

        <!-- infos destination -->
        <div class="col-md-6">

            <!-- ville + continent -->
            <h5 class="mb-2">
                <?= htmlspecialchars((string) ($destination['ville'] ?? '')) ?>
                <?php if (!empty($destination['continent_nom'])): ?>
                    — <?= htmlspecialchars((string) $destination['continent_nom']) ?>
                <?php endif; ?>
            </h5>

            <!-- description -->
            <?php if (!empty($destination['description'])): ?>
                <p><?= nl2br(htmlspecialchars((string) $destination['description'])) ?></p>
            <?php endif; ?>

            <!-- bouton retour -->
            <div class="mt-4">
                <a href="index.php?page=destinations" class="btn btn-outline-secondary px-4">
                    Retour aux destinations
                </a>
            </div>

        </div>

    </div>

    <!-- separation -->
    <hr class="my-5">

    <!-- titre voyages -->
    <h4 class="mb-3">Voyages disponibles</h4>

    <!-- aucun voyage -->
    <?php if (empty($voyages)): ?>
        <div class="alert alert-info">Aucun voyage disponible pour cette destination.</div>
    <?php else: ?>

        <!-- liste voyages -->
        <div class="row g-4">

            <?php foreach ($voyages as $v): ?>
                <div class="col-12 col-md-6 col-lg-4">

                    <!-- carte voyage -->
                    <div class="card h-100 shadow-sm">

                        <!-- image voyage -->
                        <?php if (!empty($v['image'])): ?>
                            <img
                                src="images/voyages/<?= htmlspecialchars((string) $v['image']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars((string) $v['titre']) ?>"
                                style="height:220px; object-fit:cover;"
                            >
                        <?php endif; ?>

                        <!-- contenu carte -->
                        <div class="card-body">

                            <!-- titre voyage -->
                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars((string) $v['titre']) ?>
                            </h5>

                            <!-- dates voyage -->
                            <div class="small text-muted mb-2">
                                📅 <?= htmlspecialchars((string) ($v['date_depart'] ?? '')) ?>
                                → <?= htmlspecialchars((string) ($v['date_retour'] ?? '')) ?>
                            </div>

                            <!-- prix voyage -->
                            <ul class="list-unstyled small mb-0">
                                <li>👤 Adulte : <strong><?= number_format((float) ($v['prix_adulte'] ?? 0), 2, ',', ' ') ?> €</strong></li>
                                <li>🧒 Enfant : <strong><?= number_format((float) ($v['prix_enfant'] ?? 0), 2, ',', ' ') ?> €</strong></li>
                                <li>👶 Bébé : <strong><?= number_format((float) ($v['prix_bebe'] ?? 0), 2, ',', ' ') ?> €</strong></li>
                            </ul>

                        </div>

                        <!-- actions carte -->
                        <div class="card-footer bg-white border-0">
                            <a
                                href="index.php?page=voyage_detail&id=<?= (int) ($v['id_voyage'] ?? 0) ?>"
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
