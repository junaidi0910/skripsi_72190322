-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2023 at 12:28 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `72190322_skripsi`
--

-- --------------------------------------------------------

--
-- Table structure for table `isi_kompetensi`
--

CREATE TABLE `isi_kompetensi` (
  `id_isi` int(11) NOT NULL,
  `id_kompetensi` int(11) DEFAULT NULL,
  `isi_kompetensi` text,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `isi_kompetensi`
--

INSERT INTO `isi_kompetensi` (`id_isi`, `id_kompetensi`, `isi_kompetensi`, `ket`) VALUES
(1, 6, 'memahami dan menguasai materi ', '1'),
(2, 6, 'jujur', '0');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_kompetensi`
--

CREATE TABLE `jenis_kompetensi` (
  `id_kompetensi` int(11) NOT NULL,
  `nama_kompetensi` varchar(50) DEFAULT '0',
  `bobot_kompetensi` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_kompetensi`
--

INSERT INTO `jenis_kompetensi` (`id_kompetensi`, `nama_kompetensi`, `bobot_kompetensi`) VALUES
(6, 'Akademik', 50),
(8, 'Kejujuran', 50);

-- --------------------------------------------------------

--
-- Table structure for table `jenis_user`
--

CREATE TABLE `jenis_user` (
  `id_jenis_user` int(10) NOT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_user`
--

INSERT INTO `jenis_user` (`id_jenis_user`, `jabatan`, `level`) VALUES
(4, 'Kaprodi', 2),
(5, 'Dekan Fakultas', 3),
(6, 'PA/PPA', 1),
(7, 'Admin PSDM', 0);

-- --------------------------------------------------------

--
-- Table structure for table `penilai`
--

CREATE TABLE `penilai` (
  `id_penilai` int(11) NOT NULL,
  `nip` char(18) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilai`
--

INSERT INTO `penilai` (`id_penilai`, `nip`, `id_periode`) VALUES
(4, '72190333', 4),
(5, '72190458', 4),
(6, '72190788', 4),
(7, '72190322', 4);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_nilai` int(11) NOT NULL,
  `id_penilai_detail` int(11) DEFAULT NULL,
  `id_isi` int(11) DEFAULT NULL,
  `hasil_nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_nilai`, `id_penilai_detail`, `id_isi`, `hasil_nilai`) VALUES
(3, 22, 1, 4),
(4, 22, 2, 4),
(5, 28, 1, 4),
(6, 28, 2, 4),
(7, 34, 1, 4),
(8, 34, 2, 4),
(11, 23, 1, 4),
(12, 23, 2, 4),
(13, 29, 1, 4),
(14, 29, 2, 4),
(15, 35, 1, 4),
(16, 35, 2, 4),
(19, 19, 1, 4),
(20, 19, 2, 4),
(21, 25, 1, 4),
(22, 25, 2, 4),
(23, 31, 1, 4),
(24, 31, 2, 4),
(25, 40, 2, 4),
(26, 24, 1, 4),
(27, 26, 1, 4),
(28, 32, 1, 4),
(29, 37, 1, 4),
(31, 21, 1, 4),
(32, 36, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `penilai_detail`
--

CREATE TABLE `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL,
  `id_penilai` int(11) NOT NULL,
  `nip` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penilai_detail`
--

INSERT INTO `penilai_detail` (`id_penilai_detail`, `id_penilai`, `nip`) VALUES
(19, 4, '72190322'),
(20, 4, '72190458'),
(21, 4, '72190788'),
(22, 4, '2012091200113511'),
(23, 4, '2012091200113501'),
(24, 4, '72190333'),
(25, 5, '72190322'),
(26, 5, '72190333'),
(27, 5, '72190788'),
(28, 5, '2012091200113511'),
(29, 5, '2012091200113501'),
(30, 5, '72190458'),
(31, 6, '72190322'),
(32, 6, '72190333'),
(33, 6, '72190458'),
(34, 6, '2012091200113511'),
(35, 6, '2012091200113501'),
(36, 6, '72190788'),
(37, 7, '72190333'),
(38, 7, '72190458'),
(39, 7, '72190788'),
(40, 7, '2012091200113511'),
(41, 7, '2012091200113501'),
(42, 7, '72190322');

-- --------------------------------------------------------

--
-- Table structure for table `periode`
--

CREATE TABLE `periode` (
  `id_periode` int(11) NOT NULL,
  `tahun_ajar` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `status_periode` int(11) NOT NULL,
  `setting` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id_periode`, `tahun_ajar`, `semester`, `status_periode`, `setting`) VALUES
(1, '2018', 'Ganjil', 0, '50;25;25'),
(2, '2018', 'Genap', 0, '50;30;20'),
(3, '2019', 'Ganjil', 0, '50;30;20'),
(4, '2023', 'Genap', 1, '40;40;20');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nip` char(18) NOT NULL,
  `id_jenis_user` int(11) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama_ppa` varchar(100) DEFAULT NULL,
  `status_ppa` varchar(100) DEFAULT NULL,
  `alamat` text,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `status_nikah` char(1) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nip`, `id_jenis_user`, `password`, `nama_ppa`, `status_ppa`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `status_nikah`, `no_telp`) VALUES
('2012091200113500', 7, '10mg', 'Ferdy (Admin PSDM)', 'Tetap', 'Kediri Bos', 'Kediri', '1996-03-21', 'L', 'B', '0819283746378'),
('2012091200113501', 4, '10mg', 'Agum Gumelar (Kaprodi)', 'Tetap', 'Surabaya', 'Surabaya', '1996-12-21', 'L', 'N', '0819283776666'),
('2012091200113511', 5, '10mg', 'Andriasyah Putra (Dekan Fakultas)', 'Tetap', 'Kupang Panjaan', 'Surabaya', '1987-10-02', 'L', '', '088999876765'),
('72190322', 6, '10mg', 'Junaidi', 'Tetap', 'Jalan Balapan no 5', 'Singkawang', '2023-05-05', 'L', 'B', '082154379455'),
('72190333', 6, '10mg', 'I Kadek Yudiantoro', 'Tetap', 'Jalan Sutomo no 15', 'Luwuk', '2023-03-08', 'L', 'B', '089945278452'),
('72190458', 6, '10mg', 'Jascha Fabio', 'Tetap', 'Jalan Galeria No 4', 'Ambon', '2023-02-03', 'L', 'B', '082678245611'),
('72190788', 6, '10mg', 'Jeremy Wasista', 'Tetap', 'Jalan Balapan no 6', 'Pekanbaru', '1997-06-15', 'L', 'B', '082155875426');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `isi_kompetensi`
--
ALTER TABLE `isi_kompetensi`
  ADD PRIMARY KEY (`id_isi`),
  ADD KEY `id_kompetensi` (`id_kompetensi`);

--
-- Indexes for table `jenis_kompetensi`
--
ALTER TABLE `jenis_kompetensi`
  ADD PRIMARY KEY (`id_kompetensi`);

--
-- Indexes for table `jenis_user`
--
ALTER TABLE `jenis_user`
  ADD PRIMARY KEY (`id_jenis_user`);

--
-- Indexes for table `penilai`
--
ALTER TABLE `penilai`
  ADD PRIMARY KEY (`id_penilai`),
  ADD KEY `nip` (`nip`),
  ADD KEY `id_periode` (`id_periode`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_isi` (`id_isi`),
  ADD KEY `id_penilai_detail` (`id_penilai_detail`);

--
-- Indexes for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD PRIMARY KEY (`id_penilai_detail`),
  ADD KEY `id_penilai` (`id_penilai`),
  ADD KEY `nip` (`nip`);

--
-- Indexes for table `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `id_jenis_user` (`id_jenis_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `isi_kompetensi`
--
ALTER TABLE `isi_kompetensi`
  MODIFY `id_isi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jenis_kompetensi`
--
ALTER TABLE `jenis_kompetensi`
  MODIFY `id_kompetensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jenis_user`
--
ALTER TABLE `jenis_user`
  MODIFY `id_jenis_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  MODIFY `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `isi_kompetensi`
--
ALTER TABLE `isi_kompetensi`
  ADD CONSTRAINT `FK_isi_kompetensi_jenis_kompetensi` FOREIGN KEY (`id_kompetensi`) REFERENCES `jenis_kompetensi` (`id_kompetensi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilai`
--
ALTER TABLE `penilai`
  ADD CONSTRAINT `FK_penilai_periode` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilai_user` FOREIGN KEY (`nip`) REFERENCES `user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `FK_penilaian_isi_kompetensi` FOREIGN KEY (`id_isi`) REFERENCES `isi_kompetensi` (`id_isi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilaian_penilai_detail` FOREIGN KEY (`id_penilai_detail`) REFERENCES `penilai_detail` (`id_penilai_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD CONSTRAINT `FK_penilai_detail_penilai` FOREIGN KEY (`id_penilai`) REFERENCES `penilai` (`id_penilai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilai_detail_user` FOREIGN KEY (`nip`) REFERENCES `user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_jenis_user` FOREIGN KEY (`id_jenis_user`) REFERENCES `jenis_user` (`id_jenis_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
