<?php
// Sécurité admin (si pas déjà faite dans index.php)
$unControleur->verifAdmin();

$offre = null;

/* =========================
   ACTIONS GET (sup / edit)
========================= */
if (isset($_GET['action'], $_GET['id_offre'])) {
    $action = $_GET['action'];
    $id_offre = (int) $_GET['id_offre'];

    switch ($action) {
        case "sup":
            $unControleur->delete_offre($id_offre);
            header("Location: index.php?page=admin_offres");
            exit();

        case "edit":
            $offre = $unControleur->selectWhere_offre($id_offre);
            break;
    }
}

/* =========================
   DONNEES POUR SELECT (liste destinations)
========================= */
$destinations = $unControleur->selectAll_destinations();

/* =========================
   ACTIONS POST (Valider / Modifier / Filtrer)
========================= */

// ajout
if (isset($_POST['Valider'])) {
    $unControleur->insert_offre($_POST);
    echo '<div style="text-align:center; color:green; font-weight:bold;">&#10004; Offre ajoutée.</div>';
}

// modification
if (isset($_POST['Modifier'])) {
    $unControleur->update_offre($_POST);
    header("Location: index.php?page=admin_offres");
    exit();
}

// filtrage
if (isset($_POST['Filtrer'])) {
    $filtre = $_POST['filtre'] ?? '';
    $lesOffres = $unControleur->selectLike_offre($filtre);
} else {
    $lesOffres = $unControleur->selectAll_offres();
}

/* =========================
   CHARGEMENT DES VUES
========================= */
require_once("vue/vue_insert_offre.php");
require_once("vue/vue_select_offres.php");
?>
