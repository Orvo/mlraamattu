# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 10.0.17-MariaDB)
# Database: mlraamattu
# Generation Time: 2015-12-22 09:15:51 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table answers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `answers`;

CREATE TABLE `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `text` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `error_margin` int(11) DEFAULT '0',
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `answers` WRITE;
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;

INSERT INTO `answers` (`id`, `question_id`, `text`, `error_margin`, `is_correct`)
VALUES
	(1,1,'Yes',10,1),
	(2,1,'Maybe',10,0),
	(3,1,'Wat?',10,0),
	(4,1,'Blizz pls!',10,1),
	(5,2,'One seems like enough.',10,0),
	(6,2,'At least 4, pls.',10,0),
	(7,2,'1337! What else?',10,1),
	(8,2,'What kind of a question is this?',10,0),
	(9,3,'Bananas',10,1),
	(10,4,'Potato',10,1),
	(11,4,'Tomato',10,1),
	(12,4,'Salad',10,1),
	(13,6,'Very',0,1),
	(14,6,'Somewhat',0,0),
	(15,6,'Really what?',0,0),
	(16,6,'Vrysrsbsns',0,0);

/*!40000 ALTER TABLE `answers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table archive
# ------------------------------------------------------------

DROP TABLE IF EXISTS `archive`;

CREATE TABLE `archive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `replied_to` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `archive` WRITE;
/*!40000 ALTER TABLE `archive` DISABLE KEYS */;

INSERT INTO `archive` (`id`, `user_id`, `test_id`, `data`, `replied_to`, `created_at`, `updated_at`)
VALUES
	(1,2,1,'{\"all_correct\":true,\"num_correct\":5,\"total\":5,\"given_answers\":{\"1\":[\"1\",\"4\"],\"2\":\"7\",\"3\":\"banana\",\"4\":[\"tomato\",\"salad\",\"potato\"],\"5\":\"asdd\"}}',0,'0000-00-00 00:00:00','2015-12-09 10:16:12'),
	(2,2,2,'{\"all_correct\":true,\"num_correct\":1,\"total\":1,\"given_answers\":{\"6\":\"13\"}}',0,'2015-12-01 11:54:32','2015-12-15 14:46:07'),
	(3,3,1,'{\"all_correct\":false,\"num_correct\":0,\"total\":5,\"given_answers\":{\"1\":[\"1\",\"4\"],\"2\":\"6\",\"3\":\"bananas\",\"4\":[\"potato\",\"tomato\",\"salad\"],\"5\":\"rtrfghfghfgd\"}}',1,'2015-12-01 13:20:27','2015-12-01 13:20:27'),
	(5,4,1,'{\"all_correct\":false,\"num_correct\":4,\"total\":5,\"given_answers\":{\"1\":[\"1\",\"4\"],\"2\":\"6\",\"3\":\"bananas\",\"4\":[\"potato\",\"tomato\",\"salad\"],\"5\":\"rtrfghfghfgd\"}}',0,'2015-12-03 07:57:58','2015-12-03 09:18:54'),
	(6,4,2,'{\"all_correct\":true,\"num_correct\":1,\"total\":1,\"given_answers\":{\"6\":\"13\"}}',0,'2015-12-03 07:58:16','2015-12-03 07:58:16'),
	(7,2,6,'{\"all_correct\":true,\"num_correct\":1,\"total\":1,\"given_answers\":{\"8\":\"19\"}}',0,'2015-12-17 08:39:38','2015-12-17 08:39:42');

/*!40000 ALTER TABLE `archive` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;

INSERT INTO `courses` (`id`, `title`, `description`, `created_at`, `updated_at`, `published`)
VALUES
	(1,'Default Course','The Original','0000-00-00 00:00:00','2015-12-22 07:50:24',1),
	(2,'The Brand New Course','New and improved!','0000-00-00 00:00:00','2015-12-22 09:14:51',1),
	(3,'The \"Kinda Shabby\" Course','Think twice before accepting!','0000-00-00 00:00:00','0000-00-00 00:00:00',0);

/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_10_12_000000_create_users_table',1),
	('2014_10_12_100000_create_password_resets_table',1),
	('2015_11_10_100728_create_tests_table',1),
	('2015_11_10_100911_create_questions_table',1),
	('2015_11_10_100953_create_answers_table',1),
	('2015_11_10_101135_create_courses_table',1),
	('2015_11_10_102511_add_order_to_tests_table',2),
	('2015_11_10_102927_add_order_to_questions_table',2),
	('2015_11_13_082828_add_timestamps_to_users',3),
	('2015_12_01_073542_create_archive_table',4),
	('2015_12_17_083226_add_timestamps_to_tests_table',5),
	('2015_12_17_162411_add_timestamps_to_courses_table',6),
	('2015_12_22_074011_add_published_to_courses_table',7);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table questions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `questions`;

CREATE TABLE `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;

