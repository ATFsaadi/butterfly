<?php

// Tableau admin destinations : filtre, tri et actions.

// sécurité des données

$lesDestinations = $lesDestinations ?? ($destinations ?? []);
$filtreActuel = (string) ($_GET["filtre"] ?? ($_POST["filtre"] ?? ""));
$triActuel = (string) ($_GET["tri"] ?? "pays");
$ordreActuel = (string) ($_GET["ordre"] ?? "asc");

// lien tri

function lienTriDestination(string $colonne, string $label, string $filtreActuel, string $triActuel, string $ordreActuel): string
{
    $ordre = ($triActuel === $colonne && $ordreActuel === "asc") ? "desc" : "asc";
    $icone = $triActuel === $colonne ? ($ordreActuel === "asc" ? " ^" : " v") : "";

    $url = "index.php?" . http_build_query([
        "page" => "admin_destinations",
        "filtre" => $filtreActuel,
        "tri" => $colonne,
        "ordre" => $ordre,
    ]);

    return '<a class="admin-sort-link" href="' . htmlspecialchars($url) . '">'
        . htmlspecialchars($label . $icone)
        . '</a>';
}

?>

<!-- liste destinations -->

<h3 class="section-title text-center mt-5">liste des destinations</h3>

<!-- filtre destinations -->

<form method="get" action="index.php" class="mb-4 admin-filter">
    <input type="hidden" name="page" value="admin_destinations">
    <input type="hidden" name="tri" value="<?= htmlspecialchars($triActuel) ?>">
    <input type="hidden" name="ordre" value="<?= htmlspecialchars($ordreActuel) ?>">

    <input
        type="text"
        name="filtre"
        placeholder="filtrer (pays / ville / continent)"
        class="form-control mb-2"
        value="<?= htmlspecialchars($filtreActuel) ?>"
    >

    <div class="d-flex justify-content-center gap-2 flex-wrap">
        <button type="submit" class="btn admin-btn admin-btn-primary">
            filtrer
        </button>

        <a href="index.php?page=admin_destinations" class="btn admin-btn admin-btn-outline">
            reinitialiser
        </a>
    </div>
</form>

<!-- tableau destinations -->

<div class="container mt-4 table-responsive">
    <table class="table table-bordered admin-table">
        <thead>
            <tr>
                <th>image</th>
                <th><?= lienTriDestination("pays", "pays", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriDestination("ville", "ville", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriDestination("continent", "continent", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriDestination("prix_base", "prix base", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriDestination("actif", "actif", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th>actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($lesDestinations)): ?>
                <?php foreach ($lesDestinations as $destination): ?>
                    <?php
                    $id = (int) ($destination["id_destination"] ?? 0);
                    $pays = (string) ($destination["pays"] ?? "");
                    $ville = (string) ($destination["ville"] ?? "");
                    $continent = (string) ($destination["continent"] ?? "");
                    $prixBase = (float) ($destination["prix_base"] ?? 0);
                    $actif = ((int) ($destination["actif"] ?? 0) === 1);
                    $image = (string) ($destination["image_url"] ?? "");
                    ?>

                    <!-- ligne destination -->

                    <tr>
                        <td>
                            <?php if ($image !== ""): ?>
                                <img
                                    src="<?= htmlspecialchars($image) ?>"
                                    width="100"
                                    alt="destination"
                                >
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($pays) ?></td>
                        <td><?= htmlspecialchars($ville) ?></td>
                        <td><?= htmlspecialchars($continent) ?></td>
                        <td><?= number_format($prixBase, 2, ",", " ") ?> €</td>
                        <td><?= $actif ? "oui" : "non" ?></td>

                        <!-- actions destination -->

                        <td>
                            <a
                                href="index.php?page=admin_destinations&action=edit&id_destination=<?= $id ?>"
                                class="btn btn-sm admin-btn admin-btn-green"
                            >
                                modifier
                            </a>

                            <?php if ($actif): ?>
                                <a
                                    href="index.php?page=admin_destinations&action=sup&id_destination=<?= $id ?>"
                                    onclick="return confirm('desactiver cette destination ?');"
                                    class="btn btn-sm admin-btn admin-btn-red"
                                >
                                    desactiver
                                </a>
                            <?php else: ?>
                                <a
                                    href="index.php?page=admin_destinations&action=reactiver&id_destination=<?= $id ?>"
                                    onclick="return confirm('reactiver cette destination ?');"
                                    class="btn btn-sm admin-btn admin-btn-primary"
                                >
                                    reactiver
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <!-- aucune destination -->

                <tr>
                    <td colspan="7" class="text-center text-muted">
                        aucune destination pour le moment
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
