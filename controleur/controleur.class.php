<?php
require_once __DIR__ . '/../modele/modele.class.php';

class Controleur {
    private $unModele;

    public function __construct() {
        $this->unModele = new Modele();
    }

    /* ================= UTILISATEURS ================= */

    public function select_user($email) {
        return $this->unModele->select_user($email);
    }

    public function addUser($nom, $prenom, $email, $mdp, $telephone = null, $role = 'client') {
        return $this->unModele->addUser($nom, $prenom, $email, $mdp, $telephone, $role);
    }

    public function getAllUsers() {
        return $this->unModele->getAllUsers();
    }

    /* ================= SÉCURITÉ ================= */

    public function verifConnexion() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=home');
            exit();
        }
    }

    public function verifAdmin() {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=home');
            exit();
        }
    }

        /* ===================== */
    /* ====== SLIDES ======= */
    /* ===================== */

    public function addSlide($tab) {
        $this->unModele->insertSlide($tab);
    }

    public function getAllSlides() {
        return $this->unModele->selectAllSlides();
    }

    public function getSlideById($id_slide) {
        return $this->unModele->selectSlideById($id_slide);
    }

    public function updateSlide($tab) {
        $this->unModele->updateSlide($tab);
    }

    public function deleteSlide($id_slide) {
        $this->unModele->deleteSlide($id_slide);
    }

    public function getSlidesActifs() {
        return $this->unModele->selectSlidesActifs();
    }
    /* ========================= */
/* ===== DESTINATIONS ===== */
/* ========================= */

public function addDestination($tab) {
    $this->unModele->insertDestination($tab);
}

public function getAllDestinations() {
    return $this->unModele->selectAllDestinations();
}

public function getDestinationById($id) {
    return $this->unModele->selectDestinationById($id);
}

public function updateDestination($tab) {
    $this->unModele->updateDestination($tab);
}

public function deleteDestination($id) {
    $this->unModele->deleteDestination($id);
}


}
