-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Bulan Mei 2023 pada 11.09
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbpk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `isi_kompetensi`
--

CREATE TABLE `isi_kompetensi` (
  `id_isi` int(11) NOT NULL,
  `id_kompetensi` int(11) DEFAULT NULL,
  `isi_kompetensi` text,
  `ket` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `isi_kompetensi`
--

INSERT INTO `isi_kompetensi` (`id_isi`, `id_kompetensi`, `isi_kompetensi`, `ket`) VALUES
(1, 1, 'Menguasai karakteristik peserta didik dari aspek fisik, moral, sosial, kultural, emosional, dan intelektual.', '1'),
(2, 1, 'Menguasai teori belajar dan prinsip-prinsip pembelajaran yang mendidik.', '0,1'),
(3, 1, 'Mengembangkan kurikulum yang terkait dengan mata pelajaran/bidang pengembangan yang diampu.', '0'),
(4, 1, 'Menyelenggarakan pembelajaran yang mendidik.', '0'),
(5, 1, 'Memanfaatkan teknologi informasi dan komunikasi untuk kepentingan pembelajaran.', '0'),
(6, 1, 'Memfasilitasi pengembangan potensi peserta didik untuk mengaktualisasikan berbagai potensi yang dimiliki.', '0'),
(7, 1, 'Berkomunikasi secara efektif, empatik, dan santun dengan peserta didik.', '0'),
(8, 1, 'Menyelenggarakan penilaian dan evaluasi proses dan hasil belajar.', '0'),
(9, 1, 'Memanfaatkan hasil penilaian dan evaluasi untuk kepentingan pembelajaran.', '0'),
(10, 1, 'Melakukan tindakan reflektif untuk peningkatan kualitas pembelajaran.', '0'),
(11, 3, 'Bertindak sesuai dengan norma agama, hukum, sosial, dan kebudayaan nasional Indonesia.', '0,1,2'),
(12, 3, 'Menampilkan diri sebagai pribadi yang jujur, berakhlak mulia, dan teladan bagi peserta didik dan masyarakat.', '0'),
(13, 3, 'Menampilkan diri sebagai pribadi yang mantap, stabil, dewasa, arif, dan berwibawa.', '0'),
(14, 3, 'Menunjukkan etos kerja, tanggung jawab yang tinggi, rasa bangga menjadi guru, dan rasa percaya diri.', '0'),
(15, 3, 'Menjunjung tinggi kode etik profesi guru.', '0'),
(16, 4, 'Bersikap inklusif, bertindak objektif, serta tidak diskriminatif karena pertimbangan jenis kelamin, agama, ras, kondisi fisik, latar belakang keluarga, dan status sosial ekonomi.', '0'),
(17, 4, 'Berkomunikasi secara efektif, empatik, dan santun dengan sesama pendidik, tenaga kependidikan, orang tua, dan masyarakat.', '0'),
(18, 4, 'Beradaptasi di tempat bertugas di seluruh wilayah Republik Indonesia yang memiliki keragaman sosial budaya.', '0'),
(19, 4, 'Berkomunikasi dengan komunitas profesi sendiri dan profesi lain secara lisan dan tulisan atau bentuk lain.', '0'),
(20, 5, 'Menguasai materi, struktur, konsep, dan pola pikir keilmuan yang mendukung mata pelajaran yang diampu.', '0'),
(21, 5, 'Menguasai standar kompetensi dan kompetensi dasar mata pelajaran/bidang pengembangan yang diampu.', '0'),
(22, 5, 'Mengembangkan materi pembelajaran yang diampu secara kreatif.', '0'),
(23, 5, 'Mengembangkan keprofesionalan secara berkelanjutan dengan melakukan tindakan reflektif.', '0'),
(24, 5, 'Memanfaatkan teknologi informasi dan komunikasi untuk berkomunikasi dan mengembangkan diri.', '0,1,2');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_kompetensi`
--

CREATE TABLE `jenis_kompetensi` (
  `id_kompetensi` int(11) NOT NULL,
  `nama_kompetensi` varchar(50) DEFAULT '0',
  `bobot_kompetensi` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_kompetensi`
--

INSERT INTO `jenis_kompetensi` (`id_kompetensi`, `nama_kompetensi`, `bobot_kompetensi`) VALUES
(1, 'Pedagogik', 40),
(3, 'Kepribadian', 20),
(4, 'Sosial', 20),
(5, 'Profesional', 20);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_user`
--

CREATE TABLE `jenis_user` (
  `id_jenis_user` int(10) NOT NULL,
  `jabatan` varchar(20) DEFAULT NULL,
  `level` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_user`
--

INSERT INTO `jenis_user` (`id_jenis_user`, `jabatan`, `level`) VALUES
(4, 'Wakil Kepala Sekolah', 2),
(5, 'Kepala Sekolah', 3),
(6, 'Guru', 1),
(7, 'Tata Usaha', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai`
--

CREATE TABLE `penilai` (
  `id_penilai` int(11) NOT NULL,
  `nip` char(18) DEFAULT NULL,
  `id_periode` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilai`
--

INSERT INTO `penilai` (`id_penilai`, `nip`, `id_periode`) VALUES
(1, '72190322', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilaian`
--

CREATE TABLE `penilaian` (
  `id_nilai` int(11) NOT NULL,
  `id_penilai_detail` int(11) DEFAULT NULL,
  `id_isi` int(11) DEFAULT NULL,
  `hasil_nilai` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilaian`
--

INSERT INTO `penilaian` (`id_nilai`, `id_penilai_detail`, `id_isi`, `hasil_nilai`) VALUES
(49, 1, 1, 3),
(50, 1, 2, 3),
(51, 1, 11, 3),
(52, 1, 24, 3),
(53, 2, 1, 3),
(54, 2, 2, 3),
(55, 2, 11, 3),
(56, 2, 24, 3),
(57, 3, 1, 3),
(58, 3, 2, 3),
(59, 3, 11, 3),
(60, 3, 24, 3),
(65, 4, 2, 3),
(66, 4, 3, 3),
(67, 4, 4, 3),
(68, 4, 5, 3),
(69, 4, 6, 3),
(70, 4, 7, 3),
(71, 4, 8, 3),
(72, 4, 9, 3),
(73, 4, 10, 3),
(74, 4, 11, 3),
(75, 4, 12, 3),
(76, 4, 13, 3),
(77, 4, 14, 3),
(78, 4, 15, 3),
(79, 4, 16, 3),
(80, 4, 17, 3),
(81, 4, 18, 3),
(82, 4, 19, 3),
(83, 4, 20, 3),
(84, 4, 21, 3),
(85, 4, 22, 3),
(86, 4, 23, 3),
(87, 4, 24, 3),
(88, 5, 11, 3),
(89, 5, 24, 3),
(90, 6, 1, 4),
(91, 6, 2, 4),
(92, 6, 11, 4),
(93, 6, 24, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai_detail`
--

CREATE TABLE `penilai_detail` (
  `id_penilai_detail` int(11) NOT NULL,
  `id_penilai` int(11) NOT NULL,
  `nip` char(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `penilai_detail`
--

INSERT INTO `penilai_detail` (`id_penilai_detail`, `id_penilai`, `nip`) VALUES
(1, 1, '72190333'),
(2, 1, '72190458'),
(3, 1, '72190788'),
(4, 1, '2012091200113511'),
(5, 1, '2012091200113501'),
(6, 1, '72190322');

-- --------------------------------------------------------

--
-- Struktur dari tabel `periode`
--

CREATE TABLE `periode` (
  `id_periode` int(11) NOT NULL,
  `tahun_ajar` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `status_periode` int(11) NOT NULL,
  `setting` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `periode`
--

INSERT INTO `periode` (`id_periode`, `tahun_ajar`, `semester`, `status_periode`, `setting`) VALUES
(1, '2018', 'Ganjil', 0, '50;25;25'),
(2, '2018', 'Genap', 0, '50;30;20'),
(3, '2019', 'Ganjil', 0, '50;30;20'),
(4, '2023', 'Genap', 1, '25;50;25');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`nip`, `id_jenis_user`, `password`, `nama_ppa`, `status_ppa`, `alamat`, `tempat_lahir`, `tgl_lahir`, `jenis_kelamin`, `status_nikah`, `no_telp`) VALUES
('2012091200113500', 7, '123', 'Ferdy (Tata Usaha)', 'Tetap', 'Kediri Bos', 'Kediri', '1996-03-21', 'L', 'N', '0819283746378'),
('2012091200113501', 4, '123', 'Agum Gumelar (Wakil Kepsek)', 'Tetap', 'Surabaya', 'Surabaya', '1996-12-21', 'L', 'B', '0819283776666'),
('2012091200113511', 5, '123', 'Andriasyah Putra (KepSek)', 'Tetap', 'Kupang Panjaan', 'Surabaya', '1987-10-02', 'L', 'B', '088999876765'),
('72190322', 6, '123', 'Junaidi', 'Tetap', 'Jalan Balapan no 5', 'Singkawang', '2023-05-05', 'L', 'B', '082154379455'),
('72190333', 6, '123', 'I Kadek Yudiantoro', 'Tetap', 'Jalan Sutomo no 15', 'Luwuk', '2023-03-08', 'L', 'B', '089945278452'),
('72190458', 6, '123', 'Jascha Fabio', 'Tetap', 'Jalan Galeria No 4', 'Ambon', '2023-02-03', 'L', 'B', '082678245611'),
('72190788', 6, '123', 'Jeremy Wasista', 'Tetap', 'Jalan Balapan no 6', 'Pekanbaru', '1997-06-15', 'L', 'B', '082155875426');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `isi_kompetensi`
--
ALTER TABLE `isi_kompetensi`
  ADD PRIMARY KEY (`id_isi`),
  ADD KEY `id_kompetensi` (`id_kompetensi`);

--
-- Indeks untuk tabel `jenis_kompetensi`
--
ALTER TABLE `jenis_kompetensi`
  ADD PRIMARY KEY (`id_kompetensi`);

--
-- Indeks untuk tabel `jenis_user`
--
ALTER TABLE `jenis_user`
  ADD PRIMARY KEY (`id_jenis_user`);

--
-- Indeks untuk tabel `penilai`
--
ALTER TABLE `penilai`
  ADD PRIMARY KEY (`id_penilai`),
  ADD KEY `nip` (`nip`),
  ADD KEY `id_periode` (`id_periode`);

--
-- Indeks untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_isi` (`id_isi`),
  ADD KEY `id_penilai_detail` (`id_penilai_detail`);

--
-- Indeks untuk tabel `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD PRIMARY KEY (`id_penilai_detail`),
  ADD KEY `id_penilai` (`id_penilai`),
  ADD KEY `nip` (`nip`);

--
-- Indeks untuk tabel `periode`
--
ALTER TABLE `periode`
  ADD PRIMARY KEY (`id_periode`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`nip`),
  ADD KEY `id_jenis_user` (`id_jenis_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `isi_kompetensi`
--
ALTER TABLE `isi_kompetensi`
  MODIFY `id_isi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `jenis_kompetensi`
--
ALTER TABLE `jenis_kompetensi`
  MODIFY `id_kompetensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `jenis_user`
--
ALTER TABLE `jenis_user`
  MODIFY `id_jenis_user` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penilai`
--
ALTER TABLE `penilai`
  MODIFY `id_penilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT untuk tabel `penilai_detail`
--
ALTER TABLE `penilai_detail`
  MODIFY `id_penilai_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `periode`
--
ALTER TABLE `periode`
  MODIFY `id_periode` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `isi_kompetensi`
--
ALTER TABLE `isi_kompetensi`
  ADD CONSTRAINT `FK_isi_kompetensi_jenis_kompetensi` FOREIGN KEY (`id_kompetensi`) REFERENCES `jenis_kompetensi` (`id_kompetensi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilai`
--
ALTER TABLE `penilai`
  ADD CONSTRAINT `FK_penilai_periode` FOREIGN KEY (`id_periode`) REFERENCES `periode` (`id_periode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilai_user` FOREIGN KEY (`nip`) REFERENCES `user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `FK_penilaian_isi_kompetensi` FOREIGN KEY (`id_isi`) REFERENCES `isi_kompetensi` (`id_isi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilaian_penilai_detail` FOREIGN KEY (`id_penilai_detail`) REFERENCES `penilai_detail` (`id_penilai_detail`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `penilai_detail`
--
ALTER TABLE `penilai_detail`
  ADD CONSTRAINT `FK_penilai_detail_penilai` FOREIGN KEY (`id_penilai`) REFERENCES `penilai` (`id_penilai`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_penilai_detail_user` FOREIGN KEY (`nip`) REFERENCES `user` (`nip`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_user_jenis_user` FOREIGN KEY (`id_jenis_user`) REFERENCES `jenis_user` (`id_jenis_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
