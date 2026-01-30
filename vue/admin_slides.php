<?php
$slides      = $slides ?? [];
$slideToEdit = $slideToEdit ?? null;
$errors      = $errors ?? [];
?>

<h3 class="section-title text-center mt-5">Gestion des Slides</h3>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <p><?= htmlspecialchars((string) $err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data" class="mb-4">

    <input type="hidden" name="id_slide"
           value="<?= htmlspecialchars((string) ($slideToEdit['id_slide'] ?? '')) ?>">

    <input type="hidden" name="existing_image_url"
           value="<?= htmlspecialchars((string) ($slideToEdit['image_url'] ?? '')) ?>">

    <input type="text" name="titre" placeholder="Titre" required class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($slideToEdit['titre'] ?? '')) ?>">

    <textarea name="sous_titre" placeholder="Sous-titre" class="form-control mb-2"><?= htmlspecialchars((string) ($slideToEdit['sous_titre'] ?? '')) ?></textarea>

    <input type="number" name="ordre" placeholder="Ordre" class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($slideToEdit['ordre'] ?? 1)) ?>">

    <label class="mb-2">
        <input type="checkbox" name="actif"
            <?= (empty($slideToEdit) || (int) ($slideToEdit['actif'] ?? 0) === 1) ? 'checked' : '' ?>>
        Actif
    </label>

    <input type="file" name="image" class="form-control mb-2">

    <?php if (!empty($slideToEdit['image_url'])): ?>
        <p>
            Image actuelle :
            <img src="images/slides/<?= htmlspecialchars((string) $slideToEdit['image_url']) ?>" width="100">
        </p>
    <?php endif; ?>

    <div class="d-flex justify-content-center">
        <button type="submit" name="submit_slide" class="btn btn-primary">
            <?= $slideToEdit ? 'Modifier le slide' : 'Ajouter le slide' ?>
        </button>
    </div>

</form>

<hr>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Image</th>
            <th>Titre</th>
            <th>Sous-titre</th>
            <th>Ordre</th>
            <th>Actif</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php if (!empty($slides)): ?>

            <?php foreach ($slides as $slide): ?>
                <tr>
                    <td>
                        <?php if (!empty($slide['image_url'])): ?>
                            <img src="images/slides/<?= htmlspecialchars((string) $slide['image_url']) ?>" width="100">
                        <?php endif; ?>
                    </td>

                    <td><?= htmlspecialchars((string) ($slide['titre'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string) ($slide['sous_titre'] ?? '')) ?></td>
                    <td><?= htmlspecialchars((string) ($slide['ordre'] ?? '')) ?></td>
                    <td><?= ((int) ($slide['actif'] ?? 0) === 1) ? 'Oui' : 'Non' ?></td>

                    <td>
                        <a href="index.php?page=admin_slides&edit=<?= (int) ($slide['id_slide'] ?? 0) ?>"
                           class="btn btn-warning btn-sm">
                            Modifier
                        </a>

                        <a href="index.php?page=admin_slides&delete=<?= (int) ($slide['id_slide'] ?? 0) ?>"
                           onclick="return confirm('Supprimer ce slide ?');"
                           class="btn btn-danger btn-sm">
                            Supprimer
                        </a>
                    </td>

                </tr>
            <?php endforeach; ?>

        <?php else: ?>
            <tr>
                <td colspan="6">Aucun slide</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
