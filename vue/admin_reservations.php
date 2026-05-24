<?php

// sécurité des données

$lesReservations = $lesReservations ?? [];
$triActuel = (string) ($_GET["tri"] ?? "date");
$ordreActuel = (string) ($_GET["ordre"] ?? "desc");

// lien tri

function lienTriReservation(string $colonne, string $label, string $triActuel, string $ordreActuel): string
{
    $ordre = ($triActuel === $colonne && $ordreActuel === "asc") ? "desc" : "asc";
    $icone = $triActuel === $colonne ? ($ordreActuel === "asc" ? " ^" : " v") : "";

    $url = "index.php?" . http_build_query([
        "page" => "admin_reservations",
        "tri" => $colonne,
        "ordre" => $ordre,
    ]);

    return '<a class="admin-sort-link" href="' . htmlspecialchars($url) . '">'
        . htmlspecialchars($label . $icone)
        . '</a>';
}

$resaDest = array_values(array_filter($lesReservations, function ($reservation) {
    return ($reservation["type_reservation"] ?? "") === "destination";
}));

$resaVoy = array_values(array_filter($lesReservations, function ($reservation) {
    return ($reservation["type_reservation"] ?? "") === "voyage";
}));

?>

<!-- gestion réservations -->

<h3 class="section-title text-center mt-5">Gestion des Réservations</h3>

<?php if (empty($resaDest) && empty($resaVoy)): ?>

    <!-- aucune réservation -->

    <div class="alert alert-info text-center mt-4">
        aucune réservation pour le moment.
    </div>

