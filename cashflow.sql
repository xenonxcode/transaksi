-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 06, 2024 at 08:49 AM
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
-- Database: `cashflow`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `kode_customer` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telpon` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kurirs`
--

CREATE TABLE `kurirs` (
  `id_kurir` int(11) NOT NULL,
  `kode_kurir` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telpon` varchar(20) DEFAULT NULL,
  `nomor_rekening` varchar(30) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `aras_nama` varchar(255) DEFAULT NULL,
  `nama_brosur` varchar(100) DEFAULT NULL,
  `id_tl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `resellers`
--

CREATE TABLE `resellers` (
  `id_reseller` int(11) NOT NULL,
  `kode_reseller` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telpon` varchar(20) DEFAULT NULL,
  `nomor_rekening` varchar(30) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `aras_nama` varchar(255) DEFAULT NULL,
  `nama_brosur` varchar(100) DEFAULT NULL,
  `id_tl` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sales_counters`
--

CREATE TABLE `sales_counters` (
  `id` int(11) NOT NULL,
  `kode_sc` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telpon` varchar(20) DEFAULT NULL,
  `nomor_rekening` varchar(30) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `atas_nama` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(11) NOT NULL,
  `kode_supplier` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telpon` varchar(20) DEFAULT NULL,
  `daerah` varchar(100) DEFAULT NULL,
  `hewan_qurban` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `team_leaders`
--

CREATE TABLE `team_leaders` (
  `id_tl` int(11) NOT NULL,
  `kode_tl` varchar(20) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `no_telpon` varchar(20) DEFAULT NULL,
  `nomor_rekening` varchar(30) DEFAULT NULL,
  `bank` varchar(100) DEFAULT NULL,
  `aras_nama` varchar(255) DEFAULT NULL,
  `nama_brosur` varchar(100) DEFAULT NULL,
  `jumlah_reseller` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kurirs`
--
ALTER TABLE `kurirs`
  ADD PRIMARY KEY (`id_kurir`),
  ADD KEY `id_tl` (`id_tl`);

--
-- Indexes for table `resellers`
--
ALTER TABLE `resellers`
  ADD PRIMARY KEY (`id_reseller`),
  ADD KEY `id_tl` (`id_tl`);

--
-- Indexes for table `sales_counters`
--
ALTER TABLE `sales_counters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team_leaders`
--
ALTER TABLE `team_leaders`
  ADD PRIMARY KEY (`id_tl`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kurirs`
--
ALTER TABLE `kurirs`
  MODIFY `id_kurir` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resellers`
--
ALTER TABLE `resellers`
  MODIFY `id_reseller` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sales_counters`
--
ALTER TABLE `sales_counters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `team_leaders`
--
ALTER TABLE `team_leaders`
  MODIFY `id_tl` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kurirs`
--
ALTER TABLE `kurirs`
  ADD CONSTRAINT `kurirs_ibfk_1` FOREIGN KEY (`id_tl`) REFERENCES `team_leaders` (`id_tl`);

--
-- Constraints for table `resellers`
--
ALTER TABLE `resellers`
  ADD CONSTRAINT `resellers_ibfk_1` FOREIGN KEY (`id_tl`) REFERENCES `team_leaders` (`id_tl`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
