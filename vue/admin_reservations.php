<?php

/* valeurs par defaut */
$reservations = $reservations ?? [];

?>

<!-- titre page -->
<h3 class="section-title text-center mt-5">Gestion des Réservations</h3>

<!-- aucune reservation -->
<?php if (empty($reservations)): ?>
    <div class="alert alert-info text-center mt-4">
        Aucune réservation pour le moment.
    </div>
<?php else: ?>

    <!-- tableau reservations -->
    <table class="table table-bordered mt-4 align-middle">

        <!-- entete tableau -->
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Voyage</th>
                <th>Dates</th>
                <th>Voyageurs</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Paiement</th>
                <th>Action</th>
            </tr>
        </thead>

        <!-- corps tableau -->
        <tbody>

            <?php foreach ($reservations as $r): ?>
                <?php
                    /* variables reservation */
                    $idRes  = (int) ($r['id_reservation'] ?? $r['idreservation'] ?? 0);
                    $statut = $r['statut'] ?? 'en attente';
                    $pay    = $r['paiement_statut'] ?? 'non payé';
                ?>
                <tr>

                    <!-- id -->
                    <td><?= $idRes ?></td>

                    <!-- client -->
                    <td>
                        <?= htmlspecialchars(($r['nom'] ?? '') . ' ' . ($r['prenom'] ?? '')) ?>
                    </td>

                    <!-- voyage -->
                    <td>
                        <?= htmlspecialchars((string) ($r['titre'] ?? $r['voyage_titre'] ?? '')) ?>
                    </td>

                    <!-- dates -->
                    <td>
                        <?= htmlspecialchars((string) ($r['date_depart'] ?? '')) ?>
                        →
                        <?= htmlspecialchars((string) ($r['date_retour'] ?? '')) ?>
                    </td>

                    <!-- voyageurs -->
                    <td>
                        👤 <?= (int) ($r['nombre_adultes'] ?? 0) ?>
                        / 🧒 <?= (int) ($r['nombre_enfants'] ?? 0) ?>
                        / 👶 <?= (int) ($r['nombre_bebes'] ?? 0) ?>
                    </td>

                    <!-- total -->
                    <td>
                        <strong><?= number_format((float) ($r['prix_total'] ?? 0), 2, ',', ' ') ?> €</strong>
                    </td>

                    <!-- statut reservation -->
                    <td>
                        <?php if ($statut === 'confirmée'): ?>
                            <span class="badge bg-success">✅ Confirmée</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">⏳ En attente</span>
                        <?php endif; ?>
                    </td>

                    <!-- statut paiement -->
                    <td>
                        <?php if ($pay === 'payé'): ?>
                            <span class="badge bg-success">💳 Payé</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">💳 Non payé</span>
                        <?php endif; ?>
                    </td>

                    <!-- actions admin -->
                    <td>

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

                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

<?php endif; ?>
