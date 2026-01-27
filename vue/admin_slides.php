<?php

require_once __DIR__ . '/../controleur/gestion.slides.php';
?>

<h3 class="section-title text-center mt-5">Gestion des Slides</h3>

<!-- erreurs -->
<?php if (!empty($errors)): ?>
<div class="alert alert-danger">
    <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
</div>
<?php endif; ?>

<!-- formulaire -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">

    <!-- champs caches -->
    <input type="hidden" name="id_slide" value="<?= $slideToEdit['id_slide'] ?? '' ?>">
    <input type="hidden" name="existing_image" value="<?= $slideToEdit['image'] ?? '' ?>">

    <!-- titre -->
    <input type="text" name="titre" placeholder="Titre" required class="form-control mb-2"
           value="<?= $slideToEdit['titre'] ?? '' ?>">

    <!-- description -->
    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= $slideToEdit['description'] ?? '' ?></textarea>

    <!-- lien -->
    <input type="text" name="lien" placeholder="Lien (facultatif)" class="form-control mb-2"
           value="<?= $slideToEdit['lien'] ?? '' ?>">

    <!-- ordre -->
    <input type="number" name="ordre" placeholder="Ordre" class="form-control mb-2"
           value="<?= $slideToEdit['ordre'] ?? 1 ?>">

    <!-- actif -->
    <label>
        <input type="checkbox" name="actif" <?= (!isset($slideToEdit) || ($slideToEdit['actif'] ?? 0)) ? 'checked' : '' ?>>
        Actif
    </label>

    <!-- image -->
    <input type="file" name="image" class="form-control mb-2">

    <!-- image actuelle -->
    <?php if (!empty($slideToEdit['image'])): ?>
        <p>
            Image actuelle:
            <img src="images/slides/<?= htmlspecialchars($slideToEdit['image']) ?>" width="100">
        </p>
    <?php endif; ?>

    <!-- action -->
    <button type="submit" name="submit_slide" class="btn btn-primary">
        <?= $slideToEdit ? 'Modifier le slide' : 'Ajouter le slide' ?>
    </button>
</form>

<!-- separation -->
<hr>

<!-- liste slides -->
<table class="table table-bordered">

    <!-- entete -->
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

    <!-- contenu -->
    <tbody>
        <?php foreach ($slides as $slide): ?>
        <tr>

            <!-- image -->
            <td>
                <img src="images/slides/<?= htmlspecialchars($slide['image']) ?>" width="100">
            </td>

            <!-- titre -->
            <td><?= htmlspecialchars($slide['titre']) ?></td>

            <!-- description -->
            <td><?= htmlspecialchars($slide['description']) ?></td>

            <!-- lien -->
            <td><?= htmlspecialchars($slide['lien']) ?></td>

            <!-- ordre -->
            <td><?= htmlspecialchars($slide['ordre']) ?></td>

            <!-- actif -->
            <td><?= $slide['actif'] ? 'Oui' : 'Non' ?></td>

            <!-- actions -->
            <td>
                <a href="index.php?page=admin_slides&edit=<?= $slide['id_slide'] ?>"
                   class="btn btn-warning btn-sm">
                    Modifier
                </a>

                <a href="index.php?page=admin_slides&delete=<?= $slide['id_slide'] ?>"
                   onclick="return confirm('Supprimer ce slide ?');"
                   class="btn btn-danger btn-sm">
                    Supprimer
                </a>
            </td>

        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
