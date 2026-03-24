-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3309
-- Generation Time: Mar 24, 2026 at 07:48 AM
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
-- Database: `certificate_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'Mayurk', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2025-12-22 07:53:42');

-- --------------------------------------------------------

--
-- Table structure for table `forgot_logs`
--

CREATE TABLE `forgot_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `request_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `forgot_logs`
--

INSERT INTO `forgot_logs` (`id`, `username`, `email`, `request_time`) VALUES
(1, 'yashraj1', 'yashraj@gmail.com', '2025-12-22 06:49:35'),
(2, 'yashraj2', 'yashraj2@gmail.com', '2025-12-31 20:33:29');

-- --------------------------------------------------------

--
-- Table structure for table `generated_certificates`
--

CREATE TABLE `generated_certificates` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `recipient_name` varchar(150) NOT NULL,
  `subtitle` text NOT NULL,
  `signature` varchar(150) NOT NULL,
  `issue_date` varchar(50) NOT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `help_requests`
--

CREATE TABLE `help_requests` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `problem` text NOT NULL,
  `screenshot` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `help_requests`
--

INSERT INTO `help_requests` (`id`, `name`, `email`, `problem`, `screenshot`, `created_at`, `submitted_at`) VALUES
(1, 'yashraj patil', 'patil@gmail.com', 'LIMITED TEMPLATE PLEASE ADD DIFFERANT DESIGNS', 'uploads/1774088710_39e8dfbd-85eb-4d22-8967-803dade6ba67.png', '2026-03-21 10:25:10', '2026-03-24 05:36:32'),
(2, 'yash', 'patil@gmail.com', 'not connected', 'uploads/1774088734_39e8dfbd-85eb-4d22-8967-803dade6ba67.png', '2026-03-21 10:25:34', '2026-03-24 05:36:32'),
(3, 'yashraj modhe', 'yash@1234gmail.com', 'limited templates and designs', 'uploads/1774279710_2page.pdf', '2026-03-23 15:28:30', '2026-03-24 05:36:32'),
(4, 'patil', 'yash@1234gmail.com', 'asflk', 'uploads/1774330310_2page.pdf', '2026-03-24 05:31:50', '2026-03-24 05:36:32');

-- --------------------------------------------------------

--
-- Table structure for table `login_logs`
--

CREATE TABLE `login_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `logout_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logs`
--

