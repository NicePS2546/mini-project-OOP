-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2024 at 12:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_654230015`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_reservation`
--

CREATE TABLE `tb_reservation` (
  `id` int(11) UNSIGNED NOT NULL,
  `reservedBy` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dayAmount` int(20) NOT NULL,
  `peopleAmount` int(11) NOT NULL,
  `roomType` varchar(70) NOT NULL,
  `member` tinyint(1) DEFAULT 0,
  `price` int(20) NOT NULL,
  `taxFee` int(11) NOT NULL,
  `total` int(20) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_reservation`
--

INSERT INTO `tb_reservation` (`id`, `reservedBy`, `email`, `dayAmount`, `peopleAmount`, `roomType`, `member`, `price`, `taxFee`, `total`, `reg_date`) VALUES
(2, 'พสิษฐ์ อิอิ', 'maoasdaezxooo@gmail.com', 2, 2, 'deluxe', 0, 1750, 245, 3745, '2024-08-28 14:12:21'),
(4, 'พสิษฐ์ บุญเกิด 1', 'asdasdasd@g.m', 5, 4, 'normal', 0, 850, 298, 4548, '2024-08-28 12:46:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_reservation`
--
ALTER TABLE `tb_reservation`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_reservation`
--
ALTER TABLE `tb_reservation`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
