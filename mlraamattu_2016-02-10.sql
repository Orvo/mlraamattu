# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 10.0.17-MariaDB)
# Database: mlraamattu
# Generation Time: 2016-02-10 13:37:12 +0000
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
	(16,6,'Vrysrsbsns',0,0),
	(29,13,'',10,1),
	(30,13,'',10,0),
	(31,14,'Kyllä',10,1),
	(32,14,'Ei',10,0);

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
  `discarded` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `archive` WRITE;
/*!40000 ALTER TABLE `archive` DISABLE KEYS */;

INSERT INTO `archive` (`id`, `user_id`, `test_id`, `data`, `replied_to`, `discarded`, `created_at`, `updated_at`)
VALUES
	(3,3,1,'{\"all_correct\":false,\"num_correct\":1,\"total\":5,\"given_answers\":{\"1\":[\"3\"],\"2\":\"6\",\"3\":\"bana\",\"4\":[\"\",\"tomato\",\"salad\"],\"5\":\"rtrfghfghfgd\"},\"validation\":{\"1\":{\"correct\":false,\"partial\":0,\"total\":2,\"correct_answers\":{\"0\":{\"id\":1,\"question_id\":1,\"text\":\"Yes\",\"error_margin\":10,\"is_correct\":1},\"3\":{\"id\":4,\"question_id\":1,\"text\":\"Blizz pls!\",\"error_margin\":10,\"is_correct\":1}}},\"2\":{\"correct\":false,\"correct_answers\":{\"id\":7,\"question_id\":2,\"text\":\"1337! What else?\",\"error_margin\":10,\"is_correct\":1}},\"3\":{\"correct\":false,\"correct_answers\":{\"id\":9,\"question_id\":3,\"text\":\"Bananas\",\"error_margin\":10,\"is_correct\":1}},\"4\":{\"correct\":false,\"partial\":2,\"total\":3,\"correct_answers\":[{\"id\":10,\"question_id\":4,\"text\":\"Potato\",\"error_margin\":10,\"is_correct\":1},{\"id\":11,\"question_id\":4,\"text\":\"Tomato\",\"error_margin\":10,\"is_correct\":1},{\"id\":12,\"question_id\":4,\"text\":\"Salad\",\"error_margin\":10,\"is_correct\":1}],\"correct_rows\":{\"1\":true,\"2\":true}},\"5\":{\"correct\":true}},\"feedback\":{\"1\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates rerum dolorum facilis dignissimos labore fugit pariatur omnis non totam, quibusdam id nemo distinctio perferendis.\\n\\nVeniam deserunt libero nesciunt alias eligendi, minima! Quod maxime odio, modi dicta numquam, facilis cum eligendi tempora, ab esse dolor molestiae alias, reiciendis accusantium. Dolore, consequuntur.\",\"2\":\"hello\",\"5\":\"Koepalautteen antaminen auttaa kokeiden suorittajia oppimaan paremmin. Vaikka j\\u00e4rjestelm\\u00e4 tarkistaakin useimmat koevastaukset automaattisesti, kirjallisen vastauksen tarkistus ja palautteen anto tulee suorittaa koepalautteen antamisen kautta.\\n\\nPalautteen l\\u00e4hetyksen yhteydess\\u00e4 kokeen suorittajalle l\\u00e4hetet\\u00e4\\u00e4n s\\u00e4hk\\u00f6postihuomautus annetusta palautteesta.\"}}',1,0,'2015-12-01 13:20:27','2016-02-05 10:47:50'),
	(5,4,1,'{\"all_correct\":false,\"num_correct\":3,\"total\":5,\"given_answers\":{\"1\":[\"1\",\"3\",\"4\"],\"2\":\"6\",\"3\":\"bananas\",\"4\":[\"potato\",\"tomato\",\"salad\"],\"5\":\"rtrfghfghfgd\"},\"validation\":{\"1\":{\"correct\":false,\"partial\":2,\"total\":2,\"correct_answers\":{\"0\":{\"id\":1,\"question_id\":1,\"text\":\"Yes\",\"error_margin\":10,\"is_correct\":1},\"3\":{\"id\":4,\"question_id\":1,\"text\":\"Blizz pls!\",\"error_margin\":10,\"is_correct\":1}}},\"2\":{\"correct\":false,\"correct_answers\":{\"id\":7,\"question_id\":2,\"text\":\"1337! What else?\",\"error_margin\":10,\"is_correct\":1}},\"3\":{\"correct\":true,\"correct_answers\":{\"id\":9,\"question_id\":3,\"text\":\"Bananas\",\"error_margin\":10,\"is_correct\":1}},\"4\":{\"correct\":true,\"partial\":3,\"total\":3,\"correct_answers\":[{\"id\":10,\"question_id\":4,\"text\":\"Potato\",\"error_margin\":10,\"is_correct\":1},{\"id\":11,\"question_id\":4,\"text\":\"Tomato\",\"error_margin\":10,\"is_correct\":1},{\"id\":12,\"question_id\":4,\"text\":\"Salad\",\"error_margin\":10,\"is_correct\":1}],\"correct_rows\":[true,true,true]},\"5\":{\"correct\":true}},\"feedback\":{\"1\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates rerum dolorum facilis dignissimos labore fugit pariatur omnis non totam, quibusdam id nemo distinctio perferendis.\\n\\nVeniam deserunt libero nesciunt alias eligendi, minima! Quod maxime odio, modi dicta numquam, facilis cum eligendi tempora, ab esse dolor molestiae alias, reiciendis accusantium. Dolore, consequuntur.\",\"2\":\"hello\",\"5\":\"Koepalautteen antaminen auttaa kokeiden suorittajia oppimaan paremmin. Vaikka j\\u00e4rjestelm\\u00e4 tarkistaakin useimmat koevastaukset automaattisesti, kirjallisen vastauksen tarkistus ja palautteen anto tulee suorittaa koepalautteen antamisen kautta.\\n\\nPalautteen l\\u00e4hetyksen yhteydess\\u00e4 kokeen suorittajalle l\\u00e4hetet\\u00e4\\u00e4n s\\u00e4hk\\u00f6postihuomautus annetusta palautteesta.\"}}',1,0,'2015-12-03 07:57:58','2016-02-05 10:38:46'),
	(10,2,1,'{\"all_correct\":false,\"num_correct\":2,\"total\":5,\"given_answers\":{\"1\":[\"1\",\"2\"],\"2\":\"6\",\"3\":\"I suggest you type \\\"bananas\\\" or something weird may happen. \",\"4\":[\"salad\",\"potato\",\"tomato\"],\"5\":\"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi possimus et eos modi id alias at quia ex deleniti quaerat laudantium eaque laboriosam pariatur, magnam a veritatis. Atque numquam distinctio cumque, dolorum non quis a vel rerum aspernatur provident amet perferendis repellat, dolores sed porro ullam ex, molestiae. Pariatur, esse.\"},\"validation\":{\"1\":{\"correct\":false,\"partial\":1,\"total\":2,\"correct_answers\":{\"0\":{\"id\":1,\"question_id\":1,\"text\":\"Yes\",\"error_margin\":10,\"is_correct\":1},\"3\":{\"id\":4,\"question_id\":1,\"text\":\"Blizz pls!\",\"error_margin\":10,\"is_correct\":1}}},\"2\":{\"correct\":false,\"correct_answers\":{\"id\":7,\"question_id\":2,\"text\":\"1337! What else?\",\"error_margin\":10,\"is_correct\":1}},\"3\":{\"correct\":false,\"correct_answers\":{\"id\":9,\"question_id\":3,\"text\":\"Bananas\",\"error_margin\":10,\"is_correct\":1}},\"4\":{\"correct\":true,\"partial\":3,\"total\":3,\"correct_answers\":[{\"id\":10,\"question_id\":4,\"text\":\"Potato\",\"error_margin\":10,\"is_correct\":1},{\"id\":11,\"question_id\":4,\"text\":\"Tomato\",\"error_margin\":10,\"is_correct\":1},{\"id\":12,\"question_id\":4,\"text\":\"Salad\",\"error_margin\":10,\"is_correct\":1}],\"correct_rows\":{\"1\":true,\"2\":true,\"0\":true}},\"5\":{\"correct\":true}},\"feedback\":{\"1\":\"Sy\\u00f6t\\u00e4 koepalautetta kysymyskohtaisesti jokaisen kysymyksen alla olevaan kentt\\u00e4\\u00e4n. Voit j\\u00e4tt\\u00e4\\u00e4 ne kent\\u00e4t tyhj\\u00e4ksi joihin et halua antaa palautetta, mutta sinun t\\u00e4ytyy antaa palautetta v\\u00e4hint\\u00e4\\u00e4n yhteen kysymykseen.\",\"2\":\"Sy\\u00f6t\\u00e4 koepalautetta kysymyskohtaisesti jokaisen kysymyksen alla olevaan kentt\\u00e4\\u00e4n. Voit j\\u00e4tt\\u00e4\\u00e4 ne kent\\u00e4t tyhj\\u00e4ksi joihin et halua antaa palautetta, mutta sinun t\\u00e4ytyy antaa palautetta v\\u00e4hint\\u00e4\\u00e4n yhteen kysymykseen.\",\"3\":\"Sy\\u00f6t\\u00e4 koepalautetta kysymyskohtaisesti jokaisen kysymyksen alla olevaan kentt\\u00e4\\u00e4n. Voit j\\u00e4tt\\u00e4\\u00e4 ne kent\\u00e4t tyhj\\u00e4ksi joihin et halua antaa palautetta, mutta sinun t\\u00e4ytyy antaa palautetta v\\u00e4hint\\u00e4\\u00e4n yhteen kysymykseen.\",\"4\":\"Sy\\u00f6t\\u00e4 koepalautetta kysymyskohtaisesti jokaisen kysymyksen alla olevaan kentt\\u00e4\\u00e4n. Voit j\\u00e4tt\\u00e4\\u00e4 ne kent\\u00e4t tyhj\\u00e4ksi joihin et halua antaa palautetta, mutta sinun t\\u00e4ytyy antaa palautetta v\\u00e4hint\\u00e4\\u00e4n yhteen kysymykseen.\",\"5\":\"Sy\\u00f6t\\u00e4 koepalautetta kysymyskohtaisesti jokaisen kysymyksen alla olevaan kentt\\u00e4\\u00e4n. Voit j\\u00e4tt\\u00e4\\u00e4 ne kent\\u00e4t tyhj\\u00e4ksi joihin et halua antaa palautetta, mutta sinun t\\u00e4ytyy antaa palautetta v\\u00e4hint\\u00e4\\u00e4n yhteen kysymykseen.\"}}',0,0,'2016-02-05 11:08:08','2016-02-10 12:51:41'),
	(11,2,2,'{\"all_correct\":false,\"num_correct\":0,\"total\":1,\"given_answers\":{\"6\":\"15\"},\"validation\":{\"6\":{\"correct\":false,\"correct_answers\":{\"id\":13,\"question_id\":6,\"text\":\"Very\",\"error_margin\":0,\"is_correct\":1}}}}',0,0,'2016-02-10 10:17:27','2016-02-10 10:17:27');

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
	(3,'The \"Kinda Shabby\" Course','Think twice before accepting!','0000-00-00 00:00:00','2015-12-22 12:30:56',1),
	(4,'Testi Kurssi','Ahoy!','2015-12-22 09:23:13','2016-01-20 08:11:33',0);

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
	('2015_12_22_074011_add_published_to_courses_table',7),
	('2016_01_22_164455_add_discarded_column_to_archive',8);

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

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;

