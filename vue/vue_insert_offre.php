<?php
$destinations = $destinations ?? [];
$offre = $offre ?? null;
$errors = $errors ?? [];
$success = $success ?? "";

$isEdit = ($offre !== null && !empty($offre["id_offre"] ?? 0));

$idOffre = (int)($offre["id_offre"] ?? ($_POST["id_offre"] ?? 0));
$idOffreDestination = (int)($offre["id_destination"] ?? ($_POST["id_destination"] ?? 0));

$titre = (string)($offre["titre"] ?? ($_POST["titre"] ?? ""));
$reduc = (int)($offre["pourcentage_reduction"] ?? ($_POST["pourcentage_reduction"] ?? 0));
$dateDebut = (string)($offre["date_debut"] ?? ($_POST["date_debut"] ?? ""));
$dateFin = (string)($offre["date_fin"] ?? ($_POST["date_fin"] ?? ""));

if ($offre !== null && array_key_exists("actif", $offre)) {
    $isActif = ((int)$offre["actif"] === 1);
} elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $isActif = isset($_POST["actif"]);
} else {
    $isActif = true;
}
?>

<h3 class="section-title text-center mt-5">Gestion des Offres</h3>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $erreur): ?>
                <li><?= htmlspecialchars((string)$erreur) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($success !== ""): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<form action="" method="post" class="mb-4">

    <input type="hidden" name="id_offre" value="<?= htmlspecialchars((string)$idOffre) ?>">

    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 col-xl-5">

            <select name="id_destination" class="form-control mb-2" required>
                <option value="">-- choisir une destination --</option>

                <?php foreach ($destinations as $d): ?>
                    <?php
                    $idDest = (int)($d["id_destination"] ?? 0);
                    $pays = (string)($d["pays"] ?? "");
                    $ville = (string)($d["ville"] ?? "");
                    $actifDest = (int)($d["actif"] ?? 1);

                    $labelDest = trim($pays . " - " . $ville, " -");
                    if ($actifDest !== 1) {
                        $labelDest .= " (inactive)";
                    }

                    $selected = ($idOffreDestination === $idDest) ? "selected" : "";
                    ?>
                    <option value="<?= $idDest ?>" <?= $selected ?>>
                        <?= htmlspecialchars($labelDest) ?>
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

            <input
                type="number"
                name="pourcentage_reduction"
                placeholder="réduction (%)"
                required
                min="1"
                max="100"
                class="form-control mb-2"
                value="<?= htmlspecialchars((string)$reduc) ?>"
            >

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