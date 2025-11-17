
Utilisateurs (clients/admins)

Voyages (séjour avec hôtel et vol, prix, durée, date de départ)

Types de voyage (Séjour, Aventure, Plage, Culture)

Destinations (pays, ville, description, image)



Réservations (par utilisateur, nombre de personnes, prix total, statut)

Avis (notes et commentaires par voyage et utilisateur)

Images supplémentaires pour chaque voyage

Offres (réductions, dates, image)


DROP DATABASE IF EXISTS bfly;
CREATE DATABASE bfly;
USE bfly;


-- UTILISATEURS

CREATE TABLE utilisateurs (
    idutil INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    role ENUM('client', 'admin') DEFAULT 'client',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- TYPES DE VOYAGE

CREATE TABLE types_voyage (
    idtyp INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- Insertion des types de base
INSERT INTO types_voyage (nom) VALUES
('Séjour'), ('Aventure'), ('Plage'), ('Culture');


-- DESTINATIONS

CREATE TABLE destinations (
    iddest INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    type_destination ENUM('ville','plage','montagne','culture','autre') DEFAULT 'ville',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


-- VOYAGES

CREATE TABLE voyages (
    idvoy INT AUTO_INCREMENT PRIMARY KEY,
    id_destination INT NOT NULL,
    id_type INT,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    duree INT,
    prix DECIMAL(10,2) NOT NULL,
    hotel VARCHAR(100),
    vol VARCHAR(100),
    image VARCHAR(255),
    date_depart DATE,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_destination) REFERENCES destinations(iddest) ON DELETE CASCADE,
    FOREIGN KEY (id_type) REFERENCES types_voyage(idtyp) ON DELETE SET NULL
);


-- RESERVATIONS

CREATE TABLE reservations (
    idreserv INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_voyage INT NOT NULL,
    date_depart DATE NOT NULL,
    nombre_personnes INT DEFAULT 1,
    prix_total DECIMAL(10,2) NOT NULL,
    statut ENUM('en_attente','confirmée','annulée') DEFAULT 'en_attente',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(idutil) ON DELETE CASCADE,
    FOREIGN KEY (id_voyage) REFERENCES voyages(idvoy) ON DELETE CASCADE
);


-- AVIS

CREATE TABLE avis (
    idavi INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_voyage INT NOT NULL,
    note TINYINT NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(idutil) ON DELETE CASCADE,
    FOREIGN KEY (id_voyage) REFERENCES voyages(idvoy) ON DELETE CASCADE
);


-- IMAGES DES VOYAGES

CREATE TABLE images_voyage (
    idimg INT AUTO_INCREMENT PRIMARY KEY,
    id_voyage INT NOT NULL,
    url_image VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_voyage) REFERENCES voyages(idvoy) ON DELETE CASCADE
);


-- OFFRES

CREATE TABLE offres (
    idoff INT AUTO_INCREMENT PRIMARY KEY,
    id_voyage INT NOT NULL,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    reduction DECIMAL(5,2),
    date_debut DATE,
    date_fin DATE,
    image VARCHAR(255),
    FOREIGN KEY (id_voyage) REFERENCES voyages(idvoy) ON DELETE CASCADE
);
