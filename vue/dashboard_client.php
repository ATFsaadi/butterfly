<?php

$lesReservationsDestinations = $lesReservationsDestinations ?? [];
$lesReservationsVoyages = $lesReservationsVoyages ?? [];

?>

<h3 class="section-title text-center mt-5">mes réservations</h3>

<div class="container mt-4">

    <?php if (empty($lesReservationsDestinations) && empty($lesReservationsVoyages)): ?>
        <div class="alert alert-info text-center">
            aucune réservation pour le moment.
        </div>
    <?php endif; ?>

    <h5 class="text-center mt-5">réservations destination</h5>

    <?php if (empty($lesReservationsDestinations)): ?>
        <div class="alert alert-secondary">
            aucune réservation sur mesure.
        </div>
    <?php else: ?>

        <table class="table table-bordered mt-3 align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>destination</th>
                    <th>dates</th>
                    <th>voyageurs</th>
                    <th>prix</th>
                    <th>statut</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($lesReservationsDestinations as $r): ?>
                    <?php
                    $id = (int)($r["id_reservation_destination"] ?? 0);

                    $pays = (string)($r["pays"] ?? "");
                    $ville = (string)($r["ville"] ?? "");
                    $destination = trim($ville . " — " . $pays, " —");

                    $dateDepart = (string)($r["date_depart"] ?? "");
                    $dateRetour = (string)($r["date_retour"] ?? "");

                    $nb = (int)($r["nb_personnes"] ?? 1);
                    $prix = (float)($r["prix_total"] ?? 0);

                    $statut = (string)($r["statut"] ?? "en_attente");
                    ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= htmlspecialchars($destination) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><?= number_format($prix, 2, ",", " ") ?> €</td>
                        <td class="text-center">
    <?php if ($statut === "confirmee"): ?>
        <span class="badge bg-success d-inline-block text-center" style="min-width:110px;">
            confirmée
        </span>
    <?php elseif ($statut === "annulee"): ?>
        <span class="badge bg-danger d-inline-block text-center" style="min-width:110px;">
            annulée
        </span>
    <?php else: ?>
        <span class="badge bg-warning text-dark d-inline-block text-center" style="min-width:110px;">
            en attente
        </span>
    <?php endif; ?>
</td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

    <h5 class="text-center mt-5">réservations voyages organisés</h5>

    <?php if (empty($lesReservationsVoyages)): ?>
        <div class="alert alert-secondary">
            aucune réservation de voyage organisé.
        </div>
    <?php else: ?>

        <table class="table table-bordered mt-3 align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>voyage</th>
                    <th>destination</th>
                    <th>dates</th>
                    <th>voyageurs</th>
                    <th>prix</th>
                    <th>statut</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($lesReservationsVoyages as $r): ?>
                    <?php
                    $id = (int)($r["id_reservation_voyage"] ?? 0);

                    $voyageTitre = (string)($r["voyage_titre"] ?? "");

                    $pays = (string)($r["pays"] ?? "");
                    $ville = (string)($r["ville"] ?? "");
                    $destination = trim($ville . " — " . $pays, " —");

                    $dateDepart = (string)($r["voyage_date_depart"] ?? "");
                    $dateRetour = (string)($r["voyage_date_retour"] ?? "");

                    $nb = (int)($r["nb_personnes"] ?? 1);
                    $prix = (float)($r["prix_total"] ?? 0);

                    $statut = (string)($r["statut"] ?? "en_attente");
                    ?>
                    <tr>
                        <td><?= $id ?></td>
                        <td><?= htmlspecialchars($voyageTitre) ?></td>
                        <td><?= htmlspecialchars($destination) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><?= number_format($prix, 2, ",", " ") ?> €</td>
                        <td class="text-center">
    <?php if ($statut === "confirmee"): ?>
        <span class="badge bg-success d-inline-block text-center" style="min-width:120px;">
            confirmée
        </span>
    <?php elseif ($statut === "annulee"): ?>
        <span class="badge bg-danger d-inline-block text-center" style="min-width:120px;">
            annulée
        </span>
    <?php else: ?>
        <span class="badge bg-warning text-dark d-inline-block text-center" style="min-width:120px;">
            en attente
        </span>
    <?php endif; ?>
</td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>

</div>
