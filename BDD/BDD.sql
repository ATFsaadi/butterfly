-- =========================================================
-- Base de données : bfly_ppe
-- Projet : Bfly - Situation professionnelle 1 / BTS SIO SLAM
-- Version finale propre pour import direct par le jury
-- Généré le : 01/05/2026
-- =========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

DROP DATABASE IF EXISTS `bfly_ppe`;
CREATE DATABASE IF NOT EXISTS `bfly_ppe`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE `bfly_ppe`;

SET FOREIGN_KEY_CHECKS = 0;
START TRANSACTION;

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id_categorie` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_categorie`),
  UNIQUE KEY `uk_categories_libelle` (`libelle`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id_categorie`, `libelle`, `date_creation`, `date_modification`) VALUES
(1, 'particulier', '2026-04-13 16:25:01', '2026-04-19 15:59:01'),
(2, 'entreprise', '2026-04-13 16:25:01', '2026-04-13 16:25:01'),
(3, 'groupe', '2026-04-13 16:25:01', '2026-04-13 16:25:01'),
(4, 'autre', '2026-04-13 16:25:01', '2026-04-13 16:25:01');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
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
  UNIQUE KEY `uk_client_utilisateur` (`id_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `id_utilisateur`, `nom`, `prenom`, `telephone`, `adresse`, `ville`, `pays`, `date_creation`, `date_modification`) VALUES
