-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.1.36-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             10.1.0.5464
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table baza.izbor: ~0 rows (approximately)
/*!40000 ALTER TABLE `izbor` DISABLE KEYS */;
INSERT IGNORE INTO `izbor` (`id`, `baza`, `tabela`) VALUES
	(1, 'kartoteka', 'kartoni');
/*!40000 ALTER TABLE `izbor` ENABLE KEYS */;

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
  `validacija` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `pretraga` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `dodavanje` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `izmena` tinyint(3) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table baza.kolone: ~11 rows (approximately)
/*!40000 ALTER TABLE `kolone` DISABLE KEYS */;
INSERT IGNORE INTO `kolone` (`id`, `baza`, `tabela`, `pozicija`, `naziv`, `tip`, `duzina`, `nulabilno`, `podrazumevano`, `kljuc`, `ref_tabela`, `ref_kolona`, `validacija`, `pretraga`, `dodavanje`, `izmena`) VALUES
	(1, 'kartoteka', 'kartoni', 1, 'id', 'int', NULL, 'NO', NULL, 'PRI', NULL, NULL, 1, 1, 1, 1),
	(2, 'kartoteka', 'kartoni', 2, 'groblje_id', 'int', NULL, 'NO', NULL, 'MUL', 'groblja', 'id', 1, 1, 1, 1),
	(3, 'kartoteka', 'kartoni', 3, 'parcela', 'varchar', 50, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(4, 'kartoteka', 'kartoni', 4, 'grobno_mesto', 'varchar', 50, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(5, 'kartoteka', 'kartoni', 5, 'broj_mesta', 'smallint', NULL, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(6, 'kartoteka', 'kartoni', 6, 'tip_groba', 'enum', 12, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(7, 'kartoteka', 'kartoni', 7, 'aktivan', 'tinyint', NULL, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(8, 'kartoteka', 'kartoni', 8, 'napomena', 'text', 65535, 'YES', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(9, 'kartoteka', 'kartoni', 9, 'x_pozicija', 'int', NULL, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(10, 'kartoteka', 'kartoni', 10, 'y_pozicija', 'int', NULL, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(11, 'kartoteka', 'kartoni', 11, 'saldo', 'decimal', NULL, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1);
/*!40000 ALTER TABLE `kolone` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
