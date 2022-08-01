-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 01 août 2022 à 13:31
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_esge`
--

-- --------------------------------------------------------

--
-- Structure de la table `ab`
--

CREATE TABLE `ab` (
  `idAB` tinyint(2) NOT NULL,
  `annee` varchar(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `ab`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `au`
--

CREATE TABLE `au` (
  `idAU` int(11) NOT NULL,
  `nom_au` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `au`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `do`
--

CREATE TABLE `do` (
  `idDO` tinyint(2) NOT NULL,
  `diplome` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `do`
--

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

-- --------------------------------------------------------

--
-- Structure de la table `dossier`
--

CREATE TABLE `dossier` (
  `idDOS` tinyint(2) NOT NULL,
  `nom_dos` varchar(45) DEFAULT NULL,
  `notation` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `dossier`
--

INSERT INTO `dossier` (`idDOS`, `nom_dos`, `notation`) VALUES
(1, 'Fiche d\'inscription', 'FI'),
(2, 'Lettre de motivation', 'LM'),
(3, 'Lettre d\'engagement', 'LE'),
(4, 'Bulletin de naissance', 'BN'),
(5, 'CIN', 'CIN'),
(6, '4 Photos', 'Q4P'),
(7, 'Certificat de résidence', 'CR'),
(8, 'Note Seconde', 'NS'),
(9, 'Notes Première', 'NP'),
(10, 'Notes Terminale', 'NT'),
(11, 'Notes Bacc', 'NB'),
(12, 'Notes L1', 'NL1'),
(13, 'Notes L2', 'NL2'),
(14, 'Notes L3', 'NL3'),
(15, 'Notes M1', 'NM1'),
(16, 'Diplôme Bacc', 'DB'),
(17, 'Diplôme Licence', 'DL');

-- --------------------------------------------------------

--
-- Structure de la table `entretien`
--

CREATE TABLE `entretien` (
  `idENTR` int(11) NOT NULL,
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
  `presentation_soi` text DEFAULT NULL,
  `comportement` text DEFAULT NULL,
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
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updateDate` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `entretien`
--

