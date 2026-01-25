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
            ':mot_de_passe' => password_hash($mdp, PASSWORD_DEFAULT),
            ':telephone' => $telephone,
            ':role' => $role
        ]);
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM utilisateurs ORDER BY date_creation DESC";
        $stmt = $this->unPdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
