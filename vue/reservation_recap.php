<?php

/* valeurs par defaut */
$errors      = $errors ?? [];
$reservation = $reservation ?? null;
$voyage      = $voyage ?? null;

?>

<!-- page recap reservation -->
<div class="container py-5">

    <!-- titre page -->
    <h2 class="section-title text-center mb-4">Récapitulatif de réservation</h2>

    <!-- bloc erreurs -->
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $e): ?>
                <div><?= htmlspecialchars((string) $e) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <!-- recap reservation -->
    <?php if ($reservation): ?>
        <?php
            /* id reservation */
            $idRes = (int) ($reservation['id_reservation'] ?? $reservation['idreservation'] ?? $reservation['id'] ?? 0);
        ?>

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- numero reservation -->
                <h4 class="mb-3">✅ Réservation #<?= $idRes ?></h4>

                <!-- voyage -->
                <?php if ($voyage): ?>
                    <div class="mb-2">
                        <strong>Voyage :</strong> <?= htmlspecialchars((string) ($voyage['titre'] ?? '')) ?>
                    </div>
                <?php endif; ?>

                <!-- dates -->
                <div class="mb-2">
                    <strong>Dates :</strong>
                    <?= htmlspecialchars((string) ($reservation['date_depart'] ?? '')) ?>
                    → <?= htmlspecialchars((string) ($reservation['date_retour'] ?? '')) ?>
                </div>

                <!-- voyageurs -->
                <div class="mb-2">
                    <strong>Voyageurs :</strong>
                    Adultes <?= (int) ($reservation['nombre_adultes'] ?? 0) ?>,
                    Enfants <?= (int) ($reservation['nombre_enfants'] ?? 0) ?>,
                    Bébés <?= (int) ($reservation['nombre_bebes'] ?? 0) ?>
                </div>

                <!-- total -->
                <div class="mb-4">
                    <strong>Total :</strong>
                    <span class="fs-4 fw-bold">
                        <?= number_format((float) ($reservation['prix_total'] ?? 0), 2, ',', ' ') ?> €
                    </span>
                </div>

                <!-- actions -->
                <div class="d-flex gap-2">
                    <a class="btn btn-outline-secondary" href="index.php?page=dashboard_client">Mon dashboard</a>
                    <a class="btn btn-primary" href="index.php?page=home">Continuer</a>
                </div>

            </div>
        </div>
    <?php endif; ?>

</div>
