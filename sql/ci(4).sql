-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 10, 2015 at 10:32 AM
-- Server version: 5.5.46-0ubuntu0.12.04.2
-- PHP Version: 5.6.16-1+deb.sury.org~precise+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci`
--

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`id`, `name`, `email`, `mobile`, `status`, `create_date`, `modify_date`) VALUES
(51, 'Deepak kanyan', 'deepak@kanyan.com', '9041190411', 1, '2015-10-12 05:59:51', '0000-00-00 00:00:00'),
(52, 'Clerisy Solution', 'clerisysolutionsus@gmail.com', '90900944545', 1, '2015-10-12 06:00:12', '0000-00-00 00:00:00'),
(53, 'test', 'test@test.com', '90900944545', 1, '2015-11-19 07:46:17', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `employee_images`
--

CREATE TABLE `employee_images` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `employee_images`
--

INSERT INTO `employee_images` (`id`, `emp_id`, `image`) VALUES
(65, 51, '001.jpg'),
(66, 52, '645531ca420454e4780c65f8cf2ddc50.jpg'),
(67, 53, '1a9c6af4af0a1472479d94fbcbd606e4.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(255) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `last_login` datetime NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`, `level`, `status`, `last_login`, `create_date`, `modify_date`) VALUES
(4, 'admin', 'admin@admin.com', '21232f297a57a5a743894a0e4a801fc3', '6c462e51e9ab4961bb5880846c3c177d.jpg', 1, 1, '2015-11-19 13:15:33', '2015-10-09 10:16:58', '2015-10-12 18:31:11'),
(5, 'Deepak kanyan', 'deepak@kanyan.com', '498b5924adc469aa7b660f457e0fc7e5', '96ab6ec2742ae08bb0f9ff7efb1372a2.jpg', 2, 1, '2015-11-19 13:25:22', '2015-10-12 06:08:42', '0000-00-00 00:00:00'),
(6, 'Test', 'test@test.com', '0cbc6611f5540bd0809a388dc95a615b', '66cd49efcf555e83725124c8e6b86d2d.jpg', 2, 1, '2015-10-12 16:47:09', '2015-10-12 10:57:12', '0000-00-00 00:00:00'),
(8, 'New Test', 'newtest@test.com', '0876b6b0db0707db221a5c736d8a896a', '9ab5ce589e402d8a9fa3f337cf7b1d48.jpg', 2, 1, '2015-10-12 18:29:07', '2015-10-12 11:16:25', '2015-10-12 18:30:29');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_images`
--
ALTER TABLE `employee_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_empid` (`emp_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `employee_images`
--
ALTER TABLE `employee_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `employee_images`
--
ALTER TABLE `employee_images`
  ADD CONSTRAINT `employee_images_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employee` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
