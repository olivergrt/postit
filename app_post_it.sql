-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 07 avr. 2025 à 15:54
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `app_post_it`
--

-- --------------------------------------------------------

--
-- Structure de la table `post_it`
--

DROP TABLE IF EXISTS `post_it`;
CREATE TABLE IF NOT EXISTS `post_it` (
  `id_post_it` int(11) NOT NULL AUTO_INCREMENT,
  `id_proprietaire` int(11) NOT NULL,
  `titre` varchar(150) NOT NULL,
  `contenu` varchar(250) NOT NULL,
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_post_it`),
  KEY `fk_post_it_utilisateur` (`id_proprietaire`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post_it`
--

INSERT INTO `post_it` (`id_post_it`, `id_proprietaire`, `titre`, `contenu`, `date_creation`, `date_modification`) VALUES
(1, 1, 'test', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a', '2025-03-15 01:05:31', '2025-04-06 00:50:36'),
(2, 1, 'Révision Controle de gestion', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2025-03-15 01:06:30', NULL),
(3, 1, 'Faire les courses', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2025-03-15 16:30:51', '2025-04-06 00:55:44'),
(4, 1, 'Test insert date modification', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2025-04-03 12:03:43', '2025-04-03 12:03:43'),
(5, 1, 'Yanis', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2025-04-03 13:06:52', '2025-04-04 07:18:25'),
(7, 1, 'Terminer le developpement', 'Faire la maquette du projet', '2025-04-04 09:14:36', '2025-04-04 09:14:36'),
(6, 1, 'Finir le projet', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type a', '2025-04-03 21:03:22', '2025-04-03 21:30:26'),
(8, 1, 'Faire une lettre de motivation', 'de', '2025-04-04 09:58:45', '2025-04-04 09:58:45'),
(9, 1, 'Faire un CV\r\n', 'de', '2025-04-04 10:01:33', '2025-04-04 10:01:33'),
(10, 1, 'Télécharger le logiciel', 'de', '2025-04-04 10:02:23', '2025-04-04 10:02:23'),
(11, 1, 'test 2 partage', 'test', '2025-04-04 10:03:13', '2025-04-04 10:03:13'),
(12, 1, 'Appeler maman', 'test', '2025-04-04 10:05:07', '2025-04-06 01:25:44'),
(13, 1, 'Prendre Burger King', 'test', '2025-04-04 12:20:56', '2025-04-06 01:25:33'),
(14, 1, 'Acheter une pizza', 'test', '2025-04-04 12:21:23', '2025-04-06 01:25:19'),
(15, 1, 'Ranger l\'appartement', 'test', '2025-04-04 12:22:21', '2025-04-06 01:24:57'),
(16, 1, 'Poser jour de congé', 'test', '2025-04-04 12:23:27', '2025-04-06 01:24:33'),
(17, 1, 'Planification vacances', 'test', '2025-04-04 12:29:40', '2025-04-06 01:24:21'),
(18, 1, 'Livre le livre', 'test', '2025-04-04 12:30:16', '2025-04-06 01:24:04'),
(19, 2, 'Récupérer le colis', ',', '2025-04-04 12:34:00', '2025-04-06 01:23:49'),
(20, 1, 'Acheter livre', 'rest', '2025-04-04 12:36:44', '2025-04-06 01:23:37'),
(21, 1, 'Terminer nettoyage données', 'Lorem Ipsum is simply dummy text of the printing a...', '2025-04-04 12:37:04', '2025-04-06 01:42:25'),
(22, 1, 'Faire le ménage', 'Katia va faire le ménage', '2025-04-04 12:37:46', '2025-04-07 12:59:25');

-- --------------------------------------------------------

--
-- Structure de la table `post_it_partage`
--

DROP TABLE IF EXISTS `post_it_partage`;
CREATE TABLE IF NOT EXISTS `post_it_partage` (
  `id_post_it` int(11) NOT NULL,
  `id_user_partage` int(11) NOT NULL,
  PRIMARY KEY (`id_post_it`,`id_user_partage`),
  KEY `fk_partage_utilisateur` (`id_user_partage`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post_it_partage`
--

INSERT INTO `post_it_partage` (`id_post_it`, `id_user_partage`) VALUES
(1, 6),
(3, 3),
(19, 1),
(22, 2),
(22, 3),
(22, 28);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `pseudo` varchar(255) DEFAULT NULL,
  `date_naiss` date DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `email`, `password`, `nom`, `prenom`, `pseudo`, `date_naiss`) VALUES
(1, 'test@test.com', '1a15f35c518255b94fa9ed88e5ff65332b0d7796', 'Grant', 'Oliver', 'oliver_grt', '2025-03-12'),
(2, 'katia.b@gmail.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Belhadi', 'Katia', 'katou', '2000-07-16'),
(3, 'jean.dupont1@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Jean', 'jeand1', '1990-05-15'),
(4, 'jean.dupont2@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Jean', 'jeand2', '1992-07-20'),
(5, 'jeanne.dupont@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Jeanne', 'jeanneD', '1995-09-30'),
(6, 'jean.dupond@example.com', 'pass123', 'Dupond', 'Jean', 'jean_dupond', '1991-11-10'),
(7, 'jeanne.dupond@example.com', 'pass123', 'Dupond', 'Jeanne', 'jeanne_dupond', '1993-03-25'),
(8, 'john.dupont@example.com', 'pass123', 'Dupont', 'John', 'johnD', '1988-04-05'),
(9, 'jonathan.dupont@example.com', 'pass123', 'Dupont', 'Jonathan', 'jonathanD', '1997-06-18'),
(10, 'jean.dupuis@example.com', 'pass123', 'Dupuis', 'Jean', 'jeanDupuis', '1994-12-22'),
(11, 'jeanne.dupuis@example.com', 'pass123', 'Dupuis', 'Jeanne', 'jeanneDupuis', '1998-08-14'),
(12, 'jean-michel.dupont@example.com', 'pass123', 'Dupont', 'Jean-Michel', 'jmDupont', '1985-10-02'),
(13, 'alice.dupont@example.com', 'azerty123', 'Dupont', 'Alice', 'AliciaD', '1995-06-15'),
(14, 'benjamin.martin@example.com', 'securepass1', 'Martin', 'Benjamin', 'BenjiM', '1998-11-22'),
(15, 'caroline.lefevre@example.com', 'pass1234', 'Lefevre', 'Caroline', 'CaroL', '2000-02-10'),
(16, 'david.moreau@example.com', 'mypassword', 'Moreau', 'David', 'DaveM', '1993-07-08'),
(17, 'emilie.bernard@example.com', 'testpass', 'Bernard', 'Emilie', 'EmyB', '1997-12-30'),
(18, 'francois.roux@example.com', 'rouxpass99', 'Roux', 'François', 'FrancoR', '1999-09-17'),
(19, 'gabrielle.fournier@example.com', 'gabi1234', 'Fournier', 'Gabrielle', 'GabiF', '1992-03-05'),
(20, 'hugo.durand@example.com', 'durand789', 'Durand', 'Hugo', 'HugoD', '1996-08-12'),
(21, 'isabelle.lemaitre@example.com', 'lemaitre2023', 'Lemaitre', 'Isabelle', 'IsaL', '1994-04-28'),
(22, 'julien.perrin@example.com', 'perrinpass', 'Perrin', 'Julien', 'JulienP', '1991-05-20'),
(23, 'karine.blanc@example.com', 'blancsecure', 'Blanc', 'Karine', 'KariB', '2001-10-07'),
(24, 'lucas.girard@example.com', 'lucaspass', 'Girard', 'Lucas', 'LucaG', '1990-06-01'),
(25, 'marie.dumas@example.com', 'dumas2022', 'Dumas', 'Marie', 'MarieD', '1995-09-14'),
(26, 'nicolas.rey@example.com', 'nicolaspass', 'Rey', 'Nicolas', 'NicoR', '1993-11-25'),
(27, 'olivia.dupuy@example.com', 'dupuyolivia', 'Dupuy', 'Olivia', 'OliveD', '1998-07-19'),
(28, 'paul.fontaine@example.com', 'fontaine007', 'Fontaine', 'Paul', 'PaulF', '1997-01-30'),
(29, 'quentin.dupuis@example.com', 'dupuisQ', 'Dupuis', 'Quentin', 'QDup', '1992-02-14'),
(30, 'raphaelle.martinez@example.com', 'martinezR', 'Martinez', 'Raphaëlle', 'RaphM', '1999-03-22'),
(31, 'sophie.legendre@example.com', 'legendrepass', 'Legendre', 'Sophie', 'SosoL', '2000-05-18'),
(32, 'thomas.vidal@example.com', 'vidalthomas', 'Vidal', 'Thomas', 'TomV', '1996-12-09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