INSERT INTO `login_logs` (`id`, `user_id`, `username`, `login_time`, `logout_time`) VALUES
(1, 4, 'yashraj1', '2025-12-20 01:56:17', '2026-02-19 18:59:18'),
(61, 24, 'abcd', '2026-02-11 16:52:10', '2026-02-12 00:28:09'),
(62, 24, 'abcd', '2026-02-11 19:02:22', NULL),
(63, 24, 'abcd', '2026-02-12 05:17:50', NULL),
(64, 24, 'abcd', '2026-02-12 05:33:31', '2026-02-12 11:05:56'),
(65, 24, 'abcd', '2026-02-12 05:36:08', NULL),
(66, 24, 'abcd', '2026-02-12 06:18:42', NULL),
(67, 24, 'abcd', '2026-02-12 10:46:14', NULL),
(68, 25, 'xyz', '2026-02-12 10:49:31', NULL),
(69, 24, 'abcd', '2026-02-12 11:21:58', NULL),
(70, 24, 'abcd', '2026-02-12 17:33:26', NULL),
(71, 24, 'abcd', '2026-02-12 18:21:44', NULL),
(72, 24, 'abcd', '2026-02-12 18:34:00', '2026-02-13 00:04:03'),
(73, 24, 'abcd', '2026-02-13 03:46:33', NULL),
(74, 26, 'yashraj1', '2026-02-20 03:01:32', NULL),
(75, 26, 'yashraj1', '2026-03-02 21:44:16', NULL),
(76, 27, '123', '2026-03-02 17:24:16', NULL),
(77, 27, '123', '2026-03-02 17:52:08', NULL),
(78, 27, '123', '2026-03-02 18:18:43', NULL),
(79, 27, '123', '2026-03-02 18:25:45', NULL),
(80, 27, '123', '2026-03-02 18:53:32', NULL),
(81, 27, '123', '2026-03-02 18:54:03', NULL),
(82, 27, '123', '2026-03-02 19:00:19', NULL),
(83, 27, '123', '2026-03-03 12:59:51', NULL),
(84, 27, '123', '2026-03-07 11:35:06', NULL),
(85, 27, '123', '2026-03-10 11:43:18', NULL),
(86, 27, '123', '2026-03-10 12:04:07', '2026-03-10 17:42:26'),
(87, 27, '123', '2026-03-10 12:15:10', '2026-03-10 17:45:16'),
(88, 27, '123', '2026-03-10 12:16:36', '2026-03-10 17:46:46'),
(89, 27, '123', '2026-03-10 12:18:14', '2026-03-10 17:48:40'),
(90, 27, '123', '2026-03-10 12:24:31', '2026-03-10 17:54:55'),
(91, 27, '123', '2026-03-13 11:29:49', '2026-03-13 17:03:34'),
(92, 27, '123', '2026-03-21 09:29:13', NULL),
(93, 28, 'yashmodhe', '2026-03-23 15:26:19', NULL),
(94, 29, 'ritesh1', '2026-03-24 06:37:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pdf_logs`
--

CREATE TABLE `pdf_logs` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pdf_file` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `username`, `email`, `password`, `created_at`) VALUES
(1, 'mayur', 'mayurreward', 'mkolte1122@gmail.com', '$2y$10$CaOOPar0BocnMdoQDHYkiODaFbxuaTunuwViMYS3DC5BsJvgAGTiS', '2025-12-20 01:39:41'),
(2, 'Ritesh Gavhad', 'RiteshG', 'gavhadritesh8@gmail.com', '$2y$10$MfyBkx9o/p.cAi2teJIQ4.5aAbJ3zMnaMdxx27VP6NJFYslHhHN7K', '2026-01-30 16:40:54'),
(23, 'abc', 'abc', 'abc@gmail.com', '$2y$10$0SK8YCWacYDteFg6G1nkTOgC2qFeYJGqdBTX5Hzjgezi9BzC08B2K', '2026-02-11 16:44:29'),
(24, 'abcd', 'abcd', 'abcd@gmail.com', '$2y$10$mhW.oe2Gm0wisUMV/UbDSep9fAQCXth8SGnwDB7gCSiayvACvrnqe', '2026-02-11 16:51:58'),
(25, 'xyz', 'xyz', 'xyz@gmail.com', '$2y$10$k5fqkxo0Jkcp96eUKgcjqejYD7posADeuMSHeNwbL6MifvPk6WJ6i', '2026-02-12 10:49:18'),
(26, 'yahraj', 'yashraj1', 'yashraj@gmail.com', '$2y$10$hvLtiFv12Mqo.BcLPjk3Q.O/t17CP1Iq.j5A4iSX./jwSftVx5YRO', '2026-02-20 03:01:23'),
(27, '123', '123', '123@gmail.com', '$2y$10$J13mMGokfZ3dXqNJAuz9Oe7sJ7GsmG5pKeekJqxA5zaiY6sMKdRE.', '2026-03-02 17:24:11'),
(28, 'yashraj', 'yashmodhe', 'yash@1234gmail.com', '$2y$10$lypJjknWs6PbFqceFeqvBOmoS3sAY54qdDkprj4f2GMvv.DOw4Acm', '2026-03-23 15:26:06'),
(29, 'Ritesh Gavhad', 'ritesh1', 'ritesh1@gmail.com', '$2y$10$3ZtBaw5qGCPWWepEDdp.ZOrtiiAS2o3tIwQIa7WNFv.TA7t7IBCLG', '2026-03-24 06:37:09');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `forgot_logs`
--
ALTER TABLE `forgot_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `generated_certificates`
--
ALTER TABLE `generated_certificates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `help_requests`
--
ALTER TABLE `help_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logs`
--
ALTER TABLE `login_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_logs`
--
ALTER TABLE `pdf_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `forgot_logs`
--
ALTER TABLE `forgot_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `generated_certificates`
--
ALTER TABLE `generated_certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `help_requests`
--
ALTER TABLE `help_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_logs`
--
ALTER TABLE `login_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `pdf_logs`
--
ALTER TABLE `pdf_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
