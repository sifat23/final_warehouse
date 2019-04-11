-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2019 at 01:50 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vinfo`
--

-- --------------------------------------------------------

--
-- Table structure for table `course_table`
--

CREATE TABLE `course_table` (
  `id` int(11) NOT NULL,
  `full_name` varchar(60) NOT NULL,
  `program_name` varchar(20) NOT NULL,
  `total_semester` varchar(11) NOT NULL,
  `total_credits` varchar(11) NOT NULL,
  `tution_fees` varchar(10) NOT NULL,
  `rank_allover` int(11) NOT NULL,
  `versity_id` int(11) NOT NULL,
  `science` varchar(10) NOT NULL,
  `arts` varchar(10) NOT NULL,
  `commarce` varchar(10) NOT NULL,
  `biology` double NOT NULL,
  `physices` double NOT NULL,
  `mathematics` double NOT NULL,
  `chemestry` double NOT NULL,
  `ssc` double NOT NULL,
  `hsc` double NOT NULL,
  `a_level` double NOT NULL,
  `o_level` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course_table`
--

INSERT INTO `course_table` (`id`, `full_name`, `program_name`, `total_semester`, `total_credits`, `tution_fees`, `rank_allover`, `versity_id`, `science`, `arts`, `commarce`, `biology`, `physices`, `mathematics`, `chemestry`, `ssc`, `hsc`, `a_level`, `o_level`) VALUES
(1, 'Bachelor of Architecture', 'msc', '15', '201', '8,90,000', 1, 1, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'Bachelor of Business Administration', 'msc/mba/ma', '12', '112', '9,80,000', 2, 2, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'Computer Science & Engineering', 'prostgraduate', '12', '148', '7,90,000', 2, 2, '', '', '', 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'Bachelor of Architecture', 'Undergraduate', '12', '201', '20,000,00', 1, 1, 'yes', 'no', 'no', 0, 0, 0, 0, 0, 0, 0, 0),
(5, 'Computer Science', 'Undergraduate', '12', '148', '9,80,000', 3, 3, 'yes', 'yes', 'yes', 0, 0, 0, 0, 2, 2, 2, 2),
(6, 'Computer Science & Engineering', 'Undergraduate', '12', '148', '7,60,000', 3, 3, 'yes', 'no', 'no', 0, 0, 0, 0, 3.9, 3.9, 2.9, 2.9),
(7, 'Computer Science & Engineering', 'Undergraduate', '12', '148', '7,90,000', 2, 2, 'yes', 'no', 'no', 2, 2, 2, 2, 2.4, 2.4, 2.5, 2.5),
(8, 'Bachelor of Business Administration', 'Undergraduate', '12', '112', '8,90,000', 5, 4, 'yes', 'yes', 'yes', 0, 0, 0, 0, 2.3, 2.3, 2.3, 2.3);

-- --------------------------------------------------------

--
-- Table structure for table `details_uni`
--

