DROP DATABASE IF EXISTS bfly_ppe;
CREATE DATABASE bfly_ppe
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;
USE bfly_ppe;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP TABLE IF EXISTS reservations_voyages;
DROP TABLE IF EXISTS reservations_destinations;
DROP TABLE IF EXISTS offres;
DROP TABLE IF EXISTS voyages_organises;
DROP TABLE IF EXISTS destinations;
DROP TABLE IF EXISTS continents;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS utilisateurs;


--  utilisateurs

CREATE TABLE utilisateurs (
  id_utilisateur INT UNSIGNED NOT NULL AUTO_INCREMENT,
  email VARCHAR(150) NOT NULL,
  mot_de_passe_hash VARCHAR(255) NOT NULL,
  role ENUM('client','admin') NOT NULL DEFAULT 'client',
  actif TINYINT(1) NOT NULL DEFAULT 1,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_utilisateur),
  UNIQUE KEY uk_utilisateurs_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--  client

CREATE TABLE client (
  id_client INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_utilisateur INT UNSIGNED NOT NULL,
  nom VARCHAR(80) NOT NULL,
  prenom VARCHAR(80) NOT NULL,
  telephone VARCHAR(25) DEFAULT NULL,
  adresse VARCHAR(255) DEFAULT NULL,
  ville VARCHAR(100) DEFAULT NULL,
  pays VARCHAR(100) DEFAULT NULL,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_client),
  UNIQUE KEY uk_client_utilisateur (id_utilisateur),
  CONSTRAINT fk_client_utilisateur
    FOREIGN KEY (id_utilisateur)
    REFERENCES utilisateurs(id_utilisateur)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--  continents

CREATE TABLE continents (
  id_continent INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nom VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_continent),
  UNIQUE KEY uk_continents_nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--  destinations

