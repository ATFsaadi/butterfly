<?php
$lesReservations = $lesReservations ?? [];
?>

<h3 class="section-title text-center mt-5">mes réservations</h3>

<div class="container mt-4">

    <?php if (empty($lesReservations)): ?>
        <div class="alert alert-info text-center">
            aucune réservation pour le moment.
        </div>
    <?php else: ?>

        <table class="table table-bordered mt-4 align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>destination</th>
                    <th>dates</th>
                    <th>voyageurs</th>
                    <th>statut</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($lesReservations as $r): ?>

                    <?php
                    $id = (int) ($r["id_reservation"] ?? 0);
                    $pays = $r["pays"] ?? "";
                    $ville = $r["ville"] ?? "";
                    $destination = trim($ville . " — " . $pays, " —");

                    $dateDepart = $r["date_depart"] ?? "";
                    $dateRetour = $r["date_retour"] ?? "";
                    $nb = (int) ($r["nb_personnes"] ?? 1);

                    $statut = (string) ($r["statut"] ?? "en_attente");
                    ?>

                    <tr>
                        <td><?= $id ?></td>
                        <td><?= htmlspecialchars($destination) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>

                        <td>
                            <?php if ($statut === "confirmee"): ?>
                                <span class="badge bg-success">confirmée</span>
                            <?php elseif ($statut === "annulee"): ?>
                                <span class="badge bg-danger">annulée</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">en attente</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>
