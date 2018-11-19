-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: r_internal
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.13-MariaDB

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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `remake` varchar(200) DEFAULT NULL,
  `type` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `updated_time` int(11) DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `deleted_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,0,'Áo dàii','Không biết','',0,0,1,1487862681,NULL,1489387305,NULL,NULL),(2,0,'Áo ngắn','Sắp biết','Kh&ocirc;ng',0,0,1,1487862681,NULL,1488255239,NULL,NULL),(3,1,'Áo dài lụa','Suýt biết','zzz',1,1,1,1487862689,NULL,NULL,NULL,NULL),(4,1,'Áo dài đính đá','','',0,0,NULL,NULL,NULL,1488247418,NULL,1488256301),(5,2,'Áo phông','','',0,0,NULL,NULL,NULL,1489387429,NULL,NULL),(6,2,'Áo sơ mi','','',0,0,NULL,NULL,NULL,1489387320,NULL,NULL),(7,2,'Quần bò','','',0,0,NULL,1487921899,NULL,1488249578,NULL,1488250477),(8,0,'Quần đùi','','',0,0,NULL,1488178852,NULL,1488178889,NULL,NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `created_id` int(11) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  `updated_id` int(11) DEFAULT NULL,
  `updated_time` int(11) DEFAULT NULL,
  `deleted_id` int(11) DEFAULT NULL,
  `deleted_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `department`
--

LOCK TABLES `department` WRITE;
/*!40000 ALTER TABLE `department` DISABLE KEYS */;
INSERT INTO `department` VALUES (1,'Develope','dev',NULL,0,1,NULL,NULL,NULL,NULL,NULL),(2,'Test','test',NULL,1,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `module`
--

DROP TABLE IF EXISTS `module`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `status` int(11) DEFAULT '0',
  `remake` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
INSERT INTO `module` VALUES (1,'Create role',1,NULL),(2,'Edit role',1,NULL),(3,'Media',0,NULL),(4,'Change data',1,NULL),(5,'Comment',0,NULL),(6,'Files',0,NULL);
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permission_roles`
--

DROP TABLE IF EXISTS `permission_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permission_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module_id` int(11) NOT NULL,
  `roles_id` int(11) NOT NULL,
  `read` tinyint(4) DEFAULT '0',
  `write` tinyint(4) DEFAULT '0',
  `deletable` tinyint(4) NOT NULL DEFAULT '0',
  `confirm` tinyint(4) NOT NULL DEFAULT '0',
  `comment` tinyint(4) NOT NULL DEFAULT '0',
  `import` tinyint(4) NOT NULL DEFAULT '0',
  `export` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permission_roles`
--

LOCK TABLES `permission_roles` WRITE;
/*!40000 ALTER TABLE `permission_roles` DISABLE KEYS */;
INSERT INTO `permission_roles` VALUES (1,1,8,1,1,0,0,1,0,0),(2,2,8,0,1,0,1,0,1,0),(3,3,8,1,0,1,0,1,0,0),(4,4,8,0,0,0,1,0,1,0),(5,5,8,0,0,0,0,1,0,1),(8,6,8,0,0,1,0,0,0,0),(10,1,9,0,1,0,0,0,0,1),(11,2,9,0,1,0,0,0,1,0),(12,3,9,0,0,0,0,0,0,0),(13,4,9,0,0,0,0,0,0,0),(14,5,9,0,0,0,0,0,0,0),(15,6,9,0,0,1,0,0,0,0),(16,1,10,0,0,0,0,0,0,0),(17,2,10,0,0,0,0,0,1,0),(18,3,10,0,0,0,0,1,0,0),(19,4,10,0,0,0,1,0,0,0),(20,5,10,0,0,1,0,0,0,0),(21,6,10,0,0,0,0,0,1,0);
/*!40000 ALTER TABLE `permission_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `remake` varchar(150) DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - owner\n1 - other',
  `slug` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (8,'Admin',1,NULL,1,NULL),(9,'Manager',0,NULL,0,NULL),(10,'Team leader',0,NULL,0,NULL),(11,'Employee',0,'',0,NULL),(12,'User',0,NULL,0,NULL),(23,'Test user 2',0,'',0,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `token_api`
--

DROP TABLE IF EXISTS `token_api`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `token_api` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `public_key` varchar(200) NOT NULL,
  `private_key` varchar(200) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 - un user\n1 - used',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `token_api`
--

LOCK TABLES `token_api` WRITE;
/*!40000 ALTER TABLE `token_api` DISABLE KEYS */;
/*!40000 ALTER TABLE `token_api` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(75) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(70) DEFAULT NULL,
  `last_name` varchar(70) DEFAULT NULL,
  `name_kana` varchar(100) DEFAULT NULL,
  `phone_number` varchar(45) DEFAULT NULL,
  `facebook` varchar(100) DEFAULT NULL,
  `google` varchar(100) DEFAULT NULL,
  `avatar` bigint(20) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `roles` int(11) DEFAULT NULL,
  `confirmation_code` varchar(100) DEFAULT NULL,
  `confirmed` tinyint(4) DEFAULT NULL,
  `confirmed_time` int(11) DEFAULT NULL,
  `end_time_confirm` int(11) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `token_reset_password` varchar(100) DEFAULT NULL,
  `resert_password_time` int(11) DEFAULT NULL,
  `created_time` int(11) DEFAULT NULL,
  `updated_time` int(11) DEFAULT NULL,
  `deleted_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'owner','namdhgc@gmail.com','$2y$10$KBRqq.oWW5LVEHvvF1Y0bubBYvluOkOupmhnuCtiuK2AVBR3pW.cm',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-15 13:39:36
