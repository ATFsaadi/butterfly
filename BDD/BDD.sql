SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

DROP DATABASE IF EXISTS agence_bfly;
CREATE DATABASE agence_bfly CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agence_bfly;

START TRANSACTION;

DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS offres;
DROP TABLE IF EXISTS client;
DROP TABLE IF EXISTS destinations;
DROP TABLE IF EXISTS continents;
DROP TABLE IF EXISTS slides;
DROP TABLE IF EXISTS utilisateurs;

CREATE TABLE IF NOT EXISTS utilisateurs (
  id_utilisateur INT NOT NULL AUTO_INCREMENT,
  email VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  mot_de_passe_hash VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  role ENUM('client','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  actif TINYINT(1) NOT NULL DEFAULT 1,
  date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_utilisateur),
  UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS client (
  id_client INT NOT NULL AUTO_INCREMENT,
  id_utilisateur INT NOT NULL,
  nom VARCHAR(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  prenom VARCHAR(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  telephone VARCHAR(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  adresse VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  ville VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  pays VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (id_client),
  UNIQUE KEY id_utilisateur (id_utilisateur)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS continents (
  id_continent INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (id_continent),
  UNIQUE KEY nom (nom)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS destinations (
  id_destination INT NOT NULL AUTO_INCREMENT,
  pays VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  ville VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  id_continent INT DEFAULT NULL,
  description TEXT COLLATE utf8mb4_unicode_ci,
  prix_base DECIMAL(10,2) NOT NULL,
  image_url VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  actif TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id_destination),
  KEY fk_destination_continent (id_continent)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS offres (
  id_offre INT NOT NULL AUTO_INCREMENT,
  id_destination INT NOT NULL,
  titre VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  pourcentage_reduction INT NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  actif TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id_offre),
  KEY fk_offre_destination (id_destination)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS reservations (
  id_reservation INT NOT NULL AUTO_INCREMENT,
  id_client INT NOT NULL,
  id_destination INT NOT NULL,
  date_depart DATE NOT NULL,
  date_retour DATE NOT NULL,
  nb_personnes INT NOT NULL DEFAULT 1,
  prix_total DECIMAL(10,2) NOT NULL,
  statut ENUM('en_attente','confirmee','annulee') COLLATE utf8mb4_unicode_ci DEFAULT 'en_attente',
  date_reservation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id_reservation),
  KEY fk_resa_client (id_client),
  KEY fk_resa_destination (id_destination)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS slides (
  id_slide INT NOT NULL AUTO_INCREMENT,
  titre VARCHAR(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  sous_titre VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  image_url VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  ordre INT NOT NULL DEFAULT 1,
  actif TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id_slide)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE client
  ADD CONSTRAINT fk_client_utilisateur
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs (id_utilisateur)
  ON DELETE CASCADE;

ALTER TABLE destinations
  ADD CONSTRAINT fk_destination_continent
  FOREIGN KEY (id_continent) REFERENCES continents (id_continent);

ALTER TABLE offres
  ADD CONSTRAINT fk_offre_destination
  FOREIGN KEY (id_destination) REFERENCES destinations (id_destination)
  ON DELETE CASCADE;

ALTER TABLE reservations
  ADD CONSTRAINT fk_resa_client
  FOREIGN KEY (id_client) REFERENCES client (id_client)
  ON DELETE CASCADE,
  ADD CONSTRAINT fk_resa_destination
  FOREIGN KEY (id_destination) REFERENCES destinations (id_destination)
  ON DELETE RESTRICT;

INSERT INTO utilisateurs (id_utilisateur, email, mot_de_passe_hash, role, actif, date_creation) VALUES
(1, 'admin@bfly.com',  '$2y$10$aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'admin', 1, '2026-01-05 09:10:00'),
(2, 'amira@bfly.com',  '$2y$10$bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb', 'client', 1, '2026-01-06 10:00:00'),
(3, 'yassine@bfly.com','$2y$10$ccccccccccccccccccccccccccccccccccccccccccccccccccccccccc', 'client', 1, '2026-01-07 11:00:00'),
(4, 'sarah@bfly.com',  '$2y$10$ddddddddddddddddddddddddddddddddddddddddddddddddddddddddd', 'client', 1, '2026-01-08 12:00:00'),
(5, 'mehdi@bfly.com',  '$2y$10$eeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee', 'client', 1, '2026-01-09 13:00:00'),
(6, 'ines@bfly.com',   '$2y$10$fffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff', 'client', 1, '2026-01-10 14:00:00'),
(7, 'walid@bfly.com',  '$2y$10$1111111111111111111111111111111111111111111111111111111111', 'client', 1, '2026-01-11 15:00:00'),
(8, 'lina@bfly.com',   '$2y$10$2222222222222222222222222222222222222222222222222222222222', 'client', 1, '2026-01-12 16:00:00'),
(9, 'nabil@bfly.com',  '$2y$10$3333333333333333333333333333333333333333333333333333333333', 'client', 1, '2026-01-13 17:00:00'),
(10,'farah@bfly.com',  '$2y$10$4444444444444444444444444444444444444444444444444444444444', 'client', 1, '2026-01-14 18:00:00');

INSERT INTO client (id_client, id_utilisateur, nom, prenom, telephone, adresse, ville, pays) VALUES
(1, 1, 'Admin', 'Bfly', '0600000000', '1 Rue Admin', 'Paris', 'France'),
(2, 2, 'Benali', 'Amira', '0611111111', '12 Rue des Lilas', 'Lyon', 'France'),
(3, 3, 'Ait', 'Yassine', '0622222222', '8 Avenue Atlas', 'Marseille', 'France'),
(4, 4, 'Kaci', 'Sarah', '0633333333', '5 Boulevard Soleil', 'Toulouse', 'France'),
(5, 5, 'Haddad', 'Mehdi', '0644444444', '22 Rue des Pins', 'Nice', 'France'),
(6, 6, 'Ziani', 'Ines', '0655555555', '3 Rue des Roses', 'Nantes', 'France'),
(7, 7, 'Saadi', 'Walid', '0666666666', '17 Rue du Port', 'Bordeaux', 'France'),
(8, 8, 'Cherif', 'Lina', '0677777777', '9 Rue des Arts', 'Lille', 'France'),
(9, 9, 'Bensaid', 'Nabil', '0688888888', '14 Rue des Ecoles', 'Strasbourg', 'France'),
(10,10,'Toumi', 'Farah', '0699999999', '6 Rue des Champs', 'Montpellier', 'France');

INSERT INTO continents (id_continent, nom) VALUES
(1, 'Afrique'),
(2, 'Europe'),
(3, 'Asie'),
(4, 'Amérique du Nord'),
(5, 'Amérique du Sud'),
(6, 'Océanie'),
(7, 'Antarctique'),
(8, 'Moyen-Orient'),
(9, 'Caraïbes'),
(10,'Arctique');

INSERT INTO destinations (id_destination, pays, ville, id_continent, description, prix_base, image_url, actif) VALUES
(1, 'France', 'Paris', 2, 'Monuments, musées, gastronomie et balades.', 599.99, 'images/destinations/paris.jpg', 1),
(2, 'Espagne', 'Barcelone', 2, 'Plages, architecture et ambiance méditerranéenne.', 499.00, 'images/destinations/barcelone.jpg', 1),
(3, 'Italie', 'Rome', 2, 'Histoire, cuisine italienne et monuments antiques.', 539.00, 'images/destinations/rome.jpg', 1),
(4, 'Maroc', 'Marrakech', 1, 'Souks, palais et désert : immersion culturelle.', 429.00, 'images/destinations/marrakech.jpg', 1),
(5, 'Japon', 'Tokyo', 3, 'Tradition et modernité, quartiers iconiques.', 1099.00, 'images/destinations/tokyo.jpg', 1),
(6, 'USA', 'New York', 4, 'Skyline, Broadway et Central Park.', 1299.00, 'images/destinations/newyork.jpg', 1),
(7, 'Brésil', 'Rio de Janeiro', 5, 'Plages, carnaval et paysages spectaculaires.', 999.00, 'images/destinations/rio.jpg', 1),
(8, 'Australie', 'Sydney', 6, 'Opéra, plages et ambiance australienne.', 1399.00, 'images/destinations/sydney.jpg', 1),
(9, 'Emirats Arabes Unis', 'Dubaï', 8, 'Luxe, désert et gratte-ciels.', 899.00, 'images/destinations/dubai.jpg', 1),
(10,'Mexique', 'Cancún', 9, 'Mer turquoise, détente et excursions.', 799.00, 'images/destinations/cancun.jpg', 1);

INSERT INTO offres (id_offre, id_destination, titre, pourcentage_reduction, date_debut, date_fin, actif) VALUES
(1, 1, 'Week-end City Break Paris', 15, '2026-02-01', '2026-03-15', 1),
(2, 2, 'Promo Barcelone Soleil', 20, '2026-02-05', '2026-02-28', 1),
(3, 3, 'Rome Antique - Offre Flash', 10, '2026-02-10', '2026-03-10', 1),
(4, 4, 'Marrakech Désert & Souks', 25, '2026-02-01', '2026-04-01', 1),
(5, 5, 'Tokyo Printemps', 12, '2026-03-01', '2026-04-30', 1),
(6, 6, 'New York Skyline Deal', 18, '2026-02-15', '2026-03-31', 1),
(7, 7, 'Rio Carnaval Bonus', 8, '2026-02-01', '2026-02-20', 1),
(8, 8, 'Sydney Summer Pack', 14, '2026-01-20', '2026-02-25', 1),
(9, 9, 'Dubaï Luxe & Désert', 9, '2026-02-01', '2026-03-20', 1),
(10,10,'Cancún All Inclusive', 22, '2026-02-05', '2026-04-05', 1);

INSERT INTO reservations (id_reservation, id_client, id_destination, date_depart, date_retour, nb_personnes, prix_total, statut, date_reservation) VALUES
(1, 2, 1, '2026-02-10', '2026-02-14', 2, 1199.98, 'en_attente', '2026-02-03 09:00:00'),
(2, 3, 2, '2026-03-05', '2026-03-10', 1, 499.00, 'confirmee', '2026-02-03 09:05:00'),
(3, 4, 3, '2026-02-20', '2026-02-25', 3, 1617.00, 'en_attente', '2026-02-03 09:10:00'),
(4, 5, 4, '2026-04-01', '2026-04-07', 2, 858.00, 'annulee', '2026-02-03 09:15:00'),
(5, 6, 5, '2026-03-18', '2026-03-28', 1, 1099.00, 'en_attente', '2026-02-03 09:20:00'),
(6, 7, 6, '2026-02-12', '2026-02-19', 2, 2598.00, 'confirmee', '2026-02-03 09:25:00'),
(7, 8, 7, '2026-02-22', '2026-03-01', 4, 3996.00, 'en_attente', '2026-02-03 09:30:00'),
(8, 9, 8, '2026-02-08', '2026-02-16', 2, 2798.00, 'confirmee', '2026-02-03 09:35:00'),
(9, 10, 9, '2026-03-02', '2026-03-06', 1, 899.00, 'en_attente', '2026-02-03 09:40:00'),
(10, 1, 10, '2026-02-25', '2026-03-03', 2, 1598.00, 'confirmee', '2026-02-03 09:45:00');

INSERT INTO slides (id_slide, titre, sous_titre, image_url, ordre, actif) VALUES
(1, 'Bienvenue sur Bfly', 'Découvrez nos offres du moment', 'images/slides/slide1.jpg', 1, 1),
(2, 'City Break', 'Escapades courtes et intenses', 'images/slides/slide2.jpg', 2, 1),
(3, 'Plage & Détente', 'Destinations soleil', 'images/slides/slide3.jpg', 3, 1),
(4, 'Aventure', 'Safari, désert et sensations', 'images/slides/slide4.jpg', 4, 1),
(5, 'Culture', 'Musées, histoire, gastronomie', 'images/slides/slide5.jpg', 5, 1),
(6, 'Famille', 'Voyages adaptés à tous', 'images/slides/slide6.jpg', 6, 1),
(7, 'Luxe', 'Expériences premium', 'images/slides/slide7.jpg', 7, 1),
(8, 'Nature', 'Montagnes, lacs et forêts', 'images/slides/slide8.jpg', 8, 1),
(9, 'Dernière minute', 'Offres limitées dans le temps', 'images/slides/slide9.jpg', 9, 1),
(10,'Nouveautés', 'Nouvelles destinations disponibles', 'images/slides/slide10.jpg', 10, 1);

COMMIT;
