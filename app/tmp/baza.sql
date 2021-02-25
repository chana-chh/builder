-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.14-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for baza
DROP DATABASE IF EXISTS `baza`;
CREATE DATABASE IF NOT EXISTS `baza` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `baza`;

-- Dumping structure for table baza.izbor
DROP TABLE IF EXISTS `izbor`;
CREATE TABLE IF NOT EXISTS `izbor` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `baza` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabela` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `putanja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table baza.kolone
DROP TABLE IF EXISTS `kolone`;
CREATE TABLE IF NOT EXISTS `kolone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `baza` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tabela` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pozicija` int(11) NOT NULL,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tip` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duzina` int(11) DEFAULT NULL,
  `nulabilno` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `podrazumevano` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kljuc` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_tabela` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ref_kolona` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `validacija` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `pretraga` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `dodavanje` tinyint(3) unsigned NOT NULL DEFAULT 1,
  `izmena` tinyint(3) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table baza.meso
DROP TABLE IF EXISTS `meso`;
CREATE TABLE IF NOT EXISTS `meso` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `putanja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sadrzaj` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tip_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_meso_tipovi` (`tip_id`),
  CONSTRAINT `FK_meso_tipovi` FOREIGN KEY (`tip_id`) REFERENCES `tipovi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table baza.skelet
DROP TABLE IF EXISTS `skelet`;
CREATE TABLE IF NOT EXISTS `skelet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `putanja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sadrzaj` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table baza.tipovi
DROP TABLE IF EXISTS `tipovi`;
CREATE TABLE IF NOT EXISTS `tipovi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
