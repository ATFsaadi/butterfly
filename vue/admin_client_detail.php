<?php

// sécurité des données

$client = $client ?? [];
$reservationsDestinations = $reservationsDestinations ?? [];
$reservationsVoyages = $reservationsVoyages ?? [];

?>

<!-- détail client -->

<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-3 p-4">

        <!-- en-tête -->

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Détail du client</h2>

            <a href="index.php?page=admin_clients" class="btn admin-btn admin-btn-outline">
                Retour
            </a>
        </div>

        <!-- informations client -->

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nom</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["nom"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Prénom</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["prenom"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Email</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["email"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Téléphone</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["telephone"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Adresse</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["adresse"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Ville</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["ville"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Pays</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["pays"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Statut</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= (int) ($client["actif"] ?? 0) === 1 ? "Actif" : "Désactivé" ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Créé le</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["user_date_creation"] ?? "") ?>"
                    readonly
                >
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Dernière modification</label>
                <input
                    type="text"
                    class="form-control"
                    value="<?= htmlspecialchars($client["user_date_modification"] ?? "") ?>"
                    readonly
                >
            </div>
        </div>

        <hr class="my-5">

        <!-- réservations destinations -->

        <h3 class="mb-3">Réservations de destinations</h3>

        <?php if (!empty($reservationsDestinations)): ?>
            <div class="table-responsive mb-5">
                <table class="table table-hover align-middle admin-table">
                    <thead>
                        <tr>
                            <th>Destination</th>
                            <th>Départ</th>
                            <th>Retour</th>
                            <th>Personnes</th>
                            <th>Prix total</th>
                            <th>Statut</th>
                            <th>Date réservation</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($reservationsDestinations as $reservation): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars(($reservation["ville"] ?? "") . " (" . ($reservation["pays"] ?? "") . ")") ?>
                                </td>
                                <td><?= htmlspecialchars($reservation["date_depart"] ?? "") ?></td>
                                <td><?= htmlspecialchars($reservation["date_retour"] ?? "") ?></td>
                                <td><?= (int) ($reservation["nb_personnes"] ?? 0) ?></td>
                                <td><?= htmlspecialchars((string) ($reservation["prix_total"] ?? "")) ?> €</td>
                                <td><?= htmlspecialchars($reservation["statut"] ?? "") ?></td>
                                <td><?= htmlspecialchars($reservation["date_reservation"] ?? "") ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-5">
                Aucune réservation de destination.
            </div>
        <?php endif; ?>

        <!-- réservations voyages -->

        <h3 class="mb-3">Réservations de voyages</h3>

        <?php if (!empty($reservationsVoyages)): ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle admin-table">
                    <thead>
                        <tr>
                            <th>Voyage</th>
                            <th>Destination</th>
                            <th>Départ</th>
                            <th>Retour</th>
                            <th>Personnes</th>
                            <th>Prix total</th>
                            <th>Statut</th>
                            <th>Date réservation</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($reservationsVoyages as $reservation): ?>
                            <tr>
                                <td><?= htmlspecialchars($reservation["titre"] ?? "") ?></td>
                                <td>
                                    <?= htmlspecialchars(($reservation["ville"] ?? "") . " (" . ($reservation["pays"] ?? "") . ")") ?>
                                </td>
                                <td><?= htmlspecialchars($reservation["date_depart"] ?? "") ?></td>
                                <td><?= htmlspecialchars($reservation["date_retour"] ?? "") ?></td>
                                <td><?= (int) ($reservation["nb_personnes"] ?? 0) ?></td>
                                <td><?= htmlspecialchars((string) ($reservation["prix_total"] ?? "")) ?> €</td>
                                <td><?= htmlspecialchars($reservation["statut"] ?? "") ?></td>
                                <td><?= htmlspecialchars($reservation["date_reservation"] ?? "") ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info mb-0">
                Aucune réservation de voyage.
            </div>
        <?php endif; ?>

    </div>
</div>
