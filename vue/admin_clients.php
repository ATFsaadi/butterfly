<div class="container mt-5">
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h2 class="mb-0">Liste des clients</h2>

            <form method="get" action="index.php" class="d-flex gap-2">
                <input type="hidden" name="page" value="admin_clients">

                <input
                    type="text"
                    name="filtre"
                    class="form-control"
                    placeholder="Rechercher un client..."
                    value="<?= htmlspecialchars((string)($_GET["filtre"] ?? "")) ?>"
                >

                <button type="submit" class="btn btn-dark">
                    Rechercher
                </button>

                <a href="index.php?page=admin_clients" class="btn btn-outline-secondary">
                    Réinitialiser
                </a>
            </form>
        </div>

        <?php if (!empty($clients)) : ?>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Ville</th>
                            <th>Pays</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php foreach ($clients as $client) : ?>
        <tr class="<?= (int)$client["actif"] === 1 ? "table-success" : "table-secondary" ?>">
            <td><?= htmlspecialchars($client["nom"]) ?></td>
            <td><?= htmlspecialchars($client["prenom"]) ?></td>
            <td><?= htmlspecialchars($client["email"]) ?></td>
            <td><?= htmlspecialchars($client["telephone"] ?? "") ?></td>
            <td><?= htmlspecialchars($client["ville"] ?? "") ?></td>
            <td><?= htmlspecialchars($client["pays"] ?? "") ?></td>

            <td>
                <?php if ((int)$client["actif"] === 1) : ?>
                    <span class="badge bg-success">Actif</span>
                <?php else : ?>
                    <span class="badge bg-secondary">Désactivé</span>
                <?php endif; ?>
            </td>

            <td>
                <div class="d-flex gap-2">
                    <a href="index.php?page=admin_client_detail&id_utilisateur=<?= (int)$client["id_utilisateur"] ?>" class="btn btn-sm btn-primary">
                        Détail
                    </a>

                    <form method="post" action="index.php?page=admin_clients">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars((string)$_SESSION["csrf_token"]) ?>">
                        <input type="hidden" name="id_utilisateur" value="<?= (int)$client["id_utilisateur"] ?>">

                        <?php if ((int)$client["actif"] === 1) : ?>
                            <input type="hidden" name="actif" value="0">
                            <button type="submit" name="changer_statut_client" class="btn btn-sm btn-warning">
                                Désactiver
                            </button>
                        <?php else : ?>
                            <input type="hidden" name="actif" value="1">
                            <button type="submit" name="changer_statut_client" class="btn btn-sm btn-success">
                                Activer
                            </button>
                        <?php endif; ?>
                    </form>
                </div>
            </td>
        </tr>
    <?php endforeach; ?>
</tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-info mb-0">
                Aucun client trouvé.
            </div>
        <?php endif; ?>
    </div>
</div>