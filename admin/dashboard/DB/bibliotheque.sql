-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 08:10 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bibliotheque`
--

-- --------------------------------------------------------

--
-- Table structure for table `adherent`
--

CREATE TABLE `adherent` (
  `id` int(11) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(30) NOT NULL,
  `branch` varchar(100) NOT NULL,
  `phone_number` varchar(10) NOT NULL -- here we used just moroccan phone numbers, you could customize it on your own.
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adherent`
--

INSERT INTO `adherent` (`id_adh`, `nom_complet`, `email`, `password`, `filiere`, `tele`) VALUES
(1, 'aymane elhamraoui', 'aymane.studies@gmail.com', '$2y$10$3A4pXQS.q57a/98z67jz4.znzq0p/jyqdCKIu/ZaQ00j.RrfZcnaG', 'gi', '066654'),
(2, 'aymane', 'ayla@gi.com', '$2y$10$/4ztxtK57M1sWTd8KnIJD.2aJyOuh3xcVM0gFuwbsWscum1vPBMgG', 'dd', '0666'),
(3, 'dddddddddddd', 'bb@hh.com', '$2y$10$zpzryjxewCyOGHAftPiqdOjQpjF1QQqEFhXB3p1KPEwAkwITtTtK2', 'ddd', '555252'),
(4, 'kamal', 'aymane@kk.com', '$2y$10$4vWaJWQmPk60r.6DwYZolushbUcdgcELtsM4km85JeaFx8kgJP6Ta', 'gi', '06252828'),
(5, 'll', 'aymane@ll.com', '$2y$10$GzXPNjSlQ1G3mvFRDVDSleciGcYq9zbyJ.AauGxoBWNyvtJM7IKdW', 'kl', '06666'),
(6, 'ajarai ayoub', 'ajaraiayoub@gmail.com', '$2y$10$h15t.CTXQkzcLp5Dc2AxOuTHSwjUZJ6SaOEWkZtrPHQAnUdBw0nuu', 'gi', '06658285'),
(7, 'aymanecom', 'aymane.mltr@gmail.com', '$2y$10$l/73PulzDAALfGXsIlJD/ulazKmSFlr4IGaEhBbhbzUCFNt6Sm2Em', 'gi', '0666'),
(8, 'kk', 'beki@lm.com', '$2y$10$v.7lVAtN03EGDehbgUR9ju9euXGwSTER5Skn1SYnxtMpvMzeGtZZu', 'gi', '0613352230'),
(9, 'watch', 'aymaneml@gmail.com', '$2y$10$FFj4jFKWUnW31bWZDeU12enT/grMJ8Zd1gfaO1ddZPiKkEn1zFXGi', 'ge', '0613352230'),
(10, 'achraf', 'bb@ll.com', '$2y$10$wvoxnS./MD8FIIOsaj4V4e4Y6gSJ4yNc.oarSEZYYyz1isVevWbI2', 'GI', '0613352230');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'aymane', '$2y$10$94PaQ56cl398fV/rs7v0NuKEsBp0YxrKDnNErN1l3xmZkJt5TO3Sa'),
(2, 'kamal', '$2y$10$Yjd2TD4/dPrRrbygZnXqN.MFaoyJ5QnyWiGjoi4jZJfnWDPeFiTwa'),
(3, 'ayoub', '$2y$10$NIY1C2j1CMYb8hcC9kvGcu1vGjQQp7O7c7SzA59v7G3AoBuVEOj/m');

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `auteur` varchar(50) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `qte` int(11) NOT NULL,
  `descript` varchar(200) NOT NULL,
  `doc_img` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `document`
--

INSERT INTO `document` (`id_doc`, `nom_type`, `auteur`, `titre`, `qte`, `descript`, `doc_img`) VALUES
(12, '1', 'kamal', 'rtyu', 7, 'k', './Documents/'),
(13, '1', 'kamal', 'rtyu', 1, 'rtyui', './Documents/840430.jpg'),
(14, '1', 'rtyui', 'kamaml', 1, 'lamal', './Documents/'),
(15, '1', 'uio', 'yui', 5, '', './Documents/photo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `emprunt`
--

CREATE TABLE `emprunt` (
  `id_emp` int(11) NOT NULL,
  `id_adh` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `is_confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `is_returned` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emprunt`
--

INSERT INTO `emprunt` (`id_emp`, `id_adh`, `id_doc`, `is_confirmed`, `is_returned`) VALUES
(2, 1, 12, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `examplaire`
--

CREATE TABLE `examplaire` (
  `id_exm` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `historique`
--

CREATE TABLE `historique` (
  `id_history` int(11) NOT NULL,
  `id_emp` int(11) NOT NULL,
  `id_adh` int(11) NOT NULL,
  `id_doc` int(11) NOT NULL,
  `borrow_date` datetime NOT NULL,
  `return_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `historique`
--

INSERT INTO `historique` (`id_history`, `id_emp`, `id_adh`, `id_doc`, `borrow_date`, `return_date`) VALUES
(1, 2, 1, 12, '2023-05-22 18:20:44', '2023-05-22 18:25:48'),
(2, 2, 1, 12, '2023-05-22 18:22:52', '2023-05-22 18:25:48'),
(3, 2, 1, 12, '2023-05-22 18:24:29', '2023-05-22 18:25:48'),
(4, 2, 1, 12, '2023-05-22 18:25:08', '2023-05-22 18:25:48'),
(5, 2, 1, 12, '2023-05-22 18:25:36', '2023-05-22 18:25:48');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(11) NOT NULL,
  `nom_type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `nom_type`) VALUES
(1, 'article'),
(2, 'livre'),
(4, 'periodique');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adherent`
--
ALTER TABLE `adherent`
  ADD PRIMARY KEY (`id_adh`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id_doc`);

--
-- Indexes for table `emprunt`
--
ALTER TABLE `emprunt`
  ADD PRIMARY KEY (`id_emp`),
  ADD KEY `id_adh` (`id_adh`),
  ADD KEY `id_exm` (`id_doc`);

--
-- Indexes for table `examplaire`
--
ALTER TABLE `examplaire`
  ADD PRIMARY KEY (`id_exm`);

--
-- Indexes for table `historique`
--
ALTER TABLE `historique`
  ADD PRIMARY KEY (`id_history`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adherent`
--
ALTER TABLE `adherent`
  MODIFY `id_adh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `emprunt`
--
ALTER TABLE `emprunt`
  MODIFY `id_emp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `examplaire`
--
ALTER TABLE `examplaire`
  MODIFY `id_exm` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historique`
--
ALTER TABLE `historique`
  MODIFY `id_history` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `emprunt`
--
ALTER TABLE `emprunt`
  ADD CONSTRAINT `emprunt_ibfk_1` FOREIGN KEY (`id_adh`) REFERENCES `adherent` (`id_adh`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
