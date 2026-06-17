<?php

require_once "modele/modele_class.php";

// Controleur : relie les pages au modele et centralise les appels.

class Controleur
{
    private Modele $modele;

    // Initialise le modele utilise par le controleur.
    public function __construct()
    {
        $this->modele = new Modele();
    }

    // accès au modèle

    // Retourne directement l'objet modele.
    public function getModele(): Modele
    {
        return $this->modele;
    }

    // sécurité et session

    // Verifie qu'un utilisateur est connecte.
    public function verifConnexion(): void
    {
        if (!isset($_SESSION["user"])) {
            header("location: index.php?page=home");
            exit();
        }
    }

    // Verifie que l'utilisateur connecte est admin.
    public function verifAdmin(): void
    {
        $this->verifConnexion();

        if (!isset($_SESSION["user"]["role"]) || $_SESSION["user"]["role"] !== "admin") {
            header("location: index.php?page=home");
            exit();
        }
    }

    // Indique si l'utilisateur courant est administrateur.
    public function estAdmin(): bool
    {
        return isset($_SESSION["user"]["role"]) && $_SESSION["user"]["role"] === "admin";
    }

    // Recupere l'id du client connecte.
    public function getIdClientConnecte(): int
    {
        $this->verifConnexion();

        if (!isset($_SESSION["user"]["id_client"])) {
            header("location: index.php?page=home");
            exit();
        }

        return (int) $_SESSION["user"]["id_client"];
    }

    // Recupere l'id utilisateur de la session.
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

    // Recherche un utilisateur actif par email pour la connexion.
    public function select_user_login(string $email)
    {
        return $this->modele->select_user_login($email);
    }

    // Recherche un utilisateur par email.
    public function selectWhere_utilisateur_by_email(string $email)
    {
        return $this->modele->selectWhere_utilisateur_by_email($email);
    }

    // Cree un utilisateur.
    public function insert_utilisateur(array $tab): void
    {
        $this->modele->insert_utilisateur($tab);
    }

    // Cree le compte utilisateur et la fiche client.
    public function inscription_complete(array $userTab, array $clientTab)
    {
        return $this->modele->inscription_complete($userTab, $clientTab);
    }

    // clients

    // Ajoute une fiche client.
    public function insert_client(array $tab): void
    {
        $this->modele->insert_client($tab);
    }

    // Recupere le client lie a un utilisateur.
    public function selectWhere_client_by_user(int $id_utilisateur)
    {
        return $this->modele->selectWhere_client_by_user($id_utilisateur);
    }

    // Liste tous les clients pour l'administration.
    public function selectAll_clients_admin(): array
    {
        return $this->modele->selectAll_clients_admin();
    }

    // Recherche des clients pour l'administration.
    public function selectLike_clients_admin(string $filtre): array
    {
        return $this->modele->selectLike_clients_admin($filtre);
    }

    // Charge le detail d'un client pour l'administration.
    public function selectWhere_client_admin(int $idUtilisateur)
    {
        return $this->modele->selectWhere_client_admin($idUtilisateur);
    }

    // Supprime un compte client depuis l'administration.
    public function deleteClientByAdmin(int $idUtilisateur): void
    {
        $this->modele->deleteClientByAdmin($idUtilisateur);
    }

    // Active ou desactive un utilisateur.
    public function setUtilisateurActif(int $idUtilisateur, int $actif): void
    {
        $this->modele->setUtilisateurActif($idUtilisateur, $actif);
    }

    // continents

    // Liste tous les continents.
    public function selectAll_continents()
    {
        return $this->modele->selectAll_continents();
    }

    // Recupere un continent par son id.
    public function selectWhere_continent(int $id_continent)
    {
        return $this->modele->selectWhere_continent($id_continent);
    }

    // destinations

    // Ajoute une destination.
    public function insert_destination(array $tab): void
    {
        $this->modele->insert_destination($tab);
    }

    // Liste les destinations actives.
    public function selectAll_destinations()
    {
        return $this->modele->selectAll_destinations();
    }

    // Liste les destinations pour l'administration.
    public function selectAll_destinations_admin()
    {
        return $this->modele->selectAll_destinations_admin();
    }

    // Recherche une destination publique.
    public function selectLike_destination(string $filtre)
    {
        return $this->modele->selectLike_destination($filtre);
    }

    // Recupere une destination par son id.
    public function selectWhere_destination(int $id_destination)
    {
        return $this->modele->selectWhere_destination($id_destination);
    }

