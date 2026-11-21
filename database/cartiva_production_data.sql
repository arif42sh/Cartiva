-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cartiva_db
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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `entity_type` varchar(100) DEFAULT NULL,
  `entity_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `activity_logs_user_id_foreign` (`user_id`),
  CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,1,'system_boot','Platform operations and scheduler started.','127.0.0.1','System',1,'2026-10-23 13:03:21'),(2,1,'seller_approved','Merchant Apex Tech & Lifestyle Hub verified and approved.','127.0.0.1','User',2,'2026-10-23 13:03:21'),(3,1,'cron_executed','Automatic 24-hr group expiration check completed without failures.','127.0.0.1','Scheduler',1,'2026-10-23 13:03:21'),(4,1,'product_featured','Product \'Iphone\' marked as Hot Deal.','127.0.0.1','Product',22,'2026-10-23 19:42:22');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `announcements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'banner_top',
  `target_audience` varchar(30) NOT NULL DEFAULT 'all',
  `action_url` varchar(255) DEFAULT NULL,
  `action_label` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `announcements_created_by_foreign` (`created_by`),
  KEY `announcements_is_active_index` (`is_active`),
  CONSTRAINT `announcements_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `announcements`
--

LOCK TABLES `announcements` WRITE;
/*!40000 ALTER TABLE `announcements` DISABLE KEYS */;
INSERT INTO `announcements` VALUES (1,'Mega Winter Flash Sale & Group Pools Open!','Team up with friends to unlock up to 60% bulk discount on electronics and winter fashion. Free express courier delivery on all team orders.','banner_top','all','/hot-deals','Explore Deals',1,1,'2026-10-23 13:03:21','2026-10-23 13:03:21'),(2,'Important Seller Delivery Policy Update','Merchants are required to dispatch orders within 24 hours of group unlock. Late dispatch penalty applies after 48 hours.','broadcast_alert','sellers','/seller/dashboard','Read Guidelines',1,1,'2026-10-23 13:03:21','2026-10-23 13:03:21');
/*!40000 ALTER TABLE `announcements` ENABLE KEYS */;
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
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'Smart Tech & Audio','smart-tech-audio','🎧','Premium noise-cancelling headphones, wireless earbuds, and smart accessories',1,0,'2026-10-09 02:46:29','2026-10-09 02:46:29'),(2,'Wearables & Watches','wearables-watches','⌚','Next-gen fitness trackers, titanium smartwatches, and stylish bands',1,0,'2026-10-09 02:46:29','2026-10-09 02:46:29'),(3,'Computing & Gaming','computing-gaming','💻','Mechanical keyboards, ergonomic setups, and productivity gadgets',1,0,'2026-10-09 02:46:29','2026-10-09 02:46:29'),(4,'Home & Living','home-living','☕','Modern espresso machines, ambient desk lamps, and air purifiers',1,0,'2026-10-09 02:46:29','2026-10-09 02:46:29'),(5,'Fashion & Bags','fashion-bags','🎒','Waterproof commuter backpacks, minimalist wallets, and sunglasses',1,0,'2026-10-09 02:46:29','2026-10-09 02:46:29'),(6,'ইলেকট্রনিক্স (Electronics)','tech-accessories','🎧','স্মার্ট গ্যাজেটস, নয়েজ ক্যান্সেলিং হেডফোন, কিবোর্ড ও পাওয়ার ব্যাংক',1,0,'2026-10-09 03:04:32','2026-10-11 07:00:44'),(7,'গ্রোসারি ও খাদ্যদ্রব্য (Grocery & Food)','dry-food-fmcg','🥫','প্যাকেজড প্রিমিয়াম বাদাম, মধু, অর্গানিক চা ও গ্রোসারি কম্বো',1,0,'2026-10-09 03:04:32','2026-10-11 07:00:44'),(8,'হোম ও লিভিং (Home & Living)','home-lifestyle','🏠','মডার্ন ফার্নিচার, রিডিং ল্যাম্প ও হোম ডেকর এক্সেসরিজ',1,0,'2026-10-09 03:04:32','2026-10-11 07:00:44'),(9,'উইন্টার ও লাইফস্টাইল (Winter & Lifestyle)','winter-specials','🧥','প্রিমিয়াম উইন্টার হুডি, ওয়াটারপ্রুফ ট্রাভেল ব্যাগ ও কমফোর্ট এক্সেসরিজ',1,0,'2026-10-09 03:04:32','2026-10-11 10:53:46'),(10,'ফ্যাশন ও পোশাক (Fashion & Apparel)','fashion-wearables','👕','স্মার্টওয়াচ, সানগ্লাস, উইন্টার কালেকশন ও প্রিমিয়াম আউটফিট',1,0,'2026-10-09 03:04:32','2026-10-11 07:00:44'),(11,'মোবাইল ও এক্সেসরিজ (Mobile & Accessories)','mobile-accessories','📱','ফাস্ট চার্জার, ম্যাগসেফ কেস, পাওয়ার ব্যাংক ও ওটিজি ক্যাবল',1,0,'2026-10-11 07:00:44','2026-10-11 07:00:44'),(12,'কম্পিউটার ও ল্যাপটপ (Computers & IT)','computers-accessories','💻','মেকানিক্যাল কিবোর্ড, ওয়্যারলেস মাউস, ইউএসবি হাব ও মনিটর স্ট্যান্ড',1,0,'2026-10-11 07:00:44','2026-10-11 07:00:44'),(13,'বিউটি ও কেয়ার (Beauty & Care)','beauty-personal-care','✨','অর্গানিক স্কিনকেয়ার, সানস্ক্রিন ও পারসোনাল হাইজিন কিট',1,0,'2026-10-11 07:00:44','2026-10-11 07:00:44'),(14,'কিচেন ও অ্যাপ্লায়েন্স (Kitchen Appliances)','kitchen-appliances','🍳','এয়ার ফ্রায়ার, ব্লেন্ডার, ইলেকট্রিক কেটলি ও কফি মেকার',1,0,'2026-10-11 07:00:44','2026-10-11 07:00:44'),(15,'স্পোর্টস ও ফিটনেস (Sports & Fitness)','sports-fitness','🏋️','জিম ডাম্বেল, রেজিস্ট্যান্স ব্যান্ড, ইয়োগা ম্যাট ও শেকার',1,0,'2026-10-11 07:00:44','2026-10-11 07:00:44'),(16,'বই ও স্টেশনারি (Books & Stationery)','books-stationery','📚','একাডেমিক বই, প্রিমিয়াম জার্নাল, ফাউন্টেন পেন ও ক্যালকুলেটর',1,0,'2026-10-11 07:00:44','2026-10-11 07:00:44'),(17,'বেবি ও কিডস (Baby & Kids)','baby-kids','🧸','বেবি ডায়াপার, টয় সেট, স্টাডি টেবিল ও কিডস নিউট্রিশন',1,0,'2026-10-11 07:00:44','2026-10-11 07:00:44');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
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
-- Table structure for table `group_buy_members`
--

DROP TABLE IF EXISTS `group_buy_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_buy_members` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_buy_session_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `is_leader` tinyint(1) NOT NULL DEFAULT 0,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_buy_members_group_buy_session_id_user_id_unique` (`group_buy_session_id`,`user_id`),
  KEY `group_buy_members_user_id_foreign` (`user_id`),
  CONSTRAINT `group_buy_members_group_buy_session_id_foreign` FOREIGN KEY (`group_buy_session_id`) REFERENCES `group_buy_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_buy_members_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_buy_members`
