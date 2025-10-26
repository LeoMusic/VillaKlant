/*M!999999\- enable the sandbox mode */ 
-- MariaDB dump 10.19  Distrib 10.6.23-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: villaproct_klanten
-- ------------------------------------------------------
-- Server version	10.6.23-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bedrijven`
--

DROP TABLE IF EXISTS `bedrijven`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `bedrijven` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bedrijfsnaam` varchar(255) NOT NULL,
  `straat` varchar(255) NOT NULL,
  `huisnummer` varchar(10) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  `woonplaats` varchar(100) NOT NULL,
  `land` varchar(100) NOT NULL,
  `email_facturen` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL COMMENT 'Website URL van het bedrijf',
  `telefoonnummer` varchar(20) DEFAULT NULL COMMENT 'Telefoonnummer met Nederlandse formatting',
  `notities` text DEFAULT NULL COMMENT 'Vrije notities en opmerkingen',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bedrijven`
--

LOCK TABLES `bedrijven` WRITE;
/*!40000 ALTER TABLE `bedrijven` DISABLE KEYS */;
INSERT INTO `bedrijven` VALUES (1,'Bedrijf onbekend','','','','','','',NULL,NULL,NULL),(2,'Villa ProCtrl ','Perklaan ','20','9752 GP','Haren','Nederland','Invoiceonly@villaproctrl.com',NULL,NULL,NULL),(3,'Leo Music & Audio','Hoofdstraat ','100','9501CR','Stadskanaal','Nederland','Leofactuur@leomusic.nl',NULL,NULL,NULL),(4,'Dijklander Ziekenhuis Hoorn','Maelsonstraat','3','1624 NP','Hoorn','Nederland','M.A.A.Nolles-Ligthart@dijklander.nl',NULL,NULL,NULL),(5,'IJsselland Ziekenhuis - Hoofdlocatie','Prins Constantijnweg','2','2906 ZC','Capelle a/d IJssel','Nederland','NZalm@ysl.nl',NULL,NULL,NULL),(6,'MCL Leeuwarden ','Henri Dunantweg','2','8934 AD','Leeuwarden','Nederland','j.hiemstra@mcl.n',NULL,NULL,NULL),(7,'Sheelingroup','Unit 11 Boyne Business Park','11','A92 RR96','Drogheda','Ierland','info@sheelingroup.com',NULL,NULL,NULL),(8,'DM Enginering','Haeshel St. North Industrial Park','5','30889','Caesarea','Israël','helenal@dm-ltd.co.il',NULL,NULL,NULL),(9,'Zuyderland Medisch Centrum Heerlen','Henri Dunantstraat ','5','6419 PC','Heerlen','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(10,'Saxenburgh Medisch Centrum','Weitenkamplaaan ','4A','7772 SG','Hardenberg','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(11,'Beatrix ziekenhuis','Banneweg','57','4204 AA','Gorinchem','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(12,'Dianet','Brennerbaan','130','3524 BN','Utrecht','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(13,'Tjongerschans Ziekenhuis','Thialfweg','44','8441 PW','8441 PW','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(14,'St. Antonius ziekenhuis	','Koekoekslaan','1','3435 CM','Nieuwegein','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(15,'Dijklander Ziekenhuis','Waterlandlaan','250','1441 ML','Purmerend','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(16,'Spaarne Gasthuis','Spaarnepoort','1','2134 TM ','Hoofddorp','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(17,'Rijnstate Ziekenhuis','Wagnerlaan','55','6815 AD','Arnhem','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(18,'AKLIA Groupe	','Rue du Puits Japie','501-503','79410','Échiré','Frankrijk','Nog@geenmail.nl',NULL,NULL,NULL),(19,'Viecurie MC','Tegelseweg','210','5912 BL','Venlo','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(20,'De Bonte Wever | Assen','Stadsbroek','17','9405BK','Assen','Nederland','info@debontewever.nl',NULL,NULL,NULL),(21,'A&F infinterieurbouw','Virulystraat','1','9716 JT','Groningen','Nederland','info@aenfinterieurbouw.nl',NULL,NULL,NULL),(22,' SJG Weert St. Jans Gasthuis ','Vogelsbleek','5','6001 BE','Weert','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(23,'Frisius MC locatie Heerenveen','Thialfweg ','44','8441 PW','Heerenveen','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(24,'Ziekenhuis Rivierenland','President Kennedylaan','1','4002 WP','Tiel','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(25,'Ziekenhuis St Jansdal','Wethouder Jansenlaan','90','3844 DG','Harderwijk','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(26,'OCON Hengelo','Geerdinksweg','141','7550 AM','Hengelo','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(27,'Elkerliek ziekenhuis','Wesselmanlaan','25','5707 HA','Helmond','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(28,'Sevagram','Henri Dunantstraat','3','6419 PB','Heerlen','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(29,'Viecuri','Tegelseweg','210','5912 BL','Venlo','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(30,'Sint Maartenskliniek','Hengstdal','3','6574 NA','Ubbergen','Nederland','Nog@geenmail.nl',NULL,NULL,NULL),(31,'Centre hospitalier universitaire de Nantes','allée de l\'Île-Gloriette','5','44093','Nantes','Frankrijk','Nog@geenmail.nl',NULL,NULL,NULL),(32,'South Western Sydney Local Health District','Elizabeth St','13','NSW 2170','Liverpool','Australie','Nog@geenmail.nl',NULL,NULL,NULL);
/*!40000 ALTER TABLE `bedrijven` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `functies`
--

DROP TABLE IF EXISTS `functies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `functies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `functienaam` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `functies`
--

LOCK TABLES `functies` WRITE;
/*!40000 ALTER TABLE `functies` DISABLE KEYS */;
INSERT INTO `functies` VALUES (1,'Onbekend'),(2,'Directeur'),(3,'Technicus'),(4,'Coördinator Gastvrijheid'),(5,'Administratie'),(6,'Projectleider'),(7,'Inkoop'),(8,'General Manager'),(9,'Projectleider Afd. Informatie');
/*!40000 ALTER TABLE `functies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `klanten`
--

