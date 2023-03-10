-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 08, 2019 at 11:23 AM
-- Server version: 5.7.24-0ubuntu0.18.04.1
-- PHP Version: 7.2.13-1+ubuntu18.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ydsf_bantuan`
--

-- --------------------------------------------------------

--
-- Table structure for table `config_report`
--

CREATE TABLE `config_report` (
  `id` int(11) NOT NULL,
  `periode` varchar(20) NOT NULL,
  `artikel` text NOT NULL,
  `sambutan` text NOT NULL,
  `image_page1` varchar(255) NOT NULL,
  `image_page2` varchar(255) NOT NULL,
  `small_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `config_report`
--

INSERT INTO `config_report` (`id`, `periode`, `artikel`, `sambutan`, `image_page1`, `image_page2`, `small_image`) VALUES
(1, '0000', 'artikel', 'sambutan', 'image_page1', 'image_page2', 'small_image');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `config_report`
--
ALTER TABLE `config_report`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `config_report`
--
ALTER TABLE `config_report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