    // Verifie si une destination existe deja.
    public function selectWhere_destination_by_pays_ville(string $pays, string $ville)
    {
        return $this->modele->selectWhere_destination_by_pays_ville($pays, $ville);
    }

    // Verifie les doublons de destination sauf celle modifiee.
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

    // Modifie une destination.
    public function update_destination(array $tab): void
    {
        $this->modele->update_destination($tab);
    }

    // Desactive une destination.
    public function delete_destination(int $id_destination): void
    {
        $this->modele->delete_destination($id_destination);
    }

    // Change le statut actif d'une destination.
    public function set_destination_actif(int $id_destination, int $actif): void
    {
        $this->modele->set_destination_actif($id_destination, $actif);
    }

    // offres

    // Ajoute une offre.
    public function insert_offre(array $tab): void
    {
        $this->modele->insert_offre($tab);
    }

    // Liste toutes les offres.
    public function selectAll_offres()
    {
        return $this->modele->selectAll_offres();
    }

    // Liste les offres actives.
    public function selectAll_offres_actives()
    {
        return $this->modele->selectAll_offres_actives();
    }

    // Recherche une offre admin.
    public function selectLike_offre(string $filtre)
    {
        return $this->modele->selectLike_offre($filtre);
    }

    // Recherche les offres publiques actives.
    public function selectLike_offres_actives(string $filtre): array
    {
        return $this->modele->selectLike_offres_actives($filtre);
    }

    // Recupere une offre par son id.
    public function selectWhere_offre(int $id_offre)
    {
        return $this->modele->selectWhere_offre($id_offre);
    }

    // Recupere l'offre active d'une destination.
    public function selectWhere_offre_active_by_destination(int $id_destination)
    {
        return $this->modele->selectWhere_offre_active_by_destination($id_destination);
    }

    // Modifie une offre.
    public function update_offre(array $tab): void
    {
        $this->modele->update_offre($tab);
    }

    // Desactive une offre.
    public function delete_offre(int $id_offre): void
    {
        $this->modele->delete_offre($id_offre);
    }

    // Change le statut actif d'une offre.
    public function set_offre_actif(int $id_offre, int $actif): void
    {
        $this->modele->set_offre_actif($id_offre, $actif);
    }

    // voyages

    // Ajoute un voyage organise.
    public function insert_voyage(array $tab): void
    {
        $this->modele->insert_voyage($tab);
    }

    // Liste les voyages pour l'administration.
    public function selectAll_voyages_admin()
    {
        return $this->modele->selectAll_voyages_admin();
    }

    // Liste les voyages actifs.
    public function selectAll_voyages_actifs()
    {
        return $this->modele->selectAll_voyages_actifs();
    }

    // Liste les voyages actifs d'une destination.
    public function selectAll_voyages_actifs_by_destination(int $id_destination): array
    {
        return $this->modele->selectAll_voyages_actifs_by_destination($id_destination);
    }

    // Recupere un voyage par son id.
    public function selectWhere_voyage(int $id_voyage)
    {
        return $this->modele->selectWhere_voyage($id_voyage);
    }

    // Recupere un voyage actif par son id.
    public function selectWhere_voyage_actif(int $id_voyage)
    {
        return $this->modele->selectWhere_voyage_actif($id_voyage);
    }

    // Modifie un voyage.
    public function update_voyage(array $tab): void
    {
        $this->modele->update_voyage($tab);
    }

    // Supprime un voyage.
    public function delete_voyage(int $id_voyage): void
    {
        $this->modele->delete_voyage($id_voyage);
    }

    // Change le statut d'un voyage.
    public function set_voyage_statut(int $id_voyage, string $statut): void
    {
        $this->modele->set_voyage_statut($id_voyage, $statut);
    }

    // Passe un voyage en complet si plus aucune place.
    public function maj_statut_voyage_si_complet(int $id_voyage): void
    {
        $this->modele->maj_statut_voyage_si_complet($id_voyage);
    }

    // réservations

    // Ajoute une reservation de destination.
    public function insert_reservation_destination(array $tab): void
    {
        $this->modele->insert_reservation_destination($tab);
    }

    // Ajoute une reservation de voyage.
    public function insert_reservation_voyage(array $tab): void
    {
        $this->modele->insert_reservation_voyage($tab);
    }

    // Cree une reservation destination securisee.
    public function reserver_destination(array $tab): bool
    {
        return $this->modele->reserver_destination($tab);
    }

