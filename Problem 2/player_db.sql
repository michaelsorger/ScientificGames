-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2017 at 11:12 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `player_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `player_table`
--

CREATE TABLE `player_table` (
  `id` int(10) UNSIGNED NOT NULL,
  `player_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(256) NOT NULL,
  `credits` bigint(20) NOT NULL DEFAULT '0',
  `lifetime_spins` bigint(20) NOT NULL DEFAULT '0',
  `salt_value` varchar(256) NOT NULL,
  `won_total` bigint(20) NOT NULL DEFAULT '0',
  `bet_total` bigint(20) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Player table';

--
-- Dumping data for table `player_table`
--

INSERT INTO `player_table` (`id`, `player_id`, `name`, `credits`, `lifetime_spins`, `salt_value`, `won_total`, `bet_total`) VALUES
(1, 300001, 'Mike', 1081724, 9, 'qwerty', 105797, 24073),
(3, 300002, 'Joe', 182704, 127, 'abcdef', 237904, 420200);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `player_table`
--
ALTER TABLE `player_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `player_table`
--
ALTER TABLE `player_table`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
