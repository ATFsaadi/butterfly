-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 10 juin 2026 à 17:20
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
CREATE DATABASE IF NOT EXISTS `bfly` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `bfly`;

SET FOREIGN_KEY_CHECKS = 0;


--
-- Base de données : `bfly`
--

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utilisateur` int UNSIGNED NOT NULL,
  `nom` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `pays` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `uk_client_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `id_utilisateur`, `nom`, `prenom`, `telephone`, `adresse`, `ville`, `pays`, `date_creation`, `date_modification`) VALUES
(1, 1, 'saadi', 'aylan', NULL, NULL, NULL, NULL, '2026-05-23 23:59:44', '2026-05-23 23:59:44'),
(2, 2, 'saadi', 'nina', NULL, NULL, NULL, NULL, '2026-05-24 00:00:02', '2026-05-24 00:00:02'),
(3, 3, 'Martin', 'Camille', '+33610000001', '12 rue Victor Hugo', 'Paris', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(4, 4, 'Meziane', 'Yanis', '+213550000001', 'Rue Didouche Mourad', 'Alger', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(5, 5, 'Bernard', 'Sophie', '+33610000002', '8 avenue Jean Jaures', 'Lyon', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(6, 6, 'Kaci', 'Amine', '+213550000002', 'Boulevard Krim Belkacem', 'Tizi Ouzou', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(7, 7, 'Dubois', 'Lea', '+33610000003', '25 rue Nationale', 'Lille', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(8, 8, 'Benali', 'Nassim', '+213550000003', 'Rue Larbi Ben Mhidi', 'Oran', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(9, 9, 'Moreau', 'Julien', '+33610000004', '4 place Bellecour', 'Lyon', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(10, 10, 'Aitali', 'Sara', '+213550000004', 'Cite des Palmiers', 'Bejaia', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(11, 11, 'Laurent', 'Claire', '+33610000005', '17 rue de la Republique', 'Marseille', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(12, 12, 'Saadi', 'Mehdi', '+213550000005', 'Rue Emir Abdelkader', 'Alger', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(13, 13, 'Robert', 'Emma', '+33610000006', '6 rue Alsace Lorraine', 'Toulouse', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(14, 14, 'Haddad', 'Karim', '+21622000001', 'Avenue Habib Bourguiba', 'Tunis', 'Tunisie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(15, 15, 'Petit', 'Lucas', '+33610000007', '11 rue Massena', 'Nice', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(16, 16, 'Bouchareb', 'Ines', '+213550000006', 'Rue Mohamed Khemisti', 'Constantine', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(17, 17, 'Roux', 'Manon', '+33610000008', '3 rue Sainte-Catherine', 'Bordeaux', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(18, 18, 'Cherif', 'Ilyes', '+213550000007', 'Rue des Freres Bouadou', 'Blida', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(19, 19, 'Garcia', 'Chloe', '+34600000001', 'Carrer de Mallorca', 'Barcelone', 'Espagne', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(20, 20, 'Belhadj', 'Samir', '+213550000008', 'Rue Ahmed Zabana', 'Annaba', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(21, 21, 'Fabre', 'Antoine', '+33610000009', '19 rue de Metz', 'Nancy', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(22, 22, 'Merabet', 'Lina', '+213550000009', 'Cite El Mokrani', 'Setif', 'Algerie', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(23, 23, 'Andre', 'Nicolas', '+33610000010', '2 rue Colbert', 'Nantes', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(24, 24, 'Larbi', 'Amina', '+212600000001', 'Boulevard Mohammed V', 'Casablanca', 'Maroc', '2026-05-24 00:03:01', '2026-05-24 00:03:01'),
(25, 25, 'Mercier', 'Elodie', '+33610000011', '10 rue des Arts', 'Strasbourg', 'France', '2026-05-24 00:03:01', '2026-05-24 00:03:01');

-- --------------------------------------------------------

--
-- Structure de la table `continents`
--

DROP TABLE IF EXISTS `continents`;
CREATE TABLE IF NOT EXISTS `continents` (
  `id_continent` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_continent`),
  UNIQUE KEY `uk_continents_nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `continents`
--

INSERT INTO `continents` (`id_continent`, `nom`) VALUES
(2, 'Afrique'),
(4, 'Amerique du Nord'),
(5, 'Amerique du Sud'),
(3, 'Asie'),
(1, 'Europe'),
(6, 'Oceanie');

-- --------------------------------------------------------

--
-- Structure de la table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `id_destination` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pays` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_continent` int UNSIGNED DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `prix_base` decimal(10,2) NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_destination`),
  UNIQUE KEY `uk_destination_pays_ville` (`pays`,`ville`),
  KEY `idx_destinations_continent` (`id_continent`),
  KEY `idx_destinations_actif` (`actif`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `destinations`
--

INSERT INTO `destinations` (`id_destination`, `pays`, `ville`, `id_continent`, `description`, `prix_base`, `image_url`, `actif`, `date_creation`, `date_modification`) VALUES
(1, 'France', 'Paris', 1, 'Decouverte de Paris, monuments, musees et gastronomie.', 350.00, 'images/destinations/dest_1779624090_6d429f777243.webp', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:30'),
(2, 'Algerie', 'Alger', 2, 'Sejour a Alger entre patrimoine, Casbah et bord de mer.', 220.00, 'images/destinations/dest_1779623883_6f93be323833.jpg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:07'),
(3, 'Tunisie', 'Tunis', 2, 'Voyage a Tunis avec visite de Carthage et Sidi Bou Said.', 210.00, 'images/destinations/dest_1779624622_0bc73974e97d.jpg', 0, '2026-05-24 00:01:10', '2026-06-10 18:59:52'),
(4, 'Hongrie', 'Budapest', 1, 'Sejour culturel a Budapest entre thermes et Danube.', 320.00, 'images/destinations/dest_1779624254_aa7c0e9ed0cc.jpg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:39'),
(5, 'Italie', 'Rome', 1, 'Decouverte de Rome, Colisee, Vatican et cuisine italienne.', 370.00, 'images/destinations/dest_1779624267_5762be59dc68.jpg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:44'),
(6, 'Espagne test', 'Majorque test', 1, 'Sejour detente a Majorque entre plages et villages mediterraneens.', 420.00, 'images/destinations/dest_1779624008_c66dccb2de04.jpg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:25'),
(7, 'Grece', 'Athenes', 1, 'Voyage historique a Athenes et decouverte de la culture grecque.', 390.00, 'images/destinations/dest_1779624244_c625ed629c54.webp', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:35'),
(8, 'Republique Tcheque', 'Prague', 1, 'City trip a Prague, vieille ville et chateau.', 340.00, 'images/destinations/dest_1779624584_25c46c6d0368.jpg', 0, '2026-05-24 00:01:10', '2026-06-10 18:59:52'),
(9, 'Autriche', 'Vienne', 1, 'Sejour elegant a Vienne, palais, musique et cafes.', 410.00, 'images/destinations/dest_1779623892_5048f81bb5bd.jpeg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:14'),
(10, 'Japon', 'Tokyo', 3, 'Voyage a Tokyo entre modernite, temples et gastronomie japonaise.', 850.00, 'images/destinations/dest_1779624278_947b102fe503.jpg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:47'),
(11, 'Malaisie', 'Kuala Lumpur', 3, 'Decouverte de Kuala Lumpur, temples, tours et cuisine asiatique.', 690.00, 'images/destinations/dest_1779624528_7941ebda06b0.jpg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:51'),
(12, 'Thailande', 'Bangkok', 3, 'Sejour a Bangkok entre temples, marches et ambiance tropicale.', 650.00, 'images/destinations/dest_1779624597_b654a52f3a09.jpg', 0, '2026-05-24 00:01:10', '2026-06-10 18:59:52'),
(13, 'USA', 'New York', 4, 'City trip a New York, gratte-ciel, spectacles et shopping.', 920.00, 'images/destinations/dest_1779624512_c9aea764b709.jpg', 0, '2026-05-24 00:01:10', '2026-06-10 16:40:08'),
(14, 'Mexique', 'Cancun', 4, 'Sejour soleil a Cancun entre plages et culture maya.', 780.00, 'images/destinations/dest_1779624569_9699a9739609.jpg', 0, '2026-05-24 00:01:10', '2026-06-10 18:59:52'),
(15, 'Cuba', 'La Havane', 4, 'Voyage a La Havane, culture cubaine, musique et architecture coloree.', 760.00, 'images/destinations/dest_1779623990_84e61d92e73a.jpg', 1, '2026-05-24 00:01:10', '2026-06-10 19:00:19');

-- --------------------------------------------------------

--
-- Structure de la table `offres`
--

DROP TABLE IF EXISTS `offres`;
CREATE TABLE IF NOT EXISTS `offres` (
  `id_offre` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_destination` int UNSIGNED NOT NULL,
  `titre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pourcentage_reduction` int UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_offre`),
  KEY `idx_offres_destination` (`id_destination`),
  KEY `idx_offres_actif_dates` (`actif`,`date_debut`,`date_fin`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `offres`
--

INSERT INTO `offres` (`id_offre`, `id_destination`, `titre`, `pourcentage_reduction`, `date_debut`, `date_fin`, `actif`, `date_creation`, `date_modification`) VALUES
(1, 2, 'test', 8, '2026-05-24', '2026-05-28', 0, '2026-05-24 11:25:23', '2026-06-10 16:40:52'),
(2, 14, 'Cancun Soleil', 38, '2026-06-10', '2026-07-17', 1, '2026-05-24 14:17:11', '2026-06-10 16:52:18'),
(3, 11, 'Séjour de Rêve', 28, '2026-05-24', '2026-05-31', 1, '2026-05-24 14:20:55', '2026-05-24 14:20:55'),
(4, 1, 'L\'amour et la lumière', 36, '2026-05-24', '2026-05-31', 1, '2026-05-24 14:22:26', '2026-05-24 14:22:26'),
(5, 4, 'Perle du danube', 15, '2026-05-24', '2026-05-31', 1, '2026-05-24 14:24:04', '2026-05-24 14:24:04');

-- --------------------------------------------------------

--
-- Structure de la table `reservations_destinations`
--

DROP TABLE IF EXISTS `reservations_destinations`;
CREATE TABLE IF NOT EXISTS `reservations_destinations` (
  `id_reservation_destination` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_client` int UNSIGNED NOT NULL,
  `id_destination` int UNSIGNED NOT NULL,
  `date_depart` date NOT NULL,
  `date_retour` date NOT NULL,
  `nb_personnes` int UNSIGNED NOT NULL DEFAULT '1',
  `prix_total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','confirmee','annulee') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `date_reservation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation_destination`),
  KEY `idx_resa_dest_client` (`id_client`),
  KEY `idx_resa_dest_destination` (`id_destination`),
  KEY `idx_resa_dest_statut` (`statut`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations_destinations`
--

INSERT INTO `reservations_destinations` (`id_reservation_destination`, `id_client`, `id_destination`, `date_depart`, `date_retour`, `nb_personnes`, `prix_total`, `statut`, `date_reservation`, `date_modification`) VALUES
(1, 1, 1, '2026-06-10', '2026-06-15', 2, 3500.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(2, 2, 2, '2026-06-18', '2026-06-24', 1, 1320.00, 'annulee', '2026-05-24 00:01:10', '2026-05-24 11:30:11'),
(3, 3, 5, '2026-07-05', '2026-07-12', 2, 5180.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(4, 4, 3, '2026-07-10', '2026-07-17', 3, 4410.00, 'confirmee', '2026-05-24 00:01:10', '2026-06-10 19:10:10'),
(5, 5, 6, '2026-08-02', '2026-08-09', 2, 5880.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(6, 6, 7, '2026-08-15', '2026-08-21', 1, 2340.00, 'annulee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(7, 7, 8, '2026-09-01', '2026-09-06', 2, 3400.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(8, 8, 10, '2026-09-18', '2026-09-28', 1, 8500.00, 'confirmee', '2026-05-24 00:01:10', '2026-06-10 19:08:19'),
(9, 9, 13, '2026-10-05', '2026-10-12', 2, 12880.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(10, 10, 14, '2026-11-03', '2026-11-10', 2, 10920.00, 'confirmee', '2026-05-24 00:01:10', '2026-06-10 19:06:01');

-- --------------------------------------------------------

--
-- Structure de la table `reservations_voyages`
--

DROP TABLE IF EXISTS `reservations_voyages`;
CREATE TABLE IF NOT EXISTS `reservations_voyages` (
  `id_reservation_voyage` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_client` int UNSIGNED NOT NULL,
  `id_voyage` int UNSIGNED NOT NULL,
  `nb_personnes` int UNSIGNED NOT NULL DEFAULT '1',
  `prix_total` decimal(10,2) NOT NULL,
  `statut` enum('en_attente','confirmee','annulee') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `date_reservation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation_voyage`),
  KEY `idx_resa_voy_client` (`id_client`),
  KEY `idx_resa_voy_voyage` (`id_voyage`),
  KEY `idx_resa_voy_statut` (`statut`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations_voyages`
--

INSERT INTO `reservations_voyages` (`id_reservation_voyage`, `id_client`, `id_voyage`, `nb_personnes`, `prix_total`, `statut`, `date_reservation`, `date_modification`) VALUES
(1, 11, 1, 2, 1180.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(2, 12, 2, 1, 430.00, 'en_attente', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(3, 13, 3, 2, 820.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(4, 14, 4, 1, 620.00, 'en_attente', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(5, 15, 5, 3, 2070.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(6, 16, 6, 2, 1560.00, 'annulee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(7, 17, 7, 1, 720.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(8, 18, 10, 2, 2900.00, 'confirmee', '2026-05-24 00:01:10', '2026-06-10 19:10:07'),
(9, 19, 13, 1, 1590.00, 'confirmee', '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(10, 20, 15, 2, 2640.00, 'confirmee', '2026-05-24 00:01:10', '2026-06-10 19:10:05'),
(11, 2, 5, 1, 690.00, 'en_attente', '2026-05-24 11:08:27', '2026-05-24 11:08:27'),
(12, 2, 2, 1, 430.00, 'confirmee', '2026-05-24 11:11:47', '2026-06-10 19:10:19'),
(13, 2, 1, 1, 590.00, 'confirmee', '2026-05-24 12:38:30', '2026-06-10 19:10:25'),
(14, 2, 3, 1, 410.00, 'en_attente', '2026-06-10 18:51:05', '2026-06-10 18:51:05'),
(15, 2, 2, 2, 860.00, 'en_attente', '2026-06-10 19:08:58', '2026-06-10 19:08:58'),
(16, 2, 1, 1, 790.00, 'confirmee', '2026-06-10 19:09:10', '2026-06-10 19:10:16'),
(17, 2, 1, 3, 2370.00, 'en_attente', '2026-06-10 19:09:36', '2026-06-10 19:09:36');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe_hash` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('client','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `uk_utilisateurs_email` (`email`),
  KEY `idx_utilisateurs_role_actif` (`role`,`actif`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `email`, `mot_de_passe_hash`, `role`, `actif`, `date_creation`, `date_modification`) VALUES
(1, 'aylan@gmail.com', '$2y$10$zm87j3m0WBTPO52Yc/aI5eVt5KbJkMonk8GQDmXO3EHaNE7loqeRi', 'admin', 1, '2026-05-23 23:59:44', '2026-05-24 00:04:08'),
(2, 'nina@gmail.com', '$2y$10$RPoCQzFc3lCdPZhkDoJCz.ok6rz.G3Aj1kubiTG8YY.nfq62vzRHm', 'client', 1, '2026-05-24 00:00:02', '2026-05-24 00:00:02'),
(3, 'camille.martin@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(4, 'yanis.meziane@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(5, 'sophie.bernard@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(6, 'amine.kaci@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(7, 'lea.dubois@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(8, 'nassim.benali@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(9, 'julien.moreau@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(10, 'sara.aitali@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(11, 'claire.laurent@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(12, 'mehdi.saadi@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(13, 'emma.robert@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(14, 'karim.haddad@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(15, 'lucas.petit@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(16, 'ines.bouchareb@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(17, 'manon.roux@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(18, 'ilyes.cherif@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(19, 'chloe.garcia@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(20, 'samir.belhadj@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(21, 'antoine.fabre@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(22, 'lina.merabet@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(23, 'nicolas.andre@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(24, 'amina.larbi@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10'),
(25, 'elodie.mercier@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-05-24 00:01:10', '2026-05-24 00:01:10');

-- --------------------------------------------------------

--
-- Structure de la table `voyages_organises`
--

DROP TABLE IF EXISTS `voyages_organises`;
CREATE TABLE IF NOT EXISTS `voyages_organises` (
  `id_voyage` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_destination` int UNSIGNED NOT NULL,
  `titre` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `date_depart` date NOT NULL,
  `date_retour` date NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `nb_places` int UNSIGNED NOT NULL,
  `nb_places_restantes` int UNSIGNED NOT NULL,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('actif','complet','annule') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'actif',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_voyage`),
  KEY `idx_voyages_destination` (`id_destination`),
  KEY `idx_voyages_statut_date` (`statut`,`date_depart`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `voyages_organises`
--

INSERT INTO `voyages_organises` (`id_voyage`, `id_destination`, `titre`, `description`, `date_depart`, `date_retour`, `prix`, `nb_places`, `nb_places_restantes`, `image_url`, `statut`, `date_creation`, `date_modification`) VALUES
(1, 1, 'City Break Paris', 'Voyage organise pour decouvrir les incontournables de Paris.', '2026-06-15', '2026-06-20', 790.00, 30, 25, 'images/voyages/voyage_1779622883_861fae77489a.jpg', 'actif', '2026-05-24 00:01:10', '2026-06-10 19:09:36'),
(2, 2, 'Sejour Alger Authentique', 'Circuit organise a Alger avec visites guidees.', '2026-06-22', '2026-06-29', 430.00, 30, 27, 'images/voyages/voyage_1779623150_c590dbb4c107.jpg', 'actif', '2026-05-24 00:01:10', '2026-06-10 19:08:58'),
(3, 3, 'Decouverte de Tunis', 'Sejour culturel a Tunis, Carthage et Sidi Bou Said.', '2026-07-01', '2026-07-07', 410.00, 25, 24, 'images/voyages/voyage_1779623227_d37f47fa00a2.jpg', 'actif', '2026-05-24 00:01:10', '2026-06-10 18:51:05'),
(4, 4, 'Budapest Detente', 'Voyage a Budapest avec decouverte des thermes et du centre historique.', '2026-07-10', '2026-07-16', 620.00, 25, 25, 'images/voyages/voyage_1779622715_2cbef1d1aa8c.webp', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:38:35'),
(5, 5, 'Rome Historique', 'Circuit organise a Rome entre monuments antiques et gastronomie.', '2026-07-20', '2026-07-26', 690.00, 30, 29, 'images/voyages/voyage_1779623288_6562a8448ac3.jpeg', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:48:08'),
(6, 6, 'Majorque Soleil', 'Sejour detente a Majorque avec plages et excursions.', '2026-08-01', '2026-08-08', 780.00, 20, 20, 'images/voyages/voyage_1779623655_4cd3dd049fa3.jpeg', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:54:15'),
(7, 7, 'Athenes Antique', 'Voyage organise a Athenes avec visite de l Acropole.', '2026-08-10', '2026-08-16', 720.00, 25, 25, 'images/voyages/voyage_1779622639_f7cb04a29c45.jpg', 'complet', '2026-05-24 00:01:10', '2026-05-24 17:55:11'),
(8, 8, 'Prague Romantique', 'City trip a Prague avec visite de la vieille ville.', '2026-08-20', '2026-08-25', 640.00, 25, 25, 'images/voyages/voyage_1779623684_7682f169eb22.jpg', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:54:44'),
(9, 9, 'Vienne Imperiale', 'Sejour a Vienne entre palais, musees et concerts.', '2026-09-01', '2026-09-07', 760.00, 25, 25, 'images/voyages/voyage_1779623723_b23e52d833be.jpeg', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:55:23'),
(10, 10, 'Tokyo Experience', 'Voyage organise a Tokyo entre quartiers modernes et traditions.', '2026-09-12', '2026-09-22', 1450.00, 20, 20, 'images/voyages/voyage_1779623707_9f44edbb75cf.jpg', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:55:07'),
(11, 11, 'Kuala Lumpur Decouverte', 'Sejour en Malaisie avec visites culturelles et urbaines.', '2026-10-01', '2026-10-10', 1180.00, 20, 20, 'images/voyages/voyage_1779623626_0d96d04383be.webp', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:53:46'),
(12, 12, 'Bangkok Tropical', 'Voyage a Bangkok entre temples, marches et excursions.', '2026-10-15', '2026-10-24', 1120.00, 20, 20, 'images/voyages/voyage_1779622673_fa65505e4d93.webp', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:37:53'),
(13, 13, 'New York City Trip', 'Sejour organise a New York avec visites libres et guidees.', '2026-11-01', '2026-11-08', 1590.00, 25, 25, 'images/voyages/voyage_1779623669_e05837144235.webp', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:54:29'),
(14, 14, 'Cancun Soleil', 'Sejour au Mexique entre plage, detente et excursion maya.', '2026-11-15', '2026-11-24', 1380.00, 20, 20, 'images/voyages/voyage_1779622793_e868f54420b8.jpg', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:39:53'),
(15, 15, 'La Havane Culture', 'Voyage organise a Cuba avec decouverte de La Havane.', '2026-12-01', '2026-12-10', 1320.00, 20, 20, 'images/voyages/voyage_1779623643_ff5ae8c9bc48.jpg', 'actif', '2026-05-24 00:01:10', '2026-05-24 13:54:03');

SET FOREIGN_KEY_CHECKS = 1;

--
-- Déclencheurs `reservations_voyages`
--
DROP TRIGGER IF EXISTS `trg_reservation_voyage_decrement_places`;
DELIMITER $$
CREATE TRIGGER `trg_reservation_voyage_decrement_places` BEFORE INSERT ON `reservations_voyages` FOR EACH ROW BEGIN
  UPDATE `voyages_organises`
  SET `nb_places_restantes` = `nb_places_restantes` - NEW.`nb_personnes`
  WHERE `id_voyage` = NEW.`id_voyage`
    AND `statut` = 'actif'
    AND `nb_places_restantes` >= NEW.`nb_personnes`;

  IF ROW_COUNT() = 0 THEN
    SIGNAL SQLSTATE '45000'
      SET MESSAGE_TEXT = 'Places insuffisantes pour ce voyage';
  END IF;
END
$$
DELIMITER ;

--
-- Déclencheurs `voyages_organises`
--
DROP TRIGGER IF EXISTS `trg_voyage_complet`;
DELIMITER $$
CREATE TRIGGER `trg_voyage_complet` BEFORE UPDATE ON `voyages_organises` FOR EACH ROW BEGIN
  IF NEW.`nb_places_restantes` = 0 AND NEW.`statut` = 'actif' THEN
    SET NEW.`statut` = 'complet';
  END IF;
END
$$
DELIMITER ;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_client_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `destinations`
--
ALTER TABLE `destinations`
  ADD CONSTRAINT `fk_destination_continent` FOREIGN KEY (`id_continent`) REFERENCES `continents` (`id_continent`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Contraintes pour la table `offres`
--
ALTER TABLE `offres`
  ADD CONSTRAINT `fk_offre_destination` FOREIGN KEY (`id_destination`) REFERENCES `destinations` (`id_destination`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservations_destinations`
--
ALTER TABLE `reservations_destinations`
  ADD CONSTRAINT `fk_resa_dest_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resa_dest_destination` FOREIGN KEY (`id_destination`) REFERENCES `destinations` (`id_destination`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `reservations_voyages`
--
ALTER TABLE `reservations_voyages`
  ADD CONSTRAINT `fk_resa_voy_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resa_voy_voyage` FOREIGN KEY (`id_voyage`) REFERENCES `voyages_organises` (`id_voyage`) ON DELETE RESTRICT ON UPDATE CASCADE;

--
-- Contraintes pour la table `voyages_organises`
--
ALTER TABLE `voyages_organises`
  ADD CONSTRAINT `fk_voyage_destination` FOREIGN KEY (`id_destination`) REFERENCES `destinations` (`id_destination`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
