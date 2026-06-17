<?php

// Tableau admin offres : filtre, tri et actions.

// sécurité des données

$lesOffres = $lesOffres ?? ($offres ?? []);
$filtreActuel = (string) ($_GET["filtre"] ?? ($_POST["filtre"] ?? ""));
$triActuel = (string) ($_GET["tri"] ?? "titre");
$ordreActuel = (string) ($_GET["ordre"] ?? "asc");

// lien tri

function lienTriOffre(string $colonne, string $label, string $filtreActuel, string $triActuel, string $ordreActuel): string
{
    $ordre = ($triActuel === $colonne && $ordreActuel === "asc") ? "desc" : "asc";
    $icone = $triActuel === $colonne ? ($ordreActuel === "asc" ? " ^" : " v") : "";

    $url = "index.php?" . http_build_query([
        "page" => "admin_offres",
        "filtre" => $filtreActuel,
        "tri" => $colonne,
        "ordre" => $ordre,
    ]);

    return '<a class="admin-sort-link" href="' . htmlspecialchars($url) . '">'
        . htmlspecialchars($label . $icone)
        . '</a>';
}

?>

<!-- liste offres -->

<h3 class="section-title text-center mt-5">liste des offres</h3>

<!-- filtre offres -->

<form method="get" action="index.php" class="mb-4 admin-filter">
    <input type="hidden" name="page" value="admin_offres">
    <input type="hidden" name="tri" value="<?= htmlspecialchars($triActuel) ?>">
    <input type="hidden" name="ordre" value="<?= htmlspecialchars($ordreActuel) ?>">

    <input
        type="text"
        name="filtre"
        placeholder="filtrer (titre / pays / ville / continent)"
        class="form-control mb-2"
        value="<?= htmlspecialchars($filtreActuel) ?>"
    >

    <div class="d-flex justify-content-center gap-2 flex-wrap">
        <button type="submit" class="btn admin-btn admin-btn-primary">
            filtrer
        </button>

        <a href="index.php?page=admin_offres" class="btn admin-btn admin-btn-outline">
            reinitialiser
        </a>
    </div>
</form>

<!-- tableau offres -->

<div class="container mt-4 table-responsive">
    <table class="table table-bordered align-middle admin-table">
        <thead>
            <tr>
                <th>id</th>
                <th><?= lienTriOffre("titre", "titre", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriOffre("destination", "destination", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriOffre("reduction", "reduction", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriOffre("date_debut", "debut", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriOffre("date_fin", "fin", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th><?= lienTriOffre("actif", "actif", $filtreActuel, $triActuel, $ordreActuel) ?></th>
                <th>actions</th>
            </tr>
        </thead>

        <tbody>
            <?php if (!empty($lesOffres)): ?>
                <?php foreach ($lesOffres as $offre): ?>
                    <?php
                    $idOffre = (int) ($offre["id_offre"] ?? 0);
                    $titre = (string) ($offre["titre"] ?? "");

                    $pays = (string) ($offre["pays"] ?? "");
                    $ville = (string) ($offre["ville"] ?? "");
                    $continent = (string) ($offre["continent"] ?? "");

                    $destinationTexte = trim($pays . " - " . $ville, " -");

                    if ($continent !== "") {
                        $destinationTexte .= " (" . $continent . ")";
                    }

                    $reduc = (int) ($offre["pourcentage_reduction"] ?? 0);
                    $dateDebut = (string) ($offre["date_debut"] ?? "");
                    $dateFin = (string) ($offre["date_fin"] ?? "");
                    $actif = ((int) ($offre["actif"] ?? 0) === 1);
                    ?>

                    <!-- ligne offre -->

                    <tr>
                        <td><?= $idOffre ?></td>
                        <td><?= htmlspecialchars($titre) ?></td>
                        <td><?= htmlspecialchars($destinationTexte) ?></td>
                        <td><?= $reduc ?>%</td>
                        <td><?= htmlspecialchars($dateDebut) ?></td>
                        <td><?= htmlspecialchars($dateFin) ?></td>
                        <td>
                            <span class="admin-status <?= $actif ? "is-active" : "is-muted" ?>">
                                <?= $actif ? "Active" : "Désactivée" ?>
                            </span>
                        </td>

                        <!-- actions offre -->

                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a
                                    href="index.php?page=admin_offres&action=edit&id_offre=<?= $idOffre ?>"
                                    class="btn btn-sm admin-btn admin-btn-green"
                                >
                                    modifier
                                </a>

                                <?php if ($actif): ?>
                                    <a
                                        href="index.php?page=admin_offres&action=sup&id_offre=<?= $idOffre ?>"
                                        onclick="return confirm('désactiver cette offre ?');"
                                        class="btn btn-sm admin-btn admin-btn-red"
                                    >
                                        désactiver
                                    </a>
                                <?php else: ?>
                                    <a
                                        href="index.php?page=admin_offres&action=reactiver&id_offre=<?= $idOffre ?>"
                                        onclick="return confirm('réactiver cette offre ?');"
                                        class="btn btn-sm admin-btn admin-btn-primary"
                                    >
                                        réactiver
                                    </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>

                <!-- aucune offre -->

                <tr>
                    <td colspan="8" class="text-center text-muted">
                        aucune offre trouvée
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
