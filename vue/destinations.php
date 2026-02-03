<?php
// vue/destinations.php
$destinations = $destinations ?? [];
?>

<div class="container-fluid">

    <!-- 🔍 composant recherche destinations -->
    <?php require_once __DIR__ . "/components/searchDestinations.php"; ?>

</div>

<div class="container mt-4">

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">Aucune destination trouvée.</div>
    <?php else: ?>

        <div class="row g-3">
            <?php foreach ($destinations as $d): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">

                        <?php if (!empty($d['image_url'])): ?>
                            <img src="<?= htmlspecialchars((string)$d['image_url']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars(($d['pays'] ?? '').' '.($d['ville'] ?? '')) ?>"
                                 style="height:180px; object-fit:cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars(($d['pays'] ?? '').' - '.($d['ville'] ?? '')) ?>
                            </h5>

                            <?php if (!empty($d['continent'])): ?>
                                <div class="text-muted small mb-2">
                                    <?= htmlspecialchars((string)$d['continent']) ?>
                                </div>
                            <?php endif; ?>

                            <div class="mb-2">
                                <strong><?= number_format((float)($d['prix_base'] ?? 0), 2, ',', ' ') ?> €</strong>
                                <span class="text-muted">(prix base)</span>
                            </div>

                            <a class="btn btn-outline-primary"
                               href="index.php?page=destination_detail&id_destination=<?= (int)$d['id_destination'] ?>">
                                Voir détail
                            </a>
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>

</div>
