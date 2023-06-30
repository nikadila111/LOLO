-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 30, 2023 at 04:53 AM
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
-- Database: `crudoperation`
--

-- --------------------------------------------------------

--
-- Table structure for table `CRUD`
--

CREATE TABLE `CRUD` (
  `id` int(11) NOT NULL,
  `IC number` varchar(12) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `CRUD`
--

INSERT INTO `CRUD` (`id`, `IC number`, `name`, `email`, `mobile`) VALUES
(1, '000504030730', 'Adila', 'nikadila0405@gmail.com', '01119818176'),
(5, '640120039876', 'Nornazila Othman', 'norna@gmail.com', '0139847699'),
(10, '090909030730', 'Kiyo Tuna', 'kiyo@gmail.com', '01111876523');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `petId` int(11) NOT NULL,
  `petName` varchar(255) DEFAULT NULL,
  `petColor` varchar(255) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `vaccineCard` longblob DEFAULT NULL,
  `catImage` longblob DEFAULT NULL,
  `clinicName` varchar(255) NOT NULL,
  `clinicPhone` varchar(20) NOT NULL,
  `customer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`petId`, `petName`, `petColor`, `birthdate`, `vaccineCard`, `catImage`, `clinicName`, `clinicPhone`, `customer_id`) VALUES
(5, 'tobiii', 'orange', '2021-09-01', 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 'klinik kk', '097657699', 5),
(6, 'Miko', 'Gray', '2021-03-01', 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 'Klinik KK', '097657699', 1),
(7, 'Cindy', 'tortoishell', '2008-12-01', 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 'klinik kota', '097657699', 10),
(8, 'milli', 'gray', '2022-12-01', 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 0x53637265656e73686f7420323032332d30362d313320617420312e35362e353620414d2e706e67, 'Klinik KK', '097657699', 10),
(11, 'MM', 'LOS', '2023-09-01', 0x53637265656e73686f7420323032332d30362d313920617420332e31332e323020504d2e706e67, 0x53637265656e73686f7420323032332d30362d313920617420352e35362e343820504d2e706e67, 'Klinik KK', '0122330056', 1),
(12, 'LL', 'gray', '2023-10-01', 0x53637265656e73686f7420323032332d30362d313920617420352e35392e343020504d2e706e67, 0x53637265656e73686f7420323032332d30362d313920617420352e32302e303720504d2e706e67, 'LL', '0122330056', 1),
(13, 'Kiyo', 'black', '2023-11-01', 0x53637265656e73686f7420323032332d30362d313920617420332e31332e323020504d2e706e67, 0x53637265656e73686f7420323032332d30362d313920617420352e35392e343020504d2e706e67, 'klinik kota', '0122330056', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `CRUD`
--
ALTER TABLE `CRUD`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `IC number` (`IC number`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`petId`),
  ADD KEY `customer_id` (`customer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `CRUD`
--
ALTER TABLE `CRUD`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `petId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `crud` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