DROP TABLE IF EXISTS `klanten`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `klanten` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `voornaam` varchar(255) NOT NULL,
  `achternaam` varchar(255) NOT NULL,
  `telefoonnummer_mobiel` varchar(20) DEFAULT NULL,
  `telefoonnummer_vast` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `functie_id` int(11) DEFAULT NULL,
  `bedrijf_id` int(11) DEFAULT NULL,
  `notities` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `functie_id` (`functie_id`),
  KEY `bedrijf_id` (`bedrijf_id`),
  CONSTRAINT `klanten_ibfk_1` FOREIGN KEY (`functie_id`) REFERENCES `functies` (`id`),
  CONSTRAINT `klanten_ibfk_2` FOREIGN KEY (`bedrijf_id`) REFERENCES `bedrijven` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `klanten`
--

LOCK TABLES `klanten` WRITE;
/*!40000 ALTER TABLE `klanten` DISABLE KEYS */;
INSERT INTO `klanten` VALUES (1,'Tonny','Koops','0628788421','','Tonny@villaproctrl.com',2,2,''),(2,'Albert','Boddema','0621819760','0599612346','albert@leomusic.nl',2,3,''),(3,'Hans','Groenhof','0612232025','','Hans@leomusic.nl',3,3,''),(4,'Ria','Nolles','0630702401','','m.a.a.nolles-ligthart@dijklander.nl',4,4,''),(5,'Nathalie','Zalm','0647633670','0102585256','NZalm@ysl.nl',5,5,''),(6,'Jolanda','Egberink','','0102585938','jegberink@ysl.nl',6,5,'Werkzaam op ma, di en do.'),(7,'Jos','Hiemstra','0643790857','0582867180','j.hiemstra@mcl.nl',7,6,''),(8,'Karen','Stanley','+353 (0)86 8163515','0419831667','karen@sheelingroup.com',7,7,''),(9,'Helen','Elbar','+972-50-5333226','+972-4-6178424','helenal@dm-ltd.co.il',7,8,''),(10,'Martin','Luik',' 06-21173709',' 0592-303713','M.Luik@debontewever.nl',8,20,'Kort contact via mail over spreekgestoelte, maar eerst geen interesse. Ga eens langs als ik in de buurt ben'),(11,'Eric','Roosien','','050 5773874','',1,1,''),(12,'J.','J. Hiemstra','','','',1,23,''),(13,'Bryan','Lemeer','','','',1,28,''),(14,'Tink','Voskamp','06212 970 43','','tink@buitenhuisadvies.nl',1,25,''),(15,'L.','Kievits','','','',1,30,''),(16,'J.','Fokker','','','',9,5,'');
/*!40000 ALTER TABLE `klanten` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'villaproct_klanten'
--

--
-- Dumping routines for database 'villaproct_klanten'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-10-26 10:29:28
