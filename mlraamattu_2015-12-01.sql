# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 10.0.17-MariaDB)
# Database: mlraamattu
# Generation Time: 2015-12-01 14:16:12 +0000
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
	(1,1,'Yes',0,1),
	(2,1,'Maybe',0,0),
	(3,1,'Wat?',0,0),
	(4,1,'Blizz pls!',0,1),
	(5,2,'One seems like enough.',0,0),
	(6,2,'At least 4, pls.',0,0),
	(7,2,'1337! What else?',0,1),
	(8,2,'What kind of a question is this?',0,0),
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
	(1,2,1,'{\"all_correct\":false,\"given_answers\":{\"1\":[\"1\",\"3\"],\"2\":\"6\",\"3\":\"banana\",\"4\":[\"\",\"salad\",\"potato\"],\"5\":\"asdd\"},\"validation\":{\"1\":{\"correct\":false,\"partial\":1,\"total\":2,\"correct_answers\":{\"0\":{\"id\":1,\"question_id\":1,\"text\":\"Yes\",\"error_margin\":0,\"is_correct\":1},\"3\":{\"id\":4,\"question_id\":1,\"text\":\"Blizz pls!\",\"error_margin\":0,\"is_correct\":1}}},\"2\":{\"correct\":false,\"correct_answers\":{\"id\":7,\"question_id\":2,\"text\":\"1337! What else?\",\"error_margin\":0,\"is_correct\":1}},\"3\":{\"correct\":true,\"correct_answers\":{\"id\":9,\"question_id\":3,\"text\":\"Bananas\",\"error_margin\":10,\"is_correct\":1}},\"4\":{\"correct\":false,\"partial\":2,\"total\":3,\"correct_answers\":[{\"id\":10,\"question_id\":4,\"text\":\"Potato\",\"error_margin\":10,\"is_correct\":1},{\"id\":11,\"question_id\":4,\"text\":\"Tomato\",\"error_margin\":10,\"is_correct\":1},{\"id\":12,\"question_id\":4,\"text\":\"Salad\",\"error_margin\":10,\"is_correct\":1}],\"correct_rows\":{\"2\":true,\"1\":true}},\"5\":{\"correct\":true}}}',0,'0000-00-00 00:00:00','2015-12-01 14:08:37'),
	(2,2,2,'{\"all_correct\":true,\"given_answers\":{\"6\":\"13\"},\"validation\":{\"6\":{\"correct\":true,\"correct_answers\":{\"id\":13,\"question_id\":6,\"text\":\"Very\",\"error_margin\":0,\"is_correct\":1}}}}',0,'2015-12-01 11:54:32','2015-12-01 12:02:38'),
	(3,3,1,'{\"all_correct\":false,\"given_answers\":{\"1\":null,\"2\":null,\"3\":\"\",\"4\":[\"\",\"\",\"\"],\"5\":\"\"},\"validation\":{\"1\":{\"correct\":false,\"error\":\"No given answer\"},\"2\":{\"correct\":false,\"error\":\"No given answer\"},\"3\":{\"correct\":false,\"error\":\"No given answer\"},\"4\":{\"correct\":false,\"partial\":0,\"total\":3,\"correct_answers\":[{\"id\":10,\"question_id\":4,\"text\":\"Potato\",\"error_margin\":10,\"is_correct\":1},{\"id\":11,\"question_id\":4,\"text\":\"Tomato\",\"error_margin\":10,\"is_correct\":1},{\"id\":12,\"question_id\":4,\"text\":\"Salad\",\"error_margin\":10,\"is_correct\":1}],\"correct_rows\":[]},\"5\":{\"correct\":false,\"error\":\"No given answer\"}}}',0,'2015-12-01 13:20:27','2015-12-01 13:20:27'),
	(4,4,1,'{\"all_correct\":false,\"given_answers\":{\"1\":[\"1\",\"4\"],\"2\":\"6\",\"3\":\"bananas\",\"4\":[\"\",\"salad\",\"potato\"],\"5\":\"asdd\"},\"validation\":{\"1\":{\"correct\":true,\"partial\":2,\"total\":2,\"correct_answers\":{\"0\":{\"id\":1,\"question_id\":1,\"text\":\"Yes\",\"error_margin\":0,\"is_correct\":1},\"3\":{\"id\":4,\"question_id\":1,\"text\":\"Blizz pls!\",\"error_margin\":0,\"is_correct\":1}}},\"2\":{\"correct\":false,\"correct_answers\":{\"id\":7,\"question_id\":2,\"text\":\"1337! What else?\",\"error_margin\":0,\"is_correct\":1}},\"3\":{\"correct\":true,\"correct_answers\":{\"id\":9,\"question_id\":3,\"text\":\"Bananas\",\"error_margin\":10,\"is_correct\":1}},\"4\":{\"correct\":false,\"partial\":2,\"total\":3,\"correct_answers\":[{\"id\":10,\"question_id\":4,\"text\":\"Potato\",\"error_margin\":10,\"is_correct\":1},{\"id\":11,\"question_id\":4,\"text\":\"Tomato\",\"error_margin\":10,\"is_correct\":1},{\"id\":12,\"question_id\":4,\"text\":\"Salad\",\"error_margin\":10,\"is_correct\":1}],\"correct_rows\":{\"2\":true,\"1\":true}},\"5\":{\"correct\":true}}}',0,'2015-12-01 13:52:02','2015-12-01 14:07:25');

