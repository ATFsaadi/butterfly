<?php
$lesOffres = $lesOffres ?? ($offres ?? []);
?>

<h3 class="section-title text-center mt-5">liste des offres</h3>

<form method="post" class="mb-4">
    <input
        type="text"
        name="filtre"
        placeholder="filtrer (titre / pays / ville)"
        class="form-control mb-2"
        value="<?= htmlspecialchars($_POST["filtre"] ?? "") ?>"
    >

    <div class="d-flex justify-content-center">
        <button type="submit" name="Filtrer" class="btn btn-primary">filtrer</button>
    </div>
</form>

<div class="container mt-4">
    <table class="table table-bordered">
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
                <?php foreach ($lesOffres as $o): ?>

                    <?php
                    $idOffre = (int) ($o["id_offre"] ?? 0);
                    $titre = $o["titre"] ?? "";
                    $pays = $o["pays"] ?? "";
                    $ville = $o["ville"] ?? "";
                    $destinationTexte = trim($pays . " - " . $ville, " -");

                    $reduc = (int) ($o["pourcentage_reduction"] ?? 0);
                    $dateDebut = $o["date_debut"] ?? "";
                    $dateFin = $o["date_fin"] ?? "";
                    $actif = ((int) ($o["actif"] ?? 0) === 1);
                    ?>

                    <tr>
                        <td><?= $idOffre ?></td>
                        <td><?= htmlspecialchars($titre) ?></td>
                        <td><?= htmlspecialchars($destinationTexte) ?></td>
                        <td><?= $reduc ?>%</td>
                        <td><?= htmlspecialchars($dateDebut) ?></td>
                        <td><?= htmlspecialchars($dateFin) ?></td>
                        <td><?= $actif ? "oui" : "non" ?></td>

                        <td>
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
                        </td>
                    </tr>

                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        aucune offre trouvée
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
