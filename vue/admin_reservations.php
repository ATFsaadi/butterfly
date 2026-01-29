<?php
$reservations = $reservations ?? [];
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Réservations</h2>
    <a href="index.php?page=dashboard_admin" class="btn btn-outline-secondary">
      ← Retour dashboard
    </a>
  </div>

  <?php if (empty($reservations)): ?>
    <div class="alert alert-info">Aucune réservation pour le moment.</div>
  <?php else: ?>

    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Client</th>
            <th>Voyage</th>
            <th>Dates</th>
            <th>Voyageurs</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Paiement</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($reservations as $r): ?>
            <?php
              $idRes = (int)($r['id_reservation'] ?? $r['idreservation'] ?? 0);
              $statut = $r['statut'] ?? 'en attente';
              $pay = $r['paiement_statut'] ?? 'non payé';
            ?>
            <tr>
              <td><?= $idRes ?></td>

              <td>
                <?= htmlspecialchars(($r['nom'] ?? '') . ' ' . ($r['prenom'] ?? '')) ?>
              </td>

              <td><?= htmlspecialchars((string)($r['titre'] ?? $r['voyage_titre'] ?? '')) ?></td>

              <td>
                <?= htmlspecialchars((string)($r['date_depart'] ?? '')) ?>
                →
                <?= htmlspecialchars((string)($r['date_retour'] ?? '')) ?>
              </td>

              <td class="small">
                👤 <?= (int)($r['nombre_adultes'] ?? 0) ?>
                / 🧒 <?= (int)($r['nombre_enfants'] ?? 0) ?>
                / 👶 <?= (int)($r['nombre_bebes'] ?? 0) ?>
              </td>

              <td>
                <strong><?= number_format((float)($r['prix_total'] ?? 0), 2, ',', ' ') ?> €</strong>
              </td>

              <!-- STATUT -->
              <td>
                <?php if ($statut === 'confirmée'): ?>
                  <span class="badge bg-success">✅ Confirmée</span>
                <?php else: ?>
                  <span class="badge bg-warning text-dark">⏳ En attente</span>
                <?php endif; ?>
              </td>

              <!-- PAIEMENT -->
              <td>
                <?php if ($pay === 'payé'): ?>
                  <span class="badge bg-success">💳 Payé</span>
                <?php else: ?>
                  <span class="badge bg-secondary">💳 Non payé</span>
                <?php endif; ?>
              </td>

              <!-- ACTIONS -->
              <td class="text-end">
                <div class="d-inline-flex gap-2">

                  <?php if ($statut !== 'confirmée'): ?>
                    <a href="index.php?page=admin_reservations&confirm=<?= $idRes ?>"
                       class="btn btn-sm btn-success">
                      Confirmer
                    </a>
                  <?php endif; ?>

                  <?php if ($pay !== 'payé'): ?>
                    <a href="index.php?page=admin_reservations&pay=<?= $idRes ?>"
                       class="btn btn-sm btn-outline-success">
                      Marquer payé
                    </a>
                  <?php endif; ?>

                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </div>

    <div class="text-muted small mt-2">
      Astuce : “Confirmer” valide la réservation. “Marquer payé” met à jour le statut de paiement.
    </div>

  <?php endif; ?>
</div>
