-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 04, 2018 at 11:48 AM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `for_cory`
--

-- --------------------------------------------------------

--
-- Table structure for table `company_profile`
--

CREATE TABLE `company_profile` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_address` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_city` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_state` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_zip` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_country` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phone_buss` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_phone_fax` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_business_email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_website` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_currency` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_logo` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `other_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_join_date` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company_profile`
--

INSERT INTO `company_profile` (`id`, `user_id`, `company_name`, `company_address`, `company_city`, `company_state`, `company_zip`, `company_country`, `payment_type`, `company_phone_buss`, `company_phone_fax`, `company_business_email`, `company_website`, `company_currency`, `company_logo`, `other_image`, `company_join_date`, `created_at`, `updated_at`) VALUES
(1, 12, 'AUUSH', '', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M.jpg', '2018-09-19', '2018-09-18 18:30:00', '2018-09-17 18:30:00'),
(2, 13, 'Siddd', 'Aaaaaaa', 'Bbbbbassasasa', 'Cccc', 'Dd', 'E', 'F', 'Gggg', 'H', 'I', 'Jjjjjjjjjjjjjj', 'K', 'M', 'N.jpg', '2018-09-19', '2018-09-18 18:30:00', '2018-09-21 01:41:02'),
(4, 14, 'abcdd', 'abcdaaa', 'sasa', 'asas', 'asas', 'sa', NULL, 'assa', 'assa', 'asas', 'assasaaaa', NULL, '14-logo.jpg', '14-other.png', NULL, '2018-09-20 09:15:34', '2018-09-21 06:32:51'),
(5, 11, 'WWWW', 'WWW', 'WWW', 'WWW', 'WWW', 'WWW', NULL, 'ffafdfdf', NULL, NULL, 'Null', NULL, '11-logo.jpg', '11-other.jpg', NULL, '2018-09-24 02:53:08', '2018-09-26 09:37:56'),
(6, 15, 'Deep', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Null', NULL, '15-logo.png', '15-other.png', NULL, '2018-09-26 08:34:07', '2018-09-26 08:34:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `company_profile`
--
ALTER TABLE `company_profile`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `company_profile`
--
ALTER TABLE `company_profile`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
