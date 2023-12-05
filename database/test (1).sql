-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2023 at 11:21 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` int(11) NOT NULL,
  `branch_code` varchar(50) NOT NULL,
  `department` text NOT NULL,
  `contact` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `branches`
--

INSERT INTO `branches` (`id`, `branch_code`, `department`, `contact`, `date_created`) VALUES
(3, '101011100011000', 'IT Dept', '', '2023-10-09 13:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `doc_name` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`id`, `doc_name`, `date_created`) VALUES
(1, 'Daily Time Record', '2023-10-08 00:01:50'),
(4, 'Document_1', '2023-10-26 12:54:02'),
(5, 'Document_2', '2023-10-26 12:54:31'),
(6, 'Document_3', '2023-10-26 12:54:47'),
(7, 'Document_4', '2023-10-26 12:54:59');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `message` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parcels`
--

CREATE TABLE `parcels` (
  `id` int(11) NOT NULL,
  `reference_number` varchar(100) NOT NULL,
  `created_by` varchar(30) NOT NULL,
  `sender_name` varchar(30) NOT NULL,
  `sender_contact` varchar(30) NOT NULL,
  `recipient_name` varchar(30) NOT NULL,
  `recipient_contact` varchar(30) NOT NULL,
  `doc_type` varchar(30) NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `from_branch_id` varchar(30) NOT NULL,
  `to_branch_id` varchar(30) NOT NULL,
  `remarks` varchar(200) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parcels`
--

INSERT INTO `parcels` (`id`, `reference_number`, `created_by`, `sender_name`, `sender_contact`, `recipient_name`, `recipient_contact`, `doc_type`, `file_name`, `from_branch_id`, `to_branch_id`, `remarks`, `status`, `date_created`, `date_updated`) VALUES
(3, '2023102138KMSUF', '5', '2', '09456258490', '3', '09456258490', '1', '', '3', '2', 'Signature for DTR', 2, '2023-10-21 17:51:25', '2023-11-07 10:12:43'),
(4, '20231022BC6FL84', '5', '5', '09823235345', '4', '0912354634542', '1', '', '1', '1', 'signature', 0, '2023-10-22 04:25:03', '2023-11-07 10:12:43'),
(5, '20231022RXFN3ME', '5', '5', '09458391773', '2', '09456258490', '1', '', '3', '3', 'signature', 0, '2023-10-22 13:22:53', '2023-11-07 10:12:43'),
(6, '20231025VJCX5TE', '2', '2', '09456258490', '5', '09458391773', '1', '', '3', '3', 'Sample', 1, '2023-10-24 16:16:34', '2023-11-07 10:12:43'),
(7, '20231026VJZ7NE9', '2', '2', '09456258490', '5', '09458391773', '4', '', '3', '3', 'Sample', 2, '2023-10-26 12:56:40', '2023-11-07 10:12:43'),
(8, '202310260WJXEFO', '2', '2', '09456258490', '5', '09458391773', '5', '', '3', '3', 'Sample', 0, '2023-10-26 12:57:08', '2023-11-07 10:12:43'),
(9, '202310266358JQV', '2', '2', '09456258490', '5', '09458391773', '6', '', '3', '3', 'Sample', 0, '2023-10-26 12:57:33', '2023-11-07 10:12:43'),
(10, '20231026I9QYZXR', '2', '2', '09456258490', '5', '09458391773', '7', '', '3', '3', 'Sample', 1, '2023-10-26 12:57:54', '2023-11-07 10:12:43'),
(11, '20231026EU4JFP1', '2', '2', '09456258490', '5', '09458391773', '4', '', '3', '3', 'Sample', 1, '2023-10-26 12:58:17', '2023-11-07 10:12:43'),
(12, '2023102783BH4NG', '5', '5', '09458391773', '2', '09456258490', '1', '', '3', '3', 'Samplr', 0, '2023-10-27 04:03:18', '2023-11-07 10:12:43');

-- --------------------------------------------------------

--
-- Table structure for table `parcel_tracks`
--

CREATE TABLE `parcel_tracks` (
  `id` int(11) NOT NULL,
  `parcel_id` int(11) NOT NULL,
  `sender_id` varchar(30) NOT NULL,
  `receiver_id` varchar(30) NOT NULL,
  `status` int(11) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parcel_tracks`
--

INSERT INTO `parcel_tracks` (`id`, `parcel_id`, `sender_id`, `receiver_id`, `status`, `date_created`) VALUES
(6, 3, '5', '4', 0, '2023-10-21 17:51:25'),
(7, 3, '5', '4', 1, '2023-10-21 17:52:43'),
(8, 3, '4', '2', 0, '2023-10-21 18:01:13'),
(9, 3, '4', '2', 1, '2023-10-21 18:05:26'),
(10, 3, '2', '3', 0, '2023-10-21 18:05:39'),
(11, 3, '2', '3', 2, '2023-10-21 18:07:00'),
(12, 4, '5', '4', 0, '2023-10-22 04:25:03'),
(13, 5, '5', '2', 0, '2023-10-22 13:22:53'),
(14, 6, '2', '5', 0, '2023-10-24 16:16:34'),
(15, 7, '2', '5', 0, '2023-10-26 12:56:40'),
(16, 8, '2', '5', 0, '2023-10-26 12:57:08'),
(17, 9, '2', '5', 0, '2023-10-26 12:57:33'),
(18, 10, '2', '5', 0, '2023-10-26 12:57:54'),
(19, 11, '2', '5', 0, '2023-10-26 12:58:17'),
(20, 10, '2', '5', 1, '2023-10-26 13:02:12'),
(21, 6, '2', '5', 1, '2023-10-26 13:03:50'),
(22, 11, '2', '5', 1, '2023-10-26 13:04:17'),
(23, 7, '2', '5', 2, '2023-10-26 13:04:42'),
(24, 12, '5', '2', 0, '2023-10-27 04:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'PSU Cross Platform Document Monitoring System', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `contact_number` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1 = admin, 2 = staff',
  `branch_id` int(11) NOT NULL,
  `reset_code` varchar(500) DEFAULT NULL,
  `dlt` varchar(2) NOT NULL DEFAULT '1',
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `contact_number`, `email`, `password`, `type`, `branch_id`, `reset_code`, `dlt`, `date_created`) VALUES
(1, 'Administrator', '', '', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', 1, 0, '5RPvf5UFly1HlWkkdEi8rx9eH00iJqVkF0oHgadhOWubvyrylZi1xF3bZkrMT1Kzh8FbqDEp5pkzQdECehWCxDMc7yUcZvEwKBVOLYNvx3qfrMZdRk0ohLS2MdgoDl84di7yi4ns77DrLmvptG7rAvmc36JNpWM6ZTXvr6ltoYrPHtnYexWL4mJIcOV6U3sRXae8BC9falmdZxEPPPJc2IZQ9Zm93KQceh2oZ5v09JfbR8aoBFJwjs1wFKlOwH4caHqctC0bQZDMH6qbIzsbI9jPvgKJQ2Q8Zr7LU5mPnclmfXOQEhxdgmVZIHgNUyQYy7cBCA00HLVfuc1ZULZJv65ghlVxRbK36cSNjdeGgymlX7sMVX4Tnsve8Wa7KYolczrKJQBhf9ntzlXP2E5ATdetDVegecBTtVXgSK7fepTuixCsO5qplLqTtZgCOxhvhwFwZUgPQgedVKa88trgMQcM4UUHXq4yGgGgnuutkegpBxIxs6ao', '1', '2020-11-26 10:57:04'),
(2, 'Karl Anthony', 'Pajarillo', '09456258490', 'kpajarillo_20ln1974@psu.edu.ph', '0192023a7bbd73250516f069df18b500', 2, 3, 'WoWLAv4ccaUqXsj73cofl0wES0jmPgLZ2XaqvSsVZWvfwxjFptx6HTB5TjCISOYdwNrVw18Le1x0q5y3DtaVP0zzauwX3lASc7sFphbC0LXp3a0uRBmKyZ5oeH55gYWcHfhEQAwHoWKPXmzZ6Hi58Fj3uBqBD33PPxNJsfmN3rdODHGt4SFrjicmtnSNvPt069a5CTH1cGKiH8rRykYFtXiUFmJeKuVcy6CpN8tHZSeZ95EenJhEB0IaWP8RhB9TonpNR7Wrxt7kHZQRaIRSNOjYh8gsGtgor50QpGflBeuwvjQrunpk8iVO5bKOcqEY8kaQ3XVRnayk16MyO3fHUuR4ZYGXkF1xGZAoI6nAxCXyKolUt9Clw5RQrBAKN7BEF9bJW9d4VnB5ZXskubPuO38XeguiQRqCAs5WMCgCMRazA9gTdsc7uTOyDXzlq8vG0aHMDiRhhVyiKQxyjOEc0DJa7YYRGvSORaar6UgghMR800EgIVmZ', '1', '2023-06-19 20:50:18'),
(3, 'Christian James', 'Pe Benito', '09569874123', 'ChristianPebenito@gmail.com', '0192023a7bbd73250516f069df18b500', 2, 2, NULL, '1', '2023-06-19 23:47:45'),
(4, 'Louise Ann Claire', 'Versoza', '09512634894', 'LouiseVersoza@admin.com', '0192023a7bbd73250516f069df18b500', 2, 1, NULL, '1', '2023-10-01 01:20:18'),
(5, 'Liana', 'Ramirez', '09458391773', 'LianaRamirez@admin.com', '0192023a7bbd73250516f069df18b500', 2, 3, NULL, '1', '2023-10-09 13:30:10'),
(6, 'Master', 'Ricbon', '09925836121', 'ricbonpogi@gmail.com', '7bd0f1df4e565d15b1f09e7d46ea3840', 1, 3, NULL, '1', '2023-10-26 12:24:02'),
(7, 'Chuwee', 'Ruiz', '09925836121', 'jcolpogi@gmail.com', '0f5046be0947364bf6f7c3de8352c061', 2, 3, NULL, '1', '2023-10-26 12:45:50'),
(8, 'Karl Anthony', 'Pajarillo', '09925836121', 'karl@gmail.com', '0192023a7bbd73250516f069df18b500', 3, 3, NULL, '1', '2023-11-06 14:34:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcels`
--
ALTER TABLE `parcels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parcel_tracks`
--
ALTER TABLE `parcel_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `parcels`
--
ALTER TABLE `parcels`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `parcel_tracks`
--
ALTER TABLE `parcel_tracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
