-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 01 avr. 2021 à 01:10
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `webmaster`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `afficher` (`id` INT, `idu` INT)  BEGIN
DECLARE nbr INT;
DECLARE debut VARCHAR(10000);
DECLARE lefrom VARCHAR(10000);
DECLARE fin VARCHAR(10000);
DECLARE inc INT;
DECLARE koueri VARCHAR(10000);
SET inc = 0;

SELECT COUNT(nom_competence) INTO nbr FROM competences, requerir WHERE competences.idcompetence = requerir.idcompetence AND idoffre = id;



IF nbr = 0 THEN
	SET lefrom = '';
	SET fin = '';
	SET debut = CONCAT('SELECT intitule_offre, description, nom_entreprise FROM offres_de_stage, entreprises
	WHERE offres_de_stage.IDENTREPRISE = entreprises.IDENTREPRISE
	AND NOT EXISTS (SELECT IDOFFRE FROM candidatures WHERE IDUTILISATEUR = ',idu,' AND offres_de_stage.IDOFFRE = candidatures.IDOFFRE)
	AND NOT EXISTS (SELECT IDOFFRE FROM met_en_wishlist WHERE IDUTILISATEUR = ',idu,' AND offres_de_stage.IDOFFRE = met_en_wishlist.IDOFFRE)
	AND idoffre = ',id, ' LIMIT 1');
	
ELSEIF nbr = 1 THEN
	SET lefrom = '';
	SET fin = '';
	SET debut = CONCAT('SELECT intitule_offre, description, nom_entreprise, nom_competence FROM offres_de_stage, entreprises, competences, requerir
	WHERE offres_de_stage.IDENTREPRISE = entreprises.IDENTREPRISE
	AND NOT EXISTS (SELECT IDOFFRE FROM candidatures WHERE IDUTILISATEUR = ',idu,' AND offres_de_stage.IDOFFRE = candidatures.IDOFFRE)
	AND NOT EXISTS (SELECT IDOFFRE FROM met_en_wishlist WHERE IDUTILISATEUR = ',idu,' AND offres_de_stage.IDOFFRE = met_en_wishlist.IDOFFRE)
	AND competences.idcompetence = requerir.idcompetence AND offres_de_stage.idoffre = requerir.idoffre
	AND offres_de_stage.idoffre = ',id, ' LIMIT 1');

ELSE
	SET debut = 'SELECT intitule_offre, description, nom_entreprise';
	SET lefrom = 'FROM offres_de_stage, entreprises, competences, requerir';
	SET fin = CONCAT('WHERE offres_de_stage.IDENTREPRISE = entreprises.IDENTREPRISE
	AND NOT EXISTS (SELECT IDOFFRE FROM candidatures WHERE IDUTILISATEUR = ',idu,' AND offres_de_stage.IDOFFRE = candidatures.IDOFFRE)
	AND NOT EXISTS (SELECT IDOFFRE FROM met_en_wishlist WHERE IDUTILISATEUR = ',idu,' AND offres_de_stage.IDOFFRE = met_en_wishlist.IDOFFRE)
	AND offres_de_stage.idoffre = ',id, ' LIMIT 1');
	
	WHILE inc < nbr DO
		SET debut = CONCAT (debut, ', nom_competence', inc, ' ');
		
		SET lefrom = CONCAT (lefrom, ',  (SELECT nom_competence AS nom_competence',inc,' FROM requerir, competences
		WHERE requerir.idcompetence = competences.idcompetence AND IDOFFRE = ',id,' LIMIT ',inc,',1) AS comp',inc, ' ');
		
		SET inc = inc + 1;
	END WHILE;	

END IF;

SET koueri = CONCAT(debut,lefrom,fin);
PREPARE kouerii FROM koueri;
EXECUTE kouerii;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `a`
--

CREATE TABLE `a` (
  `IDUTILISATEUR` int(11) NOT NULL,
  `IDCOMPETENCE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `autorisations`
--

CREATE TABLE `autorisations` (
  `IDAUTORISATION` int(11) NOT NULL,
  `AUTORISATIONS` tinyblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `candidatures`
--

CREATE TABLE `candidatures` (
  `IDCANDIDATURE` int(11) NOT NULL,
  `IDOFFRE` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) NOT NULL,
  `ETAT_AVANCEMENT` smallint(6) NOT NULL,
  `STATUT` smallint(6) NOT NULL,
  `CV` varchar(50) NOT NULL,
  `LDM` varchar(50) NOT NULL,
  `FICHE_VALIDATION` varchar(50) DEFAULT NULL,
  `CONVENTION` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déclencheurs `candidatures`
--
DELIMITER $$
CREATE TRIGGER `notification_in` AFTER INSERT ON `candidatures` FOR EACH ROW BEGIN
DECLARE inc INT;
DECLARE nbrpilotes INT;
DECLARE idc INT;
DECLARE ide INT;
DECLARE idcampus INT;
DECLARE idpromo INT;
DECLARE nometudiant VARCHAR(10000);
DECLARE nomentreprise VARCHAR(10000);
DECLARE laquery VARCHAR(10000);
SET idc = new.idcandidature;
SET ide = new.idutilisateur;
SET idcampus = (SELECT idcentre FROM etudier_a WHERE idutilisateur = ide);
SET idpromo = (SELECT idpromotion FROM faire_partie_ou_encadrer WHERE idutilisateur = ide);
SET nometudiant = (SELECT CONCAT(prenom, " ", nom) FROM utilisateurs WHERE idutilisateur = ide);
SET nomentreprise = (SELECT nom_entreprise FROM entreprises, offres_de_stage WHERE offres_de_stage.idoffre = new.idoffre AND offres_de_stage.identreprise = entreprises.identreprise);
SET inc = 0;
SET laquery = "";
SET nbrpilotes = (SELECT COUNT(utilisateurs.idutilisateur) FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND idrole = 2);
	

IF new.etat_avancement = 1 THEN
	
	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT(nometudiant, " a postulé à l'offre de ", nomentreprise, "."), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND idrole = 2) AS pilotes;
	
ELSEIF new.etat_avancement = 3 THEN

	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT(nomentreprise, " a renvoyé à ", nometudiant, " la fiche de validation signée;"), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND idrole = 2) AS pilotes;
	
ELSEIF new.etat_avancement = 5 THEN

	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT("La convention de stage de ", nometudiant, " a été envoyée à ", nomentreprise, "."), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND (idrole = 2 OR utilisateurs.idutilisateur = ide)) AS pilotes;
	
	UPDATE notifications SET contenu = (SELECT CONCAT("La convention de stage a été envoyée à ", nomentreprise)) WHERE idcandidature = idc AND idutilisateur = ide;
	
ELSEIF new.etat_avancement = 6 THEN

	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT(nomentreprise, " a renvoyé à ", nometudiant, " la convention de stage signée."), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND (idrole = 2 OR utilisateurs.idutilisateur = ide)) AS pilotes;
	
	UPDATE notifications SET contenu = (SELECT CONCAT(nomentreprise, " t'a renvoyé la convention de stage signée.")) WHERE idcandidature = idc AND idutilisateur = ide;

END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `notification_up` AFTER UPDATE ON `candidatures` FOR EACH ROW BEGIN
DECLARE inc INT;
DECLARE nbrpilotes INT;
DECLARE idc INT;
DECLARE ide INT;
DECLARE idcampus INT;
DECLARE idpromo INT;
DECLARE nometudiant VARCHAR(10000);
DECLARE nomentreprise VARCHAR(10000);
DECLARE laquery VARCHAR(10000);
SET idc = new.idcandidature;
SET ide = new.idutilisateur;
SET idcampus = (SELECT idcentre FROM etudier_a WHERE idutilisateur = ide);
SET idpromo = (SELECT idpromotion FROM faire_partie_ou_encadrer WHERE idutilisateur = ide);
SET nometudiant = (SELECT CONCAT(prenom, " ", nom) FROM utilisateurs WHERE idutilisateur = ide);
SET nomentreprise = (SELECT nom_entreprise FROM entreprises, offres_de_stage WHERE offres_de_stage.idoffre = new.idoffre AND offres_de_stage.identreprise = entreprises.identreprise);
SET inc = 0;
SET laquery = "";
SET nbrpilotes = (SELECT COUNT(utilisateurs.idutilisateur) FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND idrole = 2);
	

IF new.etat_avancement = 1 AND new.etat_avancement <> old.etat_avancement THEN
	
	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT(nometudiant, " a postulé à l'offre de ", nomentreprise, "."), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND idrole = 2) AS pilotes;
	
ELSEIF new.etat_avancement = 3 AND new.etat_avancement <> old.etat_avancement THEN

	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT(nomentreprise, " a renvoyé à ", nometudiant, " la fiche de validation signée;"), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND idrole = 2) AS pilotes;
	
ELSEIF new.etat_avancement = 5 AND new.etat_avancement <> old.etat_avancement THEN

	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT("La convention de stage de ", nometudiant, " a été envoyée à ", nomentreprise, "."), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND (idrole = 2 OR utilisateurs.idutilisateur = ide)) AS pilotes;
	
	UPDATE notifications SET contenu = (SELECT CONCAT("La convention de stage a été envoyée à ", nomentreprise)) WHERE idcandidature = idc AND idutilisateur = ide;
	
ELSEIF new.etat_avancement = 6 AND new.etat_avancement <> old.etat_avancement THEN

	INSERT INTO notifications (idcandidature, idutilisateur, contenu, vue) SELECT idc, idp, CONCAT(nomentreprise, " a renvoyé à ", nometudiant, " la convention de stage signée."), 0
	FROM (SELECT utilisateurs.idutilisateur AS idp FROM utilisateurs, etudier_a, faire_partie_ou_encadrer 
	WHERE utilisateurs.idutilisateur = faire_partie_ou_encadrer.idutilisateur AND utilisateurs.idutilisateur = etudier_a.idutilisateur
	AND faire_partie_ou_encadrer.idpromotion = idpromo AND etudier_a.idcentre = idcampus AND (idrole = 2 OR utilisateurs.idutilisateur = ide)) AS pilotes;
	
	UPDATE notifications SET contenu = (SELECT CONCAT(nomentreprise, " t'a renvoyé la convention de stage signée.")) WHERE idcandidature = idc AND idutilisateur = ide;

END IF;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `centres`
--

CREATE TABLE `centres` (
  `IDCENTRE` int(11) NOT NULL,
  `NOM_CENTRE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `centres`
--

INSERT INTO `centres` (`IDCENTRE`, `NOM_CENTRE`) VALUES
(1, 'Rouen'),
(2, 'Nanterre'),
(3, 'Arras'),
(4, 'Caen'),
(5, 'Bordeaux'),
(6, 'Lyon'),
(7, 'Toulouse'),
(8, 'Orléans'),
(9, 'Lille'),
(10, 'Brest'),
(11, 'Saint-Nazaire'),
(12, 'Le Mans'),
(13, 'Reims'),
(14, 'Nancy'),
(15, 'Strasbourg'),
(16, 'Dijon'),
(17, 'Grenoble'),
(18, 'Nice'),
(19, 'Aix-en-Provence'),
(20, 'Montpellier'),
(21, 'Pau'),
(22, 'Angoulême'),
(23, 'La Rochelle'),
(24, 'Châteauroux'),
(25, 'Nantes');

-- --------------------------------------------------------

--
-- Structure de la table `competences`
--

CREATE TABLE `competences` (
  `IDCOMPETENCE` int(11) NOT NULL,
  `NOM_COMPETENCE` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `competences`
--

INSERT INTO `competences` (`IDCOMPETENCE`, `NOM_COMPETENCE`) VALUES
(1, 'Adaptabilité'),
(2, 'Gestion de projet'),
(3, 'Aisance à l\'oral'),
(4, 'C++'),
(5, 'Python'),
(6, 'HTML'),
(7, 'PHP'),
(8, 'JavaScript'),
(9, 'Java'),
(10, 'C'),
(11, 'C#'),
(12, 'VBA'),
(13, 'Réseaux'),
(14, 'Suite Office'),
(15, 'Français'),
(16, 'Anglais'),
(17, 'Espagnol'),
(18, 'Allemand'),
(19, 'Italien'),
(20, 'Népalais'),
(21, 'Polonais');

-- --------------------------------------------------------

--
-- Structure de la table `dates`
--

CREATE TABLE `dates` (
  `IDDATE` int(11) NOT NULL,
  `IDCANDIDATURE` int(11) NOT NULL,
  `ETAT` smallint(6) NOT NULL,
  `DATE` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `entreprises`
--

CREATE TABLE `entreprises` (
  `IDENTREPRISE` int(11) NOT NULL,
  `NOM_ENTREPRISE` text NOT NULL,
  `VISIBLE` binary(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `entreprises`
--

INSERT INTO `entreprises` (`IDENTREPRISE`, `NOM_ENTREPRISE`, `VISIBLE`) VALUES
(1, 'Yachtneeds', 0x31),
(2, 'Airbus', 0x31),
(3, 'Wienerberger', 0x31),
(4, 'Aktor Interactive', 0x31),
(5, 'Storelift', 0x31);

-- --------------------------------------------------------

--
-- Structure de la table `etudier_a`
--

CREATE TABLE `etudier_a` (
  `IDUTILISATEUR` int(11) NOT NULL,
  `IDCENTRE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `etudier_a`
--

INSERT INTO `etudier_a` (`IDUTILISATEUR`, `IDCENTRE`) VALUES
(2, 1),
(3, 1),
(4, 7),
(5, 2),
(6, 1),
(7, 1),
(8, 7),
(9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `evaluations`
--

CREATE TABLE `evaluations` (
  `IDEVAL` int(11) NOT NULL,
  `IDENTREPRISE` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) NOT NULL,
  `NOTE` smallint(6) NOT NULL,
  `COMMENTAIRE` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `faire_partie_ou_encadrer`
--

CREATE TABLE `faire_partie_ou_encadrer` (
  `IDUTILISATEUR` int(11) NOT NULL,
  `IDPROMOTION` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `faire_partie_ou_encadrer`
--

INSERT INTO `faire_partie_ou_encadrer` (`IDUTILISATEUR`, `IDPROMOTION`) VALUES
(2, 2),
(3, 2),
(4, 1),
(5, 4),
(6, 2),
(7, 2),
(8, 1),
(9, 4);

-- --------------------------------------------------------

--
-- Structure de la table `met_en_wishlist`
--

CREATE TABLE `met_en_wishlist` (
  `IDOFFRE` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

CREATE TABLE `notifications` (
  `IDNOTIFICATION` int(11) NOT NULL,
  `IDCANDIDATURE` int(11) NOT NULL,
  `IDUTILISATEUR` int(11) NOT NULL,
  `CONTENU` varchar(10000) NOT NULL,
  `VUE` binary(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `offres_de_stage`
--

CREATE TABLE `offres_de_stage` (
  `IDOFFRE` int(11) NOT NULL,
  `IDENTREPRISE` int(11) NOT NULL,
  `NOMBRE_PLACES` int(11) NOT NULL,
  `INTITULE_OFFRE` text NOT NULL,
  `DESCRIPTION` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `offres_de_stage`
--

INSERT INTO `offres_de_stage` (`IDOFFRE`, `IDENTREPRISE`, `NOMBRE_PLACES`, `INTITULE_OFFRE`, `DESCRIPTION`) VALUES
(1, 1, 2, 'Business Developer Seller - 4/6-month Internship - End of studies', 'We are looking for an outstanding Business Developer and HUNTER to launch our marketplace in Europe and in 2022 in the US and Caribbean. Based in Monaco (home office possible at the beginning due to COVID) and reporting to our commercial director (Nils), you will be in charge of accelerating Yachtneeds growth by identifying, recruiting and accompanying sellers (selling Superyacht or maritime products) to become successful on our platform. You will immediately impact our growth in a measurable way and benefit from a large autonomy to achieve your goal.'),
(2, 2, 1, 'Airbus UpNext Internship - Data Visualization Developer (M/F)', 'As a Network data visualization intern (m/f), you will integrate a development team working with an agile methodology. You will be part of it and participate in all the usual agile rituals.The main goal is to create a completely new web based visualisation tool, collecting the data of our agile development platform (GitLab) and displaying them in a more visual and intelligible way. Multiple kind of people (developers, project leader, product owner, scrum master, external stakeholders, etc ....) will want to visualize different types of data. You will have to discuss with all of them to deeply understand their needs.'),
(3, 3, 2, 'Internship at Wienerberger Group', 'Have you had enough of working only with theory and want to get some hands-on experience? If so, then you should do an internship at Wienerberger! Through our internship, you can discover the world of building materials and infrastructure solutions. Whether it be in IT, finance, human resources, engineering or marketing, You can use all of your talents at Wienerberger. You will gain a breadth of experience across different areas of the business and pick up useful skills through “on the job training”.'),
(4, 4, 2, 'Anglophone Business Developer', 'You have a successful experience and track record in selling service to major accounts, preferably in human resources services or recruitment. You are perfectly anglophone or native of a english speaking country. In addition to your business development and customer relations skills, you are creative, responsive, rigorous. You have developed a talent in advising clients and you are a strong team player. You are passionate about the internet, social network and new technologies.'),
(5, 5, 4, 'Data Analyst', 'We are looking for a Data Analyst Intern (end of Studies OR year off internship) to join our Analytics team and help build a new generation of stores that thousands (to millions!) of people will use every day. We drive the decision-making process and strive to deliver impactful actions. The team is responsible for data analytics across all departments as well as building the tools for operations to run more efficiently. We care deeply about business relevance, efficiency, and agility.');

-- --------------------------------------------------------

--
-- Structure de la table `prendre_place_a`
--

CREATE TABLE `prendre_place_a` (
  `IDOFFRE` int(11) NOT NULL,
  `IDCENTRE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `prendre_place_a`
--

INSERT INTO `prendre_place_a` (`IDOFFRE`, `IDCENTRE`) VALUES
(1, 18),
(2, 7),
(3, 1),
(4, 1),
(5, 18);

-- --------------------------------------------------------

--
-- Structure de la table `promotions`
--

CREATE TABLE `promotions` (
  `IDPROMOTION` int(11) NOT NULL,
  `NOM_PROMOTION` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `promotions`
--

INSERT INTO `promotions` (`IDPROMOTION`, `NOM_PROMOTION`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'A3'),
(4, 'A4'),
(5, 'A5');

-- --------------------------------------------------------

--
-- Structure de la table `requerir`
--

CREATE TABLE `requerir` (
  `IDCOMPETENCE` int(11) NOT NULL,
  `IDOFFRE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `requerir`
--

INSERT INTO `requerir` (`IDCOMPETENCE`, `IDOFFRE`) VALUES
(1, 1),
(2, 4),
(3, 2),
(4, 2),
(5, 4),
(6, 5),
(7, 5),
(8, 5),
(9, 5),
(12, 3),
(14, 3),
(16, 1),
(16, 2),
(17, 4),
(19, 3),
(20, 1),
(21, 1);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `IDROLE` int(11) NOT NULL,
  `IDAUTORISATION` int(11) DEFAULT NULL,
  `NOM_ROLE` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`IDROLE`, `IDAUTORISATION`, `NOM_ROLE`) VALUES
(1, NULL, 'Administrateur'),
(2, NULL, 'Pilote'),
(3, NULL, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `s_adresser_a`
--

CREATE TABLE `s_adresser_a` (
  `IDPROMOTION` int(11) NOT NULL,
  `IDOFFRE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `s_adresser_a`
--

INSERT INTO `s_adresser_a` (`IDPROMOTION`, `IDOFFRE`) VALUES
(1, 5),
(3, 2),
(3, 3),
(4, 1),
(5, 4);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `IDUTILISATEUR` int(11) NOT NULL,
  `IDROLE` int(11) NOT NULL,
  `MAIL` text NOT NULL,
  `MDP` text NOT NULL,
  `NOM` text NOT NULL,
  `PRENOM` text NOT NULL,
  `AGE` text NOT NULL,
  `ADRESSE` text NOT NULL,
  `VISIBLE` binary(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`IDUTILISATEUR`, `IDROLE`, `MAIL`, `MDP`, `NOM`, `PRENOM`, `AGE`, `ADRESSE`, `VISIBLE`) VALUES
(1, 1, 'sblondel@cesi.fr', 'KingOfCesi', 'Blondel', 'Sébastien', '40', 'Rouen', 0x31),
(2, 3, 'louis.jarrier@viacesi.fr', 'Wordpress', 'Jarrier', 'Louis', '19', 'Val-de-reuil', 0x31),
(3, 3, 'thibaut.ligerhellard@viacesi.fr', 'SQLstack', 'Liger Hellard', 'Thibaut', '19', 'Gravigny', 0x31),
(4, 3, 'erwan.martin@viacesi.fr', 'Robocop', 'Martin', 'Erwan', '19', 'Saint-Etienne-du-Rouvray', 0x31),
(5, 3, 'teo.montlouiscalixte@viacesi.fr', 'Fullstack', 'Montlouis-calixte', 'Téo', '19', 'Mesnil-Raoul', 0x31),
(6, 2, 'rcoma@cesi.fr', 'Linux', 'Coma', 'Roland', '38', 'Le Havre', 0x31),
(7, 2, 'szacharie@cesi.fr', 'Cesi', 'Zacharie', 'Sara', '24', 'Petit Quevilly', 0x31),
(8, 2, 'amartin@viacesi.fr', 'Wireshark', 'Martin', 'Aurélien', '36', 'Rouen', 0x31),
(9, 2, 'mschumacher@cesi.fr', 'Vroum', 'Schumacher', 'Michael', '47', 'Mans', 0x31);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `a`
--
ALTER TABLE `a`
  ADD PRIMARY KEY (`IDUTILISATEUR`,`IDCOMPETENCE`),
  ADD KEY `FK_A2` (`IDCOMPETENCE`);

--
-- Index pour la table `autorisations`
--
ALTER TABLE `autorisations`
  ADD PRIMARY KEY (`IDAUTORISATION`);

--
-- Index pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD PRIMARY KEY (`IDCANDIDATURE`),
  ADD KEY `FK_ENVOIE` (`IDUTILISATEUR`),
  ADD KEY `FK_REPOND` (`IDOFFRE`);

--
-- Index pour la table `centres`
--
ALTER TABLE `centres`
  ADD PRIMARY KEY (`IDCENTRE`);

--
-- Index pour la table `competences`
--
ALTER TABLE `competences`
  ADD PRIMARY KEY (`IDCOMPETENCE`);

--
-- Index pour la table `dates`
--
ALTER TABLE `dates`
  ADD PRIMARY KEY (`IDDATE`),
  ADD KEY `FK_SE_PASSER` (`IDCANDIDATURE`);

--
-- Index pour la table `entreprises`
--
ALTER TABLE `entreprises`
  ADD PRIMARY KEY (`IDENTREPRISE`);

--
-- Index pour la table `etudier_a`
--
ALTER TABLE `etudier_a`
  ADD PRIMARY KEY (`IDUTILISATEUR`,`IDCENTRE`),
  ADD KEY `FK_ETUDIER_A2` (`IDCENTRE`);

--
-- Index pour la table `evaluations`
--
ALTER TABLE `evaluations`
  ADD PRIMARY KEY (`IDEVAL`),
  ADD KEY `FK_DONNER` (`IDUTILISATEUR`),
  ADD KEY `FK_NOTE` (`IDENTREPRISE`);

--
-- Index pour la table `faire_partie_ou_encadrer`
--
ALTER TABLE `faire_partie_ou_encadrer`
  ADD PRIMARY KEY (`IDUTILISATEUR`,`IDPROMOTION`),
  ADD KEY `FK_FAIRE_PARTIE_OU_ENCADRER2` (`IDPROMOTION`);

--
-- Index pour la table `met_en_wishlist`
--
ALTER TABLE `met_en_wishlist`
  ADD PRIMARY KEY (`IDOFFRE`,`IDUTILISATEUR`),
  ADD KEY `FK_MET_EN_WISHLIST2` (`IDUTILISATEUR`);

--
-- Index pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`IDNOTIFICATION`),
  ADD KEY `FK_DECLENCHER` (`IDCANDIDATURE`),
  ADD KEY `FK_RECEVOIR` (`IDUTILISATEUR`);

--
-- Index pour la table `offres_de_stage`
--
ALTER TABLE `offres_de_stage`
  ADD PRIMARY KEY (`IDOFFRE`),
  ADD KEY `FK_PROPOSE` (`IDENTREPRISE`);

--
-- Index pour la table `prendre_place_a`
--
ALTER TABLE `prendre_place_a`
  ADD PRIMARY KEY (`IDOFFRE`,`IDCENTRE`),
  ADD KEY `FK_PRENDRE_PLACE_A2` (`IDCENTRE`);

--
-- Index pour la table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`IDPROMOTION`);

--
-- Index pour la table `requerir`
--
ALTER TABLE `requerir`
  ADD PRIMARY KEY (`IDCOMPETENCE`,`IDOFFRE`),
  ADD KEY `FK_REQUERIR2` (`IDOFFRE`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`IDROLE`),
  ADD KEY `FK_REND_POSSIBLE` (`IDAUTORISATION`);

--
-- Index pour la table `s_adresser_a`
--
ALTER TABLE `s_adresser_a`
  ADD PRIMARY KEY (`IDPROMOTION`,`IDOFFRE`),
  ADD KEY `FK_S_ADRESSER_A2` (`IDOFFRE`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`IDUTILISATEUR`),
  ADD KEY `FK_CONCER` (`IDROLE`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `autorisations`
--
ALTER TABLE `autorisations`
  MODIFY `IDAUTORISATION` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `candidatures`
--
ALTER TABLE `candidatures`
  MODIFY `IDCANDIDATURE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `centres`
--
ALTER TABLE `centres`
  MODIFY `IDCENTRE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `competences`
--
ALTER TABLE `competences`
  MODIFY `IDCOMPETENCE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `dates`
--
ALTER TABLE `dates`
  MODIFY `IDDATE` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `entreprises`
--
ALTER TABLE `entreprises`
  MODIFY `IDENTREPRISE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `evaluations`
--
ALTER TABLE `evaluations`
  MODIFY `IDEVAL` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `IDNOTIFICATION` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `offres_de_stage`
--
ALTER TABLE `offres_de_stage`
  MODIFY `IDOFFRE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `IDPROMOTION` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `IDROLE` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `IDUTILISATEUR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `a`
--
ALTER TABLE `a`
  ADD CONSTRAINT `FK_A` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `utilisateurs` (`IDUTILISATEUR`),
  ADD CONSTRAINT `FK_A2` FOREIGN KEY (`IDCOMPETENCE`) REFERENCES `competences` (`IDCOMPETENCE`);

--
-- Contraintes pour la table `candidatures`
--
ALTER TABLE `candidatures`
  ADD CONSTRAINT `FK_ENVOIE` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `utilisateurs` (`IDUTILISATEUR`),
  ADD CONSTRAINT `FK_REPOND` FOREIGN KEY (`IDOFFRE`) REFERENCES `offres_de_stage` (`IDOFFRE`);

--
-- Contraintes pour la table `dates`
--
ALTER TABLE `dates`
  ADD CONSTRAINT `FK_SE_PASSER` FOREIGN KEY (`IDCANDIDATURE`) REFERENCES `candidatures` (`IDCANDIDATURE`);

--
-- Contraintes pour la table `etudier_a`
--
ALTER TABLE `etudier_a`
  ADD CONSTRAINT `FK_ETUDIER_A` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `utilisateurs` (`IDUTILISATEUR`),
  ADD CONSTRAINT `FK_ETUDIER_A2` FOREIGN KEY (`IDCENTRE`) REFERENCES `centres` (`IDCENTRE`);

--
-- Contraintes pour la table `evaluations`
--
ALTER TABLE `evaluations`
  ADD CONSTRAINT `FK_DONNER` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `utilisateurs` (`IDUTILISATEUR`),
  ADD CONSTRAINT `FK_NOTE` FOREIGN KEY (`IDENTREPRISE`) REFERENCES `entreprises` (`IDENTREPRISE`);

--
-- Contraintes pour la table `faire_partie_ou_encadrer`
--
ALTER TABLE `faire_partie_ou_encadrer`
  ADD CONSTRAINT `FK_FAIRE_PARTIE_OU_ENCADRER` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `utilisateurs` (`IDUTILISATEUR`),
  ADD CONSTRAINT `FK_FAIRE_PARTIE_OU_ENCADRER2` FOREIGN KEY (`IDPROMOTION`) REFERENCES `promotions` (`IDPROMOTION`);

--
-- Contraintes pour la table `met_en_wishlist`
--
ALTER TABLE `met_en_wishlist`
  ADD CONSTRAINT `FK_MET_EN_WISHLIST` FOREIGN KEY (`IDOFFRE`) REFERENCES `offres_de_stage` (`IDOFFRE`),
  ADD CONSTRAINT `FK_MET_EN_WISHLIST2` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `utilisateurs` (`IDUTILISATEUR`);

--
-- Contraintes pour la table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `FK_DECLENCHER` FOREIGN KEY (`IDCANDIDATURE`) REFERENCES `candidatures` (`IDCANDIDATURE`),
  ADD CONSTRAINT `FK_RECEVOIR` FOREIGN KEY (`IDUTILISATEUR`) REFERENCES `utilisateurs` (`IDUTILISATEUR`);

--
-- Contraintes pour la table `offres_de_stage`
--
ALTER TABLE `offres_de_stage`
  ADD CONSTRAINT `FK_PROPOSE` FOREIGN KEY (`IDENTREPRISE`) REFERENCES `entreprises` (`IDENTREPRISE`);

--
-- Contraintes pour la table `prendre_place_a`
--
ALTER TABLE `prendre_place_a`
  ADD CONSTRAINT `FK_PRENDRE_PLACE_A` FOREIGN KEY (`IDOFFRE`) REFERENCES `offres_de_stage` (`IDOFFRE`),
  ADD CONSTRAINT `FK_PRENDRE_PLACE_A2` FOREIGN KEY (`IDCENTRE`) REFERENCES `centres` (`IDCENTRE`);

--
-- Contraintes pour la table `requerir`
--
ALTER TABLE `requerir`
  ADD CONSTRAINT `FK_REQUERIR` FOREIGN KEY (`IDCOMPETENCE`) REFERENCES `competences` (`IDCOMPETENCE`),
  ADD CONSTRAINT `FK_REQUERIR2` FOREIGN KEY (`IDOFFRE`) REFERENCES `offres_de_stage` (`IDOFFRE`);

--
-- Contraintes pour la table `roles`
--
ALTER TABLE `roles`
  ADD CONSTRAINT `FK_REND_POSSIBLE` FOREIGN KEY (`IDAUTORISATION`) REFERENCES `autorisations` (`IDAUTORISATION`);

--
-- Contraintes pour la table `s_adresser_a`
--
ALTER TABLE `s_adresser_a`
  ADD CONSTRAINT `FK_S_ADRESSER_A` FOREIGN KEY (`IDPROMOTION`) REFERENCES `promotions` (`IDPROMOTION`),
  ADD CONSTRAINT `FK_S_ADRESSER_A2` FOREIGN KEY (`IDOFFRE`) REFERENCES `offres_de_stage` (`IDOFFRE`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `FK_CONCER` FOREIGN KEY (`IDROLE`) REFERENCES `roles` (`IDROLE`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
