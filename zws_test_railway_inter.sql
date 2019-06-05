-- phpMyAdmin SQL Dump
-- version 4.0.9
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 05. Jun 2019 um 15:46
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
-- Tabellenstruktur für Tabelle `zws_test_railway_inter`
--

CREATE TABLE IF NOT EXISTS `zws_test_railway_inter` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `railway_sn` varchar(50) NOT NULL DEFAULT '',
  `inter_log` text NOT NULL,
  `inter_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inter_status` tinyint(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Daten für Tabelle `zws_test_railway_inter`
--

INSERT INTO `zws_test_railway_inter` (`id`, `railway_sn`, `inter_log`, `inter_time`, `inter_status`) VALUES
(1, 'V0320221078', '', '0000-00-00 00:00:00', 0),
(2, 'V0320221149', '', '2019-06-05 09:04:21', 0),
(3, 'V0320222362', '', '2019-06-05 09:05:42', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
