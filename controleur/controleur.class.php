<?php

require_once __DIR__ . '/../modele/modele.class.php';

class Controleur {

    /* constructeur */
    private $unModele;

    public function __construct() {
        $this->unModele = new Modele();
    }

    /* utilisateurs */

    public function select_user($email) {
        return $this->unModele->select_user($email);
    }

    public function addUser($nom, $prenom, $email, $mdp, $telephone = null, $role = 'client') {
        return $this->unModele->addUser($nom, $prenom, $email, $mdp, $telephone, $role);
    }

    public function getAllUsers() {
        return $this->unModele->getAllUsers();
    }

    /* securite */

    public function verifConnexion() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=home');
            exit();
        }
    }

    public function verifAdmin() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=home');
            exit();
        }
    }

    /* slides */

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

    /* continents */

    public function getAllContinents() {
        return $this->unModele->selectAllContinents();
    }

    public function getContinentById($id) {
        return $this->unModele->selectContinentById((int)$id);
    }

    /* destinations */

    public function addDestination($tab) {
        $this->unModele->insertDestination($tab);
    }

    public function getAllDestinations() {
        return $this->unModele->selectAllDestinations();
    }

    public function getDestinationById($id) {
        return $this->unModele->selectDestinationById((int)$id);
    }

    public function updateDestination($tab) {
        $this->unModele->updateDestination($tab);
    }

    public function deleteDestination($id) {
        $this->unModele->deleteDestination((int)$id);
    }

    public function getDestinationsByContinent($id_continent) {
        return $this->unModele->selectDestinationsByContinent((int)$id_continent);
    }

    /* voyages */

    public function getAllVoyages() {
        return $this->unModele->selectAllVoyages();
    }

    public function getVoyageById($id) {
        return $this->unModele->selectVoyageById((int)$id);
    }

    public function addVoyage($tab) {
        $this->unModele->insertVoyage($tab);
    }

    public function updateVoyage($tab) {
        $this->unModele->updateVoyage($tab);
    }

    public function deleteVoyage($id) {
        $this->unModele->deleteVoyage((int)$id);
    }

    /* offres */

    public function getAllOffres() {
        return $this->unModele->selectAllOffres();
    }

    public function getOffreById($id) {
        return $this->unModele->selectOffreById((int)$id);
    }

    public function addOffre($tab) {
        $this->unModele->insertOffre($tab);
    }

    public function updateOffre($tab) {
        $this->unModele->updateOffre($tab);
    }

    public function deleteOffre($id) {
        $this->unModele->deleteOffre((int)$id);
    }

    public function getOffresActives() {
        return $this->unModele->selectOffresActives();
    }

}
