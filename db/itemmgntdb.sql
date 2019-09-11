-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Sep 11, 2019 at 10:14 PM
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
-- Database: `itemmgntdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `location` text,
  `coordinates` text,
  `make` text,
  `model` text,
  `created_by` text,
  `created_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `description`, `location`, `coordinates`, `make`, `model`, `created_by`, `created_date`) VALUES
(16, 'Description', 'location', 'cor', 'm', 'm', 'super@gmail.com', '2019-09-11 21:17:47'),
(14, 'item', 'location fine', 'dfkajo', 'gfsd', 'gT', 'user3@gmail.com', '2019-09-11 21:10:16'),
(15, 'Description', 'location', 'cor', 'make', 'mode', 'user3@gmail.com', '2019-09-11 21:17:10');

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
  `created_date` datetime DEFAULT NULL,
  `forgot_password_request_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `last_active`, `name`, `address`, `phone`, `email`, `created_date`, `forgot_password_request_date`) VALUES
(1, 'superadmin', '2c7b0576873ffcbb4ca61c5a225b94e7', 'Superadmin', NULL, 'Superadmin', 'Dallas Tx', '3184973957', 'super@gmail.com', NULL, NULL),
(20, '', 'b035f08c461a72935007b695d56a0cb6', 'Admin', NULL, 'User 3', '2000 West Barnett Spring Av', '31582245522', 'user3@gmail.com', NULL, NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
