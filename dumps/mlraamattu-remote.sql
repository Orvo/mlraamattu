-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Palvelin: localhost
-- Luontiaika: 17.03.2016 klo 13:03
-- Palvelimen versio: 5.5.47-0ubuntu0.14.04.1
-- PHP:n versio: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Tietokanta: `mlraamattu`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `answers`
--

CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `text` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `error_margin` int(11) NOT NULL DEFAULT '0',
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=17 ;

--
-- Vedos taulusta `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `text`, `error_margin`, `is_correct`) VALUES
(1, 1, 'Yes', 10, 1),
(2, 1, 'Maybe', 10, 0),
(3, 1, 'Wat?', 10, 0),
(4, 1, 'Blizz pls!', 10, 1),
(5, 2, 'One seems like enough.', 10, 0),
(6, 2, 'At least 4, pls.', 10, 0),
(7, 2, '1337! What else?', 10, 1),
(8, 2, 'What kind of a question is this?', 10, 0),
(9, 3, 'Bananas', 10, 1),
(10, 4, 'Potato', 10, 1),
(11, 4, 'Tomato', 10, 1),
(12, 4, 'Salad', 10, 1),
(13, 6, 'Very', 0, 1),
(14, 6, 'Somewhat', 0, 0),
(15, 6, 'Really what?', 0, 0),
(16, 6, 'Vrysrsbsns', 0, 0);

-- --------------------------------------------------------

--
-- Rakenne taululle `archive`
--

CREATE TABLE IF NOT EXISTS `archive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `replied_to` tinyint(1) NOT NULL,
  `reviewed_by` int(11) DEFAULT NULL,
  `discarded` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Vedos taulusta `archive`
--

