-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2023 at 01:18 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kss`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_table`
--

CREATE TABLE `admin_table` (
  `admin_id` int(11) NOT NULL,
  `admin_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `admin_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `admin_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hospital_name` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `hospital_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `hospital_contact_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `hospital_logo` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `admin_table`
--

INSERT INTO `admin_table` (`admin_id`, `admin_email_address`, `admin_password`, `admin_name`, `hospital_name`, `hospital_address`, `hospital_contact_no`, `hospital_logo`) VALUES
(1, 'admin@admin.com', 'password', 'administrator', 'City Hospital', 'G11, Islamabad', '741287410', '../images/1759788512.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `coment_table`
--

CREATE TABLE `coment_table` (
  `com_id` int(11) NOT NULL,
  `com_comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_rate` int(11) NOT NULL,
  `com_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `coment_table`
--

INSERT INTO `coment_table` (`com_id`, `com_comment`, `post_id`, `user_id`, `user_name`, `post_rate`, `com_date`) VALUES
(1, 'Testing the Comments', 2, 6, 'Sohail', 5, '2023-06-11'),
(2, 'testing', 2, 6, 'Sohail Fareed', 5, '2023-06-15'),
(3, 'testing new comment working', 2, 6, 'Sohail Fareed', 3, '2023-06-15'),
(4, 'testing', 1, 6, 'Sohail Fareed', 4, '2023-06-15'),
(5, 'add comments', 1, 6, 'Sohail Fareed', 5, '2023-06-21'),
(6, 'new testing comment ', 1, 6, 'Sohail Fareed', 4, '2023-06-21'),
(7, 'testing', 2, 8, 'test', 5, '2023-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `complaint_table`
--

CREATE TABLE `complaint_table` (
  `complaint_id` int(11) NOT NULL,
  `complaint_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `complaint_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `complaint_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `complaint_date` date NOT NULL,
  `complaint_time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `complaint_table`
--

INSERT INTO `complaint_table` (`complaint_id`, `complaint_type`, `complaint_description`, `complaint_status`, `user_id`, `user_name`, `complaint_date`, `complaint_time`) VALUES
(1, 'Unsatisfied Expert’s Feedback', 'not work', 'Resolved', 6, 'Sohail', '2023-06-12', '12:06'),
(2, 'Wrongly Assigned Research Area', 'testing insert', 'On Hold', 6, 'Sohail', '2023-06-21', '10:44:52pm');

-- --------------------------------------------------------

--
-- Table structure for table `expert_table`
--

CREATE TABLE `expert_table` (
  `expert_id` int(11) NOT NULL,
  `expert_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `expert_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `expert_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `expert_profile_image` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `expert_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `expert_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `expert_date_of_birth` date NOT NULL,
  `expert_degree` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `expert_expert_in` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `expert_status` enum('Active','Inactive') COLLATE utf8_unicode_ci NOT NULL,
  `expert_added_on` datetime NOT NULL,
  `Social` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `expert_table`
--

INSERT INTO `expert_table` (`expert_id`, `expert_email_address`, `expert_password`, `expert_name`, `expert_profile_image`, `expert_phone_no`, `expert_address`, `expert_date_of_birth`, `expert_degree`, `expert_expert_in`, `expert_status`, `expert_added_on`, `Social`) VALUES
(7, 'usama@gmail.com', 'password', 'Usama', 'images/1325888435.docx', '022222', 'USEwww', '1995-06-12', 'PHD', 'Data Science', 'Active', '2023-05-26 03:22:21', ''),
(8, 'test@gmail.com', '123456', 'test', 'images/244051074.docx', '0994', 'Mal', '2010-02-17', 'MSSE', 'Mechine Learning', 'Active', '2023-06-04 16:11:46', ''),
(12, 'expert@gmail.com', '12345', 'expert', 'images/1037157934.docx', '0999866', 'USE', '2023-06-25', 'PHD', 'Data Science', 'Active', '2023-07-02 02:30:18', '');

-- --------------------------------------------------------

--
-- Table structure for table `post_table`
--

CREATE TABLE `post_table` (
  `post_id` int(11) NOT NULL,
  `post_title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_date` date NOT NULL,
  `post_time` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `post_status` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `expert_id` int(11) NOT NULL,
  `expert_feedback` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `accept_date` date DEFAULT NULL,
  `user_feedback` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post_table`
--

INSERT INTO `post_table` (`post_id`, `post_title`, `post_description`, `post_date`, `post_time`, `post_status`, `user_name`, `user_id`, `expert_id`, `expert_feedback`, `accept_date`, `user_feedback`, `rating`) VALUES
(1, 'test', 'test the working post', '2023-06-06', '12:12', 'Completed', 'ali', 0, 7, '', NULL, '', 0),
(2, 'test', 'test the working post', '2023-06-06', '12:12', 'Completed', 'umair', 1, 8, 'test the status and feedback', '2023-06-24', '', 0),
(3, 'test title', 'testing post for page', '2023-06-22', '22-06-23 02:44:31', 'Completed', 'Sohail Fareed', 6, 8, 'testing', '2023-06-26', 'test user feed back ', 5),
(4, 'umuyguy', 'fhfkjhf kjhfk fhg', '2023-06-22', '22-06-23 02:45:14', 'Completed', 'Sohail Fareed', 6, 8, 'test', '2023-05-15', 'test user feed back ', 5),
(5, 'new post', 'test this post after expert module', '2023-06-26', '26-06-23 01:14:44', 'Completed', 'Sohail Fareed', 6, 8, 'test the status and feedback', '2023-06-26', '', 0),
(6, 'final post', 'yes i submit new description', '2023-06-30', '30-06-23 07:15:53', 'Accepted', 'Sohail Fareed', 6, 8, '', '2023-06-30', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `publication_table`
--

CREATE TABLE `publication_table` (
  `publication_id` int(11) NOT NULL,
  `publication_title` varchar(255) CHARACTER SET utf32 COLLATE utf32_unicode_ci NOT NULL,
  `publication_description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `publication_date` date NOT NULL,
  `expert_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `publication_table`
--

INSERT INTO `publication_table` (`publication_id`, `publication_title`, `publication_description`, `publication_date`, `expert_id`) VALUES
(1, 'test publication title', 'testing publication', '2023-06-18', 7);

-- --------------------------------------------------------

--
-- Table structure for table `pubrate_table`
--

CREATE TABLE `pubrate_table` (
  `pubrate_id` int(11) NOT NULL,
  `publication_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pubrate_table`
--

INSERT INTO `pubrate_table` (`pubrate_id`, `publication_id`, `rate`, `user_id`) VALUES
(1, 1, 5, 6);

-- --------------------------------------------------------

--
-- Table structure for table `repcom_table`
--

CREATE TABLE `repcom_table` (
  `rep_id` int(11) NOT NULL,
  `com_id` int(11) NOT NULL,
  `com_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `rep_date` date NOT NULL,
  `rep_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `repcom_table`
--

INSERT INTO `repcom_table` (`rep_id`, `com_id`, `com_text`, `user_id`, `rep_date`, `rep_status`) VALUES
(2, 1, 'Testing the Comments', 6, '2023-06-21', 'In Investigate'),
(4, 0, 'testing report', 6, '2023-06-22', 'On Hold'),
(5, 0, 'testing report', 6, '2023-06-22', 'In Investigate'),
(6, 0, 'testing report new', 6, '2023-06-22', 'On Hold'),
(7, 0, 'testing report', 6, '2023-06-22', 'In Investigate'),
(8, 0, 'testing report new for recheck', 6, '2023-06-22', 'Resolved');

-- --------------------------------------------------------

--
-- Table structure for table `user_table`
--

CREATE TABLE `user_table` (
  `user_id` int(11) NOT NULL,
  `user_email_address` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_date_of_birth` date NOT NULL,
  `user_gender` enum('Male','Female','Other') COLLATE utf8_unicode_ci NOT NULL,
  `user_address` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `user_phone_no` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_added_on` datetime NOT NULL,
  `user_verification_code` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email_verify` enum('No','Yes') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_table`
--

INSERT INTO `user_table` (`user_id`, `user_email_address`, `user_password`, `user_first_name`, `user_last_name`, `user_date_of_birth`, `user_gender`, `user_address`, `user_phone_no`, `user_type`, `user_added_on`, `user_verification_code`, `email_verify`) VALUES
(6, 'sohail@gmail.com', 'password', 'Sohail', 'Fareed', '2004-01-21', 'Male', 'USA', '0999933', 'Student', '2023-05-26 03:27:04', '559d442ab22e07aa66e849cb18922f56', 'Yes'),
(9, 'test12@gmail.com', '123456', 'test working', 'two', '2023-07-04', 'Male', 'working', '07567567567', 'Lecturer', '2023-07-01 16:10:24', '56f11fbb8fc450467648d918d243e3db', 'Yes'),
(10, 'usertest@gmail.com', '123456', 'test', 'three', '2023-06-27', 'Female', 'address tested', '0555544321', 'Student', '2023-07-01 17:15:02', '28793775349d2e7bcae860b1a03ab0db', 'Yes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_table`
--
ALTER TABLE `admin_table`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `coment_table`
--
ALTER TABLE `coment_table`
  ADD PRIMARY KEY (`com_id`);

--
-- Indexes for table `complaint_table`
--
ALTER TABLE `complaint_table`
  ADD PRIMARY KEY (`complaint_id`);

--
-- Indexes for table `expert_table`
--
ALTER TABLE `expert_table`
  ADD PRIMARY KEY (`expert_id`);

--
-- Indexes for table `post_table`
--
ALTER TABLE `post_table`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `publication_table`
--
ALTER TABLE `publication_table`
  ADD PRIMARY KEY (`publication_id`);

--
-- Indexes for table `pubrate_table`
--
ALTER TABLE `pubrate_table`
  ADD PRIMARY KEY (`pubrate_id`);

--
-- Indexes for table `repcom_table`
--
ALTER TABLE `repcom_table`
  ADD PRIMARY KEY (`rep_id`);

--
-- Indexes for table `user_table`
--
ALTER TABLE `user_table`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_table`
--
ALTER TABLE `admin_table`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coment_table`
--
ALTER TABLE `coment_table`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `complaint_table`
--
ALTER TABLE `complaint_table`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `expert_table`
--
ALTER TABLE `expert_table`
  MODIFY `expert_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `post_table`
--
ALTER TABLE `post_table`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `publication_table`
--
ALTER TABLE `publication_table`
  MODIFY `publication_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pubrate_table`
--
ALTER TABLE `pubrate_table`
  MODIFY `pubrate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `repcom_table`
--
ALTER TABLE `repcom_table`
  MODIFY `rep_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_table`
--
ALTER TABLE `user_table`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
