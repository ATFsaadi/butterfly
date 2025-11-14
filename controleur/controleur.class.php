<?php
require_once("modele/modele.class.php");

class Controleur {
    private $unModele;

    public function __construct() {
        $this->unModele = new Modele();
    }

    public function verifConnexion() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit();
        }
    }

    // --- Utilisateurs ---
    public function getUserByEmail($email) {
        return $this->unModele->getUserByEmail($email);
    }

    public function addUser($nom, $prenom, $email, $mot_de_passe, $telephone = null, $role = 'client') {
        return $this->unModele->addUser($nom, $prenom, $email, $mot_de_passe, $telephone, $role);
    }

    // --- Voyages ---
    public function getTypesVoyage() {
        return $this->unModele->getTypesVoyage();
    }

    public function getDestinations() {
        return $this->unModele->getDestinations();
    }

    public function getVillesDepart() {
        return $this->unModele->getVillesDepart();
    }

    public function rechercherVoyages($type = null, $destination = null, $villeDepart = null, $date = null, $duree = null) {
        return $this->unModele->rechercherVoyages($type, $destination, $villeDepart, $date, $duree);
    }
}
?>
