-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 21, 2023 at 09:10 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myadmin`
--

-- --------------------------------------------------------

--
-- Table structure for table `columns`
--

DROP TABLE IF EXISTS `columns`;
CREATE TABLE IF NOT EXISTS `columns` (
  `Name` varchar(100) NOT NULL,
  `Type` varchar(100) NOT NULL,
  `size` int(11) NOT NULL,
  `primaryKey` tinyint(1) NOT NULL,
  `foreignKey` tinyint(1) NOT NULL,
  `idTable` int(11) NOT NULL,
  KEY `fkCols_Table` (`idTable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dbs`
--

DROP TABLE IF EXISTS `dbs`;
CREATE TABLE IF NOT EXISTS `dbs` (
  `Name` varchar(100) NOT NULL,
  PRIMARY KEY (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
CREATE TABLE IF NOT EXISTS `tables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tableName` varchar(100) NOT NULL,
  `DB` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fkDb_Table` (`DB`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `columns`
--
ALTER TABLE `columns`
  ADD CONSTRAINT `fkCols_Table` FOREIGN KEY (`idTable`) REFERENCES `tables` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `fkDb_Table` FOREIGN KEY (`DB`) REFERENCES `dbs` (`Name`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