    // Cree une reservation voyage securisee.
    public function reserver_voyage(array $tab): bool
    {
        return $this->modele->reserver_voyage($tab);
    }

    // Liste les reservations de destinations.
    public function selectAll_reservations_destinations()
    {
        return $this->modele->selectAll_reservations_destinations();
    }

    // Liste les reservations de voyages.
    public function selectAll_reservations_voyages()
    {
        return $this->modele->selectAll_reservations_voyages();
    }

    // Liste toutes les reservations melangees.
    public function selectAll_reservations()
    {
        return $this->modele->selectAll_reservations_union();
    }

    // Liste les reservations destination d'un client.
    public function selectWhere_reservations_destinations_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_destinations_by_client($id_client);
    }

    // Liste les reservations voyage d'un client.
    public function selectWhere_reservations_voyages_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_voyages_by_client($id_client);
    }

    // Liste toutes les reservations d'un client.
    public function selectWhere_reservations_by_client(int $id_client)
    {
        return $this->modele->selectWhere_reservations_by_client_union($id_client);
    }

    // Recupere les reservations du client connecte.
    public function selectMesReservations(): array
    {
        $idClient = $this->getIdClientConnecte();

        return [
            "destinations" => $this->modele->selectWhere_reservations_destinations_by_client($idClient),
            "voyages" => $this->modele->selectWhere_reservations_voyages_by_client($idClient),
        ];
    }

    // Met a jour le statut d'une reservation destination.
    public function update_reservation_destination_statut(array $tab): void
    {
        $this->modele->update_reservation_destination_statut($tab);
    }

    // Met a jour le statut d'une reservation voyage.
    public function update_reservation_voyage_statut(array $tab): void
    {
        $this->modele->update_reservation_voyage_statut($tab);
    }

    // Compte les reservations en attente pour le badge admin.
    public function countReservationsEnAttenteAdmin(): int
    {
        return $this->modele->countReservationsEnAttenteAdmin();
    }

    // Compte les reservations en attente d'un client pour le badge client.
    public function countReservationsEnAttenteClient(int $idClient): int
    {
        return $this->modele->countReservationsEnAttenteClient($idClient);
    }

    // Recupere le voyage lie a une reservation voyage.
    public function select_id_voyage_by_reservation_voyage(int $id_reservation_voyage): int
    {
        return $this->modele->select_id_voyage_by_reservation_voyage($id_reservation_voyage);
    }

    // Liste les reservations destination d'un utilisateur.
    public function selectReservationsDestinationsByUtilisateur(int $idUtilisateur): array
    {
        return $this->modele->selectReservationsDestinationsByUtilisateur($idUtilisateur);
    }

    // Liste les reservations voyage d'un utilisateur.
    public function selectReservationsVoyagesByUtilisateur(int $idUtilisateur): array
    {
        return $this->modele->selectReservationsVoyagesByUtilisateur($idUtilisateur);
    }

    // profil client

    // Charge le profil complet d'un client.
    public function getProfilClient(int $idUtilisateur)
    {
        return $this->modele->getProfilClient($idUtilisateur);
    }

    // Charge le profil simple d'un utilisateur.
    public function getProfilUtilisateur(int $idUtilisateur)
    {
        return $this->modele->getProfilUtilisateur($idUtilisateur);
    }

    // Verifie si un email est deja utilise par un autre compte.
    public function emailExistePourAutreUtilisateur(string $email, int $idUtilisateur)
    {
        return $this->modele->emailExistePourAutreUtilisateur($email, $idUtilisateur);
    }

    // Modifie le profil d'un client.
    public function updateProfilClient(array $tab): void
    {
        $this->modele->updateProfilClient($tab);
    }

    // Modifie le profil d'un utilisateur.
    public function updateProfilUtilisateur(array $tab): void
    {
        $this->modele->updateProfilUtilisateur($tab);
    }

    // Recupere le mot de passe hash d'un utilisateur.
    public function selectMotDePasseUtilisateur(int $idUtilisateur)
    {
        return $this->modele->selectMotDePasseUtilisateur($idUtilisateur);
    }

    // Met a jour le mot de passe hash.
    public function updateMotDePasseUtilisateur(int $idUtilisateur, string $hash): void
    {
        $this->modele->updateMotDePasseUtilisateur($idUtilisateur, $hash);
    }

    // dashboard admin

    // Recupere les statistiques du dashboard admin.
    public function getStatsDashboardAdmin(): array
    {
        return $this->modele->getStatsDashboardAdmin();
    }
}
