<?php
$destinations = $destinations ?? [];
$offre = $offre ?? null;

$isEdit = ($offre !== null);

$idOffre = (int)($offre["id_offre"] ?? 0);
$idOffreDestination = (int)($offre["id_destination"] ?? 0);

$titre = (string)($offre["titre"] ?? "");
$reduc = (int)($offre["pourcentage_reduction"] ?? 0);
$dateDebut = (string)($offre["date_debut"] ?? "");
$dateFin = (string)($offre["date_fin"] ?? "");
$isActif = ((int)($offre["actif"] ?? 1) === 1);
?>

<h3 class="section-title text-center mt-5">Gestion des Offres</h3>

<form action="" method="post" class="mb-4">

    <input type="hidden" name="id_offre" value="<?= htmlspecialchars((string)$idOffre) ?>">

    <!-- ===== COLONNE UNIQUE CENTRÉE ===== -->
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-6 col-xl-5">

            <select name="id_destination" class="form-control mb-2" required>
                <option value="">-- choisir une destination --</option>

                <?php foreach ($destinations as $d): ?>
                    <?php
                    $idDest = (int)($d["id_destination"] ?? 0);
                    $labelDest = trim((string)($d["pays"] ?? "") . " - " . (string)($d["ville"] ?? ""), " -");
                    $selected = ($isEdit && $idOffreDestination === $idDest) ? "selected" : "";
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
                min="0"
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

            <!-- ===== SWITCH ACTIF ===== -->
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
