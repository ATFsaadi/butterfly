<?php

require_once "modele/modele_class.php";

class Controleur
{
    private Modele $modele;

    public function __construct()
    {
        $this->modele = new Modele();
    }

    // accès au modèle

    public function getModele(): Modele
    {
        return $this->modele;
    }

    // sécurité et session

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

        if (!isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== "admin") {
            header("location: index.php?page=home");
            exit();
        }
    }

    public function estAdmin(): bool
    {
        return isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "admin";
    }

    public function getIdClientConnecte(): int
    {
        $this->verifConnexion();

        if (!isset($_SESSION["user"]["id_client"])) {
            header("location: index.php?page=home");
            exit();
        }

        return (int) $_SESSION["user"]["id_client"];
    }

    public function getIdUtilisateurConnecte(): int
    {
        $this->verifConnexion();

        if (!isset($_SESSION["user"]["id_utilisateur"])) {
            header("location: index.php?page=home");
            exit();
        }

        return (int) $_SESSION["user"]["id_utilisateur"];
    }

    // utilisateurs et connexion

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

    public function selectAll_clients_admin(): array
    {
        return $this->modele->selectAll_clients_admin();
    }

    public function selectLike_clients_admin(string $filtre): array
    {
        return $this->modele->selectLike_clients_admin($filtre);
    }

    public function selectWhere_client_admin(int $idUtilisateur)
    {
        return $this->modele->selectWhere_client_admin($idUtilisateur);
    }

    public function deleteClientByAdmin(int $idUtilisateur): void
    {
        $this->modele->deleteClientByAdmin($idUtilisateur);
    }

    public function setUtilisateurActif(int $idUtilisateur, int $actif): void
    {
        $this->modele->setUtilisateurActif($idUtilisateur, $actif);
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

    public function selectWhere_destination_by_pays_ville(string $pays, string $ville)
    {
        return $this->modele->selectWhere_destination_by_pays_ville($pays, $ville);
    }

    public function selectWhere_destination_by_pays_ville_except_id(
        string $pays,
        string $ville,
        int $id_destination
    ) {
        return $this->modele->selectWhere_destination_by_pays_ville_except_id(
            $pays,
            $ville,
            $id_destination
        );
    }

    public function update_destination(array $tab): void
    {
        $this->modele->update_destination($tab);
    }

    public function delete_destination(int $id_destination): void
    {
        $this->modele->delete_destination($id_destination);
    }

    public function set_destination_actif(int $id_destination, int $actif): void
    {
        $this->modele->set_destination_actif($id_destination, $actif);
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

    public function selectLike_offres_actives(string $filtre): array
    {
        return $this->modele->selectLike_offres_actives($filtre);
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

    public function set_offre_actif(int $id_offre, int $actif): void
    {
        $this->modele->set_offre_actif($id_offre, $actif);
    }

    // voyages

    public function insert_voyage(array $tab): void
    {
        $this->modele->insert_voyage($tab);
    }

    public function selectAll_voyages_admin()
    {
        return $this->modele->selectAll_voyages_admin();
    }

    public function selectAll_voyages_actifs()
    {
        return $this->modele->selectAll_voyages_actifs();
    }

    public function selectAll_voyages_actifs_by_destination(int $id_destination): array
    {
        return $this->modele->selectAll_voyages_actifs_by_destination($id_destination);
    }

    public function selectWhere_voyage(int $id_voyage)
    {
        return $this->modele->selectWhere_voyage($id_voyage);
    }

    public function update_voyage(array $tab): void
    {
        $this->modele->update_voyage($tab);
    }

    public function delete_voyage(int $id_voyage): void
    {
        $this->modele->delete_voyage($id_voyage);
    }

    public function set_voyage_statut(int $id_voyage, string $statut): void
    {
        $this->modele->set_voyage_statut($id_voyage, $statut);
    }

    public function maj_statut_voyage_si_complet(int $id_voyage): void
    {
        $this->modele->maj_statut_voyage_si_complet($id_voyage);
    }

    // réservations

    public function insert_reservation_destination(array $tab): void
    {
        $this->modele->insert_reservation_destination($tab);
    }

    public function insert_reservation_voyage(array $tab): void
    {
        $this->modele->insert_reservation_voyage($tab);
    }

    public function reserver_destination(array $tab): bool
    {
        return $this->modele->reserver_destination($tab);
    }

    public function reserver_voyage(array $tab): bool
    {
        return $this->modele->reserver_voyage($tab);
    }

    public function selectAll_reservations_destinations()
    {
        return $this->modele->selectAll_reservations_destinations();
    }

    public function selectAll_reservations_voyages()
    {
        return $this->modele->selectAll_reservations_voyages();
    }

    public function selectAll_reservations()
    {
        return $this->modele->selectAll_reservations_union();
    }

    public function selectWhere_reservations_destinations_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_destinations_by_client($id_client);
    }

    public function selectWhere_reservations_voyages_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_voyages_by_client($id_client);
    }

    public function selectWhere_reservations_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_by_client_union($id_client);
    }

    public function selectMesReservations(): array
    {
        $idClient = $this->getIdClientConnecte();

        return [
            "destinations" => $this->modele->selectWhere_reservations_destinations_by_client($idClient),
            "voyages" => $this->modele->selectWhere_reservations_voyages_by_client($idClient),
        ];
    }

    public function update_reservation_destination_statut(array $tab): void
    {
        $this->modele->update_reservation_destination_statut($tab);
    }

    public function update_reservation_voyage_statut(array $tab): void
    {
        $this->modele->update_reservation_voyage_statut($tab);
    }

    public function select_id_voyage_by_reservation_voyage(int $id_reservation_voyage): int
    {
        return $this->modele->select_id_voyage_by_reservation_voyage($id_reservation_voyage);
    }

    public function selectReservationsDestinationsByUtilisateur(int $idUtilisateur): array
    {
        return $this->modele->selectReservationsDestinationsByUtilisateur($idUtilisateur);
    }

    public function selectReservationsVoyagesByUtilisateur(int $idUtilisateur): array
    {
        return $this->modele->selectReservationsVoyagesByUtilisateur($idUtilisateur);
    }

    // profil client

    public function getProfilClient(int $idUtilisateur)
    {
        return $this->modele->getProfilClient($idUtilisateur);
    }

    public function getProfilUtilisateur(int $idUtilisateur)
    {
        return $this->modele->getProfilUtilisateur($idUtilisateur);
    }

    public function emailExistePourAutreUtilisateur(string $email, int $idUtilisateur)
    {
        return $this->modele->emailExistePourAutreUtilisateur($email, $idUtilisateur);
    }

    public function updateProfilClient(array $tab): void
    {
        $this->modele->updateProfilClient($tab);
    }

    public function updateProfilUtilisateur(array $tab): void
    {
        $this->modele->updateProfilUtilisateur($tab);
    }

    public function selectMotDePasseUtilisateur(int $idUtilisateur)
    {
        return $this->modele->selectMotDePasseUtilisateur($idUtilisateur);
    }

    public function updateMotDePasseUtilisateur(int $idUtilisateur, string $hash): void
    {
        $this->modele->updateMotDePasseUtilisateur($idUtilisateur, $hash);
    }

    // dashboard admin

    public function getStatsDashboardAdmin(): array
    {
        return $this->modele->getStatsDashboardAdmin();
    }
}
