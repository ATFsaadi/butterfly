<?php

// sécurité des données

$clients = $clients ?? [];
$filtreActuel = (string) ($_GET["filtre"] ?? "");
$triActuel = (string) ($_GET["tri"] ?? "nom");
$ordreActuel = (string) ($_GET["ordre"] ?? "asc");

// lien tri

function lienTriClient(string $colonne, string $label, string $filtreActuel, string $triActuel, string $ordreActuel): string
{
    $ordre = ($triActuel === $colonne && $ordreActuel === "asc") ? "desc" : "asc";
    $icone = "";

    if ($triActuel === $colonne) {
        $icone = $ordreActuel === "asc" ? " ^" : " v";
    }

    $url = "index.php?" . http_build_query([
        "page" => "admin_clients",
        "filtre" => $filtreActuel,
        "tri" => $colonne,
        "ordre" => $ordre,
    ]);

    return '<a class="admin-sort-link" href="' . htmlspecialchars($url) . '">'
        . htmlspecialchars($label . $icone)
        . '</a>';
}

?>

<!-- liste clients -->
<h3 class="section-title text-center mt-5">Gestion des Clients</h3>

<!-- filtre clients -->
<form method="get" action="index.php" class="mb-4 admin-filter">
    <input type="hidden" name="page" value="admin_clients">
    <input type="hidden" name="tri" value="<?= htmlspecialchars($triActuel) ?>">
    <input type="hidden" name="ordre" value="<?= htmlspecialchars($ordreActuel) ?>">

    <input
        type="text"
        name="filtre"
        class="form-control mb-2"
        placeholder="rechercher un client..."
        value="<?= htmlspecialchars($filtreActuel) ?>"
    >

    <div class="d-flex justify-content-center gap-2 flex-wrap">
        <button type="submit" class="btn admin-btn admin-btn-primary">
            rechercher
        </button>

        <a href="index.php?page=admin_clients" class="btn admin-btn admin-btn-outline">
            reinitialiser
        </a>
    </div>
</form>
  
<h5 class="text-center mt-5">liste des clients</h5>
        <!-- tableau clients -->

        <?php if (!empty($clients)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle admin-table">
                    <thead>
                        <tr>
                            <th><?= lienTriClient("nom", "nom", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                            <th><?= lienTriClient("prenom", "prenom", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                            <th><?= lienTriClient("email", "email", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                            <th><?= lienTriClient("telephone", "telephone", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                            <th><?= lienTriClient("ville", "ville", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                            <th><?= lienTriClient("pays", "pays", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                            <th><?= lienTriClient("actif", "statut", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                            <th>action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($clients as $client): ?>
                            <tr class="<?= (int) ($client["actif"] ?? 0) === 1 ? "table-success" : "table-secondary" ?>">
                                <td><?= htmlspecialchars($client["nom"] ?? "") ?></td>
                                <td><?= htmlspecialchars($client["prenom"] ?? "") ?></td>
                                <td><?= htmlspecialchars($client["email"] ?? "") ?></td>
                                <td><?= htmlspecialchars($client["telephone"] ?? "") ?></td>
                                <td><?= htmlspecialchars($client["ville"] ?? "") ?></td>
                                <td><?= htmlspecialchars($client["pays"] ?? "") ?></td>

                                <!-- statut client -->

                                <td>
                                    <?php if ((int) ($client["actif"] ?? 0) === 1): ?>
                                        <span class="badge bg-success">Actif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Désactivé</span>
                                    <?php endif; ?>
                                </td>

                                <!-- actions client -->

                                <td>
                                    <div class="d-flex gap-2">
                                        <a
                                            href="index.php?page=admin_client_detail&id_utilisateur=<?= (int) ($client["id_utilisateur"] ?? 0) ?>"
                                            class="btn btn-sm admin-btn admin-btn-green"
                                        >
                                            Détail
                                        </a>

                                        <form method="post" action="index.php?page=admin_clients">
                                            <input
                                                type="hidden"
                                                name="csrf_token"
                                                value="<?= htmlspecialchars((string) ($_SESSION["csrf_token"] ?? "")) ?>"
                                            >

                                            <input
                                                type="hidden"
                                                name="id_utilisateur"
                                                value="<?= (int) ($client["id_utilisateur"] ?? 0) ?>"
                                            >

                                            <?php if ((int) ($client["actif"] ?? 0) === 1): ?>
                                                <input type="hidden" name="actif" value="0">

                                                <button
                                                    type="submit"
                                                    name="changer_statut_client"
                                                    class="btn btn-sm admin-btn admin-btn-red"
                                                >
                                                    Désactiver
                                                </button>
                                            <?php else: ?>
                                                <input type="hidden" name="actif" value="1">

                                                <button
                                                    type="submit"
                                                    name="changer_statut_client"
                                                    class="btn btn-sm admin-btn admin-btn-green"
                                                >
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
        <?php else: ?>

            <!-- aucun client -->

            <div class="alert alert-info mb-0">
                Aucun client trouvé.
            </div>
        <?php endif; ?>

    </div>
</div>
