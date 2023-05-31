-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 31 mai 2023 à 23:10
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `library_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(0, 'test123', 'test123');

-- --------------------------------------------------------

--
-- Structure de la table `borrows`
--

DROP TABLE IF EXISTS `borrows`;
CREATE TABLE IF NOT EXISTS `borrows` (
  `user_id` int NOT NULL,
  `doc_id` int NOT NULL,
  `borrow_code` varchar(32) NOT NULL,
  `borrow_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `return_date` timestamp NOT NULL,
  `status` varchar(30) DEFAULT NULL,
  `receipt_file` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`borrow_code`),
  UNIQUE KEY `borrow_code` (`borrow_code`),
  KEY `doc_id` (`doc_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `borrows`
--

INSERT INTO `borrows` (`user_id`, `doc_id`, `borrow_code`, `borrow_date`, `return_date`, `status`, `receipt_file`) VALUES
(21, 29, '131313', '2023-05-28 11:11:01', '2023-05-31 20:31:34', 'en cours', NULL),
(21, 42, '64747736b1854', '2023-05-28 23:00:00', '2023-05-19 20:17:20', 'retourne', 'http://localhost/management-of-library/public/assets/receipts/recu_64747736b1854.pdf'),
(21, 41, '64747785d3099', '2023-05-28 23:00:00', '2023-06-18 23:00:00', 'retourne', 'http://localhost/management-of-library/public/assets/receipts/recu_64747785d3099.pdf'),
(21, 42, '6474bb40b76ce', '2023-05-28 23:00:00', '2023-06-18 23:00:00', 'retourne', 'http://localhost/management-of-library/public/assets/receipts/recu_6474bb40b76ce.pdf'),
(21, 29, '64752bc718878', '2023-05-28 23:00:00', '2023-06-18 23:00:00', 'retourne', 'http://localhost/management-of-library/public/assets/receipts/recu_64752bc718878.pdf'),
(22, 29, '4646FGFFGFG', '2023-05-31 20:12:02', '2023-06-21 20:12:02', 'retourne', NULL),
(23, 42, '6477ce1daa371', '2023-05-30 23:00:00', '2023-06-20 23:00:00', 'refuse', 'http://localhost/management-of-library/public/assets/receipts/recu_6477ce1daa371.pdf'),
(23, 41, '6477d006b1d84', '2023-05-30 23:00:00', '2023-06-20 23:00:00', 'en cours', 'http://localhost/management-of-library/public/assets/receipts/recu_6477d006b1d84.pdf');

--
-- Déclencheurs `borrows`
--
DROP TRIGGER IF EXISTS `borrows_update`;
DELIMITER $$
CREATE TRIGGER `borrows_update` AFTER UPDATE ON `borrows` FOR EACH ROW BEGIN
	if(new.status = 'retourne')
    THEN
    UPDATE documents SET copies_left=copies_left+1
    WHERE id=old.doc_id;
    UPDATE users SET borrows_left=borrows_left+1
    WHERE id=old.user_id;
    END if;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trig_borrows_insert`;
DELIMITER $$
CREATE TRIGGER `trig_borrows_insert` AFTER INSERT ON `borrows` FOR EACH ROW BEGIN
 UPDATE users set borrows_left = borrows_left - 1 WHERE id = new.user_id;
 UPDATE documents set copies_left = copies_left - 1 WHERE id = new.doc_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `branches`
--

DROP TABLE IF EXISTS `branches`;
CREATE TABLE IF NOT EXISTS `branches` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `branches`
--

INSERT INTO `branches` (`id`, `name`, `created_at`) VALUES
(19, 'informatique', '2023-05-26 18:56:03'),
(22, 'economie', '2023-05-26 18:56:07');

-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

DROP TABLE IF EXISTS `documents`;
CREATE TABLE IF NOT EXISTS `documents` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `doc_desc` text NOT NULL,
  `author` varchar(150) NOT NULL,
  `page_count` int NOT NULL,
  `doc_img` varchar(150) DEFAULT NULL,
  `copies_left` int NOT NULL,
  `type_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `category_id` (`category_id`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `documents`
--

INSERT INTO `documents` (`id`, `title`, `doc_desc`, `author`, `page_count`, `doc_img`, `copies_left`, `type_id`, `category_id`, `created_at`) VALUES
(29, 'Hello brother', 'Marhba bikom', 'brahim taza', 46, '6473da1e01089.jpg', 0, 0, 0, '2023-05-27 23:28:01'),
(42, 'rich dad poor dad', 'heelsosdsd', 'robert kiyosaki', 36, '6474752f93b13.jpg', 12, 43, 20, '2023-05-29 09:49:35'),
(41, 'TETETE', 'SDSDSD', 'SDSD', 5656, '6473dc590776e.jpg', 353, 41, 19, '2023-05-28 14:10:44');

-- --------------------------------------------------------

--
-- Structure de la table `doc_categories`
--

DROP TABLE IF EXISTS `doc_categories`;
CREATE TABLE IF NOT EXISTS `doc_categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `doc_categories`
--

INSERT INTO `doc_categories` (`id`, `name`, `created_at`) VALUES
(20, 'Business', '2023-05-27 20:22:43'),
(19, 'Tech', '2023-05-27 20:22:37'),
(21, 'Health', '2023-05-27 20:22:50');

-- --------------------------------------------------------

--
-- Structure de la table `doc_types`
--

DROP TABLE IF EXISTS `doc_types`;
CREATE TABLE IF NOT EXISTS `doc_types` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `doc_types`
--

INSERT INTO `doc_types` (`id`, `name`, `created_at`) VALUES
(42, 'Article', '2023-05-27 20:22:23'),
(43, 'Livre', '2023-05-27 20:22:29'),
(41, 'Periodique', '2023-05-27 20:22:16');

-- --------------------------------------------------------

--
-- Structure de la table `return_doc_alert`
--

DROP TABLE IF EXISTS `return_doc_alert`;
CREATE TABLE IF NOT EXISTS `return_doc_alert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `borrow_code` varchar(32) NOT NULL,
  `alert_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `borrow_code` (`borrow_code`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `return_doc_alert`
--

INSERT INTO `return_doc_alert` (`id`, `borrow_code`, `alert_date`) VALUES
(1, '64747736b1854', '2023-05-30 08:22:50'),
(2, '131313', '2023-05-30 08:32:49'),
(3, '6474bb40b76ce', '2023-05-30 15:30:36'),
(4, '6474bb40b76ce', '2023-05-30 15:58:48'),
(5, '64747736b1854', '2023-05-30 20:19:44'),
(6, '64747736b1854', '2023-05-31 18:01:04');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `branch_id` int DEFAULT NULL,
  `borrows_left` int NOT NULL,
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `phone_number` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `branch_id` (`branch_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `branch_id`, `borrows_left`, `password`, `phone_number`, `created_at`) VALUES
(21, 'TATA tata', 'ajaraiboringsignupmail@gmail.com', 22, 4, '$2y$10$4WkuqKcr8A1b2CuQoz2aWeupgPgePQITgMu1BWjmbBDHP5FlsHLb2', '0649048466', '2023-05-28 11:07:23'),
(23, 'bola bola', 'hola@gmail.com', NULL, 1, '$2y$10$ZhcEd67UWs7qJyI0ElbPJ.hE/qIomaFyyt9wm7AlzEWIuca.IokPy', '0745365756', '2023-05-29 08:34:48');

DELIMITER $$
--
-- Évènements
--
DROP EVENT IF EXISTS `check_not_returned_docs_evt`$$
CREATE DEFINER=`root`@`localhost` EVENT `check_not_returned_docs_evt` ON SCHEDULE EVERY 1 MINUTE STARTS '2023-05-30 21:14:39' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
UPDATE borrows SET status='non retourne'
WHERE status='active' AND DATEDIFF(CURRENT_DATE(), return_date) > 0;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
