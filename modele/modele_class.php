<?php

class Modele
{
    private PDO $pdo;

    public function __construct()
    {
        $dsn = "mysql:host=localhost;dbname=agence_bfly;charset=utf8mb4";
        $user = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dsn, $user, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException $e) {
            echo "erreur de connexion à " . $dsn . "<br>";
            echo $e->getMessage();
            exit();
        }
    }

    // pdo

    private function fetchOne(string $sql, array $params = []): array|false
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function fetchAll(string $sql, array $params = []): array
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function execute(string $sql, array $params = []): void
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
    }

    // utilisateurs et authentification

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

    // clients

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

    // inscription complete

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
            $this->pdo->rollBack();
            echo "erreur inscription : " . $e->getMessage();
            return false;
        }
    }

    // continents

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

    // destinations

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

    // offres

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

    // reservations

    public function insert_reservation(array $tab): void
    {
        $sql = "insert into reservations
                (id_client, id_destination, date_depart, date_retour, nb_personnes, prix_total, statut)
                values
                (:id_client, :id_destination, :date_depart, :date_retour, :nb_personnes, :prix_total, 'en_attente')";
        $this->execute($sql, [
            ":id_client" => $tab["id_client"],
            ":id_destination" => $tab["id_destination"],
            ":date_depart" => $tab["date_depart"],
            ":date_retour" => $tab["date_retour"],
            ":nb_personnes" => $tab["nb_personnes"],
            ":prix_total" => $tab["prix_total"],
        ]);
    }

    public function selectAll_reservations(): array
    {
        $sql = "select r.*, c.nom, c.prenom, d.pays, d.ville, cont.nom as continent
                from reservations r
                join client c on c.id_client = r.id_client
                join destinations d on d.id_destination = r.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                order by r.date_reservation desc";
        return $this->fetchAll($sql);
    }

    public function selectWhere_reservations_by_client(int $id_client): array
    {
        $sql = "select r.*, d.pays, d.ville, d.image_url, cont.nom as continent
                from reservations r
                join destinations d on d.id_destination = r.id_destination
                left join continents cont on cont.id_continent = d.id_continent
                where r.id_client = :id_client
                order by r.date_reservation desc";
        return $this->fetchAll($sql, [":id_client" => $id_client]);
    }

    public function update_reservation_statut(array $tab): void
    {
        $sql = "update reservations
                set statut = :statut
                where id_reservation = :id_reservation";
        $this->execute($sql, [
            ":id_reservation" => $tab["id_reservation"],
            ":statut" => $tab["statut"],
        ]);
    }

    // slides

    public function insert_slide(array $tab): void
    {
        $sql = "insert into slides (titre, sous_titre, image_url, ordre, actif)
                values (:titre, :sous_titre, :image_url, :ordre, 1)";
        $this->execute($sql, [
            ":titre" => $tab["titre"],
            ":sous_titre" => $tab["sous_titre"] ?? null,
            ":image_url" => $tab["image_url"],
            ":ordre" => $tab["ordre"] ?? 1,
        ]);
    }

    public function selectAll_slides(): array
    {
        $sql = "select *
                from slides
                order by ordre asc";
        return $this->fetchAll($sql);
    }

    public function selectAll_slides_actifs(): array
    {
        $sql = "select *
                from slides
                where actif = 1
                order by ordre asc";
        return $this->fetchAll($sql);
    }

    public function selectWhere_slide(int $id_slide): array|false
    {
        $sql = "select *
                from slides
                where id_slide = :id_slide";
        return $this->fetchOne($sql, [":id_slide" => $id_slide]);
    }

    public function update_slide(array $tab): void
    {
        $sql = "update slides
                set titre = :titre,
                    sous_titre = :sous_titre,
                    image_url = :image_url,
                    ordre = :ordre,
                    actif = :actif
                where id_slide = :id_slide";
        $this->execute($sql, [
            ":id_slide" => $tab["id_slide"],
            ":titre" => $tab["titre"],
            ":sous_titre" => $tab["sous_titre"] ?? null,
            ":image_url" => $tab["image_url"],
            ":ordre" => $tab["ordre"],
            ":actif" => $tab["actif"] ?? 1,
        ]);
    }

    public function delete_slide(int $id_slide): void
    {
        $sql = "update slides
                set actif = 0
                where id_slide = :id_slide";
        $this->execute($sql, [":id_slide" => $id_slide]);
    }
}
