<?php
$errors = $errors ?? [];
$reservation = $reservation ?? null;
$voyage = $voyage ?? null;
?>

<div class="container py-5">
  <h2 class="section-title text-center mb-4">Récapitulatif de réservation</h2>

  <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
      <?php foreach ($errors as $e): ?>
        <div><?= htmlspecialchars($e) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

  <?php if ($reservation): ?>
    <div class="card shadow-sm">
      <div class="card-body">
        <h4 class="mb-3">✅ Réservation #<?= (int)($reservation['id_reservation'] ?? $reservation['idreservation'] ?? $reservation['id']) ?></h4>

        <?php if ($voyage): ?>
          <div class="mb-2"><strong>Voyage :</strong> <?= htmlspecialchars((string)$voyage['titre']) ?></div>
        <?php endif; ?>

        <div class="mb-2"><strong>Dates :</strong>
          <?= htmlspecialchars((string)($reservation['date_depart'] ?? '')) ?>
          → <?= htmlspecialchars((string)($reservation['date_retour'] ?? '')) ?>
        </div>

        <div class="mb-2"><strong>Voyageurs :</strong>
          Adultes <?= (int)$reservation['nombre_adultes'] ?>,
          Enfants <?= (int)$reservation['nombre_enfants'] ?>,
          Bébés <?= (int)$reservation['nombre_bebes'] ?>
        </div>

        <div class="mb-4"><strong>Total :</strong>
          <span class="fs-4 fw-bold"><?= number_format((float)$reservation['prix_total'], 2, ',', ' ') ?> €</span>
        </div>

        <div class="d-flex gap-2">
          <a class="btn btn-outline-secondary" href="index.php?page=dashboard_client">Mon dashboard</a>
          <a class="btn btn-primary" href="index.php?page=home">Continuer</a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
