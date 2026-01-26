<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/controleur.class.php';

$unControleur = new Controleur();

// Sécurité admin
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header('Location: index.php?page=home');
    exit();
}

$uploadDir = __DIR__ . '/../images/voyages/';
if (!is_dir($uploadDir)) {
    @mkdir($uploadDir, 0777, true);
}

$errors = [];

/* ===== AJOUT / MODIFICATION ===== */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $id = !empty($_POST['id_voyage']) ? (int)$_POST['id_voyage'] : null;

    $titre = trim($_POST['titre'] ?? '');

    // ✅ NOUVEAUX PRIX
    $prix_adulte = isset($_POST['prix_adulte']) ? (float)$_POST['prix_adulte'] : 0;
    $prix_enfant = isset($_POST['prix_enfant']) ? (float)$_POST['prix_enfant'] : 0;
    $prix_bebe   = isset($_POST['prix_bebe']) ? (float)$_POST['prix_bebe'] : 0;

    $date_depart = trim($_POST['date_depart'] ?? '');
    $date_retour = trim($_POST['date_retour'] ?? '');
    $description = trim($_POST['description'] ?? '');

    $id_destination = isset($_POST['id_destination']) && $_POST['id_destination'] !== ''
        ? (int)$_POST['id_destination']
        : null;

    $imageName = $_POST['existing_image'] ?? null;

    // Validations
    if ($titre === '') $errors[] = "Le titre est obligatoire.";
    if ($prix_adulte <= 0) $errors[] = "Le prix adulte doit être supérieur à 0.";
    if ($prix_enfant < 0) $errors[] = "Le prix enfant ne peut pas être négatif.";
    if ($prix_bebe < 0) $errors[] = "Le prix bébé ne peut pas être négatif.";
    if ($date_depart === '') $errors[] = "La date de départ est obligatoire.";
    if ($date_retour === '') $errors[] = "La date de retour est obligatoire.";
    if ($id_destination === null) $errors[] = "La destination est obligatoire.";

    // Upload image si présente
    if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowedExt = ['jpg','jpeg','png','gif','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt, true)) {
            $errors[] = "Format image invalide.";
        } else {
            $imageName = uniqid('voy_') . '.' . $ext;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $imageName)) {
                $errors[] = "Erreur lors de l'upload de l'image.";
            } else {
                // supprime ancienne image
                if (!empty($_POST['existing_image'])) {
                    $old = basename((string)$_POST['existing_image']);
                    @unlink($uploadDir . $old);
                }
            }
        }
    }

    if (empty($errors)) {

        // ✅ IMPORTANT : on envoie les 3 prix
        $data = [
            'titre' => $titre,
            'prix_adulte' => $prix_adulte,
            'prix_enfant' => $prix_enfant,
            'prix_bebe' => $prix_bebe,
            'date_depart' => $date_depart,
            'date_retour' => $date_retour,
            'description' => $description,
            'image' => $imageName,
            'id_destination' => $id_destination
        ];

        if ($id) {
            $data['id_voyage'] = $id;
            $unControleur->updateVoyage($data);
        } else {
            $unControleur->addVoyage($data);
        }

        header('Location: index.php?page=admin_voyages');
        exit();
    }
}

/* ===== SUPPRESSION ===== */
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $voy = $unControleur->getVoyageById($id);

    if ($voy && !empty($voy['image'])) {
        @unlink($uploadDir . basename((string)$voy['image']));
    }

    $unControleur->deleteVoyage($id);
    header('Location: index.php?page=admin_voyages');
    exit();
}

/* ===== RÉCUPÉRATION ===== */
$voyages = $unControleur->getAllVoyages();
$voyageToEdit = isset($_GET['edit']) ? $unControleur->getVoyageById((int)$_GET['edit']) : null;

// dropdown destinations
$destinations = $unControleur->getAllDestinations();
