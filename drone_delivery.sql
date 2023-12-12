-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2023 at 01:34 PM
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
-- Database: `drone_delivery`
--

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `delivery_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quote_id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `total_amt` double NOT NULL,
  `delivery_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`delivery_id`, `user_id`, `quote_id`, `order_id`, `total_amt`, `delivery_status`, `date`) VALUES
(8, 2, 5, 'ORD_81904', 200, 'Delivered', '2023-11-23 12:31:34'),
(9, 2, 4, 'ORD_69947', 300, 'Rejected', '2023-11-23 12:31:30'),
(10, 3, 7, 'ORD_87690', 250, 'Approved', '2023-11-23 12:31:19');

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `feedback_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(50) NOT NULL,
  `star_rating` varchar(50) NOT NULL,
  `feedback_text` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`feedback_id`, `user_id`, `order_id`, `star_rating`, `feedback_text`) VALUES
(7, 2, 'ORD_81904', '5', 'Good Good');

-- --------------------------------------------------------

--
-- Table structure for table `queries`
--

CREATE TABLE `queries` (
  `query_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queries`
--

INSERT INTO `queries` (`query_id`, `name`, `email`, `subject`, `message`, `date`) VALUES
(15, 'Test One', 'test1@gmail.com', 'testing', 'testing purpose', '2023-11-23 11:32:12');

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

CREATE TABLE `quotes` (
  `quote_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `image` varchar(100) NOT NULL,
  `user_name` varchar(50) NOT NULL,
  `user_number` int(10) NOT NULL,
  `delivery_type` varchar(255) DEFAULT NULL,
  `delivery_address` varchar(100) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `other_service` varchar(100) NOT NULL,
  `package_size` varchar(50) NOT NULL,
  `package_weight` varchar(50) NOT NULL,
  `delivery_price` double NOT NULL,
  `estimated_time` varchar(50) NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `quotes`
--

INSERT INTO `quotes` (`quote_id`, `user_id`, `image`, `user_name`, `user_number`, `delivery_type`, `delivery_address`, `zip_code`, `other_service`, `package_size`, `package_weight`, `delivery_price`, `estimated_time`, `latitude`, `longitude`) VALUES
(4, 2, 'Upload/activity-diagram-for-banking-system-UML-650x665.png', 'User One', 12345, 'normal', 'UK HP Hospital ', 'UK00324', 'Extra sirings', '3x3', '34KG', 300, '3 hours', '51.506980', '0.069530'),
(5, 2, 'Upload/image (4).png', 'User One', 987654321, 'normal', 'UK HP Hospital ', 'UK00324', 'Extra sirings', '4x4', '33KG', 200, '4 hours', '51.506980', '0.069530'),
(7, 3, 'Upload/image (2).png', 'User Two', 12345, 'overnight', 'UK HP Hospital ', 'UK00324', 'Extra sirings', '5x5', '130 KG', 250, '7 hours', '51.506988', '0.069533');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `number` int(10) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'User',
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `number`, `email`, `password`, `user_type`, `date`, `status`) VALUES
(1, 'Adminstrator', 0, 'admin@gmail.com', 'admin', 'Admin', '2023-11-22 07:32:19', 'Active'),
(2, 'User One', 987654321, 'user1@gmail.com', '12345', 'User', '2023-11-22 07:32:42', 'Active'),
(3, 'User Two', 12345, 'user2@gmail.com', '12345', 'User', '2023-11-22 07:33:07', 'Active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`delivery_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quote_id` (`quote_id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `queries`
--
ALTER TABLE `queries`
  ADD PRIMARY KEY (`query_id`);

--
-- Indexes for table `quotes`
--
ALTER TABLE `quotes`
  ADD PRIMARY KEY (`quote_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `delivery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `queries`
--
ALTER TABLE `queries`
  MODIFY `query_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `quotes`
--
ALTER TABLE `quotes`
  MODIFY `quote_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `deliveries_ibfk_2` FOREIGN KEY (`quote_id`) REFERENCES `quotes` (`quote_id`);

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedbacks_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `quotes`
--
ALTER TABLE `quotes`
  ADD CONSTRAINT `quotes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