--

LOCK TABLES `group_buy_members` WRITE;
/*!40000 ALTER TABLE `group_buy_members` DISABLE KEYS */;
INSERT INTO `group_buy_members` VALUES (1,1,3,1,'2026-10-09 00:46:30','2026-10-09 02:46:30','2026-10-09 02:46:30'),(2,2,4,1,'2026-10-12 04:21:09','2026-10-09 02:46:30','2026-10-12 07:21:09'),(3,2,5,0,'2026-10-12 06:21:09','2026-10-09 02:46:30','2026-10-12 07:21:09'),(4,3,5,1,'2026-10-08 23:46:30','2026-10-09 02:46:30','2026-10-09 02:46:30'),(5,4,3,1,'2026-10-12 05:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(6,5,4,1,'2026-10-12 01:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(7,5,3,0,'2026-10-12 03:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(8,5,5,0,'2026-10-12 05:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(9,5,1,0,'2026-10-12 06:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(10,6,5,1,'2026-10-12 03:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(11,6,4,0,'2026-10-12 06:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(12,3,3,1,'2026-10-12 06:21:09','2026-10-09 03:04:32','2026-10-12 07:21:09'),(13,1,6,0,'2026-10-09 04:15:20','2026-10-09 04:15:20','2026-10-09 04:15:20'),(15,6,3,0,'2026-10-11 13:00:25','2026-10-11 13:00:25','2026-10-11 13:00:25'),(16,8,3,0,'2026-10-11 13:57:55','2026-10-11 13:57:55','2026-10-11 13:57:55'),(17,8,5,1,'2026-10-12 05:21:09','2026-10-12 07:21:09','2026-10-12 07:21:09'),(18,8,1,0,'2026-10-12 06:36:09','2026-10-12 07:21:09','2026-10-12 07:21:09'),(19,7,3,1,'2026-10-12 06:51:09','2026-10-12 07:21:09','2026-10-12 07:21:09'),(20,9,4,1,'2026-10-12 06:21:09','2026-10-12 07:21:09','2026-10-12 07:21:09'),(21,11,3,1,'2026-10-13 06:39:05','2026-10-13 06:39:05','2026-10-13 06:39:05'),(22,12,3,1,'2026-10-13 06:39:05','2026-10-13 06:39:05','2026-10-13 06:39:05'),(23,13,3,1,'2026-10-21 17:03:31','2026-10-21 17:03:31','2026-10-21 17:03:31'),(24,14,3,1,'2026-10-21 18:45:44','2026-10-21 18:45:44','2026-10-21 18:45:44'),(27,16,3,1,'2026-10-23 07:15:58','2026-10-23 07:15:58','2026-10-23 08:03:46'),(28,19,3,1,'2026-11-20 05:20:46','2026-11-20 05:20:46','2026-11-20 05:20:46'),(29,20,3,1,'2026-11-20 05:33:11','2026-11-20 05:33:11','2026-11-20 05:33:11'),(30,21,3,0,'2026-11-20 05:54:05','2026-11-20 05:54:05','2026-11-20 06:06:00');
/*!40000 ALTER TABLE `group_buy_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `group_buy_sessions`
--

DROP TABLE IF EXISTS `group_buy_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `group_buy_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `leader_user_id` bigint(20) unsigned DEFAULT NULL,
  `group_code` varchar(30) NOT NULL,
  `required_members` int(10) unsigned NOT NULL DEFAULT 2,
  `discount_tiers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`discount_tiers`)),
  `achieved_tier_members` int(10) unsigned DEFAULT NULL,
  `achieved_discount_percent` decimal(5,2) DEFAULT NULL,
  `min_quota_to_ship` int(10) unsigned DEFAULT NULL,
  `max_buyers_limit` int(10) unsigned DEFAULT NULL,
  `current_members` int(10) unsigned NOT NULL DEFAULT 1,
  `status` enum('active','completed','expired') NOT NULL DEFAULT 'active',
  `expires_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_buy_sessions_group_code_unique` (`group_code`),
  KEY `group_buy_sessions_product_id_foreign` (`product_id`),
  KEY `group_buy_sessions_leader_user_id_foreign` (`leader_user_id`),
  CONSTRAINT `group_buy_sessions_leader_user_id_foreign` FOREIGN KEY (`leader_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `group_buy_sessions_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `group_buy_sessions`
--

LOCK TABLES `group_buy_sessions` WRITE;
/*!40000 ALTER TABLE `group_buy_sessions` DISABLE KEYS */;
INSERT INTO `group_buy_sessions` VALUES (1,1,3,'GRP-AURA99',2,NULL,NULL,NULL,NULL,NULL,2,'completed','2026-10-09 10:15:20','2026-10-09 02:46:30','2026-10-09 04:15:20'),(2,2,4,'GRP-TITAN7',3,NULL,NULL,NULL,NULL,NULL,2,'active','2026-11-22 13:41:44','2026-10-09 02:46:30','2026-11-20 13:41:44'),(3,12,3,'GRP-KEYK8P',2,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-21 13:41:44','2026-10-09 02:46:30','2026-11-20 13:41:44'),(4,9,3,'GRP-SOUND99',2,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-21 13:41:44','2026-10-09 03:04:32','2026-11-20 13:41:44'),(5,10,4,'GRP-HOODIE05',10,'[{\"min_members\":3,\"discount_percent\":5},{\"min_members\":5,\"discount_percent\":10},{\"min_members\":7,\"discount_percent\":15}]',3,5.00,3,NULL,4,'active','2026-11-22 13:41:44','2026-10-09 03:04:32','2026-11-20 13:41:44'),(6,11,5,'GRP-DATES33',3,NULL,NULL,NULL,NULL,NULL,2,'active','2026-11-21 13:41:44','2026-10-09 03:04:32','2026-11-20 13:41:44'),(7,18,3,'GRP-FRY08',2,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-22 01:41:44','2026-10-11 12:37:52','2026-11-20 13:41:44'),(8,15,5,'GRP-ANK65',3,NULL,NULL,NULL,NULL,NULL,2,'active','2026-11-21 13:41:44','2026-10-11 12:37:52','2026-11-20 13:41:44'),(9,16,4,'GRP-MX3S01',2,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-22 13:41:44','2026-10-11 12:37:52','2026-11-20 13:41:44'),(10,13,1,'GRP-BARISTA',2,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-22 01:41:44','2026-10-11 12:37:52','2026-11-20 13:41:44'),(11,2,3,'GRP-CBZ1D8',3,NULL,NULL,NULL,NULL,NULL,1,'expired','2026-11-20 11:13:55','2026-10-13 06:39:05','2026-11-20 05:13:55'),(12,2,3,'GRP-3BI0SC',3,NULL,NULL,NULL,NULL,NULL,1,'expired','2026-11-20 12:03:54','2026-10-13 06:39:05','2026-11-20 06:03:54'),(13,3,3,'GRP-WVF0OU',2,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-21 13:41:44','2026-10-21 17:03:31','2026-11-20 13:41:44'),(14,16,3,'GRP-VGAUHA',2,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-22 13:41:44','2026-10-21 18:45:43','2026-11-20 13:41:44'),(16,22,3,'GRP-EM6CQI',3,NULL,NULL,NULL,NULL,NULL,1,'active','2026-11-22 13:41:44','2026-10-23 06:56:04','2026-11-20 13:41:44'),(17,23,NULL,'GRP-O9ALYE',10,NULL,NULL,NULL,7,NULL,0,'expired','2026-11-20 10:17:34','2026-10-24 22:28:18','2026-11-20 04:17:34'),(19,24,3,'GRP-RZIEID',10,'[{\"min_members\":5,\"discount_percent\":2},{\"min_members\":7,\"discount_percent\":5},{\"min_members\":9,\"discount_percent\":15}]',NULL,NULL,5,NULL,2,'expired','2026-11-20 11:31:51','2026-11-20 05:20:46','2026-11-20 05:31:51'),(20,24,3,'GRP-HMYLB8',10,'[{\"min_members\":5,\"discount_percent\":2},{\"min_members\":7,\"discount_percent\":5},{\"min_members\":9,\"discount_percent\":15}]',NULL,NULL,5,NULL,1,'expired','2026-11-20 11:53:51','2026-11-20 05:33:11','2026-11-20 05:53:51'),(21,24,NULL,'GRP-EFJNNS',10,'[{\"min_members\":5,\"discount_percent\":2},{\"min_members\":7,\"discount_percent\":5},{\"min_members\":9,\"discount_percent\":15}]',NULL,NULL,5,NULL,1,'active','2026-11-21 13:41:44','2026-11-20 05:54:05','2026-11-20 13:41:44'),(22,19,NULL,'GRP-VG9QAE',3,NULL,NULL,NULL,NULL,NULL,0,'active','2026-11-21 13:41:44','2026-11-20 06:28:49','2026-11-20 13:41:44');
/*!40000 ALTER TABLE `group_buy_sessions` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_10_09_000001_add_role_and_details_to_users_table',2),(5,'2026_10_09_000002_create_categories_table',2),(6,'2026_10_09_000003_create_products_table',2),(7,'2026_10_09_000004_create_group_buy_sessions_table',2),(8,'2026_10_09_000005_create_orders_and_items_tables',2),(9,'2026_10_11_154744_add_shop_details_to_users_table',3),(10,'2026_10_22_000001_create_reviews_table',4),(11,'2026_10_23_004842_add_fulfillment_to_orders_and_products_table',5),(12,'2026_10_23_161931_add_seller_profile_fields_to_users_table',6),(13,'2026_10_24_000001_add_status_to_users_table',7),(14,'2026_10_24_000002_create_admin_core_tables_and_columns',8),(15,'2026_10_24_223635_add_tiered_quota_columns_to_products_and_sessions',9),(16,'2026_10_25_110000_add_discount_tiers_to_products_and_sessions',10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `order_items`
--

DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `product_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT 1,
  `unit_price` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `order_items`
--

LOCK TABLES `order_items` WRITE;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES (1,1,5,1,119.00,119.00,'2026-10-09 02:46:30','2026-10-09 02:46:30'),(2,2,1,1,129.00,129.00,'2026-10-09 04:15:20','2026-10-09 04:15:20'),(3,3,18,1,9400.00,9400.00,'2026-10-11 12:50:22','2026-10-11 12:50:22'),(4,4,11,1,1250.00,1250.00,'2026-10-11 13:00:25','2026-10-11 13:00:25'),(5,5,15,5,1950.00,9750.00,'2026-10-11 13:57:55','2026-10-11 13:57:55'),(6,6,2,1,2450.00,2450.00,'2026-10-13 06:39:05','2026-10-13 06:39:05'),(7,7,2,1,2450.00,2450.00,'2026-10-13 06:39:05','2026-10-13 06:39:05'),(8,8,3,1,89.00,89.00,'2026-10-21 17:03:31','2026-10-21 17:03:31'),(9,9,16,1,7600.00,7600.00,'2026-10-21 18:45:44','2026-10-21 18:45:44'),(10,10,22,3,240000.00,720000.00,'2026-10-23 06:15:01','2026-10-23 06:15:01'),(11,11,22,1,240000.00,240000.00,'2026-10-23 07:15:58','2026-10-23 07:15:58'),(12,12,22,3,240000.00,720000.00,'2026-10-23 08:34:39','2026-10-23 08:34:39'),(13,13,24,1,990.00,990.00,'2026-11-20 05:20:46','2026-11-20 05:20:46'),(14,14,24,1,990.00,990.00,'2026-11-20 05:31:06','2026-11-20 05:31:06'),(15,15,24,1,990.00,990.00,'2026-11-20 05:33:11','2026-11-20 05:33:11'),(16,16,24,1,990.00,990.00,'2026-11-20 05:54:05','2026-11-20 05:54:05');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `order_number` varchar(40) NOT NULL,
  `order_type` enum('single','group_buy') NOT NULL DEFAULT 'single',
  `group_buy_session_id` bigint(20) unsigned DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'Cash on Delivery',
  `payment_status` enum('paid','pending','refunded') NOT NULL DEFAULT 'paid',
  `escrow_status` varchar(30) NOT NULL DEFAULT 'held',
  `order_status` enum('pending_group','processing','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'processing',
  `courier_name` varchar(255) DEFAULT NULL,
  `tracking_number` varchar(255) DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `shipping_address` text NOT NULL,
  `order_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  KEY `orders_group_buy_session_id_foreign` (`group_buy_session_id`),
  KEY `orders_escrow_status_index` (`escrow_status`),
  CONSTRAINT `orders_group_buy_session_id_foreign` FOREIGN KEY (`group_buy_session_id`) REFERENCES `group_buy_sessions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES (1,3,'ORD-CARTIVA-001','single',NULL,119.00,'Cash on Delivery','paid','held','processing',NULL,NULL,NULL,NULL,'Arif Rahman','+880 1911 000003','Dhanmondi 27, Dhaka',NULL,'2026-10-09 02:46:30','2026-10-09 02:46:30'),(2,6,'ORD-OBXXSQBJ','group_buy',1,129.00,'Cash on Delivery','paid','held','processing',NULL,NULL,NULL,NULL,'Shahriar Arif','+8801617593327','Khiarpara,Bodargonj,Rangpur',NULL,'2026-10-09 04:15:20','2026-10-09 04:15:20'),(3,2,'ORD-ZHRQSUWB','group_buy',7,9400.00,'bKash / Nagad Instant','paid','held','processing',NULL,NULL,NULL,NULL,'Apex Tech & Lifestyle Hub','+880 1811 000002','Saidpur / Dhaka Commercial Hub',NULL,'2026-10-11 12:50:22','2026-10-11 12:50:22'),(4,3,'ORD-GAH3XZTJ','group_buy',6,1250.00,'Cash on Delivery','paid','held','processing',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur Commercial Area, Nilphamari',NULL,'2026-10-11 13:00:25','2026-10-11 13:00:25'),(5,3,'ORD-GBGQUK8N','group_buy',8,9750.00,'bKash Online Payment','paid','held','processing',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur Commercial Area, Nilphamari',NULL,'2026-10-11 13:57:55','2026-10-11 13:57:55'),(6,3,'ORD-MECAHB0G','group_buy',11,2450.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur - Parbotipur Road, Rampur, Ramnathpur Union [Home]',NULL,'2026-10-13 06:39:05','2026-10-22 18:51:02'),(7,3,'ORD-IWPXMBQZ','group_buy',12,2450.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur - Parbotipur Road, Rampur, Ramnathpur Union [Home]',NULL,'2026-10-13 06:39:05','2026-10-22 18:51:02'),(8,3,'ORD-NGZCN5R1','group_buy',13,89.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur - Parbotipur Road, Rampur, Ramnathpur Union [Home]',NULL,'2026-10-21 17:03:31','2026-10-22 18:51:02'),(9,3,'ORD-KXFZBVEA','group_buy',14,7600.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur - Parbotipur Road, Rampur, Ramnathpur Union [Home]',NULL,'2026-10-21 18:45:44','2026-10-23 18:48:34'),(10,3,'ORD-W9TYJK6V','single',NULL,720000.00,'Card Payment (Visa/Mastercard)','paid','held','processing',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur - Parbotipur Road, Rampur, Ramnathpur Union [Home]',NULL,'2026-10-23 06:15:01','2026-10-23 07:10:15'),(11,3,'ORD-UBVYRTJB','group_buy',16,240000.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur - Parbotipur Road, Rampur, Ramnathpur Union [Home]',NULL,'2026-10-23 07:15:58','2026-10-24 15:49:09'),(12,3,'ORD-6GU5BEU1','single',NULL,720000.00,'bKash Online Payment','paid','held','processing',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Saidpur - Parbotipur Road, Rampur, Ramnathpur Union [Home]',NULL,'2026-10-23 08:34:39','2026-10-23 08:34:39'),(13,3,'ORD-AXIL0GCE','group_buy',19,990.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Flat 4B, House 15, Kamal Ataturk Avenue, Gulshan 2, Dhaka [Home]',NULL,'2026-11-20 05:20:46','2026-11-20 05:31:51'),(14,3,'ORD-UJVEVR13','group_buy',19,990.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Flat 4B, House 15, Kamal Ataturk Avenue, Gulshan 2, Dhaka [Home]',NULL,'2026-11-20 05:31:06','2026-11-20 05:31:51'),(15,3,'ORD-LLJTPDRG','group_buy',20,990.00,'bKash Online Payment','refunded','held','cancelled',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Flat 4B, House 15, Kamal Ataturk Avenue, Gulshan 2, Dhaka [Home]',NULL,'2026-11-20 05:33:11','2026-11-20 05:53:51'),(16,3,'ORD-W6KWVLE2','group_buy',21,990.00,'bKash Online Payment','paid','held','pending_group',NULL,NULL,NULL,NULL,'Arif Shahriar','+880 1911 000003','Flat 4B, House 15, Kamal Ataturk Avenue, Gulshan 2, Dhaka [Home]',NULL,'2026-11-20 05:54:05','2026-11-20 05:54:05');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
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
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `seller_id` bigint(20) unsigned NOT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery`)),
  `single_price` decimal(10,2) NOT NULL,
  `group_price` decimal(10,2) NOT NULL,
  `tier2_group_price` decimal(10,2) DEFAULT NULL,
  `tier3_group_price` decimal(10,2) DEFAULT NULL,
  `group_size_required` int(10) unsigned NOT NULL DEFAULT 2,
  `discount_tiers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`discount_tiers`)),
  `min_quota_to_ship` int(10) unsigned DEFAULT NULL,
  `max_buyers_limit` int(10) unsigned DEFAULT NULL,
  `group_duration_hours` int(10) unsigned NOT NULL DEFAULT 24,
  `stock` int(10) unsigned NOT NULL DEFAULT 50,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `approval_status` varchar(30) NOT NULL DEFAULT 'approved',
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_hot_deal` tinyint(1) NOT NULL DEFAULT 0,
  `is_flash_sale` tinyint(1) NOT NULL DEFAULT 0,
  `rating` decimal(3,2) NOT NULL DEFAULT 4.80,
  `sales_count` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`),
  KEY `products_seller_id_foreign` (`seller_id`),
  KEY `products_category_id_foreign` (`category_id`),
  KEY `products_approval_status_index` (`approval_status`),
  CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,2,1,'Aura Pro Active Noise-Cancelling Wireless Headphones','aura-pro-anc-headphones','Immerse yourself in concert-hall acoustics with adaptive ANC, 40mm beryllium drivers, and up to 45 hours of battery life with ultra-plush memory foam cushions.','https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',NULL,199.00,129.00,NULL,NULL,2,NULL,NULL,NULL,24,45,1,'approved',0,1,1,4.30,143,'2026-10-09 02:46:30','2026-10-24 16:19:54'),(2,2,2,'Horizon Ultra Titan Smartwatch with AMOLED Display & Bluetooth Call','horizon-ultra-titan-smartwatch','অ্যারোস্পেস টাইটানিয়াম কেসিং, সাফায়ার গ্লাস স্ক্রিন, হার্ট রেট ও SpO2 সেন্সর, ১০০টির বেশি স্পোর্টস মোড এবং ৭ দিনের লং ব্যাটারি লাইফ।','https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800&q=80',NULL,3500.00,2450.00,NULL,NULL,3,NULL,NULL,NULL,48,27,1,'approved',0,1,1,4.30,137,'2026-10-09 02:46:30','2026-10-24 16:19:54'),(3,2,3,'Keyforge K8 Pro Wireless Mechanical Keyboard (Gateron Red)','keyforge-k8-pro-wireless-keyboard','Hot-swappable tactile mechanical keyboard featuring custom PBT double-shot keycaps, RGB backlighting, sound-absorbing silicone damping, and Bluetooth 5.2.','https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',NULL,135.00,89.00,NULL,NULL,2,NULL,NULL,NULL,24,61,1,'approved',0,1,1,4.30,211,'2026-10-09 02:46:30','2026-10-24 16:19:54'),(4,2,4,'Barista Artisan Compact Espresso & Latte Machine 19-Bar','barista-artisan-espresso-machine','Cafe-grade high-pressure extraction with stainless steel thermoblock heating, micro-foam steam wand, and fast 25-second warm-up for rich morning crema.','https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=800&q=80',NULL,249.00,159.00,NULL,NULL,3,NULL,NULL,NULL,36,25,1,'approved',0,0,0,4.00,74,'2026-10-09 02:46:30','2026-10-21 19:54:17'),(5,2,5,'Nomad Explorer Waterproof Tech Backpack with USB Charging Port','nomad-explorer-waterproof-backpack','ওয়াটারপ্রুফ কর্ডুরা নাইলন, ১৬ ইঞ্চি প্যাডেড ল্যাপটপ চেম্বার, অ্যান্টি-থেফ্ট ব্যাক পকেট এবং ইর্গোনমিক ভেন্টিলেটেড ব্যাক প্যানেল। অফিস ও ট্রাভেলের জন্য পারফেক্ট।','https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=800&q=80',NULL,2200.00,1550.00,NULL,NULL,2,NULL,NULL,NULL,24,60,1,'approved',0,0,0,4.30,275,'2026-10-09 02:46:30','2026-10-21 19:54:17'),(6,2,1,'VibePulse Studio ANC True Wireless Earbuds','vibepulse-studio-anc-earbuds','Spatial audio with dynamic head tracking, transparency mode, wireless Qi charging case, and IPX7 sweatproof design for workouts and daily commutes.','https://images.unsplash.com/photo-1590658268037-6bf12165a8df?w=800&q=80',NULL,99.00,59.00,NULL,NULL,2,NULL,NULL,NULL,24,80,1,'approved',0,0,0,4.80,312,'2026-10-09 02:46:30','2026-10-09 02:46:30'),(7,2,4,'Lumina Minimalist Magnetic Desk Lamp with Qi Fast Charger','lumina-minimalist-desk-lamp','Anodized aluminum body with step-less touch dimming, 5 color temperature presets, flicker-free eye care LED, and 15W integrated wireless smartphone charger.','https://images.unsplash.com/photo-1534349762230-e0cadf78f5da?w=800&q=80',NULL,85.00,52.00,NULL,NULL,2,NULL,NULL,NULL,24,40,1,'approved',0,0,0,4.70,95,'2026-10-09 02:46:30','2026-10-09 02:46:30'),(8,2,3,'Apex Pro Ergonomic Wireless Vertical Mouse','apex-pro-ergonomic-vertical-mouse','Designed by orthopedic physiotherapists to eliminate wrist strain. Features 4000 DPI optical sensor, quiet click switches, and dual Bluetooth/2.4G connectivity.','https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80',NULL,69.00,42.00,NULL,NULL,2,NULL,NULL,NULL,24,70,1,'approved',0,0,0,4.88,160,'2026-10-09 02:46:30','2026-10-09 02:46:30'),(9,2,6,'SoundCore Ultra ANC Active Noise Cancelling Headphones','soundcore-ultra-anc-headphones','অ্যাডাপ্টিভ অ্যাক্টিভ নয়েজ ক্যান্সেলেশন (ANC), ৪০ মিমি বেরিলিয়াম ড্রাইভার, ৪০ ঘণ্টা ব্যাটারি লাইফ এবং প্রিমিয়াম মেমোরি ফোম কুশন সহ হাই-রেজুলিউশন অডিও।','https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=800&q=80',NULL,4500.00,3150.00,NULL,NULL,2,NULL,NULL,NULL,24,35,1,'approved',0,0,0,4.90,148,'2026-10-09 03:04:32','2026-10-12 07:21:09'),(10,2,9,'Cartiva Heavyweight Premium Fleece Winter Hoodie','premium-fleece-winter-hoodie','৪৫০ জিএসএম প্রিমিয়াম কটন ফ্লিস ফ্যাব্রিক, ড্রপ শোল্ডার ওভারসাইজড কমফোর্ট ফিট, প্রিমিয়াম ফিনিশ। বন্ধুদের সাথে গ্রুপ করে কিনলে সর্বোচ্চ ছাড়!','https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80',NULL,1000.00,750.00,NULL,NULL,10,'[{\"min_members\":3,\"discount_percent\":5},{\"min_members\":5,\"discount_percent\":10},{\"min_members\":7,\"discount_percent\":15}]',3,NULL,48,120,1,'approved',0,0,0,4.95,320,'2026-10-09 03:04:32','2026-10-24 23:13:27'),(11,2,7,'Organic Medjool Premium Dates & Dry Fruit Mega Box (1kg Bulk Pack)','organic-medjool-dates-dry-fruit-pack','আমদানি করা শতভাগ ন্যাচারাল মদিনার মেদজুল খেজুর, কাঠবাদাম, কাজুবাদাম এবং কিশমিশের হাইজিনিক এয়ারটাইট কম্বো প্যাক। পরিবার বা বন্ধুদের সাথে শেয়ারিংয়ে দারুণ সাশ্রয়।','https://images.unsplash.com/photo-1596040033229-a9821ebd058d?w=800&q=80',NULL,1800.00,1250.00,NULL,NULL,3,NULL,NULL,NULL,24,45,1,'approved',0,0,0,4.88,195,'2026-10-09 03:04:32','2026-10-12 07:21:09'),(12,2,6,'Keyforge K8 Pro Wireless RGB Mechanical Keyboard (Hot-Swap)','keyforge-k8-pro-mechanical-keyboard','হট-সোয়াপ্যাবল ব্রাউন ট্যাকটাইল সুইচ, পিবিটি ডাবল-শট কি-ক্যাপস, সাউন্ড ড্যাম্পেনিং সিলিকন প্যাড এবং ব্লুটুথ ৫.২ মাল্টি-ডিভাইস কানেক্টিভিটি।','https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=800&q=80',NULL,3800.00,2700.00,NULL,NULL,2,NULL,NULL,NULL,24,40,1,'approved',0,0,0,4.92,210,'2026-10-09 03:04:32','2026-10-12 07:21:09'),(13,2,8,'Barista Artisan Compact Espresso & Latte Maker (19-Bar Italian Pump)','barista-artisan-compact-espresso-maker','ক্যাফে কোয়ালিটি হাই-প্রেসার এক্সট্রাকশন, স্টেইনলেস স্টিল থার্মোব্লক হিটিং, মাইক্রো-ফোম স্টিম ওয়ান্ড এবং ফাস্ট ৩০-সেকেন্ড হিট-আপ সিস্টেম।','https://images.unsplash.com/photo-1517668808822-9ebb02f2a0e6?w=800&q=80',NULL,6500.00,4800.00,NULL,NULL,3,NULL,NULL,NULL,36,20,1,'approved',0,0,0,4.82,64,'2026-10-09 03:04:32','2026-10-12 07:21:09'),(14,2,8,'Lumina Eye-Care Magnetic LED Desk Reading Lamp with 15W Qi Charger','lumina-eyecare-led-desk-lamp','স্টেপ-লেস টাচ ডিমিং, ৫টি কালার টেম্পারেচার মোড, ফ্লিকার-ফ্রি আই-প্রোটেকশন এবং ইন্টিগ্রেটেড ফাস্ট ওয়্যারলেস স্মার্টফোন চার্জিং প্যাড।','https://images.unsplash.com/photo-1534349762230-e0cadf78f5da?w=800&q=80',NULL,1650.00,1150.00,NULL,NULL,2,NULL,NULL,NULL,24,50,1,'approved',0,0,0,4.79,110,'2026-10-09 03:04:32','2026-10-12 07:21:09'),(15,2,11,'Anker 65W GaN III Fast Charger with Dual Type-C & USB-A Ports','anker-65w-gan-fast-charger','আল্ট্রা-কম্প্যাক্ট গ্যালিয়াম নাইট্রাইড (GaN) প্রযুক্তি, ল্যাপটপ ও স্মার্টফোনে হাই-স্পিড পিডি চার্জিং সাপোর্ট।','https://images.unsplash.com/photo-1583863788434-e58a36330cf0?w=800&q=80',NULL,2800.00,1950.00,NULL,NULL,3,NULL,NULL,NULL,24,40,1,'approved',0,0,0,4.93,180,'2026-10-11 07:00:44','2026-10-12 07:21:09'),(16,2,12,'Logitech MX Master 3S Ergonomic Wireless Performance Mouse','logitech-mx-master-3s-mouse','৮০০০ ডিপিআই ট্র্যাকিং, ম্যাগস্পিড ইলেক্ট্রোম্যাগনেটিক স্ক্রোলিং এবং সাইলেন্ট ক্লিক মেকানিজম। কোডিং ও ডিজাইনের জন্য সেরা।','https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?w=800&q=80',NULL,9500.00,7600.00,NULL,NULL,2,NULL,NULL,NULL,48,16,1,'approved',0,0,0,4.98,95,'2026-10-11 07:00:44','2026-10-23 18:48:34'),(17,2,13,'DermaPro SPF 50+ Aqua Sunscreen & Hyaluronic Serum Combo Pack','dermapro-sunscreen-serum-combo','হোয়াইট কাস্ট ফ্রি, ওয়াটার-রেজিস্ট্যান্ট ইউভি প্রোটেকশন এবং স্কিন হাইড্রেটিং হায়ালুরোনিক অ্যাসিড ফর্মুলা।','https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80',NULL,1500.00,990.00,NULL,NULL,3,NULL,NULL,NULL,24,60,1,'approved',0,0,0,4.85,140,'2026-10-11 07:00:44','2026-10-12 07:21:09'),(18,2,14,'Philips Essential 4.1L Rapid Air Digital Air Fryer (Low Oil Cooking)','philips-essential-digital-air-fryer','৯০% কম তেলে স্বাস্থ্যকর ফ্রাইং, টাচস্ক্রিন ৭টি প্রিসেট মোড এবং নন-স্টিক ডিশওয়াশার সেফ বাস্কেট।','https://images.unsplash.com/photo-1585515320310-259814833e62?w=800&q=80',NULL,12500.00,9400.00,NULL,NULL,2,NULL,NULL,NULL,36,12,1,'approved',0,0,0,4.94,52,'2026-10-11 07:00:44','2026-10-12 07:21:09'),(19,2,15,'TitanFit Hex Rubber Dumbbell Set (10kg Pair + Workout Mat)','titanfit-hex-dumbbell-set-10kg','নন-স্লিপ ক্রোম হ্যান্ডেল, হাই-কোয়ালিটি রাবার কোটেড বডি এবং ১০ মিমি থিক প্রিমিয়াম অ্যান্টি-টিয়ার ম্যাট।','https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=800&q=80',NULL,3200.00,2300.00,NULL,NULL,3,NULL,NULL,NULL,24,30,1,'approved',0,0,0,4.86,88,'2026-10-11 07:00:44','2026-10-12 07:21:09'),(20,2,16,'Classic Leather Bound Journal & Metal Calligraphy Pen Set','classic-leather-bound-journal-set','হাতে তৈরি জেনুইন লেদার কভার, ১০০ জিএসএম ব্লিড-প্রুফ ভিন্টেজ পেপার ও প্রিমিয়াম রিলোড্যাবল পেন।','https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?w=800&q=80',NULL,1100.00,750.00,NULL,NULL,4,NULL,NULL,NULL,48,70,1,'approved',0,0,0,4.89,165,'2026-10-11 07:00:44','2026-10-12 07:21:09'),(21,2,17,'EcoBaby Non-Toxic Soft Silicone Feeding & Teether Set (BPA Free)','ecobaby-silicone-feeding-teether-set','ফুড-গ্রেড নরম সিলিকন বাটি, সেকশন প্লেট, প্রশিক্ষণ চামচ ও পানির বোতল কম্বো। শিশুদের জন্য ১০০% নিরাপদ।','https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=800&q=80',NULL,1400.00,920.00,NULL,NULL,3,NULL,NULL,NULL,24,45,1,'approved',0,0,0,4.95,115,'2026-10-11 07:00:44','2026-10-12 07:21:09'),(22,2,1,'Iphone','iphone-S0y0h','skdjbcksadjbclasknclkan \r\nakhjxcvjh\r\nsajxcgbasjhbx','http://127.0.0.1:8000/storage/products/COPlpA1rVCnaQRxn6ByA21gL5yX4ptinNzz04rGs.webp',NULL,258000.00,240000.00,NULL,NULL,5,NULL,NULL,8,48,2,1,'approved',0,1,0,4.80,6,'2026-10-23 06:12:23','2026-10-24 15:49:09'),(23,2,3,'PS5 v1','ps5-v1-BkjQr','jvbjdshbcdbcqerwiuPObdvd','http://127.0.0.1:8000/storage/products/jXg5kb0SVv89SBzTsZHeb5EFdxXydkjnrhIYfSi0.jpg',NULL,150000.00,120000.00,NULL,NULL,10,NULL,7,NULL,72,20,1,'approved',0,0,1,4.80,0,'2026-10-24 22:28:18','2026-10-24 22:28:18'),(24,2,15,'erdg','erdg-uT5GK','mjhgvjhgvhv','http://127.0.0.1:8000/storage/products/UVmq3J4iYlI61KCZWD4dvb13POqeEJc14fpKsGyh.jpg',NULL,1200.00,990.00,NULL,NULL,10,'[{\"min_members\":5,\"discount_percent\":2},{\"min_members\":7,\"discount_percent\":5},{\"min_members\":9,\"discount_percent\":15}]',5,NULL,24,49,1,'approved',0,1,0,4.80,4,'2026-11-20 04:46:37','2026-11-20 05:54:05');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `refund_requests`
--

DROP TABLE IF EXISTS `refund_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `refund_requests` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'group_failed',
  `reason` varchar(255) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'pending',
  `payout_method` varchar(50) NOT NULL DEFAULT 'bKash',
  `payout_account` varchar(100) DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `processed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `refund_requests_order_id_foreign` (`order_id`),
  KEY `refund_requests_user_id_foreign` (`user_id`),
  KEY `refund_requests_status_index` (`status`),
  CONSTRAINT `refund_requests_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `refund_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `refund_requests`
--

LOCK TABLES `refund_requests` WRITE;
/*!40000 ALTER TABLE `refund_requests` DISABLE KEYS */;
INSERT INTO `refund_requests` VALUES (1,12,3,450.00,'group_failed','Group buying session expired before reaching 3 required buyers.','pending','bKash','01711223344',NULL,NULL,'2026-10-23 13:03:21','2026-10-23 13:03:21'),(2,12,3,1200.00,'customer_return','Customer reported sizing mismatch upon package inspection.','pending','Nagad','01811556677',NULL,NULL,'2026-10-23 13:03:21','2026-10-23 13:03:21');
/*!40000 ALTER TABLE `refund_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reported_issues`
--

DROP TABLE IF EXISTS `reported_issues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reported_issues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `seller_id` bigint(20) unsigned DEFAULT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `issue_type` varchar(50) NOT NULL DEFAULT 'customer_complaint',
  `priority` varchar(20) NOT NULL DEFAULT 'medium',
  `status` varchar(30) NOT NULL DEFAULT 'open',
  `admin_response` text DEFAULT NULL,
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reported_issues_ticket_number_unique` (`ticket_number`),
  KEY `reported_issues_user_id_foreign` (`user_id`),
  KEY `reported_issues_seller_id_foreign` (`seller_id`),
  KEY `reported_issues_order_id_foreign` (`order_id`),
  KEY `reported_issues_status_index` (`status`),
  CONSTRAINT `reported_issues_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reported_issues_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reported_issues_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reported_issues`
--

LOCK TABLES `reported_issues` WRITE;
/*!40000 ALTER TABLE `reported_issues` DISABLE KEYS */;
INSERT INTO `reported_issues` VALUES (1,3,2,12,'TCK-8EECE7','Delivery delayed by courier partner','The order was marked as shipped 4 days ago, but the Steadfast courier tracking status has not updated yet.','delivery_delay','high','open',NULL,NULL,'2026-10-23 13:03:21','2026-10-23 13:03:21'),(2,2,2,NULL,'TCK-19B1D8','Repeated COD order cancellations from same address','A shopper placed 3 consecutive COD orders and rejected delivery at doorstep in Saidpur area.','fraud_alert','urgent','investigating',NULL,NULL,'2026-10-23 13:03:21','2026-10-23 13:03:21');
/*!40000 ALTER TABLE `reported_issues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reviews` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `rating` tinyint(3) unsigned NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_product_id_user_id_unique` (`product_id`,`user_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,1,5,'Excellent product quality! Came securely packed with official warranty card. Group buying saved me a good amount of money.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(2,1,2,4,'Very good product for the price. Works exactly as described in the specs. Packaging was neat.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(3,1,3,4,'Good experience overall. Team formed quickly and item arrived in pristine condition.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(4,2,1,4,'Very good product for the price. Works exactly as described in the specs. Packaging was neat.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(5,2,2,4,'Good experience overall. Team formed quickly and item arrived in pristine condition.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(6,2,3,5,'Very pleased with this purchase. Both the solo discount and group deal options are great.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(7,3,1,4,'Very good product for the price. Works exactly as described in the specs. Packaging was neat.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(8,3,2,4,'Very good product for the price. Works exactly as described in the specs. Packaging was neat.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(9,3,3,5,'Very pleased with this purchase. Both the solo discount and group deal options are great.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(10,4,1,4,'Very good product for the price. Works exactly as described in the specs. Packaging was neat.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(11,4,2,4,'Good experience overall. Team formed quickly and item arrived in pristine condition.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(12,4,3,4,'Good experience overall. Team formed quickly and item arrived in pristine condition.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(13,5,1,4,'Very good product for the price. Works exactly as described in the specs. Packaging was neat.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(14,5,2,5,'Very pleased with this purchase. Both the solo discount and group deal options are great.','2026-10-21 19:54:17','2026-10-21 19:54:17'),(15,5,3,4,'Very good product for the price. Works exactly as described in the specs. Packaging was neat.','2026-10-21 19:54:17','2026-10-21 19:54:17');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
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
INSERT INTO `sessions` VALUES ('4L5TJxmkHctd3S4o0kMz4AJB1owrIbSrUNjf6953',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiSXpBcjFScEQwUlgweHNuUkJLWUo2YkhHWVFIUWVmengyS3huU21JVCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1795181439),('6t3NHfICv0wPDcqECvb2ip1WHJ8PhsHXLxvYsPxz',9,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiS1o0bWkzTnJOYUpmb25NbVUwbFk2V24xM0s5cmlZRU83U3dpZUxMSyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiNzk0YzBlNTk3MjU0MmZlNjRjNzcxM2QzNjJkNzY5ZjY4OWEyM2UzMTczMTJlMmNhMTU4MDEwY2Q5NmE5OWFiMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZWxsZXIvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjE2OiJzZWxsZXIuZGFzaGJvYXJkIjt9fQ==',1795183029),('7FkarQfEdhm8ZzrZl05I5x3YfXwKTf5qRBoQmiAh',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoibWJrM3JIMERrSXJuWmtNWEJ3SnZPSXh3QXMwT3gyUEhJZUFGMHpwbCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wcm9kdWN0L2VyZGctdVQ1R0siO3M6NToicm91dGUiO3M6MTM6InByb2R1Y3RzLnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1795182225),('cKBz7meYgyTpTcBbvzStmSOCATdWyP3ewnOa4Uwx',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoieHN5dGxwdTJkdlJTMjlEM2o0T09RYkpKTFBXaHM4N01HUjBCdUkxVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ncm91cC1idXkvR1JQLUVGSk5OUyI7czo1OiJyb3V0ZSI7czoxNDoiZ3JvdXAtYnV5LnNob3ciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1795182170),('hniZhqiWFItTXlvBPmSkzmYFKNUqrGkjHEuom91R',8,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiaURQVnV6RW1OWkRWYm8xbFBYOUU0cmdxNzl4Ylh3Zm9xUm5XVVdQZyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6ODtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiZjlkNDdjMTE0NDAxNTM0MDA1ZDAzMzBkZjg5MjQyZTNhYTdjNzBkMmZhNWYyMzlkYzdiYjhiNzNjM2M0ZTE0YSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==',1795183021),('jtNNBzlJHtDhukK9kY9WavrOfi5oc20maIknIpmO',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/158.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoieVFJS0tQdFZobnh1NkpWWlVQTWVHSmdRM2Z4THE1V3VSYlNvN2hzNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wYXltZW50cyI7czo1OiJyb3V0ZSI7czoxNDoiYWRtaW4ucGF5bWVudHMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjY0OiJkOTZlOGQ4MmFhNjI5OWRmNjlhNThlMGVhZGEyZGU3OGJhZTc3YWQyZmRhZmYzYTU1MjQ5YjRjN2MzN2RhMTM0Ijt9',1795185626),('LzLJJj1o4DnpOfhVvvdJhcFviY0AEyfZnoii3t2Q',9,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiT0lsTXlQVlRxVTljMkx0T0JkVzVjcXhONHVXdTFIUkpJelg2U0d1OSI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6OTtzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiNzk0YzBlNTk3MjU0MmZlNjRjNzcxM2QzNjJkNzY5ZjY4OWEyM2UzMTczMTJlMmNhMTU4MDEwY2Q5NmE5OWFiMiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zZWxsZXIvc3RvcmVmcm9udCI7czo1OiJyb3V0ZSI7czoxNzoic2VsbGVyLnN0b3JlZnJvbnQiO319',1795183866),('OAqG184OXG2bhURPea9pPMO848pk7vcxKesEqWrv',7,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYWs3eEhZTXVMckIzNE0xSUxaMFFhSVVvZWU4RWRONEh2YnFwTGRxaCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6NztzOjE3OiJwYXNzd29yZF9oYXNoX3dlYiI7czo2NDoiMDY1NGVkNWY3MmUyYjY0NjhmMjJjMzE3NjA0MDc2YzkyN2ZkYmYyNmJiZWEyZTVkMjY3MWQ1YmE3MzAzMWU4OCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9fQ==',1795183012),('PNzca3edmkqmNnLBTpIFWi9ltb3aqevMXPeGqeHE',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiUjVDSkc1cFBYN0FtWDk0OE9uOXRLRTBvemt3azA5OVVRc0dwcHVHUSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3Rlcj9yb2xlPXNlbGxlciI7czo1OiJyb3V0ZSI7czo4OiJyZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=',1795182704),('RXkPZ29aaTZokR6LupQpT7Gj0Ro4wyC0vPPtN4rw',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoicTQ2ZnBuQ1VzTjREWHRyOXE2STJQZWlwVmg4WnpYcFhTSWtSYWJ2ZSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1795182187),('vxYvXxMiMPCnUHhB13p2PWUTFytbuTh3jLGW2DS8',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT; Windows NT 10.0; en-SG) WindowsPowerShell/5.1.26100.9444','YTozOntzOjY6Il90b2tlbiI7czo0MDoiS2xmMkFGR3Zvc0NYMHBZN0tudE5MZk9EZGVGZGx2bFVlSWFsOElXeSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1795182711);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'customer',
  `status` varchar(30) NOT NULL DEFAULT 'active',
  `status_reason` varchar(255) DEFAULT NULL,
  `shop_name` varchar(255) DEFAULT NULL,
  `shop_slug` varchar(255) DEFAULT NULL,
  `business_category` varchar(255) DEFAULT NULL,
  `shop_description` text DEFAULT NULL,
  `dispatch_time` varchar(255) DEFAULT NULL,
  `return_policy` text DEFAULT NULL,
  `shop_banner` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `whatsapp_number` varchar(255) DEFAULT NULL,
  `facebook_page` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `address_tag` varchar(20) DEFAULT 'Home',
  `warehouse_address` text DEFAULT NULL,
  `payout_method` varchar(255) DEFAULT NULL,
  `payout_details` text DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_status_index` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'System Administrator','admin@cartiva.com',NULL,'$2y$12$F1UJ0fo61KVNvmXpDvkZl.EaYtas7IWcCrqLEvTGvJT/wlxa2dOCq','admin','active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'+880 1711 000001',NULL,NULL,'Gulshan 2, Dhaka, Bangladesh',NULL,NULL,'Home',NULL,NULL,NULL,NULL,NULL,'2026-10-09 02:46:28','2026-10-12 07:21:08'),(2,'Manager','seller@cartiva.com',NULL,'$2y$12$OT8AwAst05fgqaYuRMzJkueNPLuS4Dm2raSc72X4x3jCR8KUbQroW','seller','approved',NULL,'TAORB TECH','taorb-tech','Electronics & Gadgets','Official flagship store for Apex Tech on Cartiva. 100% genuine guaranteed electronics with rapid doorstep delivery across Bangladesh.','⚡ Dispatches within 12 hours (Express)','7-day replacement warranty for manufacturing defects. Item must be in original condition with unboxing video.',NULL,'+880 1711 002233','+880 1711 002233','https://facebook.com/apextechbangladesh','House 42, Road 11, Block D, Banani, Dhaka 1213',NULL,NULL,'Home','Plot 88, Tejgaon Industrial Area, Dhaka (Courier Hub Gate 2)','bkash','01711002233 (Merchant Wallet)',NULL,NULL,'2026-10-09 02:46:28','2026-10-23 11:06:00'),(3,'Arif Shahriar','customer@cartiva.com',NULL,'$2y$12$Rknsud.TuVaXK.gCfuWwpeNg/2AiVd1znhbvhgvr4IZWCFGIzQl.S','customer','active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'+880 1911 000003',NULL,NULL,'Flat 4B, House 15, Kamal Ataturk Avenue, Gulshan 2, Dhaka [Home]',23.7947191,90.4136986,'Home',NULL,NULL,NULL,'/storage/avatars/MyGs9yfeNvK20pQ8txCZ5l0LqKvW0jO4CHc5cqCD.png',NULL,'2026-10-09 02:46:29','2026-11-19 21:51:01'),(4,'Ashikur Rahman','tahmid@cartiva.com',NULL,'$2y$12$eynV15jVFaA94Q0otUkTS.0r7ZLHsWsRFaec854MglsvW8J2kwu2e','customer','active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'+880 1611 000004',NULL,NULL,'Dhanmondi, Dhaka',NULL,NULL,'Home',NULL,NULL,NULL,NULL,NULL,'2026-10-09 02:46:29','2026-10-12 07:21:09'),(5,'Fuad Hossain','farhana@cartiva.com',NULL,'$2y$12$dKfAAQyhw2cHWUK0wOAsjOynBGCdKtlg0TaZdv2p/m//9a3PgELhO','customer','active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'+880 1511 000005',NULL,NULL,'Uttara, Dhaka',NULL,NULL,'Home',NULL,NULL,NULL,NULL,NULL,'2026-10-09 02:46:29','2026-10-12 07:21:09'),(6,'Shahriar Arif','arifshahriar155@gmail.com',NULL,'$2y$12$wnts2oB9EgQh5vwSct57Y.bd.GfSdW8r1fW7sHqKXxB.Y0OFBqFQy','admin','active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'+8801617593327',NULL,NULL,'Khiarpara,Bodargonj,Rangpur',NULL,NULL,'Home',NULL,NULL,NULL,NULL,NULL,'2026-10-09 04:14:59','2026-10-23 06:35:43'),(7,'Arif Shahriar (Google)','google.shopper@cartiva.com',NULL,'$2y$12$93QCurMayuiNVaDE02muBOF70U4pLIXO4xrVtV.FXoOTFtij89K5y','customer','active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'01711000001',NULL,NULL,'Dhaka, Bangladesh',NULL,NULL,'Home',NULL,NULL,NULL,'https://ui-avatars.com/api/?name=Arif+Shahriar&background=4285F4&color=fff&bold=true','0Q0vMBsI7OAuRxEW1JJ1DLP3SBriwwWU6ETC7S5BYAzVlc4jX21a7iddiq5F','2026-11-20 13:56:51','2026-11-20 13:56:51'),(8,'Arif Shahriar (Facebook)','facebook.shopper@cartiva.com',NULL,'$2y$12$WgfWFKBXUfElKJZuW0llU.kxsYbwtP2b64yoYvYmnS0VzC1M31vha','customer','active',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'01711000002',NULL,NULL,'Dhaka, Bangladesh',NULL,NULL,'Home',NULL,NULL,NULL,'https://ui-avatars.com/api/?name=Arif+Shahriar&background=1877F2&color=fff&bold=true','7UzJDFUZbZR8fkEIoDl5onm4oQtIIgmERjubTApWTyYpg64dqo6dCDW3hJb9','2026-11-20 13:57:00','2026-11-20 13:57:00'),(9,'Google Merchant Shop','google.merchant@cartiva.com',NULL,'$2y$12$d80/IRNdU4BVcXnXAy380eaEUz0r/8vkEZwjwfs1n6ngoNviLiRlC','seller','active',NULL,'Google Express Shop',NULL,NULL,NULL,NULL,NULL,NULL,'01711000001',NULL,NULL,'Dhaka, Bangladesh',NULL,NULL,'Home',NULL,NULL,NULL,'https://ui-avatars.com/api/?name=Google+Merchant&background=4285F4&color=fff&bold=true','tJBQHrNnX6UKqM6D6WzHI2MSBc3BGD2lK4mwEEcjIeNgek4WUaVo6RwI29sb','2026-11-20 13:57:08','2026-11-20 13:57:08');
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

-- Dump completed on 2026-11-20 21:11:44
