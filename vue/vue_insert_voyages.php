<?php

$voyageToEdit = $voyageToEdit ?? ($voyage ?? null);
$destinations = $destinations ?? [];

$isEdit = ($voyageToEdit !== null);

$idVoyage = (int)($voyageToEdit["id_voyage"] ?? 0);
$existingImageUrl = (string)($voyageToEdit["image_url"] ?? "");

$idDestination = $voyageToEdit["id_destination"] ?? "";
$titre = (string)($voyageToEdit["titre"] ?? "");
$description = (string)($voyageToEdit["description"] ?? "");
$dateDepart = (string)($voyageToEdit["date_depart"] ?? "");
$dateRetour = (string)($voyageToEdit["date_retour"] ?? "");
$prix = $voyageToEdit["prix"] ?? "";
$nbPlaces = $voyageToEdit["nb_places"] ?? "";
$nbPlacesRestantes = $voyageToEdit["nb_places_restantes"] ?? "";
$statut = (string)($voyageToEdit["statut"] ?? "actif");

?>

<h3 class="section-title text-center mt-5">Gestion des Voyages</h3>

<form action="" method="post" enctype="multipart/form-data" class="mb-4">

    <input type="hidden" name="id_voyage" value="<?= htmlspecialchars((string)$idVoyage) ?>">

    <!-- ===== COLONNE UNIQUE CENTRÉE ===== -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 col-xl-5">

            <select name="id_destination" class="form-control mb-2" required>
                <option value="">-- choisir une destination --</option>
                <?php foreach ($destinations as $d): ?>
                    <?php
                    $did = (int)($d["id_destination"] ?? 0);
                    $dpays = (string)($d["pays"] ?? "");
                    $dville = (string)($d["ville"] ?? "");
                    $dcont = (string)($d["continent"] ?? "");
                    $label = trim($dpays . " - " . $dville, " -");
                    if ($dcont !== "") {
                        $label .= " (" . $dcont . ")";
                    }
                    $selected = ((string)$idDestination !== "" && (int)$idDestination === $did) ? "selected" : "";
                    ?>
                    <option value="<?= $did ?>" <?= $selected ?>>
                        <?= htmlspecialchars($label) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <input
                type="text"
                name="titre"
                placeholder="titre"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars($titre) ?>"
                maxlength="150"
            >

            <textarea
                name="description"
                placeholder="description"
                class="form-control mb-2"
                rows="3"
            ><?= htmlspecialchars($description) ?></textarea>

            <div class="row g-2">
                <div class="col-12 col-md-6">
                    <input
                        type="date"
                        name="date_depart"
                        required
                        class="form-control mb-2"
                        value="<?= htmlspecialchars($dateDepart) ?>"
                    >
                </div>
                <div class="col-12 col-md-6">
                    <input
                        type="date"
                        name="date_retour"
                        required
                        class="form-control mb-2"
                        value="<?= htmlspecialchars($dateRetour) ?>"
                    >
                </div>
            </div>

            <input
                type="number"
                step="0.01"
                min="0.01"
                name="prix"
                placeholder="prix"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars((string)$prix) ?>"
            >

            <div class="row g-2">
                <div class="col-12 col-md-6">
                    <input
                        type="number"
                        min="1"
                        name="nb_places"
                        placeholder="nb places"
                        required
                        class="form-control mb-2"
                        value="<?= htmlspecialchars((string)$nbPlaces) ?>"
                    >
                </div>
                <div class="col-12 col-md-6">
                    <input
                        type="number"
                        min="0"
                        name="nb_places_restantes"
                        placeholder="nb places restantes"
                        required
                        class="form-control mb-2"
                        value="<?= htmlspecialchars((string)$nbPlacesRestantes) ?>"
                    >
                </div>
            </div>

            <!-- ===== IMAGE ===== -->
            <label class="form-label mt-2">image (jpg/jpeg/png/gif/webp)</label>
            <input type="file" name="image" class="form-control mb-2" accept="image/*">

            <?php if ($existingImageUrl !== ""): ?>
                <p class="mb-1">image actuelle :</p>
                <img
                    src="<?= htmlspecialchars($existingImageUrl) ?>"
                    class="img-fluid mb-3"
                    style="max-height:220px; border:1px solid #ccc; padding:2px; border-radius:10px;"
                    alt="image voyage"
                >
                <div class="form-text mb-3">laisse vide pour conserver l'image actuelle.</div>
            <?php else: ?>
                <div class="form-text mb-3">(obligatoire à la création)</div>
            <?php endif; ?>

            <!-- ===== STATUT ===== -->
            <label class="form-label">statut du voyage</label>
            <select name="statut" class="form-control mb-3">
                <?php
                $statuts = [
                    "actif" => "actif",
                    "complet" => "complet",
                    "annule" => "annulé",
                ];
                foreach ($statuts as $val => $label) {
                    $sel = ($statut === $val) ? "selected" : "";
                    echo '<option value="' . htmlspecialchars($val) . '" ' . $sel . '>' . htmlspecialchars($label) . '</option>';
                }
                ?>
            </select>

            <div class="d-flex justify-content-center mt-4">
                <button type="submit" name="submit" class="btn btn-primary px-5">
                    <?= $isEdit ? "modifier le voyage" : "ajouter le voyage" ?>
                </button>
            </div>

        </div>
    </div>

</form>

<hr>
