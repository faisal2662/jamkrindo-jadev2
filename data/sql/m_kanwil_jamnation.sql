-- MariaDB dump 10.19  Distrib 10.5.22-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: jade_jamkrindo
-- ------------------------------------------------------
-- Server version	10.5.22-MariaDB

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
-- Table structure for table `m_kanwil_jamnation`
--

DROP TABLE IF EXISTS `m_kanwil_jamnation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_kanwil_jamnation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kanwil` int(11) DEFAULT NULL,
  `kode_uker` varchar(20) DEFAULT NULL,
  `nama_uker` varchar(100) DEFAULT NULL,
  `kelas_uker` varchar(25) DEFAULT NULL,
  `latitude` varchar(25) DEFAULT NULL,
  `longitude` varchar(25) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_deleted` varchar(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_kanwil_jamnation`
--

LOCK TABLES `m_kanwil_jamnation` WRITE;
/*!40000 ALTER TABLE `m_kanwil_jamnation` DISABLE KEYS */;
INSERT INTO `m_kanwil_jamnation` VALUES (1,7,'BKW7','Kantor Wilayah Denpasar','B','-8.654458853','115.21653329890924','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:52:48'),(2,4,'BKW4','Kantor Wilayah Bandung','A','-6.910655826','107.60986952537303','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55'),(3,5,'BKW5','Kantor Wilayah Semarang','A','-6.981679617','110.4122341695528','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55'),(4,9,'BKW9','Kantor Wilayah Makassar','B','-5.133215561','119.40783685662606','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55'),(5,2,'BKW2','Kantor Wilayah Palembang','B','-2.991046173','104.75675098698375','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55'),(6,8,'BKW8','Kantor Wilayah Banjarmasin','B','-3.327490958','114.58899911265445','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55'),(7,1,'BKW1','Kantor Wilayah Medan','B','3.5902455275064686','98.67497243281954','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55'),(8,3,'BKW3','Kantor Wilayah Jakarta','A','-6.177801578','106.82844443327093','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55'),(9,6,'BKW6','Kantor Wilayah Surabaya','A','-7.258891324','112.74703888119626','2025-01-09 13:54:55',NULL,'N','2025-01-09 13:54:55','2025-01-09 13:54:55');
/*!40000 ALTER TABLE `m_kanwil_jamnation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-15 15:50:05