INSERT INTO `entretien` (`idENTR`, `AU_id`, `NIV_id`, `REC_id`, `nom`, `prenom`, `sexe`, `contact`, `date_entretien`, `datenaiss`, `lieunaiss`, `adresse`, `etablissement`, `religion`, `inscription`, `le`, `presentation_soi`, `comportement`, `ecole`, `college`, `lycee`, `experience`, `projets`, `vision`, `domaine_souhaite`, `connaissance_esmia`, `qualites`, `defauts`, `autre`, `pere`, `nom_pere`, `prenom_pere`, `contact_pere`, `email_pere`, `adresse_pere`, `profession_pere`, `mere`, `nom_mere`, `prenom_mere`, `contact_mere`, `email_mere`, `adresse_mere`, `profession_mere`, `freres`, `soeurs`, `motivation`, `attentes`, `problemes`, `loisirs`, `DO_id`, `AB_id`, `SB_id`, `MB_id`, `GP_id`, `fume`, `boit`, `autodidacte`, `frs`, `agl`, `info`, `react`, `favorable`, `closed`, `creationDate`, `updateDate`) VALUES
(6, 10, 1, 4, 'RAVAO', 'Noro', 0, '032 00 000 00, , ', '2022-08-03 14:12:00', '2002-07-29', 'Andravoangy', '', 'Inconnu', 'Non communiquée', NULL, NULL, '-', 'Inconnu', 'Non renseigné', 'Non renseigné', 'Non renseigné', '-', '-', '-', '', 'Pub TV', '-', '-', '-', '', 'brad', 'Jean', '034 22 111 33', NULL, NULL, '', '', 'Je', 'lo', '038 44 555 66', NULL, NULL, '', '', '', '-', 'Vide', '-', '-', 1, 1, 1, 1, 1, 0, 0, 0, 4, 2, 3, 3, 1, 1, '2022-08-01 06:05:09', NULL),
(7, 10, 1, 3, 'RAKOTO', 'Aina', 0, '034 11 222 33', '2022-08-03 13:11:00', '1998-07-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2022-08-01 11:12:34', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `etudiant`
--

CREATE TABLE `etudiant` (
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
  `dateRec` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `etudiant`
--

INSERT INTO `etudiant` (`nie`, `abandon`, `photo`, `nom`, `prenom`, `sexe`, `datenaiss`, `lieunaiss`, `contacte`, `email`, `fb`, `adresse`, `nom_p`, `prenom_p`, `contacte_p`, `email_p`, `adresse_p`, `profession_p`, `nom_m`, `prenom_m`, `contacte_m`, `email_m`, `adresse_m`, `profession_m`, `nom_t`, `prenom_t`, `contacte_t`, `email_t`, `adresse_t`, `profession_t`, `NAT_id`, `AB_id`, `SB_id`, `MB_id`, `REC_id`, `dateRec`) VALUES
('SE20220001', 0, 'SE20220001.jpg', 'RAKOTO', 'Aina', 1, '2000-01-01', 'Befelatanana', '034 11 222 33, 032 00 111 22, ', '', '', '', 'RAKOTO', 'Jean', '034 22 111 33', '', '', '', 'RAKOTO', 'Rasoa', '038 44 555 66', '', '', '', '', '', '', '', '', '', 1, 1, 1, 1, 4, NULL),
('SE20220002', 0, NULL, 'RAVAO', 'Noro', 0, '2002-07-29', 'Andravoangy', '032 00 000 00, , ', '', '', '', 'brad', 'Jean', '034 22 111 33', '', '', '', 'Je', 'lo', '038 44 555 66', '', '', '', '', '', '', '', '', '', 1, 1, 1, 1, 4, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `gp`
--

CREATE TABLE `gp` (
  `idGP` int(11) NOT NULL,
  `nom_gp` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gp`
--

INSERT INTO `gp` (`idGP`, `nom_gp`) VALUES
(1, 'TC'),
(2, 'IRD'),
(3, 'BANCASS'),
(4, 'MEGP'),
(5, 'IMP'),
(6, 'MIAGE'),
(7, 'QUADD'),
(8, 'TC1'),
(9, 'TC2'),
(10, 'TC3'),
(11, 'TC4'),
(12, 'TC5'),
(13, 'TC6'),
(14, 'TC7'),
(15, 'TC8'),
(16, 'TC9'),
(17, 'TC10'),
(18, 'TC11'),
(19, 'TC12'),
(20, 'TC13'),
(21, 'TC14'),
(22, 'IRD1'),
(23, 'IRD2'),
(24, 'IRD3'),
(25, 'IRD4'),
(26, 'IRD5'),
(27, 'IRD6'),
(28, 'IRD7'),
(29, 'IRD8'),
(30, 'IRD9'),
(31, 'IRD10'),
(32, 'IRD11'),
(33, 'IRD12'),
(34, 'IRD13'),
(35, 'IRD14'),
(36, 'BANCASS1'),
(37, 'BANCASS2'),
(38, 'BANCASS3'),
(39, 'BANCASS4'),
(40, 'BANCASS5'),
(41, 'BANCASS6'),
(42, 'BANCASS7'),
(43, 'BANCASS8'),
(44, 'MEGP1'),
(45, 'MEGP2'),
(46, 'MEGP3'),
(47, 'MEGP4'),
(48, 'MEGP5'),
(49, 'MEGP6'),
(50, 'MEGP7'),
(51, 'MEGP8'),
(52, 'IMP1'),
(53, 'IMP2'),
(54, 'IMP3'),
(55, 'IMP4'),
(56, 'MIAGE1'),
(57, 'MIAGE2'),
(58, 'MIAGE3'),
(59, 'MIAGE4'),
(60, 'QUADD1'),
(61, 'QUADD2'),
(62, 'QUADD3'),
(63, 'QUADD4');

-- --------------------------------------------------------

--
-- Structure de la table `gp_has_au`
--

CREATE TABLE `gp_has_au` (
  `AU_id` int(11) NOT NULL,
  `NIV_id` tinyint(2) NOT NULL,
  `GP_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `gp_has_au`
--

INSERT INTO `gp_has_au` (`AU_id`, `NIV_id`, `GP_id`) VALUES
(6, 1, 1),
(6, 1, 2),
(6, 1, 8),
(6, 1, 9),
(6, 1, 10),
(6, 1, 11),
(6, 1, 12),
(6, 1, 22),
(6, 1, 23),
(6, 1, 24),
(6, 2, 2),
(6, 2, 3),
(6, 2, 22),
(6, 2, 23),
(6, 2, 44),
(6, 2, 45),
(6, 3, 2),
(6, 3, 3),
(6, 3, 4),
(6, 3, 44),
(6, 3, 45),
(6, 4, 5),
(6, 4, 6),
(6, 5, 1),
(7, 1, 1),
(7, 1, 8),
(7, 1, 9),
(7, 1, 10),
(7, 1, 11),
(7, 1, 12),
(7, 1, 22),
(7, 1, 23),
(7, 1, 24),
(7, 2, 3),
(7, 2, 22),
(7, 2, 23),
(7, 2, 44),
(7, 2, 45),
(7, 3, 2),
(7, 3, 3),
(7, 3, 22),
(7, 3, 23),
(7, 3, 44),
(7, 3, 45),
(7, 4, 5),
(7, 4, 6),
(7, 4, 7),
(7, 5, 1),
(7, 5, 5),
(7, 5, 6),
(8, 1, 1),
(8, 1, 2),
(8, 1, 8),
(8, 1, 9),
(8, 1, 10),
(8, 1, 11),
(8, 1, 12),
(8, 1, 22),
(8, 1, 23),
(8, 1, 24),
(8, 2, 2),
(8, 2, 3),
(8, 2, 4),
(8, 2, 22),
(8, 2, 23),
(8, 2, 24),
(8, 2, 36),
(8, 2, 37),
(8, 2, 44),
(8, 2, 45),
(8, 2, 46),
(8, 3, 2),
(8, 3, 3),
(8, 3, 4),
(8, 3, 22),
(8, 3, 23),
(8, 3, 44),
(8, 3, 45),
(8, 4, 5),
(8, 4, 6),
(8, 4, 7),
(8, 5, 5),
(8, 5, 6),
(8, 5, 7),
(9, 1, 1),
(9, 1, 2),
(9, 1, 8),
(9, 1, 9),
(9, 1, 10),
(9, 1, 11),
(9, 1, 12),
(9, 1, 22),
(9, 1, 23),
(9, 1, 24),
(9, 2, 2),
(9, 2, 3),
(9, 2, 4),
(9, 2, 22),
(9, 2, 23),
(9, 2, 36),
(9, 2, 37),
(9, 2, 44),
(9, 2, 45),
(9, 3, 2),
(9, 3, 3),
(9, 3, 4),
(9, 3, 22),
(9, 3, 23),
(9, 3, 36),
(9, 3, 37),
(9, 3, 44),
(9, 3, 45),
(9, 4, 5),
(9, 4, 6),
(9, 4, 7),
(9, 5, 5),
(9, 5, 6),
(9, 5, 7),
(10, 1, 1),
(10, 1, 2);

-- --------------------------------------------------------

--
-- Structure de la table `history`
--

CREATE TABLE `history` (
  `id` int(10) NOT NULL,
  `actor_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `actor_id` varchar(70) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject_id` int(10) DEFAULT NULL,
  `oldValues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`oldValues`)),
  `newValues` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`newValues`)),
  `changes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`changes`)),
  `created_at` datetime(6) DEFAULT NULL,
  `subject_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `history`
--

INSERT INTO `history` (`id`, `actor_type`, `actor_id`, `action`, `subject_id`, `oldValues`, `newValues`, `changes`, `created_at`, `subject_type`) VALUES
(1, 'USER', '', 'CREATE', 0, '[]', '{\"db\":{},\"table\":\"inscription\",\"u0000*u0000isPK\":\"num_matr\",\"u0000*u0000isAI\":true,\"num_matr\":\"SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`db_esge`.`inscription`, CONSTRAINT `fk_inscription_TrancheFS1` FOREIGN KEY (`TrancheFS_id`) REFERENCES `tranchefs` (`idT`) ON DELETE NO ACTION ON UPDATE NO ACTION)\",\"ETUDIANT_nie\":\"SE20220002\",\"AU_id\":\"10\",\"NIV_id\":\"1\",\"GP_id\":\"1\",\"dateInscr\":\"2022-08-01T08:05:09+02:00\",\"abandon\":0,\"ENTRETIEN_id\":6}', '[]', '0000-00-00 00:00:00.000000', 'Inscription'),
(2, 'USER', '', 'CREATE', 7, '[]', '{\"db\":{},\"table\":\"entretien\",\"u0000App\\Models\\EntretienModelu0000tableName\":\"entretien\",\"u0000*u0000isPK\":\"idENTR\",\"u0000*u0000isAI\":true,\"idENTR\":\"7\",\"AU_id\":\"10\",\"NIV_id\":\"1\",\"DO_id\":null,\"REC_id\":\"3\",\"GP_id\":null,\"AB_id\":null,\"SB_id\":null,\"MB_id\":null,\"nom\":\"RAKOTO\",\"prenom\":\"Aina\",\"sexe\":\"0\",\"contact\":\"034 11 222 33\",\"date_entretien\":\"2022-08-03T13:11\",\"datenaiss\":\"1998-07-22\",\"lieunaiss\":null,\"adresse\":null,\"religion\":null,\"etablissement\":null,\"presentation_soi\":null,\"ignoreOldInterview\":false,\"allow_same_date\":false,\"allow_same_person\":false,\"ecole\":null,\"college\":null,\"lycee\":null,\"comportement\":null,\"fume\":0,\"boit\":0,\"autodidacte\":null,\"experience\":null,\"autre\":null,\"pere\":null,\"nom_pere\":null,\"prenom_pere\":null,\"contact_pere\":null,\"email_pere\":null,\"adresse_pere\":null,\"profession_pere\":null,\"mere\":null,\"nom_mere\":null,\"prenom_mere\":null,\"contact_mere\":null,\"email_mere\":null,\"adresse_mere\":null,\"profession_mere\":null,\"freres\":null,\"soeurs\":null,\"domaine_souhaite\":null,\"connaissance_esmia\":null,\"motivation\":null,\"attentes\":null,\"problemes\":null,\"vision\":null,\"projets\":null,\"loisirs\":null,\"qualites\":null,\"defauts\":null,\"frs\":null,\"agl\":null,\"info\":null,\"react\":null,\"favorable\":0,\"responsable\":null,\"closed\":0,\"creationDate\":null,\"updateDate\":null,\"u0000App\\Models\\EntretienModelu0000hiddenAttrs\":[\"hiddenAttrs\",\"db\",\"table\",\"tableName\",\"isPK\",\"isAI\",\"idENTR\"],\"invalidAttributes\":[]}', '[]', '0000-00-00 00:00:00.000000', 'Entretien');

-- --------------------------------------------------------

--
-- Structure de la table `inscription`
--

CREATE TABLE `inscription` (
  `num_matr` int(11) NOT NULL,
  `ETUDIANT_nie` varchar(10) NOT NULL,
  `TrancheFS_id` int(11) NOT NULL,
  `AU_id` int(11) NOT NULL,
  `NIV_id` tinyint(2) NOT NULL,
  `GP_id` int(11) DEFAULT NULL,
  `abandon` tinyint(1) NOT NULL DEFAULT 0,
  `dateInscr` date DEFAULT NULL,
  `DI` decimal(8,0) DEFAULT NULL,
  `Reste_DI` decimal(8,0) DEFAULT NULL,
  `EP` varchar(70) DEFAULT NULL,
  `DO_id` tinyint(2) NOT NULL,
  `do_en` varchar(70) DEFAULT NULL,
  `comment` varchar(70) DEFAULT NULL,
  `list_dossier` varchar(45) DEFAULT NULL,
  `pwd` varchar(10) DEFAULT NULL,
  `ENTRETIEN_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `inscription_has_dossier`
--

CREATE TABLE `inscription_has_dossier` (
  `INSCRIPTION_id` int(11) NOT NULL,
  `DOSSIER_id` tinyint(2) NOT NULL,
  `observation` text DEFAULT NULL,
  `isValid` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `mb`
--

CREATE TABLE `mb` (
  `idMB` tinyint(2) NOT NULL,
  `mention` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `mb`
--

INSERT INTO `mb` (`idMB`, `mention`) VALUES
(1, 'Sans Mention'),
(2, 'Assez-Bien'),
(3, 'Bien'),
(4, 'Très Bien'),
(5, 'Excellent');

-- --------------------------------------------------------

--
-- Structure de la table `nat`
--

CREATE TABLE `nat` (
  `idNAT` tinyint(2) NOT NULL,
  `nationalite` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `nat`
--

INSERT INTO `nat` (`idNAT`, `nationalite`) VALUES
(1, 'MALAGASY'),
(2, 'GABONAISE'),
(3, 'CHINOISE'),
(4, 'FRANçAIS');

-- --------------------------------------------------------

--
-- Structure de la table `niv`
--

CREATE TABLE `niv` (
  `idNIV` tinyint(2) NOT NULL,
  `nom_niv` varchar(2) DEFAULT NULL,
  `description` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `niv`
--

INSERT INTO `niv` (`idNIV`, `nom_niv`, `description`) VALUES
(1, 'L1', NULL),
(2, 'L2', NULL),
(3, 'L3', NULL),
(4, 'M1', NULL),
(5, 'M2', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `niv_has_dos`
--

CREATE TABLE `niv_has_dos` (
  `DOS_id` tinyint(2) NOT NULL,
  `NIV_id` tinyint(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `niv_has_dos`
--

INSERT INTO `niv_has_dos` (`DOS_id`, `NIV_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(3, 1),
(3, 2),
(3, 3),
(3, 4),
(3, 5),
(4, 1),
(4, 2),
(4, 3),
(4, 4),
(4, 5),
(5, 1),
(5, 2),
(5, 3),
(5, 4),
(5, 5),
(6, 1),
(6, 2),
(6, 3),
(6, 4),
(6, 5),
(7, 1),
(7, 2),
(7, 3),
(7, 4),
(7, 5),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(11, 2),
(11, 3),
(12, 2),
(12, 3),
(12, 4),
(12, 5),
(13, 3),
(13, 4),
(13, 5),
(14, 4),
(14, 5),
(15, 5),
(16, 1),
(16, 2),
(16, 3),
(16, 4),
(16, 5),
(17, 4),
(17, 5);

-- --------------------------------------------------------

--
-- Structure de la table `recruteur`
--

CREATE TABLE `recruteur` (
  `idREC` tinyint(2) NOT NULL,
  `nom_rec` varchar(70) DEFAULT NULL,
  `prenom_rec` varchar(70) DEFAULT NULL,
  `sexe_rec` tinyint(1) DEFAULT 0,
  `email_rec` varchar(70) DEFAULT NULL,
  `poste_rec` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `recruteur`
--

INSERT INTO `recruteur` (`idREC`, `nom_rec`, `prenom_rec`, `sexe_rec`, `email_rec`, `poste_rec`) VALUES
(1, 'RAMANANARIVO', 'Romaine', 0, 'r.ramananarivo@esmia-mada.com', 'DG'),
(2, 'RAMANANARIVO', 'Sylvain', 1, 's.ramananarivo@esmia-mada.com', 'DGA'),
(3, 'RAKOTONDRAHANTA', 'Ndriambolanirina', 1, 'rqual@esmia-mada.com', 'DAQCOM'),
(4, 'RAMANANARIVO', 'Aina Rosy', 0, 'directiondesetudes@esmia-mada.com', 'DE'),
(5, 'RAMPANANA', 'Jess', 1, 'scolarite2@esmia-mada.com', 'SPDE');

-- --------------------------------------------------------

--
-- Structure de la table `sb`
--

CREATE TABLE `sb` (
  `idSB` tinyint(2) NOT NULL,
  `serie` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `sb`
--

INSERT INTO `sb` (`idSB`, `serie`) VALUES
(1, 'A1'),
(2, 'A2'),
(3, 'C'),
(4, 'D'),
(5, 'G1'),
(6, 'G2'),
(7, 'G3'),
(8, 'STMG'),
(9, 'PRO GA'),
(10, 'ACA'),
(11, 'TGD'),
(12, 'TECHNIQUE'),
(13, 'TGI'),
(14, 'ACTC'),
(15, 'CG'),
(16, 'FTG'),
(17, 'SCIENTIFIQUE'),
(18, 'TTER'),
(19, 'BTP'),
(20, 'GESTION ADMINISTRATION'),
(21, 'COMPTABLE GESTION'),
(22, 'GESTION'),
(23, 'INFORMATIQUE'),
(24, 'ELECTRONIQUE'),
(25, 'S'),
(26, 'MANDARIN'),
(27, 'OSE'),
(28, 'LICENCE'),
(29, 'COMMUNICATION'),
(30, 'GENERAL'),
(31, 'LITTERAIRE'),
(32, 'L'),
(33, 'MARKETING ET COMMERCE'),
(34, '3 DIMENSIONAL COACHING');

-- --------------------------------------------------------

--
-- Structure de la table `type_user`
--

CREATE TABLE `type_user` (
  `idTU` int(11) NOT NULL,
  `type_tu` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `type_user`
--

INSERT INTO `type_user` (`idTU`, `type_tu`) VALUES
(1, 'devmaster'),
(2, 'admin'),
(3, 'standard'),
(4, 'guest'),
(5, 'job_etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `email` varchar(70) DEFAULT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `prenom` varchar(45) DEFAULT NULL,
  `sexe` tinyint(1) DEFAULT NULL,
  `photo` varchar(20) DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT current_timestamp(),
  `TU_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `nom`, `prenom`, `sexe`, `photo`, `create_time`, `TU_id`) VALUES
('admin', 'admin', 'admin@gmail.com', 'ADMIN', 'ESMIA', 1, NULL, '2020-11-14 02:35:20', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `ab`
--
ALTER TABLE `ab`
  ADD PRIMARY KEY (`idAB`);

--
-- Index pour la table `au`
--
ALTER TABLE `au`
  ADD PRIMARY KEY (`idAU`);

--
-- Index pour la table `do`
--
ALTER TABLE `do`
  ADD PRIMARY KEY (`idDO`);

--
-- Index pour la table `dossier`
--
ALTER TABLE `dossier`
  ADD PRIMARY KEY (`idDOS`);

--
-- Index pour la table `entretien`
--
ALTER TABLE `entretien`
  ADD PRIMARY KEY (`idENTR`),
  ADD KEY `FK_entretien_au` (`AU_id`),
  ADD KEY `FK_entretien_niv` (`NIV_id`),
  ADD KEY `FK_entretien_do` (`DO_id`),
  ADD KEY `FK_entretien_ab` (`AB_id`),
  ADD KEY `FK_entretien_sb` (`SB_id`),
  ADD KEY `FK_entretien_mb` (`MB_id`);

--
-- Index pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD PRIMARY KEY (`nie`),
  ADD KEY `fk_etudiant_NAT1_idx` (`NAT_id`),
  ADD KEY `fk_etudiant_AB1_idx` (`AB_id`),
  ADD KEY `fk_etudiant_SB1_idx` (`SB_id`),
  ADD KEY `fk_etudiant_MB1_idx` (`MB_id`),
  ADD KEY `fk_etudiant_recruteur1_idx` (`REC_id`);

--
-- Index pour la table `gp`
--
ALTER TABLE `gp`
  ADD PRIMARY KEY (`idGP`);

--
-- Index pour la table `gp_has_au`
--
ALTER TABLE `gp_has_au`
  ADD PRIMARY KEY (`AU_id`,`NIV_id`,`GP_id`),
  ADD KEY `fk_gp_has_au_au1_idx` (`AU_id`),
  ADD KEY `fk_gp_has_au_gp1_idx` (`GP_id`),
  ADD KEY `fk_gp_has_au_niv1_idx` (`NIV_id`);

--
-- Index pour la table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD PRIMARY KEY (`num_matr`),
  ADD KEY `fk_inscription_TrancheFS1_idx` (`TrancheFS_id`),
  ADD KEY `fk_inscription_etudiant1_idx` (`ETUDIANT_nie`),
  ADD KEY `fk_inscription_do1_idx` (`DO_id`),
  ADD KEY `fk_inscription_niv1_idx` (`NIV_id`),
  ADD KEY `fk_inscription_gp1_idx` (`GP_id`),
  ADD KEY `fk_inscription_au1_idx` (`AU_id`);

--
-- Index pour la table `inscription_has_dossier`
--
ALTER TABLE `inscription_has_dossier`
  ADD PRIMARY KEY (`INSCRIPTION_id`,`DOSSIER_id`),
  ADD KEY `fk_inscription_has_dossier_inscription` (`INSCRIPTION_id`),
  ADD KEY `fk_inscription_has_dossier_dossier` (`DOSSIER_id`);

--
-- Index pour la table `mb`
--
ALTER TABLE `mb`
  ADD PRIMARY KEY (`idMB`);

--
-- Index pour la table `nat`
--
ALTER TABLE `nat`
  ADD PRIMARY KEY (`idNAT`);

--
-- Index pour la table `niv`
--
ALTER TABLE `niv`
  ADD PRIMARY KEY (`idNIV`);

--
-- Index pour la table `niv_has_dos`
--
ALTER TABLE `niv_has_dos`
  ADD PRIMARY KEY (`DOS_id`,`NIV_id`),
  ADD KEY `fk_dossier_has_niv_niv1_idx` (`NIV_id`),
  ADD KEY `fk_dossier_has_niv_dossier1_idx` (`DOS_id`);

--
-- Index pour la table `recruteur`
--
ALTER TABLE `recruteur`
  ADD PRIMARY KEY (`idREC`);

--
-- Index pour la table `sb`
--
ALTER TABLE `sb`
  ADD PRIMARY KEY (`idSB`);

--
-- Index pour la table `type_user`
--
ALTER TABLE `type_user`
  ADD PRIMARY KEY (`idTU`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD KEY `fk_user_type_user1_idx` (`TU_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `ab`
--
ALTER TABLE `ab`
  MODIFY `idAB` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pour la table `au`
--
ALTER TABLE `au`
  MODIFY `idAU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `do`
--
ALTER TABLE `do`
  MODIFY `idDO` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `dossier`
--
ALTER TABLE `dossier`
  MODIFY `idDOS` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `entretien`
--
ALTER TABLE `entretien`
  MODIFY `idENTR` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `gp`
--
ALTER TABLE `gp`
  MODIFY `idGP` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT pour la table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `inscription`
--
ALTER TABLE `inscription`
  MODIFY `num_matr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3392;

--
-- AUTO_INCREMENT pour la table `mb`
--
ALTER TABLE `mb`
  MODIFY `idMB` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `nat`
--
ALTER TABLE `nat`
  MODIFY `idNAT` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `niv`
--
ALTER TABLE `niv`
  MODIFY `idNIV` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `recruteur`
--
ALTER TABLE `recruteur`
  MODIFY `idREC` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `sb`
--
ALTER TABLE `sb`
  MODIFY `idSB` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `type_user`
--
ALTER TABLE `type_user`
  MODIFY `idTU` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `entretien`
--
ALTER TABLE `entretien`
  ADD CONSTRAINT `FK_entretien_ab` FOREIGN KEY (`AB_id`) REFERENCES `ab` (`idAB`),
  ADD CONSTRAINT `FK_entretien_au` FOREIGN KEY (`AU_id`) REFERENCES `au` (`idAU`),
  ADD CONSTRAINT `FK_entretien_do` FOREIGN KEY (`DO_id`) REFERENCES `do` (`idDO`),
  ADD CONSTRAINT `FK_entretien_mb` FOREIGN KEY (`MB_id`) REFERENCES `mb` (`idMB`),
  ADD CONSTRAINT `FK_entretien_niv` FOREIGN KEY (`NIV_id`) REFERENCES `niv` (`idNIV`),
  ADD CONSTRAINT `FK_entretien_sb` FOREIGN KEY (`SB_id`) REFERENCES `sb` (`idSB`);

--
-- Contraintes pour la table `etudiant`
--
ALTER TABLE `etudiant`
  ADD CONSTRAINT `fk_etudiant_AB1` FOREIGN KEY (`AB_id`) REFERENCES `ab` (`idAB`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etudiant_MB1` FOREIGN KEY (`MB_id`) REFERENCES `mb` (`idMB`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etudiant_NAT1` FOREIGN KEY (`NAT_id`) REFERENCES `nat` (`idNAT`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etudiant_SB1` FOREIGN KEY (`SB_id`) REFERENCES `sb` (`idSB`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_etudiant_recruteur1` FOREIGN KEY (`REC_id`) REFERENCES `recruteur` (`idREC`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `gp_has_au`
--
ALTER TABLE `gp_has_au`
  ADD CONSTRAINT `fk_gp_has_au_au1` FOREIGN KEY (`AU_id`) REFERENCES `au` (`idAU`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_gp_has_au_gp1` FOREIGN KEY (`GP_id`) REFERENCES `gp` (`idGP`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_gp_has_au_niv1` FOREIGN KEY (`NIV_id`) REFERENCES `niv` (`idNIV`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `inscription`
--
ALTER TABLE `inscription`
  ADD CONSTRAINT `fk_inscription_TrancheFS1` FOREIGN KEY (`TrancheFS_id`) REFERENCES `tranchefs` (`idT`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscription_au1` FOREIGN KEY (`AU_id`) REFERENCES `au` (`idAU`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscription_do1` FOREIGN KEY (`DO_id`) REFERENCES `do` (`idDO`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscription_etudiant1` FOREIGN KEY (`ETUDIANT_nie`) REFERENCES `etudiant` (`nie`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_inscription_gp1` FOREIGN KEY (`GP_id`) REFERENCES `gp` (`idGP`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscription_niv1` FOREIGN KEY (`NIV_id`) REFERENCES `niv` (`idNIV`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `inscription_has_dossier`
--
ALTER TABLE `inscription_has_dossier`
  ADD CONSTRAINT `fk_inscription_has_dossier_dossier` FOREIGN KEY (`DOSSIER_id`) REFERENCES `dossier` (`idDOS`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_inscription_has_dossier_inscription` FOREIGN KEY (`INSCRIPTION_id`) REFERENCES `inscription` (`num_matr`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `niv_has_dos`
--
ALTER TABLE `niv_has_dos`
  ADD CONSTRAINT `fk_dossier_has_niv_dossier1` FOREIGN KEY (`DOS_id`) REFERENCES `dossier` (`idDOS`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_dossier_has_niv_niv1` FOREIGN KEY (`NIV_id`) REFERENCES `niv` (`idNIV`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_user_type_user1` FOREIGN KEY (`TU_id`) REFERENCES `type_user` (`idTU`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
