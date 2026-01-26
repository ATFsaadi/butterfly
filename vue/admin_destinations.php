<?php
if (!isset($destinations)) $destinations = [];
if (!isset($destinationToEdit)) $destinationToEdit = null;
?>

<h2>Gestion des Destinations</h2>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
</div>
<?php endif; ?>

<!-- FORMULAIRE AJOUT / MODIFICATION -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">
    <input type="hidden" name="id_destination" value="<?= $destinationToEdit['id_destination'] ?? '' ?>">
    <input type="hidden" name="existing_image" value="<?= $destinationToEdit['image'] ?? '' ?>">

    <input type="text" name="nom" placeholder="Nom" required class="form-control mb-2" value="<?= htmlspecialchars($destinationToEdit['nom'] ?? '') ?>">
    <input type="text" name="continent" placeholder="Continent" required class="form-control mb-2" value="<?= htmlspecialchars($destinationToEdit['continent'] ?? '') ?>">
    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= htmlspecialchars($destinationToEdit['description'] ?? '') ?></textarea>
    <input type="file" name="image" class="form-control mb-2">

    <?php if (!empty($destinationToEdit['image'])): ?>
        <p>Image actuelle :</p>
        <img src="images/destinations/<?= htmlspecialchars($destinationToEdit['image']) ?>" width="150" style="border:1px solid #ccc; padding:2px;">
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
                        <img src="images/destinations/<?= htmlspecialchars($dest['image']) ?>" width="100">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($dest['nom']) ?></td>
                <td><?= htmlspecialchars($dest['continent']) ?></td>
                <td><?= htmlspecialchars($dest['description']) ?></td>
                <td>
                    <a href="index.php?page=admin_destinations&edit=<?= $dest['id_destination'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="index.php?page=admin_destinations&delete=<?= $dest['id_destination'] ?>" onclick="return confirm('Supprimer cette destination ?');" class="btn btn-danger btn-sm">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5">Aucune destination pour le moment</td></tr>
        <?php endif; ?>
    </tbody>
</table>
