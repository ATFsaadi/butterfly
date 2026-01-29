
CREATE DATABASE bfly
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

-- DESTINATIONS

INSERT INTO destinations (nom, ville, description, image, id_continent) VALUES
('Safari Kenya', 'Nairobi', 'Découverte de la faune africaine', 'kenya.jpg', 1),
('New York City', 'New York', 'La ville qui ne dort jamais', 'ny.jpg', 2),
('Rio de Janeiro', 'Rio', 'Plages et carnaval', 'rio.jpg', 3),
('Tokyo Experience', 'Tokyo', 'Tradition et modernité', 'tokyo.jpg', 4),
('Rome Antique', 'Rome', 'Histoire et gastronomie', 'rome.jpg', 5);


-- VOYAGES

INSERT INTO voyages
(titre, prix_adulte, prix_enfant, prix_bebe, duree, description, image, id_destination, ville_depart, prix, date_depart, date_retour)
VALUES
('Safari Aventure', 1800, 1200, 300, 10, 'Safari au cœur du Kenya', 'safari.jpg', 1, 'Paris', 1800, '2026-03-10', '2026-03-20'),
('City Trip NYC', 1200, 800, 200, 7, 'Voyage urbain à New York', 'ny_trip.jpg', 2, 'Paris', 1200, '2026-04-05', '2026-04-12'),
('Brésil Festif', 1500, 1000, 250, 9, 'Rio et ses plages', 'rio_trip.jpg', 3, 'Paris', 1500, '2026-05-01', '2026-05-10'),
('Tokyo Immersion', 2000, 1400, 400, 12, 'Culture japonaise complète', 'tokyo_trip.jpg', 4, 'Paris', 2000, '2026-06-15', '2026-06-27'),
('Rome Culture', 900, 600, 150, 5, 'Visite historique de Rome', 'rome_trip.jpg', 5, 'Paris', 900, '2026-07-10', '2026-07-15');


-- OFFRES

INSERT INTO offres (titre, reduction, date_debut, date_fin, description, actif, id_voyage) VALUES
('Promo Safari', 15, '2026-01-01', '2026-02-01', 'Réduction safari Kenya', 1, 1),
('NY Deal', 10, '2026-02-01', '2026-03-01', 'Offre spéciale New York', 1, 2),
('Carnaval Rio', 20, '2026-03-01', '2026-04-01', 'Promo carnaval', 1, 3),
('Tokyo Spring', 12, '2026-04-01', '2026-05-01', 'Promo printemps Japon', 1, 4),
('Rome Express', 8, '2026-05-01', '2026-06-01', 'Week-end romain', 1, 5);


-- SLIDES

INSERT INTO slides (titre, description, image, lien, ordre, actif) VALUES
('Safari Kenya', 'Explorez l’Afrique sauvage', 'slide1.jpg', '#safari', 1, 1),
('New York', 'La ville mythique', 'slide2.jpg', '#ny', 2, 1),
('Rio', 'Soleil et fête', 'slide3.jpg', '#rio', 3, 1),
('Tokyo', 'Tradition et futur', 'slide4.jpg', '#tokyo', 4, 1),
('Rome', 'Voyage dans le temps', 'slide5.jpg', '#rome', 5, 1);


CREATE TABLE reservations (
  id_reservation INT AUTO_INCREMENT PRIMARY KEY,
  id_utilisateur INT NOT NULL,
  id_voyage INT NOT NULL,
  date_depart DATE NULL,
  date_retour DATE NULL,
  nombre_adultes INT DEFAULT 0,
  nombre_enfants INT DEFAULT 0,
  nombre_bebes INT DEFAULT 0,
  prix_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
  statut ENUM('en attente','confirmée','annulée') DEFAULT 'en attente'
) ENGINE=InnoDB;

ALTER TABLE reservations
ADD paiement_statut VARCHAR(20) NOT NULL DEFAULT 'non payé';
