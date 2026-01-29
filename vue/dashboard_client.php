<h3 class="mb-4">Mes réservations</h3>
<pre><?php var_dump($_SESSION['user'] ?? null, $reservations ?? null); ?></pre>

<?php if (empty($reservations)): ?>
    <div class="alert alert-info">Aucune réservation pour le moment.</div>
<?php else: ?>
    
<table class="table table-striped align-middle">
    <thead>
        <tr>
            <th>Voyage</th>
            <th>Dates</th>
            <th>Prix</th>
            <th>Statut</th>
            <th>Paiement</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reservations as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['voyage_titre']) ?></td>

            <td>
                <?= htmlspecialchars($r['date_depart']) ?> →
                <?= htmlspecialchars($r['date_retour']) ?>
            </td>

            <td><?= number_format($r['prix_total'], 2, ',', ' ') ?> €</td>

            <!-- STATUT RESERVATION -->
            <td>
                <?php if (($r['statut'] ?? 'en attente') === 'confirmée'): ?>
                    <span class="badge bg-success">✅ Confirmée</span>
                <?php else: ?>
                    <span class="badge bg-warning text-dark">⏳ En attente</span>
                <?php endif; ?>
            </td>

            <!-- STATUT PAIEMENT -->
            <td>
                <?php if (($r['paiement_statut'] ?? 'non payé') === 'payé'): ?>
                    <span class="badge bg-success">💳 Payé</span>
                <?php else: ?>
                    <span class="badge bg-secondary">💳 Non payé</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php endif; ?>
