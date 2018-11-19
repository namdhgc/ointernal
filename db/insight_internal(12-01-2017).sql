-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 12, 2017 at 05:49 PM
-- Server version: 5.5.49-MariaDB-1ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `insight_internal`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `createdById` int(11) NOT NULL,
  `create_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `postId` varchar(64) NOT NULL,
  `content` text NOT NULL,
  `createdById` int(11) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`id`, `name`, `phone_number`, `address`, `created_date`, `updated_date`) VALUES
(1, 'Develop', '', '22 Floor', '2016-12-15 00:00:00', '2016-12-15 00:00:00'),
(2, 'Test', '', '22 Floor', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `id` int(11) NOT NULL,
  `serial_no` varchar(20) NOT NULL,
  `name` varchar(64) NOT NULL,
  `bydate` datetime NOT NULL,
  `active` tinyint(1) NOT NULL,
  `note` varchar(128) NOT NULL,
  `createdById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `document`
--

CREATE TABLE `document` (
  `id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `path` varchar(255) NOT NULL,
  `type` varchar(10) NOT NULL,
  `createById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `firstname` varchar(64) NOT NULL,
  `lastname` varchar(64) NOT NULL,
  `employeeCode` varchar(10) NOT NULL,
  `password` varchar(80) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `displayName` varchar(128) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `birthday` datetime NOT NULL,
  `address1` varchar(1024) NOT NULL,
  `address2` varchar(1024) DEFAULT NULL,
  `phone_number` varchar(200) NOT NULL,
  `probationary` datetime DEFAULT NULL,
  `official_date` datetime DEFAULT NULL,
  `out_date` datetime DEFAULT NULL,
  `position` smallint(6) DEFAULT NULL,
  `managerId` int(11) DEFAULT NULL,
  `departmentId` int(11) NOT NULL,
  `diplomaId` smallint(6) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `description` varchar(1024) DEFAULT NULL,
  `avatar_name` varchar(64) DEFAULT NULL,
  `avatar_path` varchar(256) DEFAULT NULL,
  `holiday_allowance` int(11) DEFAULT NULL,
  `createdById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL,
  `remember_token` varchar(80) DEFAULT NULL,
  `is_manager` tinyint(1) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `firstname`, `lastname`, `employeeCode`, `password`, `displayName`, `email`, `gender`, `birthday`, `address1`, `address2`, `phone_number`, `probationary`, `official_date`, `out_date`, `position`, `managerId`, `departmentId`, `diplomaId`, `active`, `description`, `avatar_name`, `avatar_path`, `holiday_allowance`, `createdById`, `created_date`, `updated_date`, `remember_token`, `is_manager`, `updated_at`) VALUES
(1, 'Lưu Hữu', 'Chuẩn', '1', '$2y$10$wypzXc11yGD4jICO5es3ueUvBlzETw4mvgvHDzYtk98wtPrNSaNP.', 'Lưu Hữu Chuẩn', 'chuanlh@insight-tec.com.vn', 1, '1992-06-20 05:30:00', 'Kim Nỗ', NULL, '0966200692', '2016-11-08 08:00:00', '2016-12-08 11:00:00', NULL, 1, 1, 1, 1, 1, NULL, 'chuan', 'chuan', 1, 1, '2016-12-14 00:00:00', '2016-12-30 00:00:00', 'piACyGEtZYD0fR3eMDidwD2GcC1C0UOsPxkxB7ITiEn0rrg96T9oJQKSCgBV', 0, '2016-12-28 09:15:25'),
(2, 'Đinh Hoài', 'Nam', '2', '$2y$10$wypzXc11yGD4jICO5es3ueUvBlzETw4mvgvHDzYtk98wtPrNSaNP.', 'Đinh Hoài Nam', 'namdh@insight-tec.com.vn', 1, '1992-06-20 05:30:00', 'Tây Sơn', NULL, '0966200692', '2016-11-08 08:00:00', '2016-12-08 11:00:00', NULL, 1, 1, 1, 1, 1, NULL, 'chuan', 'chuan', 1, 1, '2016-12-14 00:00:00', '2016-12-30 00:00:00', 'QUdU0nPjAoLZ14UPi5v3YRVuLNMY9bnpmQL54fu8W1x56hvG4vTA42g89Zs1', 0, '0000-00-00 00:00:00'),
(3, 'Văn A', 'Nguyễn', 'dev001', '$2y$10$wypzXc11yGD4jICO5es3ueUvBlzETw4mvgvHDzYtk98wtPrNSaNP.', 'Nguyễn Văn A', 'anv@insight-tec', 0, '2017-01-02 00:00:00', 'Hà Nội', NULL, '0123', NULL, '2017-01-12 09:36:49', NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, 2, '2017-01-12 09:36:49', '2017-01-12 09:36:49', NULL, 0, NULL),
(28, 'asd', 'asd', 'is002', '$2y$10$wypzXc11yGD4jICO5es3ueUvBlzETw4mvgvHDzYtk98wtPrNSaNP.', 'asd asd', 'bca@gmail.com', 1, '2017-02-02 00:00:00', 'asd', NULL, '12', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 2, '2017-01-12 17:44:04', '2017-01-12 17:44:04', NULL, NULL, NULL),
(29, 'Ho', 'Viet', 'IS001', '$2y$10$wypzXc11yGD4jICO5es3ueUvBlzETw4mvgvHDzYtk98wtPrNSaNP.', 'Viet Ho', 'abc@gmail.com', 1, '2017-01-11 00:00:00', 'sdaas', NULL, '123123', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 2, '2017-01-12 17:46:49', '2017-01-12 17:46:49', NULL, NULL, NULL),
(30, 'V', 'Ho', 'is002', '5', 'Ho V', 'abd@gmail.com', 1, '2017-01-25 00:00:00', 'aasd', NULL, '1231', NULL, NULL, NULL, NULL, NULL, 2, 2, 1, NULL, NULL, NULL, NULL, 2, '2017-01-12 17:49:29', '2017-01-12 17:49:29', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employee_device_relationship`
--

CREATE TABLE `employee_device_relationship` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `start_hire` datetime NOT NULL,
  `end_hire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `employee_role_relationship`
--

CREATE TABLE `employee_role_relationship` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `roleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employee_role_relationship`
--

INSERT INTO `employee_role_relationship` (`id`, `employeeId`, `roleId`) VALUES
(1, 1, 2),
(2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `holiday`
--

CREATE TABLE `holiday` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `approverId` int(11) NOT NULL,
  `approvedDate` datetime DEFAULT NULL,
  `isApproved` tinyint(1) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `types` smallint(6) NOT NULL,
  `note` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `holiday`
--

INSERT INTO `holiday` (`id`, `employeeId`, `approverId`, `approvedDate`, `isApproved`, `start_date`, `end_date`, `types`, `note`) VALUES
(1, 2, 1, NULL, 0, '2017-01-11 00:00:00', '2017-01-12 00:00:00', 2, 'k'),
(2, 1, 2, NULL, 0, '2017-01-12 00:10:00', '2017-01-12 00:15:00', 3, 'sd');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `overtime`
--

CREATE TABLE `overtime` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `date` date NOT NULL,
  `startTime` datetime NOT NULL,
  `endTime` datetime NOT NULL,
  `approverId` int(11) NOT NULL,
  `typeId` int(11) NOT NULL,
  `approvedDate` date DEFAULT NULL,
  `isApproved` tinyint(1) DEFAULT '0',
  `note` varchar(512) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `overtime`
--

INSERT INTO `overtime` (`id`, `employeeId`, `date`, `startTime`, `endTime`, `approverId`, `typeId`, `approvedDate`, `isApproved`, `note`) VALUES
(23, 2, '2017-01-09', '2017-01-09 10:30:00', '2017-01-09 10:35:00', 1, 0, NULL, 0, 'gga'),
(44, 2, '2017-01-10', '2017-01-10 17:00:00', '2017-01-10 18:00:00', 1, 0, NULL, 0, 'safasf'),
(45, 2, '2017-01-11', '2017-01-11 17:05:00', '2017-01-11 16:05:00', 1, 0, NULL, 0, 'wafaf'),
(50, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'chuan'),
(51, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'j'),
(52, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, '8'),
(53, 1, '2016-12-25', '2016-12-25 17:25:00', '2016-12-25 18:25:00', 1, 0, NULL, 0, 'j'),
(54, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 1, NULL, 0, 'f'),
(55, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'u'),
(56, 1, '2017-01-02', '2017-01-02 17:30:00', '2017-01-02 16:30:00', 1, 0, NULL, 0, 'k'),
(57, 1, '2017-01-02', '2017-01-02 17:30:00', '2017-01-02 16:30:00', 1, 0, NULL, 0, 'k'),
(58, 1, '2017-01-12', '2017-01-12 08:50:00', '2017-01-12 09:50:00', 1, 0, NULL, 0, '	<script type="text/javascript">alert(" Fig Bug nay di "); window.location.href="https://www.google.com.vn/search?q=takizawa+laura&rlz=1C1CHBF_enVN723VN723&espv=2&biw=1920&bih=974&source=lnms&tbm=isch&sa=X&ved=0ahUKEwjQyvbSs6zRAhXDE5QKHbzpBIEQ_AUIBigB";</script>'),
(59, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'fd'),
(60, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'e'),
(61, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'j'),
(62, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 's'),
(63, 1, '2017-01-02', '2017-01-02 09:55:00', '2017-01-02 09:55:00', 1, 0, NULL, 0, '1'),
(64, 1, '2017-01-06', '2017-01-06 10:00:00', '2017-01-06 10:00:00', 1, 0, NULL, 0, 'ds'),
(65, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, '8'),
(66, 1, '2017-01-06', '2017-01-06 10:05:00', '2017-01-06 10:05:00', 1, 0, NULL, 0, 'o'),
(67, 1, '2017-01-06', '2017-01-06 10:05:00', '2017-01-06 10:05:00', 1, 0, NULL, 0, 'ds'),
(68, 1, '2017-01-06', '2017-01-06 10:05:00', '2017-01-06 10:05:00', 1, 0, NULL, 0, 'rt'),
(69, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'l'),
(70, 1, '2017-01-06', '2017-01-06 10:05:00', '2017-01-06 10:05:00', 1, 0, NULL, 0, 'y'),
(71, 1, '2017-01-06', '2017-01-06 10:05:00', '2017-01-06 10:05:00', 1, 0, NULL, 0, 'e'),
(72, 1, '2017-01-06', '2017-01-06 10:05:00', '2017-01-06 10:05:00', 1, 0, NULL, 0, 'r'),
(73, 1, '2017-01-08', '2017-01-08 08:55:00', '2017-01-08 07:10:00', 1, 0, NULL, 0, 'nj'),
(74, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 2, 1, NULL, 0, '4'),
(75, 1, '2017-01-11', '2017-01-11 10:20:00', '2017-01-11 09:20:00', 1, 0, NULL, 0, 'g'),
(76, 1, '2017-01-06', '2017-01-06 10:30:00', '2017-01-06 10:30:00', 1, 0, NULL, 0, 's'),
(77, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'ôpkokokokokokokokokok'),
(78, 1, '2017-01-03', '2017-01-03 10:45:00', '2017-01-03 07:50:00', 1, 0, NULL, 0, 'k'),
(79, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, ';'),
(80, 1, '2017-01-03', '2017-01-03 13:05:00', '2017-01-03 09:05:00', 1, 0, NULL, 0, 'c'),
(81, 2, '2017-01-18', '2017-01-18 19:00:00', '2017-01-18 22:00:00', 1, 0, NULL, 0, 'safafa sà'),
(82, 1, '2017-01-02', '2017-01-02 12:05:00', '2017-01-02 12:05:00', 1, 0, NULL, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` mediumtext NOT NULL,
  `cateId` int(11) NOT NULL,
  `createById` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `updated_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(1024) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `name`, `description`, `created_date`, `updated_date`) VALUES
(1, 'Admin', 'Admin co tat ca cac quyen', NULL, NULL),
(2, 'User', 'User se thao tac tren Front site', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workingtime`
--

CREATE TABLE `workingtime` (
  `id` int(11) NOT NULL,
  `employeeId` int(11) NOT NULL,
  `date` date DEFAULT NULL,
  `startDate` datetime DEFAULT NULL,
  `endDate` datetime DEFAULT NULL,
  `totalTimePerDay` bigint(11) DEFAULT NULL,
  `totalTimePerMonth` bigint(11) DEFAULT NULL,
  `note` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `workingtime`
--

INSERT INTO `workingtime` (`id`, `employeeId`, `date`, `startDate`, `endDate`, `totalTimePerDay`, `totalTimePerMonth`, `note`) VALUES
(378, 1, '2017-01-06', '2017-01-06 13:08:00', '2017-01-06 13:08:53', 53, 53, ''),
(381, 2, '2017-01-06', '2017-01-06 16:50:00', '2017-01-06 16:50:13', 13, 13, ''),
(382, 1, '2017-01-08', '2017-01-08 15:13:00', '2017-01-08 15:14:02', 62, 115, ''),
(383, 1, '2017-01-09', '2017-01-09 11:38:11', '2017-01-09 12:01:39', 0, 115, ''),
(384, 2, '2017-01-10', '2017-01-10 08:45:00', '2017-01-10 09:49:00', 247, 260, 'Đến muộn đã xin phép');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `createdById` (`createdById`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `postId` (`postId`),
  ADD KEY `createdById` (`createdById`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `id_2` (`id`);

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createdById` (`createdById`);

--
-- Indexes for table `document`
--
ALTER TABLE `document`
  ADD PRIMARY KEY (`id`),
  ADD KEY `createById` (`createById`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id` (`id`),
  ADD KEY `managerId` (`managerId`),
  ADD KEY `departmentId` (`departmentId`),
  ADD KEY `diplomaId` (`diplomaId`),
  ADD KEY `createdById` (`createdById`);

--
-- Indexes for table `employee_device_relationship`
--
ALTER TABLE `employee_device_relationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `employee_role_relationship`
--
ALTER TABLE `employee_role_relationship`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`),
  ADD KEY `roleId` (`roleId`);

--
-- Indexes for table `holiday`
--
ALTER TABLE `holiday`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employeeId` (`employeeId`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overtime`
--
ALTER TABLE `overtime`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`),
  ADD KEY `title` (`title`),
  ADD KEY `title_2` (`title`),
  ADD KEY `cateId` (`cateId`),
  ADD KEY `createById` (`createById`),
  ADD KEY `title_3` (`title`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `workingtime`
--
ALTER TABLE `workingtime`
  ADD PRIMARY KEY (`id`) KEY_BLOCK_SIZE=11,
  ADD KEY `employeeId` (`employeeId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `document`
--
ALTER TABLE `document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `employee_device_relationship`
--
ALTER TABLE `employee_device_relationship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_role_relationship`
--
ALTER TABLE `employee_role_relationship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `workingtime`
--
ALTER TABLE `workingtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`createdById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `device_ibfk_1` FOREIGN KEY (`createdById`) REFERENCES `employee` (`id`);

--
-- Constraints for table `document`
--
ALTER TABLE `document`
  ADD CONSTRAINT `document_ibfk_1` FOREIGN KEY (`createById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee`
--
ALTER TABLE `employee`
  ADD CONSTRAINT `employee_ibfk_1` FOREIGN KEY (`departmentId`) REFERENCES `department` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_ibfk_2` FOREIGN KEY (`createdById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_device_relationship`
--
ALTER TABLE `employee_device_relationship`
  ADD CONSTRAINT `employee_device_relationship_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `device` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_device_relationship_ibfk_2` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employee_role_relationship`
--
ALTER TABLE `employee_role_relationship`
  ADD CONSTRAINT `employee_role_relationship_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_role_relationship_ibfk_2` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `holiday`
--
ALTER TABLE `holiday`
  ADD CONSTRAINT `holiday_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`cateId`) REFERENCES `category` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_ibfk_2` FOREIGN KEY (`createById`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `workingtime`
--
ALTER TABLE `workingtime`
  ADD CONSTRAINT `workingtime_ibfk_1` FOREIGN KEY (`employeeId`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