INSERT INTO `archive` (`id`, `user_id`, `test_id`, `data`, `replied_to`, `reviewed_by`, `discarded`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '{"all_correct":false,"num_correct":4,"total":5,"given_answers":{"1":["1","3","4"],"2":"7","3":"banana","4":["tomato","salad","potato"],"5":"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi possimus et eos modi id alias at quia ex deleniti quaerat laudantium eaque laboriosam pariatur, magnam a veritatis.\\r\\n\\r\\nAtque numquam distinctio cumque, dolorum non quis a vel rerum aspernatur provident amet perferendis repellat, dolores sed porro ullam ex, molestiae. Pariatur, esse."}}', 0, NULL, 0, '0000-00-00 00:00:00', '2016-01-22 17:49:32'),
(2, 2, 2, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"6":"13"}}', 0, NULL, 0, '2015-12-01 10:54:32', '2015-12-15 13:46:07'),
(3, 3, 1, '{"all_correct":false,"num_correct":0,"total":5,"given_answers":{"1":["1","4"],"2":"6","3":"bananas","4":["potato","tomato","salad"],"5":"rtrfghfghfgd"}}', 1, NULL, 0, '2015-12-01 12:20:27', '2015-12-01 12:20:27'),
(5, 4, 1, '{"all_correct":false,"num_correct":2,"total":5,"given_answers":{"1":["1","3","4"],"2":"6","3":"bananas","4":["potatoasd","tomato","salad"],"5":"rtrfghfghfgd hello world"},"validation":{"1":{"correct":false,"partial":2,"total":2,"correct_answers":[{"id":"1","question_id":"1","text":"Yes","error_margin":"10","is_correct":"1"},{"id":"4","question_id":"1","text":"Blizz pls!","error_margin":"10","is_correct":"1"}],"status":2},"2":{"correct":false,"correct_answers":{"id":"7","question_id":"2","text":"1337! What else?","error_margin":"10","is_correct":"1"},"status":1},"3":{"correct":true,"correct_answers":{"id":"9","question_id":"3","text":"Bananas","error_margin":"10","is_correct":"1"},"status":3},"4":{"correct":false,"partial":2,"total":3,"correct_answers":[{"id":"10","question_id":"4","text":"Potato","error_margin":"10","is_correct":"1"},{"id":"11","question_id":"4","text":"Tomato","error_margin":"10","is_correct":"1"},{"id":"12","question_id":"4","text":"Salad","error_margin":"10","is_correct":"1"}],"correct_rows":{"1":true,"2":true},"status":2},"5":{"correct":true,"status":3}}}', 0, NULL, 0, '2015-12-03 06:57:58', '2016-03-16 07:40:15'),
(7, 2, 6, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"8":"19"}}', 0, NULL, 1, '2015-12-17 07:39:38', '2015-12-17 07:39:42'),
(8, 4, 10, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"13":"asdasdsdssds"}}', 0, NULL, 0, '2015-12-22 09:15:47', '2016-01-26 17:19:59'),
(9, 2, 10, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"13":"\\u00f6"}}', 0, NULL, 0, '2016-01-22 22:13:10', '2016-01-26 17:18:36'),
(10, 4, 2, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"6":"13"},"validation":{"6":{"correct":true,"correct_answers":{"id":13,"question_id":6,"text":"Very","error_margin":0,"is_correct":1},"status":3}}}', 0, NULL, 0, '2016-02-15 15:59:07', '2016-02-15 16:00:17'),
(11, 1, 1, '{"all_correct":false,"num_correct":2,"total":5,"given_answers":{"1":["2","3"],"2":"7","3":"ghjfgh","4":["ghj","",""],"5":"fgdhj"},"validation":{"1":{"correct":false,"partial":0,"total":2,"correct_answers":{},"status":1},"2":{"correct":true,"correct_answers":{"id":"7","question_id":"2","text":"1337! What else?","error_margin":"10","is_correct":"1"},"status":3},"3":{"correct":false,"correct_answers":{"id":"9","question_id":"3","text":"Bananas","error_margin":"10","is_correct":"1"},"status":1},"4":{"correct":false,"partial":0,"total":3,"correct_answers":{},"correct_rows":[],"status":1},"5":{"correct":true,"status":3}}}', 0, NULL, 0, '2016-03-10 15:06:00', '2016-03-10 15:06:00'),
(12, 5, 1, '{"all_correct":false,"num_correct":3,"total":5,"given_answers":{"1":["1","2"],"2":"7","3":"bananas","4":["potato","tomato","salad"],"5":"asdf"},"validation":{"1":{"correct":false,"partial":0,"total":2,"correct_answers":[],"status":1},"2":{"correct":true,"correct_answers":{"id":"7","question_id":"2","text":"1337! What else?","error_margin":"10","is_correct":"1"},"status":3},"3":{"correct":true,"correct_answers":{"id":"9","question_id":"3","text":"Bananas","error_margin":"10","is_correct":"1"},"status":3},"4":{"correct":false,"partial":0,"total":3,"correct_answers":[],"correct_rows":[],"status":1},"5":{"correct":true,"status":3}},"feedback":{"1":"Sy\\u00f6t\\u00e4 koepalautetta kysymyskohtaisesti jokaisen kysymyksen alla olevaan kentt\\u00e4\\u00e4n. Voit j\\u00e4tt\\u00e4\\u00e4 ne kent\\u00e4t tyhj\\u00e4ksi joihin et halua antaa palautetta, mutta sinun t\\u00e4ytyy antaa palautetta v\\u00e4hint\\u00e4\\u00e4n yhteen kysymykseen.","2":"Palautteen l\\u00e4hetyksen yhteydess\\u00e4 kokeen suorittajalle l\\u00e4hetet\\u00e4\\u00e4n s\\u00e4hk\\u00f6postihuomautus annetusta palautteesta. Viestiin sis\\u00e4llytet\\u00e4\\u00e4n vain ne kysymykset joihin olet antanut palautetta.","3":"Koepalautteen antaminen auttaa kokeiden suorittajia oppimaan paremmin. Vaikka j\\u00e4rjestelm\\u00e4 tarkistaakin koevastaukset automaattisesti, kirjallisen vastauksen tarkistus ei onnistu koneellisesti ja sen tarkistus tulee suorittaa koepalautteen antamisen kautta.","4":"Koepalautteen antaminen lis\\u00e4ksi sallii k\\u00e4ytt\\u00e4j\\u00e4n jatkaa kurssia vaikkei k\\u00e4ytt\\u00e4j\\u00e4 olisi saanut v\\u00e4hint\\u00e4\\u00e4n puolta kysymyksist\\u00e4 oikein.","5":"Palautteen l\\u00e4hetyksen yhteydess\\u00e4 kokeen suorittajalle l\\u00e4hetet\\u00e4\\u00e4n s\\u00e4hk\\u00f6postihuomautus annetusta palautteesta. Viestiin sis\\u00e4llytet\\u00e4\\u00e4n vain ne kysymykset joihin olet antanut palautetta."}}', 1, 4, 0, '2016-03-10 15:08:56', '2016-03-11 12:04:04'),
(13, 6, 1, '{"all_correct":false,"num_correct":1,"total":5,"given_answers":{"1":["4"],"2":"6","3":"bananananananas","4":["RIP","RIP","RIP"],"5":"Very specific answer"},"validation":{"1":{"correct":false,"partial":1,"total":2,"correct_answers":[{"id":"1","question_id":"1","text":"Yes","error_margin":"10","is_correct":"1"},{"id":"4","question_id":"1","text":"Blizz pls!","error_margin":"10","is_correct":"1"}],"status":2},"2":{"correct":false,"correct_answers":{"id":"7","question_id":"2","text":"1337! What else?","error_margin":"10","is_correct":"1"},"status":1},"3":{"correct":false,"correct_answers":{"id":"9","question_id":"3","text":"Bananas","error_margin":"10","is_correct":"1"},"status":1},"4":{"correct":false,"partial":0,"total":3,"correct_answers":[{"id":"10","question_id":"4","text":"Potato","error_margin":"10","is_correct":"1"},{"id":"11","question_id":"4","text":"Tomato","error_margin":"10","is_correct":"1"},{"id":"12","question_id":"4","text":"Salad","error_margin":"10","is_correct":"1"}],"correct_rows":[],"status":1},"5":{"correct":true,"status":3}}}', 0, NULL, 0, '2016-03-10 15:18:02', '2016-03-10 15:18:02');

