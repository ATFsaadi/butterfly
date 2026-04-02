<?php

require_once "modele/modele_class.php";

class Controleur
{
    private Modele $modele;

    public function __construct()
    {
        // crée le modèle pour pouvoir appeler les requêtes sql
        $this->modele = new Modele();
    }

    // permet de récupérer l'objet modèle si besoin ailleurs
    public function getModele(): Modele
    {
        return $this->modele;
    }

    // vérifie que l'utilisateur est connecté, sinon redirection vers home
    public function verifConnexion(): void
    {
        if (!isset($_SESSION["user"])) {
            header("location: index.php?page=home");
            exit();
        }
    }

    // vérifie que l'utilisateur est admin, sinon redirection vers home
    public function verifAdmin(): void
    {
        $this->verifConnexion();

        if (!isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== "admin") {
            header("location: index.php?page=home");
            exit();
        }
    }

    // récupère l'id client de l'utilisateur connecté (sinon redirection)
    public function getIdClientConnecte(): int
    {
        $this->verifConnexion();

        if (!isset($_SESSION["user"]["id_client"])) {
            header("location: index.php?page=home");
            exit();
        }

        return (int) $_SESSION["user"]["id_client"];
    }

    // récupère l'id utilisateur de l'utilisateur connecté (sinon redirection)
    public function getIdUtilisateurConnecte(): int
    {
        $this->verifConnexion();

        if (!isset($_SESSION["user"]["id_utilisateur"])) {
            header("location: index.php?page=home");
            exit();
        }

        return (int) $_SESSION["user"]["id_utilisateur"];
    }

    // renvoie vrai si l'utilisateur connecté est admin
    public function estAdmin(): bool
    {
        return isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "admin";
    }

    /* __ utilisateurs / client __ */

    // envoie l'email au modèle pour récupérer l'utilisateur actif (connexion)
    public function select_user_login(string $email)
    {
        return $this->modele->select_user_login($email);
    }

    // récupère un utilisateur par email (utile inscription / vérif doublon)
    public function selectWhere_utilisateur_by_email(string $email)
    {
        return $this->modele->selectWhere_utilisateur_by_email($email);
    }

    // crée un utilisateur dans la base
    public function insert_utilisateur(array $tab): void
    {
        $this->modele->insert_utilisateur($tab);
    }

    // inscription complète : crée utilisateur + client (transaction dans le modèle)
    public function inscription_complete(array $userTab, array $clientTab)
    {
        return $this->modele->inscription_complete($userTab, $clientTab);
    }

    // crée une fiche client dans la base
    public function insert_client(array $tab): void
    {
        $this->modele->insert_client($tab);
    }

    // récupère la fiche client à partir de l'id utilisateur
    public function selectWhere_client_by_user(int $id_utilisateur)
    {
        return $this->modele->selectWhere_client_by_user($id_utilisateur);
    }

    /* __ continents / destinations __ */

    // récupère la liste des continents
    public function selectAll_continents()
    {
        return $this->modele->selectAll_continents();
    }

    // récupère un continent par id
    public function selectWhere_continent(int $id_continent)
    {
        return $this->modele->selectWhere_continent($id_continent);
    }

    // ajoute une destination
    public function insert_destination(array $tab): void
    {
        $this->modele->insert_destination($tab);
    }

    // liste les destinations actives
    public function selectAll_destinations()
    {
        return $this->modele->selectAll_destinations();
    }

    // liste toutes les destinations (admin)
    public function selectAll_destinations_admin()
    {
        return $this->modele->selectAll_destinations_admin();
    }

    // recherche une destination active via filtre (pays/ville/continent)
    public function selectLike_destination(string $filtre)
    {
        return $this->modele->selectLike_destination($filtre);
    }

    // récupère une destination par id
    public function selectWhere_destination(int $id_destination)
    {
        return $this->modele->selectWhere_destination($id_destination);
    }

    // vérifie si une destination existe déjà avec le même pays et la même ville
    public function selectWhere_destination_by_pays_ville(string $pays, string $ville)
    {
        return $this->modele->selectWhere_destination_by_pays_ville($pays, $ville);
    }

    // vérifie si une destination existe déjà avec le même pays et la même ville
    // sauf pour l'id en cours de modification
    public function selectWhere_destination_by_pays_ville_except_id(string $pays, string $ville, int $id_destination)
    {
        return $this->modele->selectWhere_destination_by_pays_ville_except_id($pays, $ville, $id_destination);
    }

    // modifie une destination
    public function update_destination(array $tab): void
    {
        $this->modele->update_destination($tab);
    }

    // désactive une destination (suppression logique)
    public function delete_destination(int $id_destination): void
    {
        $this->modele->delete_destination($id_destination);
    }

    // active ou désactive une destination
    public function set_destination_actif(int $id_destination, int $actif): void
    {
        $this->modele->set_destination_actif($id_destination, $actif);
    }

    /* __ offres __ */

    // crée une offre promo
    public function insert_offre(array $tab): void
    {
        $this->modele->insert_offre($tab);
    }

    // liste toutes les offres (admin)
    public function selectAll_offres()
    {
        return $this->modele->selectAll_offres();
    }

    // liste les offres actives du moment (côté client)
    public function selectAll_offres_actives()
    {
        return $this->modele->selectAll_offres_actives();
    }

