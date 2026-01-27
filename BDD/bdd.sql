

CREATE DATABASE IF NOT EXISTS bfly
USE bfly;

DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS offres;
DROP TABLE IF EXISTS voyages;
DROP TABLE IF EXISTS destinations;
DROP TABLE IF EXISTS continents;
DROP TABLE IF EXISTS slides;
DROP TABLE IF EXISTS utilisateurs;

CREATE TABLE continents (
  id_continent INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB;

INSERT INTO continents VALUES
(1,'Afrique'),(2,'Amérique du Nord'),(3,'Amérique du Sud'),
(4,'Asie'),(5,'Europe'),(6,'Océanie');

CREATE TABLE destinations (
  id_destination INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(100) NOT NULL,
  ville VARCHAR(100) NOT NULL,
  description TEXT,
  image VARCHAR(255),
  id_continent INT
) ENGINE=InnoDB;


CREATE TABLE voyages (
  id_voyage INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(100) NOT NULL,
  prix_adulte DECIMAL(10,2) NOT NULL,
  prix_enfant DECIMAL(10,2) NOT NULL,
  prix_bebe DECIMAL(10,2) NOT NULL,
  duree INT NOT NULL,
  description TEXT,
  image VARCHAR(255),
  id_destination INT NOT NULL,
  ville_depart VARCHAR(100) DEFAULT 'Paris',
  prix DECIMAL(10,2) NOT NULL DEFAULT 0,
  date_depart DATE,
  date_retour DATE
) ENGINE=InnoDB;


CREATE TABLE offres (
  id_offre INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(150) NOT NULL,
  reduction INT NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  description TEXT,
  actif TINYINT(1) DEFAULT 1,
  id_voyage INT NOT NULL
) ENGINE=MyISAM;


CREATE TABLE utilisateurs (
  idutil INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  telephone VARCHAR(20),
  role ENUM('client','admin') DEFAULT 'client',
  date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;



CREATE TABLE slides (
  id_slide INT AUTO_INCREMENT PRIMARY KEY,
  titre VARCHAR(100) NOT NULL,
  description TEXT,
  image VARCHAR(255) NOT NULL,
  lien VARCHAR(255),
  ordre INT DEFAULT 0,
  actif TINYINT(1) DEFAULT 1
) ENGINE=InnoDB;



CREATE TABLE reservations (
  id_reservation INT AUTO_INCREMENT PRIMARY KEY,
  id_utilisateur INT NOT NULL,
  id_voyage INT NOT NULL,
  nombre_adultes INT DEFAULT 0,
  nombre_enfants INT DEFAULT 0,
  nombre_bebes INT DEFAULT 0,
  date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
  statut ENUM('en attente','confirmée') DEFAULT 'en attente'
) ENGINE=InnoDB;

ALTER TABLE destinations
  ADD CONSTRAINT fk_destinations_continents
  FOREIGN KEY (id_continent) REFERENCES continents(id_continent)
  ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE voyages
  ADD CONSTRAINT voyages_ibfk_1
  FOREIGN KEY (id_destination) REFERENCES destinations(id_destination);

ALTER TABLE reservations
  ADD CONSTRAINT reservations_ibfk_1
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(idutil),
  ADD CONSTRAINT reservations_ibfk_2
  FOREIGN KEY (id_voyage) REFERENCES voyages(id_voyage);

COMMIT;
