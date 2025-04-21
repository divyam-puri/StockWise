-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 18, 2025 at 01:13 PM
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
-- Database: `StockWise`
--

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `OrderID` int(10) NOT NULL,
  `ProductID` int(10) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Quantity` int(10) DEFAULT NULL,
  `VendorID` int(10) DEFAULT NULL,
  `Amount` float DEFAULT NULL,
  `BillAmt` float DEFAULT NULL,
  `OrderType` varchar(100) NOT NULL,
  `UserID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`OrderID`, `ProductID`, `Name`, `Quantity`, `VendorID`, `Amount`, `BillAmt`, `OrderType`, `UserID`) VALUES
(1, 1, 'iPhone15', 1, 1, 60199, 60199, 'sales', 1),
(2, 2, 'iPhone 16', 1, 1, 67999, 67999, 'sales', 1),
(3, 1, 'iPhone 15', 5, NULL, 61999, 309995, 'sales', 1),
(4, 1, 'iPhone 15', 5, NULL, 61999, 309995, 'sales', 1),
(5, 2, 'iPhone 16', 10, NULL, 67999, 679990, 'sales', 1),
(6, 1, 'iPhone 15', 5, 1, 60999, 304995, 'purchase', 1),
(7, 1, 'iPhone 15', 2, NULL, 60199, 120398, 'sales', 1),
(8, 2, 'iPhone 16', 1, NULL, 67999, 67999, 'sales', 1),
(9, 2, 'iPhone 16', 2, 1, 65999, 131998, 'purchase', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `ProductID` int(10) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `SKU` varchar(100) NOT NULL,
  `SP` float NOT NULL,
  `PP` float NOT NULL,
  `Inventory` int(10) NOT NULL,
  `Location` varchar(10) NOT NULL,
  `Description` varchar(1000) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `Name`, `SKU`, `SP`, `PP`, `Inventory`, `Location`, `Description`, `UserID`) VALUES
(1, 'iPhone 15', 'ABC123', 60199, 59999, 13, 'A001', 'Apple iPhone 15 128 GB', 1),
(2, 'iPhone 16', 'ABC235', 67999, 65999, 11, 'A002', 'Apple iPhone 16 128 GB', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(10) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `BuisnessName` varchar(1000) NOT NULL,
  `BuisnessType` varchar(100) NOT NULL,
  `GSTIN` varchar(100) DEFAULT NULL,
  `Category` varchar(100) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` varchar(1000) NOT NULL,
  `PhoneNumber` bigint(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `BuisnessName`, `BuisnessType`, `GSTIN`, `Category`, `Email`, `Password`, `PhoneNumber`) VALUES
(1, 'Divyam Puri', 'MobiDecor', 'sole_proprietorship', '', 'Electronics', 'divyampu@gmail.com', '$2y$10$BhEiTN1xil25ZNUC5CFFD.a5jgL9HOwfsHY3kvh0v2Gg0LK95lO2C', 6284908998),
(2, 'Lavish', 'Haibhowal', 'pvt_llp', '', 'others', 'divyampuri1634@gmail.com', '$2y$10$58MAXi62BcU3Kxmc7SPgmuXYkO7mybnQpiMobbkrdjK4hvduhN/Mq', 7009364562),
(3, 'Gundeep', 'Deep Enterprises', 'sole_proprietorship', '', 'electronics', 'gundeeparora66@gmail.com', '$2y$10$eUz/DoXaXOX6ykxgxmPo4evppGhgYuwf4HJuZvNdppkiPIhKi6a.6', 6239849816);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `VendorID` int(10) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Number` bigint(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `UserID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`VendorID`, `Name`, `Number`, `Email`, `UserID`) VALUES
(1, 'Divyam', 6284908998, 'divyampu@gmail.com', 1),
(2, 'Lavish', 7009364562, 'divyampuri1634@gmail.com', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`OrderID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`ProductID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`VendorID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `OrderID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `ProductID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `VendorID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
