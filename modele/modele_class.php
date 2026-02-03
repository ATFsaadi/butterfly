<?php
class Modele
{
    private $unPdo;

    public function __construct()
    {
        $url = "mysql:host=localhost;dbname=agence_voyage;charset=utf8mb4";
        $user = "root";
        $mdp = "";

        try {
            $this->unPdo = new PDO($url, $user, $mdp);
            $this->unPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exp) {
            echo "Erreur de Connexion à " . $url . "<br>";
            echo $exp->getMessage();
            exit();
        }
    }

    /* =========================
       UTILISATEURS / AUTH
    ========================== */

    public function select_user_login($email)
    {
        $requete = "SELECT * FROM utilisateurs WHERE email = :email AND actif = 1";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":email" => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectWhere_utilisateur_by_email($email)
    {
        $requete = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":email" => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert_utilisateur($tab)
    {
        $requete = "INSERT INTO utilisateurs (email, mot_de_passe_hash, role, actif)
                    VALUES (:email, :hash, :role, 1)";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":email" => $tab["email"],
            ":hash"  => $tab["mot_de_passe_hash"],
            ":role"  => $tab["role"] ?? "client"
        ]);
    }

    /* =========================
       CLIENT
    ========================== */

    public function insert_client($tab)
    {
        $requete = "INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
                    VALUES (:id_utilisateur, :nom, :prenom, :telephone, :adresse, :ville, :pays)";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":id_utilisateur" => $tab["id_utilisateur"],
            ":nom" => $tab["nom"],
            ":prenom" => $tab["prenom"],
            ":telephone" => $tab["telephone"] ?? null,
            ":adresse" => $tab["adresse"] ?? null,
            ":ville" => $tab["ville"] ?? null,
            ":pays" => $tab["pays"] ?? null
        ]);
    }

    public function selectWhere_client_by_user($id_utilisateur)
    {
        $requete = "SELECT * FROM client WHERE id_utilisateur = :id_utilisateur";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_utilisateur" => $id_utilisateur]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       INSCRIPTION COMPLETE
    ========================== */

    public function inscription_complete($userTab, $clientTab)
    {
        try {
            $this->unPdo->beginTransaction();

            $this->insert_utilisateur($userTab);
            $idUser = $this->unPdo->lastInsertId();

            $clientTab["id_utilisateur"] = $idUser;
            $this->insert_client($clientTab);
            $idClient = $this->unPdo->lastInsertId();

            $this->unPdo->commit();
            return ["id_utilisateur" => $idUser, "id_client" => $idClient];
        } catch (Exception $e) {
            $this->unPdo->rollBack();
            echo "Erreur inscription : " . $e->getMessage();
            return false;
        }
    }

    /* =========================
       CONTINENTS
    ========================== */

    public function selectAll_continents()
    {
        $requete = "SELECT * FROM continents ORDER BY nom ASC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhere_continent($id_continent)
    {
        $requete = "SELECT * FROM continents WHERE id_continent = :id_continent";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_continent" => $id_continent]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       DESTINATIONS
    ========================== */

    public function insert_destination($tab)
    {
        $requete = "INSERT INTO destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
                    VALUES (:pays, :ville, :id_continent, :description, :prix_base, :image_url, 1)";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":pays" => $tab["pays"],
            ":ville" => $tab["ville"],
            ":id_continent" => $tab["id_continent"] ?? null,
            ":description" => $tab["description"] ?? null,
            ":prix_base" => $tab["prix_base"],
            ":image_url" => $tab["image_url"] ?? null
        ]);
    }

    // client: seulement actif=1
    public function selectAll_destinations()
    {
        $requete = "SELECT d.*, c.nom AS continent
                    FROM destinations d
                    LEFT JOIN continents c ON c.id_continent = d.id_continent
                    WHERE d.actif = 1
                    ORDER BY d.pays, d.ville";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // admin: affiche tout (actif et inactif)
    public function selectAll_destinations_admin()
    {
        $requete = "SELECT d.*, c.nom AS continent
                    FROM destinations d
                    LEFT JOIN continents c ON c.id_continent = d.id_continent
                    ORDER BY d.actif DESC, d.pays, d.ville";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectLike_destination($filtre)
    {
        $requete = "SELECT d.*, c.nom AS continent
                    FROM destinations d
                    LEFT JOIN continents c ON c.id_continent = d.id_continent
                    WHERE d.actif = 1
                      AND (d.pays LIKE :filtre OR d.ville LIKE :filtre OR c.nom LIKE :filtre)
                    ORDER BY d.pays, d.ville";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":filtre" => "%" . $filtre . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhere_destination($id_destination)
    {
        $requete = "SELECT d.*, c.nom AS continent
                    FROM destinations d
                    LEFT JOIN continents c ON c.id_continent = d.id_continent
                    WHERE d.id_destination = :id_destination";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_destination" => $id_destination]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update_destination($tab)
    {
        $requete = "UPDATE destinations
                    SET pays = :pays,
                        ville = :ville,
                        id_continent = :id_continent,
                        description = :description,
                        prix_base = :prix_base,
                        image_url = :image_url,
                        actif = :actif
                    WHERE id_destination = :id_destination";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":id_destination" => $tab["id_destination"],
            ":pays" => $tab["pays"],
            ":ville" => $tab["ville"],
            ":id_continent" => $tab["id_continent"] ?? null,
            ":description" => $tab["description"] ?? null,
            ":prix_base" => $tab["prix_base"],
            ":image_url" => $tab["image_url"] ?? null,
            ":actif" => $tab["actif"] ?? 1
        ]);
    }

    public function delete_destination($id_destination)
    {
        $requete = "UPDATE destinations SET actif = 0 WHERE id_destination = :id_destination";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_destination" => $id_destination]);
    }

    /* =========================
       OFFRES
    ========================== */

    public function insert_offre($tab)
    {
        $requete = "INSERT INTO offres (id_destination, titre, pourcentage_reduction, date_debut, date_fin, actif)
                    VALUES (:id_destination, :titre, :pourcentage, :date_debut, :date_fin, 1)";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":id_destination" => $tab["id_destination"],
            ":titre" => $tab["titre"],
            ":pourcentage" => $tab["pourcentage_reduction"],
            ":date_debut" => $tab["date_debut"],
            ":date_fin" => $tab["date_fin"]
        ]);
    }

    public function selectAll_offres()
    {
        $requete = "SELECT o.*, d.pays, d.ville, cont.nom AS continent
                    FROM offres o
                    JOIN destinations d ON d.id_destination = o.id_destination
                    LEFT JOIN continents cont ON cont.id_continent = d.id_continent
                    ORDER BY o.date_debut DESC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectLike_offre($filtre)
    {
        $requete = "SELECT o.*, d.pays, d.ville, cont.nom AS continent
                    FROM offres o
                    JOIN destinations d ON d.id_destination = o.id_destination
                    LEFT JOIN continents cont ON cont.id_continent = d.id_continent
                    WHERE o.titre LIKE :filtre OR d.pays LIKE :filtre OR d.ville LIKE :filtre OR cont.nom LIKE :filtre
                    ORDER BY o.date_debut DESC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":filtre" => "%" . $filtre . "%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhere_offre($id_offre)
    {
        $requete = "SELECT * FROM offres WHERE id_offre = :id_offre";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_offre" => $id_offre]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update_offre($tab)
    {
        $requete = "UPDATE offres
                    SET id_destination = :id_destination, titre = :titre,
                        pourcentage_reduction = :pourcentage, date_debut = :date_debut,
                        date_fin = :date_fin, actif = :actif
                    WHERE id_offre = :id_offre";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":id_offre" => $tab["id_offre"],
            ":id_destination" => $tab["id_destination"],
            ":titre" => $tab["titre"],
            ":pourcentage" => $tab["pourcentage_reduction"],
            ":date_debut" => $tab["date_debut"],
            ":date_fin" => $tab["date_fin"],
            ":actif" => $tab["actif"] ?? 1
        ]);
    }

    public function delete_offre($id_offre)
    {
        $requete = "UPDATE offres SET actif = 0 WHERE id_offre = :id_offre";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_offre" => $id_offre]);
    }

    public function selectAll_offres_actives()
    {
        $requete = "SELECT o.*, d.pays, d.ville, d.image_url, d.prix_base, cont.nom AS continent
                    FROM offres o
                    JOIN destinations d ON d.id_destination = o.id_destination
                    LEFT JOIN continents cont ON cont.id_continent = d.id_continent
                    WHERE o.actif = 1
                      AND d.actif = 1
                      AND CURDATE() BETWEEN o.date_debut AND o.date_fin
                    ORDER BY o.date_debut DESC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhere_offre_active_by_destination($id_destination)
    {
        $requete = "SELECT *
                    FROM offres
                    WHERE actif = 1
                      AND id_destination = :id_destination
                      AND CURDATE() BETWEEN date_debut AND date_fin
                    LIMIT 1";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_destination" => $id_destination]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =========================
       RESERVATIONS
    ========================== */

    public function insert_reservation($tab)
    {
        $requete = "INSERT INTO reservations
                    (id_client, id_destination, date_depart, date_retour, nb_personnes, prix_total, statut)
                    VALUES
                    (:id_client, :id_destination, :date_depart, :date_retour, :nb_personnes, :prix_total, 'en_attente')";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":id_client" => $tab["id_client"],
            ":id_destination" => $tab["id_destination"],
            ":date_depart" => $tab["date_depart"],
            ":date_retour" => $tab["date_retour"],
            ":nb_personnes" => $tab["nb_personnes"],
            ":prix_total" => $tab["prix_total"]
        ]);
    }

    public function selectAll_reservations()
    {
        $requete = "SELECT r.*, c.nom, c.prenom, d.pays, d.ville, cont.nom AS continent
                    FROM reservations r
                    JOIN client c ON c.id_client = r.id_client
                    JOIN destinations d ON d.id_destination = r.id_destination
                    LEFT JOIN continents cont ON cont.id_continent = d.id_continent
                    ORDER BY r.date_reservation DESC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhere_reservations_by_client($id_client)
    {
        $requete = "SELECT r.*, d.pays, d.ville, d.image_url, cont.nom AS continent
                    FROM reservations r
                    JOIN destinations d ON d.id_destination = r.id_destination
                    LEFT JOIN continents cont ON cont.id_continent = d.id_continent
                    WHERE r.id_client = :id_client
                    ORDER BY r.date_reservation DESC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_client" => $id_client]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update_reservation_statut($tab)
    {
        $requete = "UPDATE reservations
                    SET statut = :statut
                    WHERE id_reservation = :id_reservation";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":id_reservation" => $tab["id_reservation"],
            ":statut" => $tab["statut"]
        ]);
    }

    /* =========================
       SLIDES
    ========================== */

    public function insert_slide($tab)
    {
        $requete = "INSERT INTO slides (titre, sous_titre, image_url, ordre, actif)
                    VALUES (:titre, :sous_titre, :image_url, :ordre, 1)";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":titre" => $tab["titre"],
            ":sous_titre" => $tab["sous_titre"] ?? null,
            ":image_url" => $tab["image_url"],
            ":ordre" => $tab["ordre"] ?? 1
        ]);
    }

    public function selectAll_slides()
    {
        $requete = "SELECT * FROM slides ORDER BY ordre ASC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectAll_slides_actifs()
    {
        $requete = "SELECT * FROM slides WHERE actif = 1 ORDER BY ordre ASC";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhere_slide($id_slide)
    {
        $requete = "SELECT * FROM slides WHERE id_slide = :id_slide";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_slide" => $id_slide]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update_slide($tab)
    {
        $requete = "UPDATE slides
                    SET titre = :titre, sous_titre = :sous_titre, image_url = :image_url,
                        ordre = :ordre, actif = :actif
                    WHERE id_slide = :id_slide";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([
            ":id_slide" => $tab["id_slide"],
            ":titre" => $tab["titre"],
            ":sous_titre" => $tab["sous_titre"] ?? null,
            ":image_url" => $tab["image_url"],
            ":ordre" => $tab["ordre"],
            ":actif" => $tab["actif"] ?? 1
        ]);
    }

    public function delete_slide($id_slide)
    {
        $requete = "UPDATE slides SET actif = 0 WHERE id_slide = :id_slide";
        $stmt = $this->unPdo->prepare($requete);
        $stmt->execute([":id_slide" => $id_slide]);
    }
}
?>
