-- MySQL dump 10.13  Distrib 5.5.57, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: hsccrewfinder
-- ------------------------------------------------------
-- Server version	5.5.57-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin123','d3155d7ea7c71affde7fcbc23b364033b89fae8a');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `boat`
--

DROP TABLE IF EXISTS `boat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `boat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `fleet` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `boat_fleet_fk` (`fleet`),
  CONSTRAINT `boat_fleet_fk` FOREIGN KEY (`fleet`) REFERENCES `fleet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `boat`
--

LOCK TABLES `boat` WRITE;
/*!40000 ALTER TABLE `boat` DISABLE KEYS */;
INSERT INTO `boat` VALUES (1,'badger sloop 1',6,NULL);
/*!40000 ALTER TABLE `boat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Day Sailing'),(2,'HSC Sloop Racing'),(3,'MYC Wed Series'),(4,'MYC Sun Series'),(5,'Pirates\' Day'),(6,'Commordore\'s Cup'),(7,'HSC 420 Racing'),(8,'Other');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `boat` int(11) DEFAULT NULL,
  `notes` text,
  `fleet` int(11) DEFAULT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `eventCreator` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `event_boat_fk` (`boat`),
  KEY `event_category_fk` (`category`),
  KEY `event_fleet_fk` (`fleet`),
  KEY `event_eventCreator_fk` (`eventCreator`),
  CONSTRAINT `event_eventCreator_fk` FOREIGN KEY (`eventCreator`) REFERENCES `sailor` (`id`),
  CONSTRAINT `event_boat_fk` FOREIGN KEY (`boat`) REFERENCES `boat` (`id`),
  CONSTRAINT `event_category_fk` FOREIGN KEY (`category`) REFERENCES `category` (`id`),
  CONSTRAINT `event_fleet_fk` FOREIGN KEY (`fleet`) REFERENCES `fleet` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (4,NULL,'badger sloop sail','2018-04-29',1,'gonna be a good time',1,NULL,NULL,NULL),(5,NULL,'ANOTHER SLOOP SAIL!?','2018-05-16',1,'SO MUCH FUN',1,NULL,NULL,NULL),(6,NULL,'sat aft chill sloop sail wit da crew','2018-03-29',1,'sdfohsdkfjskj54k3wjh5 yo',1,NULL,NULL,NULL),(9,1,NULL,'2018-05-13',NULL,'wear sunscreen',8,'14:01:00','17:01:00',1),(10,4,NULL,'2018-05-31',NULL,'gonna crush it in an e scow',2,'12:01:00','16:01:00',1),(11,6,NULL,'2018-03-21',NULL,'yo yo yo',7,'13:01:00','14:02:00',1),(12,2,NULL,'2018-04-28',NULL,'hola peepzas',1,'16:17:00','18:00:00',1),(13,1,NULL,'2018-04-28',NULL,'khkgf',1,'19:01:00','22:01:00',1),(14,1,NULL,'2018-04-28',NULL,'WHAT up',3,'09:00:00','11:00:00',1),(15,4,NULL,'2018-04-29',NULL,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',2,'13:00:00','15:00:00',1),(17,8,NULL,'2018-05-17',NULL,'hola peepzas',1,'08:14:00','12:00:00',1),(18,1,NULL,'2018-05-04',NULL,'booze cruise all day',1,'08:00:00','20:00:00',2),(21,1,NULL,'2018-05-15',NULL,'efsfhsdfjkshdf 2qu4hk3jw  laj',5,'14:00:00','15:00:00',2),(22,1,NULL,'2018-06-02',NULL,'oh nooooooo ok bye',8,'14:01:00','18:00:00',2),(24,1,NULL,'2018-05-08',NULL,'ok o k ok o k ok o k ok ok ok o k what up what up what up',1,'13:00:00','16:00:00',2),(28,4,NULL,'2018-05-07',NULL,'whatever',12,'13:00:00','15:00:00',3),(31,1,NULL,'2018-06-07',NULL,'get yo early mornin windsurf in',5,'06:15:00','09:15:00',3),(32,7,NULL,'2018-05-18',NULL,'racing the 420: we gonna roll you right off that start line',4,'10:00:00','13:00:00',5),(33,6,NULL,'2018-06-01',NULL,'who knows',11,'13:00:00','16:00:00',5),(34,1,NULL,'2018-05-31',NULL,'i hate margin i hate margin i hate margin',1,'13:00:00','18:00:00',5),(35,1,NULL,'2018-05-04',NULL,'i\'m on a boat',3,'09:00:00','13:00:00',6),(36,1,NULL,'2018-05-12',NULL,'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',4,'19:00:00','21:00:00',6),(37,1,NULL,'2018-05-04',NULL,'fun in da sun',2,'12:00:00','16:00:00',4),(41,1,NULL,'2018-05-05',NULL,'bhjghj',1,'01:00:00','03:00:00',7);
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventCrew`
--

DROP TABLE IF EXISTS `eventCrew`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eventCrew` (
  `eventId` int(11) NOT NULL DEFAULT '0',
  `crewId` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eventId`,`crewId`),
  KEY `eventCrew_sailor_fk` (`crewId`),
  CONSTRAINT `eventCrew_event_fk` FOREIGN KEY (`eventId`) REFERENCES `event` (`id`) ON DELETE CASCADE,
  CONSTRAINT `eventCrew_sailor_fk` FOREIGN KEY (`crewId`) REFERENCES `sailor` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventCrew`
--

LOCK TABLES `eventCrew` WRITE;
/*!40000 ALTER TABLE `eventCrew` DISABLE KEYS */;
INSERT INTO `eventCrew` VALUES (24,1),(28,1),(35,1),(9,2),(15,2),(17,2),(32,2),(15,3),(18,3),(24,3),(35,3),(9,4),(15,4),(24,6);
/*!40000 ALTER TABLE `eventCrew` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fleet`
--

DROP TABLE IF EXISTS `fleet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fleet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fleet`
--

LOCK TABLES `fleet` WRITE;
/*!40000 ALTER TABLE `fleet` DISABLE KEYS */;
INSERT INTO `fleet` VALUES (1,'Badger Sloop',6),(2,'E-Scow',4),(3,'C-Scow',3),(4,'420',2),(5,'Windsurfing',1),(6,'Tech',2),(7,'Laser/Byte',1),(8,'J 24',8),(9,'J 22',6),(10,'O\'Day',6),(11,'Capri 22',6),(12,'Heavy Keelboat',10);
/*!40000 ALTER TABLE `fleet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `race`
--

DROP TABLE IF EXISTS `race`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `race` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `race`
--

LOCK TABLES `race` WRITE;
/*!40000 ALTER TABLE `race` DISABLE KEYS */;
/*!40000 ALTER TABLE `race` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sailor`
--

DROP TABLE IF EXISTS `sailor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sailor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastName` varchar(50) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `joinDate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sailor`
--

LOCK TABLES `sailor` WRITE;
/*!40000 ALTER TABLE `sailor` DISABLE KEYS */;
INSERT INTO `sailor` VALUES (1,'Cummins','Mary',NULL,'sailormary13','de0722e48173f4f6c59c130c0987ffd6243f344e','2018-04-28 16:08:35'),(2,'bobby','bob',NULL,'bob','48181acd22b3edaebc8a447868a7df7ce629920a','2018-04-29 18:47:09'),(3,NULL,'Captain Morgan',NULL,'captainmorgan','937adac2c17698631a14ce104e9216ee828f7129','2018-04-29 19:22:33'),(4,'t','benny',NULL,'ben','73675debcd8a436be48ec22211dcf44fe0df0a64','2018-04-29 19:32:24'),(5,'gurl','monica',NULL,'monica','96d53734fc1bd54d848cd30f98069b90333b1bb3','2018-04-29 19:49:46'),(6,'Nelson','Admiral','adnel@pirates.com','admiralnelson','937adac2c17698631a14ce104e9216ee828f7129','2018-05-02 00:53:03'),(7,'Marks','Ken','kmarks@gmail.com','kmarks','470bc578162732ac7f9d387d34c4af4ca6e1b6f7','2018-05-02 23:13:47');
/*!40000 ALTER TABLE `sailor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-03  0:48:30
