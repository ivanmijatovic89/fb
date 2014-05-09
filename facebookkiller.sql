-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 16, 2014 at 02:44 PM
-- Server version: 5.5.31
-- PHP Version: 5.3.27

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `facebookkiller`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(24) NOT NULL,
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'ca50c3168098da0c6d98c5791b2a0284');

-- --------------------------------------------------------

--
-- Table structure for table `blocked`
--

CREATE TABLE IF NOT EXISTS `blocked` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `by` int(11) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `blocked`
--


-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `read` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `from`, `to`, `message`, `read`, `time`) VALUES
(1, 1, 2, 'yooo', 1, '2014-03-23 21:20:02'),
(2, 2, 1, 'Wats good', 1, '2014-03-23 21:20:42'),
(3, 1, 2, 'shit shit', 1, '2014-03-23 21:20:48'),
(4, 2, 1, 'Good money', 1, '2014-03-23 21:22:24'),
(5, 1, 2, 'very good', 1, '2014-03-23 21:23:58'),
(6, 2, 1, 'Now go head n book ure tattoo', 1, '2014-03-23 21:24:47');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `mid` int(11) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `uid`, `mid`, `message`, `time`) VALUES
(1, 1, 2, 'Thanks! :) I hope this will help my push to find employment using the LAMP stack... ', '2014-03-24 16:17:32');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post` int(11) NOT NULL,
  `by` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post`, `by`, `time`) VALUES
(1, 1, 3, '2014-03-24 16:16:36'),
(2, 2, 1, '2014-03-24 16:17:42');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `uid` int(32) NOT NULL,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `tag` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(16) CHARACTER SET latin1 NOT NULL,
  `value` varchar(512) COLLATE utf8_unicode_ci NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `public` int(11) NOT NULL,
  `likes` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `uid`, `message`, `tag`, `type`, `value`, `time`, `public`, `likes`) VALUES
