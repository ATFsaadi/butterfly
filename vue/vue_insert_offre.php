<?php

// sécurité des données

$destinations = $destinations ?? [];
$offre = $offre ?? null;
$errors = $errors ?? [];
$success = $success ?? "";

// mode formulaire

$isEdit = ($offre !== null && !empty($offre["id_offre"] ?? 0));

// données offre

$idOffre = (int) ($offre["id_offre"] ?? ($_POST["id_offre"] ?? 0));
$idOffreDestination = (int) ($offre["id_destination"] ?? ($_POST["id_destination"] ?? 0));

$titre = (string) ($offre["titre"] ?? ($_POST["titre"] ?? ""));
$reduc = (int) ($offre["pourcentage_reduction"] ?? ($_POST["pourcentage_reduction"] ?? 0));
$dateDebut = (string) ($offre["date_debut"] ?? ($_POST["date_debut"] ?? ""));
$dateFin = (string) ($offre["date_fin"] ?? ($_POST["date_fin"] ?? ""));

// statut offre

if ($offre !== null && array_key_exists("actif", $offre)) {
    $isActif = ((int) $offre["actif"] === 1);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $isActif = isset($_POST["actif"]);
} else {
    $isActif = true;
}

?>

<!-- formulaire offres -->

<h3 class="section-title text-center mt-5">Gestion des Offres</h3>

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

<form action="" method="post" class="mb-4">
    <input
        type="hidden"
        name="id_offre"
        value="<?= htmlspecialchars((string) $idOffre) ?>"
    >

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 col-xl-5">

            <!-- destination -->

            <select name="id_destination" class="form-control mb-2" required>
                <option value="">-- choisir une destination --</option>

                <?php foreach ($destinations as $destination): ?>
                    <?php
                    $idDestination = (int) ($destination["id_destination"] ?? 0);
                    $pays = (string) ($destination["pays"] ?? "");
                    $ville = (string) ($destination["ville"] ?? "");
                    $actifDestination = (int) ($destination["actif"] ?? 1);

                    $labelDestination = trim($pays . " - " . $ville, " -");

                    if ($actifDestination !== 1) {
                        $labelDestination .= " (inactive)";
                    }

                    $selected = ($idOffreDestination === $idDestination) ? "selected" : "";
                    ?>

                    <option value="<?= $idDestination ?>" <?= $selected ?>>
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

            <!-- réduction -->

            <input
                type="number"
                name="pourcentage_reduction"
                placeholder="réduction (%)"
                required
                min="1"
                max="100"
                class="form-control mb-2"
                value="<?= htmlspecialchars((string) $reduc) ?>"
            >

            <!-- dates -->

            <div class="row g-2">
                <div class="col-12 col-md-6">
                    <input
                        type="date"
                        name="date_debut"
                        required
                        class="form-control mb-2"
                        value="<?= htmlspecialchars($dateDebut) ?>"
                    >
                </div>

                <div class="col-12 col-md-6">
                    <input
                        type="date"
                        name="date_fin"
                        required
                        class="form-control mb-2"
                        value="<?= htmlspecialchars($dateFin) ?>"
                    >
                </div>
            </div>

            <!-- statut -->

            <div class="form-check form-switch mt-2">
                <input
                    class="form-check-input"
                    type="checkbox"
                    role="switch"
                    value="1"
                    id="actif_offre"
                    name="actif"
                    <?= $isActif ? "checked" : "" ?>
                >

                <label class="form-check-label" for="actif_offre">
                    offre active
                </label>
            </div>

            <!-- bouton validation -->

            <div class="d-flex justify-content-center mt-4">
                <button
                    type="submit"
                    name="<?= $isEdit ? "Modifier" : "Valider" ?>"
                    class="btn btn-primary px-5"
                >
                    <?= $isEdit ? "modifier l'offre" : "ajouter l'offre" ?>
                </button>
            </div>

        </div>
    </div>
</form>

<hr>