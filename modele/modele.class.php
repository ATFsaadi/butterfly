<?php
class Modele {
    private $unPdo;

    public function __construct() {
        $url = "mysql:host=localhost;dbname=bfly";
        $user = "root";
        $mdp = "";
        try { 
            $this->unPdo = new PDO($url, $user, $mdp);
            $this->unPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exp) {
            echo "Erreur de connexion à " . $url . "<br>";
            echo $exp->getMessage();
            exit();
        }
    }

    public function getPdo() {
        return $this->unPdo;
    }

    // --- Utilisateurs ---
    public function select_user($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':email' => $email]);  
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($nom, $prenom, $email, $mdp, $telephone = null, $role = 'client') {
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, role)
            VALUES (:nom, :prenom, :email, :mot_de_passe, :telephone, :role)";
    $stmt = $this->unPdo->prepare($sql);
    return $stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':email' => $email,
        ':mot_de_passe' => $mdp, // DÉJÀ HASHÉ
        ':telephone' => $telephone,
        ':role' => $role
    ]);
}


    public function getAllUsers() {
        $sql = "SELECT * FROM utilisateurs ORDER BY date_creation DESC";
        $stmt = $this->unPdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        /* ===================== */
    /* ====== SLIDES ======= */
    /* ===================== */

    // Ajouter un slide
    public function insertSlide($tab) {
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

    // Récupérer tous les slides
    public function selectAllSlides() {
        $sql = "SELECT * FROM slides ORDER BY ordre ASC";
        return $this->unPdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un slide
    public function selectSlideById($id_slide) {
        $sql = "SELECT * FROM slides WHERE id_slide = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_slide]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Modifier un slide
    public function updateSlide($tab) {
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

    // Supprimer un slide
    public function deleteSlide($id_slide) {
        $sql = "DELETE FROM slides WHERE id_slide = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_slide]);
    }

    // Slides actifs (FRONT)
    public function selectSlidesActifs() {
        $sql = "SELECT * FROM slides WHERE actif = 1 ORDER BY ordre ASC";
        return $this->unPdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    /* ========================= */
/* ===== DESTINATIONS ===== */
/* ========================= */

public function insertDestination($tab) {
    $sql = "INSERT INTO destinations (nom, continent, description, image)
            VALUES (:nom, :continent, :description, :image)";
    $stmt = $this->unPdo->prepare($sql);
    $stmt->execute([
        ':nom' => $tab['nom'],
        ':continent' => $tab['continent'],
        ':description' => $tab['description'],
        ':image' => $tab['image']
    ]);
}

public function selectAllDestinations() {
    $sql = "SELECT * FROM destinations ORDER BY nom ASC";
    return $this->unPdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

public function selectDestinationById($id) {
    $sql = "SELECT * FROM destinations WHERE id_destination = :id";
    $stmt = $this->unPdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

public function updateDestination($tab) {
    $sql = "UPDATE destinations 
            SET nom = :nom,
                continent = :continent,
                description = :description,
                image = :image
            WHERE id_destination = :id";
    $stmt = $this->unPdo->prepare($sql);
    $stmt->execute([
        ':nom' => $tab['nom'],
        ':continent' => $tab['continent'],
        ':description' => $tab['description'],
        ':image' => $tab['image'],
        ':id' => $tab['id_destination']
    ]);
}

public function deleteDestination($id) {
    $sql = "DELETE FROM destinations WHERE id_destination = :id";
    $stmt = $this->unPdo->prepare($sql);
    $stmt->execute([':id' => $id]);
}


}
?>
