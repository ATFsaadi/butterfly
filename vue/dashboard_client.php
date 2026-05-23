<?php

// sécurité des données

$lesReservationsDestinations = $lesReservationsDestinations ?? [];
$lesReservationsVoyages = $lesReservationsVoyages ?? [];

?>

<!-- mes réservations -->

<h3 class="section-title text-center mt-5">mes réservations</h3>

<div class="container mt-4">

    <!-- aucune réservation -->

    <?php if (empty($lesReservationsDestinations) && empty($lesReservationsVoyages)): ?>
        <div class="alert alert-info text-center">
            aucune réservation pour le moment.
        </div>
    <?php endif; ?>

    <!-- réservations destinations -->

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
                <?php foreach ($lesReservationsDestinations as $reservation): ?>
                    <?php
                    $id = (int) ($reservation["id_reservation_destination"] ?? 0);

                    $pays = (string) ($reservation["pays"] ?? "");
                    $ville = (string) ($reservation["ville"] ?? "");
                    $destination = trim($ville . " — " . $pays, " —");

                    $dateDepart = (string) ($reservation["date_depart"] ?? "");
                    $dateRetour = (string) ($reservation["date_retour"] ?? "");

                    $nb = (int) ($reservation["nb_personnes"] ?? 1);
                    $prix = (float) ($reservation["prix_total"] ?? 0);

                    $statut = (string) ($reservation["statut"] ?? "en_attente");

                    $labelStatut = "en attente";
                    $classStatut = "bg-warning text-dark";
                    $largeurStatut = "110px";

                    if ($statut === "confirmee") {
                        $labelStatut = "confirmée";
                        $classStatut = "bg-success";
                    } elseif ($statut === "annulee") {
                        $labelStatut = "annulée";
                        $classStatut = "bg-danger";
                    }
                    ?>

                    <tr>
                        <td><?= $id ?></td>
                        <td><?= htmlspecialchars($destination) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><?= number_format($prix, 2, ",", " ") ?> €</td>

                        <!-- statut réservation -->

                        <td class="text-center">
                            <span
                                class="badge <?= htmlspecialchars($classStatut) ?> d-inline-block text-center"
                                style="min-width:<?= htmlspecialchars($largeurStatut) ?>;"
                            >
                                <?= htmlspecialchars($labelStatut) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- réservations voyages -->

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
                <?php foreach ($lesReservationsVoyages as $reservation): ?>
                    <?php
                    $id = (int) ($reservation["id_reservation_voyage"] ?? 0);

                    $voyageTitre = (string) ($reservation["voyage_titre"] ?? "");

                    $pays = (string) ($reservation["pays"] ?? "");
                    $ville = (string) ($reservation["ville"] ?? "");
                    $destination = trim($ville . " — " . $pays, " —");

                    $dateDepart = (string) ($reservation["voyage_date_depart"] ?? "");
                    $dateRetour = (string) ($reservation["voyage_date_retour"] ?? "");

                    $nb = (int) ($reservation["nb_personnes"] ?? 1);
                    $prix = (float) ($reservation["prix_total"] ?? 0);

                    $statut = (string) ($reservation["statut"] ?? "en_attente");

                    $labelStatut = "en attente";
                    $classStatut = "bg-warning text-dark";
                    $largeurStatut = "120px";

                    if ($statut === "confirmee") {
                        $labelStatut = "confirmée";
                        $classStatut = "bg-success";
                    } elseif ($statut === "annulee") {
                        $labelStatut = "annulée";
                        $classStatut = "bg-danger";
                    }
                    ?>

                    <tr>
                        <td><?= $id ?></td>
                        <td><?= htmlspecialchars($voyageTitre) ?></td>
                        <td><?= htmlspecialchars($destination) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><?= number_format($prix, 2, ",", " ") ?> €</td>

                        <!-- statut réservation -->

                        <td class="text-center">
                            <span
                                class="badge <?= htmlspecialchars($classStatut) ?> d-inline-block text-center"
                                style="min-width:<?= htmlspecialchars($largeurStatut) ?>;"
                            >
                                <?= htmlspecialchars($labelStatut) ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>