-- phpMyAdmin SQL Dump
-- version 4.5.4.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 18, 2018 at 11:45 PM
-- Server version: 5.7.11
-- PHP Version: 7.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fpfexpress`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `idCategorie` int(11) NOT NULL,
  `idCompte` int(11) NOT NULL,
  `nomCategorie` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`idCategorie`, `idCompte`, `nomCategorie`) VALUES
(1, 1, 'Resto'),
(2, 2, 'Gas'),
(4, 2, 'Vetements'),
(16, 2, 'Restaurants'),
(17, 2, 'Auto'),
(20, 2, 'Jeux'),
(21, 5, 'PC'),
(22, 2, 'Date'),
(25, 2, 'Essentiel'),
(26, 2, 'Cadeaux'),
(27, 2, 'Ã‰cole'),
(28, 2, 'Autre'),
(29, 2, 'Alcool'),
(30, 6, '1'),
(31, 6, '2'),
(32, 6, '3'),
(33, 6, 'test'),
(34, 6, 'test5'),
(35, 15, 'Restaurants'),
(36, 15, 'Ã‰picerie'),
(37, 15, 'Voiture'),
(38, 2, 'Gaterie'),
(41, 16, 'Restaurants'),
(42, 16, 'Ã‰picerie'),
(43, 16, 'Voiture'),
(44, 17, 'Restaurants'),
(45, 17, 'Ã‰picerie'),
(46, 17, 'Voiture');

-- --------------------------------------------------------

--
-- Table structure for table `compte`
--

CREATE TABLE `compte` (
  `idCompte` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `prenom` varchar(30) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `motDePasse` varchar(40) DEFAULT NULL,
  `background` varchar(6) NOT NULL DEFAULT 'theme1',
  `config` tinyint(1) NOT NULL DEFAULT '1',
  `idCategorieConfig` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `compte`
--

INSERT INTO `compte` (`idCompte`, `email`, `prenom`, `nom`, `motDePasse`, `background`, `config`, `idCategorieConfig`) VALUES
(2, 'mchausse', 'Maxime', 'ChaussÃ©', 'Admin123', 'theme4', 0, '2,4,16'),
(5, 'rchausse', 'Robert', 'ChaussÃ©', 'User123', 'theme1', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `depense`
--

CREATE TABLE `depense` (
  `idDepense` int(11) NOT NULL,
  `montantDepense` double(8,2) NOT NULL,
  `nomDepense` varchar(40) DEFAULT NULL,
  `recurenceDepense` varchar(3) DEFAULT NULL,
  `note` text,
  `remboursable` tinyint(1) DEFAULT NULL,
  `nomPersonne` varchar(50) DEFAULT NULL,
  `idCategorie` int(11) DEFAULT NULL,
  `idCompte` int(11) NOT NULL,
  `dateDepense` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `depense`
--

INSERT INTO `depense` (`idDepense`, `montantDepense`, `nomDepense`, `recurenceDepense`, `note`, `remboursable`, `nomPersonne`, `idCategorie`, `idCompte`, `dateDepense`) VALUES
(30, 50.00, 'Gas', '', 'A 1.25 au Shell a St-Sulpice', 0, '', 2, 2, '2018-03-31 04:00:00'),
(34, 123.00, 'qwe', '', 'qwe', 0, 'qwe', 2, 2, '2018-03-26 04:00:00'),
(41, 95.64, 'Assurance', 'men', '', 0, '', 17, 2, '2018-03-27 04:00:00'),
(45, 2.89, 'pie', '', '', 0, '', 16, 2, '2018-04-10 04:00:00'),
(54, 23.00, 'wegfgb', '', '2312312', 0, '', 2, 2, '2018-04-06 04:00:00'),
(61, 2500.00, 'PC', '', 'Alienware', 0, '', 21, 5, '2018-03-23 04:00:00'),
(62, 2500.00, 'PC', '', 'Alienware', 0, '', 21, 5, '2018-03-23 04:00:00'),
(70, 0.00, '123', '', 'Rembourser 213.00$ par 123.', 0, '', 2, 2, '2018-04-13 04:00:00'),
(74, 0.00, 'Poutine', '', 'Il etait une fois quand jai ete a lacole jeudi jai acheter une poutine a la coop de rosemont \n Rembourser 59.00$ par Papa.', 0, '', 16, 2, '2018-04-11 04:00:00'),
(78, 1200.00, 'Lit', '', '', 0, '', 25, 2, '2018-05-10 04:00:00'),
(79, 70.00, 'Speaker', '', 'Pour la fete a Papa', 0, '', 26, 2, '2018-05-04 04:00:00'),
(80, 8.50, 'Subway', '', '', 0, '', 16, 2, '2018-05-11 04:00:00'),
(81, 1.14, 'Barre de chocolat', '', '', 0, '', 16, 2, '2018-05-13 04:00:00'),
(82, 2.80, 'Frites', '', 'Au IGA', 0, '', 2, 2, '2018-05-12 04:00:00'),
(83, 12.83, 'Cadeau a maman', '', 'Sangria et fleurs', 0, '', 26, 2, '2018-05-13 04:00:00'),
(84, 28.49, 'Souper a Maman', '', 'Payer le souper a maman et le mien pour sa fete', 0, '', 26, 2, '2018-05-13 04:00:00'),
(85, 50.00, 'Gas', '', '', 0, '', 2, 2, '2018-05-12 04:00:00'),
(86, 5.00, 'Netflix', 'men', '', 1, 'Gabriel', 28, 2, '2018-05-17 04:00:00'),
(87, 5.00, 'Netflix', 'men', '', 1, 'Brendon', 28, 2, '2018-05-17 04:00:00'),
(88, 65.00, 'Cellulaire', 'men', '', 0, '', 25, 2, '2018-05-10 04:00:00'),
(89, 240.90, 'Mazda 3', 'men', '', 0, '', 17, 2, '2018-05-24 04:00:00'),
(90, 2.29, 'Bonbon', '', '', 0, '', 16, 2, '2018-05-11 04:00:00'),
(91, 20.70, 'Liqueur au caramel', '', '', 0, '', 29, 2, '2018-05-10 04:00:00'),
(92, 85.22, 'Articles de lit', '', '', 0, '', 25, 2, '2018-05-10 04:00:00'),
(93, 43.84, 'Taasty thai', '', '', 0, '', 22, 2, '2018-05-05 04:00:00'),
(94, 7.92, 'Tim horton', '', '', 0, '', 16, 2, '2018-05-16 04:00:00'),
(95, 53.08, 'Gas', '', '', 0, '', 2, 2, '2018-05-18 04:00:00'),
(96, 24.00, 'sdafsdf', 'quo', '      <script type="javascript"> window.location="http://www.tutorialspoint.com";</script>', 0, '', 43, 16, '2018-05-14 04:00:00'),
(97, 2.50, 'McDo/McFleury', '', '', 0, '', 38, 2, '2018-05-17 04:00:00'),
(98, 12.00, '1312e', '', 'e12e', 0, '', 44, 17, '2018-05-07 04:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

CREATE TABLE `revenue` (
  `idRevenue` int(11) NOT NULL,
  `montantRevenue` double(8,2) DEFAULT NULL,
  `nomRevenue` varchar(30) DEFAULT NULL,
  `recurenceRevenue` varchar(3) DEFAULT NULL,
  `idCompte` int(11) NOT NULL,
  `date` datetime(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`idRevenue`, `montantRevenue`, `nomRevenue`, `recurenceRevenue`, `idCompte`, `date`) VALUES
(30, 500.00, 'Telus', 'heb', 5, '2018-04-19 00:00:00.000000'),
(31, 166.31, 'IGA', '', 2, '2018-05-10 00:00:00.000000'),
(32, 260.09, 'IGA', '', 2, '2018-05-03 00:00:00.000000'),
(33, 260.09, 'IGA', '', 2, '2018-04-26 00:00:00.000000'),
(34, 162.75, 'IGA', '', 2, '2018-04-19 00:00:00.000000'),
(35, 419.66, 'IGA', '', 2, '2018-01-04 00:00:00.000000'),
(36, 419.66, 'IGA', '', 2, '2018-01-04 00:00:00.000000'),
(37, 95.66, 'CANADA/GST', '', 2, '2018-01-05 00:00:00.000000'),
(38, 71.25, 'Gouv. QuÃ©bec', '', 2, '2018-01-05 00:00:00.000000'),
(39, 413.07, 'IGA', '', 2, '2018-01-11 00:00:00.000000'),
(40, 339.58, 'IGA', '', 2, '2018-01-18 00:00:00.000000'),
(41, 122.25, 'IGA', '', 2, '2018-01-18 00:00:00.000000'),
(42, 316.63, 'IGA', '', 2, '2018-01-25 00:00:00.000000'),
(43, 140.85, 'IGA', '', 2, '2018-02-01 00:00:00.000000'),
(44, 140.85, 'IGA', '', 2, '2018-02-08 00:00:00.000000'),
(45, 140.85, 'IGA', '', 2, '2018-02-15 00:00:00.000000'),
(46, 219.13, 'IGA', '', 2, '2018-02-22 00:00:00.000000'),
(47, 371.01, 'Bourse IGA', '', 2, '2018-02-22 00:00:00.000000'),
(48, 140.85, 'IGA', '', 2, '2018-03-01 00:00:00.000000'),
(49, 118.74, 'IGA', '', 2, '2018-03-08 00:00:00.000000'),
(50, 162.97, 'IGA', '', 2, '2018-03-15 00:00:00.000000'),
(51, 158.37, 'CANADA/Retour de taxes', '', 2, '2018-03-19 00:00:00.000000'),
(52, 151.58, 'IGA', '', 2, '2018-03-22 00:00:00.000000'),
(53, 384.83, 'Gouv. QuÃ©bec/Retour de taxes', '', 2, '2018-03-23 00:00:00.000000'),
(54, 151.91, 'IGA', '', 2, '2018-03-29 00:00:00.000000'),
(55, 287.47, 'IGA', '', 2, '2018-04-05 00:00:00.000000'),
(56, 95.68, 'CANADA/GST', '', 2, '2018-04-05 00:00:00.000000'),
(57, 71.25, 'Gouv. QuÃ©bec', '', 2, '2018-04-05 00:00:00.000000'),
(58, 269.56, 'IGA', '', 2, '2018-04-12 00:00:00.000000'),
(59, 25.00, 'Megan/Covoiturage', '', 2, '2018-05-16 00:00:00.000000'),
(60, 222.71, 'IGA', '', 2, '2018-05-17 00:00:00.000000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`idCategorie`);

--
-- Indexes for table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`idCompte`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `depense`
--
ALTER TABLE `depense`
  ADD PRIMARY KEY (`idDepense`);

--
-- Indexes for table `revenue`
--
ALTER TABLE `revenue`
  ADD PRIMARY KEY (`idRevenue`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `idCategorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
--
-- AUTO_INCREMENT for table `compte`
--
ALTER TABLE `compte`
  MODIFY `idCompte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `depense`
--
ALTER TABLE `depense`
  MODIFY `idDepense` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `idRevenue` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
