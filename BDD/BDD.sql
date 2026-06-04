-- Script SQL complet : base, tables, contraintes et donnees de test

-- Base de donnees : bfly

-- Parametres SQL
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- Creation base
DROP DATABASE IF EXISTS `bfly`;

CREATE DATABASE `bfly`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `bfly`;

-- Nettoyage tables
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `reservations_voyages`;
DROP TABLE IF EXISTS `reservations_destinations`;
DROP TABLE IF EXISTS `offres`;
DROP TABLE IF EXISTS `voyages_organises`;
DROP TABLE IF EXISTS `destinations`;
DROP TABLE IF EXISTS `continents`;
DROP TABLE IF EXISTS `client`;
DROP TABLE IF EXISTS `utilisateurs`;

SET FOREIGN_KEY_CHECKS = 1;

-- Table utilisateurs

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('client','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `uk_utilisateurs_email` (`email`),
  KEY `idx_utilisateurs_role_actif` (`role`, `actif`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table client

CREATE TABLE `client` (
  `id_client` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int UNSIGNED NOT NULL,
  `nom` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pays` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `uk_client_utilisateur` (`id_utilisateur`),
  CONSTRAINT `fk_client_utilisateur`
    FOREIGN KEY (`id_utilisateur`)
    REFERENCES `utilisateurs` (`id_utilisateur`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table continents

CREATE TABLE `continents` (
  `id_continent` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_continent`),
  UNIQUE KEY `uk_continents_nom` (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table destinations

CREATE TABLE `destinations` (
  `id_destination` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pays` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_continent` int UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `prix_base` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_destination`),
  UNIQUE KEY `uk_destination_pays_ville` (`pays`, `ville`),
  KEY `idx_destinations_continent` (`id_continent`),
  KEY `idx_destinations_actif` (`actif`),
  CONSTRAINT `fk_destination_continent`
    FOREIGN KEY (`id_continent`)
    REFERENCES `continents` (`id_continent`)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table offres

CREATE TABLE `offres` (
  `id_offre` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_destination` int UNSIGNED NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pourcentage_reduction` int UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_offre`),
  KEY `idx_offres_destination` (`id_destination`),
  KEY `idx_offres_actif_dates` (`actif`, `date_debut`, `date_fin`),
  CONSTRAINT `fk_offre_destination`
    FOREIGN KEY (`id_destination`)
    REFERENCES `destinations` (`id_destination`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table voyages organises

CREATE TABLE `voyages_organises` (
  `id_voyage` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_destination` int UNSIGNED NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_depart` date NOT NULL,
  `date_retour` date NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `nb_places` int UNSIGNED NOT NULL,
  `nb_places_restantes` int UNSIGNED NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('actif','complet','annule') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actif',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_voyage`),
  KEY `idx_voyages_destination` (`id_destination`),
  KEY `idx_voyages_statut_date` (`statut`, `date_depart`),
  CONSTRAINT `fk_voyage_destination`
    FOREIGN KEY (`id_destination`)
    REFERENCES `destinations` (`id_destination`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table reservations destinations

CREATE TABLE `reservations_destinations` (
  `id_reservation_destination` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_client` int UNSIGNED NOT NULL,
  `id_destination` int UNSIGNED NOT NULL,
  `date_depart` date NOT NULL,
  `date_retour` date NOT NULL,
  `nb_personnes` int UNSIGNED NOT NULL DEFAULT 1,
  `prix_total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','confirmee','annulee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `date_reservation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation_destination`),
  KEY `idx_resa_dest_client` (`id_client`),
  KEY `idx_resa_dest_destination` (`id_destination`),
  KEY `idx_resa_dest_statut` (`statut`),
  CONSTRAINT `fk_resa_dest_client`
    FOREIGN KEY (`id_client`)
    REFERENCES `client` (`id_client`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_resa_dest_destination`
    FOREIGN KEY (`id_destination`)
    REFERENCES `destinations` (`id_destination`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table reservations voyages

CREATE TABLE `reservations_voyages` (
  `id_reservation_voyage` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_client` int UNSIGNED NOT NULL,
  `id_voyage` int UNSIGNED NOT NULL,
  `nb_personnes` int UNSIGNED NOT NULL DEFAULT 1,
  `prix_total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','confirmee','annulee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `date_reservation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation_voyage`),
  KEY `idx_resa_voy_client` (`id_client`),
  KEY `idx_resa_voy_voyage` (`id_voyage`),
  KEY `idx_resa_voy_statut` (`statut`),
  CONSTRAINT `fk_resa_voy_client`
    FOREIGN KEY (`id_client`)
    REFERENCES `client` (`id_client`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_resa_voy_voyage`
    FOREIGN KEY (`id_voyage`)
    REFERENCES `voyages_organises` (`id_voyage`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Donnees

SET FOREIGN_KEY_CHECKS = 0;

-- Continents de reference
INSERT INTO `continents` (`id_continent`, `nom`) VALUES
(1, 'Europe'),
(2, 'Afrique'),
(3, 'Asie'),
(4, 'Amerique du Nord'),
(5, 'Amerique du Sud'),
(6, 'Oceanie');

-- Comptes de test
INSERT INTO `utilisateurs`
(`id_utilisateur`, `email`, `mot_de_passe_hash`, `role`, `actif`) VALUES
(1, 'admin@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'admin', 1),
(3, 'camille.martin@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(4, 'yanis.meziane@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(5, 'sophie.bernard@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(6, 'amine.kaci@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(7, 'lea.dubois@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(8, 'nassim.benali@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(9, 'julien.moreau@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(10, 'sara.aitali@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(11, 'claire.laurent@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(12, 'mehdi.saadi@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(13, 'emma.robert@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(14, 'karim.haddad@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(15, 'lucas.petit@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(16, 'ines.bouchareb@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(17, 'manon.roux@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(18, 'ilyes.cherif@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(19, 'chloe.garcia@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(20, 'samir.belhadj@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(21, 'antoine.fabre@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(22, 'lina.merabet@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(23, 'nicolas.andre@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(24, 'amina.larbi@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1),
(25, 'elodie.mercier@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1);

-- Clients de test
INSERT INTO `client`
(`id_client`, `id_utilisateur`, `nom`, `prenom`, `telephone`, `adresse`, `ville`, `pays`) VALUES
(1, 3, 'Martin', 'Camille', '+33610000001', '12 rue Victor Hugo', 'Paris', 'France'),
(2, 4, 'Meziane', 'Yanis', '+213550000001', 'Rue Didouche Mourad', 'Alger', 'Algerie'),
(3, 5, 'Bernard', 'Sophie', '+33610000002', '8 avenue Jean Jaures', 'Lyon', 'France'),
(4, 6, 'Kaci', 'Amine', '+213550000002', 'Boulevard Krim Belkacem', 'Tizi Ouzou', 'Algerie'),
(5, 7, 'Dubois', 'Lea', '+33610000003', '25 rue Nationale', 'Lille', 'France'),
(6, 8, 'Benali', 'Nassim', '+213550000003', 'Rue Larbi Ben Mhidi', 'Oran', 'Algerie'),
(7, 9, 'Moreau', 'Julien', '+33610000004', '4 place Bellecour', 'Lyon', 'France'),
(8, 10, 'Aitali', 'Sara', '+213550000004', 'Cite des Palmiers', 'Bejaia', 'Algerie'),
(9, 11, 'Laurent', 'Claire', '+33610000005', '17 rue de la Republique', 'Marseille', 'France'),
(10, 12, 'Saadi', 'Mehdi', '+213550000005', 'Rue Emir Abdelkader', 'Alger', 'Algerie'),
(11, 13, 'Robert', 'Emma', '+33610000006', '6 rue Alsace Lorraine', 'Toulouse', 'France'),
(12, 14, 'Haddad', 'Karim', '+21622000001', 'Avenue Habib Bourguiba', 'Tunis', 'Tunisie'),
(13, 15, 'Petit', 'Lucas', '+33610000007', '11 rue Massena', 'Nice', 'France'),
(14, 16, 'Bouchareb', 'Ines', '+213550000006', 'Rue Mohamed Khemisti', 'Constantine', 'Algerie'),
(15, 17, 'Roux', 'Manon', '+33610000008', '3 rue Sainte-Catherine', 'Bordeaux', 'France'),
(16, 18, 'Cherif', 'Ilyes', '+213550000007', 'Rue des Freres Bouadou', 'Blida', 'Algerie'),
(17, 19, 'Garcia', 'Chloe', '+34600000001', 'Carrer de Mallorca', 'Barcelone', 'Espagne'),
(18, 20, 'Belhadj', 'Samir', '+213550000008', 'Rue Ahmed Zabana', 'Annaba', 'Algerie'),
(19, 21, 'Fabre', 'Antoine', '+33610000009', '19 rue de Metz', 'Nancy', 'France'),
(20, 22, 'Merabet', 'Lina', '+213550000009', 'Cite El Mokrani', 'Setif', 'Algerie'),
(21, 23, 'Andre', 'Nicolas', '+33610000010', '2 rue Colbert', 'Nantes', 'France'),
(22, 24, 'Larbi', 'Amina', '+212600000001', 'Boulevard Mohammed V', 'Casablanca', 'Maroc'),
(23, 25, 'Mercier', 'Elodie', '+33610000011', '10 rue des Arts', 'Strasbourg', 'France');

-- Destinations de test
INSERT INTO `destinations`
(`id_destination`, `pays`, `ville`, `id_continent`, `description`, `prix_base`, `image_url`, `actif`) VALUES
(1, 'France', 'Paris', 1, 'Decouverte de Paris, monuments, musees et gastronomie.', 350.00, NULL, 1),
(2, 'Algerie', 'Alger', 2, 'Sejour a Alger entre patrimoine, Casbah et bord de mer.', 220.00, NULL, 1),
(3, 'Tunisie', 'Tunis', 2, 'Voyage a Tunis avec visite de Carthage et Sidi Bou Said.', 210.00, NULL, 1),
(4, 'Hongrie', 'Budapest', 1, 'Sejour culturel a Budapest entre thermes et Danube.', 320.00, NULL, 1),
(5, 'Italie', 'Rome', 1, 'Decouverte de Rome, Colisee, Vatican et cuisine italienne.', 370.00, NULL, 1),
(6, 'Espagne', 'Majorque', 1, 'Sejour detente a Majorque entre plages et villages mediterraneens.', 420.00, NULL, 1),
(7, 'Grece', 'Athenes', 1, 'Voyage historique a Athenes et decouverte de la culture grecque.', 390.00, NULL, 1),
(8, 'Republique Tcheque', 'Prague', 1, 'City trip a Prague, vieille ville et chateau.', 340.00, NULL, 1),
(9, 'Autriche', 'Vienne', 1, 'Sejour elegant a Vienne, palais, musique et cafes.', 410.00, NULL, 1),
(10, 'Japon', 'Tokyo', 3, 'Voyage a Tokyo entre modernite, temples et gastronomie japonaise.', 850.00, NULL, 1),
(11, 'Malaisie', 'Kuala Lumpur', 3, 'Decouverte de Kuala Lumpur, temples, tours et cuisine asiatique.', 690.00, NULL, 1),
(12, 'Thailande', 'Bangkok', 3, 'Sejour a Bangkok entre temples, marches et ambiance tropicale.', 650.00, NULL, 1),
(13, 'USA', 'New York', 4, 'City trip a New York, gratte-ciel, spectacles et shopping.', 920.00, NULL, 1),
(14, 'Mexique', 'Cancun', 4, 'Sejour soleil a Cancun entre plages et culture maya.', 780.00, NULL, 1),
(15, 'Cuba', 'La Havane', 4, 'Voyage a La Havane, culture cubaine, musique et architecture coloree.', 760.00, NULL, 1);

-- Offres de test
INSERT INTO `offres`
(`id_offre`, `id_destination`, `titre`, `pourcentage_reduction`, `date_debut`, `date_fin`, `actif`) VALUES
(1, 1, 'Offre ete Paris', 10, '2026-06-01', '2026-06-30', 1),
(2, 6, 'Majorque soleil', 15, '2026-07-01', '2026-08-31', 1),
(3, 10, 'Tokyo decouverte', 8, '2026-08-15', '2026-09-30', 1),
(4, 13, 'New York automne', 12, '2026-09-01', '2026-11-15', 1),
(5, 14, 'Cancun detente', 18, '2026-10-01', '2026-12-15', 1),
(6, 2, 'Alger patrimoine', 10, '2026-06-01', '2026-07-31', 1);

-- Voyages de test
INSERT INTO `voyages_organises`
(`id_voyage`, `id_destination`, `titre`, `description`, `date_depart`, `date_retour`, `prix`, `nb_places`, `nb_places_restantes`, `image_url`, `statut`) VALUES
(1, 1, 'City Break Paris', 'Voyage organise pour decouvrir les incontournables de Paris.', '2026-06-15', '2026-06-20', 590.00, 30, 28, NULL, 'actif'),
(2, 2, 'Sejour Alger Authentique', 'Circuit organise a Alger avec visites guidees.', '2026-06-22', '2026-06-29', 430.00, 30, 29, NULL, 'actif'),
(3, 3, 'Decouverte de Tunis', 'Sejour culturel a Tunis, Carthage et Sidi Bou Said.', '2026-07-01', '2026-07-07', 410.00, 25, 23, NULL, 'actif'),
(4, 4, 'Budapest Detente', 'Voyage a Budapest avec decouverte des thermes et du centre historique.', '2026-07-10', '2026-07-16', 620.00, 25, 24, NULL, 'actif'),
(5, 5, 'Rome Historique', 'Circuit organise a Rome entre monuments antiques et gastronomie.', '2026-07-20', '2026-07-26', 690.00, 30, 27, NULL, 'actif'),
(6, 6, 'Majorque Soleil', 'Sejour detente a Majorque avec plages et excursions.', '2026-08-01', '2026-08-08', 780.00, 20, 20, NULL, 'actif'),
(7, 7, 'Athenes Antique', 'Voyage organise a Athenes avec visite de l Acropole.', '2026-08-10', '2026-08-16', 720.00, 25, 24, NULL, 'actif'),
(8, 8, 'Prague Romantique', 'City trip a Prague avec visite de la vieille ville.', '2026-08-20', '2026-08-25', 640.00, 25, 25, NULL, 'actif'),
(9, 9, 'Vienne Imperiale', 'Sejour a Vienne entre palais, musees et concerts.', '2026-09-01', '2026-09-07', 760.00, 25, 25, NULL, 'actif'),
(10, 10, 'Tokyo Experience', 'Voyage organise a Tokyo entre quartiers modernes et traditions.', '2026-09-12', '2026-09-22', 1450.00, 20, 18, NULL, 'actif'),
(11, 11, 'Kuala Lumpur Decouverte', 'Sejour en Malaisie avec visites culturelles et urbaines.', '2026-10-01', '2026-10-10', 1180.00, 20, 20, NULL, 'actif'),
(12, 12, 'Bangkok Tropical', 'Voyage a Bangkok entre temples, marches et excursions.', '2026-10-15', '2026-10-24', 1120.00, 20, 20, NULL, 'actif'),
(13, 13, 'New York City Trip', 'Sejour organise a New York avec visites libres et guidees.', '2026-11-01', '2026-11-08', 1590.00, 25, 24, NULL, 'actif'),
(14, 14, 'Cancun Soleil', 'Sejour au Mexique entre plage, detente et excursion maya.', '2026-11-15', '2026-11-24', 1380.00, 20, 20, NULL, 'actif'),
(15, 15, 'La Havane Culture', 'Voyage organise a Cuba avec decouverte de La Havane.', '2026-12-01', '2026-12-10', 1320.00, 20, 18, NULL, 'actif');

-- Reservations destinations de test
INSERT INTO `reservations_destinations`
(`id_reservation_destination`, `id_client`, `id_destination`, `date_depart`, `date_retour`, `nb_personnes`, `prix_total`, `statut`) VALUES
(1, 1, 1, '2026-06-10', '2026-06-15', 2, 3500.00, 'confirmee'),
(2, 2, 2, '2026-06-18', '2026-06-24', 1, 1320.00, 'en_attente'),
(3, 3, 5, '2026-07-05', '2026-07-12', 2, 5180.00, 'confirmee'),
(4, 4, 3, '2026-07-10', '2026-07-17', 3, 4410.00, 'en_attente'),
(5, 5, 6, '2026-08-02', '2026-08-09', 2, 5880.00, 'confirmee'),
(6, 6, 7, '2026-08-15', '2026-08-21', 1, 2340.00, 'annulee'),
(7, 7, 8, '2026-09-01', '2026-09-06', 2, 3400.00, 'confirmee'),
(8, 8, 10, '2026-09-18', '2026-09-28', 1, 8500.00, 'en_attente'),
(9, 9, 13, '2026-10-05', '2026-10-12', 2, 12880.00, 'confirmee'),
(10, 10, 14, '2026-11-03', '2026-11-10', 2, 10920.00, 'en_attente');

-- Reservations voyages de test
INSERT INTO `reservations_voyages`
(`id_reservation_voyage`, `id_client`, `id_voyage`, `nb_personnes`, `prix_total`, `statut`) VALUES
(1, 11, 1, 2, 1180.00, 'confirmee'),
(2, 12, 2, 1, 430.00, 'en_attente'),
(3, 13, 3, 2, 820.00, 'confirmee'),
(4, 14, 4, 1, 620.00, 'en_attente'),
(5, 15, 5, 3, 2070.00, 'confirmee'),
(6, 16, 6, 2, 1560.00, 'annulee'),
(7, 17, 7, 1, 720.00, 'confirmee'),
(8, 18, 10, 2, 2900.00, 'en_attente'),
(9, 19, 13, 1, 1590.00, 'confirmee'),
(10, 20, 15, 2, 2640.00, 'en_attente');

-- Auto increment
ALTER TABLE `utilisateurs` AUTO_INCREMENT = 26;
ALTER TABLE `client` AUTO_INCREMENT = 24;
ALTER TABLE `continents` AUTO_INCREMENT = 7;
ALTER TABLE `destinations` AUTO_INCREMENT = 16;
ALTER TABLE `offres` AUTO_INCREMENT = 7;
ALTER TABLE `voyages_organises` AUTO_INCREMENT = 16;
ALTER TABLE `reservations_destinations` AUTO_INCREMENT = 11;
ALTER TABLE `reservations_voyages` AUTO_INCREMENT = 11;

SET FOREIGN_KEY_CHECKS = 1;
