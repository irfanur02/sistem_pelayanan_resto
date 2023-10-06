-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2023 at 05:53 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sistem_pelayanan_resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `antrian_masak`
--

CREATE TABLE `antrian_masak` (
  `id_antrian_masak` int(11) NOT NULL,
  `id_meja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `antrian_masak`
--

INSERT INTO `antrian_masak` (`id_antrian_masak`, `id_meja`) VALUES
(41, 1),
(42, 1),
(43, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(53, 1),
(54, 1),
(44, 2),
(52, 2);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_antrian_masak` int(11) DEFAULT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status_pesanan` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_antrian_masak`, `id_pesanan`, `id_menu`, `jumlah`, `status_pesanan`) VALUES
(47, 97, 1, 1, '3'),
(47, 97, 10, 1, '3'),
(48, 98, 5, 2, '3'),
(48, 98, 9, 2, '3'),
(48, 98, 8, 1, '3'),
(49, 98, 7, 1, '3'),
(50, 98, 6, 1, '3'),
(51, 99, 10, 1, '3'),
(52, 100, 6, 1, '3'),
(53, 101, 1, 1, '3'),
(54, 102, 1, 1, '3'),
(54, 102, 7, 1, '3');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_menu`
--

CREATE TABLE `kategori_menu` (
  `id_kategori_menu` int(11) NOT NULL,
  `nama_kategori_menu` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori_menu`
--

INSERT INTO `kategori_menu` (`id_kategori_menu`, `nama_kategori_menu`) VALUES
(1, 'Makanan'),
(2, 'Minuman');

-- --------------------------------------------------------

--
-- Table structure for table `meja`
--

CREATE TABLE `meja` (
  `id_meja` int(11) NOT NULL,
  `no_meja` char(2) NOT NULL,
  `status_ketersedian` char(1) NOT NULL,
  `tanggal_reservasi` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `meja`
--

INSERT INTO `meja` (`id_meja`, `no_meja`, `status_ketersedian`, `tanggal_reservasi`) VALUES
(1, '1', '2', NULL),
(2, '2', '2', NULL),
(3, '3', '0', NULL),
(4, '4', '0', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) NOT NULL,
  `gambar_menu` varchar(255) NOT NULL,
  `id_kategori_menu` int(11) NOT NULL,
  `harga_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `gambar_menu`, `id_kategori_menu`, `harga_menu`) VALUES
(1, 'Nasi Goreng', 'nasi goreng.jpg', 1, 20000),
(4, 'Mie Hun', 'mie hun.jpg', 1, 15000),
(5, 'Cupcay', 'cupcay.jpg', 1, 15000),
(6, 'Mie Goreng', 'mie goreng.jpg', 1, 12000),
(7, 'Es Campur', 'es campur.jpg', 2, 7000),
(8, 'Es Jelly Susu', 'es jelly susu.jpg', 2, 6000),
(9, 'Es Jeruk', 'es jeruk.jpg', 2, 5000),
(10, 'Es Teh', 'es teh.jpg', 2, 4000);

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `tanggal_pembayaran` datetime NOT NULL,
  `model_pembayaran` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pesanan`, `id_user`, `tanggal_pembayaran`, `model_pembayaran`) VALUES
(8, 85, NULL, '2023-09-18 15:35:57', 1),
(13, 97, NULL, '2023-09-20 00:00:00', 1),
(14, 98, NULL, '2023-09-20 00:00:00', 1),
(15, 99, NULL, '2023-09-20 00:00:00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_meja` int(11) NOT NULL,
  `token` char(11) DEFAULT NULL,
  `pesanan_session` char(1) NOT NULL,
  `tanggal_pesanan` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_meja`, `token`, `pesanan_session`, `tanggal_pesanan`) VALUES
(26, 2, '!7C_cvCNw%e', '', '2023-09-11 15:49:33'),
(29, 2, 'cWAYwVk7$tE', '', NULL),
(31, 1, 'Kai6r-M^^1X', '', '2023-09-11 17:09:26'),
(33, 2, '4mG4)NS^!z*', '', '2023-09-12 00:16:24'),
(34, 1, 'fO(kBvLbT03', '', '2023-09-12 00:18:28'),
(35, 3, 'H1g-nmx!Q9f', '', '2023-09-12 00:28:19'),
(39, 2, 'dC@#r6tbi@P', '', NULL),
(40, 1, 'V06$Cx7a5yA', '', '2023-09-12 14:48:18'),
(41, 1, 'dxybvXffUAg', '', '2023-09-13 13:12:08'),
(46, 2, 'HcchxF*yH=X', '', '2023-09-13 14:00:28'),
(64, 1, 'zH66lDfPFQ=', '', '2023-09-14 15:26:24'),
(79, 1, 'zH66lDfPFQ=', '', '2023-09-15 00:01:19'),
(80, 1, 'zH66lDfPFQ=', '', '2023-09-16 00:14:01'),
(81, 2, '*SDh)0cEB!J', '', '2023-09-16 13:36:54'),
(82, 1, 'zH66lDfPFQ=', '', '2023-09-17 12:44:16'),
(83, 2, 'aQ5ve#8_Faz', '', '2023-09-17 13:56:17'),
(84, 2, '5A!A!m8Fsso', '', '2023-09-17 19:48:10'),
(85, 1, 'zH66lDfPFQ=', '', '2023-09-18 14:04:51'),
(93, 1, 'zH66lDfPFQ=', '', '2023-09-18 21:24:49'),
(94, 1, 'zH66lDfPFQ=', '', '2023-09-18 21:30:28'),
(95, 1, 'zH66lDfPFQ=', '', '2023-09-18 21:30:32'),
(97, 1, 'zH66lDfPFQ=', '', '2023-09-20 14:39:07'),
(98, 1, 'zH66lDfPFQ=', '', '2023-09-20 15:56:02'),
(99, 1, 'zH66lDfPFQ=', '', '2023-09-20 21:38:40'),
(100, 2, '3)J=O*(OQTC', '', '2023-09-20 23:23:30'),
(101, 1, 'zH66lDfPFQ=', '', '2023-09-20 23:39:56'),
(102, 1, 'zH66lDfPFQ=', '', '2023-09-21 15:55:30');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(100) NOT NULL,
  `no_hp` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antrian_masak`
--
ALTER TABLE `antrian_masak`
  ADD PRIMARY KEY (`id_antrian_masak`),
  ADD KEY `id_meja` (`id_meja`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_antrian_masak` (`id_antrian_masak`);

--
-- Indexes for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  ADD PRIMARY KEY (`id_kategori_menu`);

--
-- Indexes for table `meja`
--
ALTER TABLE `meja`
  ADD PRIMARY KEY (`id_meja`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_kategori_menu` (`id_kategori_menu`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pesanan` (`id_pesanan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `id_meja` (`id_meja`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antrian_masak`
--
ALTER TABLE `antrian_masak`
  MODIFY `id_antrian_masak` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `kategori_menu`
--
ALTER TABLE `kategori_menu`
  MODIFY `id_kategori_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `meja`
--
ALTER TABLE `meja`
  MODIFY `id_meja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `antrian_masak`
--
ALTER TABLE `antrian_masak`
  ADD CONSTRAINT `antrian_masak_ibfk_1` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`);

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`),
  ADD CONSTRAINT `detail_pesanan_ibfk_3` FOREIGN KEY (`id_antrian_masak`) REFERENCES `antrian_masak` (`id_antrian_masak`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_kategori_menu`) REFERENCES `kategori_menu` (`id_kategori_menu`);

--
-- Constraints for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`),
  ADD CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_meja`) REFERENCES `meja` (`id_meja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
