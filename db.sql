-- --------------------------------------------------------
-- Hôte :                        127.0.0.1
-- Version du serveur:           5.7.24 - MySQL Community Server (GPL)
-- SE du serveur:                Win64
-- HeidiSQL Version:             11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Listage de la structure de la base pour db_esge
CREATE DATABASE IF NOT EXISTS `db_esge` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `db_esge`;

-- Listage de la structure de la table db_esge. ab
CREATE TABLE IF NOT EXISTS `ab` (
  `idAB` tinyint(2) NOT NULL AUTO_INCREMENT,
  `annee` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`idAB`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.ab : ~26 rows (environ)
/*!40000 ALTER TABLE `ab` DISABLE KEYS */;
INSERT INTO `ab` (`idAB`, `annee`) VALUES
	(1, '2000'),
	(2, '2001'),
	(3, '2002'),
	(4, '2003'),
	(5, '2004'),
	(6, '2005'),
	(7, '2006'),
	(8, '2007'),
	(9, '2008'),
	(10, '2009'),
	(11, '2010'),
	(12, '2011'),
	(13, '2012'),
	(14, '2013'),
	(15, '2014'),
	(16, '2015'),
	(17, '2016'),
	(18, '2017'),
	(19, '2018'),
	(20, '2019'),
	(21, '2020'),
	(22, '2021'),
	(23, '2022'),
	(24, '2023'),
	(25, '2024'),
	(26, '2025');
/*!40000 ALTER TABLE `ab` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. au
CREATE TABLE IF NOT EXISTS `au` (
  `idAU` int(11) NOT NULL AUTO_INCREMENT,
  `nom_au` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idAU`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.au : ~13 rows (environ)
/*!40000 ALTER TABLE `au` DISABLE KEYS */;
INSERT INTO `au` (`idAU`, `nom_au`) VALUES
	(1, '2013-2014'),
	(2, '2014-2015'),
	(3, '2015-2016'),
	(4, '2016-2017'),
	(5, '2017-2018'),
	(6, '2018-2019'),
	(7, '2019-2020'),
	(8, '2020-2021'),
	(9, '2021-2022'),
	(10, '2022-2023'),
	(11, '2023-2024'),
	(12, '2024-2025'),
	(13, '2025-2026');
/*!40000 ALTER TABLE `au` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. do
CREATE TABLE IF NOT EXISTS `do` (
  `idDO` tinyint(2) NOT NULL AUTO_INCREMENT,
  `diplome` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idDO`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.do : ~9 rows (environ)
/*!40000 ALTER TABLE `do` DISABLE KEYS */;
INSERT INTO `do` (`idDO`, `diplome`) VALUES
	(1, 'BACC'),
	(2, 'DTS'),
	(3, 'BTS'),
	(4, 'DUT'),
	(5, 'LICENCE'),
	(6, 'MAITRISE'),
	(7, 'ACA'),
	(8, 'FM'),
	(9, 'ACTC');
/*!40000 ALTER TABLE `do` ENABLE KEYS */;


-- Listage de la structure de la table db_esge. gp
CREATE TABLE IF NOT EXISTS `gp` (
  `idGP` int(11) NOT NULL AUTO_INCREMENT,
  `nom_gp` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idGP`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.gp : ~13 rows (environ)
/*!40000 ALTER TABLE `gp` DISABLE KEYS */;
INSERT INTO `gp` (`idGP`, `nom_gp`) VALUES
	(1, 'MEGP'),
	(2, 'IRD'),
	(3, 'TC'),
	(4, 'BANCASS'),
	(5, 'IMP'),
	(6, 'MIAGE'),
	(7, 'QUADD');
/*!40000 ALTER TABLE `au` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. entretien
CREATE TABLE IF NOT EXISTS `entretien` (
  `idENTR` int(11) NOT NULL AUTO_INCREMENT,
  `AU_id` int(11) NOT NULL,
  `NIV_id` tinyint(2) NOT NULL,
  `REC_id` tinyint(2) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `prenom` varchar(70) NOT NULL,
  `sexe` tinyint(2) NOT NULL,
  `contact` varchar(70) NOT NULL,
  `date_entretien` datetime NOT NULL,
  `datenaiss` date DEFAULT NULL,
  `lieunaiss` varchar(70) DEFAULT NULL,
  `adresse` varchar(70) DEFAULT NULL,
  `etablissement` varchar(70) DEFAULT NULL,
  `religion` varchar(70) DEFAULT NULL,
  `inscription` tinyint(4) DEFAULT NULL,
  `le` date DEFAULT NULL,
  `presentation_soi` text,
  `comportement` text,
  `ecole` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `lycee` varchar(255) DEFAULT NULL,
  `experience` varchar(255) DEFAULT NULL,
  `projets` varchar(255) DEFAULT NULL,
  `vision` varchar(255) DEFAULT NULL,
  `domaine_souhaite` varchar(20) DEFAULT NULL,
  `connaissance_esmia` varchar(20) DEFAULT NULL,
  `qualites` varchar(255) DEFAULT NULL,
  `defauts` varchar(255) DEFAULT NULL,
  `autre` varchar(255) DEFAULT NULL,
  `pere` varchar(255) DEFAULT NULL,
  `nom_pere` varchar(50) DEFAULT NULL,
  `prenom_pere` varchar(50) DEFAULT NULL,
  `contact_pere` varchar(20) DEFAULT NULL,
  `email_pere` varchar(50) DEFAULT NULL,
  `adresse_pere` varchar(50) DEFAULT NULL,
  `profession_pere` varchar(20) DEFAULT NULL,
  `mere` varchar(255) DEFAULT NULL,
  `nom_mere` varchar(50) DEFAULT NULL,
  `prenom_mere` varchar(50) DEFAULT NULL,
  `contact_mere` varchar(20) DEFAULT NULL,
  `email_mere` varchar(50) DEFAULT NULL,
  `adresse_mere` varchar(50) DEFAULT NULL,
  `profession_mere` varchar(20) DEFAULT NULL,
  `freres` varchar(255) DEFAULT NULL,
  `soeurs` varchar(255) DEFAULT NULL,
  `motivation` varchar(255) DEFAULT NULL,
  `attentes` varchar(255) DEFAULT NULL,
  `problemes` varchar(255) DEFAULT NULL,
  `loisirs` varchar(255) DEFAULT NULL,
  `DO_id` tinyint(2) DEFAULT NULL,
  `AB_id` tinyint(2) DEFAULT NULL,
  `SB_id` tinyint(2) DEFAULT NULL,
  `MB_id` tinyint(2) DEFAULT NULL,
  `GP_id` int(11) DEFAULT NULL,
  `fume` tinyint(1) DEFAULT NULL,
  `boit` tinyint(1) DEFAULT NULL,
  `autodidacte` tinyint(1) DEFAULT NULL,
  `frs` tinyint(1) DEFAULT NULL,
  `agl` tinyint(1) DEFAULT NULL,
  `info` tinyint(1) DEFAULT NULL,
  `react` tinyint(1) DEFAULT NULL,
  `favorable` tinyint(1) DEFAULT NULL,
  `closed` tinyint(1) DEFAULT NULL,
  `creationDate` timestamp NOT NULL,
  `updateDate` timestamp NOT NULL,
  PRIMARY KEY (`idENTR`),
  KEY `FK_entretien_au` (`AU_id`),
  KEY `FK_entretien_niv` (`NIV_id`),
  KEY `FK_entretien_do` (`DO_id`),
  KEY `FK_entretien_ab` (`AB_id`),
  KEY `FK_entretien_sb` (`SB_id`),
  KEY `FK_entretien_mb` (`MB_id`),
  CONSTRAINT `FK_entretien_ab` FOREIGN KEY (`AB_id`) REFERENCES `ab` (`idAB`),
  CONSTRAINT `FK_entretien_sb` FOREIGN KEY (`SB_id`) REFERENCES `sb` (`idSB`),
  CONSTRAINT `FK_entretien_au` FOREIGN KEY (`AU_id`) REFERENCES `au` (`idAU`),
  CONSTRAINT `FK_entretien_do` FOREIGN KEY (`DO_id`) REFERENCES `do` (`idDO`),
  CONSTRAINT `FK_entretien_mb` FOREIGN KEY (`MB_id`) REFERENCES `mb` (`idMB`),
  CONSTRAINT `FK_entretien_niv` FOREIGN KEY (`NIV_id`) REFERENCES `niv` (`idNIV`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Listage des données de la table db_esge.entretien : ~0 rows (environ)
/*!40000 ALTER TABLE `entretien` DISABLE KEYS */;
/*!40000 ALTER TABLE `entretien` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. etudiant
CREATE TABLE IF NOT EXISTS `etudiant` (
  `nie` varchar(10) NOT NULL,
  `abandon` tinyint(1) DEFAULT NULL,
  `photo` varchar(16) DEFAULT NULL,
  `nom` varchar(70) DEFAULT NULL,
  `prenom` varchar(70) DEFAULT NULL,
  `sexe` tinyint(1) DEFAULT NULL,
  `datenaiss` date DEFAULT NULL,
  `lieunaiss` varchar(70) DEFAULT NULL,
  `contacte` varchar(70) DEFAULT NULL,
  `email` varchar(70) DEFAULT NULL,
  `fb` varchar(255) DEFAULT NULL,
  `adresse` varchar(70) DEFAULT NULL,
  `nom_p` varchar(70) DEFAULT NULL,
  `prenom_p` varchar(70) DEFAULT NULL,
  `contacte_p` varchar(70) DEFAULT NULL,
  `email_p` varchar(70) DEFAULT NULL,
  `adresse_p` varchar(70) DEFAULT NULL,
  `profession_p` varchar(70) DEFAULT NULL,
  `nom_m` varchar(70) DEFAULT NULL,
  `prenom_m` varchar(70) DEFAULT NULL,
  `contacte_m` varchar(70) DEFAULT NULL,
  `email_m` varchar(70) DEFAULT NULL,
  `adresse_m` varchar(70) DEFAULT NULL,
  `profession_m` varchar(70) DEFAULT NULL,
  `nom_t` varchar(70) DEFAULT NULL,
  `prenom_t` varchar(70) DEFAULT NULL,
  `contacte_t` varchar(70) DEFAULT NULL,
  `email_t` varchar(70) DEFAULT NULL,
  `adresse_t` varchar(70) DEFAULT NULL,
  `profession_t` varchar(70) DEFAULT NULL,
  `NAT_id` tinyint(2) NOT NULL,
  `AB_id` tinyint(2) NOT NULL,
  `SB_id` tinyint(2) NOT NULL,
  `MB_id` tinyint(2) NOT NULL,
  `REC_id` tinyint(2) NOT NULL,
  `dateRec` date DEFAULT NULL,
  PRIMARY KEY (`nie`),
  KEY `fk_etudiant_NAT1_idx` (`NAT_id`),
  KEY `fk_etudiant_AB1_idx` (`AB_id`),
  KEY `fk_etudiant_SB1_idx` (`SB_id`),
  KEY `fk_etudiant_MB1_idx` (`MB_id`),
  KEY `fk_etudiant_recruteur1_idx` (`REC_id`),
  CONSTRAINT `fk_etudiant_AB1` FOREIGN KEY (`AB_id`) REFERENCES `ab` (`idAB`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_etudiant_MB1` FOREIGN KEY (`MB_id`) REFERENCES `mb` (`idMB`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_etudiant_NAT1` FOREIGN KEY (`NAT_id`) REFERENCES `nat` (`idNAT`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_etudiant_SB1` FOREIGN KEY (`SB_id`) REFERENCES `sb` (`idSB`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_etudiant_recruteur1` FOREIGN KEY (`REC_id`) REFERENCES `recruteur` (`idREC`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Listage de la structure de la table db_esge. mb
CREATE TABLE IF NOT EXISTS `mb` (
  `idMB` tinyint(2) NOT NULL AUTO_INCREMENT,
  `mention` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idMB`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.mb : ~5 rows (environ)
/*!40000 ALTER TABLE `mb` DISABLE KEYS */;
INSERT INTO `mb` (`idMB`, `mention`) VALUES
	(1, 'Sans Mention'),
	(2, 'Assez-Bien'),
	(3, 'Bien'),
	(4, 'Très Bien'),
	(5, 'Excellent');
/*!40000 ALTER TABLE `mb` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. nat
CREATE TABLE IF NOT EXISTS `nat` (
  `idNAT` tinyint(2) NOT NULL AUTO_INCREMENT,
  `nationalite` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idNAT`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.nat : ~4 rows (environ)
/*!40000 ALTER TABLE `nat` DISABLE KEYS */;
INSERT INTO `nat` (`idNAT`, `nationalite`) VALUES
	(1, 'MALAGASY'),
	(2, 'GABONAISE'),
	(3, 'CHINOISE'),
	(4, 'FRANçAIS');
/*!40000 ALTER TABLE `nat` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. sb
CREATE TABLE IF NOT EXISTS `sb` (
  `idSB` tinyint(2) NOT NULL AUTO_INCREMENT,
  `serie` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idSB`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.sb : ~6 rows (environ)
/*!40000 ALTER TABLE `sb` DISABLE KEYS */;
INSERT INTO `sb` (`idSB`, `serie`) VALUES
	(1, 'A1'),
	(2, 'A2'),
	(3, 'C'),
	(4, 'D'),
	(5, 'L'),
	(6, 'S');
/*!40000 ALTER TABLE `sb` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. niv
CREATE TABLE IF NOT EXISTS `niv` (
  `idNIV` tinyint(2) NOT NULL AUTO_INCREMENT,
  `nom_niv` varchar(2) DEFAULT NULL,
  `description` varchar(70) DEFAULT NULL,
  PRIMARY KEY (`idNIV`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.niv : ~5 rows (environ)
/*!40000 ALTER TABLE `niv` DISABLE KEYS */;
INSERT INTO `niv` (`idNIV`, `nom_niv`, `description`) VALUES
	(1, 'L1', NULL),
	(2, 'L2', NULL),
	(3, 'L3', NULL),
	(4, 'M1', NULL),
	(5, 'M2', NULL);
/*!40000 ALTER TABLE `niv` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. recruteur
CREATE TABLE IF NOT EXISTS `recruteur` (
  `idREC` tinyint(2) NOT NULL AUTO_INCREMENT,
  `nom_rec` varchar(70) DEFAULT NULL,
  `prenom_rec` varchar(70) DEFAULT NULL,
  `sexe_rec` tinyint(1) DEFAULT '0',
  `email_rec` varchar(70) DEFAULT NULL,
  `poste_rec` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idREC`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.recruteur : ~5 rows (environ)
/*!40000 ALTER TABLE `recruteur` DISABLE KEYS */;
INSERT INTO `recruteur` (`idREC`, `nom_rec`, `prenom_rec`, `sexe_rec`, `email_rec`, `poste_rec`) VALUES
	(1, 'RAMANANARIVO', 'Romaine', 0, 'r.ramananarivo@esmia-mada.com', 'DG'),
	(2, 'RAMANANARIVO', 'Sylvain', 1, 's.ramananarivo@esmia-mada.com', 'DGA'),
	(3, 'RAKOTONDRAHANTA', 'Ndriambolanirina', 1, 'rqual@esmia-mada.com', 'DAQCOM'),
	(4, 'RAMANANARIVO', 'Aina Rosy', 0, 'directiondesetudes@esmia-mada.com', 'DE'),
	(5, 'RAMPANANA', 'Jess', 1, 'scolarite2@esmia-mada.com', 'SPDE');
/*!40000 ALTER TABLE `recruteur` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. type_user
CREATE TABLE IF NOT EXISTS `type_user` (
  `idTU` int(11) NOT NULL AUTO_INCREMENT,
  `type_tu` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idTU`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.type_user : ~5 rows (environ)
/*!40000 ALTER TABLE `type_user` DISABLE KEYS */;
INSERT INTO `type_user` (`idTU`, `type_tu`) VALUES
	(1, 'devmaster'),
	(2, 'admin'),
	(3, 'standard'),
	(4, 'guest'),
	(5, 'job_etudiant');
/*!40000 ALTER TABLE `type_user` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. user
CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `sexe` tinyint(1) DEFAULT NULL,
  `photo` varchar(20) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `TU_id` int(11) NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  KEY `fk_user_type_user1_idx` (`TU_id`),
  CONSTRAINT `fk_user_type_user1` FOREIGN KEY (`TU_id`) REFERENCES `type_user` (`idTU`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.user : ~21 rows (environ)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`username`, `password`, `email`, `nom`, `prenom`, `sexe`, `photo`, `create_time`, `TU_id`) VALUES
	('admin', 'admin', 'admin@gmail.com', 'ADMIN', 'ESMIA', 1, NULL, '2020-11-14 05:35:20', 1);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- Listage de la structure de la table db_esge. gp_has_au
CREATE TABLE IF NOT EXISTS `gp_has_au` (
  `AU_id` int(11) NOT NULL,
  `NIV_id` tinyint(2) NOT NULL,
  `GP_id` int(11) NOT NULL,
  PRIMARY KEY (`AU_id`, `NIV_id`, `GP_id`),
  KEY `fk_gp_has_au_au` (`AU_id`),
  KEY `fk_gp_has_au_niv` (`NIV_id`),
  KEY `fk_gp_has_au_gp` (`GP_id`),
  CONSTRAINT `fk_gp_has_au_au` FOREIGN KEY (`AU_id`) REFERENCES `au` (`idAU`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_has_au_niv` FOREIGN KEY (`NIV_id`) REFERENCES `niv` (`idNIV`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_gp_has_au_gp` FOREIGN KEY (`GP_id`) REFERENCES `gp` (`idGP`) ON DELETE NO ACTION ON UPDATE NO ACTION

) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Listage des données de la table db_esge.gp_has_au : ~13 rows (environ)
/*!40000 ALTER TABLE `gp_has_au` DISABLE KEYS */;
INSERT INTO `gp_has_au` (`AU_id`, `NIV_id`, `GP_id`) VALUES
	(10, 1, 2),
	(10, 1, 3),
	(10, 2, 1),
	(10, 2, 2),
	(10, 2, 4),
  (10, 3, 1),
	(10, 3, 2),
	(10, 3, 4);
/*!40000 ALTER TABLE `au` ENABLE KEYS */;

-- Listage de la structure de la table db_esge. inscription
CREATE TABLE IF NOT EXISTS `inscription` (
  `num_matr` int(11) NOT NULL,
  `ETUDIANT_nie` varchar(10) NOT NULL,
  `AU_id` int(11) NOT NULL,
  `NIV_id` tinyint(2) NOT NULL,
  `GP_id` int(11) NOT NULL,
  `ENTRETIEN_id` int(11),
  `dateInscr` timestamp,
  `abandon` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`num_matr`),
  KEY `fk_inscription_etudiant` (`ETUDIANT_nie`),
  KEY `fk_inscription_au` (`AU_id`),
  KEY `fk_inscription_niv` (`NIV_id`),
  KEY `fk_inscription_gp` (`GP_id`),
  KEY `fk_inscription_entretien` (`ENTRETIEN_id`),
  CONSTRAINT `fk_inscription_etudiant` FOREIGN KEY (`ETUDIANT_nie`) REFERENCES `etudiant` (`nie`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscription_au` FOREIGN KEY (`AU_id`) REFERENCES `au` (`idAU`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscription_niv` FOREIGN KEY (`NIV_id`) REFERENCES `niv` (`idNIV`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscription_gp` FOREIGN KEY (`GP_id`) REFERENCES `gp` (`idGP`) ON DELETE NO ACTION ON UPDATE NO ACTION
  CONSTRAINT `fk_inscription_entretien` FOREIGN KEY (`ENTRETIEN_id`) REFERENCES `entretien` (`idENTR`) ON DELETE NO ACTION ON UPDATE NO ACTION

) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `inscription_has_dossier`(
  `INSCRIPTION_id` int(11) NOT NULL,
  `DOSSIER_id` tinyint(2) NOT NULL,
  `observation` text,
  `isValid` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`INSCRIPTION_id`, `DOSSIER_id`),
  KEY `fk_inscription_has_dossier_inscription` (`INSCRIPTION_id`),
  KEY `fk_inscription_has_dossier_dossier` (`DOSSIER_id`),
  CONSTRAINT `fk_inscription_has_dossier_inscription` FOREIGN KEY (`INSCRIPTION_id`) REFERENCES `inscription` (`num_matr`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_inscription_has_dossier_dossier` FOREIGN KEY (`DOSSIER_id`) REFERENCES `dossier` (`idDOS`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Database: `db_esge`
--

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `action` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `subject_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject_id` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL,
  `oldValues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`oldValues`)),
  `newValues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`newValues`)),
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`changes`)),
  `actor_type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `actor_id` varchar(70) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;