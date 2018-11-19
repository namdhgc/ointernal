-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: insight_internal
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.22-MariaDB

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `createdById` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `createdById` (`createdById`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `postId` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `createdById` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `postId` (`postId`),
  KEY `createdById` (`createdById`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`createdById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'Develop','','22 Floor','2016-12-15 00:00:00','2016-12-15 00:00:00'),(2,'Test','','22 Floor','0000-00-00 00:00:00','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serial_no` varchar(20) NOT NULL,
  `name` varchar(64) NOT NULL,
  `bydate` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `note` varchar(128) NOT NULL,
  `createdById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `createdById` (`createdById`),
  CONSTRAINT `device_ibfk_1` FOREIGN KEY (`createdById`) REFERENCES `employee` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device`
--

LOCK TABLES `device` WRITE;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;
/*!40000 ALTER TABLE `device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document`
--

DROP TABLE IF EXISTS `document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `createById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `deleted_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `createById` (`createById`),
  CONSTRAINT `document_ibfk_1` FOREIGN KEY (`createById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document`
--

LOCK TABLES `document` WRITE;
/*!40000 ALTER TABLE `document` DISABLE KEYS */;
/*!40000 ALTER TABLE `document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `employeeCode` varchar(10) NOT NULL,
  `password` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `displayName` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthday` date NOT NULL,
  `address1` varchar(1024) NOT NULL,
  `address2` varchar(1024) DEFAULT NULL,
  `phone_number` varchar(200) NOT NULL,
  `probationary` date DEFAULT NULL,
  `official_date` date DEFAULT NULL,
  `out_date` date DEFAULT NULL,
  `position` smallint(6) DEFAULT NULL,
  `managerId` int(11) DEFAULT NULL,
  `departmentId` int(11) NOT NULL,
  `diplomaId` smallint(6) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` varchar(1024) DEFAULT NULL,
  `avatar_name` varchar(64) DEFAULT NULL,
  `avatar_path` varchar(256) DEFAULT NULL,
  `holiday_allowance` int(11) DEFAULT NULL,
  `createdById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `remember_token` varchar(80) DEFAULT NULL,
  `is_manager` tinyint(1) DEFAULT NULL,
  `roleId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `id` (`id`),
  KEY `managerId` (`managerId`),
  KEY `departmentId` (`departmentId`),
  KEY `diplomaId` (`diplomaId`),
  KEY `createdById` (`createdById`),
  CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`departmentId`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`createdById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES (1,'Lưu Hữu','Chuẩn','1','$2y$10$O7QbGjDj/XW0J.VzDkU5PO2KQMjua.bYbBa4KsDtIfNcnYeA0fS0m','Lưu Hữu Chuẩn','chuanlh@insight-tec.com.vn',1,'1992-06-20','ss',NULL,'0966200692','2017-02-20','2016-12-08',NULL,8,1,1,1,1,NULL,'chuan','chuan',1,1,'2016-12-14 00:00:00','2016-12-30 00:00:00','ZkOcwGpiF6JXv7R7TAavMBy7i6dN87uiBdOT6KOlqratGFLHaIo9vWb8TnxO',0,2),(2,'Đinh Hoài','Nam','2','$2y$10$O7QbGjDj/XW0J.VzDkU5PO2KQMjua.bYbBa4KsDtIfNcnYeA0fS0m','Đinh Hoài Nam','namdh@insight-tec.com.vn',1,'1992-06-20','Tây Sơn',NULL,'0966200692','2016-11-08','2016-12-08',NULL,8,1,1,1,1,NULL,'chuan','chuan',1,1,'2016-12-14 00:00:00','2016-12-30 00:00:00','K7rU0fDBvrIpsKLjbdE6WJ5DlMD6nkE1LzAFl15VRSqEVbm0g1WnBY7ZvWtN',0,1),(3,'Văn A','Nguyễn','dev001','$2y$10$O7QbGjDj/XW0J.VzDkU5PO2KQMjua.bYbBa4KsDtIfNcnYeA0fS0m','Nguyễn Văn A','anv@insight-tec',0,'2017-01-02','Hà Nội',NULL,'0123',NULL,'2017-01-12','2017-02-02',NULL,NULL,1,NULL,0,NULL,NULL,NULL,NULL,2,'2017-01-12 09:36:49','2017-01-12 09:36:49',NULL,0,3),(80,'Anh','Hồ','DEV005','$2y$10$juZFCiHd61F5z9H.TjZNUOQQ1cceQB2VmLwRPCteABQoZUbANUZNC','Hồ Anh','vietanhho152@gmail.com',1,'1999-02-09','asd',NULL,'123',NULL,'2016-12-05','2017-02-05',12,1,1,1,0,NULL,NULL,NULL,NULL,2,'2017-01-13 15:13:42','2017-01-13 15:13:42',NULL,NULL,3),(93,'Minh','Lê','minhl','$2y$10$rrMy2xrmiQkAkQbaUkP.uOTJJ4b3eWK7ObmJc5WG7qRM/LscpZ1im','Lê Minh','minhle@insight-tec.com.vn',1,'1990-03-28','Số 10A ngách 325/105 Thanh Lương Hai Bà Trưng Hà Nội Việt Nam',NULL,'0978169505',NULL,NULL,NULL,6,NULL,1,1,1,NULL,NULL,NULL,NULL,2,'2017-01-16 14:23:02','2017-01-16 14:23:02','m6zVorSBPlZO1Yg8t7yqjxJRlJOqxeNAQ2o7Q2C4XnNZvcPG9Hx5fBVSwxzn',NULL,2),(95,'Minh','Lê','minhl','$2y$10$kNRQh.P/v0cNHFDzLDnZ9ee1kpvus2Gm3UDkFB0L18p/yRiFFRqAG','Lê Minh','leminh2803@gmail.com',1,'1990-03-28','Số 10A ngách 325/105 Thanh Lương Hai Bà Trưng Hà Nội Việt Nam',NULL,'0978169505',NULL,NULL,NULL,5,NULL,1,2,1,NULL,NULL,NULL,NULL,93,'2017-01-16 14:46:43','2017-01-16 14:46:43',NULL,NULL,2),(107,'柏木','武志','dev-001','$2y$10$n4AqTiSWd3ie/MHCy2bsnOaiAKVFrvfd2Ta9dxewGc.Bv9Fm1iWAm','武志 柏木','kashiwagi@insight-tec.com.vn',1,'1981-07-16','Insight-tec',NULL,'0123456789',NULL,'2016-12-05','2017-02-08',2,NULL,1,1,0,NULL,NULL,NULL,NULL,2,'2017-01-23 14:09:36','2017-01-23 14:09:36',NULL,NULL,2),(119,'Diệp','Nguyễn','dev-004','$2y$10$gsLEv0Z4SRREaBMo8z9N.OOtZtVuSP8pQ.axGlxw07UV/hMK8k1ka','Nguyễn Diệp','dieploosy@gmail.com',2,'1997-06-11','không biết',NULL,'0123123123123',NULL,NULL,NULL,11,NULL,1,1,1,NULL,NULL,NULL,NULL,2,'2017-01-24 14:25:30','2017-01-24 14:25:30','TQIvJRIFFCK9VK7fWRoeGkUFxBfA499OTMBDzDcGVqi0sKp22hMhAXDTX6Xq',NULL,1),(126,'Viet Anh','Ho','HoVA','$2y$10$HbNCnf8ua7rJ1rSEWbnP0uiHAThAeUp7JqmXHczfGMZqkcMx3CzYG','Ho Viet Anh','bohiphop96@gmail.com',1,'2017-01-10','Hanoi',NULL,'0984999999',NULL,'2016-09-20','2017-02-07',12,NULL,2,2,0,NULL,NULL,NULL,NULL,2,'2017-01-24 15:03:04','2017-01-24 15:03:04',NULL,NULL,2),(127,'Thu Hoài','Tưởng','NS-001','$2y$10$W2NkoezsPZhiSjFnYffDiuO4Tf/6VKderzwkgBjWBJLojO/OX1WA.','Tưởng Thu Hoài','hoaitt@insight-tec.com.vn',2,'1986-06-12','Chưa biết',NULL,'0123456789',NULL,NULL,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,NULL,2,'2017-02-20 09:00:13','2017-02-20 09:00:13',NULL,NULL,1),(128,'Anh Tuấn','Đào','Dev-007','$2y$10$JefPjosyxmUmUKgmzB9To.LY0nkuYSUnuEmgJ.bDwV1bKMr3rF8YS','Đào Anh Tuấn','tuanda@insight-tec.com.vn',1,'1990-06-14','Chưa biết',NULL,'0123456789',NULL,NULL,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,NULL,2,'2017-02-20 10:59:39','2017-02-20 10:59:39',NULL,NULL,2),(131,'Xuân Hoà','Lê','dev-008','$2y$10$TPyrKkVYWehbFtCcgUtcQ.G3cLdXKHYdlnx4.anQXw9CsXfTpiRbS','Lê Xuân Hoà','hoalx@insight-tec.com.vn',1,'1983-06-16','Chưa biết',NULL,'0123456789',NULL,NULL,NULL,NULL,NULL,1,1,1,NULL,NULL,NULL,NULL,2,'2017-02-21 10:43:43','2017-02-21 10:43:43',NULL,NULL,2);
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_device_relationship`
--

DROP TABLE IF EXISTS `employee_device_relationship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_device_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `start_hire` datetime NOT NULL,
  `end_hire` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employeeId` (`employeeId`),
  KEY `device_id` (`device_id`),
  CONSTRAINT `employee_device_relationship_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_device_relationship_ibfk_2` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_device_relationship`
--

LOCK TABLES `employee_device_relationship` WRITE;
/*!40000 ALTER TABLE `employee_device_relationship` DISABLE KEYS */;
/*!40000 ALTER TABLE `employee_device_relationship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee_role_relationship`
--

DROP TABLE IF EXISTS `employee_role_relationship`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee_role_relationship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `employeeId` (`employeeId`),
  KEY `roleId` (`roleId`),
  CONSTRAINT `employee_role_relationship_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `employee_role_relationship_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee_role_relationship`
--

LOCK TABLES `employee_role_relationship` WRITE;
/*!40000 ALTER TABLE `employee_role_relationship` DISABLE KEYS */;
INSERT INTO `employee_role_relationship` VALUES (1,1,2),(2,2,1),(14,80,1),(24,93,1),(25,95,2),(26,107,1),(38,119,1),(45,126,2),(46,127,1),(47,128,1),(50,131,1);
/*!40000 ALTER TABLE `employee_role_relationship` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `holiday`
--

DROP TABLE IF EXISTS `holiday`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `holiday` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `approverId` int(11) NOT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `isApproved` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `types` smallint(6) NOT NULL,
  `note` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `employeeId` (`employeeId`),
  CONSTRAINT `holiday_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `holiday`
--

LOCK TABLES `holiday` WRITE;
/*!40000 ALTER TABLE `holiday` DISABLE KEYS */;
INSERT INTO `holiday` VALUES (2,1,2,NULL,0,'2017-01-12 00:20:00','2017-01-12 00:30:00',3,'sda335zzzzzz'),(12,2,1,NULL,0,'2017-01-11 15:25:00','2017-01-13 15:20:00',0,'ghi chu22xzz'),(13,2,2,'2017-01-17 17:02:27',1,'2017-01-01 16:55:00','2017-01-05 16:55:00',0,'Xin nghi'),(14,2,1,'2017-03-10 10:28:09',1,'2017-01-20 09:20:00','2017-01-22 09:30:00',0,'Approved'),(15,1,1,NULL,0,'2017-01-27 09:40:00','2017-01-30 09:25:00',0,'star'),(16,2,1,'2017-03-07 09:52:13',1,'2017-01-13 13:35:00','2017-01-14 13:35:00',0,'take a day off because of sick'),(17,127,1,NULL,0,'2017-02-08 06:05:00','2017-02-11 06:05:00',0,'ll'),(18,2,1,NULL,0,'2017-02-08 14:15:00','2017-02-10 13:50:00',0,'abc');
/*!40000 ALTER TABLE `holiday` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `overtime`
--

DROP TABLE IF EXISTS `overtime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `overtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `date` date NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `approverId` int(11) NOT NULL,
  `typeId` int(11) NOT NULL,
  `approvedDate` date DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT '0',
  `note` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `updated_at` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `overtime`
--

LOCK TABLES `overtime` WRITE;
/*!40000 ALTER TABLE `overtime` DISABLE KEYS */;
INSERT INTO `overtime` VALUES (23,2,'2017-01-09','2017-01-09 10:30:00','2017-01-09 10:35:00',1,0,NULL,0,'gga',123,0),(44,2,'2017-01-10','2017-01-10 17:00:00','2017-01-10 18:00:00',1,0,NULL,0,'safasf',0,0),(45,2,'2017-01-11','2017-01-11 17:05:00','2017-01-11 17:11:00',1,0,NULL,0,'wafaf',0,0),(50,1,'2017-01-01','2017-01-01 16:10:00','2017-01-01 17:30:00',1,0,NULL,0,'',0,0),(53,1,'2016-12-25','2016-12-25 17:30:00','2016-12-25 18:23:00',1,0,'2017-03-07',1,'j',0,0),(56,1,'2017-01-02','2017-01-02 17:30:00','2017-01-02 16:30:00',1,0,NULL,0,'k',0,0),(57,1,'2017-01-02','2017-01-02 17:30:00','2017-01-02 16:30:00',1,0,NULL,0,'k',0,0),(58,1,'2017-01-12','2017-01-12 08:50:00','2017-01-12 09:50:00',1,0,NULL,0,'',0,0),(63,1,'2017-01-02','2017-01-02 09:55:00','2017-01-02 09:55:00',1,0,NULL,0,'1',0,0),(64,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(66,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(67,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(68,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(70,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(71,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(72,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(73,1,'2017-01-08','2017-01-08 08:55:00','2017-01-08 07:10:00',1,0,NULL,0,'nj',0,0),(75,1,'2017-01-11','2017-01-11 10:20:00','2017-01-11 09:20:00',1,0,NULL,0,'g',0,0),(76,1,'2017-01-06','2017-01-06 10:05:00','2017-01-06 10:05:00',1,0,NULL,0,'y',0,0),(78,1,'2017-01-03','2017-01-03 10:45:00','2017-01-03 07:50:00',1,0,NULL,0,'k',0,0),(80,1,'2017-01-03','2017-01-03 13:05:00','2017-01-03 09:05:00',1,0,NULL,0,'c',0,0),(81,2,'2017-01-18','2017-01-18 20:00:00','2017-01-18 22:00:00',1,0,'2017-03-07',1,'safafa sà',0,0),(82,1,'2017-01-02','2017-01-02 12:05:00','2017-01-02 12:05:00',1,0,NULL,0,'',0,0),(83,1,'2017-01-24','2017-01-24 09:40:00','2017-01-24 10:40:00',1,2,NULL,0,'zsdfsf',0,0),(84,2,'2017-05-01','2017-05-01 19:10:00','2017-05-01 22:00:00',1,0,NULL,0,'overtime for SIGLASSs.',0,0);
/*!40000 ALTER TABLE `overtime` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `position`
--

DROP TABLE IF EXISTS `position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `position` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `positionId` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
INSERT INTO `position` VALUES (1,1,'Tổng giám đốc'),(2,2,'Phó giám đốc kinh doanh'),(3,3,'Phó giám đốc tài chính'),(4,4,'Phó giám đốc nhân sự'),(5,5,'Phó giám đốc dự án'),(6,6,'Trưởng phòng'),(7,7,'Phó phòng'),(8,8,'Trưởng nhóm'),(9,9,'Nhân viên chính thức'),(10,10,'Nhân viên thử việc'),(11,11,'Nhân viên làm bán thời gian'),(12,12,'Thực tập sinh');
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post`
--

DROP TABLE IF EXISTS `post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `cateId` int(11) NOT NULL,
  `createById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `title` (`title`),
  KEY `title_2` (`title`),
  KEY `cateId` (`cateId`),
  KEY `createById` (`createById`),
  KEY `title_3` (`title`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`cateId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`createById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post`
--

LOCK TABLES `post` WRITE;
/*!40000 ALTER TABLE `post` DISABLE KEYS */;
/*!40000 ALTER TABLE `post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'Admin','Admin co tat ca cac quyen',NULL,NULL),(2,'TeamLeader','Leader duoc phep thay doi request 1 lan',NULL,NULL),(3,'User','User chi duoc thao tac phia front',NULL,NULL);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workingtime`
--

DROP TABLE IF EXISTS `workingtime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workingtime` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `employeeId` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `totalTimePerDay` bigint(11) DEFAULT NULL,
  `totalTimePerMonth` bigint(11) DEFAULT NULL,
  `note` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`) KEY_BLOCK_SIZE=11,
  KEY `employeeId` (`employeeId`),
  CONSTRAINT `workingtime_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=430 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workingtime`
--

LOCK TABLES `workingtime` WRITE;
/*!40000 ALTER TABLE `workingtime` DISABLE KEYS */;
INSERT INTO `workingtime` VALUES (378,1,'2017-01-06','2017-01-06 13:05:00','2017-01-06 13:58:00',53,53,''),(382,1,'2017-01-08','2017-01-08 15:13:00','2017-01-08 15:14:02',62,115,''),(383,1,'2017-01-09','2017-01-09 11:38:11','2017-01-09 12:01:39',0,115,''),(385,2,'2017-01-18','2017-01-18 15:19:15','2017-01-18 15:26:23',428,428,''),(386,1,'2017-01-23','2017-01-23 09:35:28','2017-01-23 09:39:56',268,383,''),(387,2,'2017-01-23','2017-01-23 13:07:00','2017-01-23 13:14:00',36,464,''),(388,119,'2017-01-24','2017-01-24 14:25:57','2017-01-24 18:03:40',13063,13063,''),(389,119,'2017-02-06','2017-02-06 14:35:08',NULL,NULL,NULL,NULL),(390,119,'2017-02-08','2017-02-08 13:47:15','2017-02-08 18:04:17',15422,15422,''),(391,1,'2017-02-09','2017-02-09 10:57:25','2017-02-09 18:22:55',21330,21330,''),(392,119,'2017-02-09','2017-02-09 13:29:07','2017-02-09 18:20:17',17470,50337,'aadsddf'),(393,2,'2017-02-09','2017-02-09 18:15:35','2017-02-09 18:15:37',2,2,''),(395,1,'2017-02-10','2017-02-10 09:48:00','2017-02-10 14:40:00',12092,33422,'Check out'),(396,119,'2017-02-10','2017-02-10 13:36:00','2017-02-10 18:09:45',16425,65725,'kkook'),(398,2,'2017-02-10','2017-02-10 18:16:48',NULL,NULL,NULL,NULL),(400,2,'2017-02-13','2017-02-13 08:30:00','2017-02-13 11:35:00',40,42,'Found the bug. If any day do not have end time, all the day before can be end many times.'),(401,119,'2017-02-13','2017-02-13 13:24:24',NULL,NULL,NULL,NULL),(402,2,'2017-02-14','2017-02-14 10:34:31',NULL,NULL,NULL,NULL),(403,119,'2017-02-14','2017-02-14 13:06:29',NULL,NULL,NULL,NULL),(404,2,'2017-02-15','2017-02-15 14:59:06','2017-02-15 15:08:05',539,581,''),(406,119,'2017-02-15','2017-02-15 15:11:00',NULL,NULL,NULL,NULL),(407,2,'2017-02-16','2017-02-16 10:11:55','2017-02-16 10:28:25',990,1571,'8h - 10h: coding\r\n10h-12h: íntall'),(408,119,'2017-02-16','2017-02-16 13:19:08',NULL,NULL,NULL,NULL),(409,119,'2017-02-17','2017-02-17 13:26:40',NULL,NULL,NULL,NULL),(410,119,'2017-02-20','2017-02-20 13:07:17',NULL,NULL,NULL,NULL),(412,119,'2017-02-21','2017-02-21 13:14:56',NULL,NULL,NULL,NULL),(413,131,'2017-02-21','2017-02-21 14:03:10',NULL,NULL,NULL,NULL),(414,119,'2017-02-22','2017-02-22 13:07:25',NULL,NULL,NULL,NULL),(415,131,'2017-02-22','2017-02-22 13:28:10','2017-02-22 18:06:20',16690,16690,''),(416,131,'2017-02-23','2017-02-23 11:32:41','2017-02-23 16:10:20',11420,28110,''),(417,127,'2017-02-23','2017-02-23 17:49:06',NULL,NULL,NULL,NULL),(418,119,'2017-02-24','2017-02-24 13:41:38',NULL,NULL,NULL,NULL),(419,131,'2017-02-24','2017-02-24 16:59:40',NULL,NULL,NULL,NULL),(420,119,'2017-02-27','2017-02-27 13:11:37',NULL,NULL,NULL,NULL),(421,131,'2017-03-01','2017-03-01 08:56:13','2017-03-01 12:07:00',9227,9227,''),(422,119,'2017-03-01','2017-03-01 13:16:36',NULL,NULL,NULL,NULL),(423,119,'2017-03-02','2017-03-02 13:05:19','2017-03-02 16:06:34',10875,10875,''),(424,2,'2017-03-02','2017-03-02 14:02:40','2017-03-02 14:02:47',7,7,''),(425,131,'2017-03-02','2017-03-02 15:26:25',NULL,NULL,NULL,NULL),(426,119,'2017-03-03','2017-03-03 13:03:43',NULL,NULL,NULL,NULL),(427,119,'2017-03-06','2017-03-06 13:02:21',NULL,NULL,NULL,NULL),(428,119,'2017-03-07','2017-03-07 13:24:24',NULL,NULL,NULL,NULL),(429,2,'2017-08-18','2017-08-18 11:06:12','2017-08-18 11:06:21',9,9,'');
/*!40000 ALTER TABLE `workingtime` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-18 13:21:36
