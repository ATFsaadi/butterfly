<?php
class Modele {
    private PDO $unPdo;

    public function __construct() {
        $url = "mysql:host=localhost;dbname=bfly;charset=utf8mb4";
        $user = "root";
        $mdp = "";

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

    public function getPdo(): PDO {
        return $this->unPdo;
    }

    /* ========================= */
    /* ====== UTILISATEURS ===== */
    /* ========================= */

    public function select_user(string $email): array|false {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function addUser(string $nom, string $prenom, string $email, string $mdp, ?string $telephone = null, string $role = 'client'): bool {
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, role)
                VALUES (:nom, :prenom, :email, :mot_de_passe, :telephone, :role)";
        $stmt = $this->unPdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mdp, // déjà hashé
            ':telephone' => $telephone,
            ':role' => $role
        ]);
    }

    public function getAllUsers(): array {
        $sql = "SELECT * FROM utilisateurs ORDER BY date_creation DESC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    /* ===================== */
    /* ====== SLIDES ======= */
    /* ===================== */

    public function insertSlide(array $tab): void {
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
        $sql = "SELECT * FROM slides ORDER BY ordre ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectSlideById(int $id_slide): array|false {
        $sql = "SELECT * FROM slides WHERE id_slide = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_slide]);
        return $stmt->fetch();
    }

    public function updateSlide(array $tab): void {
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
        $sql = "DELETE FROM slides WHERE id_slide = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_slide]);
    }

    public function selectSlidesActifs(): array {
        $sql = "SELECT * FROM slides WHERE actif = 1 ORDER BY ordre ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    /* ========================= */
    /* ====== CONTINENTS ======= */
    /* ========================= */

    public function selectAllContinents(): array {
        $sql = "SELECT id_continent, nom FROM continents ORDER BY nom ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectContinentById(int $id): array|false {
        $sql = "SELECT id_continent, nom FROM continents WHERE id_continent = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    /* ========================= */
    /* ===== DESTINATIONS ====== */
    /* ========================= */

    public function insertDestination(array $tab): void {
        $sql = "INSERT INTO destinations (nom, id_continent, description, image)
                VALUES (:nom, :id_continent, :description, :image)";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':nom' => $tab['nom'],
            ':id_continent' => (int)$tab['id_continent'],
            ':description' => $tab['description'],
            ':image' => $tab['image']
        ]);
    }

    public function selectAllDestinations(): array {
        $sql = "SELECT d.*, c.nom AS continent_nom
                FROM destinations d
                LEFT JOIN continents c ON c.id_continent = d.id_continent
                ORDER BY d.nom ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectDestinationById(int $id): array|false {
        $sql = "SELECT d.*, c.nom AS continent_nom
                FROM destinations d
                LEFT JOIN continents c ON c.id_continent = d.id_continent
                WHERE d.id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function updateDestination(array $tab): void {
        $sql = "UPDATE destinations
                SET nom = :nom,
                    id_continent = :id_continent,
                    description = :description,
                    image = :image
                WHERE id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([
            ':nom' => $tab['nom'],
            ':id_continent' => (int)$tab['id_continent'],
            ':description' => $tab['description'],
            ':image' => $tab['image'],
            ':id' => $tab['id_destination']
        ]);
    }

    public function deleteDestination(int $id): void {
        $sql = "DELETE FROM destinations WHERE id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id]);
    }

    public function selectDestinationsByContinent(int $id_continent): array {
        $sql = "SELECT d.*, c.nom AS continent_nom
                FROM destinations d
                LEFT JOIN continents c ON c.id_continent = d.id_continent
                WHERE d.id_continent = :id_continent
                ORDER BY d.nom ASC";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id_continent' => $id_continent]);
        return $stmt->fetchAll();
    }
}
?>