CREATE TABLE `details_uni` (
  `id` int(11) NOT NULL,
  `rank_allover` int(11) NOT NULL,
  `university_name` varchar(60) NOT NULL,
  `short_uni_name` varchar(10) NOT NULL,
  `vc_name` varchar(60) NOT NULL,
  `university_address` varchar(300) NOT NULL,
  `location` varchar(500) NOT NULL,
  `v_logo` varchar(560) NOT NULL,
  `covar_image` varchar(560) NOT NULL,
  `p_one_name` varchar(60) NOT NULL,
  `p_one_m` varchar(2000) NOT NULL,
  `p_one_image` varchar(560) NOT NULL,
  `p_two_name` varchar(60) NOT NULL,
  `p_two_m` varchar(2000) NOT NULL,
  `p_two_image` varchar(560) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `details_uni`
--

INSERT INTO `details_uni` (`id`, `rank_allover`, `university_name`, `short_uni_name`, `vc_name`, `university_address`, `location`, `v_logo`, `covar_image`, `p_one_name`, `p_one_m`, `p_one_image`, `p_two_name`, `p_two_m`, `p_two_image`) VALUES
(1, 1, 'Brac University', 'BRAC', 'Professor Dr Syed Saad Andaleeb', '66 Mohakhali , Dhaka 1212', 'https://www.google.com/maps/place/BRAC+University/@23.7800912,90.4049885,17z/data=!3m1!4b1!4m5!3m4!1s0x3755c7715a40c603:0xec01cd75f33139f5!8m2!3d23.7800863!4d90.4071772', 'Brac-University-logo-best-p.png', '02_Cam01-1-1920x1081.jpg', 'Sir Fazle Hasan Abed', 'Since its inception in 2001, Brac University has become one of the most reputed educational institutions in Bangladesh. We have focused on generating new knowledge and promoting critical thinking amongst our students, graduating more than 7,000 young men and women during this time.', 'Sir FH Abed.jpg', 'Professor Vincent Chang, Vice Chancellor', 'Brac University is ranked highly in this country. This is a great achievement. However, in the global landscape of higher education, we are still off the radar. We are behind the world\'s best in our practices and standards. But we do not intend to stay that way. We choose to aim ambitiously high. We shall continuously improve this University. We shall benchmark ourselves against the best and eventually become one of them. Achieving such a goal demands a long vision, a brave heart and an unwavering commitment. And it is an undertaking that requires the dedication of the entire community of stakeholders. This is surely not an easy journey, nor is it quick. We may not be able to get there during my tenure as Vice Chancellor, but I am sure we will get there. And we shall now take the first step.', 'Vincent Chang Edited.jpg'),
(2, 2, 'Independent University Bangladesh', 'IUB', 'Professor M. Omar Rahman', 'Plot 16 Block B, Aftabuddin Ahmed Road, 1229,, Dhaka', 'https://www.google.com/maps/place/%E0%A6%87%E0%A6%A8%E0%A7%8D%E0%A6%A1%E0%A6%BF%E0%A6%AA%E0%A7%87%E0%A6%A8%E0%A6%A1%E0%A7%87%E0%A6%A8%E0%A7%8D%E0%A6%9F+%E0%A6%87%E0%A6%89%E0%A6%A8%E0%A6%BF%E0%A6%AD%E0%A6%BE%E0%A6%B0%E0%A7%8D%E0%A6%B8%E0%A6%BF%E0%A6%9F%E0%A6%BF,+%E0%A6%AC%E0%A6%BE%E0%A6%82%E0%A6%B2%E0%A6%BE%E0%A6%A6%E0%A7%87%E0%A6%B6/@23.8155158,90.4257628,17z/data=!3m1!4b1!4m5!3m4!1s0x3755c64be6744a57:0xeacead51ebe2bf60!8m2!3d23.8155109!4d90.4279568', 'Independent_University_Bangladesh_logo.png', 'slide3.jpg', 'Sir Fazle Hasan Abed', 'Since its inception in 2001, Brac University has become one of the most reputed educational institutions in Bangladesh. We have focused on generating new knowledge and promoting critical thinking amongst our students, graduating more than 7,000 young men and women during this time.', 'p1.jpg', 'Sir Fazle Hasan Abed', 'Since its inception in 2001, Brac University has become one of the most reputed educational institutions in Bangladesh. We have focused on generating new knowledge and promoting critical thinking amongst our students, graduating more than 7,000 young men and women during this time.', 'p1.jpg'),
(3, 3, 'North South University Bangladesh', 'NSU', 'Professor Atiqul Islam', ' Plot # 15, Block # B, 1229, Dhaka', 'https://www.google.com/maps/place/%E0%A6%A8%E0%A6%B0%E0%A7%8D%E0%A6%A5+%E0%A6%B8%E0%A6%BE%E0%A6%89%E0%A6%A5+%E0%A6%87%E0%A6%89%E0%A6%A8%E0%A6%BF%E0%A6%AD%E0%A6%BE%E0%A6%B0%E0%A7%8D%E0%A6%B8%E0%A6%BF%E0%A6%9F%E0%A6%BF/@23.8151079,90.423344,17z/data=!3m1!4b1!4m5!3m4!1s0x3755c64c103a8093:0xd660a4f50365294a!8m2!3d23.815103!4d90.425538', 'North-South-University-Logo.png', 'north-south-university.jpg', 'Sir Fazle Hasan Abed', 'Since its inception in 2001, Brac University has become one of the most reputed educational institutions in Bangladesh. We have focused on generating new knowledge and promoting critical thinking amongst our students, graduating more than 7,000 young men and women during this time.', 'p1.jpg', 'Sir Fazle Hasan Abed', 'Since its inception in 2001, Brac University has become one of the most reputed educational institutions in Bangladesh. We have focused on generating new knowledge and promoting critical thinking amongst our students, graduating more than 7,000 young men and women during this time.', 'p1.jpg'),
(4, 5, 'American International University Bangladesh', 'AIUB', 'Dr. Carmen Z. Lamagna', '408/1, Kuratoli, Khilkhet, Dhaka 1229, Bangladesh', 'https://www.google.com/maps/place/American+International+University-Bangladesh/@23.8218948,90.4256549,17.25z/data=!4m5!3m4!1s0x3755c711d13bbec7:0xc47f7c3e8e2263f2!8m2!3d23.821961!4d90.427521', 'AIUB_whole_logo.png', '2560x1600-safety-orange-blaze-orange-solid-color-background.jpg', 'Sir Fazle Hasan Abed', 'Since its inception in 2001, Brac University has become one of the most reputed educational institutions in Bangladesh. We have focused on generating new knowledge and promoting critical thinking amongst our students, graduating more than 7,000 young men and women during this time.', 'p1.jpg', 'Sir Fazle Hasan Abed', 'Since its inception in 2001, Brac University has become one of the most reputed educational institutions in Bangladesh. We have focused on generating new knowledge and promoting critical thinking amongst our students, graduating more than 7,000 young men and women during this time.', 'p1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `main_source`
--

CREATE TABLE `main_source` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pack_receive_details`
--

CREATE TABLE `pack_receive_details` (
  `id` int(11) NOT NULL,
  `invoice_code` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `pack_code` varchar(60) NOT NULL,
  `amount` int(11) NOT NULL,
  `unit` varchar(60) NOT NULL,
  `short_details` varchar(360) NOT NULL,
  `request_date` varchar(20) NOT NULL,
  `request_time` varchar(20) NOT NULL,
  `accepted_date` date NOT NULL,
  `accepted_time` time NOT NULL,
  `company_id` int(11) NOT NULL,
  `company_name` varchar(50) NOT NULL,
  `row_id` int(11) NOT NULL,
  `cave_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pack_receive_details`
--

INSERT INTO `pack_receive_details` (`id`, `invoice_code`, `name`, `pack_code`, `amount`, `unit`, `short_details`, `request_date`, `request_time`, `accepted_date`, `accepted_time`, `company_id`, `company_name`, `row_id`, `cave_id`) VALUES
(1, '', 'Body Power', '10002934', 200, 'bottle', 'cool body telcome powder', '2019-02-07', '10:14:31', '2019-02-07', '11:42:53', 10, '', 1, 1),
(3, '', '', '10003374', 0, '', '5 kg rice with very special flavor', '2019-02-07', '10:18:27', '2019-02-07', '11:44:09', 7, '', 8, 2),
(4, '', '', '10002343', 0, '', 'mouth fress chewing gum. 6 box.', '2019-02-07', '10:19:36', '2019-02-07', '11:44:53', 7, '', 3, 1),
(5, '', '', '10002956', 0, '', 'Lux Sope and Lifeboy Sope', '2019-02-08', '04:31:02', '2019-02-08', '04:32:28', 7, '', 9, 2),
(6, '', 'Books of Joke', '10021342', 100, 'pices', 'books for human right. Auther by wins black', '2019-02-10', '08:18:11', '2019-02-10', '08:20:11', 10, '', 2, 1),
(7, '', 'Pencile', '10029372', 100, 'box', 'pencile of matadore company', '2019-02-10', '09:24:22', '2019-02-10', '09:24:37', 10, '', 13, 3),
(8, '', 'Mouse', '10002934', 20, 'pices', 'Logitech mouse', '2019-02-15', '09:58:26', '2019-02-16', '09:07:18', 7, '', 1, 1),
(9, '', 'Keybord', '10039273', 100, 'pices', 'Logitech keybored wireless', '2019-02-15', '10:09:41', '2019-02-16', '11:44:00', 7, 'Havana.Prop', 10, 2),
(10, '10002', 'Laptop', '10029374', 100, 'box', 'Apple macbook pro 16gb ram 256gb ssd', '2019-02-17', '11:45:52', '2019-02-18', '12:57:49', 10, 'hip hop', 25, 5),
(11, '10025', 'e77', '8927272', 90, 'kg', 'sjksjknjnskj', '2019-02-21', '06:45:42', '2019-03-02', '05:06:16', 23, 'Oppo', 13, 3),
(12, '10002', 'Rice', '1002966', 90, 'ton', 'rohima food control forn minikate rice', '2019-02-17', '11:47:00', '2019-03-02', '05:57:34', 10, 'hip hop', 18, 4),
(13, '10002', 'Sound Box', '90227364', 200, 'box', '5:1 sterio speacker', '2019-02-17', '11:48:02', '2019-03-02', '05:59:22', 10, 'hip hop', 18, 4),
(14, '10003', 'Cocacola 1 litter', '10002923', 100, 'bottle', 'it is very populer drink', '2019-02-18', '03:26:39', '2019-03-02', '06:00:25', 7, 'Havana.Prop', 18, 4);

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `id` int(11) NOT NULL,
  `sub_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `sub_name`) VALUES
(1, 'asdasd'),
(2, 'lkjllasdasd');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course_table`
--
ALTER TABLE `course_table`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `details_uni`
--
ALTER TABLE `details_uni`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_source`
--
ALTER TABLE `main_source`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pack_receive_details`
--
ALTER TABLE `pack_receive_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course_table`
--
ALTER TABLE `course_table`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `details_uni`
--
ALTER TABLE `details_uni`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `main_source`
--
ALTER TABLE `main_source`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pack_receive_details`
--
ALTER TABLE `pack_receive_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
