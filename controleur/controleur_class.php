<?php
require_once("modele/modele_class.php");

class Controleur
{
    private $unModele;

    public function __construct()
    {
        $this->unModele = new Modele();
    }

    public function getModele()
    {
        return $this->unModele;
    }

    /* =========================
       SECURITE / SESSIONS
    ========================== */

    public function verifConnexion()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: index.php?page=home");
            exit();
        }
    }

    public function verifAdmin()
    {
        $this->verifConnexion();
        if (!isset($_SESSION['user']['role']) || $_SESSION['user']['role'] !== "admin") {
            header("Location: index.php?page=home");
            exit();
        }
    }

    /* =========================
       UTILISATEURS / AUTH
    ========================== */

    public function select_user_login($email)
    {
        return $this->unModele->select_user_login($email);
    }

    public function selectWhere_utilisateur_by_email($email)
    {
        return $this->unModele->selectWhere_utilisateur_by_email($email);
    }

    public function insert_utilisateur($tab)
    {
        $this->unModele->insert_utilisateur($tab);
    }

    public function inscription_complete($userTab, $clientTab)
    {
        return $this->unModele->inscription_complete($userTab, $clientTab);
    }

    /* =========================
       CLIENT
    ========================== */

    public function insert_client($tab)
    {
        $this->unModele->insert_client($tab);
    }

    public function selectWhere_client_by_user($id_utilisateur)
    {
        return $this->unModele->selectWhere_client_by_user($id_utilisateur);
    }

    /* =========================
       DESTINATIONS
    ========================== */

    public function insert_destination($tab)
    {
        $this->unModele->insert_destination($tab);
    }

    public function selectAll_destinations()
    {
        return $this->unModele->selectAll_destinations();
    }

    public function selectLike_destination($filtre)
    {
        return $this->unModele->selectLike_destination($filtre);
    }

    public function delete_destination($id_destination)
    {
        $this->unModele->delete_destination($id_destination);
    }

    public function update_destination($tab)
    {
        $this->unModele->update_destination($tab);
    }

    public function selectWhere_destination($id_destination)
    {
        return $this->unModele->selectWhere_destination($id_destination);
    }

    /* =========================
       OFFRES
    ========================== */

    public function insert_offre($tab)
    {
        $this->unModele->insert_offre($tab);
    }

    public function selectAll_offres()
    {
        return $this->unModele->selectAll_offres();
    }

    public function selectAll_offres_actives()
    {
        return $this->unModele->selectAll_offres_actives();
    }

    public function selectLike_offre($filtre)
    {
        return $this->unModele->selectLike_offre($filtre);
    }

    public function delete_offre($id_offre)
    {
        $this->unModele->delete_offre($id_offre);
    }

    public function update_offre($tab)
    {
        $this->unModele->update_offre($tab);
    }

    public function selectWhere_offre($id_offre)
    {
        return $this->unModele->selectWhere_offre($id_offre);
    }

    public function selectWhere_offre_active_by_destination($id_destination)
    {
        return $this->unModele->selectWhere_offre_active_by_destination($id_destination);
    }

    /* =========================
       RESERVATIONS
    ========================== */

    public function insert_reservation($tab)
    {
        $this->unModele->insert_reservation($tab);
    }

    public function selectAll_reservations()
    {
        return $this->unModele->selectAll_reservations();
    }

    public function selectWhere_reservations_by_client($id_client)
    {
        return $this->unModele->selectWhere_reservations_by_client($id_client);
    }

    public function update_reservation_statut($tab)
    {
        $this->unModele->update_reservation_statut($tab);
    }

    /* =========================
       SLIDES
    ========================== */

    public function insert_slide($tab)
    {
        $this->unModele->insert_slide($tab);
    }

    public function selectAll_slides()
    {
        return $this->unModele->selectAll_slides();
    }

    public function selectAll_slides_actifs()
    {
        return $this->unModele->selectAll_slides_actifs();
    }

    public function selectWhere_slide($id_slide)
    {
        return $this->unModele->selectWhere_slide($id_slide);
    }

    public function update_slide($tab)
    {
        $this->unModele->update_slide($tab);
    }

    public function delete_slide($id_slide)
    {
        $this->unModele->delete_slide($id_slide);
    }
}
?>
