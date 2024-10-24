-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 24, 2024 at 02:11 PM
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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `title`, `message`, `user_id`, `name`, `reg_date`) VALUES
(1, '1', '123', 7, 'Pasitsa Bungoed', '2024-10-03 04:57:52');

-- --------------------------------------------------------

--
-- Table structure for table `tb_reservation`
--

CREATE TABLE `tb_reservation` (
  `id` int(10) UNSIGNED NOT NULL,
  `reservedBy` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `dayAmount` int(11) NOT NULL,
  `peopleAmount` int(11) NOT NULL,
  `roomType` varchar(70) NOT NULL,
  `member` tinyint(1) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL,
  `taxFee` int(11) NOT NULL,
  `total` int(11) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_reservation`
--

INSERT INTO `tb_reservation` (`id`, `reservedBy`, `email`, `dayAmount`, `peopleAmount`, `roomType`, `member`, `price`, `taxFee`, `total`, `reg_date`, `user_id`) VALUES
(77, 'NIcexx SimpBigBalls', 'admin@gmail.com', 9, 5, 'deluxe', 1, 1750, 794, 12134, '2024-10-24 12:03:48', 17);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` tinytext NOT NULL,
  `email` varchar(50) NOT NULL,
  `role` int(11) NOT NULL,
  `reg_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `reg_date`) VALUES
(7, 'NicexD', '$2y$10$r8/NORbcviEVpLOBSxZDteRZP6VvtjPjMfabTnKt/PMWj8eqg3EC6', 'maoezxooo@gmail.com', 1, '2024-09-11 10:13:32'),
(10, 'maoezx0562', '$2y$10$Bp0jYku22yS3ilGAMawxSu1EmtGw3uXPF.OBTyiHNmj5EyQwjKoDa', 'maoezxooo1@gmail.com', 1, '2024-09-12 19:15:01'),
(11, 'Nice', '$2y$10$mb6abC/E6qJtwHXuUXWQmuQZD4EV52XE9Kwwp08odNa78WboXb19u', 'maoezxooo12@gmail.com', 1, '2024-09-12 18:34:49'),
(12, 'maoezx056', '$2y$10$o31AihmU0o6egoD30lANReNyd6VofOYU8l920Jl6LKFTwzvSI86AG', 'maoexasdzxooo@gmail.com', 0, '2024-09-11 15:43:05'),
(13, '121', '$2y$10$9TVWfK9wmUzq.45CD0MNQOFEmr6hTmk5KXegOueXgL8PIp6tOZ0dC', '12345678@gmail.com', 1, '2024-09-12 18:59:30'),
(17, 'admin', '$2y$10$HvHVesoDYRD0ER6N5PT4WOLQejI2Y4a2.cdcBszoHo3Jc2AHLinwq', 'admin@gmail.com', 1, '2024-10-20 06:36:15'),
(18, 'maoezx056ss', '$2y$10$Al56jn3.WCOZfWD.LQXTBOfOtteJINDG9J8CbYkdrSB5KOqWXH6ry', 'asd@xgmail.com', 0, '2024-10-03 05:05:33'),
(19, 'maoezx056ssasd', '$2y$10$d.zbihdtyJQ/C1jOizwKce2tLhhh.45N4NvC2Wd8RM3H6H6aod1eC', 'asad@xgmail.com', 0, '2024-10-03 05:11:53'),
(23, 'maoezx0560', '$2y$10$ue/A77f7HFYqajMsBZOIgO6g.3b9Pe/ku8aGyhR0dbOVBnDWhzCsG', 'maoezxooo@gmail.com1', 0, '2024-10-20 07:48:37'),
(27, 'maoezx0560x', '$2y$10$5mbjjsh2HYF6qSP1KF4a6eKiNyNFrzjoYHe084KsGb076.8BNTZZG', 'maoezxooo@gmail.comx', 0, '2024-10-20 09:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `id` int(11) NOT NULL,
  `fname` varchar(40) NOT NULL DEFAULT 'ยังไม่ได้ตั้ง',
  `lname` varchar(40) NOT NULL DEFAULT 'ยังไม่ได้ตั้ง',
  `email` varchar(100) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT 'default_avatar',
  `role` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`id`, `fname`, `lname`, `email`, `avatar`, `role`) VALUES
(7, 'Pasitsxaa0', 'Bungosedx', 'maoezxooo@gmail.com', '993706410671a38fe7dc607.53454396.jpg', 1),
(10, 'Nicexasx00', 'lnwzasss', 'maoezxooo1@gmail.com', '141155937766e334cde7a316.23134311.jpg', 1),
(11, 'sdasd', 'ยังไม่ได้ตั้ง', 'maoezxooo12@gmail.com', '183674456166e336056ecbc7.96537038.png', 1),
(12, 'x', 'ax', 'maoexasdzxooo@gmail.com', '167417473667149652668d97.44860183.png', 0),
(13, 'ยังไม่ได้ตั้ง', 'ยังไม่ได้ตั้ง', '12345678@gmail.com', '5418232186719dffd7c8be8.98982102.jpg', 1),
(17, 'NIcexx', 'SimpBigBalls', 'admin@gmail.com', '1659086096714cd37ab01b8.38341400.gif', 1),
(18, '0', 'ยังไม่ได้ตั้ง00', 'asd@xgmail.com', '442089347671a054c722766.86311419.png', 0),
(19, 'ยังไม่ได้ตั้ง', 'ยังไม่ได้ตั้ง', 'asad@xgmail.com', 'default_avatar', 0),
(23, 'ยังไม่ได้ตั้ง', 'ยังไม่ได้ตั้ง', 'maoezxooo@gmail.com1', 'default_avatar', 0),
(27, 'ยังไม่ได้ตั้ง', 'ยังไม่ได้ตั้ง', 'maoezxooo@gmail.comx', 'default_avatar', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_reservation`
--
ALTER TABLE `tb_reservation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_reservation`
--
ALTER TABLE `tb_reservation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