-- --------------------------------------------------------

--
-- Rakenne taululle `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Vedos taulusta `courses`
--

INSERT INTO `courses` (`id`, `title`, `description`, `created_at`, `updated_at`, `published`) VALUES
(1, 'Maailman Valo', '<p><img alt="" src="/uploads/images/mv-kaistale.png" style="width: 430px; height: 20px;" /></p>\n\n<h1>Maailman Valo</h1>\n\n<p><img alt="" src="/uploads/images/mv-vihot.png" style="width: 357px; height: 464px; float: right; margin-left: 10px; margin-right: 10px;" />Kurssi maailman historian vaikuttavimman henkil&ouml;n, Jeesus Nasaretilaisen el&auml;m&auml;st&auml; ja opetuksista.</p>\n\n<p>Matkusta ajassa 2000 vuotta taaksep&auml;in siihen maailmaan, miss&auml; Jeesus eli ja kohtasi ihmisi&auml; ja koe miksi h&auml;nen el&auml;m&auml;ns&auml; ja opetuksensa kiehtovat ja vaikuttavat edelleen.</p>\n\n<p>Kurssi k&auml;sitt&auml;&auml; 25 aihetta.&nbsp; Kurssin suorittaneelle l&auml;hetet&auml;&auml;n todistus.</p>\n\n<p>Er&auml;s kurssin k&auml;ynyt kirjoittaa:</p>\n\n<blockquote>&ldquo;Kiitos t&auml;st&auml; ihanasta kurssista.&nbsp; Nyt olen saanut sellaista hengellist&auml; ravintoa, jota olen janonnut monta vuotta. Voi miten t&auml;m&auml; on avartanut Raamattua ja l&auml;hent&auml;nyt minut Jeesukseen! Nyt on taas uutta tietoa ja olen entist&auml; vahvempi.&nbsp; Suosittelen mielell&auml;ni toisillekin t&auml;t&auml; kurssia.&nbsp; Kiitos!&rdquo;</blockquote>\n\n<p>Kurssin suorittaminen tapahtuu seuraavasti:</p>\n\n<ul>\n	<li>Lue opintoaihe ja siihen liittyv&auml;t raamatunkohdat.</li>\n	<li>T&auml;yt&auml; kertauslomake. - Voit lukea opintoaihetta uudelleen ja tarkistaa vastauksesi. Vastauslomakkeessa on my&ouml;s kysymys, johon voit vastata omin sanoin ja antaa henkil&ouml;kohtaisempaakin palautetta.</li>\n	<li>Opinto-ohjaajamme ovat k&auml;ytett&auml;viss&auml;, kun k&auml;yt kurssia, joten voit vapaasti kirjoittaa meille kysymyksi&auml;si tai kommenttejasi. &nbsp;</li>\n	<li>Rekister&ouml;idyt t&auml;ytt&auml;ess&auml;si ensimm&auml;ist&auml;&nbsp;kertauslomaketta, ellet ole jo aikaisemmin rekister&ouml;itynyt. Saat my&ouml;s palautetta vastauksistas.</li>\n	<li>N&auml;in jatketaan, kunnes olet k&auml;ynyt l&auml;pi kaikki kurssin 25 aihetta.</li>\n	<li>Voit siis opiskella omaan tahtiisi.</li>\n	<li>Kertauslomake kunkin opintoaiheen yhteydess&auml; rohkaisee pohtimaan lukemaasi ja oppimaasi.</li>\n</ul>\n\n<p>&nbsp;</p>\n\n<p>\n<video autoplay="true" loop="true mute=" true="">&nbsp;</video>\n</p>\n', '0000-00-00 00:00:00', '2016-03-16 12:39:34', 1),
(2, 'The Brand New Course', 'New and improved!', '0000-00-00 00:00:00', '2015-12-22 08:14:51', 1),
(3, 'The "Kinda Shabby" Course', '<p>Tervetuloa Paavalin matkassa -kirjekurssille, johon kuuluu 12&nbsp;opintovihkoa. Kurssi pureutuu Paavalin henkil&ouml;historiaan, kirjoituksiin ja ajatteluun. Kurssin suorittaneelle l&auml;hetet&auml;&auml;n todistus.</p>\n\n<p>Kurssin suorittaminen tapahtuu seuraavasti:</p>\n\n<ul>\n	<li>Lue opintoaihe ja siihen liittyv&auml;t raamatunkohdat. Raamatunkohdat avautuvat klikkaamalla omaan ikkunaan.</li>\n	<li>T&auml;yt&auml; kertauslomake. - Voit lukea opintoaihetta uudelleen ja tarkistaa vastauksesi. Vastauslomakkeessa on my&ouml;s kysymys, johon voit vastata omin sanoin ja antaa henkil&ouml;kohtaisempaakin palautetta.</li>\n	<li>Opinto-ohjaajamme ovat k&auml;ytett&auml;viss&auml;, kun k&auml;yt kurssia, joten voit vapaasti kirjoittaa meille kysymyksi&auml;si tai kommenttejasi. &nbsp;</li>\n	<li>Kirjoita nimesi kuhunkin kertauslomakkeeseen. Pid&auml;mme kirjaa edistymisest&auml;si. Jos annat s&auml;hk&ouml;postiosoitteesi, saat palautetta vastauksistasi alusta pit&auml;en. Voit jatkaa seuraavaan opintoaiheeseen ennen kuin olemme ehtineet antaa palautetta.</li>\n	<li>N&auml;in jatketaan, kunnes olet k&auml;ynyt l&auml;pi kaikki kurssin 12 opintovihkoa.</li>\n	<li>Voit siis opiskella omaan tahtiisi.</li>\n	<li>Kertauslomake kunkin opintoaiheen yhteydess&auml; rohkaisee pohtimaan lukemaasi ja oppimaasi.</li>\n</ul>\n', '0000-00-00 00:00:00', '2016-02-29 12:16:00', 1),
(4, 'Testi Kurssi', 'Ahoy!', '2015-12-22 08:23:13', '2015-12-22 08:23:13', 1),
(5, 'asdfasdf', '<p>asdfasdfasdfasdf</p>\n', '2016-02-29 12:26:19', '2016-02-29 12:26:19', 0);

-- --------------------------------------------------------

--
-- Rakenne taululle `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vedos taulusta `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_10_12_000000_create_users_table', 1),
('2014_10_12_100000_create_password_resets_table', 1),
('2015_11_10_100728_create_tests_table', 1),
('2015_11_10_100911_create_questions_table', 1),
('2015_11_10_100953_create_answers_table', 1),
('2015_11_10_101135_create_courses_table', 1),
('2015_11_10_102511_add_order_to_tests_table', 2),
('2015_11_10_102927_add_order_to_questions_table', 2),
('2015_11_13_082828_add_timestamps_to_users', 3),
('2015_12_01_073542_create_archive_table', 4),
('2015_12_17_083226_add_timestamps_to_tests_table', 5),
('2015_12_17_162411_add_timestamps_to_courses_table', 6),
('2015_12_22_074011_add_published_to_courses_table', 7),
('2016_01_22_164455_add_discarded_column_to_archive', 8),
('2016_02_15_123206_create_pages_table', 9),
('2016_02_19_113744_add_hidden_column_to_pages_table', 10),
('2016_03_01_081829_add_autodiscard_column_to_tests', 11),
('2016_03_01_111920_add_change_password_column_to_users', 12),
('2016_03_11_112345_add_reviewed_by_column_to_archive', 13),
('2016_03_16_134707_change_access_level_type_in_users_table', 14);

-- --------------------------------------------------------

--
-- Rakenne taululle `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Vedos taulusta `pages`
--

