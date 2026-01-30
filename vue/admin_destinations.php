<?php
if (!isset($destinations)) $destinations = [];
?>

<div class="container py-4">
    <h3 class="section-title text-center mt-5">Nos Destinations</h3>

    <?php if (empty($destinations)): ?>
        <div class="alert alert-info">Aucune destination disponible.</div>
    <?php else: ?>

        <div class="row g-4">
            <?php foreach ($destinations as $d): ?>
                <div class="col-12 col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm">

                        <?php if (!empty($d['image_url'])): ?>
                            <img
                                src="images/destinations/<?= htmlspecialchars((string) $d['image_url']) ?>"
                                class="card-img-top"
                                alt="<?= htmlspecialchars((string) ($d['ville'] ?? 'Destination')) ?>"
                                style="height:220px; object-fit:cover;"
                            >
                        <?php endif; ?>

                        <div class="card-body">

                            <h5 class="card-title mb-1">
                                <?= htmlspecialchars((string) ($d['ville'] ?? '')) ?>
                                <?php if (!empty($d['pays'])): ?>
                                    — <?= htmlspecialchars((string) $d['pays']) ?>
                                <?php endif; ?>
                            </h5>

                            <div class="text-muted mb-2" style="font-size:0.95rem;">
                                <?php if (!empty($d['continent'])): ?>
                                    <?= htmlspecialchars((string) $d['continent']) ?>
                                <?php endif; ?>
                            </div>

                            <p class="card-text">
                                <?= nl2br(htmlspecialchars((string) ($d['description'] ?? ''))) ?>
                            </p>

                            <div class="fw-semibold">
                                À partir de : <?= htmlspecialchars((string) ($d['prix_base'] ?? '0')) ?> €
                            </div>

                        </div>

                        <div class="card-footer bg-white border-0 d-flex gap-2">
                            <a href="index.php?page=admin_destinations&edit=<?= (int)$d['id_destination'] ?>"
                               class="btn btn-outline-secondary w-50">
                                Modifier
                            </a>

                            <a href="index.php?page=admin_destinations&delete=<?= (int)$d['id_destination'] ?>"
                               class="btn btn-outline-danger w-50"
                               onclick="return confirm('Supprimer cette destination ?');">
                                Supprimer
                            </a>
                        </div>

                    </div>

                </div>
            <?php endforeach; ?>
        </div>

    <?php endif; ?>
</div>
