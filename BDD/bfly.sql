
CREATE DATABASE IF NOT EXISTS bfly ;
USE bfly;

--utilisateurs

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


--types_voyage

CREATE TABLE types_voyage (
    idtyp INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- Insertion des types de base
INSERT INTO types_voyage (nom) VALUES
('Séjour'), ('Aventure'), ('Plage'), ('Culture');


--destinations

CREATE TABLE destinations (
    iddest INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


--voyages

CREATE TABLE voyages (
    idvoy INT AUTO_INCREMENT PRIMARY KEY,
    id_destination INT NOT NULL,
    id_type INT,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    duree INT, -- en jours
    prix DECIMAL(10,2) NOT NULL,
    image VARCHAR(255),
    date_depart DATE,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_destination) REFERENCES destinations(iddes) ON DELETE CASCADE,
    FOREIGN KEY (id_type) REFERENCES types_voyage(idtyp) ON DELETE SET NULL
);

--reservations

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
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(iduti) ON DELETE CASCADE,
    FOREIGN KEY (id_voyage) REFERENCES voyages(idvoy) ON DELETE CASCADE
);


--avis

CREATE TABLE avis (
    idavi INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_voyage INT NOT NULL,
    note TINYINT NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(iduti) ON DELETE CASCADE,
    FOREIGN KEY (id_voyage) REFERENCES voyages(idvoy) ON DELETE CASCADE
);


--images_voyage

CREATE TABLE images_voyage (
    idimg INT AUTO_INCREMENT PRIMARY KEY,
    id_voyage INT NOT NULL,
    url_image VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_voyage) REFERENCES voyages(idvoy) ON DELETE CASCADE
);


--offres

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


--contacts

CREATE TABLE contacts (
    idcont INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    sujet VARCHAR(150),
    message TEXT NOT NULL,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP
);