<?php else: ?>

    <!-- réservations destinations -->

    <h5 class="text-center mt-5">réservations destinations</h5>

    <?php if (empty($resaDest)): ?>
        <div class="alert alert-secondary mt-3">
            aucune réservation destination.
        </div>
    <?php else: ?>
        <table class="table table-bordered mt-3 align-middle admin-table">
            <thead>
                <tr>
                    <th><?= lienTriReservation("id", "#", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("client", "client", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("destination", "destination", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("date", "dates", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("voyageurs", "voyageurs", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("total", "total", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("statut", "statut", $triActuel, $ordreActuel) ?></th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($resaDest as $reservation): ?>
                    <?php
                    $idResa = (int) ($reservation["id_reservation"] ?? 0);
                    $clientNom = trim((string) ($reservation["prenom"] ?? "") . " " . (string) ($reservation["nom"] ?? ""));

                    $ville = (string) ($reservation["ville"] ?? "");
                    $pays = (string) ($reservation["pays"] ?? "");
                    $destinationLabel = trim($ville . " — " . $pays, " —");

                    $dateDepart = (string) ($reservation["date_depart"] ?? "");
                    $dateRetour = (string) ($reservation["date_retour"] ?? "");
                    $nb = (int) ($reservation["nb_personnes"] ?? 0);
                    $total = (float) ($reservation["prix_total"] ?? 0);
                    $statut = (string) ($reservation["statut"] ?? "");

                    $labelStatut = "en attente";
                    $classStatut = "bg-warning text-dark";

                    if ($statut === "confirmee") {
                        $labelStatut = "confirmée";
                        $classStatut = "bg-success";
                    } elseif ($statut === "annulee") {
                        $labelStatut = "annulée";
                        $classStatut = "bg-danger";
                    }
                    ?>

                    <tr>
                        <td><?= $idResa ?></td>
                        <td><?= htmlspecialchars($clientNom) ?></td>
                        <td><?= htmlspecialchars($destinationLabel) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><strong><?= number_format($total, 2, ",", " ") ?> €</strong></td>

                        <!-- statut réservation -->

                        <td class="text-center">
                            <span
                                class="badge <?= htmlspecialchars($classStatut) ?> d-inline-block text-center"
                                style="min-width:110px;"
                            >
                                <?= htmlspecialchars($labelStatut) ?>
                            </span>
                        </td>

                        <!-- actions réservation -->

                        <td>
                            <?php if ($statut === "en_attente"): ?>
                                <div class="d-flex gap-2">
                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= htmlspecialchars((string) ($_SESSION["csrf_token"] ?? "")) ?>"
                                        >
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="confirmer">
                                        <input type="hidden" name="type" value="destination">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">

                                        <button class="btn btn-sm admin-btn admin-btn-green" type="submit">
                                            confirmer
                                        </button>
                                    </form>

                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= htmlspecialchars((string) ($_SESSION["csrf_token"] ?? "")) ?>"
                                        >
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="annuler">
                                        <input type="hidden" name="type" value="destination">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">

                                        <button class="btn btn-sm admin-btn admin-btn-red" type="submit">
                                            annuler
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- réservations voyages -->

    <h5 class="text-center mt-5">réservations voyages</h5>

    <?php if (empty($resaVoy)): ?>
        <div class="alert alert-secondary mt-3">
            aucune réservation voyage.
        </div>
    <?php else: ?>
        <table class="table table-bordered mt-3 align-middle admin-table">
            <thead>
                <tr>
                    <th><?= lienTriReservation("id", "#", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("client", "client", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("destination", "destination", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("voyage", "voyage", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("date", "dates", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("voyageurs", "voyageurs", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("total", "total", $triActuel, $ordreActuel) ?></th>
                    <th><?= lienTriReservation("statut", "statut", $triActuel, $ordreActuel) ?></th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($resaVoy as $reservation): ?>
                    <?php
                    $idResa = (int) ($reservation["id_reservation"] ?? 0);
                    $clientNom = trim((string) ($reservation["prenom"] ?? "") . " " . (string) ($reservation["nom"] ?? ""));

                    $ville = (string) ($reservation["ville"] ?? "");
                    $pays = (string) ($reservation["pays"] ?? "");
                    $destinationLabel = trim($ville . " — " . $pays, " —");

                    $voyageTitre = (string) ($reservation["voyage_titre"] ?? "");
                    $dateDepart = (string) ($reservation["date_depart"] ?? "");
                    $dateRetour = (string) ($reservation["date_retour"] ?? "");
                    $nb = (int) ($reservation["nb_personnes"] ?? 0);
                    $total = (float) ($reservation["prix_total"] ?? 0);
                    $statut = (string) ($reservation["statut"] ?? "");

                    $labelStatut = "en attente";
                    $classStatut = "bg-warning text-dark";

                    if ($statut === "confirmee") {
                        $labelStatut = "confirmée";
                        $classStatut = "bg-success";
                    } elseif ($statut === "annulee") {
                        $labelStatut = "annulée";
                        $classStatut = "bg-danger";
                    }
                    ?>

                    <tr>
                        <td><?= $idResa ?></td>
                        <td><?= htmlspecialchars($clientNom) ?></td>
                        <td><?= htmlspecialchars($destinationLabel) ?></td>
                        <td><?= htmlspecialchars($voyageTitre) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><strong><?= number_format($total, 2, ",", " ") ?> €</strong></td>

                        <!-- statut réservation -->

                        <td class="text-center">
                            <span
                                class="badge <?= htmlspecialchars($classStatut) ?> d-inline-block text-center"
                                style="min-width:110px;"
                            >
                                <?= htmlspecialchars($labelStatut) ?>
                            </span>
                        </td>

                        <!-- actions réservation -->

                        <td>
                            <?php if ($statut === "en_attente"): ?>
                                <div class="d-flex gap-2">
                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= htmlspecialchars((string) ($_SESSION["csrf_token"] ?? "")) ?>"
                                        >
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="confirmer">
                                        <input type="hidden" name="type" value="voyage">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">

                                        <button class="btn btn-sm admin-btn admin-btn-green" type="submit">
                                            confirmer
                                        </button>
                                    </form>

                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input
                                            type="hidden"
                                            name="csrf_token"
                                            value="<?= htmlspecialchars((string) ($_SESSION["csrf_token"] ?? "")) ?>"
                                        >
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="annuler">
                                        <input type="hidden" name="type" value="voyage">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">

                                        <button class="btn btn-sm admin-btn admin-btn-red" type="submit">
                                            annuler
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

<?php endif; ?>
