-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: May 07, 2019 at 01:49 AM
-- Server version: 5.7.25
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `zhongw_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `zws_test_logis_cn`
--

CREATE TABLE `zws_test_logis_cn` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cn_packet_id` varchar(50) NOT NULL DEFAULT '',
  `goods_id` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `cn_log` text NOT NULL,
  `cn_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cn_status` tinyint(2) NOT NULL DEFAULT '0',
  `cn_company` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  INDEX(`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- Dumping data for table `zws_test_logis_cn`
--

INSERT INTO `zws_test_logis_cn` (`id`, `cn_packet_id`, `goods_id`, `cn_log`, `cn_time`, `cn_status`, `cn_company`) VALUES
(17, '123', 64001, '{\n    \"message\":\"ok\",\n    \"state\":\"0\",\n    \"status\":\"200\",\n    \"condition\":\"F00\",\n    \"ischeck\":\"0\",\n    \"com\":\"yuantong\",\n    \"nu\":\"V030344422\",\n    \"data\":[\n    {\n      \"context\":\"上海分拨中心/装件入车扫描 \",\n      \"time\":\"2012-08-28 16:33:12\",\n      \"ftime\":\"2012-08-28 16:33:12\"\n    },\n    {\n      \"context\":\"上海分拨中心/下车扫描 \",\n      \"time\":\"2012-08-27 23:22:42\",\n      \"ftime\":\"2012-08-27 23:22:42\"\n    }]\n}', '2019-05-06 22:27:27', 0, 'yuantong'),
(18, '124', 40147, '{\n    \"message\":\"ok\",\n    \"state\":\"0\",\n    \"status\":\"200\",\n    \"condition\":\"F00\",\n    \"ischeck\":\"0\",\n    \"com\":\"yuantong\",\n    \"nu\":\"V030344421\",\n    \"data\":[\n    {\n      \"context\":\"北京分拨中心/装件入车扫描 \",\n      \"time\":\"2012-01-28 16:33:19\",\n      \"ftime\":\"2012-01-28 16:33:19\"\n    },\n    {\n      \"context\":\"北京分拨中心/下车扫描 \",\n      \"time\":\"2012-01-27 23:22:42\",\n      \"ftime\":\"2012-01-27 23:22:42\"\n    }]\n}', '2019-05-06 20:20:30', 0, 'yuantong'),
(19, '223', 65265, '{\n    \"message\":\"ok\",\n    \"state\":\"0\",\n    \"status\":\"200\",\n    \"condition\":\"F00\",\n    \"ischeck\":\"0\",\n    \"com\":\"yuantong\",\n    \"nu\":\"V030344421\",\n    \"data\":[\n    {\n      \"context\":\"北京分拨中心/装件入车扫描 \",\n      \"time\":\"2012-01-28 16:33:19\",\n      \"ftime\":\"2012-01-28 16:33:19\"\n    },\n    {\n      \"context\":\"北京分拨中心/下车扫描 \",\n      \"time\":\"2012-01-27 23:22:42\",\n      \"ftime\":\"2012-01-27 23:22:42\"\n    }]\n}', '2019-05-06 21:05:04', 0, 'yuantong'),
(20, '224', 65265, '{\n    \"message\":\"ok\",\n    \"state\":\"0\",\n    \"status\":\"200\",\n    \"condition\":\"F00\",\n    \"ischeck\":\"0\",\n    \"com\":\"yuantong\",\n    \"nu\":\"V030344421\",\n    \"data\":[\n    {\n      \"context\":\"北京分拨中心/装件入车扫描 \",\n      \"time\":\"2012-01-28 16:33:19\",\n      \"ftime\":\"2012-01-28 16:33:19\"\n    },\n    {\n      \"context\":\"北京分拨中心/下车扫描 \",\n      \"time\":\"2012-01-27 23:22:42\",\n      \"ftime\":\"2012-01-27 23:22:42\"\n    }]\n}', '2019-05-06 21:05:04', 0, 'yuantong');

--
-- Indexes for dumped tables
--



--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `zws_test_logis_cn`
--
