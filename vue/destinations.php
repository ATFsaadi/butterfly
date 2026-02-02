<?php
$destinations = $destinations ?? [];
$q = htmlspecialchars($_GET['q'] ?? '');
?>

<div class="container mt-4">

    <h2 class="mb-3">Nos destinations</h2>

    <!-- Filtre (comme à l'école : simple) -->
    <form method="get" action="index.php" class="mb-4">
        <input type="hidden" name="page" value="destinations">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Rechercher (pays, ville, continent)" value="<?= $q ?>">
            <button class="btn btn-primary" type="submit">Filtrer</button>
            <a class="btn btn-secondary" href="index.php?page=destinations">Reset</a>
        </div>
    </form>

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">Aucune destination trouvée.</div>
    <?php else: ?>

        <div class="row g-3">
            <?php foreach ($destinations as $d): ?>
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100">

                        <?php if (!empty($d['image_url'])): ?>
                            <img src="<?= htmlspecialchars($d['image_url']) ?>"
                                 class="card-img-top"
                                 alt="<?= htmlspecialchars(($d['pays'] ?? '').' '.($d['ville'] ?? '')) ?>"
                                 style="height:180px; object-fit:cover;">
                        <?php endif; ?>

                        <div class="card-body">
                            <h5 class="card-title">
                                <?= htmlspecialchars(($d['pays'] ?? '').' - '.($d['ville'] ?? '')) ?>
                            </h5>

                            <?php if (!empty($d['continent'])): ?>
                                <div class="text-muted small mb-2"><?= htmlspecialchars($d['continent']) ?></div>
                            <?php endif; ?>

                            <?php if (!empty($d['prix_base'])): ?>
                                <div class="mb-2"><strong><?= number_format((float)$d['prix_base'], 2, ',', ' ') ?> €</strong> (prix base)</div>
                            <?php endif; ?>

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
