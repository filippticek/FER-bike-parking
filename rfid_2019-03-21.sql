# ************************************************************
# Sequel Pro SQL dump
# Version 4491
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.42)
# Database: rfid
# Generation Time: 2019-03-21 11:17:05 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table readerManagers
# ------------------------------------------------------------

# DROP TABLE IF EXISTS `readerManagers`;
CREATE DATABASE bikeParking;

CREATE TABLE `readerManagers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) DEFAULT NULL,
  `readerID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `readerManagers` WRITE;
/*!40000 ALTER TABLE `readerManagers` DISABLE KEYS */;

INSERT INTO `readerManagers` (`id`, `userID`, `readerID`)
VALUES
	(1,1,1);

/*!40000 ALTER TABLE `readerManagers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table readers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `readers`;

CREATE TABLE `readers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `readers` WRITE;
/*!40000 ALTER TABLE `readers` DISABLE KEYS */;

INSERT INTO `readers` (`id`, `name`, `type`)
VALUES
	(1,'Bicikli jug',1);

/*!40000 ALTER TABLE `readers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table readerTags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `readerTags`;

CREATE TABLE `readerTags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `readerid` int(11) DEFAULT NULL,
  `tagid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `readerTags` WRITE;
/*!40000 ALTER TABLE `readerTags` DISABLE KEYS */;

INSERT INTO `readerTags` (`id`, `readerid`, `tagid`)
VALUES
	(1,1,1);

/*!40000 ALTER TABLE `readerTags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tags
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tags`;

CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id1` varchar(50) DEFAULT NULL,
  `id2` varchar(50) DEFAULT NULL,
  `type` int(1) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `surname` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;

INSERT INTO `tags` (`id`, `id1`, `id2`, `type`, `username`, `name`, `surname`)
VALUES
	(1,'E20034120138F20010D5CFAF','E2005037590601040670CFAF',1,'gvasik...@fer.hr','G','Vas');

/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `isadmin` int(1) DEFAULT NULL,
  `ismanager` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `email`, `isadmin`, `ismanager`)
VALUES
	(1,'bklier','neki_hash_sa_saltom','barbara.klier@fer.hr',1,1);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
