-- phpMyAdmin SQL Dump
-- version 5.2.2deb1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 13, 2025 at 11:53 AM
-- Server version: 8.4.5-0ubuntu0.1
-- PHP Version: 8.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `certificate_verification`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'SMEC_Admin_2025!', '$2y$12$8H.EYXTfrRrx4KRrMse4DuCkufQvEAhQNFFNtvgUpxUfioTMnZ2VG', '2025-06-06 15:50:31', '2025-06-13 17:21:21');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `certificate_number` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `work_from_date` date NOT NULL,
  `work_to_date` date NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`id`, `name`, `certificate_number`, `designation`, `work_from_date`, `work_to_date`, `image_path`, `is_verified`, `created_at`, `updated_at`) VALUES
(1, 'Test1', 'test/smec/1', 'test1', '2025-06-01', '2025-06-09', 'text', 1, '2025-06-09 12:11:34', '2025-06-09 12:11:43'),
(2, 'Test2', 'test/smec/2', 'test2', '2025-06-01', '2025-06-09', 'text', 1, '2025-06-09 12:12:17', '2025-06-09 12:16:56'),
(3, 'test120', 'test120/testsmec', 'dsfsdf', '2025-06-11', '2025-06-12', 'writable/uploads/certificates/1749815436_3682caa56be660bf51ea.png', 1, '2025-06-13 17:20:36', '2025-06-13 17:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `class` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `group` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(4, '2024-03-20-000001', 'App\\Database\\Migrations\\CreateCertificatesTable', 'default', 'App', 1749205230, 1),
(5, '2024-03-20-000002', 'App\\Database\\Migrations\\CreateAdminsTable', 'default', 'App', 1749205231, 1),
(6, '2024-03-20-000003', 'App\\Database\\Migrations\\CreateDefaultAdmin', 'default', 'App', 1749205231, 1),
(7, '2024-03-20-000004', 'App\\Database\\Migrations\\UpdateCertificatesTable', 'default', 'App', 1749205955, 2),
(8, '2024-03-20-000005', 'App\\Database\\Migrations\\FixCertificatesTable', 'default', 'App', 1749206251, 3),
(9, '2024-03-20-000006', 'App\\Database\\Migrations\\UpdateCertificatesDates', 'default', 'App', 1749209557, 4),
(10, '2024-03-20-000007', 'App\\Database\\Migrations\\FixCertificatesTableStructure', 'default', 'App', 1749210065, 5),
(13, '2024-03-20-000008', 'App\\Database\\Migrations\\FixCertificatesTable', 'default', 'App', 1749212063, 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `certificate_number` (`certificate_number`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
