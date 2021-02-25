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
  `putanja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table baza.izbor: ~0 rows (approximately)
/*!40000 ALTER TABLE `izbor` DISABLE KEYS */;
INSERT IGNORE INTO `izbor` (`id`, `baza`, `tabela`, `putanja`, `naziv`) VALUES
	(1, 'baza', 'meso', 'd:\\xampp\\htdocs\\', 'builder');
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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table baza.kolone: ~5 rows (approximately)
/*!40000 ALTER TABLE `kolone` DISABLE KEYS */;
INSERT IGNORE INTO `kolone` (`id`, `baza`, `tabela`, `pozicija`, `naziv`, `tip`, `duzina`, `nulabilno`, `podrazumevano`, `kljuc`, `ref_tabela`, `ref_kolona`, `validacija`, `pretraga`, `dodavanje`, `izmena`) VALUES
	(1, 'baza', 'meso', 1, 'id', 'int', NULL, 'NO', NULL, 'PRI', NULL, NULL, 1, 1, 1, 1),
	(2, 'baza', 'meso', 2, 'putanja', 'varchar', 255, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(3, 'baza', 'meso', 3, 'naziv', 'varchar', 255, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(4, 'baza', 'meso', 4, 'sadrzaj', 'text', 65535, 'NO', NULL, '', NULL, NULL, 1, 1, 1, 1),
	(5, 'baza', 'meso', 5, 'tip_id', 'int', NULL, 'NO', NULL, 'MUL', 'tipovi', 'id', 1, 1, 1, 1);
/*!40000 ALTER TABLE `kolone` ENABLE KEYS */;

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

-- Dumping data for table baza.meso: ~0 rows (approximately)
/*!40000 ALTER TABLE `meso` DISABLE KEYS */;
/*!40000 ALTER TABLE `meso` ENABLE KEYS */;

-- Dumping structure for table baza.skelet
DROP TABLE IF EXISTS `skelet`;
CREATE TABLE IF NOT EXISTS `skelet` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `putanja` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sadrzaj` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sablon` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table baza.skelet: ~1 rows (approximately)
/*!40000 ALTER TABLE `skelet` DISABLE KEYS */;
INSERT IGNORE INTO `skelet` (`id`, `putanja`, `naziv`, `sadrzaj`, `sablon`) VALUES
	(1, '\\', 'composer.json', '{\r\n    "name": "chasha/chasha-slim3",\r\n    "description": "ChaSha Slim3 Template",\r\n    "require": {\r\n        "slim/slim": "^3.12.2",\r\n        "slim/csrf": "^0.8.3",\r\n        "slim/twig-view": "^2.5",\r\n        "slim/flash": "^0.4.0",\r\n        "kanellov/slim-twig-flash": "^0.2.0",\r\n        "twig/extensions": "*",\r\n        "phpmailer/phpmailer": "^6.1"\r\n    },\r\n    "autoload": {\r\n        "psr-4": {\r\n            "App\\\\": "app"\r\n        }\r\n    }\r\n}', 0),
	(2, '\\', '.gitignore', '/vendor', 0),
	(3, '\\', 'README.md', '# README', 0),
	(4, '\\', 'zapisnik.md', '# ZAPISNIK', 0),
	(5, '\\app\\', 'routes.php', '<?php\r\n\r\nuse App\\Middlewares\\AuthMiddleware;\r\nuse App\\Middlewares\\GuestMiddleware;\r\nuse App\\Middlewares\\UserLevelMiddleware;\r\n\r\n$app->group(\'\', function () {\r\n    $this->get(\'/prijava\', \'\\App\\Controllers\\AuthController:getPrijava\')->setName(\'prijava\');\r\n    $this->post(\'/prijava\', \'\\App\\Controllers\\AuthController:postPrijava\');\r\n})->add(new GuestMiddleware($container));\r\n\r\n$app->group(\'\', function () {\r\n    $this->get(\'/\', \'\\App\\Controllers\\HomeController:getHome\')->setName(\'pocetna\');\r\n    $this->get(\'/odjava\', \'\\App\\Controllers\\AuthController:getOdjava\')->setName(\'odjava\');\r\n    $this->get(\'/promena\', \'\\App\\Controllers\\AuthController:getPromena\')->setName(\'promena\');\r\n    $this->post(\'/promena\', \'\\App\\Controllers\\AuthController:postPromena\')->setName(\'promena\');\r\n})->add(new AuthMiddleware($container));', 0);
/*!40000 ALTER TABLE `skelet` ENABLE KEYS */;

-- Dumping structure for table baza.tipovi
DROP TABLE IF EXISTS `tipovi`;
CREATE TABLE IF NOT EXISTS `tipovi` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `naziv` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table baza.tipovi: ~0 rows (approximately)
/*!40000 ALTER TABLE `tipovi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipovi` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
