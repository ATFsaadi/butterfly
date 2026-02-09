<?php

$destinationToEdit = $destinationToEdit ?? ($destination ?? null);
$continents = $continents ?? [];

$isEdit = ($destinationToEdit !== null);

$idDestination = (int)($destinationToEdit["id_destination"] ?? 0);
$existingImageUrl = (string)($destinationToEdit["image_url"] ?? "");

$pays = (string)($destinationToEdit["pays"] ?? "");
$ville = (string)($destinationToEdit["ville"] ?? "");
$idContinent = $destinationToEdit["id_continent"] ?? "";

$description = (string)($destinationToEdit["description"] ?? "");
$prixBase = $destinationToEdit["prix_base"] ?? "";

$isActif = ((int)($destinationToEdit["actif"] ?? 1) === 1);

?>

<h3 class="section-title text-center mt-5">Gestion des Destinations</h3>

<form action="" method="post" enctype="multipart/form-data" class="mb-4">

    <input type="hidden" name="id_destination" value="<?= htmlspecialchars((string)$idDestination) ?>">

    <!-- ===== COLONNE UNIQUE CENTRÉE ===== -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 col-xl-5">

            <input
                type="text"
                name="pays"
                placeholder="pays"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars($pays) ?>"
                maxlength="100"
            >

            <input
                type="text"
                name="ville"
                placeholder="ville"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars($ville) ?>"
                maxlength="100"
            >

            <select name="id_continent" class="form-control mb-2">
                <option value="">-- choisir un continent --</option>

                <?php foreach ($continents as $c): ?>
                    <?php
                    $cid = (int)($c["id_continent"] ?? 0);
                    $cnom = (string)($c["nom"] ?? "");
                    $selected = ((string)$idContinent !== "" && (int)$idContinent === $cid) ? "selected" : "";
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
                min="0.01"
                name="prix_base"
                placeholder="prix base"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars((string)$prixBase) ?>"
            >

            <!-- ===== IMAGE ===== -->
            <label class="form-label mt-2">image (jpg/jpeg/png/gif/webp)</label>
            <input type="file" name="image" class="form-control mb-2" accept="image/*">

            <?php if ($existingImageUrl !== ""): ?>
                <p class="mb-1">image actuelle :</p>
                <img
                    src="<?= htmlspecialchars($existingImageUrl) ?>"
                    class="img-fluid mb-3"
                    style="max-height:220px; border:1px solid #ccc; padding:2px; border-radius:10px;"
                    alt="image destination"
                >
                <div class="form-text mb-3">laisse vide pour conserver l'image actuelle.</div>
            <?php else: ?>
                <div class="form-text mb-3">(obligatoire à la création)</div>
            <?php endif; ?>

            <!-- ===== ACTIF ===== -->
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
                    destination active
                </label>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <button type="submit" name="submit" class="btn btn-primary px-5">
                    <?= $isEdit ? "modifier la destination" : "ajouter la destination" ?>
                </button>
            </div>

        </div>
    </div>

</form>

<hr>
