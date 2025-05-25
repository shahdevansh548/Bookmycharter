-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 07:17 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookcharter`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `amount` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `login_id`, `doctor_id`, `start`, `end`, `amount`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 16, 1, '2025-05-27 17:00:00', '2025-05-27 17:20:00', 600, '2025-05-24 12:21:12', 'Devansh Shah', '2025-05-25 13:29:36', 'admin'),
(3, 16, 1, '2025-05-25 21:30:00', '2025-05-25 21:40:00', 300, '2025-05-25 18:05:44', 'admin', '2025-05-25 18:05:44', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `id` int(11) NOT NULL,
  `login_id` int(11) DEFAULT NULL,
  `hospital_ids` varchar(50) DEFAULT NULL,
  `working_days` varchar(50) DEFAULT NULL,
  `working_hours` varchar(50) DEFAULT NULL,
  `holiday_to` date DEFAULT NULL,
  `holiday_from` date DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`id`, `login_id`, `hospital_ids`, `working_days`, `working_hours`, `holiday_to`, `holiday_from`, `created_at`, `updated_at`) VALUES
(1, 15, '1', '1,2,3', ' 10:00-18:00', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE `hospital` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` int(10) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hospital`
--

INSERT INTO `hospital` (`id`, `name`, `email`, `phone`, `created_at`, `updated_at`) VALUES
(1, 'Devansh Shah', 'devansh.shah15944@sakec.ac.in', 2147483647, '2025-05-24 11:15:15', '2025-05-24 11:15:15');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `phone` int(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `name`, `email`, `username`, `phone`, `password`, `role`, `created_at`, `update_at`) VALUES
(1, 'admin', 'admin@123.com', 'admin', 987456321, 'admin@123', 1, '2025-05-29 13:33:58', '2025-05-30 13:33:58'),
(15, 'Devansh Shah', 'devansh.shah15944@sakec.ac.in', 'doc1', 2147483647, 'doc1', 2, '2025-05-24 11:55:45', '2025-05-24 11:55:45'),
(16, 'tusha Shah', 'devansh.shah15944@sakec.ac.in', 'user1', 2147483647, 'user1@123', 3, '2025-05-25 13:10:33', '2025-05-25 13:10:33'),
(17, 'Devansh Shah', 'devansh.shah15944@sakec.ac.in', 'user2', 2147483647, 'user2', 3, '2025-05-25 18:30:16', '2025-05-25 18:30:16');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hospital`
--
ALTER TABLE `hospital`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hospital`
--
ALTER TABLE `hospital`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
