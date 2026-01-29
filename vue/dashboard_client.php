<!-- titre page -->
<h3 class="section-title text-center mt-5">Mes réservations</h3>

<!-- aucune reservation -->
<?php if (empty($reservations)): ?>
    <div class="alert alert-info text-center mt-4">
        Aucune réservation pour le moment.
    </div>
<?php else: ?>

    <!-- tableau reservations client -->
    <table class="table table-bordered mt-4">

        <!-- entete tableau -->
        <thead>
            <tr>
                <th>Voyage</th>
                <th>Dates</th>
                <th>Prix</th>
                <th>Statut</th>
                <th>Paiement</th>
            </tr>
        </thead>

        <!-- corps tableau -->
        <tbody>

            <?php foreach ($reservations as $r): ?>
                <tr>

                    <!-- colonne voyage -->
                    <td><?= htmlspecialchars((string) ($r['voyage_titre'] ?? '')) ?></td>

                    <!-- colonne dates -->
                    <td>
                        <?= htmlspecialchars((string) ($r['date_depart'] ?? '')) ?>
                        →
                        <?= htmlspecialchars((string) ($r['date_retour'] ?? '')) ?>
                    </td>

                    <!-- colonne prix -->
                    <td>
                        <?= number_format((float) ($r['prix_total'] ?? 0), 2, ',', ' ') ?> €
                    </td>

                    <!-- colonne statut -->
                    <td>
                        <?php if (($r['statut'] ?? 'en attente') === 'confirmée'): ?>
                            <span class="badge bg-success">Confirmée</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">En attente</span>
                        <?php endif; ?>
                    </td>

                    <!-- colonne paiement -->
                    <td>
                        <?php if (($r['paiement_statut'] ?? 'non payé') === 'payé'): ?>
                            <span class="badge bg-success">Payé</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Non payé</span>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>

        </tbody>
    </table>

<?php endif; ?>
