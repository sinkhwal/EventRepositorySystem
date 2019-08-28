-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 28, 2019 at 09:33 PM
-- Server version: 5.7.24
-- PHP Version: 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eventrecorddb`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `organization` text,
  `event_title` text,
  `event_description` text,
  `event_location` text,
  `event_presenter` text,
  `event_date` text,
  `event_type` text,
  `created_by` text,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `organization`, `event_title`, `event_description`, `event_location`, `event_presenter`, `event_date`, `event_type`, `created_by`, `created_date`) VALUES
(12, 'Department 1', 'Event Title', 'Description', '2000 West Barnett Ave', 'Dr. Modi', '06/24/2020', 'Show', 'superadmin', '2019-08-28 20:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `password` text,
  `role` text NOT NULL,
  `last_active` datetime DEFAULT NULL,
  `name` text,
  `address` text,
  `phone` text,
  `email` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `last_active`, `name`, `address`, `phone`, `email`) VALUES
(1, 'superadmin', 'superadmin', 'Superadmin', NULL, 'Superadmin', 'Dallas Tx', '3184973957', 'super@gmail.com'),
(2, 'user3', 'user3', 'Admin', NULL, 'User 2', 'West Verginia 1', '3184973958', 'user@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