INSERT INTO `pages` (`id`, `test_id`, `body`, `hidden`, `created_at`, `updated_at`) VALUES
(1, 1, '<p><img alt="" src="http://raamattuavautuu.adventist.fi/uploaded_assets/5373-Maailman-valo-1.png?thumbnail=original&amp;1432180436" style="float:right; height:410px; margin:1em; width:278px" />Iloitsemme siit&auml;, ett&auml; voimme esitell&auml; sinulle Kristuksen henkil&ouml;kohtaisesti <strong>Maailman Valo</strong> -raamatuntutkistelukurssin kautta. Olemme ker&auml;nneet Kristuksesta, Maailman Valosta, loistavia kirkkaita s&auml;teit&auml; t&auml;m&auml;n kurssin sivuille, jotta h&auml;n tulisi sinulle entist&auml; todellisemmaksi ja l&auml;heisemm&auml;ksi. Kun luet t&auml;m&auml;n yksinkertaisen mutta vaikuttavan kertomuksen Kristuksen el&auml;m&auml;st&auml;, uskomme, ett&auml; se innoittaa sinua syvemmin kuin mik&auml;&auml;n muu el&auml;m&auml;kerta.</p>\n\n<hr />\n<h2>Kertomuksen l&auml;hde</h2>\n\n<p>Kertomuksemme l&auml;htein&auml; ovat nelj&auml; evankeliumia: Matteuksen, Markuksen, Luukkaan ja Johanneksen, evankeliumit, jotka ovat luotettavia ja innoitettuja kertomuksia Jeesuksen el&auml;m&auml;st&auml;. Matteus, Markus ja Luukas kertovat meille paljon siit&auml;, mit&auml; Jeesus teki. Johannes kertoo siit&auml;, kuka h&auml;n on, ja pyrkii kuvaamaan Jeesuksen taivaallista kauneutta, h&auml;nest&auml; loistanutta vanhurskautta, totuutta, taivaallista pyhyytt&auml; ja rakkautta.</p>\n\n<p>N<img alt="" src="/uploads/images/cat3.jpg" style="float:left; height:157px; margin:0 1em 1em 0; width:210px" />&auml;m&auml; el&auml;m&auml;kerrat ovat sellaisten henkil&ouml;iden kirjoittamia, jotka eliv&auml;t Jeesuksen ollessa maan p&auml;&auml;ll&auml; ja jotka ovat p&auml;tevi&auml; kirjoittamaan h&auml;nest&auml;. Nelj&auml; Uuden testamentin kirjaa, nelj&auml; evankeliumia, ovat meid&auml;n auktoriteettinamme. Niist&auml; l&ouml;yd&auml;mme luotettavat yksityiskohdat Jeesuksesta Kristuksesta: h&auml;nen olemassaolostaan ennen maailman luomista, h&auml;nen syntym&auml;st&auml;&auml;n, el&auml;m&auml;st&auml;&auml;n, teht&auml;v&auml;st&auml;&auml;n ja opetuksestaan, kuolemastaan, yl&ouml;snousemuksestaan ja h&auml;nen lupauksestaan palata t&auml;h&auml;n maailmaan toisen kerran. Jo paljon ennen kuin p&auml;&auml;set t&auml;m&auml;n 25 opintovihon kurssin loppuun, tulet huomaamaan, ett&auml; Jeesus on enemm&auml;n kuin vain pelkk&auml; ihminen, n&auml;et h&auml;ness&auml; Maailman Valon.</p>', 0, '0000-00-00 00:00:00', '2016-03-16 07:31:50'),
(2, 2, '<h2>Kaksi muistettavaa asiaa</h2>\r\n<p>\r\n	Valmistellessamme tätä raamattukurssia sinua varten olemme pitäneet mielessämme kaksi tärkeää asiaa: ensiksi, Kristuksen elämän tapahtumat on esitetty luonnollisessa järjestyksessään niin tarkasti kuin mahdollista. Tätä kutsutaan kronologiaksi, ja tämä on tärkeää. Lukiessasi näitä opintovihkoja tulet kuitenkin huomaamaan toisen, ehkä vielä tärkeämmän näkökohdan, joka on inspiroinut meitä. Pyrimme tuomaan esille mahdollisimman monia puolia Kristuksen elämästä. Saavuttaaksemme tämän meidän on joskus täytynyt jättää kertomuksen kronologia hetkeksi sivuun.\r\n</p>\r\n<p>\r\n	Samalla tavoin kuin auringonvalo prisman läpi heijastuessaan hajoaa sateenkaaren ihaniin väreihin samoin Kristus, vanhurskauden aurinko, tulee puoleensavetävämmäksi kun katsomme häntä mestariopettajana, suurena parantajana, syntisten ystävänä, Jumalan profeettana, ihmeitten tekijänä, ihmisen Pelastajana ja Jumalan Poikana. Tästä kuvaava esimerkki: Tavallisesta tarkkailijasta timantti näyttää lähes tavalliselta kiveltä ennen hiomista, mutta kun taitava jalokiviseppä hioo ja kiillottaa sitä, kymmenet pinnat alkavat säkenöidä elävän liekin tavoin. Samalla tavoin Kristuksen elämässä on monia puolia, jotka yhdistettyinä muodostavat täydellisen suuren Valon, joka on Kristus itse. Olemme pyrkineet yhdistämään nämä palaset sillä tavoin, että niistä muodostuisi mitä täydellisin kuva kaikkein kauneimmasta elämästä, mitä tämä maailma on koskaan tuntenut.\r\n</p>', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 10, '<p><img src="http://raamattuavautuu.adventist.fi/uploaded_assets/534136-kansi01b.jpg?thumbnail=original&amp;1432180481" style="float:right; margin:1em; width:250px" /></p>\n\n<p>Paavalilla oli n&auml;ky &ndash; unelma. Se oli suuri unelma, unelma uudesta ajasta ja uudesta maailmanj&auml;rjestyksest&auml;. Kaikki olisi uutta, ihmiskunta olisi j&auml;lleen yht&auml; ja ihmiset el&auml;isiv&auml;t tasa-arvoisina, rauhassa ja toisiaan rakastaen.</p>\n\n<p>Olympiaurheilijan kipin&auml; syd&auml;mess&auml;&auml;n Paavali l&auml;hti muuttamaan maail&shy;maa. H&auml;n kirjoitti korinttilaisille, joilla oli tapana j&auml;rjest&auml;&auml; joka toinen vuosi Isthmian kisat:</p>\n\n<blockquote>&rdquo;Tied&auml;tteh&auml;n, ett&auml; vaikka juoksukilpailussa kaikki juoksevat, vain yksi saa palkinnon. Juoskaa siis niin, ett&auml; voitatte sen!&nbsp; Jokainen kilpailija noudattaa lujaa itsekuria, juoksijat saavuttaakseen katoavan seppeleen, me saadaksemme katoamattoman. Min&auml; en siis juokse p&auml;&auml;m&auml;&auml;r&auml;tt&ouml;m&auml;sti enk&auml; nyrkkeilless&auml;ni huido ilmaan. Kohdistan iskut omaan ruumiiseeni ja pakotan sen tottelemaan, jottei itse&auml;ni lopulta hyl&auml;tt&auml;isi, minua, joka olen kutsunut muita kilpailuun.&rdquo; (1. Kor. 9:24&ndash;27.)</blockquote>\n\n<p>Paavali oli l&ouml;yt&auml;nyt n&auml;yn, jonka puolesta h&auml;n oli valmis kuolemaan. T&auml;st&auml; syyst&auml; h&auml;n eli el&auml;m&auml;ns&auml; t&auml;ydesti. H&auml;nen j&auml;lkeens&auml; maailma ei olisi koskaan en&auml;&auml; sama.</p>\n\n<p>Kahdensadan viidenkymmenen vuoden kuluttua h&auml;nen sanomansa oli vastaanotettu puolessa Rooman valtakuntaa ja se unelma, jota h&auml;n eli, on t&auml;h&auml;n p&auml;iv&auml;&auml;n menness&auml; vaikuttanut maailmaan enemm&auml;n kuin mik&auml;&auml;n muu maailmankatsomus.</p>\n\n<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>', 0, '2016-02-29 12:17:40', '2016-02-29 12:19:46'),
(4, 10, '<p><img src="http://raamattuavautuu.adventist.fi/uploaded_assets/534136-kansi01b.jpg?thumbnail=original&amp;1432180481" style="float:right; margin:1em; width:250px" /></p>\n\n<p>Paavalilla oli n&auml;ky &ndash; unelma. Se oli suuri unelma, unelma uudesta ajasta ja uudesta maailmanj&auml;rjestyksest&auml;. Kaikki olisi uutta, ihmiskunta olisi j&auml;lleen yht&auml; ja ihmiset el&auml;isiv&auml;t tasa-arvoisina, rauhassa ja toisiaan rakastaen.</p>\n\n<p>Olympiaurheilijan kipin&auml; syd&auml;mess&auml;&auml;n Paavali l&auml;hti muuttamaan maail&shy;maa. H&auml;n kirjoitti korinttilaisille, joilla oli tapana j&auml;rjest&auml;&auml; joka toinen vuosi Isthmian kisat:</p>\n\n<blockquote>&rdquo;Tied&auml;tteh&auml;n, ett&auml; vaikka juoksukilpailussa kaikki juoksevat, vain yksi saa palkinnon. Juoskaa siis niin, ett&auml; voitatte sen!&nbsp; Jokainen kilpailija noudattaa lujaa itsekuria, juoksijat saavuttaakseen katoavan seppeleen, me saadaksemme katoamattoman. Min&auml; en siis juokse p&auml;&auml;m&auml;&auml;r&auml;tt&ouml;m&auml;sti enk&auml; nyrkkeilless&auml;ni huido ilmaan. Kohdistan iskut omaan ruumiiseeni ja pakotan sen tottelemaan, jottei itse&auml;ni lopulta hyl&auml;tt&auml;isi, minua, joka olen kutsunut muita kilpailuun.&rdquo; (1. Kor. 9:24&ndash;27.)</blockquote>\n\n<p>Paavali oli l&ouml;yt&auml;nyt n&auml;yn, jonka puolesta h&auml;n oli valmis kuolemaan. T&auml;st&auml; syyst&auml; h&auml;n eli el&auml;m&auml;ns&auml; t&auml;ydesti. H&auml;nen j&auml;lkeens&auml; maailma ei olisi koskaan en&auml;&auml; sama.</p>\n\n<p>Kahdensadan viidenkymmenen vuoden kuluttua h&auml;nen sanomansa oli vastaanotettu puolessa Rooman valtakuntaa ja se unelma, jota h&auml;n eli, on t&auml;h&auml;n p&auml;iv&auml;&auml;n menness&auml; vaikuttanut maailmaan enemm&auml;n kuin mik&auml;&auml;n muu maailmankatsomus.</p>\n\n<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>', 0, '2016-02-29 12:19:00', '2016-02-29 12:19:00'),
(5, 10, '<p><img src="http://raamattuavautuu.adventist.fi/uploaded_assets/534136-kansi01b.jpg?thumbnail=original&amp;1432180481" style="float:right; margin:1em; width:250px" /></p>\n\n<p>Paavalilla oli n&auml;ky &ndash; unelma. Se oli suuri unelma, unelma uudesta ajasta ja uudesta maailmanj&auml;rjestyksest&auml;. Kaikki olisi uutta, ihmiskunta olisi j&auml;lleen yht&auml; ja ihmiset el&auml;isiv&auml;t tasa-arvoisina, rauhassa ja toisiaan rakastaen.</p>\n\n<p>Olympiaurheilijan kipin&auml; syd&auml;mess&auml;&auml;n Paavali l&auml;hti muuttamaan maail&shy;maa. H&auml;n kirjoitti korinttilaisille, joilla oli tapana j&auml;rjest&auml;&auml; joka toinen vuosi Isthmian kisat:</p>\n\n<blockquote>&rdquo;Tied&auml;tteh&auml;n, ett&auml; vaikka juoksukilpailussa kaikki juoksevat, vain yksi saa palkinnon. Juoskaa siis niin, ett&auml; voitatte sen!&nbsp; Jokainen kilpailija noudattaa lujaa itsekuria, juoksijat saavuttaakseen katoavan seppeleen, me saadaksemme katoamattoman. Min&auml; en siis juokse p&auml;&auml;m&auml;&auml;r&auml;tt&ouml;m&auml;sti enk&auml; nyrkkeilless&auml;ni huido ilmaan. Kohdistan iskut omaan ruumiiseeni ja pakotan sen tottelemaan, jottei itse&auml;ni lopulta hyl&auml;tt&auml;isi, minua, joka olen kutsunut muita kilpailuun.&rdquo; (1. Kor. 9:24&ndash;27.)</blockquote>\n\n<p>Paavali oli l&ouml;yt&auml;nyt n&auml;yn, jonka puolesta h&auml;n oli valmis kuolemaan. T&auml;st&auml; syyst&auml; h&auml;n eli el&auml;m&auml;ns&auml; t&auml;ydesti. H&auml;nen j&auml;lkeens&auml; maailma ei olisi koskaan en&auml;&auml; sama.</p>\n\n<p>Kahdensadan viidenkymmenen vuoden kuluttua h&auml;nen sanomansa oli vastaanotettu puolessa Rooman valtakuntaa ja se unelma, jota h&auml;n eli, on t&auml;h&auml;n p&auml;iv&auml;&auml;n menness&auml; vaikuttanut maailmaan enemm&auml;n kuin mik&auml;&auml;n muu maailmankatsomus.</p>\n\n<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>', 0, '2016-02-29 12:19:14', '2016-02-29 12:19:14');

