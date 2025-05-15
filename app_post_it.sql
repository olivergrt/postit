-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 15 mai 2025 à 18:38
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
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post_it`
--

INSERT INTO `post_it` (`id_post_it`, `id_proprietaire`, `titre`, `contenu`, `date_creation`, `date_modification`, `couleur`) VALUES
(3, 1, 'Faire les courses', '', '2025-03-15 16:30:51', '2025-04-06 00:55:44', 'jaune'),
(42, 1, 'test yanis', 'test', '2025-05-14 14:17:59', '2025-05-14 15:22:16', 'rouge'),
(6, 1, 'Finir le projet', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type a', '2025-04-03 21:03:22', '2025-04-03 21:30:26', 'jaune'),
(14, 1, 'Acheter une pizza', 'test', '2025-04-04 12:21:23', '2025-04-06 01:25:19', 'jaune'),
(17, 1, 'Planification vacances', 'test', '2025-04-04 12:29:40', '2025-04-06 01:24:21', 'jaune'),
(19, 2, 'Récupérer le colis', 'Récupérer le colis à la Poste', '2025-04-04 12:34:00', '2025-04-23 17:06:35', 'jaune'),
(20, 1, 'Acheter livre', 'rest', '2025-04-04 12:36:44', '2025-04-06 01:23:37', 'jaune'),
(22, 1, 'Faire le ménage', 'Jean et Paul vont faire le ménage.', '2025-04-04 12:37:46', '2025-05-13 19:23:39', 'vert'),
(24, 1, 'Terminer projet TER', ' d', '2025-04-23 15:33:07', '2025-05-13 23:00:02', 'orange'),
(40, 1, 'test', 'esde', '2025-05-12 19:57:32', '2025-05-13 19:23:30', 'rouge'),
(26, 2, 'Tondre la pelouse', 'Tondre la pelouse du jardin.', '2025-04-23 17:08:22', '2025-04-23 17:08:22', 'jaune'),
(25, 2, 'Acheter un barbecue', 'Aller acheter un barbecue à LeroyMerlin', '2025-04-23 17:07:57', '2025-04-23 17:07:57', 'jaune'),
(34, 39, 'Aller à action', 'Aller installer la box WIFI et acheter une vitre ', '2025-05-03 14:09:58', '2025-05-03 14:09:58', 'bleu'),
(35, 40, 'Reviser bac de Français', 'Revision de tous les chapitres vu en cours au lycée Talma ', '2025-05-03 16:28:43', '2025-05-03 16:29:48', 'bleu'),
(36, 1, 'Acheter un barbecue', 'test heure de paris', '2025-05-03 16:30:24', '2025-05-13 20:31:26', 'rose');

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
(0, 19),
(3, 3),
(19, 1),
(19, 3),
(19, 15),
(19, 30),
(22, 3),
(22, 28),
(24, 1),
(24, 2),
(24, 33),
(24, 34),
(25, 1),
(26, 1),
(26, 30),
(34, 1),
(35, 9),
(35, 39),
(42, 2),
(42, 15);

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
  `remember_token` varchar(255) DEFAULT NULL,
  `token_expire` datetime DEFAULT NULL,
  `remember_ip` varchar(45) DEFAULT NULL,
  `remember_user_agent` text,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `email`, `password`, `nom`, `prenom`, `pseudo`, `date_naiss`, `remember_token`, `token_expire`, `remember_ip`, `remember_user_agent`) VALUES
(1, 'oliver@test.fr', '$argon2id$v=19$m=65536,t=4,p=1$bk1ycEJma0dPbk85bmNrLg$v979whBh5qqN3+kCTzZk/O88qdnX2PEY8iNrdr/WEWU', 'Grant', 'Oliver', 'olivergrt', '2025-03-12', NULL, NULL, NULL, NULL),
(2, 'katia@test.fr', '$argon2id$v=19$m=65536,t=4,p=1$bk1ycEJma0dPbk85bmNrLg$v979whBh5qqN3+kCTzZk/O88qdnX2PEY8iNrdr/WEWU', 'Belhadi', 'Katia', 'katou', '2000-07-16', NULL, NULL, NULL, NULL),
(3, 'jean.dupont1@example.com', '$argon2id$v=19$m=65536,t=4,p=1$bk1ycEJma0dPbk85bmNrLg$v979whBh5qqN3+kCTzZk/O88qdnX2PEY8iNrdr/WEWU', 'Dupont', 'Jean', 'jeand1', '1990-05-15', NULL, NULL, NULL, NULL),
(4, 'jean.dupont2@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Jean', 'jeand2', '1992-07-20', NULL, NULL, NULL, NULL),
(5, 'jeanne.dupont@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Jeanne', 'jeanneD', '1995-09-30', NULL, NULL, NULL, NULL),
(6, 'jean.dupond@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupond', 'Jean', 'jean_dupond', '1991-11-10', NULL, NULL, NULL, NULL),
(7, 'jeanne.dupond@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupond', 'Jeanne', 'jeanne_dupond', '1993-03-25', NULL, NULL, NULL, NULL),
(8, 'john.dupont@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'John', 'johnD', '1988-04-05', NULL, NULL, NULL, NULL),
(9, 'jonathan.dupont@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Jonathan', 'jonathanD', '1997-06-18', NULL, NULL, NULL, NULL),
(10, 'jean.dupuis@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupuis', 'Jean', 'jeanDupuis', '1994-12-22', NULL, NULL, NULL, NULL),
(11, 'jeanne.dupuis@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupuis', 'Jeanne', 'jeanneDupuis', '1998-08-14', NULL, NULL, NULL, NULL),
(12, 'jean-michel.dupont@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Jean-Michel', 'jmDupont', '1985-10-02', NULL, NULL, NULL, NULL),
(13, 'alice.dupont@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Alice', 'AliciaD', '1995-06-15', NULL, NULL, NULL, NULL),
(14, 'benjamin.martin@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Martin', 'Benjamin', 'BenjiM', '1998-11-22', NULL, NULL, NULL, NULL),
(15, 'caroline.lefevre@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Lefevre', 'Caroline', 'CaroL', '2000-02-10', NULL, NULL, NULL, NULL),
(16, 'david.moreau@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Moreau', 'David', 'DaveM', '1993-07-08', NULL, NULL, NULL, NULL),
(17, 'emilie.bernard@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Bernard', 'Emilie', 'EmyB', '1997-12-30', NULL, NULL, NULL, NULL),
(18, 'francois.roux@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Roux', 'François', 'FrancoR', '1999-09-17', NULL, NULL, NULL, NULL),
(19, 'gabrielle.fournier@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Fournier', 'Gabrielle', 'GabiF', '1992-03-05', NULL, NULL, NULL, NULL),
(20, 'hugo.durand@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Durand', 'Hugo', 'HugoD', '1996-08-12', NULL, NULL, NULL, NULL),
(21, 'isabelle.lemaitre@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Lemaitre', 'Isabelle', 'IsaL', '1994-04-28', NULL, NULL, NULL, NULL),
(22, 'julien.perrin@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Perrin', 'Julien', 'JulienP', '1991-05-20', NULL, NULL, NULL, NULL),
(23, 'karine.blanc@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Blanc', 'Karine', 'KariB', '2001-10-07', NULL, NULL, NULL, NULL),
(24, 'lucas.girard@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Girard', 'Lucas', 'LucaG', '1990-06-01', NULL, NULL, NULL, NULL),
(25, 'marie.dumas@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dumas', 'Marie', 'MarieD', '1995-09-14', NULL, NULL, NULL, NULL),
(26, 'nicolas.rey@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Rey', 'Nicolas', 'NicoR', '1993-11-25', NULL, NULL, NULL, NULL),
(27, 'olivia.dupuy@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupuy', 'Olivia', 'OliveD', '1998-07-19', NULL, NULL, NULL, NULL),
(28, 'paul.fontaine@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Fontaine', 'Paul', 'PaulF', '1997-01-30', NULL, NULL, NULL, NULL),
(29, 'quentin.dupuis@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupuis', 'Quentin', 'QDup', '1992-02-14', NULL, NULL, NULL, NULL),
(30, 'raphaelle.martinez@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Martinez', 'Raphaëlle', 'RaphM', '1999-03-22', NULL, NULL, NULL, NULL),
(31, 'sophie.legendre@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Legendre', 'Sophie', 'SosoL', '2000-05-18', NULL, NULL, NULL, NULL),
(32, 'thomas.vidal@example.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Vidal', 'Thomas', 'TomV', '1996-12-09', NULL, NULL, NULL, NULL),
(33, 'yanis@test.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Aggoun', 'Yanis', 'aggouny1', '2025-04-01', NULL, NULL, NULL, NULL),
(34, 'leti@test.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Feti', 'Letissia', 'letissiaFeti', '2025-04-16', NULL, NULL, NULL, NULL),
(35, 'zef@ezf.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'erg', 'errz', 'rgze', '2025-05-07', NULL, NULL, NULL, NULL),
(36, 'egz@ezgvlk.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'zef', 'zfe', 'oliver_grt', '2025-05-16', NULL, NULL, NULL, NULL),
(37, 'ertg@tyyjd.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'gre', 'ezf', 'gre', '2025-05-15', NULL, NULL, NULL, NULL),
(39, 'cam@grt.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Grant', 'Cameron', 'cam_grt', '2002-02-06', NULL, NULL, NULL, NULL),
(40, 'kieran@grt.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Grant', 'Kieran', 'kierangrt', '2008-11-21', NULL, NULL, NULL, NULL),
(41, 'olivier@dupont.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'Dupont', 'Olivier', 'olivier_dpt', '2024-06-17', NULL, NULL, NULL, NULL),
(42, 'testt@eubz.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'testt', 'testttt', 'testtttt', '2000-02-02', NULL, NULL, NULL, NULL),
(43, 'fezg@ezj.fr', '320098128710a6a199a2354267a2f7fed2fa3675', 'zef', 'rfze', 'egz', '2008-11-16', NULL, NULL, NULL, NULL),
(44, 'testt@eubz.comd', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'refez', 'ter', 'zef', '2008-12-18', NULL, NULL, NULL, NULL),
(45, 'zafe@fzejh.fr', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'fez', 'erf', 'oliver_grtd', '1994-03-15', NULL, NULL, NULL, NULL),
(46, 'test@yesy.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'test', 'test', 'test', '2019-05-05', NULL, NULL, NULL, NULL),
(47, 'test@test.com', '58ad983135fe15c5a8e2e15fb5b501aedcf70dc2', 'tes', 'test', 'tests', '2021-05-04', NULL, NULL, NULL, NULL),
(48, 'testoooo@gmail.com', '$argon2id$v=19$m=65536,t=4,p=1$bk1ycEJma0dPbk85bmNrLg$v979whBh5qqN3+kCTzZk/O88qdnX2PEY8iNrdr/WEWU', 'testoooo', 'testoooo', 'testoooo', '2011-08-14', NULL, NULL, NULL, NULL),
(49, 'zda@zeajkq.fr', '$argon2id$v=19$m=65536,t=4,p=1$L0tsSTBxMVFmZTU1VkdlUA$KbZmleTmE5BDQBiUNfAtihxQYVqjdJCbNQh5QmsmppQ', 'dza', 'ez', 'dza', '2010-06-16', NULL, NULL, NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
