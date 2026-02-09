<?php

$lesVoyages = $lesVoyages ?? ($voyages ?? []);

?>

<h3 class="section-title text-center mt-5">liste des voyages</h3>

<form method="post" class="mb-4">
    <input
        type="text"
        name="filtre"
        placeholder="filtrer (titre / pays / ville / statut)"
        class="form-control mb-2"
        value="<?= htmlspecialchars((string)($_POST["filtre"] ?? "")) ?>"
    >

    <div class="d-flex justify-content-center">
        <button type="submit" name="Filtrer" class="btn btn-primary">filtrer</button>
    </div>
</form>

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
                <?php foreach ($lesVoyages as $v): ?>

                    <?php
                    $id = (int)($v["id_voyage"] ?? 0);
                    $titre = (string)($v["titre"] ?? "");
                    $pays = (string)($v["pays"] ?? "");
                    $ville = (string)($v["ville"] ?? "");
                    $continent = (string)($v["continent"] ?? "");
                    $dateDepart = (string)($v["date_depart"] ?? "");
                    $dateRetour = (string)($v["date_retour"] ?? "");
                    $prix = (float)($v["prix"] ?? 0);
                    $nbPlaces = (int)($v["nb_places"] ?? 0);
                    $nbRestantes = (int)($v["nb_places_restantes"] ?? 0);
                    $statut = (string)($v["statut"] ?? "");
                    $image = (string)($v["image_url"] ?? "");

                    $destLabel = trim($pays . " - " . $ville, " -");
                    if ($continent !== "") {
                        $destLabel .= " (" . $continent . ")";
                    }
                    ?>

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
                        <td><?= htmlspecialchars($destLabel) ?></td>
                        <td><?= htmlspecialchars($dateDepart) ?> → <?= htmlspecialchars($dateRetour) ?></td>
                        <td><?= number_format($prix, 2, ",", " ") ?> €</td>
                        <td><?= $nbRestantes ?> / <?= $nbPlaces ?></td>
                        <td><?= htmlspecialchars($statut) ?></td>

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
                <tr>
                    <td colspan="8" class="text-center text-muted">
                        aucun voyage pour le moment
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
