<?php

// sécurité des données

$lesOffres = $lesOffres ?? ($offres ?? []);

?>

<!-- liste offres -->

<h3 class="section-title text-center mt-5">liste des offres</h3>

<!-- filtre offres -->

<form method="post" class="mb-4">
    <input
        type="text"
        name="filtre"
        placeholder="filtrer (titre / pays / ville / continent)"
        class="form-control mb-2"
        value="<?= htmlspecialchars((string) ($_POST["filtre"] ?? "")) ?>"
    >

    <div class="d-flex justify-content-center">
        <button type="submit" name="Filtrer" class="btn btn-primary">
            filtrer
        </button>
    </div>
</form>

<!-- tableau offres -->

<div class="container mt-4">
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>id</th>
                <th>titre</th>
                <th>destination</th>
                <th>réduction</th>
                <th>début</th>
                <th>fin</th>
                <th>actif</th>
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
                        <td><?= $actif ? "oui" : "non" ?></td>

                        <!-- actions offre -->

                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <a
                                    href="index.php?page=admin_offres&action=edit&id_offre=<?= $idOffre ?>"
                                    class="btn btn-warning btn-sm"
                                >
                                    modifier
                                </a>

                                <a
                                    href="index.php?page=admin_offres&action=sup&id_offre=<?= $idOffre ?>"
                                    onclick="return confirm('voulez-vous vraiment supprimer cette offre ?');"
                                    class="btn btn-danger btn-sm"
                                >
                                    supprimer
                                </a>
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