/*!40000 ALTER TABLE `archive` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table courses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `courses`;

CREATE TABLE `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;

INSERT INTO `courses` (`id`, `title`, `description`)
VALUES
	(1,'Default Course','The Original');

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
	('2015_12_01_073542_create_archive_table',4);

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
	(5,1,'TEXTAREA','Freedom!','At least here you don\'t have to be specific.\r\n\r\n<img src=\"https://aitolahti.adventist.fi/uploaded_assets/2396408-aitolahti.jpg?thumbnail=original&1432180496\" alt=\"\" style=\"float:left;width:150px\"/> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi possimus et eos modi id alias at quia ex deleniti quaerat laudantium eaque laboriosam pariatur, magnam a veritatis. Atque numquam distinctio cumque, dolorum non quis a vel rerum aspernatur provident amet perferendis repellat, dolores sed porro ullam ex, molestiae. Pariatur, esse.',5),
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `tests` WRITE;
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;

INSERT INTO `tests` (`id`, `course_id`, `title`, `description`, `order`)
VALUES
	(1,1,'Basic Test','The first meal on the default course!',1),
	(2,1,'Blank Test','Just like you wanted it.',2);

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
	(2,'Reima Raju','temu92@gmail.com','$2y$10$LFlAQP0lQes918IsJ5jyBOeyXkj6u1iHAQ4aV4irBnj7aO3NnEoRC',1,'YuFjhgTsY75p9acZ4kIrjGAbdrLAzFYNKY9GRmK2IvUg9p7JTG6jZq2YA20l','0000-00-00 00:00:00','2015-12-01 12:44:11'),
	(3,'Erkki Esimerkki','erkin@esimerk.ki','$2y$10$Q0AJvNitiDjelOpna2nHsOea9NJCZFfjCAEy2dkRdJEHq1YH.GtGy',0,'3Zz2uRa8Bk6x3GOO25KFy6gEdjwmOeUjjyqBzPfBqQewCh4CG39dLAfFD7CZ','2015-12-01 13:20:27','2015-12-01 13:21:38'),
	(4,'Erkki Esimerkki','esi@merkki.fi','$2y$10$tyiiZn5CUCbCeGlqJjMqquDpQ0xTiFdjDhfysZjTTDpvCBz2RVdJW',0,'eCLYDi8GbhURam7nxxCbDGnD6XCK7snGcJXp7v1aGFEd9n3vzy8H39PAxPWf','2015-12-01 13:52:02','2015-12-01 14:07:39');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
