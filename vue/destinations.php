<?php
/* valeurs par defaut */
if (!isset($destinations)) {
    $destinations = [];
}
?>

<!-- page destinations (client) -->
<div class="container py-4">

    <!-- titre page -->
    <h3 class="section-title text-center mt-5">Nos Destinations</h3>

    <!-- aucune destination -->
    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">Aucune destination disponible.</div>
    <?php else: ?>

        <!-- grille destinations -->
        <div class="row g-4">

            <?php foreach ($destinations as $d): ?>
                <?php if ((int)($d['actif'] ?? 0) !== 1) continue; ?>

                <div class="col-12 col-md-6 col-lg-4">

                    <!-- carte destination -->
                    <div class="card h-100 shadow-sm">

                        <!-- image destination -->
                        <?php if (!empty($d['image_url'])): ?>
                            <img
                                src="images/destinations/<?= htmlspecialchars((string) $d['image_url']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars((string) ($d['ville'] ?? 'Destination')) ?>"
                                style="height:220px; object-fit:cover;"
                            >
                        <?php endif; ?>

                        <!-- contenu carte -->
                        <div class="card-body">

                            <!-- titre : ville — pays -->
                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars((string) ($d['ville'] ?? '')) ?>
                                <?php if (!empty($d['pays'])): ?>
                                    — <?= htmlspecialchars((string) $d['pays']) ?>
                                <?php endif; ?>
                            </h5>

                            <!-- continent -->
                            <?php if (!empty($d['continent'])): ?>
                                <div class="text-muted mb-2" style="font-size:0.95rem;">
                                    <?= htmlspecialchars((string) $d['continent']) ?>
                                </div>
                            <?php else: ?>
                                <div class="text-muted mb-2" style="font-size:0.95rem;">
                                    &nbsp;
                                </div>
                            <?php endif; ?>

                            <!-- description -->
                            <?php if (!empty($d['description'])): ?>
                                <p class="card-text">
                                    <?= nl2br(htmlspecialchars((string) $d['description'])) ?>
                                </p>
                            <?php else: ?>
                                <p class="card-text text-muted">
                                    Description non disponible.
                                </p>
                            <?php endif; ?>

                            <!-- prix -->
                            <div class="fw-semibold mt-2">
                                À partir de : <?= htmlspecialchars((string) ($d['prix_base'] ?? '0')) ?> €
                            </div>

                        </div>

                        <!-- actions carte -->
                        <div class="card-footer bg-white border-0">
                            <a
                                href="index.php?page=destination_detail&id=<?= (int)$d['id_destination'] ?>"
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
