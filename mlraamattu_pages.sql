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

-- Dumping structure for table mlraamattu.pages
CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `test_id` int(11) NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Dumping data for table mlraamattu.pages: ~0 rows (approximately)
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` (`id`, `test_id`, `body`, `created_at`, `updated_at`) VALUES
	(1, 1, '<img src="http://raamattuavautuu.adventist.fi/uploaded_assets/5373-Maailman-valo-1.png?thumbnail=original&1432180436" alt="" style="float:right;max-width:35%;margin:1em">\r\n<p>\r\n	Iloitsemme siitä, että voimme esitellä sinulle Kristuksen henkilökohtaisesti <strong>Maailman Valo</strong> -raamatuntutkistelukurssin kautta. Olemme keränneet Kristuksesta, Maailman Valosta, loistavia kirkkaita säteitä tämän kurssin sivuille, jotta hän tulisi sinulle entistä todellisemmaksi ja läheisemmäksi. Kun luet tämän yksinkertaisen mutta vaikuttavan kertomuksen Kristuksen elämästä, uskomme, että se innoittaa sinua syvemmin kuin mikään muu elämäkerta.\r\n</p>\r\n<h2>Kertomuksen lähde</h2>\r\n<p>\r\n	Kertomuksemme lähteinä ovat neljä evankeliumia: Matteuksen, Markuksen, Luukkaan ja Johanneksen, evankeliumit, jotka ovat luotettavia ja innoitettuja kertomuksia Jeesuksen elämästä. Matteus, Markus ja Luukas kertovat meille paljon siitä, mitä Jeesus teki. Johannes kertoo siitä, kuka hän on, ja pyrkii kuvaamaan Jeesuksen taivaallista kauneutta, hänestä loistanutta vanhurskautta, totuutta, taivaallista pyhyyttä ja rakkautta.\r\n</p>\r\n<p>\r\n	Nämä elämäkerrat ovat sellaisten henkilöiden kirjoittamia, jotka elivät Jeesuksen ollessa maan päällä ja jotka ovat päteviä kirjoittamaan hänestä. Neljä Uuden testamentin kirjaa, neljä evankeliumia, ovat meidän auktoriteettinamme. Niistä löydämme luotettavat yksityiskohdat Jeesuksesta Kristuksesta: hänen olemassaolostaan ennen maailman luomista, hänen syntymästään, elämästään, tehtävästään ja opetuksestaan, kuolemastaan, ylösnousemuksestaan ja hänen lupauksestaan palata tähän maailmaan toisen kerran. Jo paljon ennen kuin pääset tämän 25 opintovihon kurssin loppuun, tulet huomaamaan, että Jeesus on enemmän kuin vain pelkkä ihminen, näet hänessä Maailman Valon.\r\n</p>', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 2, '<h2>Kaksi muistettavaa asiaa</h2>\r\n<p>\r\n	Valmistellessamme tätä raamattukurssia sinua varten olemme pitäneet mielessämme kaksi tärkeää asiaa: ensiksi, Kristuksen elämän tapahtumat on esitetty luonnollisessa järjestyksessään niin tarkasti kuin mahdollista. Tätä kutsutaan kronologiaksi, ja tämä on tärkeää. Lukiessasi näitä opintovihkoja tulet kuitenkin huomaamaan toisen, ehkä vielä tärkeämmän näkökohdan, joka on inspiroinut meitä. Pyrimme tuomaan esille mahdollisimman monia puolia Kristuksen elämästä. Saavuttaaksemme tämän meidän on joskus täytynyt jättää kertomuksen kronologia hetkeksi sivuun.\r\n</p>\r\n<p>\r\n	Samalla tavoin kuin auringonvalo prisman läpi heijastuessaan hajoaa sateenkaaren ihaniin väreihin samoin Kristus, vanhurskauden aurinko, tulee puoleensavetävämmäksi kun katsomme häntä mestariopettajana, suurena parantajana, syntisten ystävänä, Jumalan profeettana, ihmeitten tekijänä, ihmisen Pelastajana ja Jumalan Poikana. Tästä kuvaava esimerkki: Tavallisesta tarkkailijasta timantti näyttää lähes tavalliselta kiveltä ennen hiomista, mutta kun taitava jalokiviseppä hioo ja kiillottaa sitä, kymmenet pinnat alkavat säkenöidä elävän liekin tavoin. Samalla tavoin Kristuksen elämässä on monia puolia, jotka yhdistettyinä muodostavat täydellisen suuren Valon, joka on Kristus itse. Olemme pyrkineet yhdistämään nämä palaset sillä tavoin, että niistä muodostuisi mitä täydellisin kuva kaikkein kauneimmasta elämästä, mitä tämä maailma on koskaan tuntenut.\r\n</p>', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
