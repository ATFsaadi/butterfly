<?php

class Modele
{
    private PDO $pdo;

    public function __construct()
    {
        // connexion à la base de données
        $dsn = "mysql:host=localhost;dbname=bfly_ppe;charset=utf8mb4";
        $user = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            // affiche une erreur si la connexion échoue
            echo "erreur de connexion à " . $dsn . "<br>";
            echo $e->getMessage();
            exit();
        }
    }

    // exécute une requête et récupère une seule ligne
    private function fetchOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    // exécute une requête et récupère plusieurs lignes
    private function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // exécute une requête (insert / update / delete) sans retour
    private function execute(string $sql, array $params = []): void
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    /* utilisateurs / client */

    // récupère un utilisateur actif à partir de son email (pour la connexion)
    public function select_user_login(string $email): array|false
    {
        $sql = "select *
                from utilisateurs
                where email = :email
                  and actif = 1";
        return $this->fetchOne($sql, [":email" => $email]);
    }

    // récupère un utilisateur par email (actif ou non)
    public function selectWhere_utilisateur_by_email(string $email): array|false
    {
        $sql = "select *
                from utilisateurs
                where email = :email";
        return $this->fetchOne($sql, [":email" => $email]);
    }

    // ajoute un utilisateur (compte) dans la table utilisateurs
    public function insert_utilisateur(array $tab): void
    {
        $sql = "insert into utilisateurs (email, mot_de_passe_hash, role, actif)
                values (:email, :hash, :role, 1)";
        $this->execute($sql, [
            ":email" => $tab["email"],
            ":hash" => $tab["mot_de_passe_hash"],
            ":role" => $tab["role"] ?? "client",
        ]);
    }

    // ajoute la fiche client liée à l'utilisateur (nom, prénom, adresse, etc.)
    public function insert_client(array $tab): void
    {
        $sql = "insert into client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
                values (:id_utilisateur, :nom, :prenom, :telephone, :adresse, :ville, :pays)";
        $this->execute($sql, [
            ":id_utilisateur" => $tab["id_utilisateur"],
            ":nom" => $tab["nom"],
            ":prenom" => $tab["prenom"],
            ":telephone" => $tab["telephone"] ?? null,
            ":adresse" => $tab["adresse"] ?? null,
            ":ville" => $tab["ville"] ?? null,
            ":pays" => $tab["pays"] ?? null,
        ]);
    }

    // récupère la fiche client à partir de l'id utilisateur
    public function selectWhere_client_by_user(int $id_utilisateur): array|false
    {
        $sql = "select *
                from client
                where id_utilisateur = :id_utilisateur";
        return $this->fetchOne($sql, [":id_utilisateur" => $id_utilisateur]);
    }

    // inscription complète : crée l'utilisateur + le client dans une transaction
    public function inscription_complete(array $userTab, array $clientTab): array|false
    {
        try {
            $this->pdo->beginTransaction();

            $this->insert_utilisateur($userTab);
            $idUser = (int) $this->pdo->lastInsertId();

            $clientTab["id_utilisateur"] = $idUser;
            $this->insert_client($clientTab);
            $idClient = (int) $this->pdo->lastInsertId();

            $this->pdo->commit();
            return ["id_utilisateur" => $idUser, "id_client" => $idClient];
        } catch (Exception $e) {
            // annule tout si une erreur arrive
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo "erreur inscription : " . $e->getMessage();
            return false;
        }
    }

    /* continents / destinations */

    // récupère tous les continents triés par nom
    public function selectAll_continents(): array
    {
        $sql = "select *
                from continents
                order by nom asc";
        return $this->fetchAll($sql);
    }

    // récupère un continent précis par id
    public function selectWhere_continent(int $id_continent): array|false
    {
        $sql = "select *
                from continents
                where id_continent = :id_continent";
        return $this->fetchOne($sql, [":id_continent" => $id_continent]);
    }

    // ajoute une destination (actif = 1 par défaut)
    public function insert_destination(array $tab): void
    {
        $sql = "insert into destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
                values (:pays, :ville, :id_continent, :description, :prix_base, :image_url, 1)";
        $this->execute($sql, [
            ":pays" => $tab["pays"],
            ":ville" => $tab["ville"],
            ":id_continent" => $tab["id_continent"] ?? null,
            ":description" => $tab["description"] ?? null,
            ":prix_base" => $tab["prix_base"],
            ":image_url" => $tab["image_url"] ?? null,
        ]);
    }

    // liste toutes les destinations actives (avec le nom du continent)
    public function selectAll_destinations(): array
    {
        $sql = "select d.*, c.nom as continent
                from destinations d
                left join continents c on c.id_continent = d.id_continent
                where d.actif = 1
                order by d.pays, d.ville";
        return $this->fetchAll($sql);
    }

    // liste toutes les destinations (admin : actives + inactives)
    public function selectAll_destinations_admin(): array
    {
        $sql = "select d.*, c.nom as continent
                from destinations d
                left join continents c on c.id_continent = d.id_continent
                order by d.actif desc, d.pays, d.ville";
        return $this->fetchAll($sql);
    }

    // recherche une destination active avec un filtre (pays, ville ou continent)
    public function selectLike_destination(string $filtre): array
    {
        $sql = "select d.*, c.nom as continent
                from destinations d
                left join continents c on c.id_continent = d.id_continent
                where d.actif = 1
                  and (d.pays like :filtre or d.ville like :filtre or c.nom like :filtre)
                order by d.pays, d.ville";
        return $this->fetchAll($sql, [":filtre" => "%" . $filtre . "%"]);
    }

    // récupère une destination précise par id (avec continent)
    public function selectWhere_destination(int $id_destination): array|false
    {
        $sql = "select d.*, c.nom as continent
                from destinations d
                left join continents c on c.id_continent = d.id_continent
                where d.id_destination = :id_destination";
        return $this->fetchOne($sql, [":id_destination" => $id_destination]);
    }

    // modifie une destination (y compris son statut actif)
    public function update_destination(array $tab): void
    {
        $sql = "update destinations
                set pays = :pays,
                    ville = :ville,
                    id_continent = :id_continent,
                    description = :description,
                    prix_base = :prix_base,
                    image_url = :image_url,
                    actif = :actif
                where id_destination = :id_destination";
        $this->execute($sql, [
            ":id_destination" => $tab["id_destination"],
            ":pays" => $tab["pays"],
            ":ville" => $tab["ville"],
            ":id_continent" => $tab["id_continent"] ?? null,
            ":description" => $tab["description"] ?? null,
            ":prix_base" => $tab["prix_base"],
            ":image_url" => $tab["image_url"] ?? null,
            ":actif" => $tab["actif"] ?? 1,
        ]);
    }

    // désactive une destination (suppression logique)
    public function delete_destination(int $id_destination): void
    {
        $sql = "update destinations
                set actif = 0
                where id_destination = :id_destination";
        $this->execute($sql, [":id_destination" => $id_destination]);
    }

    // active ou désactive une destination (0 ou 1)
    public function set_destination_actif(int $id_destination, int $actif): void
    {
        $sql = "update destinations
                set actif = :actif
                where id_destination = :id_destination";
        $this->execute($sql, [
            ":id_destination" => $id_destination,
            ":actif" => $actif,
        ]);
    }

    // réserve une destination : vérifie qu'elle est active puis insère la réservation
    public function reserver_destination(array $tab): bool
    {
        try {
            $this->pdo->beginTransaction();

            // vérifier que la destination existe et est active
            $sql = "select actif
                    from destinations
                    where id_destination = :id_destination
                    limit 1";
            $row = $this->fetchOne($sql, [":id_destination" => (int)$tab["id_destination"]]);

            if (!$row || (int)$row["actif"] !== 1) {
                $this->pdo->rollBack();
                return false;
            }

            // insérer la réservation destination
            $this->insert_reservation_destination([
                "id_client" => (int)$tab["id_client"],
                "id_destination" => (int)$tab["id_destination"],
                "date_depart" => $tab["date_depart"],
                "date_retour" => $tab["date_retour"],
                "nb_personnes" => (int)$tab["nb_personnes"],
                "prix_total" => (float)$tab["prix_total"],
                "statut" => "en_attente",
            ]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            // annule tout si erreur
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }

    /* offres */

    // ajoute une offre promo pour une destination (actif=1)
    public function insert_offre(array $tab): void
    {
        $sql = "insert into offres (id_destination, titre, pourcentage_reduction, date_debut, date_fin, actif)
                values (:id_destination, :titre, :pourcentage, :date_debut, :date_fin, 1)";
        $this->execute($sql, [
            ":id_destination" => $tab["id_destination"],
            ":titre" => $tab["titre"],
            ":pourcentage" => $tab["pourcentage_reduction"],
            ":date_debut" => $tab["date_debut"],
            ":date_fin" => $tab["date_fin"],
        ]);
    }

    // liste toutes les offres (avec destination + continent)
    public function selectAll_offres(): array
    {
        $sql = "select o.*, d.pays, d.ville, cont.nom as continent
                from offres o
                join destinations d on d.id_destination = o.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                order by o.date_debut desc";
        return $this->fetchAll($sql);
    }

    // recherche des offres avec un filtre (titre, pays, ville, continent)
    public function selectLike_offre(string $filtre): array
    {
        $sql = "select o.*, d.pays, d.ville, cont.nom as continent
                from offres o
                join destinations d on d.id_destination = o.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where o.titre like :filtre
                   or d.pays like :filtre
                   or d.ville like :filtre
                   or cont.nom like :filtre
                order by o.date_debut desc";
        return $this->fetchAll($sql, [":filtre" => "%" . $filtre . "%"]);
    }

    // récupère une offre par id
    public function selectWhere_offre(int $id_offre): array|false
    {
        $sql = "select *
                from offres
                where id_offre = :id_offre";
        return $this->fetchOne($sql, [":id_offre" => $id_offre]);
    }

    // modifie une offre (infos + actif)
    public function update_offre(array $tab): void
    {
        $sql = "update offres
                set id_destination = :id_destination,
                    titre = :titre,
                    pourcentage_reduction = :pourcentage,
                    date_debut = :date_debut,
                    date_fin = :date_fin,
                    actif = :actif
                where id_offre = :id_offre";
        $this->execute($sql, [
            ":id_offre" => $tab["id_offre"],
            ":id_destination" => $tab["id_destination"],
            ":titre" => $tab["titre"],
            ":pourcentage" => $tab["pourcentage_reduction"],
            ":date_debut" => $tab["date_debut"],
            ":date_fin" => $tab["date_fin"],
            ":actif" => $tab["actif"] ?? 1,
        ]);
    }

    // désactive une offre (suppression logique)
    public function delete_offre(int $id_offre): void
    {
        $sql = "update offres
                set actif = 0
                where id_offre = :id_offre";
        $this->execute($sql, [":id_offre" => $id_offre]);
    }

    // active ou désactive une offre (0 ou 1)
    public function set_offre_actif(int $id_offre, int $actif): void
    {
        $sql = "update offres
                set actif = :actif
                where id_offre = :id_offre";
        $this->execute($sql, [
            ":id_offre" => $id_offre,
            ":actif" => $actif,
        ]);
    }

    // liste les offres actives du moment (offre active + destination active + date ok)
    public function selectAll_offres_actives(): array
    {
        $sql = "select o.*, d.pays, d.ville, d.image_url, d.prix_base, cont.nom as continent
                from offres o
                join destinations d on d.id_destination = o.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where o.actif = 1
                  and d.actif = 1
                  and curdate() between o.date_debut and o.date_fin
                order by o.date_debut desc";
        return $this->fetchAll($sql);
    }

    // recherche dans les offres actives du moment
    public function selectLike_offres_actives(string $filtre): array
    {
        $sql = "select o.*, d.pays, d.ville, d.image_url, d.prix_base, cont.nom as continent
                from offres o
                join destinations d on d.id_destination = o.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where o.actif = 1
                  and d.actif = 1
                  and curdate() between o.date_debut and o.date_fin
                  and (
                        o.titre like :filtre
                     or d.pays like :filtre
                     or d.ville like :filtre
                     or cont.nom like :filtre
                  )
                order by o.date_debut desc";
        return $this->fetchAll($sql, [":filtre" => "%" . $filtre . "%"]);
    }

    // récupère l'offre active actuelle d'une destination (max 1 offre)
    public function selectWhere_offre_active_by_destination(int $id_destination): array|false
    {
        $sql = "select *
                from offres
                where actif = 1
                  and id_destination = :id_destination
                  and curdate() between date_debut and date_fin
                limit 1";
        return $this->fetchOne($sql, [":id_destination" => $id_destination]);
    }

    /* voyages */

    // ajoute un voyage organisé (avec places, dates, prix, statut)
    public function insert_voyage(array $tab): void
    {
        $sql = "insert into voyages_organises
                (id_destination, titre, description, date_depart, date_retour, prix, nb_places, nb_places_restantes, image_url, statut)
                values
                (:id_destination, :titre, :description, :date_depart, :date_retour, :prix, :nb_places, :nb_places_restantes, :image_url, :statut)";
        $this->execute($sql, [
            ":id_destination" => $tab["id_destination"],
            ":titre" => $tab["titre"],
            ":description" => $tab["description"] ?? null,
            ":date_depart" => $tab["date_depart"],
            ":date_retour" => $tab["date_retour"],
            ":prix" => $tab["prix"],
            ":nb_places" => $tab["nb_places"],
            ":nb_places_restantes" => $tab["nb_places_restantes"],
            ":image_url" => $tab["image_url"] ?? null,
            ":statut" => $tab["statut"] ?? "actif",
        ]);
    }

    // liste tous les voyages (admin)
    public function selectAll_voyages_admin(): array
    {
        $sql = "select v.*, d.pays, d.ville, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                order by v.date_depart desc";
        return $this->fetchAll($sql);
    }

    // liste les voyages au statut actif
    public function selectAll_voyages_actifs(): array
    {
        $sql = "select v.*, d.pays, d.ville, d.image_url as destination_image_url, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where v.statut = 'actif'
                order by v.date_depart asc";
        return $this->fetchAll($sql);
    }

    // récupère un voyage précis par id (avec infos destination + continent)
    public function selectWhere_voyage(int $id_voyage): array|false
    {
        $sql = "select v.*, d.pays, d.ville, d.description as destination_description, d.prix_base, d.image_url as destination_image_url, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where v.id_voyage = :id_voyage";
        return $this->fetchOne($sql, [":id_voyage" => $id_voyage]);
    }

    // modifie un voyage (infos + places + statut)
    public function update_voyage(array $tab): void
    {
        $sql = "update voyages_organises
                set id_destination = :id_destination,
                    titre = :titre,
                    description = :description,
                    date_depart = :date_depart,
                    date_retour = :date_retour,
                    prix = :prix,
                    nb_places = :nb_places,
                    nb_places_restantes = :nb_places_restantes,
                    image_url = :image_url,
                    statut = :statut
                where id_voyage = :id_voyage";
        $this->execute($sql, [
            ":id_voyage" => $tab["id_voyage"],
            ":id_destination" => $tab["id_destination"],
            ":titre" => $tab["titre"],
            ":description" => $tab["description"] ?? null,
            ":date_depart" => $tab["date_depart"],
            ":date_retour" => $tab["date_retour"],
            ":prix" => $tab["prix"],
            ":nb_places" => $tab["nb_places"],
            ":nb_places_restantes" => $tab["nb_places_restantes"],
            ":image_url" => $tab["image_url"] ?? null,
            ":statut" => $tab["statut"] ?? "actif",
        ]);
    }

    // supprime un voyage de la base (suppression réelle)
    public function delete_voyage(int $id_voyage): void
    {
        $sql = "delete from voyages_organises
                where id_voyage = :id_voyage";
        $this->execute($sql, [":id_voyage" => $id_voyage]);
    }

    // change le statut d'un voyage (ex: actif, complet, annulé)
    public function set_voyage_statut(int $id_voyage, string $statut): void
    {
        $sql = "update voyages_organises
                set statut = :statut
                where id_voyage = :id_voyage";
        $this->execute($sql, [
            ":id_voyage" => $id_voyage,
            ":statut" => $statut,
        ]);
    }

    // liste les voyages actifs d'une destination précise
    public function selectAll_voyages_actifs_by_destination(int $id_destination): array
    {
        $sql = "select v.*, d.pays, d.ville, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where v.id_destination = :id_destination
                  and v.statut = 'actif'
                order by v.date_depart asc";
        return $this->fetchAll($sql, [":id_destination" => $id_destination]);
    }

    /* reservations */

    // ajoute une réservation voyage (statut en_attente par défaut)
    public function insert_reservation_voyage(array $tab): void
    {
        $sql = "insert into reservations_voyages
                (id_client, id_voyage, nb_personnes, prix_total, statut)
                values
                (:id_client, :id_voyage, :nb_personnes, :prix_total, :statut)";
        $this->execute($sql, [
            ":id_client" => (int) $tab["id_client"],
            ":id_voyage" => (int) $tab["id_voyage"],
            ":nb_personnes" => (int) $tab["nb_personnes"],
            ":prix_total" => (float) $tab["prix_total"],
            ":statut" => $tab["statut"] ?? "en_attente",
        ]);
    }

    // ajoute une réservation destination (statut en_attente par défaut)
    public function insert_reservation_destination(array $tab): void
    {
        $sql = "insert into reservations_destinations
                (id_client, id_destination, date_depart, date_retour, nb_personnes, prix_total, statut)
                values
                (:id_client, :id_destination, :date_depart, :date_retour, :nb_personnes, :prix_total, :statut)";
        $this->execute($sql, [
            ":id_client" => (int) $tab["id_client"],
            ":id_destination" => (int) $tab["id_destination"],
            ":date_depart" => $tab["date_depart"],
            ":date_retour" => $tab["date_retour"],
            ":nb_personnes" => (int) $tab["nb_personnes"],
            ":prix_total" => (float) $tab["prix_total"],
            ":statut" => $tab["statut"] ?? "en_attente",
        ]);
    }

    // liste toutes les réservations destinations (admin)
    public function selectAll_reservations_destinations(): array
    {
        $sql = "select rd.*,
                       c.nom, c.prenom,
                       d.pays, d.ville,
                       cont.nom as continent
                from reservations_destinations rd
                join client c on c.id_client = rd.id_client
                join destinations d on d.id_destination = rd.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                order by rd.date_reservation desc";
        return $this->fetchAll($sql);
    }

    // liste toutes les réservations voyages (admin)
    public function selectAll_reservations_voyages(): array
    {
        $sql = "select rv.*,
                       c.nom, c.prenom,
                       v.titre as voyage_titre, v.date_depart as voyage_date_depart, v.date_retour as voyage_date_retour, v.prix as voyage_prix, v.statut as voyage_statut,
                       d.pays, d.ville,
                       cont.nom as continent
                from reservations_voyages rv
                join client c on c.id_client = rv.id_client
                join voyages_organises v on v.id_voyage = rv.id_voyage
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                order by rv.date_reservation desc";
        return $this->fetchAll($sql);
    }

    // récupère les réservations destinations d'un client
    public function selectWhere_reservations_destinations_by_client(int $id_client): array
    {
        $sql = "select rd.*,
                       d.pays, d.ville, d.image_url as destination_image_url,
                       cont.nom as continent
                from reservations_destinations rd
                join destinations d on d.id_destination = rd.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where rd.id_client = :id_client
                order by rd.date_reservation desc";
        return $this->fetchAll($sql, [":id_client" => $id_client]);
    }

    // récupère les réservations voyages d'un client
    public function selectWhere_reservations_voyages_by_client(int $id_client): array
    {
        $sql = "select rv.*,
                       v.titre as voyage_titre, v.date_depart as voyage_date_depart, v.date_retour as voyage_date_retour, v.prix as voyage_prix, v.image_url as voyage_image_url, v.statut as voyage_statut,
                       d.pays, d.ville, d.image_url as destination_image_url,
                       cont.nom as continent
                from reservations_voyages rv
                join voyages_organises v on v.id_voyage = rv.id_voyage
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where rv.id_client = :id_client
                order by rv.date_reservation desc";
        return $this->fetchAll($sql, [":id_client" => $id_client]);
    }

    // modifie le statut d'une réservation destination (ex: en_attente, validée, annulée)
    public function update_reservation_destination_statut(array $tab): void
    {
        $sql = "update reservations_destinations
                set statut = :statut
                where id_reservation_destination = :id_reservation_destination";
        $this->execute($sql, [
            ":id_reservation_destination" => (int) $tab["id_reservation_destination"],
            ":statut" => $tab["statut"],
        ]);
    }

    // modifie le statut d'une réservation voyage (ex: en_attente, validée, annulée)
    public function update_reservation_voyage_statut(array $tab): void
    {
        $sql = "update reservations_voyages
                set statut = :statut
                where id_reservation_voyage = :id_reservation_voyage";
        $this->execute($sql, [
            ":id_reservation_voyage" => (int) $tab["id_reservation_voyage"],
            ":statut" => $tab["statut"],
        ]);
    }

    // fusionne toutes les réservations (destinations + voyages) en une seule liste (admin)
    public function selectAll_reservations_union(): array
    {
        $sql = "
            select
                rd.id_reservation_destination as id_reservation,
                'destination' as type_reservation,
                rd.date_depart as date_depart,
                rd.date_retour as date_retour,
                rd.nb_personnes as nb_personnes,
                rd.prix_total as prix_total,
                rd.statut as statut,
                rd.date_reservation as date_reservation,

                c.nom as nom,
                c.prenom as prenom,

                d.pays as pays,
                d.ville as ville,
                cont.nom as continent,

                '' as voyage_titre,
                null as voyage_date_depart,
                null as voyage_date_retour
            from reservations_destinations rd
            join client c on c.id_client = rd.id_client
            join destinations d on d.id_destination = rd.id_destination
            left join continents cont on cont.id_continent = d.id_continent

            union all

            select
                rv.id_reservation_voyage as id_reservation,
                'voyage' as type_reservation,
                v.date_depart as date_depart,
                v.date_retour as date_retour,
                rv.nb_personnes as nb_personnes,
                rv.prix_total as prix_total,
                rv.statut as statut,
                rv.date_reservation as date_reservation,

                c.nom as nom,
                c.prenom as prenom,

                d.pays as pays,
                d.ville as ville,
                cont.nom as continent,

                v.titre as voyage_titre,
                v.date_depart as voyage_date_depart,
                v.date_retour as voyage_date_retour
            from reservations_voyages rv
            join client c on c.id_client = rv.id_client
            join voyages_organises v on v.id_voyage = rv.id_voyage
            join destinations d on d.id_destination = v.id_destination
            left join continents cont on cont.id_continent = d.id_continent

            order by date_reservation desc
        ";
        return $this->fetchAll($sql);
    }

    // récupère toutes les réservations d'un client (destinations + voyages fusionnées)
    public function selectWhere_reservations_by_client_union(int $id_client): array
    {
        $sql = "select *
                from (
                    select
                        'destination' as type_reservation,
                        rd.id_reservation_destination as id_reservation,
                        rd.id_client,
                        rd.id_destination,
                        null as id_voyage,
                        rd.date_depart,
                        rd.date_retour,
                        rd.nb_personnes,
                        rd.prix_total,
                        rd.statut,
                        rd.date_reservation,
                        null as voyage_titre,
                        null as voyage_image_url,
                        d.image_url as destination_image_url,
                        d.pays, d.ville,
                        cont.nom as continent
                    from reservations_destinations rd
                    join destinations d on d.id_destination = rd.id_destination
                    left join continents cont on cont.id_continent = d.id_continent
                    where rd.id_client = :id_client

                    union all

                    select
                        'voyage' as type_reservation,
                        rv.id_reservation_voyage as id_reservation,
                        rv.id_client,
                        v.id_destination as id_destination,
                        rv.id_voyage,
                        v.date_depart,
                        v.date_retour,
                        rv.nb_personnes,
                        rv.prix_total,
                        rv.statut,
                        rv.date_reservation,
                        v.titre as voyage_titre,
                        v.image_url as voyage_image_url,
                        d.image_url as destination_image_url,
                        d.pays, d.ville,
                        cont.nom as continent
                    from reservations_voyages rv
                    join voyages_organises v on v.id_voyage = rv.id_voyage
                    join destinations d on d.id_destination = v.id_destination
                    left join continents cont on cont.id_continent = d.id_continent
                    where rv.id_client = :id_client
                ) x
                order by date_reservation desc";
        return $this->fetchAll($sql, [":id_client" => $id_client]);
    }

    // enlève des places restantes sur un voyage si il y a assez de places
    public function decrement_places_voyage(int $id_voyage, int $nb_personnes): int
    {
        $sql = "update voyages_organises
                set nb_places_restantes = nb_places_restantes - :nb
                where id_voyage = :id_voyage
                  and statut = 'actif'
                  and nb_places_restantes >= :nb";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ":id_voyage" => $id_voyage,
            ":nb" => $nb_personnes,
        ]);
        return $stmt->rowCount();
    }

    // réserve un voyage : décrémente les places puis insère la réservation (transaction)
    public function reserver_voyage(array $tab): bool
    {
        try {
            $this->pdo->beginTransaction();

            $changed = $this->decrement_places_voyage((int) $tab["id_voyage"], (int) $tab["nb_personnes"]);
            if ($changed !== 1) {
                $this->pdo->rollBack();
                return false;
            }

            $this->insert_reservation_voyage([
                "id_client" => (int) $tab["id_client"],
                "id_voyage" => (int) $tab["id_voyage"],
                "nb_personnes" => (int) $tab["nb_personnes"],
                "prix_total" => (float) $tab["prix_total"],
                "statut" => "en_attente",
            ]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }

    // récupère l'id du voyage à partir de l'id de réservation voyage
    public function select_id_voyage_by_reservation_voyage(int $id_reservation_voyage): int
    {
        $sql = "select id_voyage
                from reservations_voyages
                where id_reservation_voyage = :id
                limit 1";
        $row = $this->fetchOne($sql, [":id" => $id_reservation_voyage]);
        return $row ? (int)$row["id_voyage"] : 0;
    }

    // passe le statut du voyage à complet si il n'y a plus de places restantes
    public function maj_statut_voyage_si_complet(int $id_voyage): void
    {
        $sql = "update voyages_organises
                set statut = 'complet'
                where id_voyage = :id_voyage
                  and nb_places_restantes <= 0
                  and statut = 'actif'";
        $this->execute($sql, [":id_voyage" => $id_voyage]);
    }
}
