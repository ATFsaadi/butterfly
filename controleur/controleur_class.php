<?php
require_once __DIR__ . '/../modele/modele_class.php';

class Controleur
{
    private Modele $unModele;

    public function __construct()
    {
        $this->unModele = new Modele();
    }

    /* =========================
       SÉCURITÉ
       ========================= */

    public function verifConnexion(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user'])) {
            header('Location: index.php?page=home');
            exit();
        }
    }

    public function verifAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] ?? '') !== 'admin') {
            header('Location: index.php?page=home');
            exit();
        }
    }

    /* =========================
       DESTINATIONS
       ========================= */

    public function addDestination(array $tab): bool
    {
        return $this->unModele->insertDestination($tab);
    }

    public function getAllDestinations(): array
    {
        return $this->unModele->selectAllDestinations();
    }

    public function getDestinationById(int $id_destination): array|false
    {
        return $this->unModele->selectDestinationById($id_destination);
    }

    public function updateDestination(array $tab): bool
    {
        return $this->unModele->updateDestination($tab);
    }

    public function deleteDestination(int $id_destination): bool
    {
        return $this->unModele->deleteDestination($id_destination);
    }

    /* =========================
       RECHERCHE (barre)
       ========================= */

    public function searchDestinations(string $q = '', string $continent = '', ?float $prix_max = null): array
    {
        return $this->unModele->searchDestinations($q, $continent, $prix_max);
    }

    public function getDistinctContinents(): array
    {
        return $this->unModele->selectDistinctContinents();
    }

    public function getDistinctVillesDepart(): array
    {
        return $this->unModele->selectDistinctVillesDepart();
    }
}
