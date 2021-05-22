-- MySQL dump 10.13  Distrib 8.0.22, for Win64 (x86_64)
--
-- Host: localhost    Database: easylandb
-- ------------------------------------------------------
-- Server version	8.0.22

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carry_out`
--
USE easylandb;

DROP TABLE IF EXISTS `carry_out`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carry_out` (
  `id_work` int unsigned NOT NULL,
  `id_technician` int unsigned NOT NULL,
  `total_duration` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_work`,`id_technician`),
  KEY `id_techCARRY_idx` (`id_technician`),
  CONSTRAINT `id_techCARRY` FOREIGN KEY (`id_technician`) REFERENCES `technician` (`id_technician`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_workCARRY` FOREIGN KEY (`id_work`) REFERENCES `work` (`id_work`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carry_out`
--

LOCK TABLES `carry_out` WRITE;
/*!40000 ALTER TABLE `carry_out` DISABLE KEYS */;
INSERT INTO `carry_out` VALUES (1,1,'3'),(1,2,'3'),(2,1,'1');
/*!40000 ALTER TABLE `carry_out` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category` (
  `id_category` int unsigned NOT NULL AUTO_INCREMENT,
  `description` text,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'Router'),(2,'Switch'),(3,'Ethernet Cable'),(4,'Network Adapter Board'),(5,'Server'),(6,'Laptop'),(7,'Desktop'),(8,'Hub'),(9,'Bridge'),(10,'Firewall'),(11,'Modem');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `component`
--

DROP TABLE IF EXISTS `component`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `component` (
  `id_component` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `price_ToBuy` double DEFAULT NULL,
  `price_ToSell` double DEFAULT NULL,
  `id_category` int unsigned NOT NULL,
  `id_manifacturer` int unsigned NOT NULL,
  `quantity_available` int DEFAULT '0',
  PRIMARY KEY (`id_component`),
  KEY `id_categoryCOMPONENT_idx` (`id_category`),
  KEY `id_manifacturerCOMPONENT_idx` (`id_manifacturer`),
  CONSTRAINT `id_categoryCOMPONENT` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_manifacturerCOMPONENT` FOREIGN KEY (`id_manifacturer`) REFERENCES `manifacturer` (`id_manifacturer`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `component`
--

LOCK TABLES `component` WRITE;
/*!40000 ALTER TABLE `component` DISABLE KEYS */;
INSERT INTO `component` VALUES (1,'Switch 16 ports',10.5,14,2,1,10),(2,'1841',20.4,25.64,1,1,2),(3,'Laptop Da Ufficio',300,370,7,5,24),(4,'Firewall UltraSafe',65.8,90,10,6,18),(5,'Wi-Fi Adapter',25.48,37.65,9,6,1),(6,'Archer 4040',57.9,74.2,11,4,15),(7,'NAS WD',449.7,630.66,5,4,6),(8,'SG116',46,65,2,6,15),(9,'CBS110-5T',35,46,2,1,12),(10,'Fire Shield',70,120,10,6,9);
/*!40000 ALTER TABLE `component` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `customer` (
  `id_customer` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned NOT NULL,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `gender` varchar(2) DEFAULT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `postal_code` int unsigned DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  PRIMARY KEY (`id_customer`),
  KEY `id_userCUSTOMER_idx` (`id_user`),
  CONSTRAINT `id_userCUSTOMER` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='one customer = 0/1 users\none user = 1 customer';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,6,'Matt','Rossi','M','via Manifatture 13','Darfo Boario Terme',25047,'1987-05-06'),(2,1,'Fabrizio','Bianchi','M','piazza della Veranda 4','Roma',118,'1995-03-01'),(3,18,'test','testgtyhyu','NB','010101, 42','Ginevra',NULL,'1961-01-01'),(8,22,'wade','baisini','M','cacca','pupu',66666,'2002-09-05'),(19,23,'test2','test2','',NULL,'Darfo',NULL,NULL),(20,26,'test3','dodo','NB','via Dei Matti, 0','Alternia',NULL,'1999-08-25');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `manifacturer`
--

DROP TABLE IF EXISTS `manifacturer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `manifacturer` (
  `id_manifacturer` int unsigned NOT NULL AUTO_INCREMENT,
  `businness_name` varchar(45) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `postal_code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id_manifacturer`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `manifacturer`
--

LOCK TABLES `manifacturer` WRITE;
/*!40000 ALTER TABLE `manifacturer` DISABLE KEYS */;
INSERT INTO `manifacturer` VALUES (1,'CISCO',NULL,'Roma',NULL),(2,'Industria1',NULL,'Brescia',NULL),(3,'Industria2',NULL,'Roma',NULL),(4,'Laboratorio TECH',NULL,'Firenze',NULL),(5,'Azienda Generica',NULL,'Ginevra',NULL),(6,'CyberSec Inc.',NULL,'Milano',NULL);
/*!40000 ALTER TABLE `manifacturer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `office`
--

DROP TABLE IF EXISTS `office`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `office` (
  `id_office` int unsigned NOT NULL AUTO_INCREMENT,
  `city` varchar(45) NOT NULL,
  `address` varchar(45) NOT NULL,
  `postal_code` varchar(5) NOT NULL,
  `id_manager` int unsigned NOT NULL,
  PRIMARY KEY (`id_office`),
  KEY `id_manager_idx` (`id_manager`),
  CONSTRAINT `id_manager` FOREIGN KEY (`id_manager`) REFERENCES `technician` (`id_technician`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `office`
--

LOCK TABLES `office` WRITE;
/*!40000 ALTER TABLE `office` DISABLE KEYS */;
INSERT INTO `office` VALUES (1,'Brescia','via Gabbiani 2','00118',1),(2,'Darfo Boario Terme','via del Merlo 7','25047',5),(3,'Brescia','via Grosseto 42','00118',1);
/*!40000 ALTER TABLE `office` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order`
--

DROP TABLE IF EXISTS `order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `order` (
  `id_order` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `status` varchar(45) NOT NULL,
  `extra_info` text,
  `id_payment` int unsigned NOT NULL,
  PRIMARY KEY (`id_order`),
  KEY `id_payment_idx` (`id_payment`),
  CONSTRAINT `id_payment` FOREIGN KEY (`id_payment`) REFERENCES `payment` (`id_payment`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT=' instruction received (se pagamento = 0 o 1), shipped (solo quando pagamento = 2) , arrived';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order`
--

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment` (
  `id_payment` int unsigned NOT NULL AUTO_INCREMENT,
  `date` date DEFAULT NULL,
  `tot` double unsigned NOT NULL,
  `status` int DEFAULT '0',
  PRIMARY KEY (`id_payment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='0: pagamento inserito nel databse\n1: pagamento accordato con il fornitore, va liquidato\n2: pagamento liquidato';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qnt_orders`
--

DROP TABLE IF EXISTS `qnt_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qnt_orders` (
  `id_order` int unsigned NOT NULL,
  `id_component` int unsigned NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`id_order`,`id_component`),
  KEY `id_componentQNT_idx` (`id_component`),
  KEY `id_componentQNTO_idx` (`id_component`),
  CONSTRAINT `id_componentQNTO` FOREIGN KEY (`id_component`) REFERENCES `component` (`id_component`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_orderQNT` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qnt_orders`
--

LOCK TABLES `qnt_orders` WRITE;
/*!40000 ALTER TABLE `qnt_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `qnt_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `qnt_works`
--

DROP TABLE IF EXISTS `qnt_works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `qnt_works` (
  `id_work` int unsigned NOT NULL,
  `id_component` int unsigned NOT NULL,
  `quantity` int DEFAULT NULL,
  PRIMARY KEY (`id_work`,`id_component`),
  KEY `id_componentQNT_idx` (`id_component`),
  CONSTRAINT `id_componentQNT` FOREIGN KEY (`id_component`) REFERENCES `component` (`id_component`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_workQNT` FOREIGN KEY (`id_work`) REFERENCES `work` (`id_work`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `qnt_works`
--

LOCK TABLES `qnt_works` WRITE;
/*!40000 ALTER TABLE `qnt_works` DISABLE KEYS */;
/*!40000 ALTER TABLE `qnt_works` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `session`
--

DROP TABLE IF EXISTS `session`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `session` (
  `id_session` varchar(100) NOT NULL,
  `start_time` int unsigned NOT NULL,
  `id_user` int unsigned NOT NULL,
  PRIMARY KEY (`id_session`),
  KEY `id_userSESSION_idx` (`id_user`),
  CONSTRAINT `id_userSESSION` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `session`
--

LOCK TABLES `session` WRITE;
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
/*!40000 ALTER TABLE `session` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `supersession`
--

DROP TABLE IF EXISTS `supersession`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `supersession` (
  `id_supersession` varchar(100) NOT NULL,
  `id_superuser` int unsigned NOT NULL,
  `start_time` int unsigned NOT NULL,
  PRIMARY KEY (`id_supersession`),
  KEY `id_superuserSESSION_idx` (`id_superuser`),
  CONSTRAINT `id_superuserSESSION` FOREIGN KEY (`id_superuser`) REFERENCES `superuser` (`id_superuser`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `supersession`
--

LOCK TABLES `supersession` WRITE;
/*!40000 ALTER TABLE `supersession` DISABLE KEYS */;
INSERT INTO `supersession` VALUES ('57kv6h3nsvh2e7uapklu5gfqoi',1,1621635349);
/*!40000 ALTER TABLE `supersession` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `superuser`
--

DROP TABLE IF EXISTS `superuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `superuser` (
  `id_superuser` int unsigned NOT NULL AUTO_INCREMENT,
  `id_technician` int unsigned NOT NULL,
  `password` text NOT NULL,
  `email` varchar(45) NOT NULL,
  `power` int DEFAULT '0',
  PRIMARY KEY (`id_superuser`),
  KEY `id_technicianSUPERUSER_idx` (`id_technician`),
  CONSTRAINT `id_technicianSUPERUSER` FOREIGN KEY (`id_technician`) REFERENCES `technician` (`id_technician`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='il nome utente è la matricola\nil power va da 0 a 2\n0 il dipendente normale\n1 il supervisore\n2 il manager';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `superuser`
--

LOCK TABLES `superuser` WRITE;
/*!40000 ALTER TABLE `superuser` DISABLE KEYS */;
INSERT INTO `superuser` VALUES (1,5,'$2y$10$/kKae9Y1koRzpBPE3.pc9urSYJlcJd9hmfEE2spS3MdKwG7UvLcWa','test@gmail.com',2),(2,1,'$2y$10$2cDqO6E2R/NG4GdLavSr6OqRZQQ0T6NtdVFBXP2I8U6acUZaCImYy','joes@gmail.com',2),(3,2,'$2y$10$fJP7w2GgAYFz18Ai8aL87.wu7UmmUF14FqfWwwYzL.fChCY/VKPQi','robertor@gmail.com',0),(4,3,'$2y$10$Vnr.H6UWEVnzmNCz5YS4S.yER9.B0hP/d0uMJk4rW2utDihp.zsQO','francescab@gmail.com',0),(5,4,'$2y$10$PLv8Iwk4.Ni0R7mHfXvSlOaAGZYKTwmztQI3CbWMXzyecEb5u73Rq','giovannij@gmail.com',1);
/*!40000 ALTER TABLE `superuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `technician`
--

DROP TABLE IF EXISTS `technician`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `technician` (
  `id_technician` int unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(45) NOT NULL,
  `lastname` varchar(45) NOT NULL,
  `gender` varchar(2) DEFAULT NULL,
  `birth_date` date NOT NULL,
  `id_supervisor` int unsigned DEFAULT NULL,
  `labor_hourly` float unsigned DEFAULT NULL,
  `id_office` int unsigned NOT NULL,
  PRIMARY KEY (`id_technician`),
  KEY `id_office_idx` (`id_office`),
  KEY `id_supervisor_idx` (`id_supervisor`),
  CONSTRAINT `id_office` FOREIGN KEY (`id_office`) REFERENCES `office` (`id_office`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_supervisor` FOREIGN KEY (`id_supervisor`) REFERENCES `technician` (`id_technician`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='//cambiare il codice';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `technician`
--

LOCK TABLES `technician` WRITE;
/*!40000 ALTER TABLE `technician` DISABLE KEYS */;
INSERT INTO `technician` VALUES (1,'Joe','Stevenson','M','1999-12-12',NULL,NULL,1),(2,'Roberto','Rinaldi','M','1998-07-20',1,NULL,1),(3,'Francesca','Bassi','F','1991-05-05',1,NULL,1),(4,'Giovanni','Jacobs','M','1992-12-30',NULL,NULL,3),(5,'test','test','NB','1961-01-01',NULL,NULL,1);
/*!40000 ALTER TABLE `technician` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ticket`
--

DROP TABLE IF EXISTS `ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ticket` (
  `id_ticket` int unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int unsigned NOT NULL,
  `title_request` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `image` blob,
  `date` date NOT NULL,
  `isOpen` tinyint NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_ticket`),
  KEY `id_userTICKET_idx` (`id_user`),
  CONSTRAINT `id_userTICKET` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ticket`
--

LOCK TABLES `ticket` WRITE;
/*!40000 ALTER TABLE `ticket` DISABLE KEYS */;
INSERT INTO `ticket` VALUES (10,17,'test','rest',NULL,'2021-05-17',1),(11,18,'dfgdfgdf','dffdgdgfdgfhnvbnbcvmbnm',NULL,'2021-05-17',1),(12,18,'gfdgfdsgdfgfdsg','dgdsgdsgdsg',NULL,'2021-05-17',1),(13,18,'fhfdghdfhfg','fgdhfgdhfghdfh',NULL,'2021-05-17',1),(14,18,'fxcbghfdhfgd','ghghjghj',NULL,'2021-05-17',1),(15,18,'fdgfdsgfd','gdfgfdg',NULL,'2021-05-17',1),(16,18,'ciao toni','j',NULL,'2021-05-17',1),(17,26,'Mario','Ciao, vediamo se funziona sono mario',NULL,'2021-05-21',1);
/*!40000 ALTER TABLE `ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id_user` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(45) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'fabrizioBianchi','$2y$10$zz2YYYZI5T3tAECkDsJ03u8Pw7eURMQYKcAok92e3jsW0Jb7h01Zi','fabriziobianchi@gmail.com'),(6,'matthew87','$2y$10$PEIjXXPbVKiYuACoiYGmgOcyqvxe28SbDuz5cWIdirWu.MjpvReny','mattrossi87@gmail.com'),(7,'marioz','$2y$10$wUwdXjyDgCPWEWkYBgF90O6wwiOKbOy01GoZZErrt.0kJQRI/OV9e','masterzaland@gmail.com'),(9,'giovivi99','$2y$10$lliwaTRaqXxY5Hx47/kG3up5/bXlignoW3.3HnG67v3uptSzBMoRO','giovi@gmail.com'),(13,'ecila29','$2y$10$CY0tv9O.wxb0JtCBtgdNg.H4AWFx51ZyTmtpwXxVuLEA0y8cX7XDe','alice@gmail.com'),(16,'AmyLess','$2y$10$W7LDh5Mm38RaOJxgGjzCMOU4NwKkG7uvYuHS15yoCz3N4/8wWmvTe','amyamy@gmail.com'),(17,'tizzy67','$2y$10$7jK4npLXhTzGDii3b3bnk.SYab/iZ1S776GsNiURdcjdVzPeGUQQq','tizzy67@gmail.com'),(18,'test','$2y$10$qaiDMbwCf57/s/rGEd/IB.E2/h/zholdKCxzFjd5tRwLGsJpm9Y2u','one.baisini@gmail.com'),(19,'gabbay1','$2y$10$OcO/WbZdbQV12xCsOtLTMOKXLzMIc1JTHGSiBJDm.Qa4E8Sk7bkZ2','gabbay@gmail.com'),(20,'robert','$2y$10$d8rwL7BzdRmZEhOgpVCGY.89dtUFHJqaUb2B2OGmtH35Np/qvS9cm','robert@gmail.com'),(22,'newuser','$2y$10$ZDI6WTlroPvhLjXLigeo.OXt1S.f5HHiqOHoM.4nBinhJ2bc9yHuy','newuser@gmail.com'),(23,'test2','$2y$10$OFq0ZskCAfKPaOppRydkQOrlcu7tbvqdzUrITBK4iPlS3Ocj9ySwa','test2@gmail.com'),(26,'test3','$2y$10$33QmPnrKVg8p6Rw1KasdIOmyjYcKmRrSaYqiHX1KiQlh3wJhwfvuW','test3@gmail.com'),(27,'newuser1','$2y$10$KvnGt3byKo8jX.FeEt2wauVSR8ke2OsgWyvxAhYuJAGkzuro5BXRq','newuser1@gmail.com');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `work`
--

DROP TABLE IF EXISTS `work`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `work` (
  `id_work` int unsigned NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `postal_code` varchar(5) DEFAULT NULL,
  `city` varchar(45) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `finish_date` varchar(45) DEFAULT NULL,
  `id_customer` int unsigned NOT NULL,
  PRIMARY KEY (`id_work`),
  KEY `id_customerWORK_idx` (`id_customer`),
  CONSTRAINT `id_customerWORK` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `work`
--

LOCK TABLES `work` WRITE;
/*!40000 ALTER TABLE `work` DISABLE KEYS */;
INSERT INTO `work` VALUES (1,'Sopralluogo e discussione del progetto.','2021-05-19','25047','Darfo Boario Terme','via Massi',NULL,3),(2,'Scambio di delicatezze.','2021-05-19','25047','Darfo Boario Terme','via Massi','2021-05-19',3),(9,'test invio tupla intervento + 1 tecnico','2021-05-22',NULL,'Darfo',NULL,NULL,19);
/*!40000 ALTER TABLE `work` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-05-22  1:24:53
