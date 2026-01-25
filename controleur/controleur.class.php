<?php
require_once __DIR__ . '/../modele/modele.class.php'; // chemin correct selon ton arborescence

class Controleur {
    private $unModele;

    public function __construct() {
        $this->unModele = new Modele();
    }

    // Vérification de connexion
    public function verifConnexion() {
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=login');
            exit();
        }
    }

    // --- Utilisateurs ---
    public function select_user($email) {
        return $this->unModele->select_user($email);
    }

    public function addUser($nom, $prenom, $email, $mdp, $telephone = null, $role = 'client') {
        return $this->unModele->addUser($nom, $prenom, $email, $mdp, $telephone, $role);
    }
}
?>
