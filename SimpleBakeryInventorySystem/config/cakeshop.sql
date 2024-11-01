-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 04:39 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cakeshop`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `ContactNumber` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `date_added` datetime(6) NOT NULL,
  `archive` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_type`, `quantity`, `price`, `date_added`, `archive`) VALUES
(36, 'Cookies', '0', '1000', '2024-10-24 18:52:50.000000', 'yes'),
(38, 'Cake', '230', '2323', '2024-10-24 19:23:00.000000', 'no'),
(39, 'Bread', '0', '23', '2024-10-24 19:23:04.000000', 'yes'),
(40, 'Cookies', '229', '233', '2024-10-24 19:41:51.000000', 'no'),
(41, 'Bread', '67', '67000000000', '2024-10-24 20:04:25.000000', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_history`
--

CREATE TABLE `transaction_history` (
  `id` int(11) NOT NULL,
  `product_type` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `transaction_date` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_history`
--

INSERT INTO `transaction_history` (`id`, `product_type`, `quantity`, `transaction_date`, `price`, `total_amount`) VALUES
(37, 'Cookies', '4', '2024-10-24 19:23:12', '13', '52'),
(38, 'Cake', '2', '2024-10-24 19:23:09', '2323', '4646'),
(39, 'Bread', '1', '2024-10-24 19:23:06', '23', '23'),
(40, 'Bread', '1', '2024-10-24 19:26:38', '23', '23'),
(41, 'Bread', '23', '2024-10-24 19:26:44', '23', '529'),
(42, 'Bread', '2273', '2024-10-24 19:27:03', '23', '52279'),
(43, 'Cake', '1', '2024-10-24 19:42:16', '2323', '2323'),
(44, 'Cake', '1', '2024-10-24 19:53:11', '2323', '2323'),
(45, 'Cake', '1', '2024-10-24 19:53:15', '2323', '2323'),
(46, 'Cookies', '3', '2024-10-24 19:53:27', '233', '699');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_history`
--
ALTER TABLE `transaction_history`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transaction_history`
--
ALTER TABLE `transaction_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
