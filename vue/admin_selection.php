<?php

require_once __DIR__ . '/../controleur/gestion.selection.php';

?>

<h2>Gestion des Slides</h2>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
</div>
<?php endif; ?>

<!-- FORMULAIRE AJOUT / MODIFICATION -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">
    <input type="hidden" name="id_slide" value="<?= $slideToEdit['id_slide'] ?? '' ?>">
    <input type="hidden" name="existing_image" value="<?= $slideToEdit['image'] ?? '' ?>">

    <input type="text" name="titre" placeholder="Titre" required class="form-control mb-2" value="<?= $slideToEdit['titre'] ?? '' ?>">
    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= $slideToEdit['description'] ?? '' ?></textarea>
    <input type="text" name="lien" placeholder="Lien (facultatif)" class="form-control mb-2" value="<?= $slideToEdit['lien'] ?? '' ?>">
    <input type="number" name="ordre" placeholder="Ordre" class="form-control mb-2" value="<?= $slideToEdit['ordre'] ?? 1 ?>">
    
    <label><input type="checkbox" name="actif" <?= (!isset($slideToEdit) || $slideToEdit['actif']) ? 'checked' : '' ?>> Actif</label>
    <input type="file" name="image" class="form-control mb-2">
    
    <?php if (!empty($slideToEdit['image'])): ?>
        <p>Image actuelle: <img src="images/slides/<?= htmlspecialchars($slideToEdit['image']) ?>" width="100"></p>
    <?php endif; ?>

    <button type="submit" name="submit_slide" class="btn btn-primary">
        <?= $slideToEdit ? 'Modifier le slide' : 'Ajouter le slide' ?>
    </button>
</form>

<hr>

<!-- LISTE DES SLIDES -->
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Description</th>
            <th>Lien</th>
            <th>Ordre</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($slides as $slide): ?>
        <tr>
            <td><img src="images/slides/<?= htmlspecialchars($slide['image']) ?>" width="100"></td>
            <td><?= htmlspecialchars($slide['titre']) ?></td>
            <td><?= htmlspecialchars($slide['description']) ?></td>
            <td><?= htmlspecialchars($slide['lien']) ?></td>
            <td><?= htmlspecialchars($slide['ordre']) ?></td>
            <td><?= $slide['actif'] ? 'Oui' : 'Non' ?></td>
            <td>
                <a href="index.php?page=admin_selection&edit=<?= $slide['id_slide'] ?>"
   class="btn btn-warning btn-sm">
   Modifier
</a>

<a href="index.php?page=admin_selection&delete=<?= $slide['id_slide'] ?>"
   onclick="return confirm('Supprimer ce slide ?');"
   class="btn btn-danger btn-sm">
   Supprimer
</a>

            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
