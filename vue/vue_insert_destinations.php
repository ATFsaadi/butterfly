<?php

// Formulaire admin destination : creation ou modification.

// sécurité des données

$destinationToEdit = $destinationToEdit ?? ($destination ?? null);
$continents = $continents ?? [];
$errors = $errors ?? [];
$success = $success ?? "";

// mode formulaire

$isEdit = ($destinationToEdit !== null);

// données destination

$idDestination = (int) ($destinationToEdit["id_destination"] ?? 0);
$existingImageUrl = (string) ($destinationToEdit["image_url"] ?? "");

$pays = (string) ($destinationToEdit["pays"] ?? "");
$ville = (string) ($destinationToEdit["ville"] ?? "");
$idContinent = $destinationToEdit["id_continent"] ?? "";

$description = (string) ($destinationToEdit["description"] ?? "");
$prixBase = $destinationToEdit["prix_base"] ?? "";

$isActif = ((int) ($destinationToEdit["actif"] ?? 1) === 1);

?>

<!-- formulaire destinations -->

<h3 class="section-title text-center mt-5">Gestion des Destinations</h3>

<!-- messages erreurs -->

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $erreur): ?>
                <li><?= htmlspecialchars((string) $erreur) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- message succès -->

<?php if ($success !== ""): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<!-- formulaire -->

<form action="" method="post" enctype="multipart/form-data" class="mb-4">

    <?php if ($isEdit): ?>
        <input
            type="hidden"
            name="id_destination"
            value="<?= htmlspecialchars((string) $idDestination) ?>"
        >
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 col-xl-5">

            <!-- pays -->

            <input
                type="text"
                name="pays"
                placeholder="pays"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars($pays) ?>"
                maxlength="100"
            >

            <!-- ville -->

            <input
                type="text"
                name="ville"
                placeholder="ville"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars($ville) ?>"
                maxlength="100"
            >

            <!-- continent -->

            <select name="id_continent" class="form-control mb-2">
                <option value="">-- choisir un continent --</option>

                <?php foreach ($continents as $continent): ?>
                    <?php
                    $idContinentOption = (int) ($continent["id_continent"] ?? 0);

                    $nomContinent = (string) (
                        $continent["nom"]
                        ?? $continent["nom_continent"]
                        ?? $continent["continent"]
                        ?? ""
                    );

                    $selected = (
                        (string) $idContinent !== "" &&
                        (int) $idContinent === $idContinentOption
                    ) ? "selected" : "";
                    ?>

                    <option value="<?= htmlspecialchars((string) $idContinentOption) ?>" <?= $selected ?>>
                        <?= htmlspecialchars($nomContinent) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- description -->

            <textarea
                name="description"
                placeholder="description"
                class="form-control mb-2"
                rows="3"
            ><?= htmlspecialchars($description) ?></textarea>

            <!-- prix -->

            <input
                type="number"
                step="0.01"
                min="0.01"
                name="prix_base"
                placeholder="prix base"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars((string) $prixBase) ?>"
            >

            <!-- image -->

            <label class="form-label mt-2">image (jpg/jpeg/png/gif/webp)</label>

            <input
                type="file"
                name="image"
                class="form-control mb-2"
                accept="image/jpeg,image/png,image/gif,image/webp"
            >

            <?php if ($existingImageUrl !== ""): ?>
                <p class="mb-1">image actuelle :</p>

                <img
                    src="<?= htmlspecialchars($existingImageUrl) ?>"
                    class="img-fluid mb-3"
                    style="max-height:220px; border:1px solid #ccc; padding:2px; border-radius:10px;"
                    alt="image destination"
                >

                <div class="form-text mb-3">
                    Laisse vide pour conserver l'image actuelle.
                </div>
            <?php else: ?>
                <div class="form-text mb-3">
                    Image facultative.
                </div>
            <?php endif; ?>

            <!-- statut -->

            <div class="form-check form-switch mt-2">
                <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    value="1"
                    id="actif"
                    name="actif"
                    <?= $isActif ? "checked" : "" ?>
                >

                <label class="form-check-label" for="actif">
                    Destination active
                </label>
            </div>

            <!-- bouton validation -->

            <div class="d-flex justify-content-center mt-4">
                <button type="submit" name="submit" class="btn btn-primary px-5">
                    <?= $isEdit ? "Modifier la destination" : "Ajouter la destination" ?>
                </button>
            </div>

        </div>
    </div>
</form>

<hr>
