<?php

// sécurité des données

$lesVoyages = $lesVoyages ?? ($voyages ?? []);
$filtreActuel = (string) ($_GET["filtre"] ?? ($_POST["filtre"] ?? ""));
$triActuel = (string) ($_GET["tri"] ?? "titre");
$ordreActuel = (string) ($_GET["ordre"] ?? "asc");

// lien tri

function lienTriVoyage(string $colonne, string $label, string $filtreActuel, string $triActuel, string $ordreActuel): string
{
    $ordre = ($triActuel === $colonne && $ordreActuel === "asc") ? "desc" : "asc";
    $icone = $triActuel === $colonne ? ($ordreActuel === "asc" ? " ^" : " v") : "";

    $url = "index.php?" . http_build_query([
        "page" => "admin_voyages",
        "filtre" => $filtreActuel,
        "tri" => $colonne,
        "ordre" => $ordre,
    ]);

    return '<a class="admin-sort-link" href="' . htmlspecialchars($url) . '">'
        . htmlspecialchars($label . $icone)
        . '</a>';
}

?>

<!-- liste voyages -->

<h3 class="section-title text-center mt-5">liste des voyages</h3>

<!-- filtre voyages -->

<form method="get" action="index.php" class="mb-4 admin-filter">
    <input type="hidden" name="page" value="admin_voyages">
    <input type="hidden" name="tri" value="<?= htmlspecialchars($triActuel) ?>">
    <input type="hidden" name="ordre" value="<?= htmlspecialchars($ordreActuel) ?>">

    <input
        type="text"
        name="filtre"
        placeholder="filtrer (titre / pays / ville / statut)"
        class="form-control mb-2"
        value="<?= htmlspecialchars($filtreActuel) ?>"
    >

    <div class="d-flex justify-content-center gap-2 flex-wrap">
        <button type="submit" class="btn admin-btn admin-btn-primary">
            filtrer
        </button>

        <a href="index.php?page=admin_voyages" class="btn admin-btn admin-btn-outline">
            reinitialiser
        </a>
    </div>
</form>

<!-- tableau voyages -->

<div class="container mt-4 table-responsive">
    <table class="table table-bordered align-middle admin-table">
        <thead>
            <tr>
                <th>aperçu</th>
                <th><?= lienTriVoyage("titre", "titre", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriVoyage("destination", "destination", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriVoyage("dates", "dates", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriVoyage("prix", "prix", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriVoyage("places", "places", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriVoyage("statut", "statut", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th style="width:200px;">actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($lesVoyages)): ?>
                <?php foreach ($lesVoyages as $voyage): ?>
                    <?php
                    $id = (int) ($voyage["id_voyage"] ?? 0);
                    $titre = (string) ($voyage["titre"] ?? "");

                    $pays = (string) ($voyage["pays"] ?? "");
                    $ville = (string) ($voyage["ville"] ?? "");
                    $continent = (string) ($voyage["continent"] ?? "");

                    $dateDepart = (string) ($voyage["date_depart"] ?? "");
                    $dateRetour = (string) ($voyage["date_retour"] ?? "");

                    $prix = (float) ($voyage["prix"] ?? 0);
                    $nbPlaces = (int) ($voyage["nb_places"] ?? 0);
                    $nbRestantes = (int) ($voyage["nb_places_restantes"] ?? 0);

                    $statut = (string) ($voyage["statut"] ?? "");
                    $image = (string) ($voyage["image_url"] ?? "");

                    $destinationLabel = trim($pays . " - " . $ville, " -");

                    if ($continent !== "") {
                        $destinationLabel .= " (" . $continent . ")";
                    }
                    ?>

                    <!-- ligne voyage -->

                    <tr>
                        <td style="width:140px;">
                            <?php if ($image !== ""): ?>
                                <img
                                    src="<?= htmlspecialchars($image) ?>"
                                    style="width:120px; height:70px; object-fit:cover; border-radius:10px;"
                                    alt="voyage"
                                >
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($titre) ?></td>
                        <td><?= htmlspecialchars($destinationLabel) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= number_format($prix, 2, ",", " ") ?> €</td>
                        <td><?= $nbRestantes ?> / <?= $nbPlaces ?></td>
                        <td>
                            <span class="admin-status <?= $statut === "actif" ? "is-active" : "is-muted" ?>">
                                <?= htmlspecialchars($statut) ?>
                            </span>
                        </td>

                        <!-- actions voyage -->

                        <td>
                            <a
                                href="index.php?page=admin_voyages&action=edit&id_voyage=<?= $id ?>"
                                class="btn btn-sm admin-btn admin-btn-green"
                            >
                                modifier
                            </a>

                            <a
                                href="index.php?page=admin_voyages&action=sup&id_voyage=<?= $id ?>"
                                onclick="return confirm('supprimer ce voyage ?');"
                                class="btn btn-sm admin-btn admin-btn-red"
                            >
                                supprimer
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <!-- aucun voyage -->

                <tr>
                    <td colspan="8" class="text-center text-muted">
                        aucun voyage pour le moment
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
