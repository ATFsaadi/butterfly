<?php

require_once "modele/modele_class.php";

class Controleur
{
    private Modele $modele;

    public function __construct()
    {
        $this->modele = new Modele();
    }

    public function getModele(): Modele
    {
        return $this->modele;
    }

    // securite et sessions

    public function verifConnexion(): void
    {
        if (!isset($_SESSION["user"])) {
            header("location: index.php?page=home");
            exit();
        }
    }

    public function verifAdmin(): void
    {
        $this->verifConnexion();

        if (
            !isset($_SESSION["user"]["role"]) ||
            $_SESSION["user"]["role"] !== "admin"
        ) {
            header("location: index.php?page=home");
            exit();
        }
    }

    // utilisateurs et authentification

    public function select_user_login(string $email)
    {
        return $this->modele->select_user_login($email);
    }

    public function selectWhere_utilisateur_by_email(string $email)
    {
        return $this->modele->selectWhere_utilisateur_by_email($email);
    }

    public function insert_utilisateur(array $tab): void
    {
        $this->modele->insert_utilisateur($tab);
    }

    public function inscription_complete(array $userTab, array $clientTab)
    {
        return $this->modele->inscription_complete($userTab, $clientTab);
    }

    // clients

    public function insert_client(array $tab): void
    {
        $this->modele->insert_client($tab);
    }

    public function selectWhere_client_by_user(int $id_utilisateur)
    {
        return $this->modele->selectWhere_client_by_user($id_utilisateur);
    }

    // continents

    public function selectAll_continents()
    {
        return $this->modele->selectAll_continents();
    }

    public function selectWhere_continent(int $id_continent)
    {
        return $this->modele->selectWhere_continent($id_continent);
    }

    // destinations

    public function insert_destination(array $tab): void
    {
        $this->modele->insert_destination($tab);
    }

    public function selectAll_destinations()
    {
        return $this->modele->selectAll_destinations();
    }

    public function selectAll_destinations_admin()
    {
        return $this->modele->selectAll_destinations_admin();
    }

    public function selectLike_destination(string $filtre)
    {
        return $this->modele->selectLike_destination($filtre);
    }

    public function selectWhere_destination(int $id_destination)
    {
        return $this->modele->selectWhere_destination($id_destination);
    }

    public function update_destination(array $tab): void
    {
        $this->modele->update_destination($tab);
    }

    public function delete_destination(int $id_destination): void
    {
        $this->modele->delete_destination($id_destination);
    }

    // offres

    public function insert_offre(array $tab): void
    {
        $this->modele->insert_offre($tab);
    }

    public function selectAll_offres()
    {
        return $this->modele->selectAll_offres();
    }

    public function selectAll_offres_actives()
    {
        return $this->modele->selectAll_offres_actives();
    }

    public function selectLike_offre(string $filtre)
    {
        return $this->modele->selectLike_offre($filtre);
    }

    public function selectWhere_offre(int $id_offre)
    {
        return $this->modele->selectWhere_offre($id_offre);
    }

    public function selectWhere_offre_active_by_destination(int $id_destination)
    {
        return $this->modele->selectWhere_offre_active_by_destination($id_destination);
    }

    public function update_offre(array $tab): void
    {
        $this->modele->update_offre($tab);
    }

    public function delete_offre(int $id_offre): void
    {
        $this->modele->delete_offre($id_offre);
    }

    // reservations

    public function insert_reservation(array $tab): void
    {
        $this->modele->insert_reservation($tab);
    }

    public function selectAll_reservations()
    {
        return $this->modele->selectAll_reservations();
    }

    public function selectWhere_reservations_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_by_client($id_client);
    }

    public function update_reservation_statut(array $tab): void
    {
        $this->modele->update_reservation_statut($tab);
    }

    // slides

    public function insert_slide(array $tab): void
    {
        $this->modele->insert_slide($tab);
    }

    public function selectAll_slides()
    {
        return $this->modele->selectAll_slides();
    }

    public function selectAll_slides_actifs()
    {
        return $this->modele->selectAll_slides_actifs();
    }

    public function selectWhere_slide(int $id_slide)
    {
        return $this->modele->selectWhere_slide($id_slide);
    }

    public function update_slide(array $tab): void
    {
        $this->modele->update_slide($tab);
    }

    public function delete_slide(int $id_slide): void
    {
        $this->modele->delete_slide($id_slide);
    }
}
