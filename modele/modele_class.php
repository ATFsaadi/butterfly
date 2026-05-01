<?php

class Modele
{
    private PDO $pdo;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=bfly_ppe;charset=utf8mb4";
        $user = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            echo "erreur de connexion à " . $dsn . "<br>";
            echo $e->getMessage();
            exit();
        }
    }

    private function fetchOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    }

    private function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    private function execute(string $sql, array $params = []): void
    {
        $stmt = $this->pdo->prepare($sql);  
        $stmt->execute($params);
    }

    /* utilisateurs / client */

    public function select_user_login(string $email): array|false
    {
        $sql = "select *
                from utilisateurs
                where email = :email
                  and actif = 1";
        return $this->fetchOne($sql, [":email" => $email]);
    }

    public function selectWhere_utilisateur_by_email(string $email): array|false
    {
        $sql = "select *
                from utilisateurs
                where email = :email";
        return $this->fetchOne($sql, [":email" => $email]);
    }

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

    public function selectWhere_client_by_user(int $id_utilisateur): array|false
    {
        $sql = "select *
                from client
                where id_utilisateur = :id_utilisateur";
        return $this->fetchOne($sql, [":id_utilisateur" => $id_utilisateur]);
    }

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
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            echo "erreur inscription : " . $e->getMessage();
            return false;
        }
    }

    /* continents / destinations */

    public function selectAll_continents(): array
    {
        $sql = "select *
                from continents
                order by nom asc";
        return $this->fetchAll($sql);
    }

    public function selectWhere_continent(int $id_continent): array|false
    {
        $sql = "select *
                from continents
                where id_continent = :id_continent";
        return $this->fetchOne($sql, [":id_continent" => $id_continent]);
    }

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

    public function selectAll_destinations(): array
    {
        $sql = "select d.*, c.nom as continent
                from destinations d
                left join continents c on c.id_continent = d.id_continent
                where d.actif = 1
                order by d.pays, d.ville";
        return $this->fetchAll($sql);
    }

    public function selectAll_destinations_admin(): array
    {
        $sql = "select d.*, c.nom as continent
                from destinations d
                left join continents c on c.id_continent = d.id_continent
                order by d.actif desc, d.pays, d.ville";
        return $this->fetchAll($sql);
    }

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

    public function selectWhere_destination(int $id_destination): array|false
    {
        $sql = "select d.*, c.nom as continent
                from destinations d
                left join continents c on c.id_continent = d.id_continent
                where d.id_destination = :id_destination";
        return $this->fetchOne($sql, [":id_destination" => $id_destination]);
    }

    public function selectWhere_destination_by_pays_ville(string $pays, string $ville): array|false
    {
        $sql = "select *
                from destinations
                where pays = :pays
                  and ville = :ville";
        return $this->fetchOne($sql, [
            ":pays" => $pays,
            ":ville" => $ville
        ]);
    }

    public function selectWhere_destination_by_pays_ville_except_id(string $pays, string $ville, int $id_destination): array|false
    {
        $sql = "select *
                from destinations
                where pays = :pays
                  and ville = :ville
                  and id_destination <> :id_destination";
        return $this->fetchOne($sql, [
            ":pays" => $pays,
            ":ville" => $ville,
            ":id_destination" => $id_destination
        ]);
    }

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

    public function delete_destination(int $id_destination): void
    {
        $sql = "update destinations
                set actif = 0
                where id_destination = :id_destination";
        $this->execute($sql, [":id_destination" => $id_destination]);
    }

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

    public function reserver_destination(array $tab): bool
    {
        try {
            $this->pdo->beginTransaction();

            $sql = "select actif
                    from destinations
                    where id_destination = :id_destination
                    limit 1";
            $row = $this->fetchOne($sql, [":id_destination" => (int)$tab["id_destination"]]);

            if (!$row || (int)$row["actif"] !== 1) {
                $this->pdo->rollBack();
                return false;
            }

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
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            return false;
        }
    }

    /* offres */

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

    public function selectAll_offres(): array
    {
        $sql = "select o.*, d.pays, d.ville, cont.nom as continent
                from offres o
                join destinations d on d.id_destination = o.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                order by o.date_debut desc";
        return $this->fetchAll($sql);
    }

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

    public function selectWhere_offre(int $id_offre): array|false
    {
        $sql = "select *
                from offres
                where id_offre = :id_offre";
        return $this->fetchOne($sql, [":id_offre" => $id_offre]);
    }

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

    public function delete_offre(int $id_offre): void
    {
        $sql = "update offres
                set actif = 0
                where id_offre = :id_offre";
        $this->execute($sql, [":id_offre" => $id_offre]);
    }

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

    public function selectWhere_offre_active_by_destination(int $id_destination): array|false
    {
        $sql = "select o.*
                from offres o
                join destinations d on d.id_destination = o.id_destination
                where o.actif = 1
                  and d.actif = 1
                  and o.id_destination = :id_destination
                  and curdate() between o.date_debut and o.date_fin
                order by o.date_debut desc
                limit 1";
        return $this->fetchOne($sql, [":id_destination" => $id_destination]);
    }

    /* voyages */

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

    public function selectAll_voyages_admin(): array
    {
        $sql = "select v.*, d.pays, d.ville, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                order by v.date_depart desc";
        return $this->fetchAll($sql);
    }

    public function selectAll_voyages_actifs(): array
    {
        $sql = "select v.*, d.pays, d.ville, d.image_url as destination_image_url, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where v.statut = 'actif'
                  and d.actif = 1
                order by v.date_depart asc";
        return $this->fetchAll($sql);
    }

    public function selectWhere_voyage(int $id_voyage): array|false
    {
        $sql = "select v.*, d.pays, d.ville, d.description as destination_description, d.prix_base, d.image_url as destination_image_url, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where v.id_voyage = :id_voyage";
        return $this->fetchOne($sql, [":id_voyage" => $id_voyage]);
    }

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

    public function delete_voyage(int $id_voyage): void
    {
        $sql = "delete from voyages_organises
                where id_voyage = :id_voyage";
        $this->execute($sql, [":id_voyage" => $id_voyage]);
    }

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

    public function selectAll_voyages_actifs_by_destination(int $id_destination): array
    {
        $sql = "select v.*, d.pays, d.ville, cont.nom as continent
                from voyages_organises v
                join destinations d on d.id_destination = v.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where v.id_destination = :id_destination
                  and v.statut = 'actif'
                  and d.actif = 1
                order by v.date_depart asc";
        return $this->fetchAll($sql, [":id_destination" => $id_destination]);
    }

    /* reservations */

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

    public function select_id_voyage_by_reservation_voyage(int $id_reservation_voyage): int
    {
        $sql = "select id_voyage
                from reservations_voyages
                where id_reservation_voyage = :id
                limit 1";
        $row = $this->fetchOne($sql, [":id" => $id_reservation_voyage]);
        return $row ? (int)$row["id_voyage"] : 0;
    }

    public function maj_statut_voyage_si_complet(int $id_voyage): void
    {
        $sql = "update voyages_organises
                set statut = 'complet'
                where id_voyage = :id_voyage
                  and nb_places_restantes <= 0
                  and statut = 'actif'";
        $this->execute($sql, [":id_voyage" => $id_voyage]);
    }

    /* profil */

    public function getProfilClient(int $idUtilisateur): array|false
    {
        $sql = "select
                    u.id_utilisateur,
                    u.email,
                    u.role,
                    c.id_client,
                    c.nom,
                    c.prenom,
                    c.telephone,
                    c.adresse,
                    c.ville,
                    c.pays
                from utilisateurs u
                inner join client c on u.id_utilisateur = c.id_utilisateur
                where u.id_utilisateur = :id_utilisateur";

        return $this->fetchOne($sql, [":id_utilisateur" => $idUtilisateur]);
    }

    public function emailExistePourAutreUtilisateur(string $email, int $idUtilisateur): array|false
    {
        $sql = "select *
                from utilisateurs
                where email = :email
                  and id_utilisateur <> :id_utilisateur";

        return $this->fetchOne($sql, [
            ":email" => $email,
            ":id_utilisateur" => $idUtilisateur
        ]);
    }

    public function updateProfilClient(array $tab): void
    {
        $sql1 = "update utilisateurs
                 set email = :email
                 where id_utilisateur = :id_utilisateur";

        $this->execute($sql1, [
            ":email" => $tab["email"],
            ":id_utilisateur" => $tab["id_utilisateur"]
        ]);

        $sql2 = "update client
                 set nom = :nom,
                     prenom = :prenom,
                     telephone = :telephone,
                     adresse = :adresse,
                     ville = :ville,
                     pays = :pays
                 where id_utilisateur = :id_utilisateur";

        $this->execute($sql2, [
            ":nom" => $tab["nom"],
            ":prenom" => $tab["prenom"],
            ":telephone" => $tab["telephone"] ?: null,
            ":adresse" => $tab["adresse"] ?: null,
            ":ville" => $tab["ville"] ?: null,
            ":pays" => $tab["pays"] ?: null,
            ":id_utilisateur" => $tab["id_utilisateur"]
        ]);
    }

    public function selectMotDePasseUtilisateur(int $idUtilisateur): array|false
    {
        $sql = "select mot_de_passe_hash
                from utilisateurs
                where id_utilisateur = :id_utilisateur";

        return $this->fetchOne($sql, [":id_utilisateur" => $idUtilisateur]);
    }

    public function updateMotDePasseUtilisateur(int $idUtilisateur, string $hash): void
    {
        $sql = "update utilisateurs
                set mot_de_passe_hash = :hash
                where id_utilisateur = :id_utilisateur";

        $this->execute($sql, [
            ":hash" => $hash,
            ":id_utilisateur" => $idUtilisateur
        ]);
    }

  public function setUtilisateurActif(int $idUtilisateur, int $actif): void
{
    $sql = "update utilisateurs
            set actif = :actif
            where id_utilisateur = :id_utilisateur";

    $this->execute($sql, [
        ":actif" => $actif,
        ":id_utilisateur" => $idUtilisateur
    ]);
}