    // recherche parmi toutes les offres
    public function selectLike_offre(string $filtre)
    {
        return $this->modele->selectLike_offre($filtre);
    }

    // recherche parmi les offres actives du moment
    public function selectLike_offres_actives(string $filtre): array
    {
        return $this->modele->selectLike_offres_actives($filtre);
    }

    // récupère une offre précise par id
    public function selectWhere_offre(int $id_offre)
    {
        return $this->modele->selectWhere_offre($id_offre);
    }

    // récupère l'offre active d'une destination (si elle existe)
    public function selectWhere_offre_active_by_destination(int $id_destination)
    {
        return $this->modele->selectWhere_offre_active_by_destination($id_destination);
    }

    // modifie une offre
    public function update_offre(array $tab): void
    {
        $this->modele->update_offre($tab);
    }

    // désactive une offre (suppression logique)
    public function delete_offre(int $id_offre): void
    {
        $this->modele->delete_offre($id_offre);
    }

    // active ou désactive une offre
    public function set_offre_actif(int $id_offre, int $actif): void
    {
        $this->modele->set_offre_actif($id_offre, $actif);
    }

    /* __ voyages __ */

    // crée un voyage organisé
    public function insert_voyage(array $tab): void
    {
        $this->modele->insert_voyage($tab);
    }

    // liste tous les voyages (admin)
    public function selectAll_voyages_admin()
    {
        return $this->modele->selectAll_voyages_admin();
    }

    // liste les voyages au statut actif (côté client)
    public function selectAll_voyages_actifs()
    {
        return $this->modele->selectAll_voyages_actifs();
    }

    // récupère un voyage précis par id
    public function selectWhere_voyage(int $id_voyage)
    {
        return $this->modele->selectWhere_voyage($id_voyage);
    }

    // modifie un voyage
    public function update_voyage(array $tab): void
    {
        $this->modele->update_voyage($tab);
    }

    // supprime un voyage (suppression réelle)
    public function delete_voyage(int $id_voyage): void
    {
        $this->modele->delete_voyage($id_voyage);
    }

    // liste les voyages actifs d'une destination
    public function selectAll_voyages_actifs_by_destination(int $id_destination): array
    {
        return $this->modele->selectAll_voyages_actifs_by_destination($id_destination);
    }

    // change le statut d'un voyage (actif/complet/annule)
    public function set_voyage_statut(int $id_voyage, string $statut): void
    {
        $this->modele->set_voyage_statut($id_voyage, $statut);
    }

    /* __ reservations (nouvelle bdd) __ */

    // ajoute une réservation destination
    public function insert_reservation_destination(array $tab): void
    {
        $this->modele->insert_reservation_destination($tab);
    }

    // ajoute une réservation voyage
    public function insert_reservation_voyage(array $tab): void
    {
        $this->modele->insert_reservation_voyage($tab);
    }

    // réserve un voyage (transaction dans le modèle : places - réservation)
    public function reserver_voyage(array $tab): bool
    {
        return $this->modele->reserver_voyage($tab);
    }

    // réserve une destination (transaction dans le modèle)
    public function reserver_destination(array $tab): bool
    {
        return $this->modele->reserver_destination($tab);
    }

    // liste toutes les réservations destinations (admin)
    public function selectAll_reservations_destinations()
    {
        return $this->modele->selectAll_reservations_destinations();
    }

    // liste toutes les réservations voyages (admin)
    public function selectAll_reservations_voyages()
    {
        return $this->modele->selectAll_reservations_voyages();
    }

    // récupère les réservations destinations d'un client
    public function selectWhere_reservations_destinations_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_destinations_by_client($id_client);
    }

    // récupère les réservations voyages d'un client
    public function selectWhere_reservations_voyages_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_voyages_by_client($id_client);
    }

    // récupère les réservations de l'utilisateur connecté (destinations + voyages)
    public function selectMesReservations(): array
    {
        $idClient = $this->getIdClientConnecte();

        return [
            "destinations" => $this->modele->selectWhere_reservations_destinations_by_client($idClient),
            "voyages" => $this->modele->selectWhere_reservations_voyages_by_client($idClient),
        ];
    }

    // modifie le statut d'une réservation destination
    public function update_reservation_destination_statut(array $tab): void
    {
        $this->modele->update_reservation_destination_statut($tab);
    }

    // modifie le statut d'une réservation voyage
    public function update_reservation_voyage_statut(array $tab): void
    {
        $this->modele->update_reservation_voyage_statut($tab);
    }

    // liste toutes les réservations (union destinations + voyages)
    public function selectAll_reservations()
    {
        return $this->modele->selectAll_reservations_union();
    }

    // récupère toutes les réservations d'un client (union destinations + voyages)
    public function selectWhere_reservations_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_by_client_union($id_client);
    }

    // récupère l'id voyage à partir d'une réservation voyage
    public function select_id_voyage_by_reservation_voyage(int $id_reservation_voyage): int
    {
        return $this->modele->select_id_voyage_by_reservation_voyage($id_reservation_voyage);
    }

    // met un voyage en complet si il n'y a plus de places
    public function maj_statut_voyage_si_complet(int $id_voyage): void
    {
        $this->modele->maj_statut_voyage_si_complet($id_voyage);
    }
}