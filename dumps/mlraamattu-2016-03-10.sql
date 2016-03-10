-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.0.17-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win32
-- HeidiSQL Version:             9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table mlraamattu.answers
CREATE TABLE IF NOT EXISTS `answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(11) NOT NULL,
  `text` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `error_margin` int(11) DEFAULT '0',
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.answers: ~16 rows (approximately)
/*!40000 ALTER TABLE `answers` DISABLE KEYS */;
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
/*!40000 ALTER TABLE `answers` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.archive
CREATE TABLE IF NOT EXISTS `archive` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `replied_to` tinyint(1) NOT NULL,
  `discarded` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.archive: ~8 rows (approximately)
/*!40000 ALTER TABLE `archive` DISABLE KEYS */;
INSERT INTO `archive` (`id`, `user_id`, `test_id`, `data`, `replied_to`, `discarded`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, '{"all_correct":false,"num_correct":4,"total":5,"given_answers":{"1":["1","3","4"],"2":"7","3":"banana","4":["tomato","salad","potato"],"5":"Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi possimus et eos modi id alias at quia ex deleniti quaerat laudantium eaque laboriosam pariatur, magnam a veritatis.\\r\\n\\r\\nAtque numquam distinctio cumque, dolorum non quis a vel rerum aspernatur provident amet perferendis repellat, dolores sed porro ullam ex, molestiae. Pariatur, esse."}}', 0, 0, '0000-00-00 00:00:00', '2016-01-22 18:49:32'),
	(2, 2, 2, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"6":"13"}}', 0, 0, '2015-12-01 11:54:32', '2015-12-15 14:46:07'),
	(3, 3, 1, '{"all_correct":false,"num_correct":0,"total":5,"given_answers":{"1":["1","4"],"2":"6","3":"bananas","4":["potato","tomato","salad"],"5":"rtrfghfghfgd"}}', 1, 0, '2015-12-01 13:20:27', '2015-12-01 13:20:27'),
	(5, 4, 1, '{"all_correct":true,"num_correct":5,"total":5,"given_answers":{"1":["1","4"],"2":"7","3":"bananas","4":["potato","tomato","salad"],"5":"rtrfghfghfgd"},"validation":{"1":{"correct":true,"partial":2,"total":2,"correct_answers":{"0":{"id":1,"question_id":1,"text":"Yes","error_margin":10,"is_correct":1},"3":{"id":4,"question_id":1,"text":"Blizz pls!","error_margin":10,"is_correct":1}},"status":3},"2":{"correct":true,"correct_answers":{"id":7,"question_id":2,"text":"1337! What else?","error_margin":10,"is_correct":1},"status":3},"3":{"correct":true,"correct_answers":{"id":9,"question_id":3,"text":"Bananas","error_margin":10,"is_correct":1},"status":3},"4":{"correct":true,"partial":3,"total":3,"correct_answers":[{"id":10,"question_id":4,"text":"Potato","error_margin":10,"is_correct":1},{"id":11,"question_id":4,"text":"Tomato","error_margin":10,"is_correct":1},{"id":12,"question_id":4,"text":"Salad","error_margin":10,"is_correct":1}],"correct_rows":[true,true,true],"status":3},"5":{"correct":true,"status":3}}}', 0, 0, '2015-12-03 07:57:58', '2016-02-15 17:03:05'),
	(7, 2, 6, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"8":"19"}}', 0, 1, '2015-12-17 08:39:38', '2015-12-17 08:39:42'),
	(8, 4, 10, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"13":"asdasdsdssds"}}', 0, 0, '2015-12-22 10:15:47', '2016-01-26 18:19:59'),
	(9, 2, 10, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"13":"\\u00f6"}}', 0, 0, '2016-01-22 23:13:10', '2016-01-26 18:18:36'),
	(10, 4, 2, '{"all_correct":true,"num_correct":1,"total":1,"given_answers":{"6":"13"},"validation":{"6":{"correct":true,"correct_answers":{"id":13,"question_id":6,"text":"Very","error_margin":0,"is_correct":1},"status":3}}}', 0, 0, '2016-02-15 16:59:07', '2016-02-15 17:00:17');
/*!40000 ALTER TABLE `archive` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.courses: ~5 rows (approximately)
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` (`id`, `title`, `description`, `created_at`, `updated_at`, `published`) VALUES
	(1, 'Default Course', '<p><img alt="" src="/uploads/images/cat3.jpg" style="float:right; margin:1em; width:200px" />Kurssi maailman historian vaikuttavimman henkil&ouml;n, Jeesus Nasaretilaisen el&auml;m&auml;st&auml; ja opetuksista.</p>\n\n<p>Matkusta ajassa 2000 vuotta taaksep&auml;in siihen maailmaan, miss&auml; Jeesus eli ja kohtasi ihmisi&auml; ja koe miksi h&auml;nen el&auml;m&auml;ns&auml; ja opetuksensa kiehtovat ja vaikuttavat edelleen.</p>\n\n<p>Kurssi k&auml;sitt&auml;&auml; 25 aihetta.&nbsp; Kurssin suorittaneelle l&auml;hetet&auml;&auml;n todistus.</p>\n\n<p>Er&auml;s kurssin k&auml;ynyt kirjoittaa:</p>\n\n<blockquote>&ldquo;Kiitos t&auml;st&auml; ihanasta kurssista.&nbsp; Nyt olen saanut sellaista hengellist&auml; ravintoa, jota olen janonnut monta vuotta. Voi miten t&auml;m&auml; on avartanut Raamattua ja l&auml;hent&auml;nyt minut Jeesukseen! Nyt on taas uutta tietoa ja olen entist&auml; vahvempi.&nbsp; Suosittelen mielell&auml;ni toisillekin t&auml;t&auml; kurssia.&nbsp; Kiitos!&rdquo;</blockquote>\n', '0000-00-00 00:00:00', '2016-03-07 15:54:05', 1),
	(2, 'The Brand New Course', 'New and improved!', '0000-00-00 00:00:00', '2015-12-22 09:14:51', 1),
	(3, 'The "Kinda Shabby" Course', '<p>Tervetuloa Paavalin matkassa -kirjekurssille, johon kuuluu 12&nbsp;opintovihkoa. Kurssi pureutuu Paavalin henkil&ouml;historiaan, kirjoituksiin ja ajatteluun. Kurssin suorittaneelle l&auml;hetet&auml;&auml;n todistus.</p>\n\n<p>Kurssin suorittaminen tapahtuu seuraavasti:</p>\n\n<ul>\n	<li>Lue opintoaihe ja siihen liittyv&auml;t raamatunkohdat. Raamatunkohdat avautuvat klikkaamalla omaan ikkunaan.</li>\n	<li>T&auml;yt&auml; kertauslomake. - Voit lukea opintoaihetta uudelleen ja tarkistaa vastauksesi. Vastauslomakkeessa on my&ouml;s kysymys, johon voit vastata omin sanoin ja antaa henkil&ouml;kohtaisempaakin palautetta.</li>\n	<li>Opinto-ohjaajamme ovat k&auml;ytett&auml;viss&auml;, kun k&auml;yt kurssia, joten voit vapaasti kirjoittaa meille kysymyksi&auml;si tai kommenttejasi. &nbsp;</li>\n	<li>Kirjoita nimesi kuhunkin kertauslomakkeeseen. Pid&auml;mme kirjaa edistymisest&auml;si. Jos annat s&auml;hk&ouml;postiosoitteesi, saat palautetta vastauksistasi alusta pit&auml;en. Voit jatkaa seuraavaan opintoaiheeseen ennen kuin olemme ehtineet antaa palautetta.</li>\n	<li>N&auml;in jatketaan, kunnes olet k&auml;ynyt l&auml;pi kaikki kurssin 12 opintovihkoa.</li>\n	<li>Voit siis opiskella omaan tahtiisi.</li>\n	<li>Kertauslomake kunkin opintoaiheen yhteydess&auml; rohkaisee pohtimaan lukemaasi ja oppimaasi.</li>\n</ul>\n', '0000-00-00 00:00:00', '2016-02-29 13:16:00', 1),
	(4, 'Testi Kurssi', 'Ahoy!', '2015-12-22 09:23:13', '2015-12-22 09:23:13', 1),
	(5, 'asdfasdf', '<p>asdfasdfasdfasdf</p>\n', '2016-02-29 13:26:19', '2016-02-29 13:26:19', 0);
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.migrations: ~16 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
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
	('2016_02_19_113744_add_hidden_column_to_pages_table', 10);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `hidden` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.pages: ~5 rows (approximately)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `test_id`, `body`, `hidden`, `created_at`, `updated_at`) VALUES
	(1, 1, '<p><img alt="" src="http://raamattuavautuu.adventist.fi/uploaded_assets/5373-Maailman-valo-1.png?thumbnail=original&amp;1432180436" style="float:right; height:410px; margin:1em; width:278px" />Iloitsemme siit&auml;, ett&auml; voimme esitell&auml; sinulle Kristuksen henkil&ouml;kohtaisesti <strong>Maailman Valo</strong> -raamatuntutkistelukurssin kautta. Olemme ker&auml;nneet Kristuksesta, Maailman Valosta, loistavia kirkkaita s&auml;teit&auml; t&auml;m&auml;n kurssin sivuille, jotta h&auml;n tulisi sinulle entist&auml; todellisemmaksi ja l&auml;heisemm&auml;ksi. Kun luet t&auml;m&auml;n yksinkertaisen mutta vaikuttavan kertomuksen Kristuksen el&auml;m&auml;st&auml;, uskomme, ett&auml; se innoittaa sinua syvemmin kuin mik&auml;&auml;n muu el&auml;m&auml;kerta.</p>\n\n<h2>Kertomuksen l&auml;hde</h2>\n\n<p>Kertomuksemme l&auml;htein&auml; ovat nelj&auml; evankeliumia: Matteuksen, Markuksen, Luukkaan ja Johanneksen, evankeliumit, jotka ovat luotettavia ja innoitettuja kertomuksia Jeesuksen el&auml;m&auml;st&auml;. Matteus, Markus ja Luukas kertovat meille paljon siit&auml;, mit&auml; Jeesus teki. Johannes kertoo siit&auml;, kuka h&auml;n on, ja pyrkii kuvaamaan Jeesuksen taivaallista kauneutta, h&auml;nest&auml; loistanutta vanhurskautta, totuutta, taivaallista pyhyytt&auml; ja rakkautta.</p>\n\n<p>N<img alt="" src="/uploads/images/cat3.jpg" style="float:left; height:157px; margin:1em; width:210px" />&auml;m&auml; el&auml;m&auml;kerrat ovat sellaisten henkil&ouml;iden kirjoittamia, jotka eliv&auml;t Jeesuksen ollessa maan p&auml;&auml;ll&auml; ja jotka ovat p&auml;tevi&auml; kirjoittamaan h&auml;nest&auml;. Nelj&auml; Uuden testamentin kirjaa, nelj&auml; evankeliumia, ovat meid&auml;n auktoriteettinamme. Niist&auml; l&ouml;yd&auml;mme luotettavat yksityiskohdat Jeesuksesta Kristuksesta: h&auml;nen olemassaolostaan ennen maailman luomista, h&auml;nen syntym&auml;st&auml;&auml;n, el&auml;m&auml;st&auml;&auml;n, teht&auml;v&auml;st&auml;&auml;n ja opetuksestaan, kuolemastaan, yl&ouml;snousemuksestaan ja h&auml;nen lupauksestaan palata t&auml;h&auml;n maailmaan toisen kerran. Jo paljon ennen kuin p&auml;&auml;set t&auml;m&auml;n 25 opintovihon kurssin loppuun, tulet huomaamaan, ett&auml; Jeesus on enemm&auml;n kuin vain pelkk&auml; ihminen, n&auml;et h&auml;ness&auml; Maailman Valon.</p>', 0, '0000-00-00 00:00:00', '2016-02-22 22:26:08'),
	(2, 2, '<h2>Kaksi muistettavaa asiaa</h2>\r\n<p>\r\n	Valmistellessamme tätä raamattukurssia sinua varten olemme pitäneet mielessämme kaksi tärkeää asiaa: ensiksi, Kristuksen elämän tapahtumat on esitetty luonnollisessa järjestyksessään niin tarkasti kuin mahdollista. Tätä kutsutaan kronologiaksi, ja tämä on tärkeää. Lukiessasi näitä opintovihkoja tulet kuitenkin huomaamaan toisen, ehkä vielä tärkeämmän näkökohdan, joka on inspiroinut meitä. Pyrimme tuomaan esille mahdollisimman monia puolia Kristuksen elämästä. Saavuttaaksemme tämän meidän on joskus täytynyt jättää kertomuksen kronologia hetkeksi sivuun.\r\n</p>\r\n<p>\r\n	Samalla tavoin kuin auringonvalo prisman läpi heijastuessaan hajoaa sateenkaaren ihaniin väreihin samoin Kristus, vanhurskauden aurinko, tulee puoleensavetävämmäksi kun katsomme häntä mestariopettajana, suurena parantajana, syntisten ystävänä, Jumalan profeettana, ihmeitten tekijänä, ihmisen Pelastajana ja Jumalan Poikana. Tästä kuvaava esimerkki: Tavallisesta tarkkailijasta timantti näyttää lähes tavalliselta kiveltä ennen hiomista, mutta kun taitava jalokiviseppä hioo ja kiillottaa sitä, kymmenet pinnat alkavat säkenöidä elävän liekin tavoin. Samalla tavoin Kristuksen elämässä on monia puolia, jotka yhdistettyinä muodostavat täydellisen suuren Valon, joka on Kristus itse. Olemme pyrkineet yhdistämään nämä palaset sillä tavoin, että niistä muodostuisi mitä täydellisin kuva kaikkein kauneimmasta elämästä, mitä tämä maailma on koskaan tuntenut.\r\n</p>', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 10, '<p><img src="http://raamattuavautuu.adventist.fi/uploaded_assets/534136-kansi01b.jpg?thumbnail=original&amp;1432180481" style="float:right; margin:1em; width:250px" /></p>\n\n<p>Paavalilla oli n&auml;ky &ndash; unelma. Se oli suuri unelma, unelma uudesta ajasta ja uudesta maailmanj&auml;rjestyksest&auml;. Kaikki olisi uutta, ihmiskunta olisi j&auml;lleen yht&auml; ja ihmiset el&auml;isiv&auml;t tasa-arvoisina, rauhassa ja toisiaan rakastaen.</p>\n\n<p>Olympiaurheilijan kipin&auml; syd&auml;mess&auml;&auml;n Paavali l&auml;hti muuttamaan maail&shy;maa. H&auml;n kirjoitti korinttilaisille, joilla oli tapana j&auml;rjest&auml;&auml; joka toinen vuosi Isthmian kisat:</p>\n\n<blockquote>&rdquo;Tied&auml;tteh&auml;n, ett&auml; vaikka juoksukilpailussa kaikki juoksevat, vain yksi saa palkinnon. Juoskaa siis niin, ett&auml; voitatte sen!&nbsp; Jokainen kilpailija noudattaa lujaa itsekuria, juoksijat saavuttaakseen katoavan seppeleen, me saadaksemme katoamattoman. Min&auml; en siis juokse p&auml;&auml;m&auml;&auml;r&auml;tt&ouml;m&auml;sti enk&auml; nyrkkeilless&auml;ni huido ilmaan. Kohdistan iskut omaan ruumiiseeni ja pakotan sen tottelemaan, jottei itse&auml;ni lopulta hyl&auml;tt&auml;isi, minua, joka olen kutsunut muita kilpailuun.&rdquo; (1. Kor. 9:24&ndash;27.)</blockquote>\n\n<p>Paavali oli l&ouml;yt&auml;nyt n&auml;yn, jonka puolesta h&auml;n oli valmis kuolemaan. T&auml;st&auml; syyst&auml; h&auml;n eli el&auml;m&auml;ns&auml; t&auml;ydesti. H&auml;nen j&auml;lkeens&auml; maailma ei olisi koskaan en&auml;&auml; sama.</p>\n\n<p>Kahdensadan viidenkymmenen vuoden kuluttua h&auml;nen sanomansa oli vastaanotettu puolessa Rooman valtakuntaa ja se unelma, jota h&auml;n eli, on t&auml;h&auml;n p&auml;iv&auml;&auml;n menness&auml; vaikuttanut maailmaan enemm&auml;n kuin mik&auml;&auml;n muu maailmankatsomus.</p>\n\n<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>', 0, '2016-02-29 13:17:40', '2016-02-29 13:19:46'),
	(4, 10, '<p><img src="http://raamattuavautuu.adventist.fi/uploaded_assets/534136-kansi01b.jpg?thumbnail=original&amp;1432180481" style="float:right; margin:1em; width:250px" /></p>\n\n<p>Paavalilla oli n&auml;ky &ndash; unelma. Se oli suuri unelma, unelma uudesta ajasta ja uudesta maailmanj&auml;rjestyksest&auml;. Kaikki olisi uutta, ihmiskunta olisi j&auml;lleen yht&auml; ja ihmiset el&auml;isiv&auml;t tasa-arvoisina, rauhassa ja toisiaan rakastaen.</p>\n\n<p>Olympiaurheilijan kipin&auml; syd&auml;mess&auml;&auml;n Paavali l&auml;hti muuttamaan maail&shy;maa. H&auml;n kirjoitti korinttilaisille, joilla oli tapana j&auml;rjest&auml;&auml; joka toinen vuosi Isthmian kisat:</p>\n\n<blockquote>&rdquo;Tied&auml;tteh&auml;n, ett&auml; vaikka juoksukilpailussa kaikki juoksevat, vain yksi saa palkinnon. Juoskaa siis niin, ett&auml; voitatte sen!&nbsp; Jokainen kilpailija noudattaa lujaa itsekuria, juoksijat saavuttaakseen katoavan seppeleen, me saadaksemme katoamattoman. Min&auml; en siis juokse p&auml;&auml;m&auml;&auml;r&auml;tt&ouml;m&auml;sti enk&auml; nyrkkeilless&auml;ni huido ilmaan. Kohdistan iskut omaan ruumiiseeni ja pakotan sen tottelemaan, jottei itse&auml;ni lopulta hyl&auml;tt&auml;isi, minua, joka olen kutsunut muita kilpailuun.&rdquo; (1. Kor. 9:24&ndash;27.)</blockquote>\n\n<p>Paavali oli l&ouml;yt&auml;nyt n&auml;yn, jonka puolesta h&auml;n oli valmis kuolemaan. T&auml;st&auml; syyst&auml; h&auml;n eli el&auml;m&auml;ns&auml; t&auml;ydesti. H&auml;nen j&auml;lkeens&auml; maailma ei olisi koskaan en&auml;&auml; sama.</p>\n\n<p>Kahdensadan viidenkymmenen vuoden kuluttua h&auml;nen sanomansa oli vastaanotettu puolessa Rooman valtakuntaa ja se unelma, jota h&auml;n eli, on t&auml;h&auml;n p&auml;iv&auml;&auml;n menness&auml; vaikuttanut maailmaan enemm&auml;n kuin mik&auml;&auml;n muu maailmankatsomus.</p>\n\n<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>', 0, '2016-02-29 13:19:00', '2016-02-29 13:19:00'),
	(5, 10, '<p><img src="http://raamattuavautuu.adventist.fi/uploaded_assets/534136-kansi01b.jpg?thumbnail=original&amp;1432180481" style="float:right; margin:1em; width:250px" /></p>\n\n<p>Paavalilla oli n&auml;ky &ndash; unelma. Se oli suuri unelma, unelma uudesta ajasta ja uudesta maailmanj&auml;rjestyksest&auml;. Kaikki olisi uutta, ihmiskunta olisi j&auml;lleen yht&auml; ja ihmiset el&auml;isiv&auml;t tasa-arvoisina, rauhassa ja toisiaan rakastaen.</p>\n\n<p>Olympiaurheilijan kipin&auml; syd&auml;mess&auml;&auml;n Paavali l&auml;hti muuttamaan maail&shy;maa. H&auml;n kirjoitti korinttilaisille, joilla oli tapana j&auml;rjest&auml;&auml; joka toinen vuosi Isthmian kisat:</p>\n\n<blockquote>&rdquo;Tied&auml;tteh&auml;n, ett&auml; vaikka juoksukilpailussa kaikki juoksevat, vain yksi saa palkinnon. Juoskaa siis niin, ett&auml; voitatte sen!&nbsp; Jokainen kilpailija noudattaa lujaa itsekuria, juoksijat saavuttaakseen katoavan seppeleen, me saadaksemme katoamattoman. Min&auml; en siis juokse p&auml;&auml;m&auml;&auml;r&auml;tt&ouml;m&auml;sti enk&auml; nyrkkeilless&auml;ni huido ilmaan. Kohdistan iskut omaan ruumiiseeni ja pakotan sen tottelemaan, jottei itse&auml;ni lopulta hyl&auml;tt&auml;isi, minua, joka olen kutsunut muita kilpailuun.&rdquo; (1. Kor. 9:24&ndash;27.)</blockquote>\n\n<p>Paavali oli l&ouml;yt&auml;nyt n&auml;yn, jonka puolesta h&auml;n oli valmis kuolemaan. T&auml;st&auml; syyst&auml; h&auml;n eli el&auml;m&auml;ns&auml; t&auml;ydesti. H&auml;nen j&auml;lkeens&auml; maailma ei olisi koskaan en&auml;&auml; sama.</p>\n\n<p>Kahdensadan viidenkymmenen vuoden kuluttua h&auml;nen sanomansa oli vastaanotettu puolessa Rooman valtakuntaa ja se unelma, jota h&auml;n eli, on t&auml;h&auml;n p&auml;iv&auml;&auml;n menness&auml; vaikuttanut maailmaan enemm&auml;n kuin mik&auml;&auml;n muu maailmankatsomus.</p>\n\n<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>', 0, '2016-02-29 13:19:14', '2016-02-29 13:19:14');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.password_resets: ~0 rows (approximately)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.questions
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `subtitle` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.questions: ~7 rows (approximately)
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` (`id`, `test_id`, `type`, `title`, `subtitle`, `order`) VALUES
	(1, 1, 'MULTI', 'Hello World!', 'Do you feel sufficiently greeted?', 1),
	(2, 1, 'CHOICE', 'Choose the right amount of potatoes.', 'It\'s a very specific science.', 2),
	(3, 1, 'TEXT', 'Be careful of what you write here.', 'I suggest you type "bananas" or something weird may happen.', 3),
	(4, 1, 'MULTITEXT', 'At this moment you realised it\'s pretty serious.', 'Now you done goofed.', 4),
	(5, 1, 'TEXTAREA', 'Freedom!', 'At least here you don\'t have to be specific.\r\n\r\n<img src="https://aitolahti.adventist.fi/uploaded_assets/2396408-aitolahti.jpg?thumbnail=original&1432180496" alt="" style="float:left;width:150px"/> <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nisi possimus et eos modi id alias at quia ex deleniti quaerat laudantium eaque laboriosam pariatur, magnam a veritatis. Atque numquam distinctio cumque, dolorum non quis a vel rerum aspernatur provident amet perferendis repellat, dolores sed porro ullam ex, molestiae. Pariatur, esse.</p>', 5),
	(6, 2, 'CHOICE', 'Ha! I lied to you! It\'s not really blank after all!', 'Does it make you feel betrayed?', 0),
	(13, 10, 'TEXTAREA', 'No mercy!!', 'The hardest question ever!', 1);
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.tests
CREATE TABLE IF NOT EXISTS `tests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.tests: ~5 rows (approximately)
/*!40000 ALTER TABLE `tests` DISABLE KEYS */;
INSERT INTO `tests` (`id`, `course_id`, `title`, `description`, `order`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Basic Test', 'The first meal on the default course!', 1, '0000-00-00 00:00:00', '2015-12-22 08:00:00'),
	(2, 1, 'Blank Test', 'Just like you wanted it.', 2, '0000-00-00 00:00:00', '2015-12-22 08:00:00'),
	(10, 3, 'Shabby Course Test', '<p>Mik&auml; h&auml;nt&auml; innosti ja mik&auml; oli h&auml;nen sanomansa? Miten sellainen ihminen eli, joka otti teht&auml;v&auml;kseen yhdist&auml;&auml; maailman?</p>\n\n<p>T&auml;m&auml; on kertomus Sauluksesta, tarsolaisesta teltantekij&auml;st&auml;, josta tuli Paavali, muutoksen tekij&auml;.</p>\n', 1, '2015-12-22 10:08:58', '2016-02-29 13:19:00'),
	(11, 1, 'Really Blank Test', 'Hehe', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(12, 1, 'ASDASDASD', 'SDFSDGSDFGFDFDGFG', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `tests` ENABLE KEYS */;


-- Dumping structure for table mlraamattu.users
CREATE TABLE IF NOT EXISTS `users` (
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `password`, `access_level`, `remember_token`, `created_at`, `updated_at`) VALUES
	(2, 'Reima Raju', 'test', '$2y$10$LFlAQP0lQes918IsJ5jyBOeyXkj6u1iHAQ4aV4irBnj7aO3NnEoRC', 1, 'ifWMy2tL80ywKP2t4nigxvRFCts7OFtGF3voTog0KvOx8ehcuQy0uBykRr2K', '0000-00-00 00:00:00', '2016-02-08 15:34:17'),
	(3, 'Erkki Esimerkki', 'erkin@esimerk.ki', '$2y$10$Q0AJvNitiDjelOpna2nHsOea9NJCZFfjCAEy2dkRdJEHq1YH.GtGy', 0, '3Zz2uRa8Bk6x3GOO25KFy6gEdjwmOeUjjyqBzPfBqQewCh4CG39dLAfFD7CZ', '2015-12-01 13:20:27', '2015-12-01 13:21:38'),
	(4, 'Milla Mallikas', 'millan@posti.fi', '$2y$10$tyiiZn5CUCbCeGlqJjMqquDpQ0xTiFdjDhfysZjTTDpvCBz2RVdJW', 1, 'SMcokdvIBMkFNZlR29gnhRNROjkvK7GVWxhYep8qxIbFMR0htXP0FKezEjly', '2015-12-01 13:52:02', '2016-02-15 17:25:35');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
