<?php

// Formulaire admin voyage : creation ou modification.

// sécurité des données

$voyageToEdit = $voyageToEdit ?? ($voyage ?? null);
$destinations = $destinations ?? [];
$errors = $errors ?? [];
$success = $success ?? "";

// mode formulaire

$isEdit = ($voyageToEdit !== null);

// données voyage

$idVoyage = (int) ($voyageToEdit["id_voyage"] ?? 0);
$existingImageUrl = (string) ($voyageToEdit["image_url"] ?? "");

$idDestination = $voyageToEdit["id_destination"] ?? "";
$titre = (string) ($voyageToEdit["titre"] ?? "");
$description = (string) ($voyageToEdit["description"] ?? "");
$dateDepart = (string) ($voyageToEdit["date_depart"] ?? "");
$dateRetour = (string) ($voyageToEdit["date_retour"] ?? "");
$prix = $voyageToEdit["prix"] ?? "";
$nbPlaces = $voyageToEdit["nb_places"] ?? "";
$nbPlacesRestantes = $voyageToEdit["nb_places_restantes"] ?? "";
$statut = (string) ($voyageToEdit["statut"] ?? "actif");
$isActif = ($statut !== "annule");

?>

<!-- formulaire voyages -->

<h3 class="section-title text-center mt-5">Gestion des Voyages</h3>

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
    <input
        type="hidden"
        name="id_voyage"
        value="<?= htmlspecialchars((string) $idVoyage) ?>"
    >

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 col-xl-5">

            <!-- destination -->

            <select name="id_destination" class="form-control mb-2" required>
                <option value="">-- choisir une destination --</option>

                <?php foreach ($destinations as $destination): ?>
                    <?php
                    $idDestinationOption = (int) ($destination["id_destination"] ?? 0);
                    $paysDestination = (string) ($destination["pays"] ?? "");
                    $villeDestination = (string) ($destination["ville"] ?? "");
                    $continentDestination = (string) ($destination["continent"] ?? "");
                    $actifDestination = (int) ($destination["actif"] ?? 1);

                    $labelDestination = trim($paysDestination . " - " . $villeDestination, " -");

                    if ($continentDestination !== "") {
                        $labelDestination .= " (" . $continentDestination . ")";
                    }

                    if ($actifDestination !== 1) {
                        $labelDestination .= " - inactive";
                    }

                    $selected = ((string) $idDestination !== "" && (int) $idDestination === $idDestinationOption)
                        ? "selected"
                        : "";
                    ?>

                    <option value="<?= $idDestinationOption ?>" <?= $selected ?>>
                        <?= htmlspecialchars($labelDestination) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- titre -->

            <input
                type="text"
                name="titre"
                placeholder="titre"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars($titre) ?>"
                maxlength="150"
            >

            <!-- description -->

            <textarea
                name="description"
                placeholder="description"
                class="form-control mb-2"
                rows="3"
            ><?= htmlspecialchars($description) ?></textarea>

            <!-- dates -->

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

            <!-- prix -->

            <input
                type="number"
                step="0.01"
                min="0.01"
                name="prix"
                placeholder="prix"
                required
                class="form-control mb-2"
                value="<?= htmlspecialchars((string) $prix) ?>"
            >

            <!-- places -->

            <div class="row g-2">
                <div class="col-12 col-md-6">
                    <input
                        type="number"
                        min="1"
                        name="nb_places"
                        placeholder="nb places"
                        required
                        class="form-control mb-2"
                        value="<?= htmlspecialchars((string) $nbPlaces) ?>"
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
                        value="<?= htmlspecialchars((string) $nbPlacesRestantes) ?>"
                    >
                </div>
            </div>

            <!-- image -->

            <label class="form-label mt-2">image (jpg/jpeg/png/gif/webp)</label>

            <input
                type="file"
                name="image"
                class="form-control mb-2"
                accept="image/*"
            >

            <?php if ($existingImageUrl !== ""): ?>
                <p class="mb-1">image actuelle :</p>

                <img
                    src="<?= htmlspecialchars($existingImageUrl) ?>"
                    class="img-fluid mb-3"
                    style="max-height:220px; border:1px solid #ccc; padding:2px; border-radius:10px;"
                    alt="image voyage"
                >

                <div class="form-text mb-3">
                    laisse vide pour conserver l'image actuelle.
                </div>
            <?php else: ?>
                <div class="form-text mb-3">
                    image facultative.
                </div>
            <?php endif; ?>

            <!-- statut -->

            <div class="form-check form-switch mt-2 mb-3">
                <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    value="1"
                    id="statut_voyage"
                    name="statut_actif"
                    <?= $isActif ? "checked" : "" ?>
                >

                <label class="form-check-label" for="statut_voyage">
                    voyage actif
                </label>
            </div>

            <label class="form-label d-none">statut du voyage</label>

            <select name="statut" class="form-control mb-3 d-none" aria-hidden="true">
                <?php
                $statuts = [
                    "actif" => "actif",
                    "complet" => "complet",
                    "annule" => "annulé",
                ];
                ?>

                <?php foreach ($statuts as $valeurStatut => $labelStatut): ?>
                    <option
                        value="<?= htmlspecialchars($valeurStatut) ?>"
                        <?= $statut === $valeurStatut ? "selected" : "" ?>
                    >
                        <?= htmlspecialchars($labelStatut) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- bouton validation -->

            <div class="d-flex justify-content-center mt-4">
                <button type="submit" name="submit" class="btn btn-primary px-5">
                    <?= $isEdit ? "modifier le voyage" : "ajouter le voyage" ?>
                </button>
            </div>

        </div>
    </div>
</form>

<hr>
