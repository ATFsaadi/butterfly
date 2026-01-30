CREATE DATABASE IF NOT EXISTS agence_voyage
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE agence_voyage;

-- =========================
-- Table : utilisateurs
-- =========================
CREATE TABLE utilisateurs (
  id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(150) NOT NULL UNIQUE,
  mot_de_passe_hash VARCHAR(255) NOT NULL,
  role ENUM('client','admin') NOT NULL DEFAULT 'client',
  actif TINYINT(1) NOT NULL DEFAULT 1,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- Table : client
-- =========================
CREATE TABLE client (
  id_client INT AUTO_INCREMENT PRIMARY KEY,
  id_utilisateur INT NOT NULL UNIQUE,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  telephone VARCHAR(25),
  adresse VARCHAR(255),
  ville VARCHAR(100),
  pays VARCHAR(100),

  CONSTRAINT fk_client_utilisateur
    FOREIGN KEY (id_utilisateur)
    REFERENCES utilisateurs(id_utilisateur)
    ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================
-- Table : destinations
-- =========================
CREATE TABLE destinations (
  id_destination INT AUTO_INCREMENT PRIMARY KEY,
  pays VARCHAR(100) NOT NULL,
  ville VARCHAR(100) NOT NULL,
  continent VARCHAR(50),
  description TEXT,
  prix_base DECIMAL(10,2) NOT NULL,
  image_url VARCHAR(255),
  actif TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;

-- =========================
-- Table : offres (POURCENTAGE)
-- =========================
CREATE TABLE offres (
  id_offre INT AUTO_INCREMENT PRIMARY KEY,
  id_destination INT NOT NULL,
  titre VARCHAR(150) NOT NULL,
  pourcentage_reduction INT NOT NULL CHECK (pourcentage_reduction BETWEEN 1 AND 100),
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  actif TINYINT(1) NOT NULL DEFAULT 1,

  CONSTRAINT fk_offre_destination
    FOREIGN KEY (id_destination)
    REFERENCES destinations(id_destination)
    ON DELETE CASCADE,

  CONSTRAINT chk_dates_offre
    CHECK (date_fin >= date_debut)
) ENGINE=InnoDB;

-- =========================
-- Table : reservations
-- =========================
CREATE TABLE reservations (
  id_reservation INT AUTO_INCREMENT PRIMARY KEY,
  id_client INT NOT NULL,
  id_destination INT NOT NULL,
  date_depart DATE NOT NULL,
  date_retour DATE NOT NULL,
  nb_personnes INT NOT NULL DEFAULT 1,
  prix_total DECIMAL(10,2) NOT NULL,
  statut ENUM('en_attente','confirmee','annulee') DEFAULT 'en_attente',
  date_reservation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

  CONSTRAINT fk_resa_client
    FOREIGN KEY (id_client)
    REFERENCES client(id_client)
    ON DELETE CASCADE,

  CONSTRAINT fk_resa_destination
    FOREIGN KEY (id_destination)
    REFERENCES destinations(id_destination)
    ON DELETE RESTRICT,

  CONSTRAINT chk_dates_resa
    CHECK (date_retour >= date_depart)
) ENGINE=InnoDB;

-- =========================
-- Table : slides
-- =========================
CREATE TABLE slides (
  id_slide INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(150) NOT NULL,
  sous_titre VARCHAR(255),
  image_url VARCHAR(255) NOT NULL,
  ordre INT NOT NULL DEFAULT 1,
  actif TINYINT(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB;
