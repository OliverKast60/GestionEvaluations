-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 30 jan. 2024 à 13:36
-- Version du serveur : 10.4.25-MariaDB
-- Version de PHP : 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `geva`
--

-- --------------------------------------------------------

--
-- Structure de la table `tblattendances`
--

CREATE TABLE `tblattendances` (
  `id` int(11) NOT NULL,
  `a_student` int(11) NOT NULL,
  `a_eval` int(11) NOT NULL,
  `a_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblattendances`
--

INSERT INTO `tblattendances` (`id`, `a_student`, `a_eval`, `a_status`) VALUES
(9, 8, 8, 1),
(10, 7, 9, 1),
(11, 10, 10, 1),
(12, 10, 11, 1),
(13, 9, 12, 1),
(14, 9, 13, 1),
(15, 9, 13, 1),
(16, 9, 12, 1),
(17, 9, 14, 1),
(18, 11, 15, 1),
(19, 8, 8, 1),
(20, 9, 18, 1),
(21, 9, 14, 1),
(22, 8, 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `tblclassements`
--

CREATE TABLE `tblclassements` (
  `id` int(11) NOT NULL,
  `cl_surveillant` int(11) NOT NULL,
  `cl_salle` int(11) NOT NULL,
  `cl_rapport` varchar(255) NOT NULL,
  `cl_date_enreg` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblclassements`
--

INSERT INTO `tblclassements` (`id`, `cl_surveillant`, `cl_salle`, `cl_rapport`, `cl_date_enreg`) VALUES
(3, 6, 1, '', '2024-01-07'),
(4, 6, 1, '', '2024-01-07'),
(5, 6, 1, '', '2024-01-08'),
(6, 7, 2, '', '2024-01-08'),
(7, 6, 1, '', '2024-01-08'),
(8, 6, 2, '', '2024-01-08'),
(9, 6, 2, '', '2024-01-08'),
(10, 9, 3, '', '2024-01-14');

-- --------------------------------------------------------

--
-- Structure de la table `tblclasses`
--

CREATE TABLE `tblclasses` (
  `id` int(11) NOT NULL,
  `c_name` varchar(40) NOT NULL,
  `c_faculty` int(11) NOT NULL,
  `c_option` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblclasses`
--

INSERT INTO `tblclasses` (`id`, `c_name`, `c_faculty`, `c_option`) VALUES
(5, 'L0', 6, 'FSTA'),
(6, 'L1', 6, 'FSTA'),
(7, 'L2', 6, 'Génie ElecInfo'),
(8, 'L3', 6, 'Génie Informatique'),
(9, 'L2', 6, 'Génie Civil'),
(10, 'L3', 6, 'Génie Civil'),
(11, 'L3', 6, 'Génie Électrique');

-- --------------------------------------------------------

--
-- Structure de la table `tblcourses`
--

CREATE TABLE `tblcourses` (
  `id` int(11) NOT NULL,
  `c_intitule` varchar(100) NOT NULL,
  `c_volume_horaire` int(11) NOT NULL,
  `c_classe` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblcourses`
--

INSERT INTO `tblcourses` (`id`, `c_intitule`, `c_volume_horaire`, `c_classe`) VALUES
(6, 'Physique', 105, 5),
(7, 'VIH SIDA', 15, 5),
(8, 'Algebre', 90, 5),
(9, 'IRS', 15, 6),
(10, 'Géométrie Analytique', 60, 5),
(11, 'Analyse complexe', 45, 7),
(12, 'Analyse complexe', 60, 9),
(13, 'Géologie', 45, 9),
(14, 'SDM', 45, 9),
(15, 'SDM', 45, 7),
(16, 'MTE', 45, 10),
(17, 'MTE', 45, 11),
(18, 'EDT', 45, 10),
(19, 'EDT', 45, 11),
(20, 'Unix', 45, 7),
(21, 'Technologie de construction', 60, 9),
(22, 'Java avancé', 45, 8),
(23, 'Base des données', 60, 8),
(24, 'Internet Engineering', 60, 8),
(25, 'Physique', 90, 6),
(26, 'Algorithme', 60, 6),
(27, 'Mécanique rationnelle1', 60, 6);

-- --------------------------------------------------------

--
-- Structure de la table `tblevaluations`
--

CREATE TABLE `tblevaluations` (
  `id` int(11) NOT NULL,
  `e_type` varchar(100) NOT NULL,
  `e_session` int(11) NOT NULL,
  `e_salle` int(11) NOT NULL,
  `e_course` int(11) NOT NULL,
  `date_eval` date NOT NULL,
  `e_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblevaluations`
--

INSERT INTO `tblevaluations` (`id`, `e_type`, `e_session`, `e_salle`, `e_course`, `date_eval`, `e_status`) VALUES
(8, 'Test', 1, 1, 20, '2024-01-08', 1),
(9, 'Test', 1, 1, 6, '2024-01-08', 1),
(10, 'Examen', 1, 1, 22, '2024-02-07', 1),
(11, 'Test', 1, 2, 23, '2024-02-08', 1),
(12, 'Test', 1, 2, 26, '2024-03-19', 1),
(13, 'Test', 1, 1, 9, '2024-06-20', 1),
(14, 'Examen', 2, 2, 27, '2024-07-23', 1),
(15, 'Test', 1, 1, 17, '2024-05-08', 1),
(16, 'Test', 1, 2, 20, '2024-08-25', 1),
(17, 'Examen', 2, 3, 9, '2024-01-10', 1),
(18, 'Examen', 2, 4, 27, '2024-04-13', 1),
(19, 'Examen', 2, 3, 20, '2024-01-16', 1);

-- --------------------------------------------------------

--
-- Structure de la table `tblfaculties`
--

CREATE TABLE `tblfaculties` (
  `id` int(11) NOT NULL,
  `f_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblfaculties`
--

INSERT INTO `tblfaculties` (`id`, `f_name`) VALUES
(6, 'FSTA'),
(7, 'FSEG'),
(8, 'MEDICINE');

-- --------------------------------------------------------

--
-- Structure de la table `tblprofesseurs`
--

CREATE TABLE `tblprofesseurs` (
  `id` int(11) NOT NULL,
  `p_name` varchar(100) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_contact` varchar(20) NOT NULL,
  `p_address` varchar(100) NOT NULL,
  `p_matricule` varchar(20) NOT NULL,
  `p_course` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblprofesseurs`
--

INSERT INTO `tblprofesseurs` (`id`, `p_name`, `p_image`, `p_contact`, `p_address`, `p_matricule`, `p_course`) VALUES
(5, 'Alisson Becker', 'R.jpg', 'alissonbecker@gmail.', 'Miami', 'AliUyKX1432024', 6),
(6, 'Jeanne Kasongo', 'happy-student-610351.jpg', 'jeannekasongo12@gmai', 'Mbuji-mayi', 'JeamtKs7572024', 7),
(8, 'Rebecca Moore', 'download-5.jpg', 'rebeccamoore@hotmail', 'Oxford 14th street 324', 'Reb8HFK2572024', 24),
(9, 'Daniel Lopez', 'daniel-lopez.png', 'danilopez@gmail.com', 'Los angeles', 'Dan4moc5552024', 10),
(10, 'Olivier Kasonia', 'portrait.PNG', 'oliverkast60@gmail.c', 'Q Himbi av du Musee 429', 'OliEaTE6922024', 22);

-- --------------------------------------------------------

--
-- Structure de la table `tblsalles`
--

CREATE TABLE `tblsalles` (
  `id` int(11) NOT NULL,
  `s_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblsalles`
--

INSERT INTO `tblsalles` (`id`, `s_name`) VALUES
(1, 'Room 1'),
(2, 'Room 2'),
(3, 'Room 3'),
(4, 'Room 4');

-- --------------------------------------------------------

--
-- Structure de la table `tblstudents`
--

CREATE TABLE `tblstudents` (
  `id` int(11) NOT NULL,
  `s_matricule` varchar(100) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_userimage` varchar(255) NOT NULL,
  `s_sex` varchar(20) NOT NULL,
  `s_civil` varchar(20) NOT NULL,
  `s_date_naissance` date NOT NULL,
  `s_nationalite` varchar(100) NOT NULL,
  `s_contact` varchar(100) NOT NULL,
  `s_classe` int(11) NOT NULL,
  `s_address` varchar(100) NOT NULL,
  `student_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblstudents`
--

INSERT INTO `tblstudents` (`id`, `s_matricule`, `s_name`, `s_userimage`, `s_sex`, `s_civil`, `s_date_naissance`, `s_nationalite`, `s_contact`, `s_classe`, `s_address`, `student_status`) VALUES
(7, 'STD-AA-011-441-2024', 'Asikire Itehero John', 'portrait-african-american-man.jpg', 'Masculin', 'Célibataire', '1998-01-02', 'COD', 'asikirejohn@gmail.com', 5, 'kyeshero', 0),
(8, 'STD-AA-011-649-2024', 'Alice Heri', 'pexels-kebs-visuals-3992656.jpg', 'Féminin', 'Célibataire', '2001-09-07', 'CMR', 'aliceheri34@gmail.com', 7, 'Yaounde', 0),
(9, 'STD-AA-011-814-2024', 'Kasereka Josue', 'admin.jpg', 'Masculin', 'Marié', '1990-12-10', 'COD', 'joshkasereka5@gmail.com', 6, 'Buja', 0),
(10, 'STD-AA-011-692-2024', 'Hope Ndeze', 'depositphotos_61603001-stock-photo-young-student.jpg', 'Féminin', 'Célibataire', '2000-03-08', 'COD', 'hopendeze@yahoo.fr', 8, 'Kituku', 0),
(11, 'STD-AA-011-545-2024', 'Junior Salumu', 'jeune-homme-posant-studio-coup-moyen.jpg', 'Masculin', 'Célibataire', '1999-02-15', 'COD', 'salumujunior4@hotmail.com', 11, 'kyeshero', 0),
(12, 'STD-AA-011-634-2024', 'Angelina Nora', 'download-2.jpg', 'Féminin', 'Marié', '1997-01-03', 'COD', 'angelnora65@gmail.com', 10, 'Himbi, av. Mayimoto No. 134', 0),
(13, 'STD-AA-011-46-2024', 'Furaha Josiane', 'download-3.jpg', 'Féminin', 'Célibataire', '2001-04-01', 'COD', 'furahajosiane@gmail.com', 8, 'Himbi, av. De la paix No. 35', 0),
(14, 'STD-AA-011-954-2024', 'Kasereka kasonia olivier', 'portrait2.PNG', 'Masculin', 'Célibataire', '2001-07-12', 'COD', 'oliverkast60@gmail.com', 8, 'Q Himbi av du Musee 429', 0);

-- --------------------------------------------------------

--
-- Structure de la table `tblsurveillants`
--

CREATE TABLE `tblsurveillants` (
  `id` int(11) NOT NULL,
  `s_name` varchar(100) NOT NULL,
  `s_matricule` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblsurveillants`
--

INSERT INTO `tblsurveillants` (`id`, `s_name`, `s_matricule`) VALUES
(6, 'john mende', 'johPY55812024'),
(7, 'Alliance Mbafumoja', 'Allvoze3122024'),
(8, 'Grace Binakosa', 'Gra8tc39882024'),
(9, 'Salomon Iteh', 'Salf1GB8772024');

-- --------------------------------------------------------

--
-- Structure de la table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `matricule` varchar(40) NOT NULL,
  `userimage` varchar(255) NOT NULL,
  `permission` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `tblusers`
--

INSERT INTO `tblusers` (`id`, `username`, `password`, `name`, `lastname`, `matricule`, `userimage`, `permission`, `status`) VALUES
(1, 'Alain', '81dc9bdb52d04dc20036dbd8313ed055', 'Alain', 'Shikaneza', 'TYU344536', 'bouchent-portrait-homme-seduisant-coiffure-afro-chaume-porte-anorak-orange.jpg', 'Chef de département', 1),
(2, 'Directeur', '81dc9bdb52d04dc20036dbd8313ed055', 'Oliver', 'Kast', '754HDGGFD', 'portrait2.PNG', 'Directeur académique', 1),
(3, 'Amisi', '81dc9bdb52d04dc20036dbd8313ed055', 'Amisi', 'Cubahiro', 'AM6634432023', 'portrait-african-american-man.jpg', 'Doyen de la faculté', 1),
(4, 'kast', '81dc9bdb52d04dc20036dbd8313ed055', 'oliver', 'kast', '564HIGGFD', 'portrait2.PNG', 'Directeur académique', 0);

-- --------------------------------------------------------

--
-- Structure de la table `userlog`
--

CREATE TABLE `userlog` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `userip` binary(16) NOT NULL,
  `loginTime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `logout` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `userlog`
--

INSERT INTO `userlog` (`id`, `username`, `name`, `userip`, `loginTime`, `logout`) VALUES
(1, 'Elisa', 'Karinde', 0x00001101011010110000000000000000, '2023-05-23 09:28:38', ''),
(2, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-23 10:56:10', ''),
(3, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-23 12:03:46', ''),
(4, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-23 12:06:22', ''),
(5, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-23 12:09:48', ''),
(6, 'uiyuioyu', 'Intruision', 0x3a3a3100000000000000000000000000, '2023-05-23 12:10:09', ''),
(7, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-23 12:11:21', ''),
(8, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-23 13:04:58', ''),
(9, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-24 07:00:29', '24-05-2023 09:00:29 AM'),
(10, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-24 07:52:59', '24-05-2023 09:52:59 AM'),
(11, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-24 07:55:28', '24-05-2023 09:55:28 AM'),
(12, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-24 07:55:41', '24-05-2023 09:55:41 AM'),
(13, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-24 07:55:53', ''),
(14, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-24 09:04:08', ''),
(15, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-24 12:45:26', ''),
(16, 'Alain', 'Intruision', 0x3a3a3100000000000000000000000000, '2023-05-25 06:43:23', ''),
(17, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-25 07:17:18', '25-05-2023 09:17:18 AM'),
(18, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-25 08:01:30', '25-05-2023 10:01:30 AM'),
(19, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-25 09:27:23', '25-05-2023 11:27:23 AM'),
(20, 'Directeur', 'Intruision', 0x3a3a3100000000000000000000000000, '2023-05-25 09:27:45', ''),
(21, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-25 09:27:58', ''),
(22, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-25 09:52:05', ''),
(23, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-25 15:15:56', '25-05-2023 05:15:56 PM'),
(24, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-25 16:14:24', '25-05-2023 06:14:24 PM'),
(25, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 08:40:04', '26-05-2023 10:40:04 AM'),
(26, 'Alain', 'Alain', 0x3a3a3100000000000000000000000000, '2023-05-26 09:05:42', '26-05-2023 11:05:42 AM'),
(27, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 09:26:44', '26-05-2023 11:26:44 AM'),
(28, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 09:27:02', '26-05-2023 11:27:02 AM'),
(29, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 09:50:47', '26-05-2023 11:50:47 AM'),
(30, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 09:52:10', '26-05-2023 11:52:10 AM'),
(31, 'Amisi', 'Amisi', 0x3a3a3100000000000000000000000000, '2023-05-26 09:52:35', '26-05-2023 11:52:35 AM'),
(32, 'Amisi', 'Amisi', 0x3a3a3100000000000000000000000000, '2023-05-26 09:55:48', '26-05-2023 11:55:48 AM'),
(33, 'Amisi', 'Amisi', 0x3a3a3100000000000000000000000000, '2023-05-26 09:56:53', '26-05-2023 11:56:53 AM'),
(34, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 09:57:01', '26-05-2023 11:57:01 AM'),
(35, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 10:25:06', '26-05-2023 12:25:06 PM'),
(36, 'Directeur', 'Bukuru', 0x3a3a3100000000000000000000000000, '2023-05-26 10:45:32', '26-05-2023 12:45:32 PM'),
(44, 'Directeur', 'Bukuru', 0x3132372e302e302e3100000000000000, '2024-01-05 22:10:54', '05-01-2024 11:10:54 PM'),
(45, 'Amisi', 'Amisi', 0x3132372e302e302e3100000000000000, '2024-01-05 22:14:29', '05-01-2024 11:14:29 PM'),
(46, 'alain', 'Alain', 0x3132372e302e302e3100000000000000, '2024-01-07 17:18:41', '07-01-2024 06:18:41 PM'),
(47, 'DIREcteur', 'Bukuru', 0x3132372e302e302e3100000000000000, '2024-01-08 13:49:19', '08-01-2024 02:49:19 PM'),
(48, 'Directeur', 'Intruision', 0x3132372e302e302e3100000000000000, '2024-01-08 13:49:38', ''),
(49, 'directeur', 'Intruision', 0x3132372e302e302e3100000000000000, '2024-01-08 13:49:56', ''),
(50, 'Directeur', 'Intruision', 0x3132372e302e302e3100000000000000, '2024-01-08 13:51:25', ''),
(51, 'alain', 'Alain', 0x3a3a3100000000000000000000000000, '2024-01-08 14:00:00', ''),
(52, 'Oliver', 'Intruision', 0x3132372e302e302e3100000000000000, '2024-01-08 17:49:04', ''),
(53, 'directeur', 'Intruision', 0x3132372e302e302e3100000000000000, '2024-01-08 17:49:21', ''),
(54, 'directeur', 'Intruision', 0x3132372e302e302e3100000000000000, '2024-01-08 17:49:48', ''),
(55, 'directeur', 'Oliver', 0x3132372e302e302e3100000000000000, '2024-01-09 10:48:01', '09-01-2024 11:48:01 AM'),
(56, 'Alain', 'Alain', 0x3132372e302e302e3100000000000000, '2024-01-09 18:26:32', '09-01-2024 07:26:32 PM'),
(57, 'alain', 'Alain', 0x3132372e302e302e3100000000000000, '2024-01-12 12:23:36', ''),
(58, 'alain', 'Alain', 0x3132372e302e302e3100000000000000, '2024-01-13 18:37:10', ''),
(59, 'alain', 'Alain', 0x3132372e302e302e3100000000000000, '2024-01-14 15:08:52', ''),
(60, 'alain', 'Alain', 0x3132372e302e302e3100000000000000, '2024-01-25 11:14:43', ''),
(61, 'alain', 'Alain', 0x3132372e302e302e3100000000000000, '2024-01-30 12:34:58', '');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tblattendances`
--
ALTER TABLE `tblattendances`
  ADD PRIMARY KEY (`id`),
  ADD KEY `a_eval` (`a_eval`),
  ADD KEY `a_student` (`a_student`);

--
-- Index pour la table `tblclassements`
--
ALTER TABLE `tblclassements`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cl_surveillant` (`cl_surveillant`);

--
-- Index pour la table `tblclasses`
--
ALTER TABLE `tblclasses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_faculty` (`c_faculty`);

--
-- Index pour la table `tblcourses`
--
ALTER TABLE `tblcourses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `c_professeur` (`c_classe`);

--
-- Index pour la table `tblevaluations`
--
ALTER TABLE `tblevaluations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `e_course` (`e_course`),
  ADD KEY `e_salle` (`e_salle`);

--
-- Index pour la table `tblfaculties`
--
ALTER TABLE `tblfaculties`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tblprofesseurs`
--
ALTER TABLE `tblprofesseurs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `p_course` (`p_course`);

--
-- Index pour la table `tblsalles`
--
ALTER TABLE `tblsalles`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `s_classe` (`s_classe`);

--
-- Index pour la table `tblsurveillants`
--
ALTER TABLE `tblsurveillants`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `userlog`
--
ALTER TABLE `userlog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tblattendances`
--
ALTER TABLE `tblattendances`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `tblclassements`
--
ALTER TABLE `tblclassements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `tblclasses`
--
ALTER TABLE `tblclasses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `tblcourses`
--
ALTER TABLE `tblcourses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pour la table `tblevaluations`
--
ALTER TABLE `tblevaluations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `tblfaculties`
--
ALTER TABLE `tblfaculties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `tblprofesseurs`
--
ALTER TABLE `tblprofesseurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `tblsalles`
--
ALTER TABLE `tblsalles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tblstudents`
--
ALTER TABLE `tblstudents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `tblsurveillants`
--
ALTER TABLE `tblsurveillants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `userlog`
--
ALTER TABLE `userlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tblattendances`
--
ALTER TABLE `tblattendances`
  ADD CONSTRAINT `tblattendances_ibfk_1` FOREIGN KEY (`a_eval`) REFERENCES `tblevaluations` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblattendances_ibfk_2` FOREIGN KEY (`a_student`) REFERENCES `tblstudents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tblclassements`
--
ALTER TABLE `tblclassements`
  ADD CONSTRAINT `tblclassements_ibfk_1` FOREIGN KEY (`cl_surveillant`) REFERENCES `tblsurveillants` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tblclasses`
--
ALTER TABLE `tblclasses`
  ADD CONSTRAINT `tblclasses_ibfk_1` FOREIGN KEY (`c_faculty`) REFERENCES `tblfaculties` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tblcourses`
--
ALTER TABLE `tblcourses`
  ADD CONSTRAINT `tblcourses_ibfk_2` FOREIGN KEY (`c_classe`) REFERENCES `tblclasses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tblevaluations`
--
ALTER TABLE `tblevaluations`
  ADD CONSTRAINT `tblevaluations_ibfk_1` FOREIGN KEY (`e_course`) REFERENCES `tblcourses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblevaluations_ibfk_2` FOREIGN KEY (`e_salle`) REFERENCES `tblsalles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tblprofesseurs`
--
ALTER TABLE `tblprofesseurs`
  ADD CONSTRAINT `tblprofesseurs_ibfk_1` FOREIGN KEY (`p_course`) REFERENCES `tblcourses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `tblstudents`
--
ALTER TABLE `tblstudents`
  ADD CONSTRAINT `tblstudents_ibfk_1` FOREIGN KEY (`s_classe`) REFERENCES `tblclasses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