INSERT INTO `password_resets` (`email`, `token`, `created_at`)
VALUES
	('millan@posti.fi','66d1700551ba5f786378d3fdb68aadfd359a3b647dcec69d1a5357f7e9ddb938','2016-02-03 13:44:58');

/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;


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
	(6,2,'CHOICE','Ha! I lied to you! It\'s not really blank after all!','Does it make you feel betrayed?',0),
	(13,10,'TEXTAREA','No mercy!!','The hardest question ever!',1),
	(14,11,'CHOICE','Uusi kysymys?','Syötä kysymys viereiseen tekstikenttään.',1);

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
	(2,1,'Blank Test','Just like you wanted it.',2,'0000-00-00 00:00:00','2015-12-22 08:00:00'),
	(10,3,'Shabby Course Test','Pls why',1,'2015-12-22 10:08:58','2015-12-22 10:08:58'),
	(11,2,'Uusi koe','Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fuga placeat omnis consequuntur adipisci, eligendi architecto nobis. Doloremque vero quibusdam pariatur repudiandae, magni impedit ab totam quasi molestiae.',1,'2016-01-28 12:37:14','2016-01-28 12:37:14');

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
	(2,'Reima Raju','reima@raju.fi','$2y$10$qXYKSR6iIYzbQmPQroRw3eaydlPTDdZFaNLudlO1BpbjRVCs5CBT2',1,'oxiR7vl0NsKfm4OOoxzwQxGpYf6EyqIJXhaEuhwgROxrLvYO0EiSwl4qkn8w','0000-00-00 00:00:00','2016-02-02 13:43:10'),
	(3,'Erkki Esimerkki','posti@osoite.fi','$2y$10$qXYKSR6iIYzbQmPQroRw3eaydlPTDdZFaNLudlO1BpbjRVCs5CBT2',0,'FsK3oecJPb00PdNn6IY9MLrKnoijSimQLnkwzUSviR3jSu62s6LcJGSIIJhP','2015-12-01 13:20:27','2016-02-05 10:47:57'),
	(4,'Milla Mallikas','millan@posti.fi','$2y$10$qXYKSR6iIYzbQmPQroRw3eaydlPTDdZFaNLudlO1BpbjRVCs5CBT2',1,'5ZCF1uxMjGSGd1CBKvpPlpucOATSkAgJa5yf9lLLz4XSnnjes77YikX3NjKW','2015-12-01 13:52:02','2016-02-05 11:07:27'),
	(5,'asdfasdf','eemaili@osoite.fi','$2y$10$qXYKSR6iIYzbQmPQroRw3eaydlPTDdZFaNLudlO1BpbjRVCs5CBT2',0,NULL,'2016-01-29 09:29:11','2016-01-29 09:29:11');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
