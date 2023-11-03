-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 11, 2020 at 10:31 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enrollment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `school_year` int(30) NOT NULL,
  `level_section_id` int(30) NOT NULL,
  `faculty_id` int(30) NOT NULL,
  `status` tinyint(30) NOT NULL DEFAULT 1 COMMENT '0 = inactive , 1 = Active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`id`, `student_id`, `school_year`, `level_section_id`, `faculty_id`, `status`, `date_updated`) VALUES
(2, 8, 2, 1, 1, 1, '2020-09-11 15:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(30) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `level_section_id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Inactive , 1 = Active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `firstname`, `middlename`, `lastname`, `level_section_id`, `user_id`, `status`, `date_updated`) VALUES
(1, 'John', '', 'Smith', 1, 4, 1, '2020-09-11 10:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `last_school`
--

CREATE TABLE `last_school` (
  `id` int(30) NOT NULL,
  `last_school` text NOT NULL,
  `last_address` text NOT NULL,
  `enrollment_id` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `last_school`
--

INSERT INTO `last_school` (`id`, `last_school`, `last_address`, `enrollment_id`) VALUES
(1, 'Sample Schoolll', 'Sample School address', 2);

-- --------------------------------------------------------

--
-- Table structure for table `level_section`
--

CREATE TABLE `level_section` (
  `id` int(30) NOT NULL,
  `level` varchar(20) NOT NULL,
  `section` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Inactive , 1 = Active',
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `level_section`
--

INSERT INTO `level_section` (`id`, `level`, `section`, `status`, `date_updated`) VALUES
(1, 'Grade 1', 'A', 1, NULL),
(2, 'Grade 1', 'B', 1, NULL),
(3, 'Grade 1', 'C', 1, NULL),
(4, 'Grade 2', 'A', 1, '2020-09-11 09:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `id` int(30) NOT NULL,
  `school_year` varchar(100) NOT NULL,
  `is_on` tinyint(1) DEFAULT 1,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = Inactive, 1 = Active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `school_year`
--

INSERT INTO `school_year` (`id`, `school_year`, `is_on`, `status`, `date_updated`) VALUES
(1, 'SY 2018-2019', 0, 1, '2020-09-11 13:08:58'),
(2, 'SY 2019-2020', 1, 1, '2020-09-11 13:09:32'),
(3, 'SY 2017-2018', 0, 1, '2020-09-11 13:09:32'),
(4, 'SY 2016-2017', 0, 1, '2020-09-11 13:08:55');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `img_path` text NOT NULL,
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `address`, `img_path`, `date_updated`) VALUES
(1, 'Sample School', 'Sample School address', '1599802140_no-image-available.png', '2020-09-11 13:29:35');

-- --------------------------------------------------------

--
-- Table structure for table `student_list`
--

CREATE TABLE `student_list` (
  `id` int(30) NOT NULL,
  `student_code` varchar(50) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middlename` varchar(50) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dob` date NOT NULL,
  `address` text NOT NULL,
  `contact_person` varchar(200) NOT NULL,
  `cp_relation` varchar(100) NOT NULL,
  `cp_number` varchar(100) NOT NULL,
  `cp_address` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1= new , 2 =regular,3=transferee , 4= returnee',
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0 = inactive , 1= active',
  `date_created` date NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `student_list`
--

INSERT INTO `student_list` (`id`, `student_code`, `firstname`, `middlename`, `lastname`, `gender`, `dob`, `address`, `contact_person`, `cp_relation`, `cp_number`, `cp_address`, `type`, `status`, `date_created`, `date_updated`) VALUES
(8, '2020-00001\n', 'Sample', '', 'Test', 'female', '2014-06-23', 'Test', '', '', '', '', 1, 1, '2020-09-11', '2020-09-11 16:21:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `user_type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = admin',
  `username` varchar(25) NOT NULL,
  `password` varchar(25) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT ' 0 = incative , 1 = active',
  `date_updated` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_type`, `username`, `password`, `status`, `date_updated`) VALUES
(1, 'Administrator', 1, 'admin', 'admin123', 1, '2020-09-08 16:42:28'),
(2, 'John Smith', 1, 'jsmth', 'admin123', 1, '2020-09-08 16:13:53'),
(3, 'Sample User', 1, 'sample', 'sampl123', 1, '2020-09-09 11:34:14'),
(4, 'John  Smith', 2, 'jsmith', 'admin123', 1, '2020-09-11 09:55:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `last_school`
--
ALTER TABLE `last_school`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level_section`
--
ALTER TABLE `level_section`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_list`
--
ALTER TABLE `student_list`
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
-- AUTO_INCREMENT for table `enrollment`
--
ALTER TABLE `enrollment`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `last_school`
--
ALTER TABLE `last_school`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `level_section`
--
ALTER TABLE `level_section`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `student_list`
--
ALTER TABLE `student_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