(1, 1, 'Benali', 'Amine', '+213550000001', 'Rue Didouche Mourad', 'Alger', 'Algérie', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(2, 2, 'Kaci', 'Sara', '+213550000002', 'Boulevard Krim Belkacem', 'Tizi Ouzou', 'Algérie', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(4, 4, 'Ouali', 'Mehdi', '+213550000004', 'Rue Emir Abdelkader', 'Constantine', 'Algérie', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(6, 6, 'Haddad', 'Nassim', '+213550000006', 'Rue des Frères', 'Bejaïa', 'Algérie', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(7, 7, 'Martin', 'Julien', '+33600000001', '10 Rue de Lyon', 'Paris', 'France', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(8, 8, 'Dubois', 'Claire', '+33600000002', '20 Rue Nationale', 'Lille', 'France', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(9, 9, 'Rossi', 'Luca', '+390600000003', 'Via Roma 22', 'Rome', 'Italie', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(10, 10, 'Garcia', 'Sofia', '+34910000004', 'Calle Mayor 5', 'Madrid', 'Espagne', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(11, 11, 'Mueller', 'Hans', '+49300000005', 'Alexanderplatz 1', 'Berlin', 'Allemagne', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(12, 12, 'Johnson', 'Emma', '+442000000006', '221B Baker St', 'London', 'Royaume-Uni', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(13, 13, 'Tanaka', 'Kei', '+81300000007', 'Shibuya', 'Tokyo', 'Japon', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(14, 14, 'Silva', 'Diego', '+551100000008', 'Av. Paulista', 'São Paulo', 'Brésil', '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(16, 17, 'aylan', 'saadi', NULL, NULL, NULL, NULL, '2026-04-02 12:26:13', '2026-04-02 12:26:13'),
(17, 18, 'nina', 'nina', NULL, NULL, NULL, NULL, '2026-04-09 11:17:21', '2026-04-09 11:17:21'),
(20, 21, 'SAADI', 'Atef', NULL, NULL, NULL, NULL, '2026-04-10 14:14:52', '2026-04-10 14:14:52'),
(21, 22, 'ilo', 'nin', NULL, NULL, NULL, NULL, '2026-04-19 15:41:14', '2026-04-19 15:41:14');

-- --------------------------------------------------------

--
-- Structure de la table `continents`
--

DROP TABLE IF EXISTS `continents`;
CREATE TABLE IF NOT EXISTS `continents` (
  `id_continent` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id_continent`),
  UNIQUE KEY `uk_continents_nom` (`nom`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `continents`
--

INSERT INTO `continents` (`id_continent`, `nom`) VALUES
(2, 'Afrique'),
(4, 'Amérique du Nord'),
(5, 'Amérique du Sud'),
(3, 'Asie'),
(1, 'Europe'),
(6, 'Océanie');

-- --------------------------------------------------------

--
-- Structure de la table `destinations`
--

DROP TABLE IF EXISTS `destinations`;
CREATE TABLE IF NOT EXISTS `destinations` (
  `id_destination` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `pays` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_continent` int UNSIGNED DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `prix_base` decimal(10,2) NOT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_destination`),
  UNIQUE KEY `uk_destination_pays_ville` (`pays`,`ville`),
  KEY `idx_destinations_continent` (`id_continent`),
  KEY `idx_destinations_actif` (`actif`),
  KEY `idx_destinations_pays_ville` (`pays`,`ville`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `destinations`
--

INSERT INTO `destinations` (`id_destination`, `pays`, `ville`, `id_continent`, `description`, `prix_base`, `image_url`, `actif`, `date_creation`, `date_modification`) VALUES
(1, 'Algérie', 'Alger', 2, 'Capitale, Casbah, baie d\'Alger', 180.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(2, 'Algérie', 'Oran', 2, 'Front de mer, culture et gastronomie', 160.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(3, 'Algérie', 'Constantine', 2, 'Ville des ponts, patrimoine', 150.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(4, 'Algérie', 'Annaba', 2, 'Plages et histoire', 155.00, NULL, 0, '2026-03-31 11:37:29', '2026-04-10 09:48:28'),
(5, 'Algérie', 'Tamanrasset', 2, 'Sahara, aventure', 220.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(6, 'Algérie', 'Bejaïa', 2, 'Côte, nature, randonnées', 145.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(7, 'France', 'Paris', 1, 'Musées, monuments', 320.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(8, 'France', 'Nice', 1, 'Riviera, mer', 290.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(9, 'Espagne', 'Barcelone', 1, 'Architecture, plage', 280.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(10, 'Italie', 'Rome', 1, 'Histoire, cuisine', 300.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(11, 'Portugal', 'Lisbonne', 1, 'Ville colorée', 260.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(12, 'Allemagne', 'Berlin', 1, 'Culture et nightlife', 270.00, NULL, 0, '2026-03-31 11:37:29', '2026-04-10 09:50:37'),
(13, 'Royaume-Uni', 'Londres', 1, 'City trip', 340.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(14, 'Pays-Bas', 'Amsterdam', 1, 'Canaux, musées', 310.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(15, 'Grèce', 'Athènes', 1, 'Antiquité', 275.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(16, 'Suisse', 'Genève', 1, 'Lac, montagne', 360.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(17, 'Japon', 'Tokyo', 3, 'Modernité, temples', 520.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(18, 'Thaïlande', 'Bangkok', 3, 'Street food, marchés', 430.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(19, 'Émirats Arabes Unis', 'Dubaï', 3, 'Luxe et désert', 480.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(20, 'Turquie', 'Istanbul', 3, 'Entre deux mondes', 350.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(21, 'Indonésie', 'Bali', 3, 'Plages, détente', 450.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(22, 'Vietnam', 'Hanoï', 3, 'Culture et nature', 410.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(23, 'USA', 'New York', 4, 'City trip', 650.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(24, 'Canada', 'Montréal', 4, 'Culture francophone', 590.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(25, 'Mexique', 'Cancún', 4, 'Mer et soleil', 520.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(26, 'USA', 'Miami', 4, 'Plage et ambiance', 610.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(27, 'Brésil', 'Rio de Janeiro', 5, 'Plages, carnaval', 680.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(28, 'Argentine', 'Buenos Aires', 5, 'Tango, culture', 640.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(29, 'Australie', 'Sydney', 6, 'Opéra, plages', 820.00, NULL, 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29');

-- --------------------------------------------------------

--
-- Structure de la table `offres`
--

DROP TABLE IF EXISTS `offres`;
CREATE TABLE IF NOT EXISTS `offres` (
  `id_offre` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_destination` int UNSIGNED NOT NULL,
  `titre` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pourcentage_reduction` int UNSIGNED NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_offre`),
  KEY `idx_offre_destination` (`id_destination`),
  KEY `idx_offres_actif_dates` (`actif`,`date_debut`,`date_fin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `offres`
--

INSERT INTO `offres` (`id_offre`, `id_destination`, `titre`, `pourcentage_reduction`, `date_debut`, `date_fin`, `actif`, `date_creation`, `date_modification`) VALUES
(1, 1, 'Promo Alger - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(2, 6, 'Promo Bejaïa - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(3, 2, 'Promo Oran - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(4, 9, 'Promo Barcelone - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(5, 8, 'Promo Nice - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(6, 7, 'Promo Paris - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(7, 10, 'Promo Rome - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(8, 14, 'Promo Amsterdam - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(9, 11, 'Promo Lisbonne - 15%', 15, '2026-04-01', '2026-05-15', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(17, 27, 'Offre Flash Rio de Janeiro - 20%', 20, '2026-04-10', '2026-06-01', 0, '2026-03-31 11:37:37', '2026-04-10 09:49:32'),
(18, 19, 'Offre Flash Dubaï - 20%', 20, '2026-04-10', '2026-06-01', 1, '2026-03-31 11:37:37', '2026-03-31 11:37:37'),
(19, 21, 'Offre Flash Bali - 20%', 20, '2026-04-10', '2026-06-01', 1, '2026-03-31 11:37:37', '2026-03-31 11:37:37'),
(20, 17, 'Offre Flash Tokyo - 20%', 20, '2026-04-10', '2026-06-01', 1, '2026-03-31 11:37:37', '2026-03-31 11:37:37'),
(22, 25, 'Offre Flash Cancún - 20%', 20, '2026-04-10', '2026-06-01', 1, '2026-03-31 11:37:37', '2026-03-31 11:37:37'),
(23, 20, 'Offre Flash Istanbul - 20%', 20, '2026-04-10', '2026-06-01', 1, '2026-03-31 11:37:37', '2026-03-31 11:37:37'),
(24, 26, 'Offre Flash Miami - 20%', 20, '2026-04-10', '2026-06-01', 1, '2026-03-31 11:37:37', '2026-03-31 11:37:37'),
(25, 23, 'Offre Flash New York - 20%', 20, '2026-04-10', '2026-06-01', 1, '2026-03-31 11:37:37', '2026-03-31 11:37:37'),
(26, 2, 'Offre Oran Découverte - 14%', 14, '2026-04-19', '2026-04-28', 1, '2026-04-19 16:03:35', '2026-04-19 16:03:35'),
(27, 4, 'Offre Annaba Plage - 30%', 30, '2026-04-19', '2026-04-19', 1, '2026-04-19 16:05:58', '2026-04-19 16:05:58'),
(28, 4, 'Offre Annaba Premium - 50%', 50, '2026-04-19', '2026-04-30', 1, '2026-04-19 16:07:08', '2026-04-19 16:07:08'),
(29, 5, 'Offre Tamanrasset Aventure - 30%', 30, '2026-04-19', '2026-04-24', 1, '2026-04-19 16:08:21', '2026-04-19 16:08:21');

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
  `statut` enum('en_attente','confirmee','annulee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `date_reservation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation_destination`),
  KEY `idx_resa_dest_client` (`id_client`),
  KEY `idx_resa_dest_destination` (`id_destination`),
  KEY `idx_resa_dest_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations_destinations`
--

INSERT INTO `reservations_destinations` (`id_reservation_destination`, `id_client`, `id_destination`, `date_depart`, `date_retour`, `nb_personnes`, `prix_total`, `statut`, `date_reservation`, `date_modification`) VALUES
(4, 20, 6, '2026-04-24', '2026-04-30', 1, 739.50, 'en_attente', '2026-04-10 14:54:12', '2026-04-11 15:25:35'),
(5, 20, 6, '2026-04-11', '2026-05-02', 1, 2588.25, 'en_attente', '2026-04-11 09:59:41', '2026-04-11 15:25:42'),
(6, 20, 6, '2026-04-17', '2026-04-22', 2, 1232.50, 'confirmee', '2026-04-17 08:52:33', '2026-04-17 08:52:47');

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
  `statut` enum('en_attente','confirmee','annulee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en_attente',
  `date_reservation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_reservation_voyage`),
  KEY `idx_resa_voy_client` (`id_client`),
  KEY `idx_resa_voy_voyage` (`id_voyage`),
  KEY `idx_resa_voy_statut` (`statut`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `reservations_voyages`
--

INSERT INTO `reservations_voyages` (`id_reservation_voyage`, `id_client`, `id_voyage`, `nb_personnes`, `prix_total`, `statut`, `date_reservation`, `date_modification`) VALUES
(6, 20, 1, 1, 275.40, 'annulee', '2026-04-10 14:53:40', '2026-04-11 10:02:24'),
(7, 20, 2, 1, 244.80, 'confirmee', '2026-04-11 10:00:00', '2026-04-11 10:02:30');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

DROP TABLE IF EXISTS `utilisateurs`;
CREATE TABLE IF NOT EXISTS `utilisateurs` (
  `id_utilisateur` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mot_de_passe_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('client','admin') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'client',
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_modification` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `uk_utilisateurs_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `email`, `mot_de_passe_hash`, `role`, `actif`, `date_creation`, `date_modification`) VALUES
(1, 'amine.benali@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 0, '2026-03-31 11:37:29', '2026-04-15 10:54:55'),
(2, 'sara.kaci@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(4, 'mehdi.ouali@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(6, 'nassim.haddad@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(7, 'julien.martin@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(8, 'claire.dubois@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(9, 'luca.rossi@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(10, 'sofia.garcia@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(11, 'hans.mueller@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(12, 'emma.johnson@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 0, '2026-03-31 11:37:29', '2026-04-15 10:54:58'),
(13, 'kei.tanaka@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(14, 'diego.silva@bfly.com', '$2y$12$6mfYL/.r.AF5iLPmC4VR0ObktMUkrp6TUo04o7n0zlYAY0kabuJSu', 'client', 1, '2026-03-31 11:37:29', '2026-03-31 11:37:29'),
(15, 'admin@bfly.com', '$2y$12$HeiswY/EhJ.TRFlj4euDaee..BuxxD4ZkgCQQ4fCmuwYbK2eclSSK', 'admin', 1, '2026-03-31 11:37:29', '2026-04-10 10:10:09'),
(17, 'aylan@gmail.com', '$2y$10$556AzencrYUZHKfb9wKMXeFFPTnrjt7E1Hsqh3pzgwGVZ4abBvadm', 'admin', 1, '2026-04-02 12:26:13', '2026-04-19 15:59:40'),
(18, 'nina@gmail.com', '$2y$10$gIcEe8EBHU0P2qdjRe.1I.dYdmyPdXPwisyUBw8n.hdF03M2kwax2', 'admin', 1, '2026-04-09 11:17:21', '2026-04-09 11:18:03'),
(21, 'atef_saadi@outlook.fr', '$2y$10$WzgcujudeewZfXrp/haweODPKsSatp7VMfyzAk9oGJitSTqi4ij8K', 'client', 1, '2026-04-10 14:14:52', '2026-04-10 23:12:02'),
(22, 'elo@gmail.com', '$2y$10$qGJ3dLihq8JaWY6/HCCZIu1F5R.JQI5S25vEDr112keICp/Padzwe', 'client', 1, '2026-04-19 15:41:14', '2026-04-19 15:41:14');

-- --------------------------------------------------------

--
-- Structure de la table `voyages_organises`
--

DROP TABLE IF EXISTS `voyages_organises`;
CREATE TABLE IF NOT EXISTS `voyages_organises` (
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
  `id_categorie` int UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id_voyage`),
  KEY `idx_voyage_destination` (`id_destination`),
  KEY `idx_voyages_statut_date` (`statut`,`date_depart`),
  KEY `idx_voyage_categorie` (`id_categorie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `voyages_organises`
--

INSERT INTO `voyages_organises` (`id_voyage`, `id_destination`, `titre`, `description`, `date_depart`, `date_retour`, `prix`, `nb_places`, `nb_places_restantes`, `image_url`, `statut`, `date_creation`, `date_modification`, `id_categorie`) VALUES
(1, 1, 'Séjour à Alger', 'Voyage organisé vers Alger (Algérie)', '2026-06-10', '2026-06-17', 324.00, 30, 21, 'images/voyages/voyage_1776606184_e5ee1bb0d3ea.jpeg', 'actif', '2026-03-31 11:37:29', '2026-04-19 15:43:04', NULL),
(2, 2, 'Séjour à Oran', 'Voyage organisé vers Oran (Algérie)', '2026-06-10', '2026-06-17', 288.00, 30, 27, NULL, 'actif', '2026-03-31 11:37:29', '2026-04-11 10:00:00', NULL),
(3, 5, 'Séjour à Tamanrasset', 'Voyage organisé vers Tamanrasset (Algérie)', '2026-06-10', '2026-06-17', 396.00, 30, 30, NULL, 'actif', '2026-03-31 11:37:29', '2026-03-31 11:37:29', NULL),
(4, 7, 'City Break Paris', 'Court séjour découverte à Paris', '2026-07-05', '2026-07-10', 512.00, 25, 25, NULL, 'actif', '2026-03-31 11:37:29', '2026-03-31 11:37:29', NULL),
(5, 9, 'City Break Barcelone', 'Court séjour découverte à Barcelone', '2026-07-05', '2026-07-10', 448.00, 25, 25, NULL, 'actif', '2026-03-31 11:37:29', '2026-03-31 11:37:29', NULL),
(6, 10, 'City Break Rome', 'Court séjour découverte à Rome', '2026-07-05', '2026-07-10', 480.00, 25, 25, NULL, 'actif', '2026-03-31 11:37:29', '2026-03-31 11:37:29', NULL),
(7, 13, 'City Break Londres', 'Court séjour découverte à Londres', '2026-07-05', '2026-07-10', 544.00, 25, 25, NULL, 'actif', '2026-03-31 11:37:29', '2026-04-13 17:20:21', 1),
(8, 14, 'City Break Amsterdam', 'Court séjour découverte à Amsterdam', '2026-07-05', '2026-07-10', 496.00, 25, 25, NULL, 'actif', '2026-03-31 11:37:29', '2026-03-31 11:37:29', NULL),
(13, 19, 'Évasion Dubaï', 'Séjour détente et visites à Dubaï', '2026-08-12', '2026-08-20', 816.00, 20, 20, 'images/voyages/voyage_1776606810_116e0cb6d1be.jpeg', 'actif', '2026-03-31 11:37:29', '2026-04-19 15:53:30', NULL),
(14, 21, 'Évasion Bali', 'Séjour détente et visites à Bali', '2026-08-12', '2026-08-20', 765.00, 20, 20, 'images/voyages/voyage_1776606824_6b0701645945.jpg', 'actif', '2026-03-31 11:37:29', '2026-04-19 15:53:44', NULL),
(15, 23, 'Évasion New York', 'Séjour détente et visites à New York', '2026-08-12', '2026-08-20', 1105.00, 20, 20, 'images/voyages/voyage_1776606914_b79df5ad3c0a.webp', 'actif', '2026-03-31 11:37:29', '2026-04-19 15:55:14', NULL),
(16, 27, 'Évasion Rio de Janeiro', 'Séjour détente et visites à Rio de Janeiro', '2026-08-12', '2026-08-20', 1156.00, 20, 20, NULL, 'actif', '2026-03-31 11:37:29', '2026-03-31 11:37:29', NULL);

--
-- Déclencheurs `voyages_organises`
--
DROP TRIGGER IF EXISTS `trg_voyage_depart_insert`;
DELIMITER $$
CREATE TRIGGER `trg_voyage_depart_insert` BEFORE INSERT ON `voyages_organises` FOR EACH ROW BEGIN
    IF NEW.date_depart < DATE_ADD(CURDATE(), INTERVAL 3 DAY) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La date de départ doit être au moins 3 jours après la date du jour';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_voyage_depart_update`;
DELIMITER $$
CREATE TRIGGER `trg_voyage_depart_update` BEFORE UPDATE ON `voyages_organises` FOR EACH ROW BEGIN
    IF NEW.date_depart < DATE_ADD(CURDATE(), INTERVAL 3 DAY) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La date de départ doit être au moins 3 jours après la date du jour';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_voyage_duree_insert`;
DELIMITER $$
CREATE TRIGGER `trg_voyage_duree_insert` BEFORE INSERT ON `voyages_organises` FOR EACH ROW BEGIN
    IF DATEDIFF(NEW.date_retour, NEW.date_depart) > 30 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La durée du voyage ne doit pas dépasser 30 jours';
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_voyage_duree_update`;
DELIMITER $$
CREATE TRIGGER `trg_voyage_duree_update` BEFORE UPDATE ON `voyages_organises` FOR EACH ROW BEGIN
    IF DATEDIFF(NEW.date_retour, NEW.date_depart) > 30 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La durée du voyage ne doit pas dépasser 30 jours';
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
  ADD CONSTRAINT `fk_voyage_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id_categorie`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_voyage_destination` FOREIGN KEY (`id_destination`) REFERENCES `destinations` (`id_destination`) ON DELETE CASCADE ON UPDATE CASCADE;
SET FOREIGN_KEY_CHECKS = 1;
COMMIT;


-- =========================================================
-- Comptes de démonstration
-- Admin : admin@bfly.com / 123
-- Utilisateurs clients de démonstration : mot de passe client123
-- =========================================================

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
