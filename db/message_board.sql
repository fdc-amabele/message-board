-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2019 at 10:12 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `message_board`
--

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `to_id` int(11) NOT NULL,
  `from_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `to_id`, `from_id`, `content`, `created`, `modified`) VALUES
(1, 2, 3, 'Hey cilley, how are you?', '2019-05-31 07:36:52', '2019-05-31 07:36:52'),
(2, 3, 2, 'Im good', '2019-05-31 07:37:08', '2019-05-31 07:37:08'),
(3, 2, 3, 'nice', '2019-05-31 07:39:51', '2019-05-31 07:39:51'),
(5, 3, 2, 'nothing', '2019-05-31 07:40:42', '2019-05-31 07:40:42'),
(8, 1, 3, 'hasdjfalsjd f', '2019-05-31 07:57:08', '2019-05-31 07:57:08'),
(9, 1, 6, 'hey, where you working at?', '2019-05-31 08:39:32', '2019-05-31 08:39:32'),
(10, 1, 6, 'just curious', '2019-05-31 08:39:40', '2019-05-31 08:39:40'),
(11, 1, 6, 'test', '2019-05-31 08:42:19', '2019-05-31 08:42:19'),
(18, 1, 6, '23', '2019-05-31 08:42:38', '2019-05-31 08:42:38'),
(23, 2, 6, 'sss', '2019-05-31 10:02:09', '2019-05-31 10:02:09'),
(24, 2, 6, 'aaaa', '2019-05-31 10:02:13', '2019-05-31 10:02:13'),
(25, 2, 6, 'sdasd', '2019-05-31 10:02:15', '2019-05-31 10:02:15'),
(26, 2, 6, 'asdasd', '2019-05-31 10:02:16', '2019-05-31 10:02:16'),
(27, 2, 6, 'asdasd', '2019-05-31 10:02:18', '2019-05-31 10:02:18'),
(28, 2, 6, 'asdasdasd', '2019-05-31 10:02:21', '2019-05-31 10:02:21'),
(29, 2, 6, 'asd', '2019-05-31 10:02:22', '2019-05-31 10:02:22'),
(30, 2, 6, 'asd', '2019-05-31 10:02:23', '2019-05-31 10:02:23'),
(31, 2, 6, 'asd', '2019-05-31 10:02:23', '2019-05-31 10:02:23'),
(32, 2, 6, 'asd', '2019-05-31 10:02:24', '2019-05-31 10:02:24'),
(33, 2, 6, 'asd', '2019-05-31 10:02:25', '2019-05-31 10:02:25'),
(34, 2, 6, 'asd', '2019-05-31 10:02:26', '2019-05-31 10:02:26'),
(35, 6, 2, 'asdfas', '2019-05-31 10:04:25', '2019-05-31 10:04:25'),
(36, 6, 2, 'asdasddas', '2019-05-31 10:04:33', '2019-05-31 10:04:33'),
(37, 6, 2, 'sdasdasd', '2019-05-31 10:04:34', '2019-05-31 10:04:34'),
(38, 6, 2, 'asd', '2019-05-31 10:04:35', '2019-05-31 10:04:35'),
(39, 6, 2, 'asdsadsd', '2019-05-31 10:04:36', '2019-05-31 10:04:36'),
(40, 2, 6, 'asdasd', '2019-05-31 10:04:40', '2019-05-31 10:04:40'),
(41, 2, 6, 'asdasd', '2019-05-31 10:04:41', '2019-05-31 10:04:41'),
(42, 6, 2, 'asdasdasd', '2019-05-31 10:04:44', '2019-05-31 10:04:44'),
(43, 6, 2, 'this is the last message', '2019-05-31 10:05:23', '2019-05-31 10:05:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL COMMENT '	1=male, 2=female, null=not specified	',
  `birthdate` date DEFAULT NULL,
  `hubby` text,
  `last_login_time` datetime NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `created_ip` varchar(20) NOT NULL COMMENT '	user ip address',
  `modified_ip` varchar(20) NOT NULL COMMENT '	user ip address'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `gender`, `birthdate`, `hubby`, `last_login_time`, `created`, `modified`, `created_ip`, `modified_ip`) VALUES
(1, 'John Doe', 'john@gmail.com', 'f13cd6fd671082b4f1ef688eee5f43fdd42e4e82', '1559186383_2.jpg', '1', '1970-01-01', '', '2019-05-31 08:08:17', '2019-05-30 05:19:29', '2019-05-31 08:08:17', '::1', '::1'),
(2, 'Nicole Cilley', 'nicole@gmail.com', 'f13cd6fd671082b4f1ef688eee5f43fdd42e4e82', '1559186416_1.jpg', '2', '1970-01-01', '', '2019-05-31 10:04:19', '2019-05-30 05:20:00', '2019-05-31 10:04:19', '::1', '::1'),
(3, 'Arthur Lindey', 'arthur@gmail.com', 'f13cd6fd671082b4f1ef688eee5f43fdd42e4e82', '1559186463_4.jpg', '1', '1970-01-01', '', '2019-05-31 10:02:47', '2019-05-30 05:20:49', '2019-05-31 10:02:47', '::1', '::1'),
(5, 'Jane Doe', 'jane@gmail.com', 'f13cd6fd671082b4f1ef688eee5f43fdd42e4e82', '1559199669_images.png', '2', '1970-01-01', '', '2019-05-30 09:00:05', '2019-05-30 08:59:58', '2019-05-30 09:01:09', '::1', '::1'),
(6, 'Therese Juls', 'therese@gmail.com', 'f13cd6fd671082b4f1ef688eee5f43fdd42e4e82', '1559201727_images (1).png', '1', '2009-01-07', 'test', '2019-05-31 10:03:21', '2019-05-30 09:34:22', '2019-05-31 10:03:21', '::1', '::1');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
