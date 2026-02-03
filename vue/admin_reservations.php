<h3 class="section-title text-center mt-5">gestion des réservations</h3>

<?php if (empty($lesReservations)): ?>
    <div class="alert alert-info text-center mt-4">
        aucune réservation pour le moment.
    </div>
<?php else: ?>

<table class="table table-bordered mt-4 align-middle">
    <thead>
        <tr>
            <th>#</th>
            <th>client</th>
            <th>destination</th>
            <th>dates</th>
            <th>voyageurs</th>
            <th>total</th>
            <th>statut</th>
            <th>action</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($lesReservations as $r): ?>
            <tr>
                <td><?= (int) $r["id_reservation"] ?></td>

                <td>
                    <?= htmlspecialchars(($r["prenom"] ?? "")." ".($r["nom"] ?? "")) ?>
                </td>

                <td>
                    <?= htmlspecialchars(($r["ville"] ?? "")." — ".($r["pays"] ?? "")) ?>
                </td>

                <td>
                    <?= htmlspecialchars($r["date_depart"]) ?>
                    →
                    <?= htmlspecialchars($r["date_retour"]) ?>
                </td>

                <td><?= (int) $r["nb_personnes"] ?></td>

                <td>
                    <strong><?= number_format((float) $r["prix_total"], 2, ",", " ") ?> €</strong>
                </td>

                <td>
                    <?php if ($r["statut"] === "confirmee"): ?>
                        <span class="badge bg-success">confirmée</span>
                    <?php elseif ($r["statut"] === "annulee"): ?>
                        <span class="badge bg-danger">annulée</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">en attente</span>
                    <?php endif; ?>
                </td>

                <td>
                    <?php if ($r["statut"] === "en_attente"): ?>
                        <a class="btn btn-sm btn-success"
                           href="index.php?page=admin_reservations&action=confirmer&id_reservation=<?= (int) $r["id_reservation"] ?>">
                            confirmer
                        </a>

                        <a class="btn btn-sm btn-outline-danger"
                           href="index.php?page=admin_reservations&action=annuler&id_reservation=<?= (int) $r["id_reservation"] ?>">
                            annuler
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>
