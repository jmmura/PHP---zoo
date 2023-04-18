<meta charset="UTF-8">
<?php
//on crée notre requête pour initialiser la base de données et les tables
$req ="-- On crée notre base de données
DROP DATABASE IF EXISTS group20;
CREATE DATABASE IF NOT EXISTS group20;
USE group20;

-- On va créer nos tables
-- Institution
CREATE TABLE IF NOT EXISTS Institution(
	nom_institution VARCHAR(50) NOT NULL,
	rue VARCHAR(50) NOT NULL,
	code_postal VARCHAR(50) NOT NULL,
	pays VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(nom_institution)
)
ENGINE=INNODB;

-- Espèce
CREATE TABLE IF NOT EXISTS Espece(
	nom_scientifique VARCHAR(50) NOT NULL,
	nom_courant VARCHAR(50) NOT NULL,
	regime_alimentaire VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(nom_scientifique)
)
ENGINE=INNODB;

-- Climat
CREATE TABLE IF NOT EXISTS Climat(
	nom_scientifique VARCHAR(50) NOT NULL,
	nom_climat VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(nom_climat, nom_scientifique),
	
	FOREIGN KEY(nom_scientifique) REFERENCES Espece(nom_scientifique)
)
ENGINE=INNODB;

-- Enclos
CREATE TABLE IF NOT EXISTS Enclos(
	n_enclos INT NOT NULL,
	climat VARCHAR(50) NOT NULL,
	taille INT NOT NULL,
	
	PRIMARY KEY(n_enclos)
)
ENGINE=INNODB;

-- Animal
CREATE TABLE IF NOT EXISTS Animal(
	nom_scientifique VARCHAR(50) NOT NULL,
	n_puce INT NOT NULL,
	taille INT NOT NULL,
	sexe CHAR(1) CHECK (VALUE IN ('M', 'F')),
	date_naissance VARCHAR(10) NOT NULL,
	n_enclos INT NOT NULL,
	
	PRIMARY KEY(nom_scientifique, n_puce),
	
	FOREIGN KEY(nom_scientifique) REFERENCES Espece(nom_scientifique),
	FOREIGN KEY(n_enclos) REFERENCES Enclos(n_enclos)
)
ENGINE=INNODB;

-- Matériel
CREATE TABLE IF NOT EXISTS Materiel(
	n_materiel INT NOT NULL,
	etat VARCHAR(50) NOT NULL,
	local VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(n_materiel)
)
ENGINE=INNODB;

-- Personnel
CREATE TABLE IF NOT EXISTS Personnel(
	n_registre INT NOT NULL,
	nom VARCHAR(50) NOT NULL,
	prenom VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(n_registre)
)
ENGINE=INNODB;

-- Vétérinaire
CREATE TABLE IF NOT EXISTS Veterinaire(
	n_registre INT NOT NULL,
	n_licence INT NOT NULL,
	specialite VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(n_registre),
	
	FOREIGN KEY(n_registre) REFERENCES Personnel(n_registre)
)
ENGINE=INNODB;

-- Technicien
CREATE TABLE IF NOT EXISTS Technicien(
	n_registre INT NOT NULL,
	
	PRIMARY KEY(n_registre),
	
	FOREIGN KEY(n_registre) REFERENCES Personnel(n_registre)
)
ENGINE=INNODB;

ALTER TABLE Personnel
ADD CONSTRAINT veterinaire_ou_technicien
CHECK (n_registre IN (Technicien.n_registre, Veterinaire.n_registre));

-- Intervention
CREATE TABLE IF NOT EXISTS Intervention(
	n_intervention INT NOT NULL,
	date VARCHAR(10) NOT NULL,
	description VARCHAR(50) NOT NULL,
	n_registre INT NOT NULL,
	nom_scientifique VARCHAR(50) NOT NULL,
	n_puce INT NOT NULL,
	
	PRIMARY KEY(n_intervention),
	
	FOREIGN KEY(n_registre) REFERENCES Personnel(n_registre),
	FOREIGN KEY(nom_scientifique, n_puce) REFERENCES Animal(nom_scientifique, n_puce)
)
ENGINE=INNODB;

