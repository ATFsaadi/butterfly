<?php
if (!isset($destinations)) $destinations = [];
if (!isset($destinationToEdit)) $destinationToEdit = null;
if (!isset($continents)) $continents = [];
?>

<h2>Gestion des Destinations</h2>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
</div>
<?php endif; ?>

<!-- FORMULAIRE AJOUT / MODIFICATION -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">
    <input type="hidden" name="id_destination" value="<?= htmlspecialchars((string)($destinationToEdit['id_destination'] ?? '')) ?>">
    <input type="hidden" name="existing_image" value="<?= htmlspecialchars((string)($destinationToEdit['image'] ?? '')) ?>">

    <input type="text" name="nom" placeholder="Nom" required class="form-control mb-2"
           value="<?= htmlspecialchars((string)($destinationToEdit['nom'] ?? '')) ?>">

    <!-- ✅ NOUVEAU : Ville -->
    <input type="text" name="ville" placeholder="Ville" required class="form-control mb-2"
           value="<?= htmlspecialchars((string)($destinationToEdit['ville'] ?? '')) ?>">

    <!-- Dropdown Continents -->
    <select name="id_continent" required class="form-control mb-2">
        <option value="">-- Choisir un continent --</option>
        <?php foreach ($continents as $c): ?>
            <?php
                $selected = '';
                $currentIdContinent = $destinationToEdit['id_continent'] ?? null;
                if ($currentIdContinent !== null && (int)$currentIdContinent === (int)$c['id_continent']) {
                    $selected = 'selected';
                }
            ?>
            <option value="<?= (int)$c['id_continent'] ?>" <?= $selected ?>>
                <?= htmlspecialchars((string)$c['nom']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= htmlspecialchars((string)($destinationToEdit['description'] ?? '')) ?></textarea>

    <input type="file" name="image" class="form-control mb-2">

    <?php if (!empty($destinationToEdit['image'])): ?>
        <p>Image actuelle :</p>
        <img src="images/destinations/<?= htmlspecialchars((string)$destinationToEdit['image']) ?>"
             width="150" style="border:1px solid #ccc; padding:2px;">
    <?php endif; ?>

    <button type="submit" name="submit" class="btn btn-primary">
        <?= $destinationToEdit ? 'Modifier la destination' : 'Ajouter la destination' ?>
    </button>
</form>

<hr>

<!-- LISTE DES DESTINATIONS -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Ville</th> <!-- ✅ NOUVEAU -->
            <th>Continent</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($destinations)): ?>
            <?php foreach ($destinations as $dest): ?>
            <tr>
                <td>
                    <?php if (!empty($dest['image'])): ?>
                        <img src="images/destinations/<?= htmlspecialchars((string)$dest['image']) ?>" width="100">
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars((string)($dest['nom'] ?? '')) ?></td>

                <!-- ✅ NOUVEAU : Ville -->
                <td><?= htmlspecialchars((string)($dest['ville'] ?? '')) ?></td>

                <!-- Continent affiché : continent_nom (JOIN), sinon fallback ancien champ continent -->
                <td><?= htmlspecialchars((string)($dest['continent_nom'] ?? $dest['continent'] ?? '')) ?></td>

                <td><?= htmlspecialchars((string)($dest['description'] ?? '')) ?></td>

                <td>
                    <a href="index.php?page=admin_destinations&edit=<?= (int)$dest['id_destination'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="index.php?page=admin_destinations&delete=<?= (int)$dest['id_destination'] ?>"
                       onclick="return confirm('Supprimer cette destination ?');"
                       class="btn btn-danger btn-sm">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6">Aucune destination pour le moment</td></tr>
        <?php endif; ?>
    </tbody>
</table>
