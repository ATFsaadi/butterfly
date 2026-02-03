<?php

$destinations = $destinations ?? [];
$destinationToEdit = $destinationToEdit ?? null;
$continents = $continents ?? [];

// mode edition

$isEdit = ($destinationToEdit !== null);

$idDestination = (int) ($destinationToEdit["id_destination"] ?? 0);
$existingImageUrl = $destinationToEdit["image_url"] ?? "";

$pays = $destinationToEdit["pays"] ?? "";
$ville = $destinationToEdit["ville"] ?? "";
$idContinent = $destinationToEdit["id_continent"] ?? "";

$description = $destinationToEdit["description"] ?? "";
$prixBase = $destinationToEdit["prix_base"] ?? "";

$isActif = ((int) ($destinationToEdit["actif"] ?? 1) === 1);

?>

<h3 class="section-title text-center mt-5">Gestion des Destinations</h3>

<form action="" method="post" enctype="multipart/form-data" class="mb-4">

    <input type="hidden" name="id_destination" value="<?= htmlspecialchars((string) $idDestination) ?>">

    <input type="hidden" name="existing_image_url" value="<?= htmlspecialchars((string) $existingImageUrl) ?>">

    <input
        type="text"
        name="pays"
        placeholder="pays"
        required
        class="form-control mb-2"
        value="<?= htmlspecialchars($pays) ?>"
    >

    <input
        type="text"
        name="ville"
        placeholder="ville"
        required
        class="form-control mb-2"
        value="<?= htmlspecialchars($ville) ?>"
    >

    <select name="id_continent" class="form-control mb-2">
        <option value="">-- choisir un continent --</option>

        <?php foreach ($continents as $c): ?>
            <?php
            $cid = (int) ($c["id_continent"] ?? 0);
            $cnom = $c["nom"] ?? "";
            $selected = ((string) $idContinent !== "" && (int) $idContinent === $cid) ? "selected" : "";
            ?>
            <option value="<?= $cid ?>" <?= $selected ?>>
                <?= htmlspecialchars($cnom) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <textarea
        name="description"
        placeholder="description"
        class="form-control mb-2"
        rows="3"
    ><?= htmlspecialchars($description) ?></textarea>

    <input
        type="number"
        step="0.01"
        name="prix_base"
        placeholder="prix base"
        required
        class="form-control mb-2"
        value="<?= htmlspecialchars((string) $prixBase) ?>"
    >

    <input type="file" name="image" class="form-control mb-2" accept="image/*">

    <?php if ($existingImageUrl !== ""): ?>
        <p class="mb-1">image actuelle :</p>
        <img
            src="<?= htmlspecialchars($existingImageUrl) ?>"
            width="150"
            style="border:1px solid #ccc; padding:2px;"
            alt="image destination"
        >
    <?php endif; ?>

    <div class="form-check mb-3 mt-2">
        <input
            class="form-check-input"
            type="checkbox"
            value="1"
            id="actif"
            name="actif"
            <?= $isActif ? "checked" : "" ?>
        >
        <label class="form-check-label" for="actif">destination active</label>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" name="submit" class="btn btn-primary">
            <?= $isEdit ? "modifier la destination" : "ajouter la destination" ?>
        </button>
    </div>

</form>

<hr>
