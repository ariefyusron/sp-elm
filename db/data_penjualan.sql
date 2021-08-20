-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2021 at 03:27 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `data_penjualan`
--

-- --------------------------------------------------------

--
-- Table structure for table `data_bulan`
--

CREATE TABLE `data_bulan` (
  `no` int(5) NOT NULL,
  `tahun` varchar(11) NOT NULL,
  `bulan` varchar(50) NOT NULL,
  `jumlah` int(50) NOT NULL,
  `pendapatan` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_bulan`
--

INSERT INTO `data_bulan` (`no`, `tahun`, `bulan`, `jumlah`, `pendapatan`) VALUES
(1, '2020', 'Juli', 1822, 44281623),
(2, '2020', 'Agustus', 2047, 47383248),
(3, '2020', 'September', 1972, 44725575),
(4, '2020', 'Oktober', 2100, 48571069),
(5, '2020', 'November', 2034, 46780811),
(6, '2020', 'Desember', 2189, 49438404),
(7, '2021', 'Januari', 1914, 44035580);

-- --------------------------------------------------------

--
-- Table structure for table `data_hari`
--

CREATE TABLE `data_hari` (
  `no` int(5) NOT NULL,
  `tanggal` varchar(50) NOT NULL,
  `jumlah` int(25) NOT NULL,
  `pendapatan` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `data_hari`
--

INSERT INTO `data_hari` (`no`, `tanggal`, `jumlah`, `pendapatan`) VALUES
(1, '07/01/2020', 53, 1218000),
(2, '07/02/2020', 38, 873000),
(3, '07/03/2020', 45, 1028000),
(4, '07/04/2020', 71, 1628000),
(5, '07/05/2020', 77, 1769000),
(6, '07/06/2020', 27, 620000),
(7, '07/07/2020', 73, 1678000),
(8, '07/08/2020', 51, 1175000),
(9, '07/09/2020', 59, 1380000),
(10, '07/10/2020', 63, 1454000),
(11, '07/11/2020', 71, 1633000),
(12, '07/12/2020', 90, 2058000),
(13, '07/13/2020', 49, 1122850),
(14, '07/14/2020', 55, 1269675),
(15, '07/15/2020', 74, 1475575),
(16, '07/16/2020', 50, 1149200),
(17, '07/17/2020', 61, 2013975),
(18, '07/18/2020', 61, 1392725),
(19, '07/19/2020', 64, 1478850),
(20, '07/20/2020', 45, 1038550),
(21, '07/21/2020', 59, 1259400),
(22, '07/22/2020', 70, 1604950),
(23, '07/23/2020', 56, 2453415),
(24, '07/24/2020', 50, 2051965),
(25, '07/25/2020', 86, 1964235),
(26, '07/26/2020', 81, 1865965),
(27, '07/27/2020', 70, 1630020),
(28, '07/28/2020', 60, 1382868),
(29, '07/29/2020', 49, 1139115),
(30, '07/30/2020', 39, 899290),
(31, '07/31/2020', 25, 575000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `data_bulan`
--
ALTER TABLE `data_bulan`
  ADD PRIMARY KEY (`no`);

--
-- Indexes for table `data_hari`
--
ALTER TABLE `data_hari`
  ADD PRIMARY KEY (`no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `data_bulan`
--
ALTER TABLE `data_bulan`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `data_hari`
--
ALTER TABLE `data_hari`
  MODIFY `no` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
