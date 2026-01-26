-- TABLE utilisateurs
CREATE TABLE utilisateurs (
  idutil INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  mot_de_passe VARCHAR(255) NOT NULL,
  telephone VARCHAR(20) DEFAULT NULL,
  role ENUM('client','admin') DEFAULT 'client',
  date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
  date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (idutil)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLE destinations
CREATE TABLE destinations (
  id_destination INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(100) NOT NULL,
  continent VARCHAR(50),
  description TEXT,
  image VARCHAR(255),
  PRIMARY KEY (id_destination)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLE voyages
CREATE TABLE voyages (
  id_voyage INT NOT NULL AUTO_INCREMENT,
  titre VARCHAR(100) NOT NULL,
  prix_adulte DECIMAL(10,2) NOT NULL,
  prix_enfant DECIMAL(10,2) NOT NULL,
  prix_bebe DECIMAL(10,2) NOT NULL,
  duree INT NOT NULL,
  description TEXT,
  image VARCHAR(255),
  id_destination INT NOT NULL,
  PRIMARY KEY (id_voyage),
  FOREIGN KEY (id_destination) REFERENCES destinations(id_destination)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- TABLE reservations
CREATE TABLE reservations (
  id_reservation INT NOT NULL AUTO_INCREMENT,
  id_utilisateur INT NOT NULL,
  id_voyage INT NOT NULL,
  nombre_adultes INT DEFAULT 0,
  nombre_enfants INT DEFAULT 0,
  nombre_bebes INT DEFAULT 0,
  date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
  statut ENUM('en attente','confirmée') DEFAULT 'en attente',
  PRIMARY KEY (id_reservation),
  FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(idutil),
  FOREIGN KEY (id_voyage) REFERENCES voyages(id_voyage)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE voyages
ADD COLUMN ville_depart VARCHAR(100) DEFAULT 'Paris';


UPDATE voyages SET ville_depart = 'Paris' WHERE id_voyage = 1;
UPDATE voyages SET ville_depart = 'Lyon' WHERE id_voyage = 2;
UPDATE voyages SET ville_depart = 'Marseille' WHERE id_voyage = 3;


CREATE TABLE slides (
    id_slide INT NOT NULL AUTO_INCREMENT,
    titre VARCHAR(100) NOT NULL,
    description TEXT,
    image VARCHAR(255) NOT NULL,
    lien VARCHAR(255) DEFAULT NULL,
    ordre INT DEFAULT 0,
    actif TINYINT(1) DEFAULT 1,
    PRIMARY KEY (id_slide)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE IF NOT EXISTS continents (
  id_continent INT AUTO_INCREMENT PRIMARY KEY,
  nom VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO continents (nom) VALUES
('Afrique'), ('Amérique du Nord'), ('Amérique du Sud'),
('Asie'), ('Europe'), ('Océanie');

ALTER TABLE destinations
  ADD COLUMN id_continent INT NULL;



ALTER TABLE destinations
  ADD CONSTRAINT fk_destinations_continents
  FOREIGN KEY (id_continent) REFERENCES continents(id_continent)
  ON UPDATE CASCADE
  ON DELETE SET NULL;

CREATE TABLE offres (
    id_offre INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(150) NOT NULL,
    reduction INT NOT NULL,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    description TEXT,
    actif TINYINT(1) DEFAULT 1,
    id_voyage INT NOT NULL,

    CONSTRAINT fk_offres_voyages
        FOREIGN KEY (id_voyage)
        REFERENCES voyages(id_voyage)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