-- --------------------------------------------------------

--
-- Rakenne taululle `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vedos taulusta `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('temu92@gmail.com', '0e2518a92bac1d1beadc7749d46f1c135631a9b3557ccf60273669ec970f4a25', '2016-03-16 08:54:09');

-- --------------------------------------------------------

--
-- Rakenne taululle `questions`
--

CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=14 ;

--
-- Vedos taulusta `questions`
--

INSERT INTO `questions` (`id`, `test_id`, `type`, `title`, `subtitle`, `order`) VALUES
(1, 1, 'MULTI', 'Hello World!', 'Do you feel sufficiently greeted?', 1),
(2, 1, 'CHOICE', 'Choose the right amount of potatoes.', 'It''s a very specific science.', 2),
(3, 1, 'TEXT', 'Be careful of what you write here.', 'I suggest you type "bananas" or something weird may happen.', 3),
(4, 1, 'MULTITEXT', 'At this moment you realised it''s pretty serious.', 'Now you done goofed.', 4),
(5, 1, 'TEXTAREA', 'Freedom!', 'At least here you don''t have to be specific.\r\n\r\n<img src="https://aitolahti.adventist.fi/uploaded_assets/2396408-aitolahti.jpg?thumbnail=original&1432180496" alt="" style="float:left;width:150px"/> <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi possimus et eos modi id alias at quia ex deleniti quaerat laudantium eaque laboriosam pariatur, magnam a veritatis. Atque numquam distinctio cumque, dolorum non quis a vel rerum aspernatur provident amet perferendis repellat, dolores sed porro ullam ex, molestiae. Pariatur, esse.</p>', 5),
(6, 2, 'CHOICE', 'Ha! I lied to you! It''s not really blank after all!', 'Does it make you feel betrayed?', 0),
(13, 10, 'TEXTAREA', 'No mercy!!', 'The hardest question ever!', 1);

