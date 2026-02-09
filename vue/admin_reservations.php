<h3 class="section-title text-center mt-5">gestion des réservations</h3>

<?php
$lesReservations = $lesReservations ?? [];
$resaDest = array_values(array_filter($lesReservations, fn($r) => ($r["type_reservation"] ?? "") === "destination"));
$resaVoy  = array_values(array_filter($lesReservations, fn($r) => ($r["type_reservation"] ?? "") === "voyage"));
?>

<?php if (empty($resaDest) && empty($resaVoy)): ?>
    <div class="alert alert-info text-center mt-4">
        aucune réservation pour le moment.
    </div>
<?php else: ?>

    <!-- ===================== DESTINATIONS ===================== -->
    <h5 class="text-center mt-5">réservations destinations</h5>

    <?php if (empty($resaDest)): ?>
        <div class="alert alert-secondary mt-3">aucune réservation destination.</div>
    <?php else: ?>
        <table class="table table-bordered mt-3 align-middle">
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
                <?php foreach ($resaDest as $r): ?>
                    <?php
                    $idResa = (int)($r["id_reservation"] ?? 0);
                    $clientNom = trim((string)($r["prenom"] ?? "") . " " . (string)($r["nom"] ?? ""));
                    $ville = (string)($r["ville"] ?? "");
                    $pays = (string)($r["pays"] ?? "");
                    $destinationLabel = trim($ville . " — " . $pays, " —");

                    $dateDepart = (string)($r["date_depart"] ?? "");
                    $dateRetour = (string)($r["date_retour"] ?? "");
                    $nb = (int)($r["nb_personnes"] ?? 0);
                    $total = (float)($r["prix_total"] ?? 0);
                    $statut = (string)($r["statut"] ?? "");
                    ?>
                    <tr>
                        <td><?= $idResa ?></td>
                        <td><?= htmlspecialchars($clientNom) ?></td>
                        <td><?= htmlspecialchars($destinationLabel) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><strong><?= number_format($total, 2, ",", " ") ?> €</strong></td>
                        <td class="text-center">
    <?php
    $label = "en attente";
    $class = "bg-warning text-dark";

    if ($statut === "confirmee") {
        $label = "confirmée";
        $class = "bg-success";
    } elseif ($statut === "annulee") {
        $label = "annulée";
        $class = "bg-danger";
    }
    ?>
    <span
        class="badge <?= $class ?> d-inline-block text-center"
        style="min-width:110px;"
    >
        <?= $label ?>
    </span>
</td>

                        <td>
                            <?php if ($statut === "en_attente"): ?>
                                <div class="d-flex gap-2">
                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)$_SESSION["csrf_token"]) ?>">
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="confirmer">
                                        <input type="hidden" name="type" value="destination">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">
                                        <button class="btn btn-sm btn-success" type="submit">confirmer</button>
                                    </form>

                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)$_SESSION["csrf_token"]) ?>">
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="annuler">
                                        <input type="hidden" name="type" value="destination">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">annuler</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>


    <!-- ===================== VOYAGES ===================== -->
    <h5 class="text-center mt-5">réservations voyages </h5>

    <?php if (empty($resaVoy)): ?>
        <div class="alert alert-secondary mt-3">aucune réservation voyage.</div>
    <?php else: ?>
        <table class="table table-bordered mt-3 align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>client</th>
                    <th>destination</th>
                    <th>voyage</th>
                    <th>dates</th>
                    <th>voyageurs</th>
                    <th>total</th>
                    <th>statut</th>
                    <th>action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($resaVoy as $r): ?>
                    <?php
                    $idResa = (int)($r["id_reservation"] ?? 0);
                    $clientNom = trim((string)($r["prenom"] ?? "") . " " . (string)($r["nom"] ?? ""));
                    $ville = (string)($r["ville"] ?? "");
                    $pays = (string)($r["pays"] ?? "");
                    $destinationLabel = trim($ville . " — " . $pays, " —");

                    $voyageTitre = (string)($r["voyage_titre"] ?? "");
                    $dateDepart = (string)($r["date_depart"] ?? "");
                    $dateRetour = (string)($r["date_retour"] ?? "");
                    $nb = (int)($r["nb_personnes"] ?? 0);
                    $total = (float)($r["prix_total"] ?? 0);
                    $statut = (string)($r["statut"] ?? "");
                    ?>
                    <tr>
                        <td><?= $idResa ?></td>
                        <td><?= htmlspecialchars($clientNom) ?></td>
                        <td><?= htmlspecialchars($destinationLabel) ?></td>
                        <td><?= htmlspecialchars($voyageTitre) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= $nb ?></td>
                        <td><strong><?= number_format($total, 2, ",", " ") ?> €</strong></td>
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

                        <td>
                            <?php if ($statut === "en_attente"): ?>
                                <div class="d-flex gap-2">
                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)$_SESSION["csrf_token"]) ?>">
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="confirmer">
                                        <input type="hidden" name="type" value="voyage">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">
                                        <button class="btn btn-sm btn-success" type="submit">confirmer</button>
                                    </form>

                                    <form method="post" action="index.php?page=admin_reservations" class="m-0">
                                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)$_SESSION["csrf_token"]) ?>">
                                        <input type="hidden" name="maj_statut" value="1">
                                        <input type="hidden" name="action" value="annuler">
                                        <input type="hidden" name="type" value="voyage">
                                        <input type="hidden" name="id_reservation" value="<?= $idResa ?>">
                                        <button class="btn btn-sm btn-outline-danger" type="submit">annuler</button>
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