public function selectLike_clients_admin(string $filtre): array
{
    $sql = "select
                c.id_client,
                c.nom,
                c.prenom,
                c.telephone,
                c.adresse,
                c.ville,
                c.pays,
                u.id_utilisateur,
                u.email,
                u.role,
                u.actif,
                u.date_creation
            from client c
            inner join utilisateurs u on u.id_utilisateur = c.id_utilisateur
            where u.role = 'client'
              and (
                    c.nom like :filtre
                 or c.prenom like :filtre
                 or u.email like :filtre
                 or c.ville like :filtre
                 or c.pays like :filtre
              )
            order by c.nom asc, c.prenom asc";

    return $this->fetchAll($sql, [":filtre" => "%" . $filtre . "%"]);
}

public function selectAll_clients_admin(): array
{
    $sql = "select
                c.id_client,
                c.nom,
                c.prenom,
                c.telephone,
                c.adresse,
                c.ville,
                c.pays,
                u.id_utilisateur,
                u.email,
                u.role,
                u.actif,
                u.date_creation
            from client c
            inner join utilisateurs u on u.id_utilisateur = c.id_utilisateur
            where u.role = 'client'
            order by c.nom asc, c.prenom asc";

    return $this->fetchAll($sql);
}

public function deleteClientByAdmin(int $idUtilisateur): void
{
    $sql = "delete from utilisateurs
            where id_utilisateur = :id_utilisateur
              and role = 'client'";

    $this->execute($sql, [":id_utilisateur" => $idUtilisateur]);
}
public function selectWhere_client_admin(int $idUtilisateur): array|false
{
    $sql = "select
                c.id_client,
                c.nom,
                c.prenom,
                c.telephone,
                c.adresse,
                c.ville,
                c.pays,
                c.date_creation as client_date_creation,
                c.date_modification as client_date_modification,
                u.id_utilisateur,
                u.email,
                u.role,
                u.actif,
                u.date_creation as user_date_creation,
                u.date_modification as user_date_modification
            from client c
            inner join utilisateurs u on u.id_utilisateur = c.id_utilisateur
            where u.id_utilisateur = :id_utilisateur
              and u.role = 'client'";

    return $this->fetchOne($sql, [":id_utilisateur" => $idUtilisateur]);
}
public function selectReservationsDestinationsByUtilisateur(int $idUtilisateur): array
{
    $sql = "select
                rd.id_reservation_destination,
                rd.date_depart,
                rd.date_retour,
                rd.nb_personnes,
                rd.prix_total,
                rd.statut,
                rd.date_reservation,
                d.pays,
                d.ville
            from reservations_destinations rd
            inner join client c on c.id_client = rd.id_client
            inner join destinations d on d.id_destination = rd.id_destination
            where c.id_utilisateur = :id_utilisateur
            order by rd.date_reservation desc";

    return $this->fetchAll($sql, [":id_utilisateur" => $idUtilisateur]);
}

