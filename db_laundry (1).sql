-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 27, 2025 at 12:04 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laundry`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis`
--

CREATE TABLE `tb_jenis` (
  `kd_jenis` int NOT NULL,
  `jenis_laundry` varchar(100) NOT NULL,
  `lama_proses` int NOT NULL,
  `tarif` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_jenis`
--

INSERT INTO `tb_jenis` (`kd_jenis`, `jenis_laundry`, `lama_proses`, `tarif`) VALUES
(1, 'Laundry + Seterika', 3, 7000),
(2, 'Fast Laundry', 1, 10000),
(12, 'Regular', 2, 6000),
(13, 'Cuci Karpet', 3, 10000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laporan`
--

CREATE TABLE `tb_laporan` (
  `id_laporan` int NOT NULL,
  `tgl_laporan` date NOT NULL,
  `ket_laporan` int NOT NULL,
  `catatan` text NOT NULL,
  `id_laundry` char(10) DEFAULT NULL,
  `pemasukan` int NOT NULL,
  `id_pengeluaran` char(10) DEFAULT NULL,
  `pengeluaran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_laporan`
--

INSERT INTO `tb_laporan` (`id_laporan`, `tgl_laporan`, `ket_laporan`, `catatan`, `id_laundry`, `pemasukan`, `id_pengeluaran`, `pengeluaran`) VALUES
(18, '2022-01-09', 2, 'Beli deterjen', NULL, 0, 'PG-0001', 100000),
(27, '2022-01-11', 2, 'service mesin cuci', NULL, 0, 'PG-0003', 200000),
(28, '2022-01-09', 1, '5 baju, 5 celana levis', 'LD-0001', 70000, NULL, 0),
(29, '2022-01-09', 1, '10 kemeja, 2 celana training', 'LD-0002', 100000, NULL, 0),
(30, '2022-01-09', 1, 'Karpet 20kg', 'LD-0003', 200000, NULL, 0),
(31, '2022-01-09', 1, '2 celana, 3 baju, 2 kaus', 'LD-0005', 35000, NULL, 0),
(32, '2022-01-10', 2, 'Membeli pemutih pakaian', NULL, 0, 'PG-0004', 50000),
(33, '1221-02-12', 2, '121121', NULL, 0, 'PG-0011', 12000),
(34, '2025-07-12', 2, 'Beli beras untuk jumat berkahh', NULL, 0, 'PG-0012', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_laundry`
--

CREATE TABLE `tb_laundry` (
  `id_laundry` char(10) NOT NULL,
  `pelangganid` int NOT NULL,
  `userid` int NOT NULL,
  `kd_jenis` char(6) NOT NULL,
  `tgl_terima` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `jml_kilo` int NOT NULL,
  `catatan` text NOT NULL,
  `totalbayar` int NOT NULL,
  `status_pembayaran` int NOT NULL,
  `status_pengambilan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_laundry`
--

INSERT INTO `tb_laundry` (`id_laundry`, `pelangganid`, `userid`, `kd_jenis`, `tgl_terima`, `tgl_selesai`, `jml_kilo`, `catatan`, `totalbayar`, `status_pembayaran`, `status_pengambilan`) VALUES
('LD-0001', 5, 27, '1', '2022-01-09', '2022-01-12', 10, '5 baju, 5 celana levis', 70000, 1, 1),
('LD-0002', 3, 27, '2', '2022-01-09', '2022-01-10', 10, '10 kemeja, 2 celana training', 100000, 1, 0),
('LD-0003', 5, 27, '13', '2022-01-09', '2022-01-12', 20, 'Karpet 20kg', 200000, 1, 0),
('LD-0004', 9, 27, '12', '2022-01-09', '2022-01-11', 9, '14 kaus', 54000, 0, 0),
('LD-0005', 9, 27, '1', '2022-01-09', '2022-01-12', 5, '2 celana, 3 baju, 2 kaus', 35000, 1, 0),
('LD-0006', 3, 28, '1', '2025-09-25', '2025-09-28', 5, 'jfje', 35000, 1, 0),
('LD-0007', 3, 28, '1', '2025-09-25', '2025-09-28', 2, 'ew', 14000, 0, 0),
('LD-0008', 15, 40, '1', '2025-10-06', '2025-10-09', 2, 'cks', 14000, 1, 1),
('LD-0009', 24, 47, '2', '2025-10-20', '2025-10-21', 4, 'proses', 40000, 1, 1),
('LD-0010', 23, 47, '12', '2025-10-20', '2025-10-22', 2, 'cihuy', 12000, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `pelangganid` int NOT NULL,
  `pelanggannama` varchar(150) NOT NULL,
  `pelangganjk` varchar(15) NOT NULL,
  `pelangganalamat` text NOT NULL,
  `pelanggantelp` varchar(20) NOT NULL,
  `pelangganfoto` varchar(100) DEFAULT NULL,
  `pelanggantgl_lahir` date DEFAULT NULL,
  `pelangganemail` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`pelangganid`, `pelanggannama`, `pelangganjk`, `pelangganalamat`, `pelanggantelp`, `pelangganfoto`, `pelanggantgl_lahir`, `pelangganemail`) VALUES
(23, '1221', 'Laki - laki', 'sasa', '123', NULL, '2026-01-14', 'sabilulbily@gmail.com'),
(24, 'fawwas', 'Laki - laki', 'rumah', '08302', NULL, '2025-10-16', 'admin@filamentphp.com');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengeluaran`
--

CREATE TABLE `tb_pengeluaran` (
  `id_pengeluaran` char(10) NOT NULL,
  `tgl_pengeluaran` date NOT NULL,
  `catatan` text NOT NULL,
  `pengeluaran` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_pengeluaran`
--

INSERT INTO `tb_pengeluaran` (`id_pengeluaran`, `tgl_pengeluaran`, `catatan`, `pengeluaran`) VALUES
('PG-0008', '0001-12-12', '2121', 21),
('PG-0009', '0121-02-12', '21', 12),
('PG-0010', '0121-02-12', '212121', 212121),
('PG-0011', '1221-02-12', '121121', 12000),
('PG-0012', '2025-07-12', 'Beli beras untuk jumat berkahh', 150000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `userid` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `userpass` varchar(100) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `jk` varchar(15) NOT NULL,
  `alamat` text NOT NULL,
  `usertelp` varchar(20) NOT NULL,
  `userfoto` varchar(255) DEFAULT NULL,
  `level` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`userid`, `username`, `userpass`, `nama`, `jk`, `alamat`, `usertelp`, `userfoto`, `level`) VALUES
(33, 'shlv', '$2y$10$Ep1N6966FSG4LJM57Lr9qO.JjV6sOvihajybybgL.4seVQ48OT8By', 'shelvi dwi', 'Perempuan', 'malang', '07231', '68dd1939b1a5f.jpg', 'admin'),
(40, 'cnd', '$2y$10$uhg9TYsmMuQINa79aBMWkufW2Nk.Bv7WtHqNSuE65FoiCPR8gCMV2', 'conrad', 'Perempuan', 'mlg', '13', '68dd21eb6b119.jpg', 'kasir'),
(47, '123123', '$2y$10$2hMV02mv4IKISRovony1u.358/eyX8aYr79x02FEBAZNGu0yYW5y2', '123123', 'Laki - laki', '123123', '123123', '68f484f928843.jpeg', 'kasir');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  ADD PRIMARY KEY (`kd_jenis`);

--
-- Indexes for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indexes for table `tb_laundry`
--
ALTER TABLE `tb_laundry`
  ADD PRIMARY KEY (`id_laundry`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`pelangganid`);

--
-- Indexes for table `tb_pengeluaran`
--
ALTER TABLE `tb_pengeluaran`
  ADD PRIMARY KEY (`id_pengeluaran`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_jenis`
--
ALTER TABLE `tb_jenis`
  MODIFY `kd_jenis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tb_laporan`
--
ALTER TABLE `tb_laporan`
  MODIFY `id_laporan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `pelangganid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
