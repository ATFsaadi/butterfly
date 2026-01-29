<?php

/* valeurs par defaut */
if (!isset($destinations)) {
    $destinations = [];
}
if (!isset($destinationToEdit)) {
    $destinationToEdit = null;
}
if (!isset($continents)) {
    $continents = [];
}

?>

<!-- titre page -->
<h3 class="section-title text-center mt-5">Gestion des Destinations</h3>

<!-- bloc erreurs -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <p><?= htmlspecialchars((string) $err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- formulaire destination -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">

    <!-- champs caches -->
    <input type="hidden" name="id_destination"
           value="<?= htmlspecialchars((string) ($destinationToEdit['id_destination'] ?? '')) ?>">

    <input type="hidden" name="existing_image"
           value="<?= htmlspecialchars((string) ($destinationToEdit['image'] ?? '')) ?>">

    <!-- champ nom -->
    <input type="text" name="nom" placeholder="Nom" required class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($destinationToEdit['nom'] ?? '')) ?>">

    <!-- champ ville -->
    <input type="text" name="ville" placeholder="Ville" required class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($destinationToEdit['ville'] ?? '')) ?>">

    <!-- select continent -->
    <select name="id_continent" required class="form-control mb-2">
        <option value="">-- Choisir un continent --</option>

        <?php foreach ($continents as $c): ?>
            <?php
                /* selection continent */
                $selected = '';
                $currentIdContinent = $destinationToEdit['id_continent'] ?? null;

                if ($currentIdContinent !== null && (int) $currentIdContinent === (int) $c['id_continent']) {
                    $selected = 'selected';
                }
            ?>
            <option value="<?= (int) $c['id_continent'] ?>" <?= $selected ?>>
                <?= htmlspecialchars((string) $c['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- champ description -->
    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= htmlspecialchars((string) ($destinationToEdit['description'] ?? '')) ?></textarea>

    <!-- champ image -->
    <input type="file" name="image" class="form-control mb-2">

    <!-- preview image actuelle -->
    <?php if (!empty($destinationToEdit['image'])): ?>
        <p>Image actuelle :</p>
        <img src="images/destinations/<?= htmlspecialchars((string) $destinationToEdit['image']) ?>"
             width="150" style="border:1px solid #ccc; padding:2px;">
    <?php endif; ?>

    <!-- bouton action -->
    <div class="d-flex justify-content-center">
        <button type="submit" name="submit" class="btn btn-primary">
            <?= $destinationToEdit ? 'Modifier la destination' : 'Ajouter la destination' ?>
        </button>
    </div>

</form>

<!-- separation -->
<hr>

<!-- tableau destinations -->
<table class="table table-bordered">

    <!-- entete tableau -->
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Ville</th>
            <th>Continent</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>

    <!-- corps tableau -->
    <tbody>

        <?php if (!empty($destinations)): ?>

            <?php foreach ($destinations as $dest): ?>
                <tr>

                    <!-- colonne image -->
                    <td>
                        <?php if (!empty($dest['image'])): ?>
                            <img src="images/destinations/<?= htmlspecialchars((string) $dest['image']) ?>" width="100">
                        <?php endif; ?>
                    </td>

                    <!-- colonne nom -->
                    <td><?= htmlspecialchars((string) ($dest['nom'] ?? '')) ?></td>

                    <!-- colonne ville -->
                    <td><?= htmlspecialchars((string) ($dest['ville'] ?? '')) ?></td>

                    <!-- colonne continent -->
                    <td><?= htmlspecialchars((string) ($dest['continent_nom'] ?? $dest['continent'] ?? '')) ?></td>

                    <!-- colonne description -->
                    <td><?= htmlspecialchars((string) ($dest['description'] ?? '')) ?></td>

                    <!-- colonne actions -->
                    <td>
                        <a href="index.php?page=admin_destinations&edit=<?= (int) $dest['id_destination'] ?>"
                           class="btn btn-warning btn-sm">Modifier</a>

                        <a href="index.php?page=admin_destinations&delete=<?= (int) $dest['id_destination'] ?>"
                           onclick="return confirm('Supprimer cette destination ?');"
                           class="btn btn-danger btn-sm">Supprimer</a>
                    </td>

                </tr>
            <?php endforeach; ?>

        <?php else: ?>

            <!-- ligne vide -->
            <tr>
                <td colspan="6">Aucune destination pour le moment</td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>
