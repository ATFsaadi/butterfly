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

    // --- Utilisateurs ---
    public function getUserByEmail($email) {
        $sql = "SELECT * FROM utilisateurs WHERE email = :email";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':email' => $email]);  
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($nom, $prenom, $email, $mot_de_passe, $telephone = null, $role = 'client') {
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, telephone, role)
                VALUES (:nom, :prenom, :email, :mot_de_passe, :telephone, :role)";
        $stmt = $this->unPdo->prepare($sql);
        return $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':mot_de_passe' => $mot_de_passe,
            ':telephone' => $telephone,
            ':role' => $role
        ]);
    }

    // --- Voyages ---
    public function getTypesVoyage() {
        $sql = "SELECT * FROM types_voyage ORDER BY nom ASC";
        $stmt = $this->unPdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDestinations() {
        $sql = "SELECT DISTINCT destination FROM voyage ORDER BY destination ASC";
        $stmt = $this->unPdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVillesDepart() {
        $sql = "SELECT DISTINCT ville_depart FROM voyage ORDER BY ville_depart ASC";
        $stmt = $this->unPdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function rechercherVoyages($type = null, $destination = null, $villeDepart = null, $date = null, $duree = null) {
        $sql = "SELECT * FROM voyage WHERE 1=1";
        $params = [];

        if ($type) { $sql .= " AND id_type = :type"; $params[':type'] = $type; }
        if ($destination) { $sql .= " AND destination = :destination"; $params[':destination'] = $destination; }
        if ($villeDepart) { $sql .= " AND ville_depart = :villeDepart"; $params[':villeDepart'] = $villeDepart; }
        if ($date) { $sql .= " AND date_depart >= :date"; $params[':date'] = $date; }
        if ($duree) { $sql .= " AND duree = :duree"; $params[':duree'] = $duree; }

        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
