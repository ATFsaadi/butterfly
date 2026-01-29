<?php

/* session */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* valeurs par defaut */
$voyage = $voyage ?? null;

/* verification voyage */
if (!$voyage): ?>
    <div class="container py-5">
        <div class="alert alert-danger text-center">
            Voyage introuvable.
        </div>
    </div>
<?php return; endif; ?>

<?php

/* utilisateur connecte */
$connected = !empty($_SESSION['user']) && !empty($_SESSION['user']['idutil']);

?>

<!-- page voyage detail -->
<div class="container py-5">

    <!-- titre page -->
    <h2 class="section-title text-center mb-4">
        <?= htmlspecialchars((string) ($voyage['titre'] ?? '')) ?>
    </h2>

    <!-- grille contenu -->
    <div class="row g-4 align-items-start">

        <!-- carte image -->
        <div class="col-lg-6">
            <div class="card shadow-sm h-100 voyage-card">

                <!-- image voyage -->
                <?php if (!empty($voyage['image'])): ?>
                    <img
                        src="images/voyages/<?= htmlspecialchars(basename((string) $voyage['image'])) ?>"
                        alt="<?= htmlspecialchars((string) ($voyage['titre'] ?? 'Voyage')) ?>"
                        class="card-img-top"
                        style="height:260px; object-fit:cover;"
                    >
                <?php endif; ?>

                <!-- contenu image -->
                <div class="card-body">

                    <!-- titre voyage -->
                    <h4 class="mb-1">
                        <?= htmlspecialchars((string) ($voyage['titre'] ?? '')) ?>
                    </h4>

                    <!-- destination -->
                    <div class="fw-semibold text-secondary mb-3">
                        <?= htmlspecialchars((string) ($voyage['destination_nom'] ?? '')) ?>
                    </div>

                </div>

            </div>
        </div>

        <!-- carte details + actions -->
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- titre bloc -->
                    <h5 class="mb-3">Détails du voyage</h5>

                    <!-- destination -->
                    <div class="text-muted mb-3">
                        <?= htmlspecialchars((string) ($voyage['destination_nom'] ?? '')) ?>
                    </div>

                    <!-- description -->
                    <?php if (!empty($voyage['description'])): ?>
                        <p class="mb-3">
                            <?= nl2br(htmlspecialchars((string) $voyage['description'])) ?>
                        </p>
                    <?php endif; ?>

                    <!-- dates -->
                    <div class="d-flex justify-content-between align-items-center border rounded px-3 py-2 small gap-3">

                        <!-- date depart -->
                        <div class="text-nowrap">
                            <i class="bi bi-calendar-event me-1"></i>
                            Départ : <strong><?= htmlspecialchars((string) ($voyage['date_depart'] ?? '')) ?></strong>
                        </div>

                        <!-- separateur -->
                        <div class="d-flex align-items-center text-muted flex-grow-1">
                            <span class="flex-grow-1 border-top"></span>
                            <span class="mx-2 fs-5"><i class="bi bi-airplane"></i></span>
                            <span class="flex-grow-1 border-top"></span>
                        </div>

                        <!-- date retour -->
                        <div class="text-nowrap">
                            <i class="bi bi-calendar-check me-1"></i>
                            Retour : <strong><?= htmlspecialchars((string) ($voyage['date_retour'] ?? '')) ?></strong>
                        </div>

                    </div>

                    <!-- separation -->
                    <hr class="my-4">

                    <!-- prix -->
                    <div class="small mb-3">
                        <div>👤 Adulte : <strong><?= number_format((float) ($voyage['prix_adulte'] ?? 0), 2, ',', ' ') ?> €</strong></div>
                        <div>🧒 Enfant : <strong><?= number_format((float) ($voyage['prix_enfant'] ?? 0), 2, ',', ' ') ?> €</strong></div>
                        <div>👶 Bébé : <strong><?= number_format((float) ($voyage['prix_bebe'] ?? 0), 2, ',', ' ') ?> €</strong></div>
                    </div>

                    <!-- separation -->
                    <hr class="my-4">

                    <!-- bouton reservation -->
                    <?php if ($connected): ?>

                        <!-- form reserver -->
                        <form action="index.php" method="GET" class="m-0">
                            <input type="hidden" name="page" value="reservation">
                            <input type="hidden" name="id" value="<?= (int) ($voyage['id_voyage'] ?? 0) ?>">

                            <button type="submit" class="btn btn-primary w-100 mt-2 py-3">
                                Réserver ce voyage
                            </button>
                        </form>

                    <?php else: ?>

                        <!-- bouton login -->
                        <button type="button"
                                class="btn btn-primary w-100 mt-2 py-3"
                                data-bs-toggle="modal"
                                data-bs-target="#loginModal">
                            Se connecter pour réserver
                        </button>

                    <?php endif; ?>

                    <!-- retour -->
                    <a href="index.php?page=voyages" class="btn btn-outline-secondary w-100 mt-2">
                        ← Retour aux voyages
                    </a>

                </div>
            </div>
        </div>

    </div>

</div>
