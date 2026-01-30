<?php
$reservations = $reservations ?? [];
?>

<h3 class="section-title text-center mt-5">Gestion des Réservations</h3>

<?php if (empty($reservations)): ?>
    <div class="alert alert-info text-center mt-4">
        Aucune réservation pour le moment.
    </div>
<?php else: ?>

    <table class="table table-bordered mt-4 align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Destination</th>
                <th>Dates</th>
                <th>Voyageurs</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($reservations as $r): ?>
                <?php
                    $idRes = (int) ($r['id_reservation'] ?? 0);
                    $statut = $r['statut'] ?? 'en_attente';

                    $clientNom = trim(($r['nom'] ?? '') . ' ' . ($r['prenom'] ?? ''));
                    $destLabel = trim(($r['ville'] ?? '') . ' — ' . ($r['pays'] ?? ''));
                ?>
                <tr>
                    <td><?= $idRes ?></td>

                    <td><?= htmlspecialchars($clientNom) ?></td>

                    <td><?= htmlspecialchars($destLabel) ?></td>

                    <td>
                        <?= htmlspecialchars((string) ($r['date_depart'] ?? '')) ?>
                        →
                        <?= htmlspecialchars((string) ($r['date_retour'] ?? '')) ?>
                    </td>

                    <td><?= (int) ($r['nb_personnes'] ?? 1) ?></td>

                    <td>
                        <strong><?= number_format((float) ($r['prix_total'] ?? 0), 2, ',', ' ') ?> €</strong>
                    </td>

                    <td>
                        <?php if ($statut === 'confirmee'): ?>
                            <span class="badge bg-success">✅ Confirmée</span>
                        <?php elseif ($statut === 'annulee'): ?>
                            <span class="badge bg-danger">⛔ Annulée</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">⏳ En attente</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php if ($statut !== 'confirmee'): ?>
                            <a href="index.php?page=admin_reservations&confirm=<?= $idRes ?>"
                               class="btn btn-sm btn-success">
                                Confirmer
                            </a>
                        <?php endif; ?>

                        <?php if ($statut !== 'annulee'): ?>
                            <a href="index.php?page=admin_reservations&cancel=<?= $idRes ?>"
                               class="btn btn-sm btn-outline-danger"
                               onclick="return confirm('Annuler cette réservation ?');">
                                Annuler
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>