public function selectReservationsVoyagesByUtilisateur(int $idUtilisateur): array
{
    $sql = "select
                rv.id_reservation_voyage,
                rv.nb_personnes,
                rv.prix_total,
                rv.statut,
                rv.date_reservation,
                v.titre,
                v.date_depart,
                v.date_retour,
                d.pays,
                d.ville
            from reservations_voyages rv
            inner join client c on c.id_client = rv.id_client
            inner join voyages_organises v on v.id_voyage = rv.id_voyage
            inner join destinations d on d.id_destination = v.id_destination
            where c.id_utilisateur = :id_utilisateur
            order by rv.date_reservation desc";

    return $this->fetchAll($sql, [":id_utilisateur" => $idUtilisateur]);
}

public function getStatsDashboardAdmin(): array
{
    $sqlClients = "select count(*) as total_clients
                   from utilisateurs
                   where role = 'client'";
    $clients = $this->fetchOne($sqlClients);

    $sqlClientsDesactives = "select count(*) as total_clients_desactives
                             from utilisateurs
                             where role = 'client'
                               and actif = 0";
    $clientsDesactives = $this->fetchOne($sqlClientsDesactives);

    $sqlReservationsDest = "select count(*) as total_resa_dest,
                                   coalesce(sum(prix_total), 0) as total_ca_dest
                            from reservations_destinations";
    $resaDest = $this->fetchOne($sqlReservationsDest);

    $sqlReservationsVoy = "select count(*) as total_resa_voy,
                                  coalesce(sum(prix_total), 0) as total_ca_voy
                           from reservations_voyages";
    $resaVoy = $this->fetchOne($sqlReservationsVoy);

    $totalReservations = (int)($resaDest["total_resa_dest"] ?? 0) + (int)($resaVoy["total_resa_voy"] ?? 0);
    $chiffreAffaires = (float)($resaDest["total_ca_dest"] ?? 0) + (float)($resaVoy["total_ca_voy"] ?? 0);

    return [
        "total_clients" => (int)($clients["total_clients"] ?? 0),
        "total_clients_desactives" => (int)($clientsDesactives["total_clients_desactives"] ?? 0),
        "total_reservations" => $totalReservations,
        "chiffre_affaires" => $chiffreAffaires
    ];
}

}