CREATE TABLE destinations (
  id_destination INT UNSIGNED NOT NULL AUTO_INCREMENT,
  pays VARCHAR(100) NOT NULL,
  ville VARCHAR(100) NOT NULL,
  id_continent INT UNSIGNED DEFAULT NULL,
  description TEXT,
  prix_base DECIMAL(10,2) NOT NULL,
  image_url VARCHAR(255) DEFAULT NULL,
  actif TINYINT(1) NOT NULL DEFAULT 1,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_destination),
  UNIQUE KEY uk_destination_pays_ville (pays, ville),
  KEY idx_destinations_continent (id_continent),
  KEY idx_destinations_actif (actif),
  KEY idx_destinations_pays_ville (pays, ville),
  CONSTRAINT fk_destination_continent
    FOREIGN KEY (id_continent)
    REFERENCES continents(id_continent)
    ON DELETE SET NULL
    ON UPDATE CASCADE,
  CONSTRAINT chk_destinations_prix_base CHECK (prix_base > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--  voyages_organises

CREATE TABLE voyages_organises (
  id_voyage INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_destination INT UNSIGNED NOT NULL,
  titre VARCHAR(150) NOT NULL,
  description TEXT,
  date_depart DATE NOT NULL,
  date_retour DATE NOT NULL,
  prix DECIMAL(10,2) NOT NULL,
  nb_places INT UNSIGNED NOT NULL,
  nb_places_restantes INT UNSIGNED NOT NULL,
  image_url VARCHAR(255) DEFAULT NULL,
  statut ENUM('actif','complet','annule') NOT NULL DEFAULT 'actif',
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_voyage),
  KEY idx_voyage_destination (id_destination),
  KEY idx_voyages_statut_date (statut, date_depart),
  CONSTRAINT fk_voyage_destination
    FOREIGN KEY (id_destination)
    REFERENCES destinations(id_destination)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT chk_voyage_dates CHECK (date_retour >= date_depart),
  CONSTRAINT chk_voyage_prix CHECK (prix > 0),
  CONSTRAINT chk_voyage_nb_places CHECK (nb_places > 0),
  CONSTRAINT chk_voyage_nb_places_restantes CHECK (nb_places_restantes >= 0 AND nb_places_restantes <= nb_places)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--  offres

CREATE TABLE offres (
  id_offre INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_destination INT UNSIGNED NOT NULL,
  titre VARCHAR(150) NOT NULL,
  pourcentage_reduction INT UNSIGNED NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  actif TINYINT(1) NOT NULL DEFAULT 1,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_offre),
  KEY idx_offre_destination (id_destination),
  KEY idx_offres_actif_dates (actif, date_debut, date_fin),
  CONSTRAINT fk_offre_destination
    FOREIGN KEY (id_destination)
    REFERENCES destinations(id_destination)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT chk_offre_dates CHECK (date_fin >= date_debut),
  CONSTRAINT chk_offre_reduction CHECK (pourcentage_reduction > 0 AND pourcentage_reduction <= 100)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--  reservations_destinations

CREATE TABLE reservations_destinations (
  id_reservation_destination INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_client INT UNSIGNED NOT NULL,
  id_destination INT UNSIGNED NOT NULL,
  date_depart DATE NOT NULL,
  date_retour DATE NOT NULL,
  nb_personnes INT UNSIGNED NOT NULL DEFAULT 1,
  prix_total DECIMAL(10,2) NOT NULL,
  statut ENUM('en_attente','confirmee','annulee') NOT NULL DEFAULT 'en_attente',
  date_reservation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_reservation_destination),
  KEY idx_resa_dest_client (id_client),
  KEY idx_resa_dest_destination (id_destination),
  KEY idx_resa_dest_statut (statut),
  CONSTRAINT fk_resa_dest_client
    FOREIGN KEY (id_client)
    REFERENCES client(id_client)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_resa_dest_destination
    FOREIGN KEY (id_destination)
    REFERENCES destinations(id_destination)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT chk_resa_dest_dates CHECK (date_retour >= date_depart),
  CONSTRAINT chk_resa_dest_nb_personnes CHECK (nb_personnes > 0),
  CONSTRAINT chk_resa_dest_prix_total CHECK (prix_total >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


--  reservations_voyages

CREATE TABLE reservations_voyages (
  id_reservation_voyage INT UNSIGNED NOT NULL AUTO_INCREMENT,
  id_client INT UNSIGNED NOT NULL,
  id_voyage INT UNSIGNED NOT NULL,
  nb_personnes INT UNSIGNED NOT NULL DEFAULT 1,
  prix_total DECIMAL(10,2) NOT NULL,
  statut ENUM('en_attente','confirmee','annulee') NOT NULL DEFAULT 'en_attente',
  date_reservation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id_reservation_voyage),
  KEY idx_resa_voy_client (id_client),
  KEY idx_resa_voy_voyage (id_voyage),
  KEY idx_resa_voy_statut (statut),
  CONSTRAINT fk_resa_voy_client
    FOREIGN KEY (id_client)
    REFERENCES client(id_client)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT fk_resa_voy_voyage
    FOREIGN KEY (id_voyage)
    REFERENCES voyages_organises(id_voyage)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT chk_resa_voy_nb_personnes CHECK (nb_personnes > 0),
  CONSTRAINT chk_resa_voy_prix_total CHECK (prix_total >= 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- INSERT continents

INSERT INTO continents (nom) VALUES
('Europe'),
('Afrique'),
('Asie'),
('Amérique du Nord'),
('Amérique du Sud'),
('Océanie');


-- INSERT utilisateurs

INSERT INTO utilisateurs (email, mot_de_passe_hash, role, actif) VALUES
('amine.benali@bfly.com',  '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('sara.kaci@bfly.com',     '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('yasmine.belaid@bfly.com','$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('mehdi.ouali@bfly.com',   '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('lina.cherif@bfly.com',   '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('nassim.haddad@bfly.com', '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('julien.martin@bfly.com', '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('claire.dubois@bfly.com', '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('luca.rossi@bfly.com',    '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('sofia.garcia@bfly.com',  '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('hans.mueller@bfly.com',  '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('emma.johnson@bfly.com',  '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('kei.tanaka@bfly.com',    '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('diego.silva@bfly.com',   '$2y$10$dummyhash000000000000000000000000000000000000000000', 'client', 1),
('admin@bfly.com',         '$2y$10$dummyhash000000000000000000000000000000000000000000', 'admin',  1);


-- INSERT clients

INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Benali', 'Amine', '+213550000001', 'Rue Didouche Mourad', 'Alger', 'Algérie' FROM utilisateurs WHERE email='amine.benali@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Kaci', 'Sara', '+213550000002', 'Boulevard Krim Belkacem', 'Tizi Ouzou', 'Algérie' FROM utilisateurs WHERE email='sara.kaci@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Belaid', 'Yasmine', '+213550000003', 'Rue Larbi Ben M''hidi', 'Oran', 'Algérie' FROM utilisateurs WHERE email='yasmine.belaid@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Ouali', 'Mehdi', '+213550000004', 'Rue Emir Abdelkader', 'Constantine', 'Algérie' FROM utilisateurs WHERE email='mehdi.ouali@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Cherif', 'Lina', '+213550000005', 'Centre-ville', 'Annaba', 'Algérie' FROM utilisateurs WHERE email='lina.cherif@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Haddad', 'Nassim', '+213550000006', 'Rue des Frères', 'Bejaïa', 'Algérie' FROM utilisateurs WHERE email='nassim.haddad@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Martin', 'Julien', '+33600000001', '10 Rue de Lyon', 'Paris', 'France' FROM utilisateurs WHERE email='julien.martin@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Dubois', 'Claire', '+33600000002', '20 Rue Nationale', 'Lille', 'France' FROM utilisateurs WHERE email='claire.dubois@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Rossi', 'Luca', '+390600000003', 'Via Roma 22', 'Rome', 'Italie' FROM utilisateurs WHERE email='luca.rossi@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Garcia', 'Sofia', '+34910000004', 'Calle Mayor 5', 'Madrid', 'Espagne' FROM utilisateurs WHERE email='sofia.garcia@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Mueller', 'Hans', '+49300000005', 'Alexanderplatz 1', 'Berlin', 'Allemagne' FROM utilisateurs WHERE email='hans.mueller@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Johnson', 'Emma', '+442000000006', '221B Baker St', 'London', 'Royaume-Uni' FROM utilisateurs WHERE email='emma.johnson@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Tanaka', 'Kei', '+81300000007', 'Shibuya', 'Tokyo', 'Japon' FROM utilisateurs WHERE email='kei.tanaka@bfly.com';
INSERT INTO client (id_utilisateur, nom, prenom, telephone, adresse, ville, pays)
SELECT id_utilisateur, 'Silva', 'Diego', '+551100000008', 'Av. Paulista', 'São Paulo', 'Brésil' FROM utilisateurs WHERE email='diego.silva@bfly.com';


-- INSERT destinations

INSERT INTO destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
SELECT 'Algérie','Alger', id_continent, 'Capitale, Casbah, baie d''Alger', 180.00, NULL, 1 FROM continents WHERE nom='Afrique';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
SELECT 'Algérie','Oran', id_continent, 'Front de mer, culture et gastronomie', 160.00, NULL, 1 FROM continents WHERE nom='Afrique';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
SELECT 'Algérie','Constantine', id_continent, 'Ville des ponts, patrimoine', 150.00, NULL, 1 FROM continents WHERE nom='Afrique';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
SELECT 'Algérie','Annaba', id_continent, 'Plages et histoire', 155.00, NULL, 1 FROM continents WHERE nom='Afrique';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
SELECT 'Algérie','Tamanrasset', id_continent, 'Sahara, aventure', 220.00, NULL, 1 FROM continents WHERE nom='Afrique';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base, image_url, actif)
SELECT 'Algérie','Bejaïa', id_continent, 'Côte, nature, randonnées', 145.00, NULL, 1 FROM continents WHERE nom='Afrique';

INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'France','Paris', id_continent,'Musées, monuments', 320.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'France','Nice', id_continent,'Riviera, mer', 290.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Espagne','Barcelone', id_continent,'Architecture, plage', 280.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Italie','Rome', id_continent,'Histoire, cuisine', 300.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Portugal','Lisbonne', id_continent,'Ville colorée', 260.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Allemagne','Berlin', id_continent,'Culture et nightlife', 270.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Royaume-Uni','Londres', id_continent,'City trip', 340.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Pays-Bas','Amsterdam', id_continent,'Canaux, musées', 310.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Grèce','Athènes', id_continent,'Antiquité', 275.00 FROM continents WHERE nom='Europe';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Suisse','Genève', id_continent,'Lac, montagne', 360.00 FROM continents WHERE nom='Europe';

INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Japon','Tokyo', id_continent,'Modernité, temples', 520.00 FROM continents WHERE nom='Asie';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Thaïlande','Bangkok', id_continent,'Street food, marchés', 430.00 FROM continents WHERE nom='Asie';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Émirats Arabes Unis','Dubaï', id_continent,'Luxe et désert', 480.00 FROM continents WHERE nom='Asie';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Turquie','Istanbul', id_continent,'Entre deux mondes', 350.00 FROM continents WHERE nom='Asie';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Indonésie','Bali', id_continent,'Plages, détente', 450.00 FROM continents WHERE nom='Asie';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Vietnam','Hanoï', id_continent,'Culture et nature', 410.00 FROM continents WHERE nom='Asie';

INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'USA','New York', id_continent,'City trip', 650.00 FROM continents WHERE nom='Amérique du Nord';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Canada','Montréal', id_continent,'Culture francophone', 590.00 FROM continents WHERE nom='Amérique du Nord';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Mexique','Cancún', id_continent,'Mer et soleil', 520.00 FROM continents WHERE nom='Amérique du Nord';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'USA','Miami', id_continent,'Plage et ambiance', 610.00 FROM continents WHERE nom='Amérique du Nord';

INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Brésil','Rio de Janeiro', id_continent,'Plages, carnaval', 680.00 FROM continents WHERE nom='Amérique du Sud';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Argentine','Buenos Aires', id_continent,'Tango, culture', 640.00 FROM continents WHERE nom='Amérique du Sud';

INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Australie','Sydney', id_continent,'Opéra, plages', 820.00 FROM continents WHERE nom='Océanie';
INSERT INTO destinations (pays, ville, id_continent, description, prix_base) SELECT 'Maroc','Marrakech', id_continent,'Souks, médina', 260.00 FROM continents WHERE nom='Afrique';


-- INSERT voyages

INSERT INTO voyages_organises
(id_destination, titre, description, date_depart, date_retour, prix, nb_places, nb_places_restantes, image_url, statut)
SELECT d.id_destination,
       CONCAT('Séjour à ', d.ville),
       CONCAT('Voyage organisé vers ', d.ville, ' (', d.pays, ')'),
       '2026-06-10','2026-06-17',
       (d.prix_base * 1.8),
       30, 30,
       NULL,'actif'
FROM destinations d
WHERE (d.pays='Algérie' AND d.ville IN ('Alger','Oran','Tamanrasset'))
LIMIT 3;

INSERT INTO voyages_organises
(id_destination, titre, description, date_depart, date_retour, prix, nb_places, nb_places_restantes, image_url, statut)
SELECT d.id_destination,
       CONCAT('City Break ', d.ville),
       CONCAT('Court séjour découverte à ', d.ville),
       '2026-07-05','2026-07-10',
       (d.prix_base * 1.6),
       25, 25,
       NULL,'actif'
FROM destinations d
WHERE d.ville IN ('Paris','Rome','Barcelone','Amsterdam','Londres')
LIMIT 5;

INSERT INTO voyages_organises
(id_destination, titre, description, date_depart, date_retour, prix, nb_places, nb_places_restantes, image_url, statut)
SELECT d.id_destination,
       CONCAT('Évasion ', d.ville),
       CONCAT('Séjour détente et visites à ', d.ville),
       '2026-08-12','2026-08-20',
       (d.prix_base * 1.7),
       20, 20,
       NULL,'actif'
FROM destinations d
WHERE d.ville IN ('Bali','Tokyo','Dubaï','New York','Rio de Janeiro','Marrakech','Nice')
LIMIT 7;


-- INSERT offres

INSERT INTO offres (id_destination, titre, pourcentage_reduction, date_debut, date_fin, actif)
SELECT d.id_destination,
       CONCAT('Promo ', d.ville, ' - 15%'),
       15,
       '2026-04-01','2026-05-15',
       1
FROM destinations d
WHERE d.ville IN ('Alger','Oran','Bejaïa','Paris','Rome','Barcelone','Londres','Nice','Amsterdam','Lisbonne')
LIMIT 10;

INSERT INTO offres (id_destination, titre, pourcentage_reduction, date_debut, date_fin, actif)
SELECT d.id_destination,
       CONCAT('Offre Flash ', d.ville, ' - 20%'),
       20,
       '2026-04-10','2026-06-01',
       1
FROM destinations d
WHERE d.ville IN ('Tokyo','Bali','Dubaï','Istanbul','New York','Miami','Cancún','Rio de Janeiro','Sydney','Marrakech')
LIMIT 10;