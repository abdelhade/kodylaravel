-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: kodylar
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `acc_groups`
--

DROP TABLE IF EXISTS `acc_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acc_groups` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `aname` varchar(255) DEFAULT NULL,
  `acc_type` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `code` varchar(30) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acc_groups`
--

LOCK TABLES `acc_groups` WRITE;
/*!40000 ALTER TABLE `acc_groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `acc_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acc_head`
--

DROP TABLE IF EXISTS `acc_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acc_head` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `deletable` int(11) DEFAULT 1,
  `editable` tinyint(1) DEFAULT 1,
  `aname` varchar(255) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `e_mail` varchar(100) DEFAULT NULL,
  `constant` int(11) DEFAULT 0,
  `is_stock` tinyint(1) DEFAULT 0,
  `is_fund` int(11) DEFAULT 0,
  `rentable` int(11) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `nature` int(11) DEFAULT NULL,
  `kind` int(11) DEFAULT NULL,
  `is_basic` tinyint(1) DEFAULT NULL,
  `start_balance` decimal(10,2) DEFAULT 0.00,
  `credit` decimal(10,2) DEFAULT 0.00,
  `debit` decimal(10,2) DEFAULT 0.00,
  `balance` decimal(10,2) DEFAULT 0.00,
  `secret` tinyint(1) DEFAULT 0,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `info` varchar(250) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1017 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acc_head`
--

LOCK TABLES `acc_head` WRITE;
/*!40000 ALTER TABLE `acc_head` DISABLE KEYS */;
INSERT INTO `acc_head` VALUES (1,'1',0,0,'الأصول',NULL,NULL,NULL,0,0,0,NULL,0,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(2,'2',0,0,'الخصوم',NULL,NULL,NULL,0,0,0,NULL,0,2,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(3,'3',0,0,'الإيرادات',NULL,NULL,NULL,0,0,0,NULL,0,2,2,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(4,'4',0,0,'المصروفات',NULL,NULL,NULL,0,0,0,NULL,0,1,2,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(11,'11',0,0,'الأصول الثابتة',NULL,NULL,NULL,0,0,0,NULL,1,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(12,'12',0,0,'الأصول المتداولة',NULL,NULL,NULL,0,0,0,NULL,1,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(21,'21',0,0,'الالتزامات المتداولة',NULL,NULL,NULL,0,0,0,NULL,2,2,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(22,'22',0,0,'حقوق الملكية',NULL,NULL,NULL,0,0,0,NULL,2,2,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(31,'31',0,0,'إيرادات مبيعات',NULL,NULL,NULL,0,0,0,NULL,3,2,2,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(32,'32',0,0,'إيرادات أخرى',NULL,NULL,NULL,0,0,0,NULL,3,2,2,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(41,'41',0,0,'تكلفة المبيعات',NULL,NULL,NULL,0,0,0,NULL,4,1,2,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(44,'44',0,0,'مصروفات تشغيلية',NULL,NULL,NULL,0,0,0,NULL,4,1,2,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(121,'121',0,0,'الخزائن والعهود',NULL,NULL,NULL,0,0,0,NULL,12,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(122,'122',0,0,'العملاء',NULL,NULL,NULL,0,0,0,NULL,12,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(123,'123',0,0,'المخازن',NULL,NULL,NULL,0,0,0,NULL,12,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(124,'124',0,0,'البنوك',NULL,NULL,NULL,0,0,0,NULL,12,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(125,'125',0,0,'المدينون المتنوعون',NULL,NULL,NULL,0,0,0,NULL,12,1,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(211,'211',0,0,'الموردين',NULL,NULL,NULL,0,0,0,NULL,21,2,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(212,'212',0,0,'الدائنون المتنوعون',NULL,NULL,NULL,0,0,0,NULL,21,2,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(213,'213',0,0,'موظفين (أمانات)',NULL,NULL,NULL,0,0,0,NULL,21,2,1,1,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(1001,'121001',0,0,'الخزينة الرئيسية',NULL,NULL,NULL,0,0,1,NULL,121,1,1,0,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(1002,'122001',0,0,'عميل نقدي',NULL,NULL,NULL,0,0,0,NULL,122,1,1,0,0.00,0.00,0.00,232.00,0,'2026-02-14 12:15:07','2026-03-07 09:48:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(1003,'123001',0,0,'المخزن الرئيسي',NULL,NULL,NULL,0,1,0,NULL,123,1,1,0,0.00,0.00,0.00,-205.00,0,'2026-02-14 12:15:07','2026-03-07 09:49:19',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(1004,'211001',0,0,'مورد نقدي',NULL,NULL,NULL,0,0,0,NULL,211,2,1,0,0.00,0.00,0.00,NULL,0,'2026-02-14 12:15:07','2026-02-14 12:20:31',NULL,0,0,0,'2026-02-14 10:15:07','2026-02-14 10:15:07'),(1005,'213001',1,1,'موظف 1',NULL,NULL,NULL,0,1,1,1,213,NULL,1,0,0.00,0.00,0.00,-51.00,0,'2026-02-14 12:20:56','2026-02-25 09:09:03',NULL,0,0,0,'2026-02-14 10:20:56','2026-02-14 10:20:56'),(1006,'213002',1,1,'موظف 2',NULL,NULL,NULL,0,1,1,1,213,NULL,1,0,0.00,0.00,0.00,NULL,0,'2026-02-14 12:21:09','2026-02-14 12:21:11',NULL,0,0,0,'2026-02-14 10:21:09','2026-02-14 10:21:09'),(1007,'Incidunt enim et to',1,1,'Rogan Snyder','+1 (263) 566-1287','Officiis recusandae',NULL,0,1,0,0,123,NULL,1,1,0.00,0.00,0.00,NULL,0,'2026-02-18 14:33:28','2026-02-18 14:33:28',NULL,0,0,0,'2026-02-18 12:33:28','2026-02-18 12:33:28'),(1008,'213003',1,1,'Claudia Kidd',NULL,NULL,NULL,0,0,0,0,35,NULL,1,0,0.00,0.00,0.00,66.00,0,'2026-02-23 14:42:54','2026-02-25 09:09:03',NULL,0,0,0,'2026-02-23 12:42:54','2026-02-23 12:42:54'),(1009,'213004',1,1,'Kato Morales',NULL,NULL,NULL,0,0,0,0,35,NULL,1,0,0.00,0.00,0.00,-15.00,0,'2026-02-23 14:43:21','2026-02-25 09:09:03',NULL,0,0,0,'2026-02-23 12:43:21','2026-02-23 12:43:21'),(1010,'124001',1,1,'بنك 1',NULL,NULL,NULL,0,1,1,1,124,NULL,1,0,0.00,0.00,0.00,NULL,0,'2026-02-25 09:09:25','2026-02-25 09:09:26',NULL,0,0,0,'2026-02-25 09:09:25','2026-02-25 09:09:25'),(1011,'121002',1,1,'صندوق 1',NULL,NULL,NULL,0,1,1,1,121,NULL,1,0,0.00,0.00,0.00,-100.00,0,'2026-02-25 09:10:12','2026-03-07 09:22:50',NULL,0,0,0,'2026-02-25 09:10:12','2026-02-25 09:10:12'),(1012,'123002',1,1,'مخزن 2',NULL,NULL,NULL,0,0,0,0,123,NULL,1,0,0.00,0.00,0.00,-200.00,0,'2026-02-25 09:11:33','2026-03-07 09:59:41',NULL,0,0,0,'2026-02-25 09:11:33','2026-02-25 09:11:33'),(1013,'213005',1,1,'Yoko Neal',NULL,NULL,NULL,0,0,0,0,35,NULL,1,0,0.00,0.00,0.00,-12.00,0,'2026-02-25 10:31:48','2026-03-07 09:22:50',NULL,0,0,0,'2026-02-25 10:31:48','2026-02-25 10:31:48'),(1014,'213006',1,1,'Galena Patel',NULL,NULL,NULL,0,0,0,0,35,NULL,1,0,0.00,0.00,0.00,NULL,0,'2026-02-25 10:40:01','2026-02-25 11:09:34',NULL,0,0,0,'2026-02-25 10:40:01','2026-02-25 10:40:01'),(1015,'122002',1,1,'عميل 2','01223456789','ةةةة',NULL,0,1,1,1,122,NULL,1,0,0.00,0.00,0.00,200.00,0,'2026-02-25 11:10:12','2026-03-07 09:59:41',NULL,0,0,0,'2026-02-25 11:10:12','2026-02-25 11:10:12'),(1016,'1221772021110',1,1,'عميل3','01123456789','وووووووووووووووو',NULL,0,0,0,NULL,122,NULL,NULL,0,0.00,0.00,0.00,85.00,0,'2026-02-25 12:05:10','2026-03-07 09:49:19',NULL,0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `acc_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `allowances`
--

DROP TABLE IF EXISTS `allowances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `allowances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tybe` int(11) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `allowances`
--

LOCK TABLES `allowances` WRITE;
/*!40000 ALTER TABLE `allowances` DISABLE KEYS */;
/*!40000 ALTER TABLE `allowances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analisys`
--

DROP TABLE IF EXISTS `analisys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analisys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client` int(11) DEFAULT NULL,
  `lap` int(11) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `img` varchar(250) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analisys`
--

