-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 06 avr. 2025 à 01:34
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
(19, 1, 'Récupérer le colis', ',', '2025-04-04 12:34:00', '2025-04-06 01:23:49'),
(20, 1, 'Acheter livre', 'rest', '2025-04-04 12:36:44', '2025-04-06 01:23:37'),
(21, 1, 'Terminé nettoyage données', 'Lorem Ipsum is simply dummy text of the printing a...', '2025-04-04 12:37:04', '2025-04-06 01:23:22'),
(22, 1, 'Faire le ménage', 'Lorem Ipsum is simply dummy text of the printing a...', '2025-04-04 12:37:46', '2025-04-06 01:22:43');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
