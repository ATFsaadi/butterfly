<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$voyage = $voyage ?? null;

if (!$voyage): ?>
    <div class="container py-5">
        <div class="alert alert-danger">Voyage introuvable.</div>
    </div>
<?php return; endif; ?>

<?php
$connected = !empty($_SESSION['user']) && !empty($_SESSION['user']['idutil']);
?>

<div class="container py-5">

    <h2 class="section-title text-center mb-4">
        <?= htmlspecialchars((string)$voyage['titre']) ?>
    </h2>

    <div class="row align-items-center g-4">

        <div class="col-md-6">
            <?php if (!empty($voyage['image'])): ?>
                <img src="images/voyages/<?= htmlspecialchars(basename((string)$voyage['image'])) ?>"
                     class="img-fluid rounded shadow-sm"
                     alt="<?= htmlspecialchars((string)$voyage['titre']) ?>">
            <?php endif; ?>
        </div>

        <div class="col-md-6">
            <h5 class="mb-2"><?= htmlspecialchars((string)($voyage['destination_nom'] ?? '')) ?></h5>

            <p><?= nl2br(htmlspecialchars((string)($voyage['description'] ?? ''))) ?></p>

            <ul class="list-unstyled mt-3">
                <li>👤 Adulte : <strong><?= number_format((float)$voyage['prix_adulte'], 2, ',', ' ') ?> €</strong></li>
                <li>🧒 Enfant : <strong><?= number_format((float)$voyage['prix_enfant'], 2, ',', ' ') ?> €</strong></li>
                <li>👶 Bébé : <strong><?= number_format((float)$voyage['prix_bebe'], 2, ',', ' ') ?> €</strong></li>
                <li class="mt-2">
                    📅 <?= htmlspecialchars((string)($voyage['date_depart'] ?? '')) ?>
                    → <?= htmlspecialchars((string)($voyage['date_retour'] ?? '')) ?>
                </li>
            </ul>

            <div class="mt-4 d-grid gap-2">
                <?php if ($connected): ?>
                    <a href="index.php?page=reservation&id=<?= (int)$voyage['id_voyage'] ?>"
                       class="btn btn-primary btn-lg">
                        Réserver ce voyage
                    </a>
                <?php else: ?>
                    <a href="index.php?page=home"
                       class="btn btn-primary btn-lg">
                        Se connecter pour réserver
                    </a>
                <?php endif; ?>

                <a href="index.php?page=voyages" class="btn btn-outline-secondary">
                    ← Retour aux voyages
                </a>
            </div>

        </div>

    </div>
</div>
