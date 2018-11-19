-- phpMyAdmin SQL Dump
-- version 4.6.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 13, 2017 at 01:45 PM
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
  `birthday` date NOT NULL,
  `address1` varchar(1024) NOT NULL,
  `address2` varchar(1024) DEFAULT NULL,
  `phone_number` varchar(200) NOT NULL,
  `probationary` datetime DEFAULT NULL,
  `official_date` date DEFAULT NULL,
  `out_date` date DEFAULT NULL,
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
(1, 'Lưu Hữu', 'Chuẩn', '1', '$2y$10$O7QbGjDj/XW0J.VzDkU5PO2KQMjua.bYbBa4KsDtIfNcnYeA0fS0m', 'Lưu Hữu Chuẩn', 'chuanlh@insight-tec.com.vn', 1, '1992-06-20', 'Kim Nỗ', NULL, '0966200692', '2016-11-08 08:00:00', '2016-12-08', NULL, 1, 1, 1, 1, 1, NULL, 'chuan', 'chuan', 1, 1, '2016-12-14 00:00:00', '2016-12-30 00:00:00', 'ZkOcwGpiF6JXv7R7TAavMBy7i6dN87uiBdOT6KOlqratGFLHaIo9vWb8TnxO', 0, '2016-12-28 09:15:25'),
(2, 'Đinh Hoài', 'Nam', '2', '$2y$10$O7QbGjDj/XW0J.VzDkU5PO2KQMjua.bYbBa4KsDtIfNcnYeA0fS0m', 'Đinh Hoài Nam', 'namdh@insight-tec.com.vn', 1, '1992-06-20', 'Tây Sơn', NULL, '0966200692', '2016-11-08 08:00:00', '2016-12-08', NULL, 1, 1, 1, 1, 1, NULL, 'chuan', 'chuan', 1, 1, '2016-12-14 00:00:00', '2016-12-30 00:00:00', '2E2FKurTMxKgIKiqEePZkx35Ivl1VdSb2mWMrG6aSXeVKAY9AQaY42BlPmZl', 0, '0000-00-00 00:00:00'),
(3, 'Văn A', 'Nguyễn', 'dev001', '$2y$10$O7QbGjDj/XW0J.VzDkU5PO2KQMjua.bYbBa4KsDtIfNcnYeA0fS0m', 'Nguyễn Văn A', 'anv@insight-tec', 0, '2017-01-02', 'Hà Nội', NULL, '0123', NULL, '2017-01-12', '2017-02-02', NULL, NULL, 1, NULL, 0, NULL, NULL, NULL, NULL, 2, '2017-01-12 09:36:49', '2017-01-12 09:36:49', NULL, 0, NULL),
(80, 'Anh', 'Hồ', 'DEV005', '$2y$10$juZFCiHd61F5z9H.TjZNUOQQ1cceQB2VmLwRPCteABQoZUbANUZNC', 'Hồ Anh', 'vietanhho152@gmail.com', 1, '1999-02-09', 'asd', NULL, '123', NULL, '2016-12-05', '2017-02-05', NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 2, '2017-01-13 15:13:42', '2017-01-13 15:13:42', NULL, NULL, NULL),
(93, 'Minh', 'Lê', 'minhl', '$2y$10$rrMy2xrmiQkAkQbaUkP.uOTJJ4b3eWK7ObmJc5WG7qRM/LscpZ1im', 'Lê Minh', 'minhle@insight-tec.com.vn', 1, '1990-03-28', 'Số 10A ngách 325/105 Thanh Lương Hai Bà Trưng Hà Nội Việt Nam', NULL, '0978169505', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 2, '2017-01-16 14:23:02', '2017-01-16 14:23:02', 'm6zVorSBPlZO1Yg8t7yqjxJRlJOqxeNAQ2o7Q2C4XnNZvcPG9Hx5fBVSwxzn', NULL, NULL),
(95, 'Minh', 'Lê', 'minhl', '$2y$10$kNRQh.P/v0cNHFDzLDnZ9ee1kpvus2Gm3UDkFB0L18p/yRiFFRqAG', 'Lê Minh', 'leminh2803@gmail.com', 1, '1990-03-28', 'Số 10A ngách 325/105 Thanh Lương Hai Bà Trưng Hà Nội Việt Nam', NULL, '0978169505', NULL, NULL, NULL, NULL, NULL, 1, 2, 1, NULL, NULL, NULL, NULL, 93, '2017-01-16 14:46:43', '2017-01-16 14:46:43', NULL, NULL, NULL),
(107, '柏木', '武志', 'dev-001', '$2y$10$n4AqTiSWd3ie/MHCy2bsnOaiAKVFrvfd2Ta9dxewGc.Bv9Fm1iWAm', '武志 柏木', 'kashiwagi@insight-tec.com.vn', 1, '1981-07-16', 'Insight-tec', NULL, '0123456789', NULL, '2016-12-05', '2017-02-08', NULL, NULL, 1, 1, 0, NULL, NULL, NULL, NULL, 2, '2017-01-23 14:09:36', '2017-01-23 14:09:36', NULL, NULL, NULL),
(119, 'Diệp', 'Nguyễn', 'dev-004', '$2y$10$gsLEv0Z4SRREaBMo8z9N.OOtZtVuSP8pQ.axGlxw07UV/hMK8k1ka', 'Nguyễn Diệp', 'dieploosy@gmail.com', 2, '1997-06-11', 'không biết', NULL, '0123123123123', NULL, NULL, NULL, NULL, NULL, 1, 1, 1, NULL, NULL, NULL, NULL, 2, '2017-01-24 14:25:30', '2017-01-24 14:25:30', '0hHNp9gdJxZOfEIVOfjrQkuMIo8BSWlKCNKRyFJuTjDh5HfkjoRwAC1WaFKr', NULL, NULL),
(126, 'Viet Anh', 'Ho', 'HoVA', '$2y$10$HbNCnf8ua7rJ1rSEWbnP0uiHAThAeUp7JqmXHczfGMZqkcMx3CzYG', 'Ho Viet Anh', 'bohiphop96@gmail.com', 1, '2017-01-10', 'Hanoi', NULL, '0984999999', NULL, '2016-09-20', '2017-02-07', NULL, NULL, 2, 2, 0, NULL, NULL, NULL, NULL, 2, '2017-01-24 15:03:04', '2017-01-24 15:03:04', NULL, NULL, NULL);

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
(2, 2, 1),
(14, 80, 1),
(24, 93, 1),
(25, 95, 2),
(26, 107, 1),
(38, 119, 2),
(45, 126, 2);

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
(2, 1, 2, NULL, 0, '2017-01-12 00:20:00', '2017-01-12 00:30:00', 3, 'sda335zzzzzz'),
(12, 2, 1, NULL, 0, '2017-01-11 15:25:00', '2017-01-17 15:20:00', 2, 'ghi chu22xzz'),
(13, 2, 2, '2017-01-17 17:02:27', 1, '2017-01-01 16:55:00', '2017-01-05 16:55:00', 0, 'Xin nghi'),
(14, 2, 1, '2017-02-09 10:01:51', 1, '2017-01-20 09:20:00', '2017-01-22 09:20:00', 0, 'Approved'),
(15, 1, 1, NULL, 0, '2017-01-26 09:40:00', '2017-01-27 09:40:00', 0, 'star'),
(16, 2, 1, '2017-01-23 13:35:48', 1, '2017-01-13 13:35:00', '2017-01-14 13:35:00', 0, 'take a day off because of sick');

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
(45, 2, '2017-01-11', '2017-01-11 17:05:00', '2017-01-11 17:11:00', 1, 0, NULL, 0, 'wafaf'),
(50, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'chuan'),
(51, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, 'j'),
(52, 1, '2017-01-01', '2017-01-01 16:10:00', '2017-01-01 17:30:00', 1, 0, NULL, 0, '8'),
(53, 1, '2016-12-25', '2016-12-25 17:30:00', '2016-12-25 18:23:00', 1, 0, '2017-02-03', 1, 'j'),
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
(81, 2, '2017-01-18', '2017-01-18 20:00:00', '2017-01-18 22:00:00', 1, 0, '2017-01-16', 1, 'safafa sà'),
(82, 1, '2017-01-02', '2017-01-02 12:05:00', '2017-01-02 12:05:00', 1, 0, NULL, 0, ''),
(83, 1, '2017-01-24', '2017-01-24 09:40:00', '2017-01-24 10:40:00', 1, 2, NULL, 0, 'zsdfsf'),
(84, 2, '2017-01-24', '2017-01-24 19:10:00', '2017-01-24 22:00:00', 1, 0, '2017-01-23', 1, 'overtime for SIGLASS.');

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
(378, 1, '2017-01-06', '2017-01-06 13:05:00', '2017-01-06 13:58:00', 53, 53, ''),
(382, 1, '2017-01-08', '2017-01-08 15:13:00', '2017-01-08 15:14:02', 62, 115, ''),
(383, 1, '2017-01-09', '2017-01-09 11:38:11', '2017-01-09 12:01:39', 0, 115, ''),
(385, 2, '2017-01-18', '2017-01-18 15:19:15', '2017-01-18 15:26:23', 428, 428, ''),
(386, 1, '2017-01-23', '2017-01-23 09:35:28', '2017-01-23 09:39:56', 268, 383, ''),
(387, 2, '2017-01-23', '2017-01-23 13:07:00', '2017-01-23 13:14:00', 36, 464, ''),
(388, 119, '2017-01-24', '2017-01-24 14:25:57', '2017-01-24 18:03:40', 13063, 13063, ''),
(389, 119, '2017-02-06', '2017-02-06 14:35:08', NULL, NULL, NULL, NULL),
(390, 119, '2017-02-08', '2017-02-08 13:47:15', '2017-02-08 18:04:17', 15422, 15422, ''),
(391, 1, '2017-02-09', '2017-02-09 10:57:25', '2017-02-09 18:22:55', 21330, 21330, ''),
(392, 119, '2017-02-09', '2017-02-09 13:29:07', '2017-02-09 18:20:17', 17470, 50337, 'aadsddf'),
(393, 2, '2017-02-09', '2017-02-09 18:15:35', '2017-02-09 18:15:37', 2, 2, ''),
(395, 1, '2017-02-10', '2017-02-10 09:48:00', '2017-02-10 14:40:00', 12092, 33422, 'Check out'),
(396, 119, '2017-02-10', '2017-02-10 13:36:00', '2017-02-10 18:09:45', 16425, 65725, 'kkook'),
(398, 2, '2017-02-10', '2017-02-10 18:16:48', NULL, NULL, NULL, NULL),
(400, 2, '2017-02-13', '2017-02-13 08:30:00', '2017-02-13 11:35:00', 40, 42, 'Found the bug. If any day do not have end time, all the day before can be end many times.'),
(401, 119, '2017-02-13', '2017-02-13 13:24:24', NULL, NULL, NULL, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
--
-- AUTO_INCREMENT for table `employee_device_relationship`
--
ALTER TABLE `employee_device_relationship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `employee_role_relationship`
--
ALTER TABLE `employee_role_relationship`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `holiday`
--
ALTER TABLE `holiday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `overtime`
--
ALTER TABLE `overtime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=402;
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
