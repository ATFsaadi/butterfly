<?php

/* controleur slides */
require_once __DIR__ . '/../controleur/gestion.slides.php';

/* valeurs par defaut */
$slides      = $slides ?? [];
$slideToEdit = $slideToEdit ?? null;
$errors      = $errors ?? [];

?>

<!-- titre page -->
<h3 class="section-title text-center mt-5">Gestion des Slides</h3>

<!-- bloc erreurs -->
<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $err): ?>
            <p><?= htmlspecialchars((string) $err) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<!-- formulaire slide -->
<form action="" method="POST" enctype="multipart/form-data" class="mb-4">

    <!-- champs caches -->
    <input type="hidden" name="id_slide"
           value="<?= htmlspecialchars((string) ($slideToEdit['id_slide'] ?? '')) ?>">

    <input type="hidden" name="existing_image"
           value="<?= htmlspecialchars((string) ($slideToEdit['image'] ?? '')) ?>">

    <!-- champ titre -->
    <input type="text" name="titre" placeholder="Titre" required class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($slideToEdit['titre'] ?? '')) ?>">

    <!-- champ description -->
    <textarea name="description" placeholder="Description" class="form-control mb-2"><?= htmlspecialchars((string) ($slideToEdit['description'] ?? '')) ?></textarea>

    <!-- champ lien -->
    <input type="text" name="lien" placeholder="Lien (facultatif)" class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($slideToEdit['lien'] ?? '')) ?>">

    <!-- champ ordre -->
    <input type="number" name="ordre" placeholder="Ordre" class="form-control mb-2"
           value="<?= htmlspecialchars((string) ($slideToEdit['ordre'] ?? 1)) ?>">

    <!-- checkbox actif -->
    <label class="mb-2">
        <input type="checkbox" name="actif"
            <?= (empty($slideToEdit) || (int) ($slideToEdit['actif'] ?? 0) === 1) ? 'checked' : '' ?>>
        Actif
    </label>

    <!-- champ image -->
    <input type="file" name="image" class="form-control mb-2">

    <!-- preview image actuelle -->
    <?php if (!empty($slideToEdit['image'])): ?>
        <p>
            Image actuelle :
            <img src="images/slides/<?= htmlspecialchars((string) $slideToEdit['image']) ?>" width="100">
        </p>
    <?php endif; ?>

    <!-- bouton action -->
    <div class="d-flex justify-content-center">
        <button type="submit" name="submit_slide" class="btn btn-primary">
            <?= $slideToEdit ? 'Modifier le slide' : 'Ajouter le slide' ?>
        </button>
    </div>

</form>

<!-- separation -->
<hr>

<!-- tableau slides -->
<table class="table table-bordered">

    <!-- entete tableau -->
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

    <!-- corps tableau -->
    <tbody>

        <?php if (!empty($slides)): ?>

            <?php foreach ($slides as $slide): ?>
                <tr>

                    <!-- colonne image -->
                    <td>
                        <?php if (!empty($slide['image'])): ?>
                            <img src="images/slides/<?= htmlspecialchars((string) $slide['image']) ?>" width="100">
                        <?php endif; ?>
                    </td>

                    <!-- colonne titre -->
                    <td><?= htmlspecialchars((string) ($slide['titre'] ?? '')) ?></td>

                    <!-- colonne description -->
                    <td><?= htmlspecialchars((string) ($slide['description'] ?? '')) ?></td>

                    <!-- colonne lien -->
                    <td><?= htmlspecialchars((string) ($slide['lien'] ?? '')) ?></td>

                    <!-- colonne ordre -->
                    <td><?= htmlspecialchars((string) ($slide['ordre'] ?? '')) ?></td>

                    <!-- colonne actif -->
                    <td><?= ((int) ($slide['actif'] ?? 0) === 1) ? 'Oui' : 'Non' ?></td>

                    <!-- colonne actions -->
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

            <!-- ligne vide -->
            <tr>
                <td colspan="7">Aucun slide</td>
            </tr>

        <?php endif; ?>

    </tbody>
</table>
