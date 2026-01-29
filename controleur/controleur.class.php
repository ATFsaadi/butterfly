<?php
require_once __DIR__ . '/../modele/modele.class.php';

class Controleur
{
    private $unModele;
    public function __construct()
    {
        $this->unModele = new Modele();
    }

    /* utilisateurs */
    /* recuperer un utilisateur par email */
    public function select_user($email)
    {
        return $this->unModele->select_user($email);
    }

    /* ajouter un utilisateur */
    public function addUser($nom, $prenom, $email, $mdp, $telephone = null, $role = 'client')
    {
        return $this->unModele->addUser($nom, $prenom, $email, $mdp, $telephone, $role);
    }

    /* recuperer tous les utilisateurs */
    public function getAllUsers()
    {
        return $this->unModele->getAllUsers();
    }

    /* securite */
    /* verifier si un utilisateur est connecte */
    public function verifConnexion()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=home');
            exit();
        }
    }

    /* verifier si l'utilisateur est admin */
    public function verifAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: index.php?page=home');
            exit();
        }
    }

    /* slides */
    /* ajouter un slide */
    public function addSlide($tab)
    {
        $this->unModele->insertSlide($tab);
    }

    /* recuperer tous les slides */
    public function getAllSlides()
    {
        return $this->unModele->selectAllSlides();
    }

    /* recuperer un slide par id */
    public function getSlideById($id_slide)
    {
        return $this->unModele->selectSlideById($id_slide);
    }

    /* modifier un slide */
    public function updateSlide($tab)
    {
        $this->unModele->updateSlide($tab);
    }

    /* supprimer un slide */
    public function deleteSlide($id_slide)
    {
        $this->unModele->deleteSlide($id_slide);
    }

    /* recuperer les slides actifs */
    public function getSlidesActifs()
    {
        return $this->unModele->selectSlidesActifs();
    }

    /* continents */
    /* recuperer tous les continents */
    public function getAllContinents()
    {
        return $this->unModele->selectAllContinents();
    }

    /* recuperer un continent par id */
    public function getContinentById($id)
    {
        return $this->unModele->selectContinentById((int) $id);
    }

    /* destinations */
    /* ajouter une destination */
    public function addDestination($tab)
    {
        $this->unModele->insertDestination($tab);
    }

    /* recuperer toutes les destinations */
    public function getAllDestinations()
    {
        return $this->unModele->selectAllDestinations();
    }

    /* recuperer une destination par id */
    public function getDestinationById($id)
    {
        return $this->unModele->selectDestinationById((int) $id);
    }

    /* modifier une destination */
    public function updateDestination($tab)
    {
        $this->unModele->updateDestination($tab);
    }

    /* supprimer une destination */
    public function deleteDestination($id)
    {
        $this->unModele->deleteDestination((int) $id);
    }

    /* recuperer les destinations par continent */
    public function getDestinationsByContinent($id_continent)
    {
        return $this->unModele->selectDestinationsByContinent((int) $id_continent);
    }

    /* voyages */
    /* recuperer tous les voyages */
    public function getAllVoyages()
    {
        return $this->unModele->selectAllVoyages();
    }

    /* recuperer un voyage par id */
    public function getVoyageById($id)
    {
        return $this->unModele->selectVoyageById((int) $id);
    }

    /* ajouter un voyage */
    public function addVoyage($tab)
    {
        $this->unModele->insertVoyage($tab);
    }

    /* modifier un voyage */
    public function updateVoyage($tab)
    {
        $this->unModele->updateVoyage($tab);
    }

    /* supprimer un voyage */
    public function deleteVoyage($id)
    {
        $this->unModele->deleteVoyage((int) $id);
    }

    /* offres */
    /* recuperer toutes les offres */
    public function getAllOffres()
    {
        return $this->unModele->selectAllOffres();
    }

    /* recuperer une offre par id */
    public function getOffreById($id)
    {
        return $this->unModele->selectOffreById((int) $id);
    }

    /* ajouter une offre */
    public function addOffre($tab)
    {
        $this->unModele->insertOffre($tab);
    }

    /* modifier une offre */
    public function updateOffre($tab)
    {
        $this->unModele->updateOffre($tab);
    }

    /* supprimer une offre */
    public function deleteOffre($id)
    {
        $this->unModele->deleteOffre((int) $id);
    }

    /* recuperer les offres actives */
    public function getOffresActives()
    {
        return $this->unModele->selectOffresActives();
    }

    /* reservations */
    /* ajouter une reservation */
    public function addReservation($tab)
    {
        return $this->unModele->addReservation($tab);
    }

    /* recuperer les reservations d'un utilisateur */
    public function getReservationsByUser(int $id_utilisateur): array
    {
        return $this->unModele->selectReservationsByUser($id_utilisateur);
    }

    /* recuperer une reservation par id */
    public function getReservationById(int $id_reservation)
    {
        return $this->unModele->selectReservationById($id_reservation);
    }

    /* recuperer toutes les reservations */
    public function getAllReservations(): array
    {
        return $this->unModele->selectAllReservations();
    }

    /* confirmer une reservation */
    public function confirmReservation(int $id): bool
    {
        return $this->unModele->confirmReservation($id);
    }

    /* marquer une reservation comme payee */
    public function markReservationPaid(int $id): bool
    {
        return $this->unModele->markReservationPaid($id);
    }

    /* compter les reservations en attente */
    public function countReservationsEnAttente(): int
    {
        return $this->unModele->countReservationsEnAttente();
    }
}
