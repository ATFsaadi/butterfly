<?php

// sécurité des données

$lesVoyages = $lesVoyages ?? ($voyages ?? []);

?>

<!-- liste voyages -->

<h3 class="section-title text-center mt-5">liste des voyages</h3>

<!-- filtre voyages -->

<form method="post" class="mb-4">
    <input
        type="text"
        name="filtre"
        placeholder="filtrer (titre / pays / ville / statut)"
        class="form-control mb-2"
        value="<?= htmlspecialchars((string) ($_POST["filtre"] ?? "")) ?>"
    >

    <div class="d-flex justify-content-center">
        <button type="submit" name="Filtrer" class="btn btn-primary">
            filtrer
        </button>
    </div>
</form>

<!-- tableau voyages -->

<div class="container mt-4">
    <table class="table table-bordered align-middle">
        <thead>
            <tr>
                <th>aperçu</th>
                <th>titre</th>
                <th>destination</th>
                <th>dates</th>
                <th>prix</th>
                <th>places</th>
                <th>statut</th>
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
                        <td><?= htmlspecialchars($statut) ?></td>

                        <!-- actions voyage -->

                        <td>
                            <a
                                href="index.php?page=admin_voyages&action=edit&id_voyage=<?= $id ?>"
                                class="btn btn-warning btn-sm"
                            >
                                modifier
                            </a>

                            <a
                                href="index.php?page=admin_voyages&action=sup&id_voyage=<?= $id ?>"
                                onclick="return confirm('supprimer ce voyage ?');"
                                class="btn btn-danger btn-sm"
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