-- Entretien
CREATE TABLE IF NOT EXISTS Entretien(
	n_entretien INT NOT NULL,
	n_registre INT NOT NULL,
	n_materiel INT NOT NULL,
	date VARCHAR(10) NOT NULL,
	n_enclos INT NOT NULL,
	
	PRIMARY KEY(n_entretien),
	
	FOREIGN KEY(n_registre) REFERENCES Personnel(n_registre),
	FOREIGN KEY(n_materiel) REFERENCES Materiel(n_materiel),
	FOREIGN KEY(n_enclos) REFERENCES Enclos(n_enclos)
)
ENGINE=INNODB;

-- Provenance
CREATE TABLE IF NOT EXISTS Provenance(
	nom_scientifique VARCHAR(50) NOT NULL,
	n_puce INT NOT NULL,
	nom_institution VARCHAR(50) NOT NULL,
	
	PRIMARY KEY(nom_scientifique, n_puce),
	
	FOREIGN KEY(nom_scientifique, n_puce) REFERENCES Animal(nom_scientifique, n_puce),
	FOREIGN KEY(nom_institution) REFERENCES Institution(nom_institution)
)
ENGINE=INNODB;

-- On va remplir nos tables
-- Institution
LOAD DATA LOCAL INFILE 'Institution.txt'
INTO TABLE group20.Institution
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (nom (str), rue (str), code_postal (str), pays (str))

-- Espece
LOAD DATA LOCAL INFILE 'Espece.txt'
INTO TABLE group20.Espece
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- nom_latin (str), nom_courant (str), regime_alimentaire (str))

-- Climat
LOAD DATA LOCAL INFILE 'Climat.txt'
INTO TABLE group20.Climat
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (nom_latin (str), nom_climat (str))

-- Enclos
LOAD DATA LOCAL INFILE 'Enclos.txt'
INTO TABLE group20.Enclos
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (n_enclos (int), nom_climat (str), taille (int))

-- Animal
LOAD DATA LOCAL INFILE 'Animal.txt'
INTO TABLE group20.Animal
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (nom_scientifique (str), n_puce (int), taille (int), sexe (str), date_naissance (str), n_enclos (int))

-- Materiel
LOAD DATA LOCAL INFILE 'Materiel.txt'
INTO TABLE group20.Materiel
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (n_matériel (int), état (str), local (str))

-- Personnel
LOAD DATA LOCAL INFILE 'Personnel.txt'
INTO TABLE group20.Personnel
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (nom (str), prenom (str), n_registre (int))

-- Technicien
LOAD DATA LOCAL INFILE 'Technicien.txt'
INTO TABLE group20.Technicien
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (n_registre (int))

-- Veterinaire
LOAD DATA LOCAL INFILE 'Veterinaire.txt'
INTO TABLE group20.Veterinaire
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (n_registre (int), n_licence (int), specialite (str))

-- Intervention
LOAD DATA LOCAL INFILE 'Intervention.txt'
INTO TABLE group20.Intervention
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (n_intervention (int), date (str), description (str), n_registre (int), nom_latin (str), n_puce (int))

-- Entretien
LOAD DATA LOCAL INFILE 'Entretien.txt'
INTO TABLE group20.Entretien
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (n_entretien (int), n_registre (int), n_materiel (int), date (str), n_enclos (int))

-- Provenance
LOAD DATA LOCAL INFILE 'Provenance.txt'
INTO TABLE group20.Provenance
FIELDS
	TERMINATED BY ','
LINES
	TERMINATED BY '\n'

IGNORE 1 LINES;
-- (nom_latin (str), n_puce (int), nom_institution (str))";

$bdd = new PDO('mysql:host=ms800.montefiore.ulg.ac.be;dbname=;charset=utf8','group20','mwsVo+5IXq');
$bdd->query($req);

header('Location: Menu.php',true,301);
?>