LOCK TABLES `analisys` WRITE;
/*!40000 ALTER TABLE `analisys` DISABLE KEYS */;
/*!40000 ALTER TABLE `analisys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attandance`
--

DROP TABLE IF EXISTS `attandance`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attandance` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee` int(11) DEFAULT NULL,
  `fptybe` int(11) DEFAULT NULL,
  `fpdate` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `fromwhere` varchar(10) DEFAULT NULL,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attandance`
--

LOCK TABLES `attandance` WRITE;
/*!40000 ALTER TABLE `attandance` DISABLE KEYS */;
/*!40000 ALTER TABLE `attandance` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attdocs`
--

DROP TABLE IF EXISTS `attdocs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attdocs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empid` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fromdate` date DEFAULT NULL,
  `todate` date DEFAULT NULL,
  `alldays` decimal(10,2) DEFAULT NULL,
  `workdays` decimal(10,2) DEFAULT NULL,
  `exphours` decimal(10,2) DEFAULT NULL,
  `accualhours` decimal(10,2) DEFAULT NULL,
  `attdays` int(11) DEFAULT NULL,
  `absdays` int(11) DEFAULT NULL,
  `holidays` int(11) DEFAULT NULL,
  `earlyminits` decimal(10,2) DEFAULT NULL,
  `entitle` decimal(10,2) DEFAULT 0.00,
  `info` varchar(250) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attdocs`
--

LOCK TABLES `attdocs` WRITE;
/*!40000 ALTER TABLE `attdocs` DISABLE KEYS */;
/*!40000 ALTER TABLE `attdocs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `attlog`
--

DROP TABLE IF EXISTS `attlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attlog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee` int(11) DEFAULT NULL,
  `day` date DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `fpin` time DEFAULT NULL,
  `fpout` time DEFAULT NULL,
  `defhours` decimal(8,2) DEFAULT NULL,
  `curhours` decimal(8,2) DEFAULT NULL,
  `dueforhour` decimal(8,2) DEFAULT NULL,
  `realdue` decimal(8,2) DEFAULT NULL,
  `statue` tinyint(1) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `info` int(11) DEFAULT NULL,
  `attdoc` int(11) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attlog`
--

LOCK TABLES `attlog` WRITE;
/*!40000 ALTER TABLE `attlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `attlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barcodes`
--

DROP TABLE IF EXISTS `barcodes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barcodes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barcodes`
--

LOCK TABLES `barcodes` WRITE;
/*!40000 ALTER TABLE `barcodes` DISABLE KEYS */;
/*!40000 ALTER TABLE `barcodes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `book_tybes`
--

DROP TABLE IF EXISTS `book_tybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `book_tybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` decimal(8,2) DEFAULT NULL,
  `qty` tinyint(1) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `book_tybes`
--

LOCK TABLES `book_tybes` WRITE;
/*!40000 ALTER TABLE `book_tybes` DISABLE KEYS */;
/*!40000 ALTER TABLE `book_tybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `booking_cards`
--

DROP TABLE IF EXISTS `booking_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `booking_cards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client` varchar(255) DEFAULT NULL,
  `barcode` varchar(255) DEFAULT NULL,
  `rtybe` varchar(255) DEFAULT NULL,
  `rcost` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `remain` int(11) DEFAULT NULL,
  `bcase` int(11) DEFAULT NULL,
  `fromdate` date DEFAULT NULL,
  `todate` date DEFAULT NULL,
  `crtime` datetime DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `user` int(11) DEFAULT 0,
  `bransh` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `booking_cards`
--

LOCK TABLES `booking_cards` WRITE;
/*!40000 ALTER TABLE `booking_cards` DISABLE KEYS */;
/*!40000 ALTER TABLE `booking_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-language_ar','a:240:{s:15:\"lang_publicname\";s:10:\"الاسم\";s:15:\"lang_publicinfo\";s:14:\"معلومات\";s:21:\"lang_publicoperations\";s:12:\"عمليات\";s:14:\"lang_publicjob\";s:14:\"الوظيفة\";s:18:\"lang_publicdetails\";s:12:\"تفاصيل\";s:15:\"lang_publicdate\";s:14:\"التاريخ\";s:15:\"lang_publictype\";s:10:\"النوع\";s:18:\"lang_publicconfirm\";s:10:\"تأكيد\";s:14:\"lang_publicdel\";s:6:\"حذف\";s:15:\"lang_warningmsg\";s:88:\"قد يوجد مشكلة في ID أو تم الترحيل من المكان الخاطئ\";s:16:\"lang_warningmsg1\";s:76:\"لا يمكن مسح المدخل لارتباطه ببعض العمليات\";s:16:\"lang_warningmsg2\";s:145:\"تأكد ان العمليات المرتبطة بهذا البند تم تعديلها جميعا ليكون هذا البند غير مرتبط\";s:16:\"lang_warningmsg3\";s:35:\"غير مسموح للمستخدم \";s:9:\"lang_main\";s:16:\"الرئيسية\";s:14:\"lang_main_back\";s:45:\" الرجوع للقائمه الرئيسية\";s:16:\"lang_warningmsg4\";s:45:\"برجاء مراجعه مدير النظام\";s:16:\"lang_warningmsg5\";s:61:\" هل تريد بالتأكيد حذف هذه المهمة   \";s:11:\"sittingpass\";s:9:\"hadi@1234\";s:10:\"lang_title\";s:9:\"HORS TECH\";s:14:\"lang_navlogout\";s:23:\"تسجيل الخروج\";s:13:\"lang_sidename\";s:9:\"HORS TECH\";s:13:\"lang_sidemain\";s:16:\"الرئيسيه\";s:14:\"lang_sideentry\";s:27:\"ادخال البيانات\";s:18:\"lang_sideemployees\";s:16:\"الموظفين\";s:13:\"lang_sidejops\";s:33:\"المسميات الوظيفية\";s:14:\"lang_siderules\";s:31:\"الادوار الوظيفية\";s:18:\"lang_sidejoplevels\";s:35:\"المستويات الوظيفية\";s:20:\"lang_sidedepartments\";s:15:\" الأقسام\";s:19:\"lang_sideattendance\";s:12:\"الحضور\";s:21:\"lang_sideattenrecords\";s:23:\"سجلات الحضور\";s:18:\"lang_sideattendays\";s:23:\"سجلات الحضور\";s:22:\"lang_sideattennotebook\";s:23:\"دفاتر الحضور\";s:21:\"lang_sideholidayperms\";s:23:\"أذونات أجازة\";s:24:\"lang_sideshiftmanagement\";s:27:\"إدارة الورديات\";s:20:\"lang_sidecustomshift\";s:23:\"ورديات مخصصة\";s:18:\"lang_sidemissiones\";s:15:\"المهمات \";s:22:\"lang_side_allmissiones\";s:20:\"كل المهمات \";s:20:\"lang_side_newmission\";s:21:\" مهمه جديده \";s:27:\"lang_sideattendancesessions\";s:30:\"سجل جلسات الحضور\";s:17:\"lang_sidesettings\";s:18:\"الإعدادات\";s:17:\"lang_sidesalaries\";s:16:\"المرتبات\";s:19:\"lang_sideincomepath\";s:23:\"مسير الرواتب\";s:22:\"lang_sidesalarycoupons\";s:25:\"قسائم الرواتب\";s:15:\"lang_sideborrow\";s:10:\"السلف\";s:20:\"lang_sidesalaryitems\";s:21:\"بنود الراتب\";s:24:\"lang_sidesalarytemplates\";s:23:\"قوالب الراتب\";s:16:\"lang_sidereports\";s:16:\"التقارير\";s:26:\"lang_sideattendancereports\";s:25:\"تقارير الحضور\";s:24:\"lang_sidesalariesreports\";s:29:\"تقارير المرتبات\";s:17:\"lang_siderequests\";s:14:\"الطلبات\";s:27:\"lang_siderequestsmanagement\";s:25:\"إدارة الطلبات\";s:14:\"lang_sideusers\";s:20:\"المستخدمين\";s:18:\"lang_sidecontracts\";s:12:\"العقود\";s:21:\"lang_sideallcontracts\";s:17:\"كل العقود\";s:26:\"lang_sidetrainingcontracts\";s:23:\"عقود التدريب\";s:24:\"lang_sidehiringcontracts\";s:19:\"عقود العمل\";s:27:\"lang_sideoutsourcecontracts\";s:21:\"عقود خارجيه\";s:21:\"lang_sidevarcontracts\";s:17:\"عقود مرنه\";s:15:\"lang_dashsearch\";s:10:\"البحث\";s:17:\"lang_dashallbills\";s:21:\"كل الفواتير\";s:16:\"lang_dashnewbill\";s:23:\"فاتورة جديدة\";s:19:\"lang_choiceemployee\";s:17:\"اختر موظف\";s:14:\"lang_typeOrder\";s:18:\" نوع الطلب\";s:16:\"lang_StatusOrder\";s:20:\" حالة الطلب\";s:19:\"lang_Submissiondate\";s:27:\" تاريخ التقديم \";s:17:\"lang_Startingdate\";s:27:\" تاريخ التنفيذ \";s:18:\"lang_employeeslist\";s:27:\"قائمة الموظفين\";s:15:\"lang_departlist\";s:25:\"قائمة الأقسام\";s:15:\"lang_levelslist\";s:29:\"قائمة المستويات\";s:14:\"lang_ruleslist\";s:25:\"قائمة الأدوار\";s:13:\"lang_jobslist\";s:25:\"قائمة الوظائف\";s:10:\"lang_users\";s:20:\"المستخدمين\";s:13:\"lang_username\";s:23:\"اسم المتسخدم\";s:14:\"lang_userimage\";s:8:\"صورة\";s:19:\"lang_useroperations\";s:12:\"عمليات\";s:15:\"lang_usergender\";s:10:\"النوع\";s:13:\"lang_password\";s:8:\"password\";s:9:\"lang_user\";s:4:\"user\";s:10:\"lang_admin\";s:5:\"admin\";s:29:\"lang_addemployee_personalinfo\";s:23:\"بيانات شخصية\";s:21:\"lang_addemployee_name\";s:10:\"الاسم\";s:22:\"lang_addemployee_phone\";s:19:\"رقم الهاتف\";s:25:\"lang_addemployee_password\";s:12:\"باسورد\";s:24:\"lang_addemployee_basmaid\";s:19:\"رقم البصمه\";s:22:\"lang_addemployee_email\";s:33:\"البريد الإلكتروني\";s:22:\"lang_addemployee_image\";s:8:\"صورة\";s:23:\"lang_addemployee_upload\";s:10:\"تحميل\";s:21:\"lang_addemployee_info\";s:14:\"معلومات\";s:23:\"lang_addemployee_active\";s:10:\"موقوف\";s:24:\"lang_addemployee_details\";s:27:\"بيانات تفصيلية\";s:28:\"lang_addemployee_dateofbirth\";s:25:\"تاريخ الميلاد\";s:23:\"lang_addemployee_gender\";s:10:\"النوع\";s:21:\"lang_addemployee_male\";s:6:\"ذكر\";s:23:\"lang_addemployee_female\";s:8:\"أنثي\";s:24:\"lang_addemployee_address\";s:10:\"عنوان\";s:25:\"lang_addemployee_address1\";s:11:\"1عنوان\";s:25:\"lang_addemployee_address2\";s:11:\"2عنوان\";s:24:\"lang_addemployee_country\";s:10:\"البلد\";s:24:\"lang_addemployee_jobinfo\";s:25:\"بيانات وظيفية\";s:20:\"lang_addemployee_job\";s:14:\"الوظيفة\";s:26:\"lang_addemployee_jobdepart\";s:10:\"القسم\";s:24:\"lang_addemployee_jobtype\";s:21:\"نوع الوظيفة\";s:24:\"lang_addemployee_jobname\";s:27:\"المسمى الوظيفي\";s:25:\"lang_addemployee_jobstart\";s:21:\"وقت التوظيف\";s:23:\"lang_addemployee_jobend\";s:23:\"وقت الانتهاء\";s:25:\"lang_addemployee_salaries\";s:16:\"المرتبات\";s:24:\"lang_addemployee_vacansy\";s:14:\"العطلات\";s:24:\"lang_addemployee_holiday\";s:16:\"الأجازات\";s:23:\"lang_addemployee_salary\";s:12:\"المرتب\";s:25:\"lang_addemployee_joplevel\";s:29:\"المستوي الوظيفي\";s:22:\"lang_addemployee_shift\";s:12:\"الشيفت\";s:24:\"lang_addemployee_confirm\";s:10:\"تأكيد\";s:23:\"lang_emprofilemainentry\";s:21:\"بيانات عامه\";s:22:\"lang_emprofilejopentry\";s:25:\"بيانات وظيفية\";s:17:\"lang_emprofilejop\";s:27:\"بيانات الوظيفة\";s:22:\"lang_addhicont_newcont\";s:22:\"عقد عمل جديد\";s:26:\"lang_addhicont_newtrianing\";s:26:\"عقد تدريب جديد\";s:21:\"lang_addhicont_newout\";s:26:\"عقد خارجي جديد\";s:19:\"lang_addhicont_name\";s:10:\"الاسم\";s:23:\"lang_addhicont_employee\";s:12:\"الموظف\";s:18:\"lang_addhicont_jop\";s:14:\"الوظيفة\";s:29:\"lang_addhicont_jopdescription\";s:21:\"وصف الوظيفة\";s:21:\"lang_addhicont_salary\";s:12:\"المرتب\";s:30:\"lang_addhicont_salaryagreement\";s:27:\"مبلغ الاتفاقيه\";s:7:\"lang_lc\";s:0:\"\";s:26:\"lang_addhicont_salaryraise\";s:14:\"الزيادة\";s:24:\"lang_addhicont_startcont\";s:21:\"بداية العقد\";s:22:\"lang_addhicont_endcont\";s:21:\"نهاية العقد\";s:24:\"lang_addhicont_workhours\";s:21:\"ساعات العمل\";s:27:\"lang_addhicont_inorderhours\";s:39:\"ساعات العمل تحت الطلب\";s:26:\"lang_addhicont_workdaysoff\";s:32:\"عدد أيام الأجازات\";s:19:\"lang_addhicont_info\";s:14:\"معلومات\";s:19:\"lang_addhicont_user\";s:16:\"المستخدم\";s:19:\"lang_addhicont_rule\";s:6:\"بند\";s:22:\"lang_addhicont_confirm\";s:10:\"تأكيد\";s:13:\"lang_adfp_add\";s:30:\"إضافة بصمة يدويا\";s:16:\"lang_adfp_fptype\";s:19:\"نوع البصمة\";s:18:\"lang_adfp_employee\";s:19:\"اسم الموظف\";s:13:\"lang_adfp_day\";s:10:\"اليوم\";s:14:\"lang_adfp_time\";s:10:\"الوقت\";s:11:\"lang_addjop\";s:32:\"اضافة وظيفه جديده\";s:12:\"lang_namejop\";s:18:\"اسم وظيفه \";s:17:\"lang_employeename\";s:21:\"اسم الموظف  \";s:11:\"lang_submit\";s:12:\" تاكيد \";s:21:\"lang_adde_fingerprint\";s:30:\"اضافة بصمه يدويا\";s:18:\"lang_name_joplevel\";s:37:\"اسم المستوي الوظيفي \";s:17:\"lang_add_joplevel\";s:41:\"اضافة المستوي الوظيفي \";s:16:\"lang_add_joprule\";s:29:\"اضافة دور وظيفي \";s:14:\"lang_name_rule\";s:19:\"اسم الدور  \";s:13:\"lang_add_task\";s:20:\"اضافة مهمه \";s:10:\"lang__task\";s:10:\" مهمه \";s:14:\"lang_type_task\";s:19:\"نوع المهمه\";s:12:\"lang__untask\";s:17:\" غير مهمه \";s:11:\"lang_urgent\";s:14:\" عاجله   \";s:13:\"lang_unurgent\";s:21:\" غير عاجله   \";s:17:\"lang_add_new_user\";s:33:\" اضافة متسخدم جديد\";s:17:\"lang_image_upload\";s:19:\"تحميل صوره\";s:12:\"lang_add_new\";s:22:\"اضافة جديده \";s:9:\"lang_edit\";s:12:\" تعديل \";s:16:\"lang_save_powers\";s:27:\" حفظ الصلاحيات \";s:8:\"lang_add\";s:12:\" اضافه \";s:11:\"lang_delete\";s:8:\" حذف \";s:9:\"lang_show\";s:8:\" عرض \";s:13:\"lang_validity\";s:18:\" الصلاحيه \";s:20:\"lang_customer_powers\";s:31:\" صلاحيات العملاء \";s:20:\"lang_visiting_powers\";s:33:\" صلاحيات الزيارات \";s:21:\"lang_request_not_read\";s:40:\" الطلبات الغير مقروءه \";s:14:\"lang_All_basma\";s:18:\" البصمات   \";s:15:\"lang_orders_new\";s:15:\"طلب جديد\";s:25:\"lang__regularleve_request\";s:34:\"طلب أجازة اعتيادية\";s:22:\"lang_Sickleave_request\";s:28:\"طلب أجازة مرضيه\";s:24:\"lang_annualleave_request\";s:36:\"طلب الاجازة السنوية\";s:27:\"lang_Earlydeparture_request\";s:28:\"طلب انصراف مبكر\";s:27:\"lang_Permission_to_latework\";s:34:\" إذن تأخير عن العمل\";s:15:\"lang_all_orders\";s:23:\" كل الطلبات   \";s:14:\"lang_editOrder\";s:24:\"  تعديل الطلب \";s:15:\"lang_vacansyday\";s:24:\"ايام العطلات \";s:16:\"lang_arrangement\";s:16:\" الترتيب \";s:11:\"lang_shifts\";s:18:\" الورديات \";s:13:\"lang_addshift\";s:23:\" اضافة ورديه \";s:14:\"lang_infoshift\";s:27:\" معلومات ورديه \";s:20:\"lang_addshift_gender\";s:10:\"النوع\";s:12:\"lang_workday\";s:19:\"ايام العمل\";s:21:\"lang_Attendance_rules\";s:24:\"قواعد الحضور \";s:15:\"lang_startshift\";s:27:\" بداية الورديه \";s:13:\"lang_endshift\";s:27:\" نهاية الورديه \";s:21:\"lang_start_attendance\";s:34:\" بداية معاد الحضور \";s:19:\"lang_end_attendance\";s:34:\" نهاية معاد الحضور \";s:23:\"lang_end_dismissal_date\";s:38:\" نهاية معاد الانصراف \";s:25:\"lang_start_dismissal_date\";s:38:\" بداية معاد الانصراف \";s:14:\"lang_late_time\";s:24:\" وقت التاخير  \";s:17:\"lang_plholder_jop\";s:30:\"اكتب اسم الوظيفة\";s:20:\"lang_plholder_joplvl\";s:38:\"اكتب المستوي الوظيفي\";s:21:\"lang_plholder_joprule\";s:34:\"اكتب الدور الوظيفي\";s:18:\"lang_pbholder_name\";s:19:\"أدخل الاسم\";s:19:\"lang_pbholder_phone\";s:28:\"أدخل رقم الهاتف\";s:19:\"lang_pbholder_email\";s:42:\"أدخل البريد الإلكتروني\";s:18:\"lang_pbholder_file\";s:15:\"اختر ملف\";s:21:\"lang_pbholder_refname\";s:17:\"اسم مرجعي\";s:20:\"lang_pbholder_jopdes\";s:21:\"وصف الوظيفة\";s:20:\"lang_pbholder_amount\";s:27:\"مبلغ الاتفاقية\";s:23:\"lang_pbholder_startdate\";s:21:\"بداية العقد\";s:21:\"lang_pbholder_enddate\";s:21:\"نهاية العقد\";s:23:\"lang_pbholder_workhours\";s:21:\"ساعات العمل\";s:18:\"lang_pbholder_whuo\";s:39:\"ساعات العمل تحت الطلب\";s:18:\"lang_pbholder_holi\";s:32:\"عدد أيام الأجازات\";s:18:\"lang_pbholder_info\";s:14:\"معلومات\";s:18:\"lang_pbholder_user\";s:16:\"المستخدم\";s:18:\"lang_pbholder_rule\";s:13:\"بند رقم\";s:20:\"lang_pbholder_salary\";s:12:\"المرتب\";s:19:\"lang_pbholder_raise\";s:14:\"الزيادة\";s:20:\"lang_pbholder_client\";s:12:\"العميل\";s:21:\"lang_pbholder_typetsk\";s:21:\"اكتب المهمة\";s:19:\"lang_pbholder_uname\";s:32:\"اكتب اسم المستخدم\";s:22:\"lang_pbholder_password\";s:26:\"اكتب كلمة السر\";s:21:\"lang_pbholder_address\";s:23:\"أدخل العنوان\";s:21:\"lang_pbholder_basmaid\";s:22:\"أدخل رقم فقط\";s:21:\"lang_Permission_Leave\";s:37:\"معلومات اذن الاجازه \";s:14:\"lang_addsh_sat\";s:10:\"السبت\";s:14:\"lang_addsh_sun\";s:10:\"الأحد\";s:14:\"lang_addsh_mon\";s:14:\"الإثنين\";s:14:\"lang_addsh_tue\";s:16:\"الثلاثاء\";s:14:\"lang_addsh_wed\";s:16:\"الأربعاء\";s:14:\"lang_addsh_thu\";s:12:\"الخميس\";s:14:\"lang_addsh_fri\";s:12:\"الجمعه\";s:16:\"lang_addsh_start\";s:25:\"بداية الوردية\";s:14:\"lang_addsh_end\";s:25:\"نهاية الوردية\";s:19:\"lang_addsh_stardatt\";s:30:\"بداية وقت الحضور\";s:17:\"lang_addsh_endatt\";s:30:\"نهاية وقت الحضور\";s:19:\"lang_addsh_startout\";s:34:\"بداية وقت الانصراف\";s:17:\"lang_addsh_endout\";s:34:\"نهاية وقت الانصراف\";s:22:\"lang_addsh_delaylimits\";s:23:\"حدود التأخير\";s:22:\"lang_addsh_earlylimits\";s:23:\"حدود التبكير\";s:26:\"lang_addemployee_basmaname\";s:28:\"الاسم في اليصمه\";s:16:\"lang_depart_edit\";s:21:\"تعديل القسم\";s:19:\"lang_depart_depname\";s:26:\"اكتب اسم القسم\";s:12:\"lang_jopedit\";s:25:\"تعديل الوظيفة\";s:15:\"lang_joplvledit\";s:40:\"تعديل المستوى الوظيفي\";s:14:\"lang_drugindex\";s:23:\"جدول الادوية\";s:8:\"lang_qty\";s:12:\"الكمية\";}',1772892395),('laravel-cache-system_settings','a:31:{s:2:\"id\";i:1;s:12:\"company_name\";s:11:\"FOCUS HOUSE\";s:11:\"company_add\";s:54:\"سمنود - برج زايد - الدور الخامس\";s:13:\"company_email\";s:26:\"abdelhadeeladawy@gmail.com\";s:11:\"company_tel\";s:12:\"010053662038\";s:9:\"edit_pass\";s:3:\"125\";s:3:\"lic\";s:65:\"d35c99e7485691ea14f829029dc03e69A67b8d2f92148f52cad46e331936922e8\";s:10:\"updateline\";s:0:\"\";s:8:\"acc_rent\";i:99;s:9:\"startdate\";s:10:\"2024-01-01\";s:7:\"enddate\";s:10:\"2024-12-31\";s:4:\"lang\";s:2:\"ar\";s:9:\"bodycolor\";s:7:\"#f0f0f0\";s:6:\"showhr\";i:1;s:9:\"showclinc\";i:1;s:7:\"showatt\";i:1;s:11:\"showpayroll\";i:1;s:8:\"showrent\";i:1;s:7:\"showpay\";i:1;s:7:\"showtsk\";i:1;s:14:\"def_pos_client\";i:155;s:13:\"def_pos_store\";i:27;s:16:\"def_pos_employee\";i:131;s:12:\"def_pos_fund\";i:21;s:9:\"isdeleted\";i:0;s:6:\"tenant\";i:0;s:6:\"branch\";i:0;s:4:\"logo\";N;s:14:\"show_all_tasks\";N;s:10:\"created_at\";N;s:10:\"updated_at\";s:19:\"2026-03-07 13:47:00\";}',1772889095),('laravel-cache-user_data_1','a:20:{s:2:\"id\";i:1;s:5:\"uname\";s:5:\"admin\";s:8:\"password\";s:60:\"$2y$10$evySEvXqssqflRswKtuxP.cnpLjJaDrFwXbiXYNdeD8IR1VIHwlUa\";s:6:\"crtime\";s:19:\"2022-12-05 15:01:33\";s:9:\"isdeleted\";i:0;s:8:\"usertype\";i:2;s:8:\"userrole\";i:1;s:3:\"img\";s:12:\"22947314.png\";s:10:\"def_client\";N;s:8:\"def_fund\";N;s:9:\"def_store\";N;s:8:\"def_prod\";N;s:7:\"def_emp\";N;s:10:\"tasksindex\";N;s:8:\"tasksadd\";i:1;s:9:\"tasksedit\";N;s:6:\"tenant\";i:0;s:6:\"branch\";i:0;s:10:\"created_at\";N;s:10:\"updated_at\";N;}',1772889095),('laravel-cache-user_role_1','a:0:{}',1772889095);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calls`
--

DROP TABLE IF EXISTS `calls`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calls` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) DEFAULT NULL,
  `call_type` tinyint(1) DEFAULT 1,
  `call_date` date DEFAULT NULL,
  `call_time` time DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `client_id` int(11) DEFAULT 1,
  `emp_comment` varchar(250) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `next_date` date DEFAULT NULL,
  `next_time` time DEFAULT NULL,
  `mod_comment` varchar(250) DEFAULT NULL,
  `mod_rate` tinyint(1) DEFAULT 5,
  `user_id` int(11) DEFAULT 1,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calls`
--

LOCK TABLES `calls` WRITE;
/*!40000 ALTER TABLE `calls` DISABLE KEYS */;
/*!40000 ALTER TABLE `calls` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cases`
--

DROP TABLE IF EXISTS `cases`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cases` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cases`
--

LOCK TABLES `cases` WRITE;
/*!40000 ALTER TABLE `cases` DISABLE KEYS */;
/*!40000 ALTER TABLE `cases` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chances`
--

DROP TABLE IF EXISTS `chances`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chances` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client` varchar(50) DEFAULT NULL,
  `cname` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `cdate` date DEFAULT NULL,
  `important` tinyint(1) DEFAULT NULL,
  `expected` decimal(10,2) DEFAULT 0.00,
  `tybe` int(11) DEFAULT 1,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chances`
--

LOCK TABLES `chances` WRITE;
/*!40000 ALTER TABLE `chances` DISABLE KEYS */;
/*!40000 ALTER TABLE `chances` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chances_tybes`
--

DROP TABLE IF EXISTS `chances_tybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chances_tybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `info` varchar(50) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chances_tybes`
--

LOCK TABLES `chances_tybes` WRITE;
/*!40000 ALTER TABLE `chances_tybes` DISABLE KEYS */;
INSERT INTO `chances_tybes` VALUES (1,'جديد',NULL,'2023-11-27 23:20:13',0,0,0,NULL,NULL),(2,'تم الاتفاق',NULL,'2023-11-27 23:27:21',0,0,0,NULL,NULL),(3,'دفع عربون',NULL,'2023-11-27 23:27:21',0,0,0,NULL,NULL),(4,'صفقه تامه',NULL,'2023-11-27 23:27:42',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `chances_tybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `info` varchar(150) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 1,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cities`
--

LOCK TABLES `cities` WRITE;
/*!40000 ALTER TABLE `cities` DISABLE KEYS */;
/*!40000 ALTER TABLE `cities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `clients`
--

DROP TABLE IF EXISTS `clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `phone2` varchar(150) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `address2` varchar(150) DEFAULT NULL,
  `address3` varchar(150) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `height` decimal(8,2) DEFAULT NULL,
  `weight` decimal(8,2) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `ref` varchar(20) DEFAULT NULL,
  `diseses` varchar(200) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `imgs` varchar(250) DEFAULT NULL,
  `jop` varchar(50) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `drugs` varchar(250) DEFAULT NULL,
  `seriousdes` varchar(250) DEFAULT NULL,
  `familydes` varchar(250) DEFAULT NULL,
  `allergy` varchar(250) DEFAULT NULL,
  `temp` varchar(9) DEFAULT NULL,
  `pressure` varchar(9) DEFAULT NULL,
  `diabetes` varchar(9) DEFAULT NULL,
  `brate` varchar(9) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clients`
--

LOCK TABLES `clients` WRITE;
/*!40000 ALTER TABLE `clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `closed_orders`
--

DROP TABLE IF EXISTS `closed_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `closed_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `shift` varchar(10) NOT NULL COMMENT 'رقم الشيفت',
  `user` varchar(10) NOT NULL COMMENT 'اسم المستخدم',
  `date` date DEFAULT NULL COMMENT 'تاريخ الشيفت',
  `strttime` datetime DEFAULT NULL COMMENT 'وقت البداية',
  `endtime` time DEFAULT NULL COMMENT 'وقت الانهاية',
  `total_sales` double NOT NULL DEFAULT 0 COMMENT 'إجمالي المبيعات',
  `delevery` double NOT NULL DEFAULT 0 COMMENT 'مبيعات الدليفري',
  `tables` double NOT NULL DEFAULT 0 COMMENT 'مبيعات الطاولات',
  `takeaway` double NOT NULL DEFAULT 0 COMMENT 'مبيعات التيك أواي',
  `expenses` double NOT NULL DEFAULT 0 COMMENT 'المصاريف',
  `fund_before` double NOT NULL DEFAULT 0 COMMENT 'رصيد الدرج قبل',
  `fund_after` double NOT NULL DEFAULT 0 COMMENT 'رصيد الدرج بعد',
  `exp_notes` varchar(30) DEFAULT NULL COMMENT 'ملاحظات المصاريف',
  `cash` double NOT NULL DEFAULT 0 COMMENT 'المبلغ المسلم',
  `info` varchar(50) DEFAULT NULL COMMENT 'ملاحظات',
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'وقت الإنشاء',
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'وقت التعديل',
  `info2` varchar(20) NOT NULL COMMENT 'معلومات إضافية',
  `tenant` int(11) NOT NULL DEFAULT 1 COMMENT 'المستأجر',
  `branch` int(11) NOT NULL DEFAULT 1 COMMENT 'الفرع',
  PRIMARY KEY (`id`),
  KEY `closed_orders_date_index` (`date`),
  KEY `closed_orders_user_index` (`user`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `closed_orders`
--

LOCK TABLES `closed_orders` WRITE;
/*!40000 ALTER TABLE `closed_orders` DISABLE KEYS */;
INSERT INTO `closed_orders` VALUES (1,'20260221_','Unknown','2026-02-21',NULL,'11:17:00',0,0,0,0,0,0,0,'إغلاق تلقائي',0,'إغلاق شيفت تلقائي - عدد الطلبات: 0','2026-02-21 11:17:00','2026-02-21 11:17:00','auto_close',1,1);
/*!40000 ALTER TABLE `closed_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cost_centers`
--

DROP TABLE IF EXISTS `cost_centers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cost_centers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cost_centers`
--

LOCK TABLES `cost_centers` WRITE;
/*!40000 ALTER TABLE `cost_centers` DISABLE KEYS */;
INSERT INTO `cost_centers` VALUES (1,'المركز الافتراضي',NULL,'2024-01-18 23:17:02','2024-01-18 23:17:02',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `cost_centers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criminals`
--

DROP TABLE IF EXISTS `criminals`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criminals` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `dateofbirth` date DEFAULT NULL,
  `jop` varchar(255) DEFAULT NULL,
  `station` varchar(111) DEFAULT NULL,
  `mname` varchar(255) DEFAULT NULL,
  `crmaddress` varchar(255) DEFAULT NULL,
  `idcardnum` varchar(255) DEFAULT NULL,
  `scar` int(11) DEFAULT NULL,
  `otherdetails` varchar(255) DEFAULT NULL,
  `prtnrs` varchar(255) DEFAULT NULL,
  `crmstyle` int(11) DEFAULT NULL,
  `dngrs` int(11) DEFAULT NULL,
  `fesh` int(11) DEFAULT NULL,
  `karta` int(11) DEFAULT NULL,
  `entry` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criminals`
--

LOCK TABLES `criminals` WRITE;
/*!40000 ALTER TABLE `criminals` DISABLE KEYS */;
/*!40000 ALTER TABLE `criminals` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_activities`
--

DROP TABLE IF EXISTS `crm_activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `type_id` bigint(20) unsigned NOT NULL,
  `related_to` varchar(255) NOT NULL,
  `related_id` bigint(20) unsigned NOT NULL,
  `activity_date` datetime NOT NULL,
  `duration` int(11) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `status` enum('planned','completed','cancelled') NOT NULL DEFAULT 'planned',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_activities_type_id_foreign` (`type_id`),
  CONSTRAINT `crm_activities_type_id_foreign` FOREIGN KEY (`type_id`) REFERENCES `crm_activity_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_activities`
--

LOCK TABLES `crm_activities` WRITE;
/*!40000 ALTER TABLE `crm_activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `crm_activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_activity_types`
--

DROP TABLE IF EXISTS `crm_activity_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_activity_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_activity_types`
--

LOCK TABLES `crm_activity_types` WRITE;
/*!40000 ALTER TABLE `crm_activity_types` DISABLE KEYS */;
INSERT INTO `crm_activity_types` VALUES (1,'مكالمة هاتفية','phone','2026-02-28 09:24:47','2026-02-28 09:24:47'),(2,'اجتماع','calendar','2026-02-28 09:24:47','2026-02-28 09:24:47'),(3,'بريد إلكتروني','mail','2026-02-28 09:24:47','2026-02-28 09:24:47'),(4,'مهمة','check','2026-02-28 09:24:47','2026-02-28 09:24:47'),(5,'عرض تقديمي','presentation','2026-02-28 09:24:47','2026-02-28 09:24:47');
/*!40000 ALTER TABLE `crm_activity_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_contacts`
--

DROP TABLE IF EXISTS `crm_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_contacts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_contacts`
--

LOCK TABLES `crm_contacts` WRITE;
/*!40000 ALTER TABLE `crm_contacts` DISABLE KEYS */;
INSERT INTO `crm_contacts` VALUES (1,'ققققققققق','fasiqanyno@mailinator.com','+1 (657) 279-8939','Quis dolor voluptatu','Underwood Stone Plc','Nam ullam sed deseru','Voluptates deserunt','Sunt porro asperiore','2026-02-28 09:38:29','2026-02-28 09:38:48');
/*!40000 ALTER TABLE `crm_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_lead_sources`
--

DROP TABLE IF EXISTS `crm_lead_sources`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_lead_sources` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_lead_sources`
--

LOCK TABLES `crm_lead_sources` WRITE;
/*!40000 ALTER TABLE `crm_lead_sources` DISABLE KEYS */;
INSERT INTO `crm_lead_sources` VALUES (1,'موقع الويب','عملاء من الموقع الإلكتروني','2026-02-28 09:10:45','2026-02-28 09:10:45'),(2,'وسائل التواصل الاجتماعي','عملاء من منصات التواصل','2026-02-28 09:10:45','2026-02-28 09:10:45'),(3,'إحالة','عملاء من إحالات','2026-02-28 09:10:45','2026-02-28 09:10:45'),(4,'معرض','عملاء من المعارض','2026-02-28 09:10:45','2026-02-28 09:10:45'),(5,'اتصال مباشر','عملاء من الاتصال المباشر','2026-02-28 09:10:45','2026-02-28 09:10:45');
/*!40000 ALTER TABLE `crm_lead_sources` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_lead_statuses`
--

DROP TABLE IF EXISTS `crm_lead_statuses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_lead_statuses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL DEFAULT '#3b82f6',
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_lead_statuses`
--

LOCK TABLES `crm_lead_statuses` WRITE;
/*!40000 ALTER TABLE `crm_lead_statuses` DISABLE KEYS */;
INSERT INTO `crm_lead_statuses` VALUES (1,'جديد','#3b82f6',1,'2026-02-28 09:15:58','2026-02-28 09:15:58'),(2,'تم الاتصال','#8b5cf6',2,'2026-02-28 09:15:58','2026-02-28 09:15:58'),(3,'مؤهل','#10b981',3,'2026-02-28 09:15:58','2026-02-28 09:15:58'),(4,'غير مهتم','#ef4444',4,'2026-02-28 09:15:58','2026-02-28 09:15:58'),(5,'تم التحويل','#059669',5,'2026-02-28 09:15:58','2026-02-28 09:15:58');
/*!40000 ALTER TABLE `crm_lead_statuses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_leads`
--

DROP TABLE IF EXISTS `crm_leads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_leads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `source_id` bigint(20) unsigned NOT NULL,
  `status_id` bigint(20) unsigned NOT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_leads_source_id_foreign` (`source_id`),
  KEY `crm_leads_status_id_foreign` (`status_id`),
  CONSTRAINT `crm_leads_source_id_foreign` FOREIGN KEY (`source_id`) REFERENCES `crm_lead_sources` (`id`) ON DELETE CASCADE,
  CONSTRAINT `crm_leads_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `crm_lead_statuses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_leads`
--

LOCK TABLES `crm_leads` WRITE;
/*!40000 ALTER TABLE `crm_leads` DISABLE KEYS */;
INSERT INTO `crm_leads` VALUES (1,'Phelan Figueroa','dubymigosu@mailinator.com','+1 (109) 229-4713','Hines Blake Plc',4,1,'Nobis nobis sequi eu','2026-02-28 09:27:23','2026-02-28 09:27:23');
/*!40000 ALTER TABLE `crm_leads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_opportunities`
--

DROP TABLE IF EXISTS `crm_opportunities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_opportunities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `lead_id` bigint(20) unsigned NOT NULL,
  `stage_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `probability` int(11) NOT NULL DEFAULT 0,
  `expected_close_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `crm_opportunities_lead_id_foreign` (`lead_id`),
  KEY `crm_opportunities_stage_id_foreign` (`stage_id`),
  CONSTRAINT `crm_opportunities_lead_id_foreign` FOREIGN KEY (`lead_id`) REFERENCES `crm_leads` (`id`) ON DELETE CASCADE,
  CONSTRAINT `crm_opportunities_stage_id_foreign` FOREIGN KEY (`stage_id`) REFERENCES `crm_opportunity_stages` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_opportunities`
--

LOCK TABLES `crm_opportunities` WRITE;
/*!40000 ALTER TABLE `crm_opportunities` DISABLE KEYS */;
INSERT INTO `crm_opportunities` VALUES (1,'Reprehenderit archi',1,3,45.00,12,'2019-02-05','At voluptatum rem vo','2026-02-28 10:01:48','2026-02-28 10:01:48'),(2,'Ea esse vel laboris',1,5,23.00,17,'2026-03-03','Molestias consequunt','2026-02-28 12:51:44','2026-02-28 12:51:44');
/*!40000 ALTER TABLE `crm_opportunities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_opportunity_stages`
--

DROP TABLE IF EXISTS `crm_opportunity_stages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_opportunity_stages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `probability` int(11) NOT NULL DEFAULT 0,
  `order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_opportunity_stages`
--

LOCK TABLES `crm_opportunity_stages` WRITE;
/*!40000 ALTER TABLE `crm_opportunity_stages` DISABLE KEYS */;
INSERT INTO `crm_opportunity_stages` VALUES (1,'تأهيل',10,1,'2026-02-28 09:23:19','2026-02-28 09:23:19'),(2,'تحليل الاحتياجات',25,2,'2026-02-28 09:23:19','2026-02-28 09:23:19'),(3,'عرض السعر',50,3,'2026-02-28 09:23:19','2026-02-28 09:23:19'),(4,'تفاوض',75,4,'2026-02-28 09:23:19','2026-02-28 09:23:19'),(5,'إغلاق ناجح',100,5,'2026-02-28 09:23:19','2026-02-28 09:23:19'),(6,'خسارة',0,6,'2026-02-28 09:23:19','2026-02-28 09:23:19');
/*!40000 ALTER TABLE `crm_opportunity_stages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `crm_style`
--

DROP TABLE IF EXISTS `crm_style`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `crm_style` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `crm_style`
--

LOCK TABLES `crm_style` WRITE;
/*!40000 ALTER TABLE `crm_style` DISABLE KEYS */;
/*!40000 ALTER TABLE `crm_style` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ctp`
--

DROP TABLE IF EXISTS `ctp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ctp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `type` varchar(100) DEFAULT NULL,
  `number` varchar(100) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ctp`
--

LOCK TABLES `ctp` WRITE;
/*!40000 ALTER TABLE `ctp` DISABLE KEYS */;
/*!40000 ALTER TABLE `ctp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cvs`
--

DROP TABLE IF EXISTS `cvs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cvs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `userid` tinyint(1) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) DEFAULT NULL,
  `degree` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `exp1` varchar(250) DEFAULT NULL,
  `exp2` varchar(250) DEFAULT NULL,
  `exp3` varchar(250) DEFAULT NULL,
  `lastsalary` varchar(255) DEFAULT NULL,
  `expsalary` varchar(255) DEFAULT '0',
  `referances` text DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cvs`
--

LOCK TABLES `cvs` WRITE;
/*!40000 ALTER TABLE `cvs` DISABLE KEYS */;
/*!40000 ALTER TABLE `cvs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `delivery_clients`
--

DROP TABLE IF EXISTS `delivery_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `delivery_clients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `delivery_clients`
--

LOCK TABLES `delivery_clients` WRITE;
/*!40000 ALTER TABLE `delivery_clients` DISABLE KEYS */;
/*!40000 ALTER TABLE `delivery_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'المبيعات','قسم المبيعات','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(2,'المحاسبة','قسم المحاسبة','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(3,'الإدارة','قسم الإدارة','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(4,'الدعم الفني','قسم الدعم الفني','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(5,'المبيعات','قسم المبيعات','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(6,'المحاسبة','قسم المحاسبة','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(7,'الإدارة','قسم الإدارة','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(8,'الدعم الفني','قسم الدعم الفني','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(9,'قسم','ببببووووووووووو','2026-02-25 12:39:14',0,0,0,'2026-02-25 12:37:25','2026-02-25 12:39:14');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `drugs`
--

DROP TABLE IF EXISTS `drugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `drugs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `purpose` varchar(200) DEFAULT NULL,
  `effectivematerial` varchar(200) DEFAULT NULL,
  `sideeffects` text DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 1,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `drugs`
--

LOCK TABLES `drugs` WRITE;
/*!40000 ALTER TABLE `drugs` DISABLE KEYS */;
/*!40000 ALTER TABLE `drugs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emp_allowences`
--

DROP TABLE IF EXISTS `emp_allowences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emp_allowences` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empid` int(11) DEFAULT NULL,
  `allowid` int(11) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `info` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emp_allowences`
--

LOCK TABLES `emp_allowences` WRITE;
/*!40000 ALTER TABLE `emp_allowences` DISABLE KEYS */;
/*!40000 ALTER TABLE `emp_allowences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emp_kbis`
--

DROP TABLE IF EXISTS `emp_kbis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emp_kbis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `emp_id` int(11) DEFAULT NULL,
  `kbi_id` int(11) DEFAULT NULL,
  `kbi_weight` decimal(10,2) DEFAULT NULL,
  `kbi_rate` decimal(10,2) DEFAULT NULL,
  `kbi_sum` decimal(10,2) DEFAULT NULL,
  `user` int(11) DEFAULT 1,
  `crtime` datetime DEFAULT current_timestamp(),
  `mdtime` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` tinyint(1) DEFAULT 0,
  `branch` tinyint(1) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emp_kbis`
--

LOCK TABLES `emp_kbis` WRITE;
/*!40000 ALTER TABLE `emp_kbis` DISABLE KEYS */;
/*!40000 ALTER TABLE `emp_kbis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emplog`
--

DROP TABLE IF EXISTS `emplog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emplog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `employee` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `chkin` time DEFAULT NULL,
  `chkout` time DEFAULT NULL,
  `addin` time DEFAULT NULL,
  `addout` time DEFAULT NULL,
  `latecost` decimal(8,2) DEFAULT NULL,
  `earlcost` decimal(8,2) DEFAULT NULL,
  `absent` int(11) DEFAULT NULL,
  `holiday` int(11) DEFAULT NULL,
  `deducation` decimal(8,2) DEFAULT NULL,
  `additional` decimal(8,2) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emplog`
--

LOCK TABLES `emplog` WRITE;
/*!40000 ALTER TABLE `emplog` DISABLE KEYS */;
/*!40000 ALTER TABLE `emplog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `basma_id` int(11) DEFAULT NULL,
  `basma_name` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `imgs` varchar(250) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `dateofbirth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `address2` varchar(250) DEFAULT NULL,
  `town` int(11) DEFAULT NULL,
  `jop` int(11) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `joptybe` int(11) DEFAULT NULL,
  `joplevel` int(11) DEFAULT NULL,
  `dateofhire` date DEFAULT NULL,
  `dateofend` date DEFAULT NULL,
  `shift` int(11) DEFAULT NULL,
  `vacancy` int(11) DEFAULT NULL,
  `holiday` int(11) DEFAULT NULL,
  `salary` decimal(11,2) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `education` varchar(100) DEFAULT NULL,
  `skills` varchar(200) DEFAULT NULL,
  `hour_extra` decimal(10,2) DEFAULT 0.00,
  `day_extra` decimal(10,2) DEFAULT 0.00,
  `ent_tybe` int(11) DEFAULT 1,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES (1,1,'Craig Levy','Claudia Kidd','Amet consectetur r','2026-02-23 14:42:54',NULL,'dexekot@mailinator.com','+1 (277) 718-4109',0,'1981-01-30','0',NULL,'Rerum officia tempor','A deserunt neque qui',3,3,7,1,4,'1981-04-22','1992-07-28',2,NULL,NULL,10000.00,'15',NULL,NULL,39.00,6.00,NULL,1,0,0,'2026-02-23 12:42:54','2026-02-25 10:10:52'),(2,2,'Blaze Glover','Kato Morales','Est beatae vel magn','2026-02-23 14:43:21',NULL,'zupy@mailinator.com','+1 (479) 841-8763',0,'2024-12-13','1',NULL,'Laboriosam commodo','Possimus in quos co',2,3,6,3,4,'2011-04-24','1985-02-26',3,NULL,NULL,22.00,'Pa$$w0rd!',NULL,NULL,89.00,3.00,NULL,1,0,0,'2026-02-23 12:43:21','2026-02-25 10:11:06'),(3,1,'Danielle Harrell','Yoko Neal','Consequatur nostrud','2026-02-25 10:31:48',NULL,'jekole@mailinator.com','+1 (624) 985-2613',0,'1981-10-25','0',NULL,'Aut irure quod volup','Voluptas neque volup',1,2,6,1,3,'2024-09-11','1972-07-15',2,NULL,NULL,1500.00,'Pa$$w0rd!',NULL,NULL,61.00,21.00,NULL,0,0,0,'2026-02-25 10:31:48','2026-02-25 10:31:48'),(4,3,'Lawrence Dennis','Galena Patel','In neque enim pariat','2026-02-25 10:40:01',NULL,'tupibyxa@mailinator.com','+1 (388) 893-4758',0,'2006-06-04','1',NULL,'Cupiditate nulla iur','Enim sunt voluptates',3,9,3,1,3,'2009-04-18','1986-07-24',1,NULL,NULL,2000.00,'Pa$$w0rd!',NULL,NULL,55.00,1.00,NULL,1,0,0,'2026-02-25 10:40:01','2026-02-25 10:43:52');
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entitles`
--

DROP TABLE IF EXISTS `entitles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entitles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tybe` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entitles`
--

LOCK TABLES `entitles` WRITE;
/*!40000 ALTER TABLE `entitles` DISABLE KEYS */;
/*!40000 ALTER TABLE `entitles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extras`
--

DROP TABLE IF EXISTS `extras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `extras` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empid` int(11) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `val` decimal(10,2) DEFAULT NULL,
  `tybe` int(11) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extras`
--

LOCK TABLES `extras` WRITE;
/*!40000 ALTER TABLE `extras` DISABLE KEYS */;
/*!40000 ALTER TABLE `extras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_details`
--

DROP TABLE IF EXISTS `fat_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fat_id` bigint(20) unsigned NOT NULL COMMENT 'معرف الطلب',
  `item_id` bigint(20) unsigned NOT NULL COMMENT 'معرف الصنف',
  `quantity` double NOT NULL DEFAULT 1 COMMENT 'الكمية',
  `price` double NOT NULL DEFAULT 0 COMMENT 'السعر',
  `total` double NOT NULL DEFAULT 0 COMMENT 'الإجمالي',
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'وقت الإنشاء',
  PRIMARY KEY (`id`),
  KEY `fat_details_fat_id_index` (`fat_id`),
  KEY `fat_details_item_id_index` (`item_id`),
  CONSTRAINT `fat_details_fat_id_foreign` FOREIGN KEY (`fat_id`) REFERENCES `ot_head` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_details`
--

LOCK TABLES `fat_details` WRITE;
/*!40000 ALTER TABLE `fat_details` DISABLE KEYS */;
INSERT INTO `fat_details` VALUES (3,3,1,740,100,74000,'2026-02-15 11:22:18'),(5,5,1,151,100,15100,'2026-02-15 12:39:44'),(6,6,1,100,100,10000,'2026-02-15 13:16:00'),(7,7,1,11,100,1100,'2026-02-15 13:16:25'),(8,8,1,294,100,29400,'2026-02-15 13:18:21'),(9,9,1,578,100,57800,'2026-02-15 13:26:20'),(10,10,1,758,100,75800,'2026-02-15 16:40:30'),(11,2,1,182,100,17472,'2026-02-15 19:41:31'),(12,1,1,823,100,66663,'2026-02-15 19:44:00'),(14,12,1,444,100,34188,'2026-02-15 19:51:38'),(16,13,1,318,100,13038,'2026-02-15 20:06:56'),(18,14,1,8,100,248,'2026-02-15 21:00:42'),(19,15,2,58,11,-116,'2026-02-16 13:18:54'),(25,19,3,791,50,18984,'2026-02-17 11:30:56'),(26,20,1,2,130,260,'2026-02-17 11:33:20'),(27,20,2,1,20,20,'2026-02-17 11:33:20'),(28,21,1,2,130,260,'2026-02-17 13:46:17'),(29,21,2,3,20,60,'2026-02-17 13:46:17'),(31,22,3,1125,50,56250,'2026-02-18 10:21:46'),(32,23,2,2,20,40,'2026-02-18 13:12:23'),(33,23,3,2,60,120,'2026-02-18 13:12:23'),(34,23,1,1,130,130,'2026-02-18 13:12:23'),(35,24,2,1,20,20,'2026-02-18 13:12:56'),(36,24,3,1,60,60,'2026-02-18 13:12:56'),(37,24,1,1,130,130,'2026-02-18 13:12:56'),(38,16,1,2,130,260,'2026-02-18 13:24:22'),(39,16,2,2,20,40,'2026-02-18 13:24:22'),(40,16,3,2,60,120,'2026-02-18 13:24:22'),(41,16,1,1,130,130,'2026-02-18 13:24:22'),(42,17,1,2,130,260,'2026-02-18 13:28:34'),(43,18,1,1,130,130,'2026-02-18 13:34:20'),(44,18,3,2,60,120,'2026-02-18 13:34:20'),(45,25,3,2,60,120,'2026-02-21 10:55:11'),(46,25,2,1,20,20,'2026-02-21 10:55:11'),(47,26,2,16,20,320,'2026-02-21 10:55:42'),(48,27,2,2,20,40,'2026-02-21 12:04:39'),(49,27,3,1,60,60,'2026-02-21 12:04:39'),(50,28,1,4,130,520,'2026-02-21 12:31:32'),(51,29,1,2,130,260,'2026-02-23 06:51:39'),(52,29,3,1,60,60,'2026-02-23 06:51:39'),(53,29,2,1,20,20,'2026-02-23 06:51:39'),(54,30,3,2,60,120,'2026-02-23 06:52:11'),(55,30,2,19,20,380,'2026-02-23 06:52:11'),(56,31,2,1,20,20,'2026-02-23 07:06:52'),(57,31,3,1,60,60,'2026-02-23 07:06:52'),(58,31,1,1,130,130,'2026-02-23 07:06:52'),(59,32,1,2,130,260,'2026-02-23 08:12:14'),(60,32,3,2,60,120,'2026-02-23 08:12:14'),(61,32,2,1,20,20,'2026-02-23 08:12:14'),(62,33,3,2,60,120,'2026-02-23 12:51:06'),(63,34,2,3,20,60,'2026-02-24 07:59:09'),(64,34,3,1,60,60,'2026-02-24 07:59:09'),(65,34,1,2,130,260,'2026-02-24 07:59:09'),(66,35,3,2,60,120,'2026-02-24 08:45:38'),(67,35,1,1,130,130,'2026-02-24 08:45:38'),(68,35,2,5,20,100,'2026-02-24 08:45:38'),(69,36,3,2,60,120,'2026-02-24 11:15:17'),(70,37,1,1,130,130,'2026-02-24 11:16:31'),(71,39,1,2,130,260,'2026-02-24 12:43:18'),(75,42,2,2,20,40,'2026-02-24 13:27:31'),(76,42,3,2,60,120,'2026-02-24 13:27:31'),(77,42,2,2,20,40,'2026-02-24 13:27:31'),(78,44,2,100,11,1100,'2026-02-25 09:12:41'),(81,45,1,2,130,260,'2026-02-25 11:31:36'),(82,45,3,3,60,180,'2026-02-25 11:31:36'),(83,46,1,2,130,260,'2026-02-25 12:05:10'),(84,47,3,3,60,180,'2026-02-28 11:11:56'),(85,48,4,100,0,0,'2026-02-28 14:43:41'),(86,49,1,2,130,260,'2026-03-01 11:37:06'),(87,49,4,1,60,60,'2026-03-01 11:37:06'),(88,49,2,1,20,20,'2026-03-01 11:37:06'),(89,50,5,10,17,170,'2026-03-01 12:00:27'),(94,51,4,1,60,60,'2026-03-01 12:23:24'),(95,51,5,1,20,20,'2026-03-01 12:23:24'),(96,51,1,1,130,130,'2026-03-01 12:23:24'),(97,51,3,1,60,60,'2026-03-01 12:23:24'),(98,52,3,2,60,120,'2026-03-01 13:16:55'),(100,54,3,4,50,200,'2026-03-01 15:05:47'),(101,55,6,2,680,1360,'2026-03-01 16:03:29'),(102,55,1,1,130,130,'2026-03-01 16:03:29'),(103,56,1,2,130,260,'2026-03-01 16:04:00'),(107,53,6,50,440,22000,'2026-03-01 18:37:47'),(108,57,5,200,17,3400,'2026-03-01 18:38:24'),(109,58,5,10,17,170,'2026-03-01 18:42:12'),(110,59,5,10,17,170,'2026-03-02 09:08:47'),(111,64,3,2,60,120,'2026-03-02 11:18:14'),(112,64,1,3,130,390,'2026-03-02 11:18:14'),(113,64,5,1,20,20,'2026-03-02 11:18:14'),(114,68,7,18,20,360,'2026-03-02 12:19:13'),(115,69,5,12,17,204,'2026-03-02 12:20:02'),(116,70,5,20,17,340,'2026-03-02 13:22:51'),(117,71,2,2,20,40,'2026-03-02 13:32:24'),(118,71,3,1,60,60,'2026-03-02 13:32:24'),(119,71,6,1,45,45,'2026-03-02 13:32:24'),(120,72,1,2,130,260,'2026-03-02 13:34:37'),(121,75,7,15,20,300,'2026-03-03 08:40:58'),(122,80,6,20,30,600,'2026-03-03 09:01:43'),(123,81,3,9,50,450,'2026-03-03 09:08:25'),(126,84,3,1,50,50,'2026-03-03 09:18:38'),(127,85,6,15,30,450,'2026-03-03 09:56:52'),(128,86,1,100,100,10000,'2026-03-03 10:00:17'),(129,87,1,10,100,900,'2026-03-03 10:04:40'),(130,88,7,20,20,400,'2026-03-03 10:08:29'),(131,89,7,20,20,400,'2026-03-03 10:12:23'),(132,90,1,10,100,1000,'2026-03-03 10:22:51'),(133,91,1,10,100,1000,'2026-03-03 10:50:54'),(134,92,1,10,100,1000,'2026-03-03 11:00:14'),(135,93,6,2,30,60,'2026-03-03 12:04:46'),(136,94,5,4,100,400,'2026-03-03 12:33:41'),(137,95,5,4,100,400,'2026-03-03 12:34:10'),(138,96,7,10,20,200,'2026-03-03 12:41:15'),(139,97,5,2,20,40,'2026-03-07 09:48:30'),(140,97,7,2,40,80,'2026-03-07 09:48:30'),(141,98,2,2,20,40,'2026-03-07 09:49:19'),(142,98,6,1,45,45,'2026-03-07 09:49:19'),(143,99,6,1,30,30,'2026-03-07 09:51:21'),(144,100,3,4,50,200,'2026-03-07 09:59:41');
/*!40000 ALTER TABLE `fat_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fat_tybes`
--

DROP TABLE IF EXISTS `fat_tybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fat_tybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crttime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fat_tybes`
--

LOCK TABLES `fat_tybes` WRITE;
/*!40000 ALTER TABLE `fat_tybes` DISABLE KEYS */;
INSERT INTO `fat_tybes` VALUES (1,'فاتورة مبيعات',NULL,'2024-01-29 14:39:27',0,0,0,NULL,NULL),(2,'فاتورة مشنريات',NULL,'2024-01-29 14:41:22',0,0,0,NULL,NULL),(3,'فاتورة مردود مبيعات',NULL,'2024-03-06 13:25:41',0,0,0,NULL,NULL),(4,'فاتورة مردود مشتريات',NULL,'2024-03-06 13:26:30',0,0,0,NULL,NULL),(5,'اذن تسليم بضاعه',NULL,'2024-03-06 13:26:30',0,0,0,NULL,NULL),(6,'اذن استلام بضاعه',NULL,'2024-03-06 13:26:57',0,0,0,NULL,NULL),(7,'اذن تسليم بضاعه',NULL,'2024-03-06 13:26:57',0,0,0,NULL,NULL),(8,'اذن حجز',NULL,'2024-03-06 13:29:32',0,0,0,NULL,NULL),(9,'امر بيع',NULL,'2024-03-06 13:29:32',0,0,0,NULL,NULL),(10,'امر شراء',NULL,'2024-03-06 13:29:32',0,0,0,NULL,NULL),(11,'فاتورة تصنيع حر',NULL,'2024-03-06 13:29:32',0,0,0,NULL,NULL),(12,'تصنيع نموذجي',NULL,'2024-03-06 13:29:32',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `fat_tybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fats`
--

DROP TABLE IF EXISTS `fats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fats` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fat_id` int(11) DEFAULT NULL,
  `zanka_id` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fats`
--

LOCK TABLES `fats` WRITE;
/*!40000 ALTER TABLE `fats` DISABLE KEYS */;
/*!40000 ALTER TABLE `fats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fptybes`
--

DROP TABLE IF EXISTS `fptybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fptybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fptybes`
--

LOCK TABLES `fptybes` WRITE;
/*!40000 ALTER TABLE `fptybes` DISABLE KEYS */;
INSERT INTO `fptybes` VALUES (1,'حضور','2023-07-31 19:57:14',NULL,0,0,NULL,NULL),(2,'انصراف','2023-07-31 19:57:14',NULL,0,0,NULL,NULL),(3,'حضور اضافي','2023-07-31 19:57:42',NULL,0,0,NULL,NULL),(4,'انصراف اضافي','2023-07-31 19:58:34',NULL,0,0,NULL,NULL),(5,'invalid','2023-08-10 01:45:50',NULL,0,0,NULL,NULL);
/*!40000 ALTER TABLE `fptybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hiringcontracts`
--

DROP TABLE IF EXISTS `hiringcontracts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hiringcontracts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `employee` int(11) DEFAULT NULL,
  `jop` int(11) DEFAULT NULL,
  `jopdescription` varchar(250) DEFAULT NULL,
  `joprule1` text DEFAULT NULL,
  `joprule2` text DEFAULT NULL,
  `joprule3` text DEFAULT NULL,
  `joprule4` text DEFAULT NULL,
  `workhours` int(11) DEFAULT NULL,
  `inorderhours` int(11) DEFAULT NULL,
  `workdaysoff` int(11) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `salaryraise` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `user` int(11) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `startcontract` date DEFAULT NULL,
  `endcontract` date DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hiringcontracts`
--

LOCK TABLES `hiringcontracts` WRITE;
/*!40000 ALTER TABLE `hiringcontracts` DISABLE KEYS */;
/*!40000 ALTER TABLE `hiringcontracts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holidays`
--

DROP TABLE IF EXISTS `holidays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holidays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holidays`
--

LOCK TABLES `holidays` WRITE;
/*!40000 ALTER TABLE `holidays` DISABLE KEYS */;
/*!40000 ALTER TABLE `holidays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imgs`
--

DROP TABLE IF EXISTS `imgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imgs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iname` text DEFAULT NULL,
  `cname` int(11) DEFAULT NULL,
  `itemid` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `clprofile` int(11) DEFAULT NULL,
  `img_date` date DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imgs`
--

LOCK TABLES `imgs` WRITE;
/*!40000 ALTER TABLE `imgs` DISABLE KEYS */;
INSERT INTO `imgs` VALUES (1,'Screenshot 2026-02-16 01040274825.png',NULL,2,NULL,NULL,NULL,'2026-02-16 13:20:05',0,0,0,'2026-02-16 11:20:05',NULL),(2,'Screenshot 2026-03-01 142635276013.png',NULL,6,NULL,NULL,NULL,'2026-03-01 14:05:12',0,0,0,'2026-03-01 14:05:12',NULL),(3,'cheeseCake381613.jpg',NULL,7,NULL,NULL,NULL,'2026-03-02 10:58:10',0,0,0,'2026-03-02 10:58:10',NULL),(4,'cookies12557.jpg',NULL,5,NULL,NULL,NULL,'2026-03-02 12:28:54',0,0,0,'2026-03-02 12:28:54',NULL),(5,'download851989.jpg',NULL,4,NULL,NULL,NULL,'2026-03-02 13:31:43',0,0,0,'2026-03-02 13:31:43',NULL);
/*!40000 ALTER TABLE `imgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `imporfplog`
--

DROP TABLE IF EXISTS `imporfplog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `imporfplog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `basma_id` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `imporfplog`
--

LOCK TABLES `imporfplog` WRITE;
/*!40000 ALTER TABLE `imporfplog` DISABLE KEYS */;
/*!40000 ALTER TABLE `imporfplog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_group`
--

DROP TABLE IF EXISTS `item_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_group` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gname` varchar(255) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `parent` tinyint(1) DEFAULT 0,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_group`
--

LOCK TABLES `item_group` WRITE;
/*!40000 ALTER TABLE `item_group` DISABLE KEYS */;
INSERT INTO `item_group` VALUES (1,'مجموعه 1',NULL,0,'2026-02-14 13:21:31','2026-02-14 13:21:31',0,0,0,0,'2026-02-14 11:21:31','2026-02-14 11:21:31'),(2,'بان كيك',NULL,0,'2026-03-01 14:01:04','2026-03-01 14:01:04',0,0,0,0,'2026-03-01 14:01:04','2026-03-01 14:01:04'),(3,'وافل',NULL,0,'2026-03-01 14:01:36','2026-03-01 14:01:36',0,0,0,0,'2026-03-01 14:01:36','2026-03-01 14:01:36');
/*!40000 ALTER TABLE `item_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_group2`
--

DROP TABLE IF EXISTS `item_group2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_group2` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gname` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_group2`
--

LOCK TABLES `item_group2` WRITE;
/*!40000 ALTER TABLE `item_group2` DISABLE KEYS */;
INSERT INTO `item_group2` VALUES (1,'تصنيف 1',NULL,'2026-02-14 13:22:51','2026-02-14 13:22:51',0,0,0,0,'2026-02-14 11:22:51','2026-02-14 11:22:51');
/*!40000 ALTER TABLE `item_group2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_group3`
--

DROP TABLE IF EXISTS `item_group3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_group3` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `gname` varchar(255) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_group3`
--

LOCK TABLES `item_group3` WRITE;
/*!40000 ALTER TABLE `item_group3` DISABLE KEYS */;
/*!40000 ALTER TABLE `item_group3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_units`
--

DROP TABLE IF EXISTS `item_units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item_units` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `u_val` decimal(10,2) DEFAULT NULL,
  `def_sale` int(11) DEFAULT 0,
  `def_buy` int(11) DEFAULT 0,
  `def_stock` int(11) DEFAULT 0,
  `cost_price` int(11) DEFAULT NULL,
  `price1` decimal(10,2) DEFAULT 0.00,
  `price2` decimal(10,2) DEFAULT 0.00,
  `price3` decimal(10,2) DEFAULT 0.00,
  `price4` decimal(10,3) DEFAULT 0.000,
  `unit_barcode` varchar(255) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_units`
--

LOCK TABLES `item_units` WRITE;
/*!40000 ALTER TABLE `item_units` DISABLE KEYS */;
INSERT INTO `item_units` VALUES (1,1,1,1.00,0,0,0,100,130.00,120.00,110.00,0.000,'1245',0,0,0,'2026-02-14 11:27:29','2026-02-14 11:27:29'),(2,2,2,1.00,0,0,0,11,20.00,16.00,15.00,0.000,'1234',0,0,0,'2026-02-16 11:20:05','2026-02-16 11:20:05'),(3,3,1,1.00,0,0,0,50,60.00,56.00,55.00,0.000,'3',0,0,0,'2026-02-17 11:30:02','2026-02-17 11:30:02'),(4,4,1,1.00,0,0,0,0,60.00,58.00,55.00,0.000,'4',0,0,0,'2026-02-28 14:07:41','2026-03-02 13:31:43'),(5,5,1,1.00,0,0,0,17,20.00,19.00,18.00,0.000,'5',0,0,0,'2026-03-01 11:49:09','2026-03-02 12:28:54'),(6,5,2,1.00,0,0,0,100,200.00,180.00,18.00,0.000,'1892',0,0,0,'2026-03-01 11:49:09','2026-03-02 12:28:54'),(7,6,4,1.00,0,0,0,440,680.00,490.00,300.00,0.000,'Ipsum qui consequun',0,0,0,'2026-03-01 14:05:12','2026-03-01 14:05:12'),(8,6,1,1.00,0,0,0,30,45.00,40.00,38.00,0.000,'15',0,0,0,'2026-03-02 09:21:59','2026-03-02 09:21:59'),(9,7,2,1.00,0,0,0,20,40.00,35.00,30.00,0.000,'Quo veniam ut sed v',0,0,0,'2026-03-02 10:58:10','2026-03-02 10:58:10'),(10,7,1,1.00,0,0,0,20,40.00,35.00,30.00,0.000,'Quo veniam ut sed v',0,0,0,'2026-03-03 08:44:06','2026-03-03 08:44:06');
/*!40000 ALTER TABLE `item_units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joplevels`
--

DROP TABLE IF EXISTS `joplevels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joplevels` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joplevels`
--

LOCK TABLES `joplevels` WRITE;
/*!40000 ALTER TABLE `joplevels` DISABLE KEYS */;
INSERT INTO `joplevels` VALUES (1,'مبتدئ','مستوى مبتدئ','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(2,'متوسط','مستوى متوسط','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(3,'متقدم','مستوى متقدم','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(4,'خبير','مستوى خبير','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18');
/*!40000 ALTER TABLE `joplevels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joprules`
--

DROP TABLE IF EXISTS `joprules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joprules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joprules`
--

LOCK TABLES `joprules` WRITE;
/*!40000 ALTER TABLE `joprules` DISABLE KEYS */;
/*!40000 ALTER TABLE `joprules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jops`
--

DROP TABLE IF EXISTS `jops`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jops` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jops`
--

LOCK TABLES `jops` WRITE;
/*!40000 ALTER TABLE `jops` DISABLE KEYS */;
INSERT INTO `jops` VALUES (1,'موظف مبيعات','موظف مبيعات','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(2,'محاسب','محاسب','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(3,'مدير','مدير','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(4,'موظف استقبال','موظف استقبال','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(5,'فني','فني','2026-02-23 11:35:20',0,0,0,'2026-02-23 09:35:20','2026-02-23 09:35:20'),(6,'موظف مبيعات','موظف مبيعات','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(7,'محاسب','محاسب','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(8,'مدير','مدير','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(9,'موظف استقبال','موظف استقبال','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(10,'فني','فني','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18');
/*!40000 ALTER TABLE `jops` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `joptybes`
--

DROP TABLE IF EXISTS `joptybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `joptybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `joptybes`
--

LOCK TABLES `joptybes` WRITE;
/*!40000 ALTER TABLE `joptybes` DISABLE KEYS */;
INSERT INTO `joptybes` VALUES (1,'دوام كامل','دوام كامل','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(2,'دوام جزئي','دوام جزئي','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(3,'مؤقت','عمل مؤقت','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18');
/*!40000 ALTER TABLE `joptybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_entries`
--

DROP TABLE IF EXISTS `journal_entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_entries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `journal_id` int(11) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `debit` int(11) DEFAULT 0,
  `credit` int(11) DEFAULT 0,
  `tybe` int(11) DEFAULT NULL,
  `info` varchar(150) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `op2` int(11) DEFAULT 0,
  `op_id` int(11) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_entries`
--

LOCK TABLES `journal_entries` WRITE;
/*!40000 ALTER TABLE `journal_entries` DISABLE KEYS */;
INSERT INTO `journal_entries` VALUES (3,4,1008,66,0,0,NULL,'2026-02-24 12:50:42',41,0,0,'2026-02-24 12:50:42',0,0,NULL,NULL),(4,4,1005,0,66,1,NULL,'2026-02-24 12:50:42',41,0,0,'2026-02-24 12:50:42',0,0,NULL,NULL),(5,5,1005,15,0,0,NULL,'2026-02-24 14:12:56',43,0,0,'2026-02-24 14:12:56',0,0,NULL,NULL),(6,5,1009,0,15,1,NULL,'2026-02-24 14:12:56',43,0,0,'2026-02-24 14:12:56',0,0,NULL,NULL),(7,6,1011,100,100,0,NULL,'2026-03-04 11:00:15',0,0,0,'2026-03-04 11:00:15',0,0,'2026-03-04 11:00:15','2026-03-04 11:00:15'),(10,8,1002,12,0,0,NULL,'2026-03-04 12:02:36',0,0,0,'2026-03-04 12:02:36',0,0,'2026-03-04 12:02:36','2026-03-04 12:02:36'),(11,8,1013,0,12,1,NULL,'2026-03-04 12:02:36',0,0,0,'2026-03-04 12:02:36',0,0,'2026-03-04 12:02:36','2026-03-04 12:02:36'),(12,7,1002,100,0,0,NULL,'2026-03-04 12:12:54',0,0,0,'2026-03-04 12:12:54',0,0,'2026-03-04 12:12:54','2026-03-04 12:12:54'),(13,7,1011,0,100,1,NULL,'2026-03-04 12:12:54',0,0,0,'2026-03-04 12:12:54',0,0,'2026-03-04 12:12:54','2026-03-04 12:12:54'),(14,9,1002,120,0,0,NULL,'2026-03-07 09:48:31',0,97,0,'2026-03-07 09:48:31',0,0,NULL,NULL),(15,9,1003,0,120,1,NULL,'2026-03-07 09:48:31',0,97,0,'2026-03-07 09:48:31',0,0,NULL,NULL),(16,10,1016,85,0,0,NULL,'2026-03-07 09:49:19',0,98,0,'2026-03-07 09:49:19',0,0,NULL,NULL),(17,10,1003,0,85,1,NULL,'2026-03-07 09:49:19',0,98,0,'2026-03-07 09:49:19',0,0,NULL,NULL),(18,11,1015,200,0,0,NULL,'2026-03-07 09:59:41',0,100,0,'2026-03-07 09:59:41',0,0,NULL,NULL),(19,11,1012,0,200,1,NULL,'2026-03-07 09:59:41',0,100,0,'2026-03-07 09:59:41',0,0,NULL,NULL);
/*!40000 ALTER TABLE `journal_entries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_heads`
--

DROP TABLE IF EXISTS `journal_heads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_heads` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `journal_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `jdate` date DEFAULT NULL,
  `op_id` int(11) DEFAULT NULL,
  `pro_tybe` int(11) DEFAULT NULL,
  `details` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `op2` int(11) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT NULL,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_heads`
--

LOCK TABLES `journal_heads` WRITE;
/*!40000 ALTER TABLE `journal_heads` DISABLE KEYS */;
INSERT INTO `journal_heads` VALUES (1,1,11.00,'2026-02-18',NULL,NULL,NULL,'2026-02-18 14:26:46',0,0,'2026-02-18 14:26:46',1,0,0,'2026-02-18 12:26:46','2026-02-18 12:26:46'),(4,3,66.00,'2023-12-26',NULL,NULL,'سند مالي _ Sequi distinctio Si','2026-02-24 12:50:42',41,0,'2026-02-24 12:50:42',1,0,0,NULL,NULL),(5,4,15.00,'2026-02-24',NULL,NULL,'سند مالي _ ','2026-02-24 14:12:56',43,1,'2026-03-04 12:13:58',1,0,0,NULL,'2026-03-04 12:13:58'),(6,5,100.00,'2026-03-04',NULL,NULL,NULL,'2026-03-04 11:00:15',0,1,'2026-03-04 11:19:19',1,0,0,'2026-03-04 11:00:15','2026-03-04 11:19:19'),(7,6,100.00,'2026-03-04',NULL,NULL,'تةةةةةةةةةةةةةةةةةةةة','2026-03-04 11:19:06',0,0,'2026-03-04 12:12:54',1,0,0,'2026-03-04 11:19:06','2026-03-04 12:12:54'),(8,7,12.00,'2026-03-04',NULL,NULL,'من ح/ااااا\r\nالي ح/ةةةةةةةةةةة','2026-03-04 12:02:36',0,0,'2026-03-04 12:02:36',1,0,0,'2026-03-04 12:02:36','2026-03-04 12:02:36'),(9,8,120.00,'2026-03-07',97,NULL,'فاتورة POS _ 97','2026-03-07 09:48:30',0,0,'2026-03-07 09:48:30',1,0,0,NULL,NULL),(10,9,85.00,'2026-03-07',98,NULL,'فاتورة POS _ 98','2026-03-07 09:49:19',0,0,'2026-03-07 09:49:19',1,0,0,NULL,NULL),(11,10,200.00,'2026-03-07',100,NULL,'فاتورة مبيعات _ 100','2026-03-07 09:59:41',0,0,'2026-03-07 09:59:41',1,0,0,NULL,NULL);
/*!40000 ALTER TABLE `journal_heads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `journal_tybes`
--

DROP TABLE IF EXISTS `journal_tybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `journal_tybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `journal_id` int(11) DEFAULT NULL,
  `jname` varchar(222) DEFAULT NULL,
  `jtext` varchar(222) DEFAULT NULL,
  `info` varchar(222) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `journal_tybes`
--

LOCK TABLES `journal_tybes` WRITE;
/*!40000 ALTER TABLE `journal_tybes` DISABLE KEYS */;
INSERT INTO `journal_tybes` VALUES (1,1,'purchases','يومية المقبوضات',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL),(2,2,'sales','يومية المدفوعات',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL),(3,3,'Payments','المبيعات',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL),(4,4,'receipts','يومية المشتريات',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL),(5,5,'Accrueds','ايراد مستحق',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL),(6,6,'Accrueds','خصم مكتسب',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL),(7,7,'Accrueds','خصم مسموح به',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL),(8,8,'journal','القيود اليومية',NULL,'2024-03-13 22:34:38','2024-03-13 22:34:38',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `journal_tybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karta`
--

DROP TABLE IF EXISTS `karta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `karta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kname` varchar(255) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karta`
--

LOCK TABLES `karta` WRITE;
/*!40000 ALTER TABLE `karta` DISABLE KEYS */;
/*!40000 ALTER TABLE `karta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kbis`
--

DROP TABLE IF EXISTS `kbis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kbis` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `kname` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `user` int(11) DEFAULT 1,
  `isdeleted` tinyint(1) DEFAULT 0,
  `crtime` datetime DEFAULT current_timestamp(),
  `mdtime` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `ktybe` varchar(100) DEFAULT NULL,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kbis`
--

LOCK TABLES `kbis` WRITE;
/*!40000 ALTER TABLE `kbis` DISABLE KEYS */;
INSERT INTO `kbis` VALUES (1,'معدل الانجاز','المهمات المكتملة/ المهمات الموكلة',1,0,'2024-07-24 20:10:58','2024-07-24 20:25:02','الانتاجية',0,0,NULL,NULL),(2,'معدل العمل الفعلي','وقت العمل الفعلي/وقت العمل',1,0,'2024-07-24 20:24:47','2024-07-24 20:24:47','الانتاجية',0,0,NULL,NULL),(3,'معدل الاخطاء','100% بدون اخطاء  ||    0% اخطاء اكثر من المسموح',1,0,'2024-07-24 20:26:59','2024-07-24 20:26:59','',0,0,NULL,NULL),(4,'معدل جودة المخرجات','يتم التقييم من ادارة الجودة',1,0,'2024-07-24 20:27:55','2024-07-24 20:27:55','الجودة',0,0,NULL,NULL),(5,'معدل الحضور','الحضور بالساعات / الساعات المقررة',1,0,'2024-07-24 20:29:18','2024-07-24 20:29:18','الالتزام',0,0,NULL,NULL),(6,'معدل التطور','احساب المهارات المضافة شهريا',1,0,'2024-07-24 20:30:04','2024-07-24 20:30:04','التطوير',0,0,NULL,NULL),(7,'تقييم الزملاء','يتم من خلال استطلاعات\r\n',1,0,'2024-07-24 20:32:32','2024-07-24 20:32:32','العمل الجماعي',0,0,NULL,NULL),(8,'معدل المشاركة في الاجتماعات','المشاركة / الاجتماعات',1,0,'2024-07-24 20:35:16','2024-07-24 20:35:16','العمل الجماعي',0,0,NULL,NULL),(9,'تقييم القائد','تقييم الفريق للقائد',1,0,'2024-07-24 20:37:33','2024-07-24 20:37:33','المديرين',0,0,NULL,NULL),(10,'نسبه الحقيق للفريق','نسبة تحقيق الاهداف .. لمتخذي القرار',1,0,'2024-07-24 20:38:11','2024-07-24 20:38:11','المديرين',0,0,NULL,NULL),(11,'وقت الاستجابة','يتم عن طريق التغذية العكسية',1,0,'2024-07-24 20:43:24','2024-07-24 20:43:24','خدمة العملاء',0,0,NULL,NULL),(12,'معدل حل المشكلات','المشكلات المحلولة / عدد المشكلات',1,0,'2024-07-24 20:44:03','2024-07-24 20:44:03','خدمة العملاء',0,0,NULL,NULL),(13,'نسبة رضا العميل','العملاء الراضين / عدد عملاء الاستطلاع',1,0,'2024-07-24 20:44:36','2024-07-24 20:44:36','خدمة العملاء',0,0,NULL,NULL),(14,'معدل تقليل التكاليف','تقييم المشرف',1,0,'2024-07-24 20:46:07','2024-07-24 20:46:07','الكفاءة التشغيلية',0,0,NULL,NULL),(15,'استغلال الموارد','تقييم المديرين',1,0,'2024-07-24 20:49:12','2024-07-24 20:49:12','الكفاءة التشغيلية',0,0,NULL,NULL),(16,'عدد الافكار الجديدة المنفذه','عدد الافكار المنفذه / عدد الافكار الجديدة المقدمة',1,0,'2024-07-24 21:03:59','2024-07-24 21:03:59','الابتكار',0,0,NULL,NULL);
/*!40000 ALTER TABLE `kbis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2024_01_01_000001_create_pos_tables',1),(5,'2024_01_01_000002_create_pos_orders_table',1),(6,'2026_01_23_123226_create_acc_groups_table',1),(7,'2026_01_23_123236_create_acc_head_table',1),(8,'2026_01_23_123246_create_allowances_table',1),(9,'2026_01_23_123256_create_analisys_table',1),(10,'2026_01_23_123306_create_attandance_table',1),(11,'2026_01_23_123316_create_attdocs_table',1),(12,'2026_01_23_123326_create_attlog_table',1),(13,'2026_01_23_123336_create_barcodes_table',1),(14,'2026_01_23_123346_create_booking_cards_table',1),(15,'2026_01_23_123356_create_book_tybes_table',1),(16,'2026_01_23_123406_create_calls_table',1),(17,'2026_01_23_123416_create_cases_table',1),(18,'2026_01_23_123426_create_chances_table',1),(19,'2026_01_23_123436_create_chances_tybes_table',1),(20,'2026_01_23_123446_create_cities_table',1),(21,'2026_01_23_123456_create_clients_table',1),(22,'2026_01_23_123516_create_cost_centers_table',1),(23,'2026_01_23_123526_create_criminals_table',1),(24,'2026_01_23_123536_create_crm_style_table',1),(25,'2026_01_23_123546_create_ctp_table',1),(26,'2026_01_23_123556_create_cvs_table',1),(27,'2026_01_23_123606_create_delivery_clients_table',1),(28,'2026_01_23_123616_create_departments_table',1),(29,'2026_01_23_123626_create_drugs_table',1),(30,'2026_01_23_123636_create_emplog_table',1),(31,'2026_01_23_123646_create_employees_table',1),(32,'2026_01_23_123656_create_emp_allowences_table',1),(33,'2026_01_23_123706_create_emp_kbis_table',1),(34,'2026_01_23_123716_create_entitles_table',1),(35,'2026_01_23_123727_create_extras_table',1),(36,'2026_01_23_123737_create_fats_table',1),(37,'2026_01_23_123757_create_fat_tybes_table',1),(38,'2026_01_23_123807_create_fptybes_table',1),(39,'2026_01_23_123817_create_hiringcontracts_table',1),(40,'2026_01_23_123827_create_holidays_table',1),(41,'2026_01_23_123837_create_imgs_table',1),(42,'2026_01_23_123847_create_imporfplog_table',1),(43,'2026_01_23_123857_create_item_group_table',1),(44,'2026_01_23_123907_create_item_group2_table',1),(45,'2026_01_23_123917_create_item_group3_table',1),(46,'2026_01_23_123927_create_item_units_table',1),(47,'2026_01_23_123937_create_joplevels_table',1),(48,'2026_01_23_123947_create_joprules_table',1),(49,'2026_01_23_123957_create_jops_table',1),(50,'2026_01_23_124007_create_joptybes_table',1),(51,'2026_01_23_124017_create_journal_entries_table',1),(52,'2026_01_23_124027_create_journal_heads_table',1),(53,'2026_01_23_124037_create_journal_tybes_table',1),(54,'2026_01_23_124047_create_karta_table',1),(55,'2026_01_23_124057_create_kbis_table',1),(56,'2026_01_23_124107_create_myinstallments_table',1),(57,'2026_01_23_124117_create_myitems_table',1),(58,'2026_01_23_124127_create_myoper_det_table',1),(59,'2026_01_23_124137_create_myoptions_table',1),(60,'2026_01_23_124147_create_mypatterns_table',1),(61,'2026_01_23_124157_create_mypowers_table',1),(62,'2026_01_23_124207_create_myrents_table',1),(63,'2026_01_23_124217_create_myunits_table',1),(64,'2026_01_23_124227_create_myvouchers_table',1),(65,'2026_01_23_124237_create_my_news_table',1),(66,'2026_01_23_124247_create_notes_table',1),(67,'2026_01_23_124257_create_oppatterns_table',1),(68,'2026_01_23_124307_create_orders_table',1),(69,'2026_01_23_124317_create_order_status_table',1),(70,'2026_01_23_124327_create_order_types_table',1),(71,'2026_01_23_124347_create_paper_types_table',1),(72,'2026_01_23_124357_create_patt_cols_table',1),(73,'2026_01_23_124407_create_permits_table',1),(74,'2026_01_23_124417_create_prescdetails_table',1),(75,'2026_01_23_124427_create_prescs_table',1),(76,'2026_01_23_124437_create_price_lists_table',1),(77,'2026_01_23_124447_create_print_table',1),(78,'2026_01_23_124457_create_process_table',1),(79,'2026_01_23_124507_create_prods_table',1),(80,'2026_01_23_124517_create_productions_table',1),(81,'2026_01_23_124527_create_pro_tybes_table',1),(82,'2026_01_23_124627_create_rays_table',1),(83,'2026_01_23_124637_create_reservations_table',1),(84,'2026_01_23_124647_create_salaries_table',1),(85,'2026_01_23_124657_create_services_table',1),(86,'2026_01_23_124717_create_settings_table',1),(87,'2026_01_23_124727_create_shifts_table',1),(88,'2026_01_23_124737_create_shw_optns_table',1),(89,'2026_01_23_124747_create_sitting_items_table',1),(90,'2026_01_23_124757_create_skills_table',1),(91,'2026_01_23_124817_create_tasks_table',1),(92,'2026_01_23_124827_create_tasktybes_table',1),(93,'2026_01_23_124837_create_test_table',1),(94,'2026_01_23_124847_create_towns_table',1),(95,'2026_01_23_124857_create_transactions_table',1),(96,'2026_01_23_124907_create_users_table',1),(97,'2026_01_23_124917_create_usr_pwrs_table',1),(98,'2026_01_23_124927_create_vacancies_table',1),(99,'2026_01_23_124937_create_visits_table',1),(100,'2026_01_23_124947_create_visittybes_table',1),(101,'2026_01_23_124957_create_zankat_table',1),(102,'2026_02_21_133549_add_age_column_to_ot_head_table',2),(103,'2026_02_23_141805_increase_employee_number_column_length',3),(104,'2026_02_24_131500_add_voucher_columns_to_ot_head_table',4),(105,'2026_02_24_131600_fix_journal_entries_columns',5),(106,'2026_02_25_000001_create_crm_lead_sources_table',6),(107,'2026_02_25_000002_create_crm_lead_statuses_table',6),(108,'2026_02_25_000003_create_crm_leads_table',6),(109,'2026_02_25_000004_create_crm_opportunity_stages_table',6),(110,'2026_02_25_000005_create_crm_opportunities_table',6),(111,'2026_02_25_000006_create_crm_contacts_table',6),(112,'2026_02_25_000007_create_crm_activity_types_table',6),(113,'2026_02_25_000008_create_crm_activities_table',6),(114,'2026_03_01_160000_add_accural_date_to_ot_head_table',7),(115,'2026_03_02_add_image_to_myitems',8),(116,'2026_03_03_add_converted_fields_to_ot_head',9);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `my_news`
--

DROP TABLE IF EXISTS `my_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `my_news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `tags` varchar(250) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `user` int(11) DEFAULT 1,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `my_news`
--

LOCK TABLES `my_news` WRITE;
/*!40000 ALTER TABLE `my_news` DISABLE KEYS */;
/*!40000 ALTER TABLE `my_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `myinstallments`
--

DROP TABLE IF EXISTS `myinstallments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myinstallments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cl_id` int(11) DEFAULT NULL,
  `rent_id` int(11) DEFAULT NULL,
  `contract` int(11) DEFAULT 0,
  `ins_value` decimal(10,2) DEFAULT 0.00,
  `ins_date` date DEFAULT NULL,
  `ins_case` int(11) DEFAULT NULL,
  `ins_paid` decimal(10,2) DEFAULT NULL,
  `voucher` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `info` varchar(250) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myinstallments`
--

LOCK TABLES `myinstallments` WRITE;
/*!40000 ALTER TABLE `myinstallments` DISABLE KEYS */;
/*!40000 ALTER TABLE `myinstallments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `myitems`
--

DROP TABLE IF EXISTS `myitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myitems` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iname` varchar(255) DEFAULT NULL,
  `name2` varchar(200) DEFAULT NULL,
  `code` int(11) DEFAULT NULL,
  `salesqty` decimal(10,2) DEFAULT 1.00,
  `barcode` varchar(25) DEFAULT NULL,
  `itmqty` decimal(10,2) DEFAULT 0.00,
  `info` varchar(250) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `market_price` decimal(10,2) DEFAULT 0.00,
  `cost_price` decimal(10,2) DEFAULT 0.00,
  `last_price` int(11) DEFAULT 0,
  `price1` decimal(10,2) DEFAULT 0.00,
  `price2` decimal(10,2) DEFAULT 0.00,
  `price3` decimal(10,2) DEFAULT NULL,
  `group1` int(11) DEFAULT 0,
  `group2` int(11) DEFAULT 0,
  `group3` int(11) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 1,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myitems`
--

LOCK TABLES `myitems` WRITE;
/*!40000 ALTER TABLE `myitems` DISABLE KEYS */;
INSERT INTO `myitems` VALUES (1,'صنف1','صنف1',1,1.00,'1245',428.00,'ssssssssss',NULL,110.00,100.00,0,130.00,120.00,NULL,1,1,0,0,'2026-02-14 13:27:29','2026-03-03 11:00:14',1,0,0,'2026-02-14 11:27:29','2026-02-14 11:27:29'),(2,'صنفففففففف','صنففففففففففف',2,1.00,'1234',96.00,NULL,NULL,15.00,11.00,0,20.00,16.00,NULL,1,1,0,0,'2026-02-16 13:20:05','2026-03-07 09:49:19',1,0,0,'2026-02-16 11:20:05','2026-02-16 11:20:05'),(3,'صنف3','صنف3',3,1.00,'3',95.00,NULL,NULL,55.00,50.00,0,60.00,56.00,NULL,1,1,0,0,'2026-02-17 13:30:02','2026-03-07 09:59:41',1,0,0,'2026-02-17 11:30:02','2026-02-17 11:30:02'),(4,'عصير',NULL,4,1.00,'4',98.00,NULL,NULL,50.00,0.00,0,60.00,58.00,NULL,1,1,0,0,'2026-02-28 14:07:41','2026-03-02 13:31:43',1,0,0,'2026-02-28 14:07:41','2026-03-02 13:31:43'),(5,'بسكوت',NULL,5,1.00,'5',79.00,'ةةةةةةة',NULL,18.00,17.00,0,20.00,19.00,NULL,1,1,0,0,'2026-03-01 11:49:09','2026-03-07 09:48:30',1,0,0,'2026-03-01 11:49:09','2026-03-02 12:28:54'),(6,'وافل كلاسيك','Daria Coleman',6,1.00,'365',38.00,'Ea adipisicing qui d',NULL,300.00,30.00,0,45.00,40.00,NULL,3,1,0,0,'2026-03-01 14:05:12','2026-03-07 09:51:21',1,0,0,'2026-03-01 14:05:12','2026-03-02 09:21:58'),(7,'بااااااااااننننننن','Halee Dudley',7,1.00,'Sed explicabo Odio',63.00,'Beatae fuga Ullam c',NULL,30.00,20.00,0,40.00,35.00,NULL,2,1,0,0,'2026-03-02 10:58:10','2026-03-07 09:48:30',1,0,0,'2026-03-02 10:58:10','2026-03-03 08:44:06');
/*!40000 ALTER TABLE `myitems` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `myoper_det`
--

DROP TABLE IF EXISTS `myoper_det`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myoper_det` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oper_det_id` int(11) DEFAULT NULL,
  `int_oper_det_date` int(11) DEFAULT NULL,
  `oper_head_id` int(11) DEFAULT NULL,
  `comp_id` int(11) DEFAULT NULL,
  `debit` decimal(26,4) DEFAULT NULL,
  `credit` decimal(26,4) DEFAULT NULL,
  `eng_debit` decimal(26,4) DEFAULT NULL,
  `eng_credit` decimal(26,4) DEFAULT NULL,
  `model_val` decimal(26,4) DEFAULT NULL,
  `def_val` decimal(26,4) DEFAULT NULL,
  `acc_id` int(11) DEFAULT NULL,
  `stor_id` int(11) DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `man_id` int(11) DEFAULT NULL,
  `cost_center_id` int(11) DEFAULT NULL,
  `has_costed_link` tinyint(4) DEFAULT NULL,
  `is_not_active` tinyint(4) DEFAULT NULL,
  `notes` varchar(50) DEFAULT NULL,
  `mst_no` varchar(20) DEFAULT NULL,
  `mst_date` varchar(12) DEFAULT NULL,
  `balance_befor` decimal(26,4) DEFAULT NULL,
  `balance_after` decimal(26,4) DEFAULT NULL,
  `det_Currency_id` int(11) DEFAULT NULL,
  `det_Currency_unit_convert` decimal(12,6) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myoper_det`
--

LOCK TABLES `myoper_det` WRITE;
/*!40000 ALTER TABLE `myoper_det` DISABLE KEYS */;
/*!40000 ALTER TABLE `myoper_det` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `myoptions`
--

DROP TABLE IF EXISTS `myoptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myoptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `oname` varchar(255) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `def_value` int(11) DEFAULT 0,
  `cur_value` int(11) DEFAULT 0,
  `op_tybe` int(11) DEFAULT 0,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myoptions`
--

LOCK TABLES `myoptions` WRITE;
/*!40000 ALTER TABLE `myoptions` DISABLE KEYS */;
/*!40000 ALTER TABLE `myoptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mypatterns`
--

DROP TABLE IF EXISTS `mypatterns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mypatterns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) DEFAULT NULL,
  `ptext` varchar(255) DEFAULT NULL,
  `is_def` int(11) DEFAULT 0,
  `is_basic` int(11) DEFAULT 0,
  `ptybe` int(11) DEFAULT 4,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `info` varchar(100) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mypatterns`
--

LOCK TABLES `mypatterns` WRITE;
/*!40000 ALTER TABLE `mypatterns` DISABLE KEYS */;
/*!40000 ALTER TABLE `mypatterns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mypowers`
--

DROP TABLE IF EXISTS `mypowers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mypowers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `power_id` int(11) DEFAULT NULL,
  `section_type_no` int(11) DEFAULT NULL,
  `power_name` varchar(100) DEFAULT NULL,
  `eng_power_name` varchar(100) DEFAULT NULL,
  `is_hide_in_casher` int(11) DEFAULT NULL,
  `level_no` tinyint(4) DEFAULT NULL,
  `is_for_view_only` tinyint(4) DEFAULT NULL,
  `power_code` varchar(100) DEFAULT NULL,
  `power_class` tinyint(4) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `col_index` int(11) DEFAULT NULL,
  `stoped` tinyint(4) DEFAULT NULL,
  `tmp_state_no` tinyint(4) DEFAULT NULL,
  `power_type` tinyint(4) DEFAULT NULL,
  `menu_type` tinyint(4) DEFAULT NULL,
  `def_state` varchar(20) DEFAULT NULL,
  `user_1` varchar(20) DEFAULT NULL,
  `kind` varchar(10) DEFAULT NULL,
  `is_on_my_thread` tinyint(4) DEFAULT NULL,
  `is_calling_from_main` tinyint(4) DEFAULT NULL,
  `calling_from` varchar(10) DEFAULT NULL,
  `edit_mode` tinyint(4) DEFAULT NULL,
  `frist_shown_id` varchar(10) DEFAULT NULL,
  `is_casher_from` tinyint(4) DEFAULT NULL,
  `is_op_paper` tinyint(4) DEFAULT NULL,
  `is_hiddin` tinyint(4) DEFAULT NULL,
  `prog_id` tinyint(4) DEFAULT NULL,
  `is_pure_kitchen` tinyint(4) DEFAULT NULL,
  `is_for_api` tinyint(4) DEFAULT NULL,
  `t_stamp` timestamp NULL DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mypowers`
--

LOCK TABLES `mypowers` WRITE;
/*!40000 ALTER TABLE `mypowers` DISABLE KEYS */;
/*!40000 ALTER TABLE `mypowers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `myrents`
--

DROP TABLE IF EXISTS `myrents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myrents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cl_id` int(11) DEFAULT NULL,
  `rent_id` int(11) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `idintity` varchar(50) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `pay_tybe` int(11) DEFAULT 1,
  `r_value` decimal(10,2) DEFAULT 0.00,
  `bnd1` varchar(250) DEFAULT NULL,
  `bnd2` varchar(250) DEFAULT NULL,
  `bnd3` varchar(250) DEFAULT NULL,
  `bnd4` varchar(250) DEFAULT NULL,
  `info` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myrents`
--

LOCK TABLES `myrents` WRITE;
/*!40000 ALTER TABLE `myrents` DISABLE KEYS */;
/*!40000 ALTER TABLE `myrents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `myunits`
--

DROP TABLE IF EXISTS `myunits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myunits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myunits`
--

LOCK TABLES `myunits` WRITE;
/*!40000 ALTER TABLE `myunits` DISABLE KEYS */;
INSERT INTO `myunits` VALUES (1,'قطعه','2024-03-25 03:56:49','2024-03-25 03:56:49',NULL,0,0,NULL,NULL),(2,'كرتونة ','2024-03-25 03:59:05','2025-02-26 15:16:20',NULL,0,0,NULL,NULL),(3,'دسته','2024-03-25 03:59:12','2024-03-25 04:13:25',NULL,0,0,NULL,NULL),(4,'باله','2024-07-25 00:26:22','2024-07-25 00:26:30',0,0,0,NULL,NULL),(5,'قطعه','2024-07-28 17:36:16','2024-07-28 17:36:16',0,0,0,NULL,NULL),(6,'م','2024-09-22 13:54:45','2024-09-28 16:15:45',0,0,0,NULL,NULL),(7,'كيلو','2024-09-28 16:15:39','2024-09-28 16:15:39',0,0,0,NULL,NULL),(8,'متر','2025-02-26 15:16:07','2025-02-26 15:16:07',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `myunits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `myvouchers`
--

DROP TABLE IF EXISTS `myvouchers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `myvouchers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `vdate` date DEFAULT NULL,
  `tybe` int(11) DEFAULT NULL,
  `val` decimal(10,2) DEFAULT NULL,
  `account` tinyint(1) DEFAULT NULL,
  `fund_account` tinyint(1) DEFAULT NULL,
  `voucher_id` varchar(255) DEFAULT NULL,
  `serial_number` varchar(20) DEFAULT NULL,
  `cost_center` tinyint(1) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 1,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `myvouchers`
--

LOCK TABLES `myvouchers` WRITE;
/*!40000 ALTER TABLE `myvouchers` DISABLE KEYS */;
/*!40000 ALTER TABLE `myvouchers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notes`
--

DROP TABLE IF EXISTS `notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `n1` varchar(100) DEFAULT '0',
  `n2` varchar(100) DEFAULT '0',
  `n3` varchar(100) DEFAULT '0',
  `n4` varchar(100) DEFAULT '0',
  `n5` varchar(100) DEFAULT '0',
  `n6` varchar(100) DEFAULT '0',
  `n7` varchar(100) DEFAULT '0',
  `n8` varchar(100) DEFAULT '0',
  `n9` varchar(100) DEFAULT '0',
  `n10` varchar(100) DEFAULT '0',
  `n11` varchar(100) DEFAULT '0',
  `n12` varchar(100) DEFAULT '0',
  `n13` varchar(100) DEFAULT '0',
  `n14` varchar(100) DEFAULT '0',
  `n15` varchar(100) DEFAULT '0',
  `n16` varchar(100) DEFAULT '0',
  `n17` varchar(100) DEFAULT '0',
  `n18` varchar(100) DEFAULT '0',
  `n19` varchar(100) DEFAULT '0',
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notes`
--

LOCK TABLES `notes` WRITE;
/*!40000 ALTER TABLE `notes` DISABLE KEYS */;
/*!40000 ALTER TABLE `notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oppatterns`
--

DROP TABLE IF EXISTS `oppatterns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oppatterns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pame` varchar(100) DEFAULT NULL,
  `ptext` varchar(100) DEFAULT NULL,
  `def_width` int(11) DEFAULT 50,
  `cur_width` int(11) DEFAULT 50,
  `shown` int(11) DEFAULT 1,
  `is_edit` int(11) DEFAULT 1,
  `is_print` int(11) DEFAULT 1,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oppatterns`
--

LOCK TABLES `oppatterns` WRITE;
/*!40000 ALTER TABLE `oppatterns` DISABLE KEYS */;
/*!40000 ALTER TABLE `oppatterns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_status`
--

DROP TABLE IF EXISTS `order_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_status` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_status`
--

LOCK TABLES `order_status` WRITE;
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_types`
--

DROP TABLE IF EXISTS `order_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_types`
--

LOCK TABLES `order_types` WRITE;
/*!40000 ALTER TABLE `order_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `order_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tybe` int(11) DEFAULT NULL,
  `employee` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `applyingdate` date DEFAULT NULL,
  `curdate` date DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ot_head`
--

DROP TABLE IF EXISTS `ot_head`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ot_head` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pro_id` int(11) DEFAULT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `pro_date` date NOT NULL COMMENT 'تاريخ الطلب',
  `accural_date` date DEFAULT NULL COMMENT 'تاريخ الاستحقاق',
  `pro_tybe` tinyint(4) NOT NULL DEFAULT 9 COMMENT 'نوع الطلب',
  `is_finance` tinyint(4) NOT NULL DEFAULT 0,
  `is_journal` tinyint(4) NOT NULL DEFAULT 0,
  `journal_tybe` tinyint(4) DEFAULT NULL,
  `pro_num` int(11) DEFAULT NULL,
  `age` tinyint(4) NOT NULL DEFAULT 1 COMMENT 'نوع الطلب: 1=تيك أواي، 2=طاولة، 3=دليفري',
  `acc1` int(11) DEFAULT NULL,
  `acc2` int(11) DEFAULT NULL,
  `store_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `acc_fund` int(11) DEFAULT NULL,
  `user` bigint(20) unsigned NOT NULL COMMENT 'معرف المستخدم',
  `fat_total` double NOT NULL DEFAULT 0 COMMENT 'الإجمالي',
  `fat_disc` double NOT NULL DEFAULT 0 COMMENT 'الخصم',
  `fat_net` double NOT NULL DEFAULT 0 COMMENT 'الصافي',
  `pro_value` double NOT NULL DEFAULT 0,
  `cost_center` int(11) DEFAULT NULL,
  `info` text DEFAULT NULL COMMENT 'ملاحظات',
  `isdeleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'علم الحذف',
  `converted_to_invoice` tinyint(4) NOT NULL DEFAULT 0 COMMENT '1 = تم التحويل لفاتورة',
  `converted_at` timestamp NULL DEFAULT NULL COMMENT 'تاريخ التحويل',
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'وقت الإنشاء',
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'وقت التعديل',
  PRIMARY KEY (`id`),
  KEY `ot_head_pro_date_index` (`pro_date`),
  KEY `ot_head_user_index` (`user`),
  KEY `ot_head_pro_tybe_index` (`pro_tybe`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ot_head`
--

LOCK TABLES `ot_head` WRITE;
/*!40000 ALTER TABLE `ot_head` DISABLE KEYS */;
INSERT INTO `ot_head` VALUES (1,NULL,NULL,'1978-08-04',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,66663,21,66729,0,NULL,'Aut ut laboris quod',0,0,NULL,'2026-02-14 13:04:29','2026-02-15 19:44:00'),(2,NULL,NULL,'1981-06-06',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,17472,10,17544,0,NULL,'Consectetur amet h',0,0,NULL,'2026-02-14 13:04:58','2026-02-15 19:41:31'),(3,NULL,NULL,'1971-05-16',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,8880,81,8885,0,NULL,'In ea non dolore qui',0,0,NULL,'2026-02-15 11:22:18','2026-02-15 11:22:18'),(4,NULL,NULL,'2016-06-09',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,1440,20,1437,0,NULL,'Ipsum rerum quasi te',1,0,NULL,'2026-02-15 11:29:35','2026-02-15 21:48:41'),(5,NULL,NULL,'2011-05-16',NULL,3,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,7248,90,7250,0,NULL,'Molestiae voluptatem',0,0,NULL,'2026-02-15 12:39:44','2026-02-15 12:39:44'),(6,NULL,NULL,'1986-08-08',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,1900,68,1891,0,NULL,'Et vel duis rerum of',0,0,NULL,'2026-02-15 13:16:00','2026-02-15 13:16:00'),(7,NULL,NULL,'2017-10-17',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,55,19,122,0,NULL,'Et sit itaque excep',0,0,NULL,'2026-02-15 13:16:25','2026-02-15 13:16:25'),(8,NULL,NULL,'1997-12-31',NULL,3,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,3234,81,3164,0,NULL,'Dolores impedit sed',0,0,NULL,'2026-02-15 13:18:21','2026-02-15 13:18:21'),(9,NULL,NULL,'2008-09-20',NULL,8,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,10404,86,10328,0,NULL,'Libero sed aperiam p',0,0,NULL,'2026-02-15 13:26:20','2026-02-15 13:26:20'),(10,NULL,NULL,'2000-07-29',NULL,3,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,9096,98,9090,0,NULL,'Quisquam velit veli',0,0,NULL,'2026-02-15 16:40:30','2026-02-15 16:40:30'),(11,NULL,NULL,'1980-08-09',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,9900,12,9987,0,NULL,'Aspernatur velit ver',1,0,NULL,'2026-02-15 19:49:34','2026-02-15 21:49:56'),(12,NULL,NULL,'1991-08-01',NULL,3,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,34188,41,34151,0,NULL,'Aut et architecto ev',0,0,NULL,'2026-02-15 19:51:38','2026-02-15 19:51:38'),(13,NULL,NULL,'1984-10-08',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,13038,59,13031,0,NULL,'Labore aut libero lo',0,0,NULL,'2026-02-15 19:56:29','2026-02-15 20:06:56'),(14,NULL,NULL,'1990-11-03',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,248,11,263,0,NULL,'Velit id commodi nat',0,0,NULL,'2026-02-15 21:00:23','2026-02-15 21:00:42'),(15,NULL,NULL,'2025-01-29',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,-116,12,-107,0,NULL,'Omnis maxime blandit',0,0,NULL,'2026-02-16 13:18:54','2026-02-16 13:18:54'),(16,NULL,NULL,'2026-02-18',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,550,0,550,0,NULL,'',1,0,NULL,'2026-02-17 10:10:51','2026-02-18 15:28:10'),(17,NULL,NULL,'2026-02-18',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,260,0,260,0,NULL,'',1,0,NULL,'2026-02-17 10:11:02','2026-02-24 10:00:47'),(18,NULL,NULL,'2026-02-18',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,250,0,250,0,NULL,'',1,0,NULL,'2026-02-17 10:16:02','2026-02-24 12:44:46'),(19,NULL,NULL,'2003-08-16',NULL,10,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,18984,98,18920,0,NULL,'Beatae voluptas omni',0,0,NULL,'2026-02-17 11:30:56','2026-02-17 11:30:56'),(20,NULL,NULL,'2026-02-17',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,280,0,280,0,NULL,'',0,0,NULL,'2026-02-17 11:33:20','2026-02-17 11:33:20'),(21,NULL,NULL,'2026-02-17',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,320,0,320,0,NULL,'',1,0,NULL,'2026-02-17 13:46:17','2026-02-18 12:23:04'),(22,NULL,NULL,'1988-09-24',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,56250,56250,0,0,NULL,'Voluptas corrupti i',0,0,NULL,'2026-02-18 10:21:00','2026-02-18 10:21:46'),(23,NULL,NULL,'2026-02-18',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,290,0,290,0,NULL,'',0,0,NULL,'2026-02-18 13:12:23','2026-02-18 13:12:23'),(24,NULL,NULL,'2026-02-18',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,210,0,210,0,NULL,'',0,0,NULL,'2026-02-18 13:12:56','2026-02-18 13:12:56'),(25,NULL,NULL,'2026-02-21',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,140,0,140,0,NULL,'',0,0,NULL,'2026-02-21 10:55:11','2026-02-21 10:55:11'),(26,NULL,NULL,'2026-02-21',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,320,0,320,0,NULL,'',0,0,NULL,'2026-02-21 10:55:42','2026-02-21 10:55:42'),(27,NULL,NULL,'2026-02-21',NULL,9,0,0,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,1,100,0,100,0,NULL,'',0,0,NULL,'2026-02-21 12:04:39','2026-02-21 12:04:39'),(28,NULL,NULL,'2026-02-21',NULL,9,0,0,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,1,520,0,520,0,NULL,'',0,0,NULL,'2026-02-21 12:31:32','2026-02-21 12:31:32'),(29,NULL,NULL,'2026-02-23',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,340,0,340,0,NULL,'',0,0,NULL,'2026-02-23 06:51:39','2026-02-23 06:51:39'),(30,NULL,NULL,'2026-02-23',NULL,9,0,0,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,1,500,0,500,0,NULL,'',0,0,NULL,'2026-02-23 06:52:11','2026-02-23 06:52:11'),(31,NULL,NULL,'2026-02-23',NULL,9,0,0,NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,1,210,0,210,0,NULL,'',0,0,NULL,'2026-02-23 07:06:52','2026-02-23 07:06:52'),(32,NULL,NULL,'2026-02-23',NULL,9,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,400,0,400,0,NULL,'',0,0,NULL,'2026-02-23 08:12:14','2026-02-23 08:12:14'),(33,NULL,NULL,'2026-02-23',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,120,0,120,0,NULL,'',0,0,NULL,'2026-02-23 12:51:06','2026-02-23 12:51:06'),(34,NULL,NULL,'2026-02-24',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,380,0,380,0,NULL,'',0,0,NULL,'2026-02-24 07:59:09','2026-02-24 07:59:09'),(35,NULL,NULL,'2026-02-24',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,350,0,350,0,NULL,'',0,0,NULL,'2026-02-24 08:45:38','2026-02-24 08:45:38'),(36,NULL,NULL,'2026-02-24',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,120,0,120,0,NULL,'',0,0,NULL,'2026-02-24 11:15:17','2026-02-24 11:15:17'),(37,NULL,NULL,'2026-02-24',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,130,0,130,0,NULL,'',0,0,NULL,'2026-02-24 11:16:31','2026-02-24 11:16:31'),(39,NULL,NULL,'2026-02-24',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,260,0,260,0,NULL,'',0,0,NULL,'2026-02-24 12:43:18','2026-02-24 12:43:18'),(41,11,1,'2023-12-26',NULL,2,1,1,2,11,1,1008,1005,NULL,NULL,NULL,1,0,0,0,66,1,'Sequi distinctio Si',0,0,NULL,'2026-02-24 12:50:42','2026-02-24 12:50:42'),(42,NULL,NULL,'2026-02-24',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,200,0,200,0,NULL,'',0,0,NULL,'2026-02-24 13:09:53','2026-02-24 13:27:31'),(43,3,1,'2026-02-24',NULL,1,1,1,1,3,1,1005,1009,NULL,NULL,NULL,1,0,0,0,15,1,NULL,0,0,NULL,'2026-02-24 14:12:56','2026-02-24 14:12:56'),(44,NULL,NULL,'2026-02-25',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,1100,0,1100,0,NULL,NULL,0,0,NULL,'2026-02-25 09:12:41','2026-02-25 09:12:41'),(45,NULL,NULL,'2026-02-25',NULL,9,0,0,NULL,NULL,3,1002,1003,1003,1,1001,1,440,0,440,0,NULL,'',0,0,NULL,'2026-02-25 11:30:17','2026-02-25 11:31:36'),(46,NULL,NULL,'2026-02-25',NULL,9,0,0,NULL,NULL,3,1016,1003,1003,1,1001,1,260,0,260,0,NULL,'ديليفري - عميل3 | موبايل: 01123456789 | عنوان: وووووووووووووووو',0,0,NULL,'2026-02-25 12:05:10','2026-02-25 12:05:10'),(47,NULL,NULL,'2026-02-28',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,180,0,180,0,NULL,'',0,0,NULL,'2026-02-28 11:11:56','2026-02-28 11:11:56'),(48,NULL,NULL,'2026-02-28',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,0,0,0,0,NULL,NULL,0,0,NULL,'2026-02-28 14:43:41','2026-02-28 14:43:41'),(49,NULL,NULL,'2026-03-01',NULL,9,0,0,NULL,NULL,3,1016,1003,1003,1,1001,1,340,170,170,0,NULL,'ديليفري - عميل3 | موبايل: 01123456789 | عنوان: وووووووووووووووو',0,0,NULL,'2026-03-01 11:37:06','2026-03-01 11:37:06'),(50,NULL,NULL,'2026-03-01',NULL,4,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,170,15,155,0,NULL,NULL,0,0,NULL,'2026-03-01 12:00:27','2026-03-01 12:00:27'),(51,NULL,NULL,'2026-03-01',NULL,9,0,0,NULL,NULL,2,1002,1003,1003,1,1001,1,270,27,243,0,NULL,'طاولة رقم 11',0,0,NULL,'2026-03-01 12:22:48','2026-03-01 12:23:24'),(52,NULL,NULL,'2026-03-01',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,120,0,120,0,NULL,'',0,0,NULL,'2026-03-01 13:16:55','2026-03-01 13:16:55'),(53,NULL,NULL,'2026-03-01',NULL,4,0,0,NULL,NULL,1,123,211,123,3,NULL,1,22000,0,22000,0,NULL,NULL,0,0,NULL,'2026-03-01 15:03:45','2026-03-01 18:37:47'),(54,NULL,NULL,'2026-03-01',NULL,3,0,0,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,1,200,0,200,0,NULL,NULL,0,0,NULL,'2026-03-01 15:05:47','2026-03-01 15:05:47'),(55,NULL,NULL,'2026-03-01',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,1490,223.5,1266.5,0,NULL,'',0,0,NULL,'2026-03-01 16:03:29','2026-03-01 16:03:29'),(56,NULL,NULL,'2026-03-01',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,260,0,260,0,NULL,'',0,0,NULL,'2026-03-01 16:04:00','2026-03-01 16:04:00'),(57,NULL,NULL,'2026-03-01',NULL,4,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,3400,0,3400,0,NULL,NULL,0,0,NULL,'2026-03-01 16:09:25','2026-03-01 18:38:24'),(58,NULL,NULL,'2026-03-01',NULL,3,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,170,0,170,0,NULL,NULL,0,0,NULL,'2026-03-01 17:00:43','2026-03-01 18:42:12'),(59,NULL,NULL,'2026-03-02',NULL,10,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,170,0,170,0,NULL,NULL,0,0,NULL,'2026-03-02 09:08:47','2026-03-02 09:08:47'),(64,NULL,NULL,'2026-03-02',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,530,0,530,0,NULL,'',0,0,NULL,'2026-03-02 11:18:14','2026-03-02 11:18:14'),(68,NULL,NULL,'2026-03-02',NULL,4,0,0,NULL,NULL,1,1003,1004,1003,3,NULL,1,360,0,360,0,NULL,NULL,0,0,NULL,'2026-03-02 12:19:13','2026-03-02 12:19:13'),(69,NULL,NULL,'2026-03-02',NULL,10,0,0,NULL,NULL,1,1003,1004,1003,3,NULL,1,204,0,204,0,NULL,NULL,0,0,NULL,'2026-03-02 12:20:02','2026-03-02 12:20:02'),(70,NULL,NULL,'2026-03-02',NULL,10,0,0,NULL,NULL,1,1003,1004,1003,3,NULL,1,340,0,340,0,NULL,NULL,0,0,NULL,'2026-03-02 13:22:51','2026-03-02 13:22:51'),(71,NULL,NULL,'2026-03-02',NULL,9,0,0,NULL,NULL,2,1002,1003,1003,1,1001,1,145,0,145,0,NULL,'',0,0,NULL,'2026-03-02 13:32:24','2026-03-02 13:32:24'),(72,NULL,NULL,'2026-03-02',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,260,0,260,0,NULL,'',0,0,NULL,'2026-03-02 13:34:37','2026-03-02 13:34:37'),(75,NULL,NULL,'2026-03-03',NULL,4,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,300,0,300,0,NULL,NULL,0,0,NULL,'2026-03-03 08:40:58','2026-03-03 08:40:58'),(80,NULL,NULL,'2026-03-03',NULL,4,0,0,NULL,NULL,1,1003,1004,1003,3,NULL,1,600,0,600,0,NULL,NULL,0,0,NULL,'2026-03-03 09:01:43','2026-03-03 09:01:43'),(81,NULL,NULL,'2026-03-03',NULL,3,0,0,NULL,NULL,1,1003,1004,1003,3,NULL,1,450,0,450,0,NULL,NULL,0,0,NULL,'2026-03-03 09:08:25','2026-03-03 09:08:25'),(84,NULL,NULL,'2026-03-03',NULL,3,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,50,0,50,0,NULL,NULL,0,0,NULL,'2026-03-03 09:18:38','2026-03-03 09:18:38'),(85,NULL,NULL,'2026-03-03',NULL,4,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,450,10,442,0,NULL,NULL,0,0,NULL,'2026-03-03 09:56:52','2026-03-03 10:02:45'),(86,NULL,NULL,'2026-03-03',NULL,8,0,0,NULL,NULL,1,1003,1002,1003,3,NULL,1,10000,0,10000,0,NULL,NULL,0,0,NULL,'2026-03-03 10:00:17','2026-03-03 10:00:17'),(87,NULL,NULL,'2026-03-03',NULL,8,0,0,NULL,NULL,1,1012,1015,1012,3,NULL,1,900,0,900,0,NULL,NULL,0,0,NULL,'2026-03-03 10:04:40','2026-03-03 10:04:40'),(88,NULL,NULL,'2026-03-03',NULL,4,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,400,50,350,0,NULL,NULL,0,0,NULL,'2026-03-03 10:08:29','2026-03-03 10:21:57'),(89,NULL,NULL,'2026-03-03',NULL,12,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,400,0,400,0,NULL,NULL,0,1,'2026-03-03 11:16:06','2026-03-03 10:12:23','2026-03-03 11:16:06'),(90,NULL,NULL,'2026-03-03',NULL,8,0,0,NULL,NULL,1,1003,1016,1003,3,NULL,1,1000,0,1000,0,NULL,NULL,0,0,NULL,'2026-03-03 10:22:51','2026-03-03 10:22:51'),(91,NULL,NULL,'2026-03-03',NULL,8,0,0,NULL,NULL,1,1003,1002,1003,3,NULL,1,1000,0,1000,0,NULL,' [تم التحويل لفاتورة #92]',1,0,NULL,'2026-03-03 10:50:54','2026-03-03 11:00:14'),(92,NULL,NULL,'2026-03-03',NULL,3,0,0,NULL,NULL,1,1003,1002,1003,3,NULL,1,1000,0,1000,0,NULL,'تم التحويل من أمر بيع #91',0,0,NULL,'2026-03-03 11:00:14','2026-03-03 11:00:14'),(93,NULL,NULL,'2026-03-03',NULL,11,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,60,0,60,0,NULL,NULL,0,0,NULL,'2026-03-03 12:04:46','2026-03-03 12:04:46'),(94,NULL,NULL,'2026-03-03',NULL,12,0,0,NULL,NULL,1,1012,1002,1012,3,NULL,1,400,0,400,0,NULL,' [تم التحويل لفاتورة #95]',0,1,'2026-03-03 12:35:23','2026-03-03 12:33:41','2026-03-03 12:35:23'),(95,NULL,NULL,'2026-03-03',NULL,3,0,0,NULL,NULL,1,1012,1002,1012,3,NULL,1,400,0,400,0,NULL,'تم التحويل من عرض سعر #94',0,0,NULL,'2026-03-03 12:34:10','2026-03-03 12:34:10'),(96,NULL,NULL,'2026-03-03',NULL,12,0,0,NULL,NULL,1,1012,1004,1012,3,NULL,1,200,0,200,0,NULL,NULL,0,1,'2026-03-03 12:41:25','2026-03-03 12:41:15','2026-03-03 12:41:25'),(97,NULL,NULL,'2026-03-07',NULL,9,0,0,NULL,NULL,1,1002,1003,1003,1,1001,1,120,0,120,0,NULL,'',0,0,NULL,'2026-03-07 09:48:30','2026-03-07 09:48:30'),(98,NULL,NULL,'2026-03-07',NULL,9,0,0,NULL,NULL,3,1016,1003,1003,1,1001,1,85,0,85,0,NULL,'ديليفري - عميل3 | موبايل: 01123456789 | عنوان: وووووووووووووووو',0,0,NULL,'2026-03-07 09:49:19','2026-03-07 09:49:19'),(99,NULL,NULL,'2026-03-07',NULL,3,0,0,NULL,NULL,1,1012,1015,1012,3,NULL,1,30,0,30,0,NULL,NULL,0,0,NULL,'2026-03-07 09:51:21','2026-03-07 09:51:21'),(100,NULL,NULL,'2026-03-07',NULL,3,0,0,NULL,NULL,1,1012,1015,1012,3,NULL,1,200,0,200,0,NULL,NULL,0,0,NULL,'2026-03-07 09:59:41','2026-03-07 09:59:41');
/*!40000 ALTER TABLE `ot_head` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paper_types`
--

DROP TABLE IF EXISTS `paper_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paper_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paper_types`
--

LOCK TABLES `paper_types` WRITE;
/*!40000 ALTER TABLE `paper_types` DISABLE KEYS */;
/*!40000 ALTER TABLE `paper_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patt_cols`
--

DROP TABLE IF EXISTS `patt_cols`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patt_cols` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(255) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patt_cols`
--

LOCK TABLES `patt_cols` WRITE;
/*!40000 ALTER TABLE `patt_cols` DISABLE KEYS */;
/*!40000 ALTER TABLE `patt_cols` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permits`
--

DROP TABLE IF EXISTS `permits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empid` int(11) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `curdate` date DEFAULT NULL,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `val` decimal(8,2) DEFAULT NULL,
  `statue` tinyint(1) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permits`
--

LOCK TABLES `permits` WRITE;
/*!40000 ALTER TABLE `permits` DISABLE KEYS */;
/*!40000 ALTER TABLE `permits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescdetails`
--

DROP TABLE IF EXISTS `prescdetails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescdetails` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `prescid` int(11) DEFAULT NULL,
  `drug` int(11) DEFAULT NULL,
  `dose` varchar(255) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescdetails`
--

LOCK TABLES `prescdetails` WRITE;
/*!40000 ALTER TABLE `prescdetails` DISABLE KEYS */;
/*!40000 ALTER TABLE `prescdetails` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescs`
--

DROP TABLE IF EXISTS `prescs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client` int(11) DEFAULT NULL,
  `visit` int(11) DEFAULT NULL,
  `analayses` varchar(250) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescs`
--

LOCK TABLES `prescs` WRITE;
/*!40000 ALTER TABLE `prescs` DISABLE KEYS */;
/*!40000 ALTER TABLE `prescs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `price_lists`
--

DROP TABLE IF EXISTS `price_lists`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `price_lists` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `price_lists`
--

LOCK TABLES `price_lists` WRITE;
/*!40000 ALTER TABLE `price_lists` DISABLE KEYS */;
INSERT INTO `price_lists` VALUES (1,'سعر 1',0,0,0,NULL,NULL),(2,'سعر 2',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `price_lists` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `print`
--

DROP TABLE IF EXISTS `print`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `print` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `print`
--

LOCK TABLES `print` WRITE;
/*!40000 ALTER TABLE `print` DISABLE KEYS */;
/*!40000 ALTER TABLE `print` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pro_tybes`
--

DROP TABLE IF EXISTS `pro_tybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pro_tybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(200) DEFAULT NULL,
  `ptext` varchar(200) DEFAULT NULL,
  `ptybe` int(11) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pro_tybes`
--

LOCK TABLES `pro_tybes` WRITE;
/*!40000 ALTER TABLE `pro_tybes` DISABLE KEYS */;
INSERT INTO `pro_tybes` VALUES (1,'سند قبض',NULL,1,NULL,'2024-03-14 00:01:35','2024-03-14 00:01:35',0,0,0,NULL,NULL),(2,'سند دفع',NULL,2,NULL,'2024-03-14 00:01:35','2024-03-14 00:02:22',0,0,0,NULL,NULL),(3,'فاتورة مبيعات',NULL,3,NULL,'2024-03-14 00:01:58','2024-03-14 00:02:26',0,0,0,NULL,NULL),(4,'فاتورة مشتريات',NULL,4,NULL,'2024-03-14 00:01:58','2024-03-14 00:02:28',0,0,0,NULL,NULL),(5,'استحقاق قسط',NULL,5,NULL,'2024-03-17 01:53:16','2024-03-17 01:53:27',0,0,0,NULL,NULL),(6,'خصم مكتسب',NULL,6,NULL,'2024-03-17 01:53:16','2024-03-17 01:53:27',0,0,0,NULL,NULL),(7,'خصم مسموح به',NULL,7,NULL,'2024-03-17 01:53:16','2024-03-17 01:53:27',0,0,0,NULL,NULL),(8,'قيد يومية',NULL,8,NULL,'2024-05-14 08:06:41','2024-05-14 08:06:54',0,0,0,NULL,NULL),(9,'فاتورة كاشير',NULL,9,NULL,'2024-05-14 08:06:41','2024-07-19 14:25:29',0,0,0,NULL,NULL),(10,'فاتورة مردود مبيعات',NULL,10,NULL,'2024-05-14 08:06:41','2024-11-21 13:25:06',0,0,0,NULL,NULL),(11,'فاتورة مردود مشتريات',NULL,11,NULL,'2024-05-14 08:06:41','2024-11-21 13:25:10',0,0,0,NULL,NULL),(12,'أمر شراء',NULL,12,NULL,'2024-05-14 08:06:41','2024-11-21 13:25:12',0,0,0,NULL,NULL),(13,'أمر بيع',NULL,13,NULL,'2024-05-14 08:06:41','2024-11-21 13:25:16',0,0,0,NULL,NULL),(14,'رصيد افتتاحي مخازن',NULL,14,NULL,'2024-05-14 08:06:41','2024-11-23 09:40:49',0,0,0,NULL,NULL),(15,'رصيد افتتاحي حسابات',NULL,15,NULL,'2024-05-14 08:06:41','2024-11-23 09:40:52',0,0,0,NULL,NULL);
/*!40000 ALTER TABLE `pro_tybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `process`
--

DROP TABLE IF EXISTS `process`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `process` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `process`
--

LOCK TABLES `process` WRITE;
/*!40000 ALTER TABLE `process` DISABLE KEYS */;
INSERT INTO `process` VALUES (1,'add account >> موظف 1','2026-02-14 12:20:56','2026-02-14 10:20:56',NULL),(2,'add account >> موظف 2','2026-02-14 12:21:09','2026-02-14 10:21:09',NULL),(3,'add group','2026-02-14 13:21:31','2026-02-14 11:21:31',NULL),(4,'add category','2026-02-14 13:22:51','2026-02-14 11:22:51',NULL),(5,'add item','2026-02-14 13:27:29','2026-02-14 11:27:29',NULL),(6,'add item','2026-02-16 13:20:05','2026-02-16 11:20:05',NULL),(7,'add item','2026-02-17 13:30:02','2026-02-17 11:30:02',NULL),(8,'add account >> Rogan Snyder','2026-02-18 14:33:28','2026-02-18 12:33:28',NULL),(9,'add employee','2026-02-23 14:42:54','2026-02-23 12:42:54',NULL),(10,'add employee','2026-02-23 14:43:21','2026-02-23 12:43:21',NULL),(11,'add account >> بنك 1','2026-02-25 09:09:25','2026-02-25 09:09:25',NULL),(12,'add account >> صندوق 1','2026-02-25 09:10:12','2026-02-25 09:10:12',NULL),(13,'add account >> مخزن 2','2026-02-25 09:11:33','2026-02-25 09:11:33',NULL),(14,'add employee','2026-02-25 10:31:48','2026-02-25 10:31:48',NULL),(15,'add employee','2026-02-25 10:40:01','2026-02-25 10:40:01',NULL),(16,'add account >> عميل 2','2026-02-25 11:10:12','2026-02-25 11:10:12',NULL),(17,'add department','2026-02-25 12:37:25','2026-02-25 12:37:25',NULL),(18,'add item','2026-02-28 14:07:41','2026-02-28 14:07:41',NULL),(19,'add item','2026-03-01 11:49:09','2026-03-01 11:49:09',NULL),(20,'add group','2026-03-01 14:01:04','2026-03-01 14:01:04',NULL),(21,'add group','2026-03-01 14:01:36','2026-03-01 14:01:36',NULL),(22,'add item','2026-03-01 14:05:12','2026-03-01 14:05:12',NULL),(23,'add item','2026-03-02 10:58:10','2026-03-02 10:58:10',NULL),(24,'add journal','2026-03-04 11:00:15','2026-03-04 11:00:15',NULL),(25,'add journal','2026-03-04 11:19:06','2026-03-04 11:19:06',NULL),(26,'add journal','2026-03-04 12:02:36','2026-03-04 12:02:36',NULL);
/*!40000 ALTER TABLE `process` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prods`
--

DROP TABLE IF EXISTS `prods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pname` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prods`
--

LOCK TABLES `prods` WRITE;
/*!40000 ALTER TABLE `prods` DISABLE KEYS */;
/*!40000 ALTER TABLE `prods` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productions`
--

DROP TABLE IF EXISTS `productions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `productions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `snd_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `emp_name` varchar(255) DEFAULT NULL,
  `qty` decimal(10,2) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `value` decimal(10,2) DEFAULT NULL,
  `info` varchar(150) DEFAULT NULL,
  `info2` varchar(150) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 1,
  `isdeleted` int(11) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productions`
--

LOCK TABLES `productions` WRITE;
/*!40000 ALTER TABLE `productions` DISABLE KEYS */;
/*!40000 ALTER TABLE `productions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rays`
--

DROP TABLE IF EXISTS `rays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rays` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client` int(11) DEFAULT NULL,
  `lap` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `img` varchar(250) DEFAULT NULL,
  `crtime` timestamp NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `info` varchar(250) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rays`
--

LOCK TABLES `rays` WRITE;
/*!40000 ALTER TABLE `rays` DISABLE KEYS */;
/*!40000 ALTER TABLE `rays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservations`
--

DROP TABLE IF EXISTS `reservations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client` int(11) DEFAULT NULL,
  `diseses` varchar(250) DEFAULT '0',
  `phone` varchar(15) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `duration` decimal(8,2) DEFAULT NULL,
  `visittybe` int(11) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `paid` int(11) DEFAULT 0,
  `deserved` int(11) DEFAULT 0,
  `rest` int(11) DEFAULT 0,
  `done` int(11) DEFAULT 0,
  `info` varchar(250) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservations`
--

LOCK TABLES `reservations` WRITE;
/*!40000 ALTER TABLE `reservations` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `salaries`
--

DROP TABLE IF EXISTS `salaries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `salaries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `empid` int(11) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `salary` decimal(10,2) DEFAULT 0.00,
  `extra` decimal(10,2) DEFAULT 0.00,
  `disc` decimal(10,2) DEFAULT 0.00,
  `allow` decimal(10,2) DEFAULT 0.00,
  `dedu` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `salaries`
--

LOCK TABLES `salaries` WRITE;
/*!40000 ALTER TABLE `salaries` DISABLE KEYS */;
/*!40000 ALTER TABLE `salaries` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sname` varchar(255) DEFAULT NULL,
  `info` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('NwlSxX8EzumA3X98W7H6j1YNH5CClyHxpR4Dq0GT',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36','YTo3OntzOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czozMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2Rhc2hib2FyZCI7czo1OiJyb3V0ZSI7czoxNToiZGFzaGJvYXJkLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo2OiJfdG9rZW4iO3M6NDA6IkVzbVhmZFdFazJhWDF6ZHhGV1d1N2lKY3NFOVY0UXNCY2dDbnowcXciO3M6NjoidXNlcmlkIjtpOjE7czo2OiJ1c3JvbGUiO2k6MTtzOjQ6InVzdHkiO2k6MjtzOjU6ImxvZ2luIjtzOjU6ImFkbWluIjt9',1772888806);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `company_name` varchar(200) DEFAULT NULL,
  `company_add` varchar(200) DEFAULT NULL,
  `company_email` varchar(50) DEFAULT NULL,
  `company_tel` varchar(200) DEFAULT NULL,
  `edit_pass` varchar(50) DEFAULT NULL,
  `lic` varchar(250) DEFAULT NULL,
  `updateline` text DEFAULT NULL,
  `acc_rent` int(11) DEFAULT 0,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `lang` varchar(20) DEFAULT 'ar',
  `bodycolor` varchar(50) DEFAULT NULL,
  `showhr` tinyint(1) DEFAULT 1,
  `showclinc` tinyint(1) DEFAULT 1,
  `showatt` int(11) DEFAULT 1,
  `showpayroll` int(11) DEFAULT 1,
  `showrent` int(11) DEFAULT 1,
  `showpay` int(11) DEFAULT 1,
  `showtsk` int(11) DEFAULT 1,
  `def_pos_client` int(11) DEFAULT NULL,
  `def_pos_store` int(11) DEFAULT NULL,
  `def_pos_employee` int(11) DEFAULT NULL,
  `def_pos_fund` int(11) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `logo` varchar(255) DEFAULT NULL,
  `show_all_tasks` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'FOCUS HOUSE','سمنود - برج زايد - الدور الخامس','abdelhadeeladawy@gmail.com','010053662038','125','d35c99e7485691ea14f829029dc03e69A67b8d2f92148f52cad46e331936922e8','',99,'2024-01-01','2024-12-31','ar','#f0f0f0',1,1,1,1,1,1,1,155,27,131,21,0,0,0,NULL,NULL,NULL,'2026-03-07 11:47:00');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shifts`
--

DROP TABLE IF EXISTS `shifts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shifts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `shiftstart` time DEFAULT NULL,
  `shiftend` time DEFAULT NULL,
  `hours` decimal(11,2) DEFAULT NULL,
  `instart` time DEFAULT NULL,
  `inend` time DEFAULT NULL,
  `outstart` time DEFAULT NULL,
  `outend` time DEFAULT NULL,
  `latelimit` tinyint(1) DEFAULT NULL,
  `earlylimit` int(11) DEFAULT NULL,
  `workingdays` varchar(20) DEFAULT NULL,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shifts`
--

LOCK TABLES `shifts` WRITE;
/*!40000 ALTER TABLE `shifts` DISABLE KEYS */;
INSERT INTO `shifts` VALUES (1,'الصباحي','الشيفت الصباحي','2026-02-23 12:19:18',0,'08:00:00','16:00:00',8.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(2,'المسائي','الشيفت المسائي','2026-02-23 12:19:18',0,'16:00:00','00:00:00',8.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(3,'الليلي','الشيفت الليلي','2026-02-23 12:19:18',0,'00:00:00','08:00:00',8.00,NULL,NULL,NULL,NULL,NULL,NULL,NULL,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18');
/*!40000 ALTER TABLE `shifts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shw_optns`
--

DROP TABLE IF EXISTS `shw_optns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shw_optns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sname` varchar(255) DEFAULT NULL,
  `is_show` int(11) DEFAULT 0,
  `def_width` int(11) DEFAULT 50,
  `cur_width` int(11) DEFAULT 50,
  `info` varchar(150) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shw_optns`
--

LOCK TABLES `shw_optns` WRITE;
/*!40000 ALTER TABLE `shw_optns` DISABLE KEYS */;
/*!40000 ALTER TABLE `shw_optns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sitting_items`
--

DROP TABLE IF EXISTS `sitting_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sitting_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `iname` varchar(255) DEFAULT NULL,
  `item_value` tinyint(1) DEFAULT 0,
  `item_description` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sitting_items`
--

LOCK TABLES `sitting_items` WRITE;
/*!40000 ALTER TABLE `sitting_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `sitting_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `skills`
--

DROP TABLE IF EXISTS `skills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `skills` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sname` varchar(255) DEFAULT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `info` varchar(200) DEFAULT NULL,
  `scolor` varchar(100) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user` int(11) DEFAULT 1,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `skills`
--

LOCK TABLES `skills` WRITE;
/*!40000 ALTER TABLE `skills` DISABLE KEYS */;
/*!40000 ALTER TABLE `skills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tables`
--

DROP TABLE IF EXISTS `tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tables` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tname` varchar(255) NOT NULL COMMENT 'اسم الطاولة',
  `table_case` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0=متاحة، 1=محجوزة، 2=صيانة',
  `crtime` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'وقت الإنشاء',
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'وقت التعديل',
  `isdeleted` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'علم الحذف المنطقي',
  `branch` varchar(255) NOT NULL DEFAULT 'main' COMMENT 'الفرع',
  `tatnet` int(11) NOT NULL DEFAULT 0 COMMENT 'حقل إضافي',
  PRIMARY KEY (`id`),
  KEY `tables_isdeleted_index` (`isdeleted`),
  KEY `tables_table_case_index` (`table_case`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tables`
--

LOCK TABLES `tables` WRITE;
/*!40000 ALTER TABLE `tables` DISABLE KEYS */;
INSERT INTO `tables` VALUES (1,'طاولة 1',0,'2026-02-16 12:44:50','2026-02-21 14:33:32',1,'main',0),(2,'طاولة 2',0,'2026-02-16 12:44:50','2026-02-16 12:44:50',0,'main',0),(3,'طاولة 3',0,'2026-02-16 12:44:50','2026-02-25 11:35:32',0,'main',0),(4,'طاولة 4',0,'2026-02-16 12:44:50','2026-02-16 12:44:50',0,'main',0),(5,'طاولة 5',0,'2026-02-16 12:44:50','2026-02-16 12:44:50',0,'main',0),(6,'طاولة 6',0,'2026-02-16 12:44:50','2026-02-25 11:35:22',0,'main',0),(7,'طاولة 7',0,'2026-02-16 12:44:50','2026-02-16 12:44:50',0,'main',0),(8,'طاولة 8',0,'2026-02-16 12:44:50','2026-02-25 11:34:37',0,'main',0),(9,'طاولة 9',0,'2026-02-16 12:44:50','2026-02-25 11:35:09',0,'main',0),(10,'طاولة 10',1,'2026-02-16 12:44:50','2026-03-02 13:32:24',0,'main',0),(11,'طاولة 11',1,'2026-02-16 12:44:50','2026-03-01 12:23:24',0,'main',0),(12,'طاولة 12',0,'2026-02-16 12:44:50','2026-02-16 12:44:50',0,'main',0);
/*!40000 ALTER TABLE `tables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `ch_tybe` int(11) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `user` int(11) DEFAULT NULL,
  `tasktybe` int(11) DEFAULT NULL,
  `important` tinyint(1) DEFAULT NULL,
  `urgent` tinyint(1) DEFAULT NULL,
  `emp_comment` varchar(200) DEFAULT NULL,
  `cl_comment` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasktybes`
--

DROP TABLE IF EXISTS `tasktybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasktybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasktybes`
--

LOCK TABLES `tasktybes` WRITE;
/*!40000 ALTER TABLE `tasktybes` DISABLE KEYS */;
/*!40000 ALTER TABLE `tasktybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `test`
--

DROP TABLE IF EXISTS `test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `test` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` varchar(255) DEFAULT 'Active',
  `name` varchar(50) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `test` varchar(1) DEFAULT NULL,
  `time` time DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `test`
--

LOCK TABLES `test` WRITE;
/*!40000 ALTER TABLE `test` DISABLE KEYS */;
/*!40000 ALTER TABLE `test` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `towns`
--

DROP TABLE IF EXISTS `towns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `towns` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `towns`
--

LOCK TABLES `towns` WRITE;
/*!40000 ALTER TABLE `towns` DISABLE KEYS */;
INSERT INTO `towns` VALUES (1,'القاهرة','القاهرة','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(2,'الإسكندرية','الإسكندرية','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18'),(3,'الجيزة','الجيزة','2026-02-23 12:19:18',0,0,0,'2026-02-23 10:19:18','2026-02-23 10:19:18');
/*!40000 ALTER TABLE `towns` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tdate` date DEFAULT NULL,
  `details` varchar(200) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uname` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `usertype` int(11) DEFAULT NULL,
  `userrole` int(11) DEFAULT 1,
  `img` varchar(255) DEFAULT NULL,
  `def_client` int(11) DEFAULT NULL,
  `def_fund` int(11) DEFAULT NULL,
  `def_store` int(11) DEFAULT NULL,
  `def_prod` int(11) DEFAULT NULL,
  `def_emp` int(11) DEFAULT NULL,
  `tasksindex` int(11) DEFAULT NULL,
  `tasksadd` int(11) DEFAULT NULL,
  `tasksedit` int(11) DEFAULT NULL,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin','$2y$10$evySEvXqssqflRswKtuxP.cnpLjJaDrFwXbiXYNdeD8IR1VIHwlUa','2022-12-05 13:01:33',0,2,1,'22947314.png',NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,0,0,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usr_pwrs`
--

DROP TABLE IF EXISTS `usr_pwrs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usr_pwrs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rollname` varchar(50) DEFAULT NULL,
  `is_active` int(11) DEFAULT 1,
  `is_fav_users` int(11) DEFAULT 0,
  `show_users` int(11) DEFAULT 1,
  `add_users` int(11) DEFAULT 1,
  `edit_users` int(11) DEFAULT 1,
  `delete_users` int(11) DEFAULT 1,
  `is_fav_general_entrys` int(11) DEFAULT 0,
  `show_general_entrys` int(11) DEFAULT 1,
  `add_general_entrys` int(11) DEFAULT 1,
  `edit_general_entrys` int(11) DEFAULT 1,
  `delete_general_entrys` int(11) DEFAULT 1,
  `is_fav_clients` int(11) DEFAULT 0,
  `show_clients` int(11) DEFAULT 1,
  `add_clients` int(11) DEFAULT 1,
  `edit_clients` int(11) DEFAULT 1,
  `is_fav_suppliers` int(11) DEFAULT 0,
  `delete_clients` int(11) DEFAULT 1,
  `show_suppliers` int(11) DEFAULT 1,
  `add_suppliers` int(11) DEFAULT 1,
  `edit_suppliers` int(11) DEFAULT 1,
  `delete_suppliers` int(11) DEFAULT 1,
  `is_fav_funds` int(11) DEFAULT 0,
  `show_funds` int(11) DEFAULT 1,
  `add_funds` int(11) DEFAULT 1,
  `edit_funds` int(11) DEFAULT 1,
  `delete_funds` int(11) DEFAULT 1,
  `is_fav_banks` int(11) DEFAULT 0,
  `show_banks` int(11) DEFAULT 1,
  `add_banks` int(11) DEFAULT 1,
  `edit_banks` int(11) DEFAULT 1,
  `delete_banks` int(11) DEFAULT 1,
  `is_fav_stock` int(11) DEFAULT 0,
  `show_stock` int(11) DEFAULT 1,
  `add_stock` int(11) DEFAULT 1,
  `edit_stock` int(11) DEFAULT 1,
  `delete_stock` int(11) DEFAULT 1,
  `is_fav_expenses` int(11) DEFAULT 0,
  `show_expenses` int(11) DEFAULT 1,
  `add_expenses` int(11) DEFAULT 1,
  `edit_expenses` int(11) DEFAULT 1,
  `delete_expenses` int(11) DEFAULT 1,
  `is_fav_revenuses` int(11) DEFAULT 0,
  `show_revenuses` int(11) DEFAULT 1,
  `add_revenuses` int(11) DEFAULT 1,
  `edit_revenuses` int(11) DEFAULT 1,
  `delete_revenuses` int(11) DEFAULT 1,
  `is_fav_credits` int(11) DEFAULT 0,
  `show_credits` int(11) DEFAULT 1,
  `add_credits` int(11) DEFAULT 1,
  `edit_credits` int(11) DEFAULT 1,
  `delete_credits` int(11) DEFAULT 1,
  `is_fav_depits` int(11) DEFAULT 0,
  `show_depits` int(11) DEFAULT 1,
  `add_depits` int(11) DEFAULT 1,
  `edit_depits` int(11) DEFAULT 1,
  `delete_depits` int(11) DEFAULT 1,
  `is_fav_partners` int(11) DEFAULT 0,
  `show_partners` int(11) DEFAULT 1,
  `add_partners` int(11) DEFAULT 1,
  `edit_partners` int(11) DEFAULT 1,
  `delete_partners` int(11) DEFAULT 1,
  `is_fav_assets` int(11) DEFAULT 0,
  `show_assets` int(11) DEFAULT 1,
  `add_assets` int(11) DEFAULT 1,
  `edit_assets` int(11) DEFAULT 1,
  `delete_assets` int(11) DEFAULT 1,
  `is_fav_rentables` int(11) DEFAULT 0,
  `show_rentables` int(11) DEFAULT 1,
  `add_rentables` int(11) DEFAULT 1,
  `edit_rentables` int(11) DEFAULT 1,
  `delete_rentables` int(11) DEFAULT 1,
  `is_fav_employees` int(11) DEFAULT 0,
  `show_employees` int(11) DEFAULT 1,
  `add_employees` int(11) DEFAULT 1,
  `edit_employees` int(11) DEFAULT 1,
  `delete_employees` int(11) DEFAULT 1,
  `is_fav_items` int(11) DEFAULT 0,
  `show_items` int(11) DEFAULT 1,
  `add_items` int(11) DEFAULT 1,
  `edit_items` int(11) DEFAULT 1,
  `delete_items` int(11) DEFAULT 1,
  `is_fav_item_groups` int(11) DEFAULT 0,
  `show_item_groups` int(11) DEFAULT 1,
  `add_item_groups` int(11) DEFAULT 1,
  `edit_item_groups` int(11) DEFAULT 1,
  `delete_item_groups` int(11) DEFAULT 1,
  `is_fav_sales` int(11) DEFAULT 0,
  `show_sales` int(11) DEFAULT 1,
  `add_sales` int(11) DEFAULT 1,
  `edit_sales` int(11) DEFAULT 1,
  `delete_sales` int(11) DEFAULT 1,
  `is_fav_resale` int(11) DEFAULT 0,
  `show_resale` int(11) DEFAULT 1,
  `add_resale` int(11) DEFAULT 1,
  `edit_resale` int(11) DEFAULT 1,
  `delete_resale` int(11) DEFAULT 1,
  `is_fav_purcases` int(11) DEFAULT 0,
  `show_purchases` int(11) DEFAULT 1,
  `add_purchases` int(11) DEFAULT 1,
  `edit_purchases` int(11) DEFAULT 1,
  `delete_purchases` int(11) DEFAULT 1,
  `is_fav_repurchases` int(11) DEFAULT 0,
  `show_repurchases` int(11) DEFAULT 1,
  `add_repurchases` int(11) DEFAULT 1,
  `edit_repurchases` int(11) DEFAULT 1,
  `delete_repurchases` int(11) DEFAULT 1,
  `is_fav_recive` int(11) DEFAULT 0,
  `show_recive` int(11) DEFAULT 1,
  `add_recive` int(11) DEFAULT 1,
  `edit_recive` int(11) DEFAULT 1,
  `delete_recive` int(11) DEFAULT 1,
  `show_payment` int(11) DEFAULT 1,
  `is_fav_payment` int(11) DEFAULT 0,
  `add_payment` int(11) DEFAULT 1,
  `edit_payment` int(11) DEFAULT 1,
  `delete_payment` int(11) DEFAULT 1,
  `is_fav_clinic_clients` int(11) DEFAULT 0,
  `show_clinic_clients` int(11) DEFAULT 1,
  `add_clinic_clients` int(11) DEFAULT 1,
  `edit_clinic_clients` int(11) DEFAULT 1,
  `delete_clinic_clients` int(11) DEFAULT 1,
  `is_fav_reservations` int(11) DEFAULT 0,
  `show_reservations` int(11) DEFAULT 1,
  `add_reservations` int(11) DEFAULT 1,
  `edit_reservations` int(11) DEFAULT 1,
  `delete_reservations` int(11) DEFAULT 1,
  `is_fav_drugs` int(11) DEFAULT 0,
  `show_drugs` int(11) DEFAULT 1,
  `add_drugs` int(11) DEFAULT 1,
  `edit_drugs` int(11) DEFAULT 1,
  `is_fav_attandance` int(11) DEFAULT 1,
  `delete_attandance` int(11) DEFAULT 1,
  `edit_attandance` int(11) DEFAULT 1,
  `show_attandance` int(11) DEFAULT 1,
  `add_attandance` int(11) DEFAULT 1,
  `delete_drugs` int(11) DEFAULT 1,
  `is_fav_client_profile` int(11) DEFAULT 0,
  `show_client_profile` int(11) DEFAULT 1,
  `add_client_profile` int(11) DEFAULT 1,
  `edit_client_profile` int(11) DEFAULT 1,
  `delete_client_profile` int(11) DEFAULT 1,
  `is_fav_advanced_clients` int(11) DEFAULT 0,
  `show_advanced_clients` int(11) DEFAULT 1,
  `add_advanced_clients` int(11) DEFAULT 1,
  `edit_advanced_clients` int(11) DEFAULT 1,
  `delete_advanced_clients` int(11) DEFAULT 1,
  `is_fav_chances` int(11) DEFAULT 0,
  `show_chances` int(11) DEFAULT 1,
  `add_chances` int(11) DEFAULT 1,
  `edit_chances` int(11) DEFAULT 1,
  `delete_chances` int(11) DEFAULT 1,
  `is_fav_calls` int(11) DEFAULT 0,
  `show_calls` int(11) DEFAULT 1,
  `add_calls` int(11) DEFAULT 1,
  `edit_calls` int(11) DEFAULT 1,
  `delete_calls` int(11) DEFAULT 1,
  `is_fav_journals` int(11) DEFAULT 0,
  `show_journals` int(11) DEFAULT 1,
  `add_journals` int(11) DEFAULT 1,
  `edit_journals` int(11) DEFAULT 1,
  `delete_journals` int(11) DEFAULT 1,
  `show_gl_reports` int(11) DEFAULT 1,
  `show_clinic_reports` int(11) DEFAULT 1,
  `show_rent_reports` int(11) DEFAULT 1,
  `show_payroll_report` int(11) DEFAULT 1,
  `show_hr_report` int(11) DEFAULT 1,
  `sid_entry` int(11) DEFAULT 1,
  `sid_stock` int(11) DEFAULT 1,
  `sid_sales` int(11) DEFAULT 1,
  `sid_purchases` int(11) DEFAULT 1,
  `sid_vouchers` int(11) DEFAULT 1,
  `sid_clinics` int(11) DEFAULT 1,
  `sid_crm` int(11) DEFAULT 1,
  `sid_accounts` int(11) DEFAULT 1,
  `sid_assets` int(11) DEFAULT 1,
  `sid_reports` int(11) DEFAULT 1,
  `sid_hr` int(11) DEFAULT 1,
  `sid_payroll` int(11) DEFAULT 1,
  `sid_rents` int(11) DEFAULT 1,
  `show_total_reservation` int(11) DEFAULT 1,
  `show_ended_reservation` int(11) DEFAULT 1,
  `info` varchar(250) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `show_all_tasks` tinyint(1) DEFAULT NULL,
  `show_main_cards` tinyint(1) DEFAULT 1,
  `show_main_elements` tinyint(1) DEFAULT 1,
  `show_main_tables` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usr_pwrs`
--

LOCK TABLES `usr_pwrs` WRITE;
/*!40000 ALTER TABLE `usr_pwrs` DISABLE KEYS */;
/*!40000 ALTER TABLE `usr_pwrs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vacancies`
--

DROP TABLE IF EXISTS `vacancies`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vacancies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `info` text DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vacancies`
--

LOCK TABLES `vacancies` WRITE;
/*!40000 ALTER TABLE `vacancies` DISABLE KEYS */;
/*!40000 ALTER TABLE `vacancies` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visits`
--

DROP TABLE IF EXISTS `visits`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visits` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `client` int(11) DEFAULT NULL,
  `complaint` varchar(250) DEFAULT NULL,
  `diagnosis` varchar(250) DEFAULT NULL,
  `recommendation` varchar(250) DEFAULT NULL,
  `prescription` varchar(250) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `mdtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `info` varchar(255) DEFAULT NULL,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visits`
--

LOCK TABLES `visits` WRITE;
/*!40000 ALTER TABLE `visits` DISABLE KEYS */;
/*!40000 ALTER TABLE `visits` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `visittybes`
--

DROP TABLE IF EXISTS `visittybes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visittybes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `value` decimal(8,2) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `visittybes`
--

LOCK TABLES `visittybes` WRITE;
/*!40000 ALTER TABLE `visittybes` DISABLE KEYS */;
/*!40000 ALTER TABLE `visittybes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zankat`
--

DROP TABLE IF EXISTS `zankat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zankat` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zname` varchar(255) DEFAULT NULL,
  `colors` tinyint(1) DEFAULT 1,
  `ctp` tinyint(1) DEFAULT NULL,
  `zncase` tinyint(1) DEFAULT NULL,
  `print` tinyint(1) DEFAULT NULL,
  `ptype` tinyint(1) DEFAULT NULL,
  `service` tinyint(1) DEFAULT NULL,
  `prod` tinyint(1) DEFAULT NULL,
  `measure` tinyint(1) DEFAULT NULL,
  `draw` tinyint(1) DEFAULT NULL,
  `farkh` tinyint(1) DEFAULT NULL,
  `info` varchar(255) DEFAULT NULL,
  `crtime` timestamp NOT NULL DEFAULT current_timestamp(),
  `date` varchar(255) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `fatid` int(11) DEFAULT 0,
  `isdeleted` tinyint(1) DEFAULT 0,
  `tenant` int(11) DEFAULT 0,
  `branch` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zankat`
--

LOCK TABLES `zankat` WRITE;
/*!40000 ALTER TABLE `zankat` DISABLE KEYS */;
/*!40000 ALTER TABLE `zankat` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-07 15:06:56
