-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2023 at 08:50 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `isi_penilaian`
--

CREATE TABLE `isi_penilaian` (
  `id_isi` int(11) NOT NULL,
  `id_kelpenilaian` int(11) DEFAULT NULL,
  `isi_penilaian` text DEFAULT NULL,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `isi_penilaian`
--

INSERT INTO `isi_penilaian` (`id_isi`, `id_kelpenilaian`, `isi_penilaian`, `ket`) VALUES
(3, 9, 'Ketaatan', '0'),
(4, 9, 'Tanggung Jawab', '0'),
(5, 9, 'Kesetiaan', '0'),
(6, 9, 'Kejujuran', '0'),
(7, 10, 'Sikap Kerja (Kerja sama)', '0'),
(8, 10, 'Prakarsa', '0'),
(9, 10, 'Prestasi', '0'),
(10, 10, 'Pengabdian Masyarakat', '0'),
(11, 12, 'nilai 1', '1'),
(12, 12, 'nilai 2', '1'),
(13, 12, 'nilai 3', '1'),
(14, 12, 'nilai 4', '1'),
(15, 10, 'test', '0,1');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_user`
--

CREATE TABLE `jenis_user` (
  `id_jenis_user` int(10) NOT NULL,
  `jabatan` varchar(40) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `jenis_user`
--

INSERT INTO `jenis_user` (`id_jenis_user`, `jabatan`, `level`) VALUES
(4, 'Pejabat Penilai', 2),
(5, 'PA/PPA', 1),
(7, 'Admin PSDM', 0),
(8, 'Atasan Pejabat Penilai', 3);

-- --------------------------------------------------------

--
-- Table structure for table `kelompok_penilaian`
--

CREATE TABLE `kelompok_penilaian` (
  `id_kelpenilaian` int(11) NOT NULL,
  `nama_kelpenilaian` varchar(50) DEFAULT '0',
  `bobot_kelpenilaian` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kelompok_penilaian`
--

INSERT INTO `kelompok_penilaian` (`id_kelpenilaian`, `nama_kelpenilaian`, `bobot_kelpenilaian`) VALUES
(9, 'Kedisplinan', ''),
(10, 'Kapabilitas', ''),
(12, 'Rekan Kerja', '');

-- --------------------------------------------------------

--
-- Table structure for table `penilai`
--

CREATE TABLE `penilai` (
  `id_penilai` int(11) NOT NULL,
  `nip` char(18) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penilai`
--

INSERT INTO `penilai` (`id_penilai`, `nip`, `id_periode`) VALUES
(2, '2012091200113511', 4),
(17, '72190377', 4);

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_nilai` int(11) NOT NULL,
  `id_penilai_detail` int(11) DEFAULT NULL,
  `id_isi` int(11) DEFAULT NULL,
  `hasil_nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penilaian`
--

INSERT INTO `penilaian` (`id_nilai`, `id_penilai_detail`, `id_isi`, `hasil_nilai`) VALUES
(100, 54, 11, 12),
(101, 54, 12, 12),
(102, 54, 13, 12),
(103, 54, 14, 12);

-- --------------------------------------------------------

--
-- Table structure for table `penilai_detail`
--

CREATE TABLE `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL,
  `id_penilai` int(11) NOT NULL,
  `nip` char(16) NOT NULL,
  `status` int(1) DEFAULT NULL,
  `pesan` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `penilai_detail`
--

INSERT INTO `penilai_detail` (`id_penilai_detail`, `id_penilai`, `nip`, `status`, `pesan`) VALUES
(11, 2, '2012091200113501', NULL, NULL),
(47, 2, '2012091200113501', NULL, NULL),
(48, 2, '72190456', NULL, NULL),
(49, 2, '72190322', NULL, NULL),
(50, 2, '72190678', NULL, NULL),
(51, 2, '72190377', NULL, NULL),
(52, 17, '2012091200113501', NULL, NULL),
(53, 17, '2012091200113511', NULL, NULL),
(54, 17, '72190322', 1, 'test'),
(55, 17, '72190456', NULL, NULL),
(56, 17, '72190678', NULL, NULL);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `periode`
--

INSERT INTO `periode` (`id_periode`, `tahun_ajar`, `semester`, `status_periode`, `setting`) VALUES
(1, '2018', 'Ganjil', 0, ''),
(2, '2018', 'Genap', 0, ''),
(3, '2019', 'Ganjil', 0, ''),
(4, '2023', 'Genap', 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `nip` char(18) NOT NULL,
  `id_jenis_user` int(11) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `nama_ppa` varchar(100) DEFAULT NULL,
  `golongan` varchar(100) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `unit_organisasi` varchar(100) DEFAULT NULL,
  `status_ppa` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `jenis_kelamin` char(1) DEFAULT NULL,
  `status_nikah` char(1) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`nip`, `id_jenis_user`, `password`, `nama_ppa`, `golongan`, `jabatan`, `unit_organisasi`, `status_ppa`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `status_nikah`, `no_telp`) VALUES
('2012091200113500', 7, '10mg', 'Ferdy (Admin PSDM)', 'ppa', 'Dosen', 'fakultas TI', 'Tetap', 'Kediri Bos', 'Kediri', '1996-03-21', 'L', 'B', '0819283746378'),
('2012091200113501', 4, '10mg', 'Agum Gumelar (Pejabat Penilai)', 'golongan A', 'dosen biasa', 'fakultas TI', 'Tetap', 'Surabaya', 'Surabaya', '1996-12-21', 'L', 'N', '0819283776666'),
('2012091200113511', 5, '10mg', 'Andriasyah Putra (PA)', 'Test', 'Test2', 'Test3', 'Tetap', 'Kupang Panjaan', 'Surabaya', '1987-10-02', 'L', '', '088999876765'),
('2012091200113599', 8, '10mg', 'Firdaus (Atasan)', 'karyaa', 'wakil kaprodi', 'fakultas TI', 'Tetap', 'jalan alianyang', 'Pontianak', '2023-10-12', 'L', 'B', '082166835690'),
('72190322', 5, '10mg', 'Junaidi', 'Pembina Utama', 'Dosen', 'Fakultas Teknologi Informasi', 'Tetap', 'Jalan Balapan No 5', 'Singkawang', '2023-10-12', 'L', 'B', '082154379452'),
('72190377', 5, '10mg', 'I kadek yudi', 'karya', 'dosen biasa', 'fakultas TI', 'Tetap', 'Jalan Iskandar', 'Luwuk', '2023-10-13', 'L', 'B', '08995678234'),
('72190456', 5, '10mg', 'Rafael', 'Karya', 'dosen biasa', 'Fakultas TI', 'Tetap', 'Jalan Manado', 'Manado', '2023-10-01', 'L', 'B', '08995672345'),
('72190678', 5, '10mg', 'Yosia Agil', NULL, NULL, NULL, 'Tetap', 'Jalan Sejahtera no 56', 'Wonosobo', '2023-10-10', 'L', 'B', '082166835688');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `isi_penilaian`
--
ALTER TABLE `isi_penilaian`
  ADD PRIMARY KEY (`id_isi`),
  ADD KEY `id_kompetensi` (`id_kelpenilaian`);

--
-- Indexes for table `jenis_user`
--
ALTER TABLE `jenis_user`
  ADD PRIMARY KEY (`id_jenis_user`);

--
-- Indexes for table `kelompok_penilaian`
--
ALTER TABLE `kelompok_penilaian`
  ADD PRIMARY KEY (`id_kelpenilaian`);

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
-- AUTO_INCREMENT for table `isi_penilaian`
--
ALTER TABLE `isi_penilaian`
  MODIFY `id_isi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `jenis_user`
--
ALTER TABLE `jenis_user`
  MODIFY `id_jenis_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelompok_penilaian`
--
ALTER TABLE `kelompok_penilaian`
  MODIFY `id_kelpenilaian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT for table `penilai_detail`
--
ALTER TABLE `penilai_detail`
  MODIFY `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `isi_penilaian`
--
ALTER TABLE `isi_penilaian`
  ADD CONSTRAINT `FK_isi_kompetensi_jenis_kompetensi` FOREIGN KEY (`id_kelpenilaian`) REFERENCES `kelompok_penilaian` (`id_kelpenilaian`) ON DELETE CASCADE ON UPDATE CASCADE;

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
  ADD CONSTRAINT `FK_penilaian_isi_kompetensi` FOREIGN KEY (`id_isi`) REFERENCES `isi_penilaian` (`id_isi`) ON DELETE CASCADE ON UPDATE CASCADE,
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
