<?php

class Modele
{
    private PDO $unPdo;

    public function __construct()
    {
        $url  = "mysql:host=localhost;dbname=agence_voyage;charset=utf8mb4";
        $user = "root";
        $mdp  = "";

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

    /* =========================
       DESTINATIONS (CRUD)
       ========================= */

    public function insertDestination(array $tab): bool
    {
        $sql = "INSERT INTO destinations (pays, ville, continent, description, prix_base, image_url, actif)
                VALUES (:pays, :ville, :continent, :description, :prix_base, :image_url, :actif)";
        $stmt = $this->unPdo->prepare($sql);

        return $stmt->execute([
            ':pays'        => $tab['pays'],
            ':ville'       => $tab['ville'],
            ':continent'   => $tab['continent'] ?? null,
            ':description' => $tab['description'] ?? null,
            ':prix_base'   => (float) $tab['prix_base'],
            ':image_url'   => $tab['image_url'] ?? null,
            ':actif'       => (int) ($tab['actif'] ?? 1),
        ]);
    }

    public function selectAllDestinations(): array
    {
        $sql = "SELECT * FROM destinations ORDER BY pays ASC, ville ASC";
        return $this->unPdo->query($sql)->fetchAll();
    }

    public function selectDestinationById(int $id_destination): array|false
    {
        $sql = "SELECT * FROM destinations WHERE id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute([':id' => $id_destination]);
        return $stmt->fetch();
    }

    public function updateDestination(array $tab): bool
    {
        $sql = "UPDATE destinations
                SET pays = :pays,
                    ville = :ville,
                    continent = :continent,
                    description = :description,
                    prix_base = :prix_base,
                    image_url = :image_url,
                    actif = :actif
                WHERE id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);

        return $stmt->execute([
            ':pays'        => $tab['pays'],
            ':ville'       => $tab['ville'],
            ':continent'   => $tab['continent'] ?? null,
            ':description' => $tab['description'] ?? null,
            ':prix_base'   => (float) $tab['prix_base'],
            ':image_url'   => $tab['image_url'] ?? null,
            ':actif'       => (int) ($tab['actif'] ?? 1),
            ':id'          => (int) $tab['id_destination'],
        ]);
    }

    public function deleteDestination(int $id_destination): bool
    {
        $sql = "DELETE FROM destinations WHERE id_destination = :id";
        $stmt = $this->unPdo->prepare($sql);
        return $stmt->execute([':id' => $id_destination]);
    }

    /* =========================
       RECHERCHE DESTINATIONS (pour la barre)
       ========================= */

    public function searchDestinations(string $q = '', string $continent = '', ?float $prix_max = null): array
    {
        $sql = "SELECT *
                FROM destinations
                WHERE actif = 1";
        $params = [];

        if ($q !== '') {
            $sql .= " AND (pays LIKE :q OR ville LIKE :q OR continent LIKE :q)";
            $params[':q'] = '%' . $q . '%';
        }

        if ($continent !== '') {
            $sql .= " AND continent = :continent";
            $params[':continent'] = $continent;
        }

        if ($prix_max !== null) {
            $sql .= " AND prix_base <= :prix_max";
            $params[':prix_max'] = $prix_max;
        }

        $sql .= " ORDER BY pays ASC, ville ASC";

        $stmt = $this->unPdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function selectDistinctContinents(): array
    {
        $sql = "SELECT DISTINCT continent
                FROM destinations
                WHERE actif = 1 AND continent IS NOT NULL AND continent <> ''
                ORDER BY continent ASC";
        $rows = $this->unPdo->query($sql)->fetchAll();

        return array_map(fn($r) => $r['continent'], $rows);
    }

    /*
      OPTIONNEL : si tu as une table voyages avec une colonne ville_depart
      Sinon, supprime cette méthode et dans ta vue tu mets $villesDepart = []
    */
    public function selectDistinctVillesDepart(): array
    {
        $sql = "SELECT DISTINCT ville_depart
                FROM voyages
                WHERE ville_depart IS NOT NULL AND ville_depart <> ''
                ORDER BY ville_depart ASC";
        $rows = $this->unPdo->query($sql)->fetchAll();

        return array_map(fn($r) => $r['ville_depart'], $rows);
    }
}
