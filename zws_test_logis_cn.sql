-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Jun 2019 um 15:40
-- Server Version: 5.6.14
-- PHP-Version: 5.5.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Datenbank: `zhongw_test`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `zws_test_logis_cn`
--

CREATE TABLE IF NOT EXISTS `zws_test_logis_cn` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cn_packet_sn` varchar(50) NOT NULL DEFAULT '',
  `railway_id` mediumint(8) unsigned NOT NULL,
  `cn_log` text NOT NULL,
  `cn_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cn_status` tinyint(2) NOT NULL DEFAULT '0',
  `cn_company` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `railway_id` (`railway_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=41 ;

--
-- Daten für Tabelle `zws_test_logis_cn`
--

INSERT INTO `zws_test_logis_cn` (`id`, `cn_packet_sn`, `railway_id`, `cn_log`, `cn_time`, `cn_status`, `cn_company`) VALUES
(1, '75145301313545', 1, '', '2019-06-05 13:39:35', 0, ''),
(2, '900087884718', 1, '', '2019-06-05 13:39:35', 0, ''),
(3, '94661945900-1-1-306', 1, '', '2019-06-05 13:39:35', 0, ''),
(4, '73112298909142', 1, '', '2019-06-05 13:39:35', 0, ''),
(5, '3706530057761', 1, '', '2019-06-05 13:39:35', 0, ''),
(6, '75144112315391', 1, '', '2019-06-05 13:39:35', 0, ''),
(7, '37965130713', 1, '', '2019-06-05 13:39:35', 0, ''),
(8, 'VA52834633714-1-1', 1, '', '2019-06-05 13:39:35', 0, ''),
(9, '805398573050226555', 1, '', '2019-06-05 13:39:35', 0, ''),
(10, '73105962553976', 1, '', '2019-06-05 13:39:35', 0, ''),
(11, '7791535488', 1, '', '2019-06-05 13:39:35', 0, ''),
(12, '37982936861', 1, '', '2019-06-05 13:39:35', 0, ''),
(13, '37956411865', 1, '', '2019-06-05 13:39:35', 0, ''),
(14, '37821180198', 1, '', '2019-06-05 13:39:35', 0, ''),
(15, '3946461529749', 1, '', '2019-06-05 13:39:35', 0, ''),
(16, 'JDX000019048165', 2, '', '2019-06-05 13:39:35', 0, ''),
(17, '37974142199', 2, '', '2019-06-05 13:39:35', 0, ''),
(18, '190511043127583109', 2, '', '2019-06-05 13:39:35', 0, ''),
(19, '37982936861', 2, '', '2019-06-05 13:39:35', 0, ''),
(20, '73112732094717', 2, '', '2019-06-05 13:39:35', 0, ''),
(21, '805761224016519222', 2, '', '2019-06-05 13:39:35', 0, ''),
(22, '805733153637732561', 2, '', '2019-06-05 13:39:35', 0, ''),
(23, '75144363950334', 2, '', '2019-06-05 13:39:35', 0, ''),
(24, '37821180198', 3, '', '2019-06-05 13:39:35', 0, ''),
(25, '73112483273239', 3, '', '2019-06-05 13:39:35', 0, ''),
(26, '75149569879381', 3, '', '2019-06-05 13:39:35', 0, ''),
(27, '805891326865468717', 3, '', '2019-06-05 13:39:35', 0, ''),
(28, '75148434764560', 3, '', '2019-06-05 13:39:35', 0, ''),
(29, '75149032170606', 3, '', '2019-06-05 13:39:35', 0, ''),
(30, '75148325818416', 3, '', '2019-06-05 13:39:35', 0, ''),
(31, 'JDVC00135865022-1-1', 3, '', '2019-06-05 13:39:35', 0, ''),
(32, '73113290098508', 3, '', '2019-06-05 13:39:35', 0, ''),
(33, '75148736127828', 3, '', '2019-06-05 13:39:35', 0, ''),
(34, '38022716388', 3, '', '2019-06-05 13:39:35', 0, ''),
(35, '805876350175711242', 3, '', '2019-06-05 13:39:35', 0, ''),
(36, '51657730002113', 3, '', '2019-06-05 13:39:35', 0, ''),
(37, 'YT2000072951625', 3, '', '2019-06-05 13:39:35', 0, ''),
(38, '73112982357174', 3, '', '2019-06-05 13:39:35', 0, ''),
(39, '38040357340', 3, '', '2019-06-05 13:39:35', 0, ''),
(40, '73113195337282', 3, '', '2019-06-05 13:39:35', 0, '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
