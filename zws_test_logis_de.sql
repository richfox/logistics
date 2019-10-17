-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Jun 2019 um 15:44
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
-- Tabellenstruktur für Tabelle `zws_test_logis_de`
--

CREATE TABLE IF NOT EXISTS `zws_test_logis_de` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `de_packet_sn` varchar(50) NOT NULL DEFAULT '',
  `railway_id` mediumint(8) unsigned NOT NULL,
  `de_log` text NOT NULL,
  `de_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `de_status` tinyint(2) NOT NULL DEFAULT '-1',
  `de_company` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `railway_id` (`railway_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

--
-- Daten für Tabelle `zws_test_logis_de`
--

INSERT INTO `zws_test_logis_de` (`id`, `de_packet_sn`, `railway_id`, `de_log`, `de_time`, `de_status`, `de_company`) VALUES
(1, '1Z30YE216852356434', 1, '', '2019-06-05 09:27:43', -1, 'ups'),
(2, '1Z30YE216852937217', 1, '', '2019-06-05 09:32:16', -1, 'ups'),
(3, '1Z30YE216853460444', 1, '', '2019-06-05 09:32:16', -1, 'ups'),
(4, '1Z30YE216854334025', 1, '', '2019-06-05 09:32:16', -1, 'ups'),
(5, '1Z30YE216852397873', 2, '', '2019-06-05 09:32:16', -1, 'ups'),
(6, '1Z30YE216854385060', 2, '', '2019-06-05 09:32:16', -1, 'ups'),
(7, '1Z30YE216852376574', 3, '', '2019-06-05 09:32:16', -1, 'ups'),
(8, '1Z30YE216853408608', 3, '', '2019-06-05 09:32:16', -1, 'ups'),
(9, '1Z30YE216852558994', 3, '', '2019-06-05 09:32:16', -1, 'ups'),
(10, '1Z30YE216852486982', 3, '', '2019-06-05 09:32:16', -1, 'ups'),
(11, '1Z30YE216852011814', 3, '', '2019-06-05 09:32:16', -1, 'ups');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
