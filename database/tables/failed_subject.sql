-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 13, 2024 at 11:16 AM
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
-- Database: `fep_bsu`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_subject`
--

CREATE TABLE `failed_subject` (
  `id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `sr_code` varchar(30) NOT NULL,
  `section_id` int(11) NOT NULL,
  `subject_status` int(11) NOT NULL,
  `sem_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `failed_subject`
--

INSERT INTO `failed_subject` (`id`, `subject_id`, `sr_code`, `section_id`, `subject_status`, `sem_id`) VALUES
(1, 50, '19-61072', 1, 3, 1),
(2, 53, '19-61072', 1, 3, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_subject`
--
ALTER TABLE `failed_subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_subject`
--
ALTER TABLE `failed_subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
