-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : Dim 04 mai 2025 à 17:40
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
  `couleur` enum('orange','rouge','vert','bleu','jaune','rose') DEFAULT 'jaune',
  PRIMARY KEY (`id_post_it`),
  KEY `fk_post_it_utilisateur` (`id_proprietaire`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post_it`
--

INSERT INTO `post_it` (`id_post_it`, `id_proprietaire`, `titre`, `contenu`, `date_creation`, `date_modification`, `couleur`) VALUES
(3, 1, 'Faire les courses', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book', '2025-03-15 16:30:51', '2025-04-06 00:55:44', 'jaune'),
(6, 1, 'Finir le projet', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type a', '2025-04-03 21:03:22', '2025-04-03 21:30:26', 'jaune'),
(14, 1, 'Acheter une pizza', 'test', '2025-04-04 12:21:23', '2025-04-06 01:25:19', 'jaune'),
(17, 1, 'Planification vacances', 'test', '2025-04-04 12:29:40', '2025-04-06 01:24:21', 'jaune'),
(19, 2, 'Récupérer le colis', 'Récupérer le colis à la Poste', '2025-04-04 12:34:00', '2025-04-23 17:06:35', 'jaune'),
(20, 1, 'Acheter livre', 'rest', '2025-04-04 12:36:44', '2025-04-06 01:23:37', 'jaune'),
(22, 1, 'Faire le ménage', 'Jean et Paul vont faire le ménage.', '2025-04-04 12:37:46', '2025-05-04 17:35:34', 'jaune'),
(24, 1, 'Terminer projet TER', 'Terminer le code du projet.', '2025-04-23 15:33:07', '2025-05-01 17:10:44', 'jaune'),
(27, 1, 'test', 'test', '2025-04-30 12:36:27', '2025-05-01 17:10:52', 'jaune'),
(26, 2, 'Tondre la pelouse', 'Tondre la pelouse du jardin.', '2025-04-23 17:08:22', '2025-04-23 17:08:22', 'jaune'),
(25, 2, 'Acheter un barbecue', 'Aller acheter un barbecue à LeroyMerlin', '2025-04-23 17:07:57', '2025-04-23 17:07:57', 'jaune'),
(33, 1, 'test', 'test', '2025-05-02 14:13:09', '2025-05-02 14:13:09', 'bleu'),
(34, 39, 'Aller à action', 'Aller installer la box WIFI et acheter une vitre ', '2025-05-03 14:09:58', '2025-05-03 14:09:58', 'bleu'),
(35, 40, 'Reviser bac de Français', 'Revision de tous les chapitres vu en cours au lycée Talma ', '2025-05-03 16:28:43', '2025-05-03 16:29:48', 'bleu'),
(36, 1, 'Acheter un barbecue', 'test', '2025-05-03 16:30:24', '2025-05-04 16:53:49', 'orange');

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
(19, 3),
(19, 15),
(19, 30),
(22, 3),
(22, 28),
(23, 1),
(24, 1),
(24, 2),
(24, 33),
(24, 34),
(25, 1),
(26, 1),
(26, 30),
(27, 2),
(29, 14),
(34, 1),
(35, 9),
(35, 39);

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
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `email`, `password`, `nom`, `prenom`, `pseudo`, `date_naiss`) VALUES
(1, 'oliver@test.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Grant', 'Oliver', 'olivergrt', '2025-03-12'),
(2, 'katia@test.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Belhadi', 'Katia', 'katou', '2000-07-16'),
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
(32, 'thomas.vidal@example.com', 'vidalthomas', 'Vidal', 'Thomas', 'TomV', '1996-12-09'),
(33, 'yanis@test.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Aggoun', 'Yanis', 'aggouny1', '2025-04-01'),
(34, 'leti@test.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Feti', 'Letissia', 'letissiaFeti', '2025-04-16'),
(35, 'zef@ezf.com', '$2y$10$BvJ7EKuCswqartQOTJdk6eBrxVf8WPuhsjm1G2rlzY/DJq75euJom', 'erg', 'errz', 'rgze', '2025-05-07'),
(36, 'egz@ezgvlk.com', '$2y$10$N.kiicgL/emhOGbO74fEz./KwVm.2feJKuofyOplWQONwo6wNODbC', 'zef', 'zfe', 'oliver_grt', '2025-05-16'),
(37, 'ertg@tyyjd.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'gre', 'ezf', 'gre', '2025-05-15'),
(39, 'cam@grt.fr', '4e5b7b55052bdd41a170c734055ed86b8d3af265', 'Grant', 'Cameron', 'cam_grt', '2002-02-06'),
(40, 'kieran@grt.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Grant', 'Kieran', 'kierangrt', '2008-11-21');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