INSERT INTO `questions` (`id`, `test_id`, `type`, `title`, `subtitle`, `order`)
VALUES
	(1,1,'MULTI','Hello World!','Do you feel sufficiently greeted?',1),
	(2,1,'CHOICE','Choose the right amount of potatoes.','It\'s a very specific science.',2),
	(3,1,'TEXT','Be careful of what you write here.','I suggest you type \"bananas\" or something weird may happen.',3),
	(4,1,'MULTITEXT','At this moment you realised it\'s pretty serious.','Now you done goofed.',4),
	(5,1,'TEXTAREA','Freedom!','At least here you don\'t have to be specific.\r\n\r\n<img src=\"https://aitolahti.adventist.fi/uploaded_assets/2396408-aitolahti.jpg?thumbnail=original&1432180496\" alt=\"\" style=\"float:left;width:150px\"/> <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi possimus et eos modi id alias at quia ex deleniti quaerat laudantium eaque laboriosam pariatur, magnam a veritatis. Atque numquam distinctio cumque, dolorum non quis a vel rerum aspernatur provident amet perferendis repellat, dolores sed porro ullam ex, molestiae. Pariatur, esse.</p>',5),
	(6,2,'CHOICE','Ha! I lied to you! It\'s not really blank after all!','Does it make you feel betrayed?',0);

/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tests
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tests`;

CREATE TABLE `tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;

INSERT INTO `tests` (`id`, `course_id`, `title`, `description`, `order`, `created_at`, `updated_at`)
VALUES
	(1,1,'Basic Test','The first meal on the default course!',1,'0000-00-00 00:00:00','2015-12-22 08:00:00'),
	(2,1,'Blank Test','Just like you wanted it.',2,'0000-00-00 00:00:00','2015-12-22 08:00:00');

/*!40000 ALTER TABLE `tests` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `access_level` int(11) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `access_level`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(2,'Reima Raju','test','$2y$10$LFlAQP0lQes918IsJ5jyBOeyXkj6u1iHAQ4aV4irBnj7aO3NnEoRC',1,'SXm50Qs0S4tjvW6Inn3DiIBczYL1UsgoR9TLK0VlEZvL0DcVeHe6IviUqmgE','0000-00-00 00:00:00','2015-12-16 08:12:24'),
	(3,'Erkki Esimerkki','erkin@esimerk.ki','$2y$10$Q0AJvNitiDjelOpna2nHsOea9NJCZFfjCAEy2dkRdJEHq1YH.GtGy',0,'3Zz2uRa8Bk6x3GOO25KFy6gEdjwmOeUjjyqBzPfBqQewCh4CG39dLAfFD7CZ','2015-12-01 13:20:27','2015-12-01 13:21:38'),
	(4,'Milla Mallikas','asdf','$2y$10$tyiiZn5CUCbCeGlqJjMqquDpQ0xTiFdjDhfysZjTTDpvCBz2RVdJW',1,'ZWkWH1p3jrvBZLL39B5pALrr4eLSOE4UkIwJ4U1zbhU4ClbYQRKLIFkqAVJK','2015-12-01 13:52:02','2015-12-15 14:24:01');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
