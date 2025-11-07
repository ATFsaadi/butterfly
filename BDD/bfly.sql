-- Création de la base
CREATE DATABASE IF NOT EXISTS bfly CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE bfly;

-- ==============================
-- TABLE : utilisateurs
-- ==============================
CREATE TABLE utilisateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    telephone VARCHAR(20),
    role ENUM('client', 'admin') DEFAULT 'client',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ==============================
-- TABLE : types_voyage (nouvelle table pour plus de flexibilité)
-- ==============================
CREATE TABLE types_voyage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL UNIQUE
);

-- Insertion des types de base
INSERT INTO types_voyage (nom) VALUES
('Séjour'), ('Aventure'), ('Plage'), ('Culture');

-- ==============================
-- TABLE : destinations
-- ==============================
CREATE TABLE destinations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    pays VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ==============================
-- TABLE : voyages
-- ==============================
CREATE TABLE voyages (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    FOREIGN KEY (id_destination) REFERENCES destinations(id) ON DELETE CASCADE,
    FOREIGN KEY (id_type) REFERENCES types_voyage(id) ON DELETE SET NULL
);

CREATE INDEX idx_voyage_destination ON voyages(id_destination);
CREATE INDEX idx_voyage_type ON voyages(id_type);

-- ==============================
-- TABLE : reservations
-- ==============================
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_voyage INT NOT NULL,
    date_depart DATE NOT NULL,
    nombre_personnes INT DEFAULT 1,
    prix_total DECIMAL(10,2) NOT NULL,
    statut ENUM('en_attente','confirmée','annulée') DEFAULT 'en_attente',
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (id_voyage) REFERENCES voyages(id) ON DELETE CASCADE
);

CREATE INDEX idx_reservation_utilisateur ON reservations(id_utilisateur);
CREATE INDEX idx_reservation_voyage ON reservations(id_voyage);

-- ==============================
-- TABLE : avis
-- ==============================
CREATE TABLE avis (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    id_voyage INT NOT NULL,
    note TINYINT NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id) ON DELETE CASCADE,
    FOREIGN KEY (id_voyage) REFERENCES voyages(id) ON DELETE CASCADE
);

-- ==============================
-- TABLE : images_voyage
-- ==============================
CREATE TABLE images_voyage (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_voyage INT NOT NULL,
    url_image VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_voyage) REFERENCES voyages(id) ON DELETE CASCADE
);

-- ==============================
-- TABLE : offres (optionnelle mais utile pour "Nos Offres")
-- ==============================
CREATE TABLE offres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_voyage INT NOT NULL,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    reduction DECIMAL(5,2),
    date_debut DATE,
    date_fin DATE,
    image VARCHAR(255),
    FOREIGN KEY (id_voyage) REFERENCES voyages(id) ON DELETE CASCADE
);

-- ==============================
-- TABLE : contacts (formulaire de contact du site)
-- ==============================
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    sujet VARCHAR(150),
    message TEXT NOT NULL,
    date_envoi DATETIME DEFAULT CURRENT_TIMESTAMP
);
