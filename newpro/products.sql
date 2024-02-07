-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 27, 2023 at 04:45 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 7.4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pharma`
--

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `medicineName` varchar(250) NOT NULL,
  `product_type` varchar(250) NOT NULL,
  `product_dose` varchar(250) NOT NULL,
  `addiinfo` varchar(250) NOT NULL,
  `manudate` varchar(250) NOT NULL,
  `expdate` varchar(250) NOT NULL,
  `quantity` varchar(250) NOT NULL,
  `price` varchar(250) NOT NULL,
  `suppliername` varchar(250) NOT NULL,
  `reorderlevel` varchar(250) NOT NULL,
  `description` varchar(500) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6),
  `supplier_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `medicineName`, `product_type`, `product_dose`, `addiinfo`, `manudate`, `expdate`, `quantity`, `price`, `suppliername`, `reorderlevel`, `description`, `created_at`, `supplier_status`) VALUES
(85, 'LKV', 'Test001', '100mg', 'COMMECT', '2023-10-10', '2023-10-25', '10', '300', '5', '100', 'NO', '2023-10-26 07:39:14.185130', 1),
(86, 'LKNBBBB', 'Test001', '100mg', 'COMMECT SECOND', '2023-10-10', '2023-10-27', '0', '300', '5', '100', 'NO', '2023-10-26 07:42:43.376539', 1),
(87, 'newid test', 'Test001', '100mg', 'COMMEC 2', '2023-10-03', '2023-10-28', '10', '50', '5', '300', 'no', '2023-10-26 08:31:20.297319', 1),
(88, 'newid test', 'Test001', '100mg', 'COMMEC 2', '2023-10-03', '2023-10-28', '10', '50', '5', '300', 'no', '2023-10-26 08:32:47.565765', 1),
(89, '', 'Option 1', 'Option 1', '', '', '', '', '', 'Option 1', '', '', '2023-10-27 05:41:49.442006', NULL),
(90, '', 'Option 1', 'Option 1', '', '', '', '', '', 'Option 1', '', '', '2023-10-27 05:41:49.448777', NULL),
(91, 'dgdg', 'Test001', '100mg', 'sf', '2023-10-16', '2023-10-25', '425', '41254', '3', '42', '42fgrf', '2023-10-27 14:31:52.893244', NULL),
(92, 'dgdg', 'Test001', '100mg', 'sf', '2023-10-16', '2023-10-25', '425', '41254', '3', '42', '42fgrf', '2023-10-27 14:43:49.653149', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
