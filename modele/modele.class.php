<?php
class Modele {

    /* connexion */
    private PDO $unPdo;

    public function __construct() {

        /* configuration base */
        $url = "mysql:host=localhost;dbname=bfly;charset=utf8mb4";
        $user = "root";
        $mdp = "";

        /* connexion pdo */
        try {
            $this->unPdo = new PDO($url, $user, $mdp);
            $this->unPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->unPdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $exp) {
            echo "Erreur de connexion à " . $url . "<br>";
            echo $exp->getMessage();
            exit();
        }
    }

    /* acces pdo */
    public function getPdo(): PDO {
        return $this->unPdo;
    }

    /* utilisateurs */

    public function select_user(string $email): array|false {
        /* requete select utilisateur */
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function addUser(string $nom, string $prenom, string $email, string $mdp, ?string $telephone = null, string $role = 'client'): bool {
        /* requete insertion utilisateur */
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, role)
                VALUES (:nom, :prenom, :email, :mot_de_passe, :telephone, :role)";
        $stmt = $this->unPdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mdp,
            ':telephone' => $telephone,
            ':role' => $role
        ]);
    }

    public function getAllUsers(): array {
        /* requete liste utilisateurs */
        $sql = "SELECT * FROM utilisateurs ORDER BY date_creation DESC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    /* slides */

    public function insertSlide(array $tab): void {
        /* requete insertion slide */
        $sql = "INSERT INTO slides (titre, description, image, lien, ordre, actif)
                VALUES (:titre, :description, :image, :lien, :ordre, :actif)";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':titre' => $tab['titre'],
            ':description' => $tab['description'],
            ':image' => $tab['image'],
            ':lien' => $tab['lien'],
            ':ordre' => $tab['ordre'],
            ':actif' => $tab['actif']
        ]);
    }

    public function selectAllSlides(): array {
        /* requete liste slides */
        $sql = "SELECT * FROM slides ORDER BY ordre ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectSlideById(int $id_slide): array|false {
        /* requete slide par id */
        $sql = "SELECT * FROM slides WHERE id_slide = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_slide]);
        return $stmt->fetch();
    }

    public function updateSlide(array $tab): void {
        /* requete mise a jour slide */
        $sql = "UPDATE slides
                SET titre = :titre,
                    description = :description,
                    image = :image,
                    lien = :lien,
                    ordre = :ordre,
                    actif = :actif
                WHERE id_slide = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':titre' => $tab['titre'],
            ':description' => $tab['description'],
            ':image' => $tab['image'],
            ':lien' => $tab['lien'],
            ':ordre' => $tab['ordre'],
            ':actif' => $tab['actif'],
            ':id' => $tab['id_slide']
        ]);
    }

    public function deleteSlide(int $id_slide): void {
        /* requete suppression slide */
        $sql = "DELETE FROM slides WHERE id_slide = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_slide]);
    }

    public function selectSlidesActifs(): array {
        /* requete slides actifs */
        $sql = "SELECT * FROM slides WHERE actif = 1 ORDER BY ordre ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    /* continents */

    public function selectAllContinents(): array {
        /* requete liste continents */
        $sql = "SELECT id_continent, nom FROM continents ORDER BY nom ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectContinentById(int $id): array|false {
        /* requete continent par id */
        $sql = "SELECT id_continent, nom FROM continents WHERE id_continent = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /* destinations */

    public function insertDestination(array $tab): void {
        /* requete insertion destination */
        $sql = "INSERT INTO destinations (nom, ville, id_continent, description, image)
                VALUES (:nom, :ville, :id_continent, :description, :image)";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':nom' => $tab['nom'],
            ':ville' => $tab['ville'],
            ':id_continent' => (int)$tab['id_continent'],
            ':description' => $tab['description'],
            ':image' => $tab['image']
        ]);
    }

    public function selectAllDestinations(): array {
        /* requete liste destinations */
        $sql = "SELECT d.*, c.nom AS continent_nom
                FROM destinations d
                LEFT JOIN continents c ON c.id_continent = d.id_continent
                ORDER BY d.nom ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectDestinationById(int $id): array|false {
        /* requete destination par id */
        $sql = "SELECT d.*, c.nom AS continent_nom
                FROM destinations d
                LEFT JOIN continents c ON c.id_continent = d.id_continent
                WHERE d.id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function updateDestination(array $tab): void {
        /* requete mise a jour destination */
        $sql = "UPDATE destinations
                SET nom = :nom,
                    ville = :ville,
                    id_continent = :id_continent,
                    description = :description,
                    image = :image
                WHERE id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':nom' => $tab['nom'],
            ':ville' => $tab['ville'],
            ':id_continent' => (int)$tab['id_continent'],
            ':description' => $tab['description'],
            ':image' => $tab['image'],
            ':id' => (int)$tab['id_destination']
        ]);
    }

    public function deleteDestination(int $id): void {
        /* requete suppression destination */
        $sql = "DELETE FROM destinations WHERE id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function selectDestinationsByContinent(int $id_continent): array {
        /* requete destinations par continent */
        $sql = "SELECT d.*, c.nom AS continent_nom
                FROM destinations d
                LEFT JOIN continents c ON c.id_continent = d.id_continent
                WHERE d.id_continent = :id_continent
                ORDER BY d.nom ASC";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id_continent' => $id_continent]);
        return $stmt->fetchAll();
    }

    /* voyages */

    public function selectAllVoyages(): array {
        /* requete liste voyages */
        $sql = "SELECT v.*, d.nom AS destination_nom
                FROM voyages v
                JOIN destinations d ON d.id_destination = v.id_destination
                ORDER BY v.id_voyage DESC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectVoyageById(int $id): array|false {
        /* requete voyage par id */
        $sql = "SELECT v.*, d.nom AS destination_nom
                FROM voyages v
                JOIN destinations d ON d.id_destination = v.id_destination
                WHERE v.id_voyage = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insertVoyage(array $tab): void {
        /* requete insertion voyage */
        $sql = "INSERT INTO voyages (titre, prix_adulte, prix_enfant, prix_bebe, date_depart, date_retour, description, image, id_destination)
                VALUES (:titre, :prix_adulte, :prix_enfant, :prix_bebe, :date_depart, :date_retour, :description, :image, :id_destination)";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':titre' => $tab['titre'],
            ':prix_adulte' => $tab['prix_adulte'],
            ':prix_enfant' => $tab['prix_enfant'],
            ':prix_bebe' => $tab['prix_bebe'],
            ':date_depart' => $tab['date_depart'],
            ':date_retour' => $tab['date_retour'],
            ':description' => $tab['description'],
            ':image' => $tab['image'],
            ':id_destination' => (int)$tab['id_destination']
        ]);
    }

    public function updateVoyage(array $tab): void {
        /* requete mise a jour voyage */
        $sql = "UPDATE voyages
                SET titre = :titre,
                    prix_adulte = :prix_adulte,
                    prix_enfant = :prix_enfant,
                    prix_bebe = :prix_bebe,
                    date_depart = :date_depart,
                    date_retour = :date_retour,
                    description = :description,
                    image = :image,
                    id_destination = :id_destination
                WHERE id_voyage = :id_voyage";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':titre' => $tab['titre'],
            ':prix_adulte' => $tab['prix_adulte'],
            ':prix_enfant' => $tab['prix_enfant'],
            ':prix_bebe' => $tab['prix_bebe'],
            ':date_depart' => $tab['date_depart'],
            ':date_retour' => $tab['date_retour'],
            ':description' => $tab['description'],
            ':image' => $tab['image'],
            ':id_destination' => (int)$tab['id_destination'],
            ':id_voyage' => (int)$tab['id_voyage']
        ]);
    }

    public function deleteVoyage(int $id): void {
        /* requete suppression voyage */
        $sql = "DELETE FROM voyages WHERE id_voyage = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    /* offres */

    public function selectAllOffres(): array {
        /* requete liste offres */
        $sql = "SELECT o.*, v.titre AS voyage_titre
                FROM offres o
                JOIN voyages v ON v.id_voyage = o.id_voyage
                ORDER BY o.date_debut DESC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectOffreById(int $id): array|false {
        /* requete offre par id */
        $sql = "SELECT * FROM offres WHERE id_offre = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function insertOffre(array $tab): void {
        /* requete insertion offre */
        $sql = "INSERT INTO offres (titre, reduction, date_debut, date_fin, description, actif, id_voyage)
                VALUES (:titre, :reduction, :date_debut, :date_fin, :description, :actif, :id_voyage)";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':titre' => $tab['titre'],
            ':reduction' => $tab['reduction'],
            ':date_debut' => $tab['date_debut'],
            ':date_fin' => $tab['date_fin'],
            ':description' => $tab['description'],
            ':actif' => $tab['actif'],
            ':id_voyage' => (int)$tab['id_voyage']
        ]);
    }

    public function updateOffre(array $tab): void {
        /* requete mise a jour offre */
        $sql = "UPDATE offres
                SET titre = :titre,
                    reduction = :reduction,
                    date_debut = :date_debut,
                    date_fin = :date_fin,
                    description = :description,
                    actif = :actif,
                    id_voyage = :id_voyage
                WHERE id_offre = :id_offre";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':titre' => $tab['titre'],
            ':reduction' => $tab['reduction'],
            ':date_debut' => $tab['date_debut'],
            ':date_fin' => $tab['date_fin'],
            ':description' => $tab['description'],
            ':actif' => $tab['actif'],
            ':id_voyage' => (int)$tab['id_voyage'],
            ':id_offre' => (int)$tab['id_offre']
        ]);
    }

    public function deleteOffre(int $id): void {
        /* requete suppression offre */
        $sql = "DELETE FROM offres WHERE id_offre = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function selectOffresActives(): array {
        /* requete offres actives */
        $sql = "SELECT o.*, v.titre AS voyage_titre, v.description AS voyage_description, v.image AS voyage_image,
                       v.prix_adulte, v.prix_enfant, v.prix_bebe
                FROM offres o
                JOIN voyages v ON v.id_voyage = o.id_voyage
                WHERE o.actif = 1
                ORDER BY o.date_debut DESC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    /* reservations */

   public function addReservation(array $tab)
{
    $sql = "INSERT INTO reservations
            (id_utilisateur, id_voyage, date_depart, date_retour, nombre_adultes, nombre_enfants, nombre_bebes, prix_total)
            VALUES (:id_utilisateur, :id_voyage, :date_depart, :date_retour, :adultes, :enfants, :bebes, :prix_total)";

    $stmt = $this->unPdo->prepare($sql);

    $ok = $stmt->execute([
        ':id_utilisateur' => (int)$tab['id_utilisateur'],
        ':id_voyage'      => (int)$tab['id_voyage'],
        ':date_depart'    => $tab['date_depart'] ?? null,
        ':date_retour'    => $tab['date_retour'] ?? null,
        ':adultes'        => (int)($tab['nombre_adultes'] ?? 0),
        ':enfants'        => (int)($tab['nombre_enfants'] ?? 0),
        ':bebes'          => (int)($tab['nombre_bebes'] ?? 0),
        ':prix_total'     => (float)($tab['prix_total'] ?? 0),
    ]);

    if (!$ok) return false;

    return (int)$this->unPdo->lastInsertId(); 
}


    public function selectReservationsByUser(int $id_utilisateur): array
    {
        $sql = "SELECT r.*, v.titre AS voyage_titre, v.image AS voyage_image
                FROM reservations r
                JOIN voyages v ON v.id_voyage = r.id_voyage
                WHERE r.id_utilisateur = :id
                ORDER BY r.date_reservation DESC";

        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_utilisateur]);
        return $stmt->fetchAll();
    }

    public function selectReservationById(int $id_reservation): array|false
    {
        $sql = "SELECT r.*, v.titre AS voyage_titre, v.image AS voyage_image
                FROM reservations r
                JOIN voyages v ON v.id_voyage = r.id_voyage
                WHERE r.id_reservation = :id";

        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_reservation]);
        return $stmt->fetch();
    }

   public function selectAllReservations(): array
{
    $sql = "SELECT r.*, u.nom, u.prenom, v.titre
            FROM reservations r
            JOIN utilisateurs u ON u.idutil = r.id_utilisateur
            JOIN voyages v ON v.id_voyage = r.id_voyage
            ORDER BY r.date_reservation DESC";

    return $this->unPdo->query($sql)->fetchAll();
}


public function confirmReservation(int $id): bool
{
    $sql = "UPDATE reservations SET statut = 'confirmée' WHERE id_reservation = :id";
    $stmt = $this->unPdo->prepare($sql);
    return $stmt->execute([':id' => $id]);
}


}