(1, 1, 'Hi and welcome to what I am calling Codename: Facebook Killer.... I made this just to show off a bit of my skills. I hope you enjoy it, if you have any issues with it be sure to let me know...', '', '', '', '2014-03-23 20:54:22', 1, 1),
(2, 3, 'Wow this looks a lot like facebook...not in a bad way.', '', '', '', '2014-03-24 16:16:16', 1, 1),
(3, 1, 'totaly', '', 'map', 'san fran', '2014-04-06 00:08:58', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from` int(11) NOT NULL,
  `to` int(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `child` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `read` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `from`, `to`, `parent`, `child`, `type`, `read`, `time`) VALUES
(1, 1, 2, 0, 0, 4, 0, '2014-03-23 21:19:43'),
(2, 2, 1, 0, 0, 4, 1, '2014-03-23 21:21:55'),
(3, 3, 1, 1, 0, 2, 1, '2014-03-24 16:16:36'),
(4, 3, 1, 0, 0, 4, 1, '2014-03-24 16:16:40'),
(5, 1, 3, 0, 0, 4, 0, '2014-03-24 16:16:52'),
(6, 1, 3, 2, 1, 1, 0, '2014-03-24 16:17:32'),
(7, 1, 3, 2, 0, 2, 0, '2014-03-24 16:17:42'),
(8, 5, 1, 0, 0, 4, 0, '2014-03-25 00:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `relations`
--

CREATE TABLE IF NOT EXISTS `relations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leader` int(11) NOT NULL,
  `subscriber` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `relations`
--

INSERT INTO `relations` (`id`, `leader`, `subscriber`, `time`) VALUES
(1, 2, 1, '2014-03-23 21:19:43'),
(2, 1, 2, '2014-03-23 21:21:55'),
(3, 1, 3, '2014-03-24 16:16:40'),
(4, 3, 1, '2014-03-24 16:16:52'),
(5, 1, 5, '2014-03-25 00:18:00');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE IF NOT EXISTS `reports` (
  `id` int(12) NOT NULL AUTO_INCREMENT,
  `post` varchar(11) NOT NULL,
  `parent` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `by` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `reports`
--


-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `title` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `theme` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `perpage` int(11) NOT NULL,
  `censor` varchar(2048) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `captcha` int(11) NOT NULL,
  `intervalm` int(11) NOT NULL,
  `intervaln` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `message` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `format` varchar(256) NOT NULL,
  `mail` int(11) NOT NULL,
  `sizemsg` int(11) NOT NULL,
  `formatmsg` varchar(256) NOT NULL,
  `cperpage` int(11) NOT NULL,
  `mprivacy` int(11) NOT NULL,
  `ilimit` int(11) NOT NULL,
  `climit` int(11) NOT NULL,
  `qperpage` tinyint(4) NOT NULL,
  `rperpage` int(11) NOT NULL,
  `uperpage` int(11) NOT NULL,
  `sperpage` int(11) NOT NULL,
  `nperpage` tinyint(4) NOT NULL,
  `nperwidget` tinyint(4) NOT NULL,
  `lperpost` int(11) NOT NULL,
  `conline` int(4) NOT NULL,
  `ronline` tinyint(4) NOT NULL,
  `mperpage` tinyint(4) NOT NULL,
  `verified` int(11) NOT NULL,
  `notificationl` tinyint(4) NOT NULL,
  `notificationc` tinyint(4) NOT NULL,
  `notifications` tinyint(4) NOT NULL,
  `notificationd` tinyint(4) NOT NULL,
  `notificationf` tinyint(4) NOT NULL,
  `chatr` int(11) NOT NULL,
  `email_comment` tinyint(4) NOT NULL,
  `email_like` tinyint(4) NOT NULL,
  `email_new_friend` tinyint(4) NOT NULL,
  `smiles` tinyint(4) NOT NULL,
  `ad1` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad2` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad3` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad4` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad5` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad6` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ad7` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`title`, `theme`, `perpage`, `censor`, `captcha`, `intervalm`, `intervaln`, `time`, `message`, `size`, `format`, `mail`, `sizemsg`, `formatmsg`, `cperpage`, `mprivacy`, `ilimit`, `climit`, `qperpage`, `rperpage`, `uperpage`, `sperpage`, `nperpage`, `nperwidget`, `lperpost`, `conline`, `ronline`, `mperpage`, `verified`, `notificationl`, `notificationc`, `notifications`, `notificationd`, `notificationf`, `chatr`, `email_comment`, `email_like`, `email_new_friend`, `smiles`, `ad1`, `ad2`, `ad3`, `ad4`, `ad5`, `ad6`, `ad7`) VALUES
('Yum Village', 'dolphin', 10, '', 1, 10000, 10000, 0, 500, 10485760, 'png,jpg,gif', 1, 10485760, 'png,jpg,gif', 3, 1, 9, 500, 10, 20, 20, 10, 100, 3, 5, 60, 10, 10, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `idu` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `password` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `first_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(32) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(128) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `website` varchar(128) NOT NULL,
  `bio` varchar(160) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `facebook` varchar(256) NOT NULL,
  `twitter` varchar(128) NOT NULL,
  `gplus` varchar(256) NOT NULL,
  `image` varchar(128) NOT NULL,
  `private` int(11) NOT NULL,
  `salted` varchar(256) NOT NULL,
  `background` varchar(256) NOT NULL,
  `cover` varchar(128) NOT NULL,
  `verified` int(11) NOT NULL,
  `privacy` int(11) NOT NULL DEFAULT '1',
  `gender` tinyint(4) NOT NULL,
  `online` int(11) NOT NULL,
  `offline` tinyint(4) NOT NULL,
  `notificationl` tinyint(4) NOT NULL,
  `notificationc` tinyint(4) NOT NULL,
  `notifications` tinyint(4) NOT NULL,
  `notificationd` tinyint(4) NOT NULL,
  `notificationf` tinyint(4) NOT NULL,
  `email_comment` tinyint(4) NOT NULL,
  `email_like` tinyint(4) NOT NULL,
  `email_new_friend` tinyint(4) NOT NULL,
  `born` date NOT NULL,
  UNIQUE KEY `id` (`idu`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`idu`, `username`, `password`, `email`, `first_name`, `last_name`, `location`, `website`, `bio`, `date`, `facebook`, `twitter`, `gplus`, `image`, `private`, `salted`, `background`, `cover`, `verified`, `privacy`, `gender`, `online`, `offline`, `notificationl`, `notificationc`, `notifications`, `notificationd`, `notificationf`, `email_comment`, `email_like`, `email_new_friend`, `born`) VALUES
(1, 'xavierjohnson', '39af2b835f8f2192493ecc72b5032b52', 'infinitedevelopment@me.com', 'Xavier', 'Johnson', 'Detroit', '', 'Lorem ipsum ', '2014-03-23', '', '', '', '2064733766_126117240_753817428.jpg', 0, '', '', '949225213_927694056_1279756954.jpg', 0, 1, 1, 1396884489, 0, 1, 1, 1, 1, 0, 1, 1, 1, '1991-08-28'),
(2, 'dennisthebusiness', 'b3f36d11524b7ec2adcf26c561f9578b', 'DennisTheBusiness@gmail.com', '', '', '', '', '', '2014-03-23', '', '', '', 'default.png', 0, '', '', 'default.png', 0, 1, 0, 1395611008, 0, 1, 1, 1, 1, 0, 1, 1, 1, '2014-01-01'),
(3, 'jwarzech', '8e14991341810b8f3f7ceb750f0ef2a0', 'jordan@backstit.ch', '', '', '', '', '', '2014-03-24', '', '', '', 'default.png', 0, '', '', 'default.png', 0, 1, 0, 1395677820, 0, 1, 1, 1, 1, 0, 1, 1, 1, '0000-00-00'),
(5, 'granit', 'f312ec1d9547e303731203a54c088b7a', 'granit.ibrahimi@gmail.com', '', '', '', '', '', '2014-03-25', '', '', '', 'default.png', 0, '', '', 'default.png', 0, 1, 0, 1395706772, 0, 1, 1, 1, 1, 0, 1, 1, 1, '0000-00-00'),
(6, 'arlind', '50a10d890d536e0d5a622e1a9720aa25', 'asd@asd.com', '', '', '', '', '', '2014-03-25', '', '', '', 'default.png', 0, '', '', 'default.png', 0, 1, 0, 1395734496, 0, 1, 1, 1, 1, 0, 1, 1, 1, '0000-00-00');
