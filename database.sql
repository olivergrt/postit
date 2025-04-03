-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 03 avr. 2025 à 19:30
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
  `date_creation` datetime NOT NULL,
  `date_modification` datetime DEFAULT NULL,
  PRIMARY KEY (`id_post_it`),
  KEY `fk_post_it_utilisateur` (`id_proprietaire`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