-- --------------------------------------------------------

--
-- Rakenne taululle `tests`
--

CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `autodiscard` tinyint(1) NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=13 ;

--
-- Vedos taulusta `tests`
--

INSERT INTO `tests` (`id`, `course_id`, `title`, `description`, `autodiscard`, `order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Basic Test', '<p>The first meal on the default course!</p>\n', 0, 1, '0000-00-00 00:00:00', '2016-03-10 14:44:56'),
(2, 1, 'Blank Test', 'Just like you wanted it.', 0, 2, '0000-00-00 00:00:00', '2015-12-22 07:00:00'),
(10, 3, 'Shabby Course Test', '<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>\n', 0, 1, '2015-12-22 09:08:58', '2016-02-29 12:19:00'),
(11, 1, 'Really Blank Test', 'Hehe', 0, 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 1, 'ASDASDASD', 'SDFSDGSDFGFDFDGFG', 0, 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Rakenne taululle `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `change_password` tinyint(1) NOT NULL,
  `access_level` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=8 ;

--
-- Vedos taulusta `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `change_password`, `access_level`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ylläpitäjä', 'admin', '$2y$10$CxVDDTDweKgC7gcU3ipQJuJY5xjOg2/RexO/.jIxSTkJ7dtqR39UO', 0, 'ADMIN', 'xu9nd6HTQvaRCz256ApqsSJFIVc6Tko2DcOhwvGC77kgSyPcmv5c6TB5pAWD', '2016-03-10 09:10:26', '2016-03-16 13:47:27'),
(2, 'Reima Raju', 'test', '$2y$10$LFlAQP0lQes918IsJ5jyBOeyXkj6u1iHAQ4aV4irBnj7aO3NnEoRC', 0, 'ADMIN', 'ifWMy2tL80ywKP2t4nigxvRFCts7OFtGF3voTog0KvOx8ehcuQy0uBykRr2K', '0000-00-00 00:00:00', '2016-03-16 13:47:27'),
(3, 'Erkki Esimerkki', 'erkin@esimerk.ki', '$2y$10$Q0AJvNitiDjelOpna2nHsOea9NJCZFfjCAEy2dkRdJEHq1YH.GtGy', 0, 'USER', '3Zz2uRa8Bk6x3GOO25KFy6gEdjwmOeUjjyqBzPfBqQewCh4CG39dLAfFD7CZ', '2015-12-01 12:20:27', '2016-03-16 13:47:27'),
(4, 'Milla Mallikas', 'millan@posti.fi', '$2y$10$tyiiZn5CUCbCeGlqJjMqquDpQ0xTiFdjDhfysZjTTDpvCBz2RVdJW', 0, 'ADMIN', 'rnrHn3qpMFL3M3xMyTyXw664UYTT9YHe1TPIMhRDgNvPg61iUk1MlQIxJKxd', '2015-12-01 12:52:02', '2016-03-16 13:47:27'),
(5, 'Testikäyttäjä', 'temu92@gmail.com', '$2y$10$Y80j/KTf6lqu40eVEN/xi.MdcqD9trPYXz03Nj/ZgS8lWa.0TFchC', 1, 'ADMIN', 'TAg75w35LyxaKZYeeBuGLxaKGBKgBnhQ5qvXZbxYyKlQ1XeCsK0YIsVFzsqB', '2016-03-10 15:08:56', '2016-03-16 13:53:52'),
(6, 'Bram', 'bramvgemert@gmail.com', '$2y$10$HbbK3QXdlpIV8ujcHHPmVetIK0vsWWSlN5Iz7rFX0fcqiElfQVj/y', 1, 'TEACHER', NULL, '2016-03-10 15:18:01', '2016-03-16 13:47:51'),
(7, 'Orvo Miettinen', 'orvo@adventtikirkko.fi', '$2y$10$4Fz9sVlZ1yBZ1natG0/LguSiro4am/7iIA.l88PDm3K6CvEvz4GJW', 1, 'ADMIN', NULL, '2016-03-16 11:56:03', '2016-03-16 13:47:45');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
