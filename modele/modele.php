<?php
class Modele {
    private $unPdo;

    // Constructeur : connexion à la base de données
    public function __construct() {
        $url = "mysql:host=localhost;dbname=bfly";
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
}
    ?>