-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2019 at 11:07 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci_online_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `dosen`
--

CREATE TABLE `dosen` (
  `id_dosen` int(11) NOT NULL,
  `nip` char(12) NOT NULL,
  `nama_dosen` varchar(50) NOT NULL,
  `email` varchar(254) NOT NULL,
  `matkul_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dosen`
--

INSERT INTO `dosen` (`id_dosen`, `nip`, `nama_dosen`, `email`, `matkul_id`) VALUES
(1, '12345678', 'Koro Sensei', 'korosensei@gmail.com', 1),
(3, '01234567', 'Tobirama Sensei', 'tobirama@gmail.com', 5);

--
-- Triggers `dosen`
--
DELIMITER $$
CREATE TRIGGER `edit_user_dosen` BEFORE UPDATE ON `dosen` FOR EACH ROW UPDATE `users` SET `email` = NEW.email, `username` = NEW.nip WHERE `users`.`username` = OLD.nip
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `hapus_user_dosen` BEFORE DELETE ON `dosen` FOR EACH ROW DELETE FROM `users` WHERE `users`.`username` = OLD.nip
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'dosen', 'Pembuat Soal dan ujian'),
(3, 'mahasiswa', 'Peserta Ujian');

-- --------------------------------------------------------

--
-- Table structure for table `h_ujian`
--

CREATE TABLE `h_ujian` (
  `id` int(11) NOT NULL,
  `ujian_id` int(11) NOT NULL,
  `mahasiswa_id` int(11) NOT NULL,
  `list_soal` longtext NOT NULL,
  `list_jawaban` longtext NOT NULL,
  `jml_benar` int(11) NOT NULL,
  `nilai` decimal(10,2) NOT NULL,
  `nilai_bobot` decimal(10,2) NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `tgl_selesai` datetime NOT NULL,
  `status` enum('Y','N') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `h_ujian`
--

INSERT INTO `h_ujian` (`id`, `ujian_id`, `mahasiswa_id`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`) VALUES
(1, 1, 1, '1,2,3', '1:B:N,2:A:N,3:D:N', 3, '100.00', '100.00', '2019-02-16 08:35:05', '2019-02-16 08:36:05', 'N'),
(2, 2, 1, '3,2,1', '3:D:N,2:C:N,1:D:N', 1, '33.00', '100.00', '2019-02-16 10:11:14', '2019-02-16 10:12:14', 'N'),
(3, 3, 1, '5,6', '5:C:N,6:D:N', 2, '100.00', '100.00', '2019-02-16 11:06:25', '2019-02-16 11:07:25', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan`
--

CREATE TABLE `jurusan` (
  `id_jurusan` int(11) NOT NULL,
  `nama_jurusan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jurusan`
--

INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'Sistem Informasi'),
(2, 'Teknik Informatika');

-- --------------------------------------------------------

--
-- Table structure for table `jurusan_matkul`
--

CREATE TABLE `jurusan_matkul` (
  `id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `jurusan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jurusan_matkul`
--

INSERT INTO `jurusan_matkul` (`id`, `matkul_id`, `jurusan_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 2, 2),
(6, 5, 2);

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(30) NOT NULL,
  `jurusan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jurusan_id`) VALUES
(1, '12.1E.13', 1),
(2, '11.1A.13', 1),
(3, '10.1D.13', 1),
(7, '12.1A.10', 2),
(8, '12.1B.10', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kelas_dosen`
--

CREATE TABLE `kelas_dosen` (
  `id` int(11) NOT NULL,
  `kelas_id` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kelas_dosen`
--

INSERT INTO `kelas_dosen` (`id`, `kelas_id`, `dosen_id`) VALUES
(1, 3, 1),
(2, 2, 1),
(3, 1, 1),
(9, 2, 3),
(10, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `login_attempts`
--

INSERT INTO `login_attempts` (`id`, `ip_address`, `login`, `time`) VALUES
(1, '::1', 'ad', 1550742963);

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id_mahasiswa` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nim` char(20) NOT NULL,
  `email` varchar(254) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `kelas_id` int(11) NOT NULL COMMENT 'kelas&jurusan'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `nim`, `email`, `jenis_kelamin`, `kelas_id`) VALUES
(1, 'Muhammad Ghifari Arfananda', '12183018', 'mghifariarfan@gmail.com', 'L', 1);

-- --------------------------------------------------------

--
-- Table structure for table `matkul`
--

CREATE TABLE `matkul` (
  `id_matkul` int(11) NOT NULL,
  `nama_matkul` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `matkul`
--

INSERT INTO `matkul` (`id_matkul`, `nama_matkul`) VALUES
(1, 'Bahasa Inggris'),
(2, 'Dasar Pemrograman'),
(3, 'Enterpreneurship'),
(5, 'Matematika Advanced');

-- --------------------------------------------------------

--
-- Table structure for table `m_ujian`
--

CREATE TABLE `m_ujian` (
  `id_ujian` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `nama_ujian` varchar(200) NOT NULL,
  `jumlah_soal` int(11) NOT NULL,
  `waktu` int(11) NOT NULL,
  `jenis` enum('acak','urut') NOT NULL,
  `tgl_mulai` datetime NOT NULL,
  `terlambat` datetime NOT NULL,
  `token` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `m_ujian`
--

INSERT INTO `m_ujian` (`id_ujian`, `dosen_id`, `matkul_id`, `nama_ujian`, `jumlah_soal`, `waktu`, `jenis`, `tgl_mulai`, `terlambat`, `token`) VALUES
(1, 1, 1, 'First Test', 3, 1, 'acak', '2019-02-15 17:25:40', '2019-02-20 17:25:44', 'DPEHL'),
(2, 1, 1, 'Second Test', 3, 1, 'acak', '2019-02-16 10:05:08', '2019-02-17 10:05:10', 'GOEMB'),
(3, 3, 5, 'Try Out 01', 2, 1, 'acak', '2019-02-16 07:00:00', '2019-02-28 14:00:00', 'IFSDH');

-- --------------------------------------------------------

--
-- Table structure for table `tb_soal`
--

CREATE TABLE `tb_soal` (
  `id_soal` int(11) NOT NULL,
  `dosen_id` int(11) NOT NULL,
  `matkul_id` int(11) NOT NULL,
  `bobot` int(11) NOT NULL,
  `file` varchar(255) NOT NULL,
  `tipe_file` varchar(50) NOT NULL,
  `soal` longtext NOT NULL,
  `opsi_a` longtext NOT NULL,
  `opsi_b` longtext NOT NULL,
  `opsi_c` longtext NOT NULL,
  `opsi_d` longtext NOT NULL,
  `opsi_e` longtext NOT NULL,
  `file_a` varchar(255) NOT NULL,
  `file_b` varchar(255) NOT NULL,
  `file_c` varchar(255) NOT NULL,
  `file_d` varchar(255) NOT NULL,
  `file_e` varchar(255) NOT NULL,
  `jawaban` varchar(5) NOT NULL,
  `created_on` int(11) NOT NULL,
  `updated_on` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tb_soal`
--

INSERT INTO `tb_soal` (`id_soal`, `dosen_id`, `matkul_id`, `bobot`, `file`, `tipe_file`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `file_a`, `file_b`, `file_c`, `file_d`, `file_e`, `jawaban`, `created_on`, `updated_on`) VALUES
(1, 1, 1, 1, '', '', '<p>Dian : The cake is scrumptious! I love i<br>Joni : … another piece?<br>Dian : Thank you. You should tell me the recipe.<br>Joni : I will.</p><p>Which of the following offering expressions best fill the blank?</p>', '<p>Do you mind if you have</p>', '<p>Would you like</p>', '<p>Shall you hav</p>', '<p>Can I have you</p>', '<p>I will bring you</p>', '', '', '', '', '', 'B', 1550225760, 1550225760),
(2, 1, 1, 1, '', '', '<p>Fitri : The French homework is really hard. I don’t feel like to do it.<br>Rahmat : … to help you?<br>Fitri : It sounds great. Thanks, Rahmat!</p><p><br></p><p>Which of the following offering expressions best fill the blank?</p>', '<p>Would you like me</p>', '<p>Do you mind if I</p>', '<p>Shall I</p>', '<p>Can I</p>', '<p>I will</p>', '', '', '', '', '', 'A', 1550225952, 1550225952),
(3, 1, 1, 1, 'd166959dabe9a81e4567dc44021ea503.jpg', 'image/jpeg', '<p>What is the picture describing?</p><p><small class=\"text-muted\">Sumber gambar: meros.jp</small></p>', '<p>The students are arguing with their lecturer.</p>', '<p>The students are watching their preacher.</p>', '<p>The teacher is angry with their students.</p>', '<p>The students are listening to their lecturer.</p>', '<p>The students detest the preacher.</p>', '', '', '', '', '', 'D', 1550226174, 1550226174),
(5, 3, 5, 1, '', '', '<p>(2000 x 3) : 4 x 0 = ...</p>', '<p>NULL</p>', '<p>NaN</p>', '<p>0</p>', '<p>1</p>', '<p>-1</p>', '', '', '', '', '', 'C', 1550289702, 1550289724),
(6, 3, 5, 1, '98a79c067fefca323c56ed0f8d1cac5f.png', 'image/png', '<p>Nomor berapakah ini?</p>', '<p>Sembilan</p>', '<p>Sepuluh</p>', '<p>Satu</p>', '<p>Tujuh</p>', '<p>Tiga</p>', '', '', '', '', '', 'D', 1550289774, 1550289774);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) UNSIGNED DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'Administrator', '$2y$12$tGY.AtcyXrh7WmccdbT1rOuKEcTsKH6sIUmDr0ore1yN4LnKTTtuu', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1268889823, 1550743550, 1, 'Admin', 'Istrator', 'ADMIN', '0'),
(3, '::1', '12183018', '$2y$10$TLtlU8WsPUBQgLWcL5n8SO9YoTd1jDktGIkIvm9Fk2ROI0yJQ.TlC', 'mghifariarfan@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1550225511, 1550743572, 1, 'Muhammad', 'Arfananda', NULL, NULL),
(4, '::1', '12345678', '$2y$10$9CxUKgrB/0tlgOEIec1Fl.RMrLLcpJPGyFqqRh2gec.crgeVBWvym', 'korosensei@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1550226286, 1550743600, 1, 'Koro', 'Sensei', NULL, NULL),
(8, '::1', '01234567', '$2y$10$5pAJAyB3XvrGEkvGak2QI.1pWqwK/S76r3Pf4ltQSGQzLMpw53Tvy', 'tobirama@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1550289356, 1550743585, 1, 'Tobirama', 'Sensei', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(3, 1, 1),
(5, 3, 3),
(6, 4, 2),
(10, 8, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dosen`
--
ALTER TABLE `dosen`
  ADD PRIMARY KEY (`id_dosen`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `matkul_id` (`matkul_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `h_ujian`
--
ALTER TABLE `h_ujian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ujian_id` (`ujian_id`),
  ADD KEY `mahasiswa_id` (`mahasiswa_id`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id_jurusan`);

--
-- Indexes for table `jurusan_matkul`
--
ALTER TABLE `jurusan_matkul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_id` (`jurusan_id`),
  ADD KEY `matkul_id` (`matkul_id`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`id_kelas`),
  ADD KEY `jurusan_id` (`jurusan_id`);

--
-- Indexes for table `kelas_dosen`
--
ALTER TABLE `kelas_dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kelas_id` (`kelas_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id_mahasiswa`),
  ADD UNIQUE KEY `nim` (`nim`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `kelas_id` (`kelas_id`);

--
-- Indexes for table `matkul`
--
ALTER TABLE `matkul`
  ADD PRIMARY KEY (`id_matkul`);

--
-- Indexes for table `m_ujian`
--
ALTER TABLE `m_ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `matkul_id` (`matkul_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indexes for table `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `matkul_id` (`matkul_id`),
  ADD KEY `dosen_id` (`dosen_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_activation_selector` (`activation_selector`),
  ADD UNIQUE KEY `uc_forgotten_password_selector` (`forgotten_password_selector`),
  ADD UNIQUE KEY `uc_remember_selector` (`remember_selector`),
  ADD UNIQUE KEY `uc_email` (`email`) USING BTREE;

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dosen`
--
ALTER TABLE `dosen`
  MODIFY `id_dosen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `h_ujian`
--
ALTER TABLE `h_ujian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id_jurusan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jurusan_matkul`
--
ALTER TABLE `jurusan_matkul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kelas`
--
ALTER TABLE `kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `kelas_dosen`
--
ALTER TABLE `kelas_dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id_mahasiswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `matkul`
--
ALTER TABLE `matkul`
  MODIFY `id_matkul` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `m_ujian`
--
ALTER TABLE `m_ujian`
  MODIFY `id_ujian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_soal`
--
ALTER TABLE `tb_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dosen`
--
ALTER TABLE `dosen`
  ADD CONSTRAINT `dosen_ibfk_1` FOREIGN KEY (`matkul_id`) REFERENCES `matkul` (`id_matkul`);

--
-- Constraints for table `h_ujian`
--
ALTER TABLE `h_ujian`
  ADD CONSTRAINT `h_ujian_ibfk_1` FOREIGN KEY (`ujian_id`) REFERENCES `m_ujian` (`id_ujian`),
  ADD CONSTRAINT `h_ujian_ibfk_2` FOREIGN KEY (`mahasiswa_id`) REFERENCES `mahasiswa` (`id_mahasiswa`);

--
-- Constraints for table `jurusan_matkul`
--
ALTER TABLE `jurusan_matkul`
  ADD CONSTRAINT `jurusan_matkul_ibfk_1` FOREIGN KEY (`jurusan_id`) REFERENCES `jurusan` (`id_jurusan`),
  ADD CONSTRAINT `jurusan_matkul_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `matkul` (`id_matkul`);

--
-- Constraints for table `kelas_dosen`
--
ALTER TABLE `kelas_dosen`
  ADD CONSTRAINT `kelas_dosen_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id_dosen`),
  ADD CONSTRAINT `kelas_dosen_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `mahasiswa_ibfk_2` FOREIGN KEY (`kelas_id`) REFERENCES `kelas` (`id_kelas`);

--
-- Constraints for table `m_ujian`
--
ALTER TABLE `m_ujian`
  ADD CONSTRAINT `m_ujian_ibfk_1` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id_dosen`),
  ADD CONSTRAINT `m_ujian_ibfk_2` FOREIGN KEY (`matkul_id`) REFERENCES `matkul` (`id_matkul`);

--
-- Constraints for table `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD CONSTRAINT `tb_soal_ibfk_1` FOREIGN KEY (`matkul_id`) REFERENCES `matkul` (`id_matkul`),
  ADD CONSTRAINT `tb_soal_ibfk_2` FOREIGN KEY (`dosen_id`) REFERENCES `dosen` (`id_dosen`);

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
-- ===========================================================
-- SAMPLE DATA for ujian-online-ci system
-- Generated: 200 mahasiswa, 10 dosen, 3 jurusan, 15 matkul
-- ===========================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = '+07:00';
SET FOREIGN_KEY_CHECKS = 0;

-- ---------- GROUPS ----------
DELETE FROM `users_groups`;
DELETE FROM `groups`;
INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'dosen', 'Pembuat Soal dan ujian'),
(3, 'mahasiswa', 'Peserta Ujian');

-- ---------- JURUSAN ----------
TRUNCATE TABLE `jurusan`;
INSERT INTO `jurusan` (`id_jurusan`, `nama_jurusan`) VALUES
(1, 'Sistem Informasi'),
(2, 'Teknik Informatika'),
(3, 'Manajemen Informatika');

-- ---------- MATA KULIAH ----------
TRUNCATE TABLE `matkul`;
INSERT INTO `matkul` (`id_matkul`, `nama_matkul`) VALUES
(1, 'Basis Data'),
(2, 'Analisis Sistem'),
(3, 'Manajemen Proyek'),
(4, 'E-commerce'),
(5, 'Interaksi Manusia Komputer'),
(6, 'Algoritma & Struktur Data'),
(7, 'Jaringan Komputer'),
(8, 'Sistem Operasi'),
(9, 'Pemrograman Web'),
(10, 'Keamanan Informasi'),
(11, 'Pemrograman Dasar'),
(12, 'Multimedia'),
(13, 'Akuntansi Dasar'),
(14, 'Sistem Informasi Manajemen'),
(15, 'Desain Grafis');

-- ---------- JURUSAN_MATKUL ----------
TRUNCATE TABLE `jurusan_matkul`;
INSERT INTO `jurusan_matkul` (`id`, `matkul_id`, `jurusan_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2),
(10, 10, 2),
(11, 11, 3),
(12, 12, 3),
(13, 13, 3),
(14, 14, 3),
(15, 15, 3);

-- ---------- KELAS ----------
TRUNCATE TABLE `kelas`;
INSERT INTO `kelas` (`id_kelas`, `nama_kelas`, `jurusan_id`) VALUES
(1, '12.1E.01', 1),
(2, '12.1E.02', 1),
(3, '12.1E.03', 1),
(4, '11.1E.01', 1),
(5, '12.1A.01', 2),
(6, '12.1A.02', 2),
(7, '11.1A.01', 2),
(8, '11.1A.02', 2),
(9, '12.1B.01', 3),
(10, '12.1B.02', 3),
(11, '11.1B.01', 3);

-- ---------- DOSEN ----------
TRUNCATE TABLE `dosen`;
INSERT INTO `dosen` (`id_dosen`, `nip`, `nama_dosen`, `email`, `matkul_id`) VALUES
(1, '19742824', 'Dr. Ahmad Fauzi, M.Kom', 'ahmad.fauzi@univ.ac.id', 1),
(2, '19751409', 'Dr. Siti Rahmawati, M.T', 'siti.rahmawati@univ.ac.id', 2),
(3, '19765506', 'Bambang Supriyadi, S.Kom, M.Cs', 'bambang.supriyadi@univ.ac.id', 3),
(4, '19775012', 'Dewi Sartika, S.Si, M.T', 'dewi.sartika@univ.ac.id', 4),
(5, '19784657', 'Eko Prasetyo, S.Kom, M.Eng', 'eko.prasetyo@univ.ac.id', 5),
(6, '19793286', 'Fitri Handayani, S.T, M.Kom', 'fitri.handayani@univ.ac.id', 6),
(7, '19802679', 'Gunawan Wijaya, S.Kom, M.M', 'gunawan.wijaya@univ.ac.id', 7),
(8, '19819935', 'Hendra Gunawan, S.T, M.Kom', 'hendra.gunawan@univ.ac.id', 8),
(9, '19822424', 'Indah Permata Sari, S.Kom, M.Cs', 'indah.permata@univ.ac.id', 9),
(10, '19837912', 'Joko Susilo, S.Si, M.T', 'joko.susilo@univ.ac.id', 10);

-- ---------- KELAS_DOSEN ----------
TRUNCATE TABLE `kelas_dosen`;
INSERT INTO `kelas_dosen` (`id`, `kelas_id`, `dosen_id`) VALUES
(1, 1, 1),
(2, 11, 1),
(3, 2, 2),
(4, 4, 2),
(5, 4, 3),
(6, 9, 3),
(7, 10, 4),
(8, 1, 4),
(9, 9, 5),
(10, 4, 5),
(11, 11, 6),
(12, 9, 6),
(13, 7, 7),
(14, 4, 7),
(15, 8, 8),
(16, 10, 8),
(17, 5, 9),
(18, 1, 9),
(19, 3, 10),
(20, 7, 10);

-- ---------- MAHASISWA ----------
TRUNCATE TABLE `mahasiswa`;
INSERT INTO `mahasiswa` (`id_mahasiswa`, `nama`, `nim`, `email`, `jenis_kelamin`, `kelas_id`) VALUES
(1, 'Yuni', '1310001', 'yuni.1@student.univ.ac.id', 'P', 1),
(2, 'Intan Purnama', '1250002', 'intan.2@student.univ.ac.id', 'L', 2),
(3, 'Nia Halim', '1230003', 'nia.3@student.univ.ac.id', 'L', 3),
(4, 'Oni', '1240004', 'oni.4@student.univ.ac.id', 'P', 4),
(5, 'Betty Siahaan', '1430005', 'betty.5@student.univ.ac.id', 'L', 5),
(6, 'Leni', '1310006', 'leni.6@student.univ.ac.id', 'L', 6),
(7, 'Nanda Nainggolan', '1220007', 'nanda.7@student.univ.ac.id', 'P', 7),
(8, 'Citra Wulandari', '1220008', 'citra.8@student.univ.ac.id', 'L', 8),
(9, 'Utami Susanto', '1320009', 'utami.9@student.univ.ac.id', 'L', 9),
(10, 'Winda Lim', '1220010', 'winda.10@student.univ.ac.id', 'P', 10),
(11, 'Dani', '1310011', 'dani.11@student.univ.ac.id', 'L', 11),
(12, 'Oji Suryanto', '1440012', 'oji.12@student.univ.ac.id', 'L', 1),
(13, 'Tedi Sihombing', '1310013', 'tedi.13@student.univ.ac.id', 'P', 2),
(14, 'Kiki Purba', '1350014', 'kiki.14@student.univ.ac.id', 'L', 3),
(15, 'Caca Hasibuan', '1250015', 'caca.15@student.univ.ac.id', 'L', 4),
(16, 'Laras Situmeang', '1430016', 'laras.16@student.univ.ac.id', 'P', 5),
(17, 'Yuda Siregar', '1210017', 'yuda.17@student.univ.ac.id', 'L', 6),
(18, 'Vera Sitompul', '1420018', 'vera.18@student.univ.ac.id', 'L', 7),
(19, 'Herman', '1330019', 'herman.19@student.univ.ac.id', 'P', 8),
(20, 'Dedi Hutapea', '1340020', 'dedi.20@student.univ.ac.id', 'L', 9),
(21, 'Dodo Sembiring', '1220021', 'dodo.21@student.univ.ac.id', 'L', 10),
(22, 'Putri', '1450022', 'putri.22@student.univ.ac.id', 'P', 11),
(23, 'Ujang Gunawan', '1320023', 'ujang.23@student.univ.ac.id', 'L', 1),
(24, 'Rini Rajagukguk', '1220024', 'rini.24@student.univ.ac.id', 'L', 2),
(25, 'Hesti Dalimunthe', '1340025', 'hesti.25@student.univ.ac.id', 'P', 3),
(26, 'Gilang Ginting', '1250026', 'gilang.26@student.univ.ac.id', 'L', 4),
(27, 'Bunga Santoso', '1440027', 'bunga.27@student.univ.ac.id', 'L', 5),
(28, 'Arif Salim', '1410028', 'arif.28@student.univ.ac.id', 'P', 6),
(29, 'Fajar Sitanggang', '1350029', 'fajar.29@student.univ.ac.id', 'L', 7),
(30, 'Panca', '1450030', 'panca.30@student.univ.ac.id', 'L', 8),
(31, 'Oman Hidayat', '1440031', 'oman.31@student.univ.ac.id', 'P', 9),
(32, 'Mimi Marpaung', '1310032', 'mimi.32@student.univ.ac.id', 'L', 10),
(33, 'Mega Ritonga', '1350033', 'mega.33@student.univ.ac.id', 'L', 11),
(34, 'Novi Iskandar', '1240034', 'novi.34@student.univ.ac.id', 'P', 1),
(35, 'Vania Nasution', '1420035', 'vania.35@student.univ.ac.id', 'L', 2),
(36, 'Dian Utami', '1220036', 'dian.36@student.univ.ac.id', 'L', 3),
(37, 'Ratna Siregar', '1210037', 'ratna.37@student.univ.ac.id', 'P', 4),
(38, 'Rere Siburian', '1410038', 'rere.38@student.univ.ac.id', 'L', 5),
(39, 'Jaya Harahap', '1240039', 'jaya.39@student.univ.ac.id', 'L', 6),
(40, 'Risa Sinaga', '1430040', 'risa.40@student.univ.ac.id', 'P', 7),
(41, 'Putu', '1250041', 'putu.41@student.univ.ac.id', 'L', 8),
(42, 'Pasha Lubis', '1220042', 'pasha.42@student.univ.ac.id', 'L', 9),
(43, 'Kurnia Darmawan', '1440043', 'kurnia.43@student.univ.ac.id', 'P', 10),
(44, 'Linda Winarto', '1240044', 'linda.44@student.univ.ac.id', 'L', 11),
(45, 'Endah Kusuma', '1440045', 'endah.45@student.univ.ac.id', 'L', 1),
(46, 'Hana Herman', '1220046', 'hana.46@student.univ.ac.id', 'P', 2),
(47, 'Pandi Hartono', '1320047', 'pandi.47@student.univ.ac.id', 'L', 3),
(48, 'Tomas Pratama', '1250048', 'tomas.48@student.univ.ac.id', 'L', 4),
(49, 'Heru Nugroho', '1330049', 'heru.49@student.univ.ac.id', 'P', 5),
(50, 'Doni Tan', '1410050', 'doni.50@student.univ.ac.id', 'L', 6),
(51, 'Sinta Suharto', '1440051', 'sinta.51@student.univ.ac.id', 'L', 7),
(52, 'Hesti Santoso', '1310052', 'hesti.52@student.univ.ac.id', 'P', 8),
(53, 'Pramono Wibowo', '1230053', 'pramono.53@student.univ.ac.id', 'L', 9),
(54, 'Mario', '1310054', 'mario.54@student.univ.ac.id', 'L', 10),
(55, 'Vivi', '1310055', 'vivi.55@student.univ.ac.id', 'P', 11),
(56, 'Ahmad Daulay', '1240056', 'ahmad.56@student.univ.ac.id', 'L', 1),
(57, 'Fandi Siregar', '1410057', 'fandi.57@student.univ.ac.id', 'L', 2),
(58, 'Novan Wijaya', '1250058', 'novan.58@student.univ.ac.id', 'P', 3),
(59, 'Rina Tarigan', '1420059', 'rina.59@student.univ.ac.id', 'L', 4),
(60, 'Okta Setiawan', '1450060', 'okta.60@student.univ.ac.id', 'L', 5),
(61, 'Oki Manurung', '1410061', 'oki.61@student.univ.ac.id', 'P', 6),
(62, 'Puji Simanjuntak', '1410062', 'puji.62@student.univ.ac.id', 'L', 7),
(63, 'Ardi Saputra', '1220063', 'ardi.63@student.univ.ac.id', 'L', 8),
(64, 'Vina Prabowo', '1350064', 'vina.64@student.univ.ac.id', 'P', 9),
(65, 'Cici Cahyono', '1410065', 'cici.65@student.univ.ac.id', 'L', 10),
(66, 'Mira Sulaiman', '1230066', 'mira.66@student.univ.ac.id', 'L', 11),
(67, 'Fauzi Yulianto', '1340067', 'fauzi.67@student.univ.ac.id', 'P', 1),
(68, 'Umi Siregar', '1420068', 'umi.68@student.univ.ac.id', 'L', 2),
(69, 'Oscar Simatupang', '1240069', 'oscar.69@student.univ.ac.id', 'L', 3),
(70, 'Wira Lumbantobing', '1230070', 'wira.70@student.univ.ac.id', 'P', 4),
(71, 'Niken', '1330071', 'niken.71@student.univ.ac.id', 'L', 5),
(72, 'Aditya Purnama', '1320072', 'aditya.72@student.univ.ac.id', 'L', 6),
(73, 'Wahyu Halim', '1250073', 'wahyu.73@student.univ.ac.id', 'P', 7),
(74, 'Taufik', '1450074', 'taufik.74@student.univ.ac.id', 'L', 8),
(75, 'Jesika Siahaan', '1410075', 'jesika.75@student.univ.ac.id', 'L', 9),
(76, 'Agus', '1420076', 'agus.76@student.univ.ac.id', 'P', 10),
(77, 'Rian Nainggolan', '1340077', 'rian.77@student.univ.ac.id', 'L', 11),
(78, 'Nana Wulandari', '1240078', 'nana.78@student.univ.ac.id', 'L', 1),
(79, 'Juni Susanto', '1410079', 'juni.79@student.univ.ac.id', 'P', 2),
(80, 'Sena Lim', '1310080', 'sena.80@student.univ.ac.id', 'L', 3),
(81, 'Uci', '1440081', 'uci.81@student.univ.ac.id', 'L', 4),
(82, 'Ina Suryanto', '1430082', 'ina.82@student.univ.ac.id', 'P', 5),
(83, 'Yayan Sihombing', '1430083', 'yayan.83@student.univ.ac.id', 'L', 6),
(84, 'Aliya Purba', '1210084', 'aliya.84@student.univ.ac.id', 'L', 7),
(85, 'Juli Hasibuan', '1240085', 'juli.85@student.univ.ac.id', 'P', 8),
(86, 'Komang Situmeang', '1440086', 'komang.86@student.univ.ac.id', 'L', 9),
(87, 'Teguh Siregar', '1210087', 'teguh.87@student.univ.ac.id', 'L', 10),
(88, 'Hasan Sitompul', '1430088', 'hasan.88@student.univ.ac.id', 'P', 11),
(89, 'Nizar', '1310089', 'nizar.89@student.univ.ac.id', 'L', 1),
(90, 'Uswa Hutapea', '1320090', 'uswa.90@student.univ.ac.id', 'L', 2),
(91, 'Tono Sembiring', '1250091', 'tono.91@student.univ.ac.id', 'P', 3),
(92, 'Santi', '1220092', 'santi.92@student.univ.ac.id', 'L', 4),
(93, 'Pandu Gunawan', '1240093', 'pandu.93@student.univ.ac.id', 'L', 5),
(94, 'Maman Rajagukguk', '1450094', 'maman.94@student.univ.ac.id', 'P', 6),
(95, 'Yuni Dalimunthe', '1350095', 'yuni.95@student.univ.ac.id', 'L', 7),
(96, 'Gilang Ginting', '1450096', 'gilang.96@student.univ.ac.id', 'L', 8),
(97, 'Erna Santoso', '1420097', 'erna.97@student.univ.ac.id', 'P', 9),
(98, 'Fany Salim', '1310098', 'fany.98@student.univ.ac.id', 'L', 10),
(99, 'Cici Sitanggang', '1240099', 'cici.99@student.univ.ac.id', 'L', 11),
(100, 'Gusti', '1410100', 'gusti.100@student.univ.ac.id', 'P', 1),
(101, 'Tio Hidayat', '1330101', 'tio.101@student.univ.ac.id', 'L', 2),
(102, 'Eka Marpaung', '1320102', 'eka.102@student.univ.ac.id', 'L', 3),
(103, 'Galuh Ritonga', '1450103', 'galuh.103@student.univ.ac.id', 'P', 4),
(104, 'Ewin Iskandar', '1450104', 'ewin.104@student.univ.ac.id', 'L', 5),
(105, 'Lala Nasution', '1410105', 'lala.105@student.univ.ac.id', 'L', 6),
(106, 'Kartika Utami', '1330106', 'kartika.106@student.univ.ac.id', 'P', 7),
(107, 'Wasis Siregar', '1230107', 'wasis.107@student.univ.ac.id', 'L', 8),
(108, 'Olla Siburian', '1250108', 'olla.108@student.univ.ac.id', 'L', 9),
(109, 'Ucok Harahap', '1230109', 'ucok.109@student.univ.ac.id', 'P', 10),
(110, 'Bima Sinaga', '1240110', 'bima.110@student.univ.ac.id', 'L', 11),
(111, 'Yani', '1420111', 'yani.111@student.univ.ac.id', 'L', 1),
(112, 'Krisna Lubis', '1340112', 'krisna.112@student.univ.ac.id', 'P', 2),
(113, 'Lina Darmawan', '1340113', 'lina.113@student.univ.ac.id', 'L', 3),
(114, 'Dwi Winarto', '1250114', 'dwi.114@student.univ.ac.id', 'L', 4),
(115, 'Nadya Kusuma', '1420115', 'nadya.115@student.univ.ac.id', 'P', 5),
(116, 'Fikri Herman', '1350116', 'fikri.116@student.univ.ac.id', 'L', 6),
(117, 'Rama Hartono', '1320117', 'rama.117@student.univ.ac.id', 'L', 7),
(118, 'Yeni Pratama', '1450118', 'yeni.118@student.univ.ac.id', 'P', 8),
(119, 'Susanti Nugroho', '1350119', 'susanti.119@student.univ.ac.id', 'L', 9),
(120, 'Wawan Tan', '1320120', 'wawan.120@student.univ.ac.id', 'L', 10),
(121, 'Pipit Suharto', '1310121', 'pipit.121@student.univ.ac.id', 'P', 11),
(122, 'Lukman Santoso', '1240122', 'lukman.122@student.univ.ac.id', 'L', 1),
(123, 'Joko Wibowo', '1230123', 'joko.123@student.univ.ac.id', 'L', 2),
(124, 'Rudi', '1340124', 'rudi.124@student.univ.ac.id', 'P', 3),
(125, 'Iqbal', '1330125', 'iqbal.125@student.univ.ac.id', 'L', 4),
(126, 'Jefri Daulay', '1220126', 'jefri.126@student.univ.ac.id', 'L', 5),
(127, 'Bella Siregar', '1430127', 'bella.127@student.univ.ac.id', 'P', 6),
(128, 'Bagus Wijaya', '1210128', 'bagus.128@student.univ.ac.id', 'L', 7),
(129, 'Irwan Tarigan', '1440129', 'irwan.129@student.univ.ac.id', 'L', 8),
(130, 'Candra Setiawan', '1220130', 'candra.130@student.univ.ac.id', 'P', 9),
(131, 'Galih Manurung', '1230131', 'galih.131@student.univ.ac.id', 'L', 10),
(132, 'Tata Simanjuntak', '1410132', 'tata.132@student.univ.ac.id', 'L', 11),
(133, 'Fani Saputra', '1230133', 'fani.133@student.univ.ac.id', 'P', 1),
(134, 'Gina Prabowo', '1430134', 'gina.134@student.univ.ac.id', 'L', 2),
(135, 'Via Cahyono', '1410135', 'via.135@student.univ.ac.id', 'L', 3),
(136, 'Bunga Sulaiman', '1320136', 'bunga.136@student.univ.ac.id', 'P', 4),
(137, 'Cindy Yulianto', '1350137', 'cindy.137@student.univ.ac.id', 'L', 5),
(138, 'Boni Siregar', '1220138', 'boni.138@student.univ.ac.id', 'L', 6),
(139, 'Olga Simatupang', '1320139', 'olga.139@student.univ.ac.id', 'P', 7),
(140, 'Ida Lumbantobing', '1320140', 'ida.140@student.univ.ac.id', 'L', 8),
(141, 'Nina', '1350141', 'nina.141@student.univ.ac.id', 'L', 9),
(142, 'Ucok Purnama', '1330142', 'ucok.142@student.univ.ac.id', 'P', 10),
(143, 'Siska Halim', '1340143', 'siska.143@student.univ.ac.id', 'L', 11),
(144, 'Eko', '1250144', 'eko.144@student.univ.ac.id', 'L', 1),
(145, 'Edi Siahaan', '1340145', 'edi.145@student.univ.ac.id', 'P', 2),
(146, 'Jamil', '1440146', 'jamil.146@student.univ.ac.id', 'L', 3),
(147, 'Ilham Nainggolan', '1210147', 'ilham.147@student.univ.ac.id', 'L', 4),
(148, 'Vina Wulandari', '1410148', 'vina.148@student.univ.ac.id', 'P', 5),
(149, 'Iwan Susanto', '1420149', 'iwan.149@student.univ.ac.id', 'L', 6),
(150, 'Intan Lim', '1220150', 'intan.150@student.univ.ac.id', 'L', 7),
(151, 'Elen', '1410151', 'elen.151@student.univ.ac.id', 'P', 8),
(152, 'Hendra Suryanto', '1450152', 'hendra.152@student.univ.ac.id', 'L', 9),
(153, 'Lilis Sihombing', '1340153', 'lilis.153@student.univ.ac.id', 'L', 10),
(154, 'Ayu Purba', '1430154', 'ayu.154@student.univ.ac.id', 'P', 11),
(155, 'Andi Hasibuan', '1250155', 'andi.155@student.univ.ac.id', 'L', 1),
(156, 'Desi Situmeang', '1430156', 'desi.156@student.univ.ac.id', 'L', 2),
(157, 'Bayu Siregar', '1410157', 'bayu.157@student.univ.ac.id', 'P', 3),
(158, 'Jihan Sitompul', '1310158', 'jihan.158@student.univ.ac.id', 'L', 4),
(159, 'Dania', '1220159', 'dania.159@student.univ.ac.id', 'L', 5),
(160, 'Laily Hutapea', '1250160', 'laily.160@student.univ.ac.id', 'P', 6),
(161, 'Wulan Sembiring', '1320161', 'wulan.161@student.univ.ac.id', 'L', 7),
(162, 'Citra', '1230162', 'citra.162@student.univ.ac.id', 'L', 8),
(163, 'Rizky Gunawan', '1330163', 'rizky.163@student.univ.ac.id', 'P', 9),
(164, 'Momon Rajagukguk', '1210164', 'momon.164@student.univ.ac.id', 'L', 10),
(165, 'Yoga Dalimunthe', '1420165', 'yoga.165@student.univ.ac.id', 'L', 11),
(166, 'Geri Ginting', '1450166', 'geri.166@student.univ.ac.id', 'P', 1),
(167, 'Sri Santoso', '1420167', 'sri.167@student.univ.ac.id', 'L', 2),
(168, 'Budi Salim', '1250168', 'budi.168@student.univ.ac.id', 'L', 3),
(169, 'Fajar Sitanggang', '1340169', 'fajar.169@student.univ.ac.id', 'P', 4),
(170, 'Siska', '1430170', 'siska.170@student.univ.ac.id', 'L', 5),
(171, 'Eva Hidayat', '1230171', 'eva.171@student.univ.ac.id', 'L', 6),
(172, 'Lisa Marpaung', '1340172', 'lisa.172@student.univ.ac.id', 'P', 7),
(173, 'Umar Ritonga', '1450173', 'umar.173@student.univ.ac.id', 'L', 8),
(174, 'Mila Iskandar', '1220174', 'mila.174@student.univ.ac.id', 'L', 9),
(175, 'Kurni Nasution', '1440175', 'kurni.175@student.univ.ac.id', 'P', 10),
(176, 'Fanny Utami', '1410176', 'fanny.176@student.univ.ac.id', 'L', 11),
(177, 'Kevin Siregar', '1250177', 'kevin.177@student.univ.ac.id', 'L', 1),
(178, 'Tika Siburian', '1440178', 'tika.178@student.univ.ac.id', 'P', 2),
(179, 'Willy Harahap', '1410179', 'willy.179@student.univ.ac.id', 'L', 3),
(180, 'Ulfah Sinaga', '1340180', 'ulfah.180@student.univ.ac.id', 'L', 4),
(181, 'Opik', '1350181', 'opik.181@student.univ.ac.id', 'P', 5),
(182, 'Kadek Lubis', '1240182', 'kadek.182@student.univ.ac.id', 'L', 6),
(183, 'Adi Darmawan', '1230183', 'adi.183@student.univ.ac.id', 'L', 7),
(184, 'Hadi Winarto', '1310184', 'hadi.184@student.univ.ac.id', 'P', 8),
(185, 'Indah Kusuma', '1430185', 'indah.185@student.univ.ac.id', 'L', 9),
(186, 'Winda Herman', '1230186', 'winda.186@student.univ.ac.id', 'L', 10),
(187, 'Tari Hartono', '1340187', 'tari.187@student.univ.ac.id', 'P', 11),
(188, 'Yanti Pratama', '1430188', 'yanti.188@student.univ.ac.id', 'L', 1),
(189, 'Geby Nugroho', '1450189', 'geby.189@student.univ.ac.id', 'L', 2),
(190, 'Santi Tan', '1340190', 'santi.190@student.univ.ac.id', 'P', 3),
(191, 'Dimas Suharto', '1450191', 'dimas.191@student.univ.ac.id', 'L', 4),
(192, 'Jordi Santoso', '1210192', 'jordi.192@student.univ.ac.id', 'L', 5),
(193, 'Maya Wibowo', '1350193', 'maya.193@student.univ.ac.id', 'P', 6),
(194, 'Made', '1310194', 'made.194@student.univ.ac.id', 'L', 7),
(195, 'Sari', '1330195', 'sari.195@student.univ.ac.id', 'L', 8),
(196, 'Euis Daulay', '1210196', 'euis.196@student.univ.ac.id', 'P', 9),
(197, 'Kamil Siregar', '1220197', 'kamil.197@student.univ.ac.id', 'L', 10),
(198, 'Gita Wijaya', '1450198', 'gita.198@student.univ.ac.id', 'L', 11),
(199, 'Feri Tarigan', '1310199', 'feri.199@student.univ.ac.id', 'P', 1),
(200, 'Hani Setiawan', '1450200', 'hani.200@student.univ.ac.id', 'L', 2);

-- ---------- USERS ----------
TRUNCATE TABLE `users`;
INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
(1, '127.0.0.1', 'admin', '$2y$10$qVSPvyDpXbT81LyOw8MNkek9RpPImEaaVMDnOkLE62BMbiXbyNNHS', 'admin@admin.com', NULL, '', NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Admin', 'System', 'ADMIN', 0),
(2, '127.0.0.1', 19742824, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'ahmad.fauzi@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fauzi', '', NULL, NULL),
(3, '127.0.0.1', 19751409, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'siti.rahmawati@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rahmawati', '', NULL, NULL),
(4, '127.0.0.1', 19765506, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'bambang.supriyadi@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Supriyadi', '', NULL, NULL),
(5, '127.0.0.1', 19775012, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'dewi.sartika@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Sartika', '', NULL, NULL),
(6, '127.0.0.1', 19784657, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'eko.prasetyo@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Prasetyo', '', NULL, NULL),
(7, '127.0.0.1', 19793286, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'fitri.handayani@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Handayani', '', NULL, NULL),
(8, '127.0.0.1', 19802679, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'gunawan.wijaya@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Wijaya', '', NULL, NULL),
(9, '127.0.0.1', 19819935, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'hendra.gunawan@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Gunawan', '', NULL, NULL),
(10, '127.0.0.1', 19822424, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'indah.permata@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Sari', '', NULL, NULL),
(11, '127.0.0.1', 19837912, '$2y$10$zC2mAY1AakClevIvukn1du5CBqvcPhxBlkz7baTSsHpR1L.bgEHWy', 'joko.susilo@univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Susilo', '', NULL, NULL),
(12, '127.0.0.1', 1310001, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yuni.1@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yuni', '', NULL, NULL),
(13, '127.0.0.1', 1250002, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'intan.2@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Intan', 'Purnama', NULL, NULL),
(14, '127.0.0.1', 1230003, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'nia.3@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Nia', 'Halim', NULL, NULL),
(15, '127.0.0.1', 1240004, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'oni.4@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Oni', '', NULL, NULL),
(16, '127.0.0.1', 1430005, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'betty.5@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Betty', 'Siahaan', NULL, NULL),
(17, '127.0.0.1', 1310006, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'leni.6@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Leni', '', NULL, NULL),
(18, '127.0.0.1', 1220007, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'nanda.7@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Nanda', 'Nainggolan', NULL, NULL),
(19, '127.0.0.1', 1220008, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'citra.8@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Citra', 'Wulandari', NULL, NULL),
(20, '127.0.0.1', 1320009, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'utami.9@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Utami', 'Susanto', NULL, NULL),
(21, '127.0.0.1', 1220010, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'winda.10@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Winda', 'Lim', NULL, NULL),
(22, '127.0.0.1', 1310011, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'dani.11@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Dani', '', NULL, NULL),
(23, '127.0.0.1', 1440012, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'oji.12@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Oji', 'Suryanto', NULL, NULL),
(24, '127.0.0.1', 1310013, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'tedi.13@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Tedi', 'Sihombing', NULL, NULL),
(25, '127.0.0.1', 1350014, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'kiki.14@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Kiki', 'Purba', NULL, NULL),
(26, '127.0.0.1', 1250015, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'caca.15@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Caca', 'Hasibuan', NULL, NULL),
(27, '127.0.0.1', 1430016, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'laras.16@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Laras', 'Situmeang', NULL, NULL),
(28, '127.0.0.1', 1210017, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yuda.17@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yuda', 'Siregar', NULL, NULL),
(29, '127.0.0.1', 1420018, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'vera.18@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Vera', 'Sitompul', NULL, NULL),
(30, '127.0.0.1', 1330019, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'herman.19@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Herman', '', NULL, NULL),
(31, '127.0.0.1', 1340020, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'dedi.20@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Dedi', 'Hutapea', NULL, NULL),
(32, '127.0.0.1', 1220021, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'dodo.21@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Dodo', 'Sembiring', NULL, NULL),
(33, '127.0.0.1', 1450022, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'putri.22@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Putri', '', NULL, NULL),
(34, '127.0.0.1', 1320023, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ujang.23@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ujang', 'Gunawan', NULL, NULL),
(35, '127.0.0.1', 1220024, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'rini.24@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rini', 'Rajagukguk', NULL, NULL),
(36, '127.0.0.1', 1340025, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'hesti.25@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Hesti', 'Dalimunthe', NULL, NULL),
(37, '127.0.0.1', 1250026, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'gilang.26@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Gilang', 'Ginting', NULL, NULL),
(38, '127.0.0.1', 1440027, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'bunga.27@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Bunga', 'Santoso', NULL, NULL),
(39, '127.0.0.1', 1410028, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'arif.28@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Arif', 'Salim', NULL, NULL),
(40, '127.0.0.1', 1350029, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fajar.29@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fajar', 'Sitanggang', NULL, NULL),
(41, '127.0.0.1', 1450030, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'panca.30@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Panca', '', NULL, NULL),
(42, '127.0.0.1', 1440031, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'oman.31@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Oman', 'Hidayat', NULL, NULL),
(43, '127.0.0.1', 1310032, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'mimi.32@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Mimi', 'Marpaung', NULL, NULL),
(44, '127.0.0.1', 1350033, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'mega.33@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Mega', 'Ritonga', NULL, NULL),
(45, '127.0.0.1', 1240034, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'novi.34@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Novi', 'Iskandar', NULL, NULL),
(46, '127.0.0.1', 1420035, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'vania.35@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Vania', 'Nasution', NULL, NULL),
(47, '127.0.0.1', 1220036, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'dian.36@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Dian', 'Utami', NULL, NULL),
(48, '127.0.0.1', 1210037, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ratna.37@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ratna', 'Siregar', NULL, NULL),
(49, '127.0.0.1', 1410038, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'rere.38@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rere', 'Siburian', NULL, NULL),
(50, '127.0.0.1', 1240039, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'jaya.39@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Jaya', 'Harahap', NULL, NULL),
(51, '127.0.0.1', 1430040, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'risa.40@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Risa', 'Sinaga', NULL, NULL),
(52, '127.0.0.1', 1250041, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'putu.41@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Putu', '', NULL, NULL),
(53, '127.0.0.1', 1220042, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'pasha.42@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Pasha', 'Lubis', NULL, NULL),
(54, '127.0.0.1', 1440043, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'kurnia.43@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Kurnia', 'Darmawan', NULL, NULL),
(55, '127.0.0.1', 1240044, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'linda.44@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Linda', 'Winarto', NULL, NULL),
(56, '127.0.0.1', 1440045, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'endah.45@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Endah', 'Kusuma', NULL, NULL),
(57, '127.0.0.1', 1220046, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'hana.46@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Hana', 'Herman', NULL, NULL),
(58, '127.0.0.1', 1320047, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'pandi.47@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Pandi', 'Hartono', NULL, NULL),
(59, '127.0.0.1', 1250048, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'tomas.48@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Tomas', 'Pratama', NULL, NULL),
(60, '127.0.0.1', 1330049, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'heru.49@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Heru', 'Nugroho', NULL, NULL),
(61, '127.0.0.1', 1410050, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'doni.50@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Doni', 'Tan', NULL, NULL),
(62, '127.0.0.1', 1440051, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'sinta.51@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Sinta', 'Suharto', NULL, NULL),
(63, '127.0.0.1', 1310052, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'hesti.52@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Hesti', 'Santoso', NULL, NULL),
(64, '127.0.0.1', 1230053, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'pramono.53@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Pramono', 'Wibowo', NULL, NULL),
(65, '127.0.0.1', 1310054, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'mario.54@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Mario', '', NULL, NULL),
(66, '127.0.0.1', 1310055, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'vivi.55@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Vivi', '', NULL, NULL),
(67, '127.0.0.1', 1240056, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ahmad.56@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ahmad', 'Daulay', NULL, NULL),
(68, '127.0.0.1', 1410057, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fandi.57@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fandi', 'Siregar', NULL, NULL),
(69, '127.0.0.1', 1250058, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'novan.58@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Novan', 'Wijaya', NULL, NULL),
(70, '127.0.0.1', 1420059, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'rina.59@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rina', 'Tarigan', NULL, NULL),
(71, '127.0.0.1', 1450060, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'okta.60@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Okta', 'Setiawan', NULL, NULL),
(72, '127.0.0.1', 1410061, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'oki.61@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Oki', 'Manurung', NULL, NULL),
(73, '127.0.0.1', 1410062, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'puji.62@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Puji', 'Simanjuntak', NULL, NULL),
(74, '127.0.0.1', 1220063, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ardi.63@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ardi', 'Saputra', NULL, NULL),
(75, '127.0.0.1', 1350064, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'vina.64@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Vina', 'Prabowo', NULL, NULL),
(76, '127.0.0.1', 1410065, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'cici.65@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Cici', 'Cahyono', NULL, NULL),
(77, '127.0.0.1', 1230066, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'mira.66@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Mira', 'Sulaiman', NULL, NULL),
(78, '127.0.0.1', 1340067, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fauzi.67@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fauzi', 'Yulianto', NULL, NULL),
(79, '127.0.0.1', 1420068, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'umi.68@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Umi', 'Siregar', NULL, NULL),
(80, '127.0.0.1', 1240069, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'oscar.69@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Oscar', 'Simatupang', NULL, NULL),
(81, '127.0.0.1', 1230070, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'wira.70@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Wira', 'Lumbantobing', NULL, NULL),
(82, '127.0.0.1', 1330071, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'niken.71@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Niken', '', NULL, NULL),
(83, '127.0.0.1', 1320072, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'aditya.72@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Aditya', 'Purnama', NULL, NULL),
(84, '127.0.0.1', 1250073, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'wahyu.73@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Wahyu', 'Halim', NULL, NULL),
(85, '127.0.0.1', 1450074, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'taufik.74@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Taufik', '', NULL, NULL),
(86, '127.0.0.1', 1410075, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'jesika.75@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Jesika', 'Siahaan', NULL, NULL),
(87, '127.0.0.1', 1420076, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'agus.76@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Agus', '', NULL, NULL),
(88, '127.0.0.1', 1340077, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'rian.77@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rian', 'Nainggolan', NULL, NULL),
(89, '127.0.0.1', 1240078, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'nana.78@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Nana', 'Wulandari', NULL, NULL),
(90, '127.0.0.1', 1410079, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'juni.79@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Juni', 'Susanto', NULL, NULL),
(91, '127.0.0.1', 1310080, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'sena.80@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Sena', 'Lim', NULL, NULL),
(92, '127.0.0.1', 1440081, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'uci.81@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Uci', '', NULL, NULL),
(93, '127.0.0.1', 1430082, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ina.82@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ina', 'Suryanto', NULL, NULL),
(94, '127.0.0.1', 1430083, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yayan.83@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yayan', 'Sihombing', NULL, NULL),
(95, '127.0.0.1', 1210084, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'aliya.84@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Aliya', 'Purba', NULL, NULL),
(96, '127.0.0.1', 1240085, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'juli.85@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Juli', 'Hasibuan', NULL, NULL),
(97, '127.0.0.1', 1440086, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'komang.86@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Komang', 'Situmeang', NULL, NULL),
(98, '127.0.0.1', 1210087, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'teguh.87@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Teguh', 'Siregar', NULL, NULL),
(99, '127.0.0.1', 1430088, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'hasan.88@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Hasan', 'Sitompul', NULL, NULL),
(100, '127.0.0.1', 1310089, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'nizar.89@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Nizar', '', NULL, NULL),
(101, '127.0.0.1', 1320090, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'uswa.90@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Uswa', 'Hutapea', NULL, NULL),
(102, '127.0.0.1', 1250091, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'tono.91@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Tono', 'Sembiring', NULL, NULL),
(103, '127.0.0.1', 1220092, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'santi.92@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Santi', '', NULL, NULL),
(104, '127.0.0.1', 1240093, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'pandu.93@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Pandu', 'Gunawan', NULL, NULL),
(105, '127.0.0.1', 1450094, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'maman.94@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Maman', 'Rajagukguk', NULL, NULL),
(106, '127.0.0.1', 1350095, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yuni.95@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yuni', 'Dalimunthe', NULL, NULL),
(107, '127.0.0.1', 1450096, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'gilang.96@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Gilang', 'Ginting', NULL, NULL),
(108, '127.0.0.1', 1420097, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'erna.97@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Erna', 'Santoso', NULL, NULL),
(109, '127.0.0.1', 1310098, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fany.98@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fany', 'Salim', NULL, NULL),
(110, '127.0.0.1', 1240099, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'cici.99@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Cici', 'Sitanggang', NULL, NULL),
(111, '127.0.0.1', 1410100, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'gusti.100@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Gusti', '', NULL, NULL),
(112, '127.0.0.1', 1330101, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'tio.101@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Tio', 'Hidayat', NULL, NULL),
(113, '127.0.0.1', 1320102, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'eka.102@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Eka', 'Marpaung', NULL, NULL),
(114, '127.0.0.1', 1450103, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'galuh.103@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Galuh', 'Ritonga', NULL, NULL),
(115, '127.0.0.1', 1450104, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ewin.104@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ewin', 'Iskandar', NULL, NULL),
(116, '127.0.0.1', 1410105, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'lala.105@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Lala', 'Nasution', NULL, NULL),
(117, '127.0.0.1', 1330106, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'kartika.106@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Kartika', 'Utami', NULL, NULL),
(118, '127.0.0.1', 1230107, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'wasis.107@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Wasis', 'Siregar', NULL, NULL),
(119, '127.0.0.1', 1250108, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'olla.108@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Olla', 'Siburian', NULL, NULL),
(120, '127.0.0.1', 1230109, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ucok.109@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ucok', 'Harahap', NULL, NULL),
(121, '127.0.0.1', 1240110, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'bima.110@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Bima', 'Sinaga', NULL, NULL),
(122, '127.0.0.1', 1420111, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yani.111@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yani', '', NULL, NULL),
(123, '127.0.0.1', 1340112, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'krisna.112@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Krisna', 'Lubis', NULL, NULL),
(124, '127.0.0.1', 1340113, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'lina.113@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Lina', 'Darmawan', NULL, NULL),
(125, '127.0.0.1', 1250114, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'dwi.114@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Dwi', 'Winarto', NULL, NULL),
(126, '127.0.0.1', 1420115, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'nadya.115@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Nadya', 'Kusuma', NULL, NULL),
(127, '127.0.0.1', 1350116, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fikri.116@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fikri', 'Herman', NULL, NULL),
(128, '127.0.0.1', 1320117, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'rama.117@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rama', 'Hartono', NULL, NULL),
(129, '127.0.0.1', 1450118, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yeni.118@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yeni', 'Pratama', NULL, NULL),
(130, '127.0.0.1', 1350119, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'susanti.119@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Susanti', 'Nugroho', NULL, NULL),
(131, '127.0.0.1', 1320120, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'wawan.120@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Wawan', 'Tan', NULL, NULL),
(132, '127.0.0.1', 1310121, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'pipit.121@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Pipit', 'Suharto', NULL, NULL),
(133, '127.0.0.1', 1240122, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'lukman.122@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Lukman', 'Santoso', NULL, NULL),
(134, '127.0.0.1', 1230123, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'joko.123@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Joko', 'Wibowo', NULL, NULL),
(135, '127.0.0.1', 1340124, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'rudi.124@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rudi', '', NULL, NULL),
(136, '127.0.0.1', 1330125, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'iqbal.125@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Iqbal', '', NULL, NULL),
(137, '127.0.0.1', 1220126, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'jefri.126@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Jefri', 'Daulay', NULL, NULL),
(138, '127.0.0.1', 1430127, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'bella.127@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Bella', 'Siregar', NULL, NULL),
(139, '127.0.0.1', 1210128, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'bagus.128@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Bagus', 'Wijaya', NULL, NULL),
(140, '127.0.0.1', 1440129, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'irwan.129@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Irwan', 'Tarigan', NULL, NULL),
(141, '127.0.0.1', 1220130, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'candra.130@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Candra', 'Setiawan', NULL, NULL),
(142, '127.0.0.1', 1230131, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'galih.131@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Galih', 'Manurung', NULL, NULL),
(143, '127.0.0.1', 1410132, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'tata.132@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Tata', 'Simanjuntak', NULL, NULL),
(144, '127.0.0.1', 1230133, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fani.133@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fani', 'Saputra', NULL, NULL),
(145, '127.0.0.1', 1430134, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'gina.134@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Gina', 'Prabowo', NULL, NULL),
(146, '127.0.0.1', 1410135, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'via.135@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Via', 'Cahyono', NULL, NULL),
(147, '127.0.0.1', 1320136, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'bunga.136@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Bunga', 'Sulaiman', NULL, NULL),
(148, '127.0.0.1', 1350137, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'cindy.137@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Cindy', 'Yulianto', NULL, NULL),
(149, '127.0.0.1', 1220138, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'boni.138@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Boni', 'Siregar', NULL, NULL),
(150, '127.0.0.1', 1320139, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'olga.139@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Olga', 'Simatupang', NULL, NULL),
(151, '127.0.0.1', 1320140, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ida.140@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ida', 'Lumbantobing', NULL, NULL),
(152, '127.0.0.1', 1350141, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'nina.141@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Nina', '', NULL, NULL),
(153, '127.0.0.1', 1330142, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ucok.142@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ucok', 'Purnama', NULL, NULL),
(154, '127.0.0.1', 1340143, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'siska.143@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Siska', 'Halim', NULL, NULL),
(155, '127.0.0.1', 1250144, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'eko.144@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Eko', '', NULL, NULL),
(156, '127.0.0.1', 1340145, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'edi.145@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Edi', 'Siahaan', NULL, NULL),
(157, '127.0.0.1', 1440146, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'jamil.146@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Jamil', '', NULL, NULL),
(158, '127.0.0.1', 1210147, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ilham.147@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ilham', 'Nainggolan', NULL, NULL),
(159, '127.0.0.1', 1410148, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'vina.148@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Vina', 'Wulandari', NULL, NULL),
(160, '127.0.0.1', 1420149, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'iwan.149@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Iwan', 'Susanto', NULL, NULL),
(161, '127.0.0.1', 1220150, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'intan.150@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Intan', 'Lim', NULL, NULL),
(162, '127.0.0.1', 1410151, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'elen.151@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Elen', '', NULL, NULL),
(163, '127.0.0.1', 1450152, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'hendra.152@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Hendra', 'Suryanto', NULL, NULL),
(164, '127.0.0.1', 1340153, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'lilis.153@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Lilis', 'Sihombing', NULL, NULL),
(165, '127.0.0.1', 1430154, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ayu.154@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ayu', 'Purba', NULL, NULL),
(166, '127.0.0.1', 1250155, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'andi.155@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Andi', 'Hasibuan', NULL, NULL),
(167, '127.0.0.1', 1430156, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'desi.156@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Desi', 'Situmeang', NULL, NULL),
(168, '127.0.0.1', 1410157, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'bayu.157@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Bayu', 'Siregar', NULL, NULL),
(169, '127.0.0.1', 1310158, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'jihan.158@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Jihan', 'Sitompul', NULL, NULL),
(170, '127.0.0.1', 1220159, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'dania.159@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Dania', '', NULL, NULL),
(171, '127.0.0.1', 1250160, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'laily.160@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Laily', 'Hutapea', NULL, NULL),
(172, '127.0.0.1', 1320161, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'wulan.161@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Wulan', 'Sembiring', NULL, NULL),
(173, '127.0.0.1', 1230162, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'citra.162@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Citra', '', NULL, NULL),
(174, '127.0.0.1', 1330163, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'rizky.163@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Rizky', 'Gunawan', NULL, NULL),
(175, '127.0.0.1', 1210164, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'momon.164@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Momon', 'Rajagukguk', NULL, NULL),
(176, '127.0.0.1', 1420165, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yoga.165@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yoga', 'Dalimunthe', NULL, NULL),
(177, '127.0.0.1', 1450166, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'geri.166@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Geri', 'Ginting', NULL, NULL),
(178, '127.0.0.1', 1420167, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'sri.167@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Sri', 'Santoso', NULL, NULL),
(179, '127.0.0.1', 1250168, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'budi.168@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Budi', 'Salim', NULL, NULL),
(180, '127.0.0.1', 1340169, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fajar.169@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fajar', 'Sitanggang', NULL, NULL),
(181, '127.0.0.1', 1430170, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'siska.170@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Siska', '', NULL, NULL),
(182, '127.0.0.1', 1230171, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'eva.171@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Eva', 'Hidayat', NULL, NULL),
(183, '127.0.0.1', 1340172, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'lisa.172@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Lisa', 'Marpaung', NULL, NULL),
(184, '127.0.0.1', 1450173, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'umar.173@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Umar', 'Ritonga', NULL, NULL),
(185, '127.0.0.1', 1220174, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'mila.174@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Mila', 'Iskandar', NULL, NULL),
(186, '127.0.0.1', 1440175, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'kurni.175@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Kurni', 'Nasution', NULL, NULL),
(187, '127.0.0.1', 1410176, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'fanny.176@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Fanny', 'Utami', NULL, NULL),
(188, '127.0.0.1', 1250177, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'kevin.177@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Kevin', 'Siregar', NULL, NULL),
(189, '127.0.0.1', 1440178, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'tika.178@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Tika', 'Siburian', NULL, NULL),
(190, '127.0.0.1', 1410179, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'willy.179@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Willy', 'Harahap', NULL, NULL),
(191, '127.0.0.1', 1340180, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'ulfah.180@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Ulfah', 'Sinaga', NULL, NULL),
(192, '127.0.0.1', 1350181, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'opik.181@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Opik', '', NULL, NULL),
(193, '127.0.0.1', 1240182, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'kadek.182@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Kadek', 'Lubis', NULL, NULL),
(194, '127.0.0.1', 1230183, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'adi.183@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Adi', 'Darmawan', NULL, NULL),
(195, '127.0.0.1', 1310184, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'hadi.184@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Hadi', 'Winarto', NULL, NULL),
(196, '127.0.0.1', 1430185, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'indah.185@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Indah', 'Kusuma', NULL, NULL),
(197, '127.0.0.1', 1230186, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'winda.186@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Winda', 'Herman', NULL, NULL),
(198, '127.0.0.1', 1340187, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'tari.187@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Tari', 'Hartono', NULL, NULL),
(199, '127.0.0.1', 1430188, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'yanti.188@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Yanti', 'Pratama', NULL, NULL),
(200, '127.0.0.1', 1450189, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'geby.189@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Geby', 'Nugroho', NULL, NULL),
(201, '127.0.0.1', 1340190, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'santi.190@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Santi', 'Tan', NULL, NULL),
(202, '127.0.0.1', 1450191, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'dimas.191@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Dimas', 'Suharto', NULL, NULL),
(203, '127.0.0.1', 1210192, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'jordi.192@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Jordi', 'Santoso', NULL, NULL),
(204, '127.0.0.1', 1350193, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'maya.193@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Maya', 'Wibowo', NULL, NULL),
(205, '127.0.0.1', 1310194, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'made.194@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Made', '', NULL, NULL),
(206, '127.0.0.1', 1330195, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'sari.195@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Sari', '', NULL, NULL),
(207, '127.0.0.1', 1210196, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'euis.196@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Euis', 'Daulay', NULL, NULL),
(208, '127.0.0.1', 1220197, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'kamil.197@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Kamil', 'Siregar', NULL, NULL),
(209, '127.0.0.1', 1450198, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'gita.198@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Gita', 'Wijaya', NULL, NULL),
(210, '127.0.0.1', 1310199, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'feri.199@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Feri', 'Tarigan', NULL, NULL),
(211, '127.0.0.1', 1450200, '$2y$10$Y2kL/xT257qsJYVcZ6VrAeDN6QFxgzmA90dZwujmsmGXhWHEIhDLO', 'hani.200@student.univ.ac.id', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1722000000, 1722000000, 1, 'Hani', 'Setiawan', NULL, NULL);

-- ---------- USERS_GROUPS ----------
TRUNCATE TABLE `users_groups`;
INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 2),
(4, 4, 2),
(5, 5, 2),
(6, 6, 2),
(7, 7, 2),
(8, 8, 2),
(9, 9, 2),
(10, 10, 2),
(11, 11, 2),
(12, 12, 3),
(13, 13, 3),
(14, 14, 3),
(15, 15, 3),
(16, 16, 3),
(17, 17, 3),
(18, 18, 3),
(19, 19, 3),
(20, 20, 3),
(21, 21, 3),
(22, 22, 3),
(23, 23, 3),
(24, 24, 3),
(25, 25, 3),
(26, 26, 3),
(27, 27, 3),
(28, 28, 3),
(29, 29, 3),
(30, 30, 3),
(31, 31, 3),
(32, 32, 3),
(33, 33, 3),
(34, 34, 3),
(35, 35, 3),
(36, 36, 3),
(37, 37, 3),
(38, 38, 3),
(39, 39, 3),
(40, 40, 3),
(41, 41, 3),
(42, 42, 3),
(43, 43, 3),
(44, 44, 3),
(45, 45, 3),
(46, 46, 3),
(47, 47, 3),
(48, 48, 3),
(49, 49, 3),
(50, 50, 3),
(51, 51, 3),
(52, 52, 3),
(53, 53, 3),
(54, 54, 3),
(55, 55, 3),
(56, 56, 3),
(57, 57, 3),
(58, 58, 3),
(59, 59, 3),
(60, 60, 3),
(61, 61, 3),
(62, 62, 3),
(63, 63, 3),
(64, 64, 3),
(65, 65, 3),
(66, 66, 3),
(67, 67, 3),
(68, 68, 3),
(69, 69, 3),
(70, 70, 3),
(71, 71, 3),
(72, 72, 3),
(73, 73, 3),
(74, 74, 3),
(75, 75, 3),
(76, 76, 3),
(77, 77, 3),
(78, 78, 3),
(79, 79, 3),
(80, 80, 3),
(81, 81, 3),
(82, 82, 3),
(83, 83, 3),
(84, 84, 3),
(85, 85, 3),
(86, 86, 3),
(87, 87, 3),
(88, 88, 3),
(89, 89, 3),
(90, 90, 3),
(91, 91, 3),
(92, 92, 3),
(93, 93, 3),
(94, 94, 3),
(95, 95, 3),
(96, 96, 3),
(97, 97, 3),
(98, 98, 3),
(99, 99, 3),
(100, 100, 3),
(101, 101, 3),
(102, 102, 3),
(103, 103, 3),
(104, 104, 3),
(105, 105, 3),
(106, 106, 3),
(107, 107, 3),
(108, 108, 3),
(109, 109, 3),
(110, 110, 3),
(111, 111, 3),
(112, 112, 3),
(113, 113, 3),
(114, 114, 3),
(115, 115, 3),
(116, 116, 3),
(117, 117, 3),
(118, 118, 3),
(119, 119, 3),
(120, 120, 3),
(121, 121, 3),
(122, 122, 3),
(123, 123, 3),
(124, 124, 3),
(125, 125, 3),
(126, 126, 3),
(127, 127, 3),
(128, 128, 3),
(129, 129, 3),
(130, 130, 3),
(131, 131, 3),
(132, 132, 3),
(133, 133, 3),
(134, 134, 3),
(135, 135, 3),
(136, 136, 3),
(137, 137, 3),
(138, 138, 3),
(139, 139, 3),
(140, 140, 3),
(141, 141, 3),
(142, 142, 3),
(143, 143, 3),
(144, 144, 3),
(145, 145, 3),
(146, 146, 3),
(147, 147, 3),
(148, 148, 3),
(149, 149, 3),
(150, 150, 3),
(151, 151, 3),
(152, 152, 3),
(153, 153, 3),
(154, 154, 3),
(155, 155, 3),
(156, 156, 3),
(157, 157, 3),
(158, 158, 3),
(159, 159, 3),
(160, 160, 3),
(161, 161, 3),
(162, 162, 3),
(163, 163, 3),
(164, 164, 3),
(165, 165, 3),
(166, 166, 3),
(167, 167, 3),
(168, 168, 3),
(169, 169, 3),
(170, 170, 3),
(171, 171, 3),
(172, 172, 3),
(173, 173, 3),
(174, 174, 3),
(175, 175, 3),
(176, 176, 3),
(177, 177, 3),
(178, 178, 3),
(179, 179, 3),
(180, 180, 3),
(181, 181, 3),
(182, 182, 3),
(183, 183, 3),
(184, 184, 3),
(185, 185, 3),
(186, 186, 3),
(187, 187, 3),
(188, 188, 3),
(189, 189, 3),
(190, 190, 3),
(191, 191, 3),
(192, 192, 3),
(193, 193, 3),
(194, 194, 3),
(195, 195, 3),
(196, 196, 3),
(197, 197, 3),
(198, 198, 3),
(199, 199, 3),
(200, 200, 3),
(201, 201, 3),
(202, 202, 3),
(203, 203, 3),
(204, 204, 3),
(205, 205, 3),
(206, 206, 3),
(207, 207, 3),
(208, 208, 3),
(209, 209, 3),
(210, 210, 3),
(211, 211, 3);

-- ---------- SOAL ----------
TRUNCATE TABLE `tb_soal`;
INSERT INTO `tb_soal` (`id_soal`, `dosen_id`, `matkul_id`, `bobot`, `file`, `tipe_file`, `soal`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `opsi_e`, `file_a`, `file_b`, `file_c`, `file_d`, `file_e`, `jawaban`, `created_on`, `updated_on`) VALUES
(1, 1, 1, 1, '', '', '<p>Apa yang dimaksud dengan Database?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(2, 1, 1, 1, '', '', '<p>Berikut ini adalah contoh dari Database, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(3, 1, 1, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Basis Data?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(4, 1, 1, 1, '', '', '<p>Normalisasi pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(5, 1, 1, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang SQL?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(6, 2, 2, 1, '', '', '<p>Apa yang dimaksud dengan Use Case?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(7, 2, 2, 1, '', '', '<p>Berikut ini adalah contoh dari SDLC, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(8, 2, 2, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Flowchart?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(9, 2, 2, 1, '', '', '<p>Use Case pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(10, 2, 2, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Flowchart?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(11, 3, 3, 1, '', '', '<p>Apa yang dimaksud dengan Scrum?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(12, 3, 3, 1, '', '', '<p>Berikut ini adalah contoh dari Scrum, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(13, 3, 3, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Scrum?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(14, 3, 3, 1, '', '', '<p>Project Management pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(15, 3, 3, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Manajemen Proyek?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(16, 4, 4, 1, '', '', '<p>Apa yang dimaksud dengan E-business?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(17, 4, 4, 1, '', '', '<p>Berikut ini adalah contoh dari E-commerce, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(18, 4, 4, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan E-commerce?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(19, 4, 4, 1, '', '', '<p>E-commerce pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(20, 4, 4, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang E-commerce?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(21, 5, 5, 1, '', '', '<p>Apa yang dimaksud dengan Usability?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(22, 5, 5, 1, '', '', '<p>Berikut ini adalah contoh dari User Experience, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(23, 5, 5, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Usability?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(24, 5, 5, 1, '', '', '<p>HCI pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(25, 5, 5, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang HCI?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(26, 6, 6, 1, '', '', '<p>Apa yang dimaksud dengan Struktur Data?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(27, 6, 6, 1, '', '', '<p>Berikut ini adalah contoh dari Searching, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(28, 6, 6, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Algoritma?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(29, 6, 6, 1, '', '', '<p>Searching pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(30, 6, 6, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Searching?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(31, 7, 7, 1, '', '', '<p>Apa yang dimaksud dengan Jaringan Komputer?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(32, 7, 7, 1, '', '', '<p>Berikut ini adalah contoh dari Jaringan Komputer, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(33, 7, 7, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Routing?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(34, 7, 7, 1, '', '', '<p>Networking pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(35, 7, 7, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Networking?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(36, 8, 8, 1, '', '', '<p>Apa yang dimaksud dengan Process Management?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(37, 8, 8, 1, '', '', '<p>Berikut ini adalah contoh dari Process Management, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(38, 8, 8, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan File System?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(39, 8, 8, 1, '', '', '<p>Sistem Operasi pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(40, 8, 8, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Scheduling?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(41, 9, 9, 1, '', '', '<p>Apa yang dimaksud dengan PHP?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(42, 9, 9, 1, '', '', '<p>Berikut ini adalah contoh dari Pemrograman Web, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(43, 9, 9, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan HTML?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(44, 9, 9, 1, '', '', '<p>JavaScript pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(45, 9, 9, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang HTML?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(46, 10, 10, 1, '', '', '<p>Apa yang dimaksud dengan Cryptography?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(47, 10, 10, 1, '', '', '<p>Berikut ini adalah contoh dari Keamanan Informasi, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(48, 10, 10, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Firewall?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(49, 10, 10, 1, '', '', '<p>Firewall pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(50, 10, 10, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Cyber Security?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(51, 1, 11, 1, '', '', '<p>Apa yang dimaksud dengan Variable?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(52, 1, 11, 1, '', '', '<p>Berikut ini adalah contoh dari Variable, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(53, 1, 11, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Array?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(54, 1, 11, 1, '', '', '<p>Pemrograman Dasar pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(55, 1, 11, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Pemrograman Dasar?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(56, 1, 12, 1, '', '', '<p>Apa yang dimaksud dengan Grafik?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(57, 1, 12, 1, '', '', '<p>Berikut ini adalah contoh dari Audio, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(58, 1, 12, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Grafik?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(59, 1, 12, 1, '', '', '<p>Audio pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(60, 1, 12, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Grafik?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(61, 1, 13, 1, '', '', '<p>Apa yang dimaksud dengan Laba Rugi?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(62, 1, 13, 1, '', '', '<p>Berikut ini adalah contoh dari Laporan Keuangan, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(63, 1, 13, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Laporan Keuangan?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(64, 1, 13, 1, '', '', '<p>Akuntansi Dasar pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(65, 1, 13, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Akuntansi Dasar?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(66, 1, 14, 1, '', '', '<p>Apa yang dimaksud dengan ERP?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(67, 1, 14, 1, '', '', '<p>Berikut ini adalah contoh dari ERP, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(68, 1, 14, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan ERP?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(69, 1, 14, 1, '', '', '<p>SIM pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(70, 1, 14, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang CRM?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(71, 1, 15, 1, '', '', '<p>Apa yang dimaksud dengan Desain Grafis?</p>', '<p>Teori tentang {topic}</p>', '<p>Penerapan {topic}</p>', '<p>Definisi {topic}</p>', '<p>Sejarah {topic}</p>', '<p>Semua salah</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(72, 1, 15, 1, '', '', '<p>Berikut ini adalah contoh dari Vector, kecuali:</p>', '<p>Contoh 1</p>', '<p>Contoh 2</p>', '<p>Contoh 3</p>', '<p>Contoh 4</p>', '<p>Semua benar</p>', '', '', '', '', '', 'E', 1722000000, 1722000000),
(73, 1, 15, 1, '', '', '<p>Siapa tokoh utama dalam pengembangan Desain Grafis?</p>', '<p>Tokoh A</p>', '<p>Tokoh B</p>', '<p>Tokoh C</p>', '<p>Tokoh D</p>', '<p>Tokoh E</p>', '', '', '', '', '', 'A', 1722000000, 1722000000),
(74, 1, 15, 1, '', '', '<p>Vector pertama kali diperkenalkan pada tahun?</p>', '<p>1950</p>', '<p>1960</p>', '<p>1970</p>', '<p>1980</p>', '<p>1990</p>', '', '', '', '', '', 'C', 1722000000, 1722000000),
(75, 1, 15, 1, '', '', '<p>Manakah pernyataan yang BENAR tentang Vector?</p>', '<p>Pernyataan 1 benar</p>', '<p>Pernyataan 2 benar</p>', '<p>Pernyataan 1 dan 2 benar</p>', '<p>Semua salah</p>', '<p>Semua benar</p>', '', '', '', '', '', 'C', 1722000000, 1722000000);

-- ---------- UJIAN ----------
TRUNCATE TABLE `m_ujian`;
INSERT INTO `m_ujian` (`id_ujian`, `dosen_id`, `matkul_id`, `nama_ujian`, `jumlah_soal`, `waktu`, `jenis`, `tgl_mulai`, `terlambat`, `token`) VALUES
(1, 7, 7, 'Ujian UTS - Jaringan Komputer - Ganjil 2026', 10, 30, 'acak', '2026-07-01 08:00:00', '2026-07-15 23:59:00', 'KFEGT'),
(2, 1, 1, 'Ujian UAS - Basis Data - Genap 2026', 20, 45, 'urut', '2026-07-02 08:00:00', '2026-07-16 23:59:00', 'GJROY'),
(3, 4, 4, 'Ujian Quiz - E-commerce - Ganjil 2026', 20, 90, 'urut', '2026-07-03 08:00:00', '2026-07-17 23:59:00', 'MKPFX'),
(4, 9, 9, 'Ujian Try Out - Pemrograman Web - Genap 2026', 20, 45, 'acak', '2026-07-04 08:00:00', '2026-07-18 23:59:00', 'JKRDR'),
(5, 2, 2, 'Ujian Remidi - Analisis Sistem - Ganjil 2026', 20, 30, 'acak', '2026-07-05 08:00:00', '2026-07-19 23:59:00', 'WIYNU'),
(6, 1, 1, 'Ujian UTS - Basis Data - Genap 2026', 25, 60, 'urut', '2026-08-06 08:00:00', '2026-08-20 23:59:00', 'MKHAF'),
(7, 9, 9, 'Ujian UAS - Pemrograman Web - Ganjil 2026', 20, 45, 'acak', '2026-08-07 08:00:00', '2026-08-21 23:59:00', 'ZNMXP'),
(8, 7, 7, 'Ujian Quiz - Jaringan Komputer - Genap 2026', 25, 45, 'urut', '2026-08-08 08:00:00', '2026-08-22 23:59:00', 'ZJFXE'),
(9, 8, 8, 'Ujian Try Out - Sistem Operasi - Ganjil 2026', 20, 45, 'acak', '2026-08-09 08:00:00', '2026-08-23 23:59:00', 'UPZYR'),
(10, 8, 8, 'Ujian Remidi - Sistem Operasi - Genap 2026', 25, 90, 'acak', '2026-08-10 08:00:00', '2026-08-24 23:59:00', 'AAMVC'),
(11, 6, 6, 'Ujian UTS - Algoritma & Struktur Data - Ganjil 2026', 20, 45, 'urut', '2026-09-11 08:00:00', '2026-09-25 23:59:00', 'LCIAI'),
(12, 8, 8, 'Ujian UAS - Sistem Operasi - Genap 2026', 25, 45, 'urut', '2026-09-12 08:00:00', '2026-09-26 23:59:00', 'NFUBF'),
(13, 10, 10, 'Ujian Quiz - Keamanan Informasi - Ganjil 2026', 25, 45, 'acak', '2026-09-13 08:00:00', '2026-09-27 23:59:00', 'GKTJS'),
(14, 9, 9, 'Ujian Try Out - Pemrograman Web - Genap 2026', 15, 90, 'acak', '2026-09-14 08:00:00', '2026-09-28 23:59:00', 'XDWPT'),
(15, 2, 2, 'Ujian Remidi - Analisis Sistem - Ganjil 2026', 20, 90, 'acak', '2026-09-15 08:00:00', '2026-09-29 23:59:00', 'PKCDE');

-- ---------- HASIL UJIAN ----------
TRUNCATE TABLE `h_ujian`;
INSERT INTO `h_ujian` (`id`, `ujian_id`, `mahasiswa_id`, `list_soal`, `list_jawaban`, `jml_benar`, `nilai`, `nilai_bobot`, `tgl_mulai`, `tgl_selesai`, `status`) VALUES
(1, 3, 90, '16,17,19,18,20', '16:D:N,17:E:N,19:C:N,18:E:N,20:E:N', 0, '0.00', '100.00', '2026-07-22 16:19:00', '2026-07-05 12:07:00', 'N'),
(2, 15, 28, '10,7,9,8,6', '10:C:N,7:B:N,9:C:N,8:E:N,6:D:N', 0, '0.00', '100.00', '2026-08-28 08:05:00', '2026-08-27 12:02:00', 'N'),
(3, 1, 86, '32,33,31,35,34', '32:E:N,33:A:N,31:A:N,35:A:N,34:B:N', 0, '0.00', '100.00', '2026-07-27 13:37:00', '2026-07-14 10:02:00', 'N'),
(4, 5, 94, '6,8,10,9,7', '6:C:N,8:E:N,10:D:N,9:E:N,7:B:N', 0, '0.00', '100.00', '2026-07-28 10:51:00', '2026-07-14 08:11:00', 'N'),
(5, 12, 86, '39,37,40,36,38', '39:D:N,37:A:N,40:D:N,36:B:N,38:B:N', 0, '0.00', '100.00', '2026-08-12 12:52:00', '2026-07-08 08:42:00', 'N'),
(6, 4, 103, '43,45,41,42,44', '43:E:N,45:D:N,41:E:N,42:C:N,44:A:N', 0, '0.00', '100.00', '2026-07-09 10:37:00', '2026-08-02 09:38:00', 'N'),
(7, 7, 89, '43,44,45,41,42', '43:E:N,44:B:N,45:C:N,41:A:N,42:D:N', 0, '0.00', '100.00', '2026-07-17 16:43:00', '2026-07-12 14:04:00', 'N'),
(8, 11, 85, '30,28,29,26,27', '30:E:N,28:C:N,29:D:N,26:C:N,27:D:N', 0, '0.00', '100.00', '2026-08-18 10:12:00', '2026-08-22 14:43:00', 'N'),
(9, 12, 45, '40,38,37,36,39', '40:C:N,38:B:N,37:D:N,36:E:N,39:E:N', 0, '0.00', '100.00', '2026-08-15 15:28:00', '2026-07-17 15:50:00', 'N'),
(10, 15, 189, '7,6,10,8,9', '7:B:N,6:C:N,10:B:N,8:B:N,9:B:N', 0, '0.00', '100.00', '2026-07-02 11:30:00', '2026-07-15 14:56:00', 'N'),
(11, 11, 148, '27,29,30,28,26', '27:B:N,29:A:N,30:A:N,28:D:N,26:B:N', 0, '0.00', '100.00', '2026-07-26 16:29:00', '2026-07-18 11:58:00', 'N'),
(12, 14, 32, '44,42,45,43,41', '44:E:N,42:E:N,45:D:N,43:E:N,41:D:N', 0, '0.00', '100.00', '2026-07-24 15:28:00', '2026-08-25 11:53:00', 'N'),
(13, 11, 71, '30,29,28,26,27', '30:D:N,29:A:N,28:C:N,26:B:N,27:C:N', 0, '0.00', '100.00', '2026-08-11 16:05:00', '2026-07-05 11:24:00', 'N'),
(14, 12, 40, '37,36,40,38,39', '37:E:N,36:D:N,40:D:N,38:A:N,39:B:N', 0, '0.00', '100.00', '2026-08-13 08:54:00', '2026-08-16 08:22:00', 'N'),
(15, 5, 193, '9,10,8,6,7', '9:B:N,10:C:N,8:D:N,6:D:N,7:A:N', 0, '0.00', '100.00', '2026-08-11 14:46:00', '2026-07-27 15:58:00', 'N'),
(16, 3, 160, '20,16,17,19,18', '20:D:N,16:B:N,17:D:N,19:B:N,18:A:N', 0, '0.00', '100.00', '2026-08-13 13:13:00', '2026-08-11 13:48:00', 'N'),
(17, 15, 98, '8,9,7,6,10', '8:A:N,9:E:N,7:A:N,6:C:N,10:B:N', 0, '0.00', '100.00', '2026-07-25 08:48:00', '2026-07-08 11:53:00', 'N'),
(18, 1, 160, '32,35,31,34,33', '32:E:N,35:B:N,31:D:N,34:C:N,33:C:N', 0, '0.00', '100.00', '2026-07-20 09:49:00', '2026-07-10 09:37:00', 'N'),
(19, 1, 80, '35,34,32,31,33', '35:E:N,34:B:N,32:A:N,31:C:N,33:E:N', 0, '0.00', '100.00', '2026-07-26 08:22:00', '2026-08-22 13:04:00', 'N'),
(20, 9, 166, '38,36,37,40,39', '38:D:N,36:C:N,37:D:N,40:B:N,39:D:N', 0, '0.00', '100.00', '2026-07-24 16:41:00', '2026-08-20 16:49:00', 'N'),
(21, 8, 120, '34,33,32,31,35', '34:C:N,33:D:N,32:B:N,31:D:N,35:E:N', 0, '0.00', '100.00', '2026-08-11 08:31:00', '2026-08-06 15:13:00', 'N'),
(22, 6, 67, '3,5,4,2,1', '3:E:N,5:B:N,4:A:N,2:B:N,1:D:N', 0, '0.00', '100.00', '2026-08-18 11:44:00', '2026-08-21 15:28:00', 'N'),
(23, 13, 5, '46,48,50,47,49', '46:C:N,48:E:N,50:C:N,47:D:N,49:E:N', 0, '0.00', '100.00', '2026-08-14 16:21:00', '2026-08-23 15:17:00', 'N'),
(24, 5, 65, '7,6,8,9,10', '7:A:N,6:E:N,8:B:N,9:B:N,10:B:N', 0, '0.00', '100.00', '2026-08-09 16:38:00', '2026-08-04 11:18:00', 'N'),
(25, 4, 93, '42,43,41,44,45', '42:A:N,43:A:N,41:E:N,44:C:N,45:B:N', 0, '0.00', '100.00', '2026-08-04 08:36:00', '2026-08-16 15:28:00', 'N'),
(26, 6, 48, '1,3,2,5,4', '1:D:N,3:D:N,2:A:N,5:E:N,4:A:N', 0, '0.00', '100.00', '2026-07-05 12:05:00', '2026-07-04 16:48:00', 'N'),
(27, 7, 156, '45,42,43,44,41', '45:D:N,42:C:N,43:E:N,44:D:N,41:C:N', 0, '0.00', '100.00', '2026-07-20 09:48:00', '2026-07-21 11:16:00', 'N'),
(28, 11, 21, '27,30,26,28,29', '27:A:N,30:D:N,26:D:N,28:E:N,29:D:N', 0, '0.00', '100.00', '2026-08-02 11:18:00', '2026-08-23 15:04:00', 'N'),
(29, 11, 60, '28,27,29,26,30', '28:B:N,27:C:N,29:B:N,26:A:N,30:A:N', 0, '0.00', '100.00', '2026-07-26 12:38:00', '2026-08-15 09:29:00', 'N'),
(30, 12, 78, '39,38,40,37,36', '39:A:N,38:E:N,40:A:N,37:D:N,36:C:N', 0, '0.00', '100.00', '2026-08-01 09:14:00', '2026-07-25 12:36:00', 'N'),
(31, 1, 196, '32,34,33,35,31', '32:B:N,34:E:N,33:D:N,35:D:N,31:A:N', 0, '0.00', '100.00', '2026-08-12 14:21:00', '2026-08-22 09:54:00', 'N'),
(32, 3, 85, '19,20,17,18,16', '19:D:N,20:A:N,17:C:N,18:C:N,16:C:N', 0, '0.00', '100.00', '2026-07-25 14:55:00', '2026-07-22 16:29:00', 'N'),
(33, 7, 14, '42,43,44,45,41', '42:A:N,43:B:N,44:C:N,45:E:N,41:B:N', 0, '0.00', '100.00', '2026-08-15 15:07:00', '2026-07-21 11:45:00', 'N'),
(34, 3, 80, '20,16,18,17,19', '20:B:N,16:A:N,18:D:N,17:A:N,19:B:N', 0, '0.00', '100.00', '2026-08-23 12:32:00', '2026-08-14 15:30:00', 'N'),
(35, 4, 117, '45,42,44,41,43', '45:A:N,42:C:N,44:D:N,41:C:N,43:E:N', 0, '0.00', '100.00', '2026-08-27 08:18:00', '2026-08-27 15:55:00', 'N'),
(36, 3, 115, '20,19,17,18,16', '20:D:N,19:C:N,17:B:N,18:B:N,16:E:N', 0, '0.00', '100.00', '2026-08-08 14:02:00', '2026-08-24 15:45:00', 'N'),
(37, 15, 98, '9,7,10,6,8', '9:E:N,7:E:N,10:C:N,6:A:N,8:D:N', 0, '0.00', '100.00', '2026-07-17 15:00:00', '2026-07-14 10:04:00', 'N'),
(38, 8, 68, '33,34,35,31,32', '33:E:N,34:D:N,35:C:N,31:D:N,32:E:N', 0, '0.00', '100.00', '2026-07-20 09:15:00', '2026-08-08 09:27:00', 'N'),
(39, 2, 195, '1,4,5,2,3', '1:A:N,4:C:N,5:A:N,2:C:N,3:C:N', 0, '0.00', '100.00', '2026-08-14 10:15:00', '2026-08-19 10:10:00', 'N'),
(40, 3, 21, '20,19,18,16,17', '20:E:N,19:B:N,18:B:N,16:D:N,17:C:N', 0, '0.00', '100.00', '2026-08-09 08:57:00', '2026-08-10 16:10:00', 'N'),
(41, 2, 114, '3,5,4,2,1', '3:D:N,5:C:N,4:B:N,2:D:N,1:D:N', 0, '0.00', '100.00', '2026-07-08 14:36:00', '2026-08-19 12:44:00', 'N'),
(42, 5, 6, '9,8,6,10,7', '9:C:N,8:B:N,6:E:N,10:C:N,7:B:N', 0, '0.00', '100.00', '2026-07-20 12:43:00', '2026-07-21 09:57:00', 'N'),
(43, 11, 166, '26,28,27,30,29', '26:B:N,28:A:N,27:C:N,30:C:N,29:D:N', 0, '0.00', '100.00', '2026-07-07 10:50:00', '2026-08-17 16:58:00', 'N'),
(44, 5, 43, '8,9,7,10,6', '8:D:N,9:A:N,7:B:N,10:B:N,6:D:N', 0, '0.00', '100.00', '2026-08-03 14:00:00', '2026-08-18 09:29:00', 'N'),
(45, 6, 173, '3,4,5,2,1', '3:B:N,4:D:N,5:A:N,2:E:N,1:E:N', 0, '0.00', '100.00', '2026-08-20 11:41:00', '2026-07-21 15:58:00', 'N'),
(46, 12, 78, '39,36,40,38,37', '39:C:N,36:D:N,40:A:N,38:A:N,37:B:N', 0, '0.00', '100.00', '2026-07-13 15:23:00', '2026-08-19 10:56:00', 'N'),
(47, 7, 168, '41,44,43,42,45', '41:A:N,44:C:N,43:B:N,42:D:N,45:D:N', 0, '0.00', '100.00', '2026-07-28 13:06:00', '2026-08-18 13:03:00', 'N'),
(48, 7, 71, '42,41,45,44,43', '42:E:N,41:A:N,45:A:N,44:C:N,43:B:N', 0, '0.00', '100.00', '2026-07-26 11:04:00', '2026-07-19 11:52:00', 'N'),
(49, 14, 60, '43,42,45,41,44', '43:B:N,42:B:N,45:E:N,41:C:N,44:B:N', 0, '0.00', '100.00', '2026-07-22 08:08:00', '2026-07-12 11:37:00', 'N'),
(50, 6, 5, '2,3,1,4,5', '2:E:N,3:A:N,1:A:N,4:D:N,5:D:N', 0, '0.00', '100.00', '2026-08-17 09:28:00', '2026-07-20 08:46:00', 'N');

-- ---------- RESET AUTO_INCREMENT ----------
ALTER TABLE `groups` AUTO_INCREMENT = 4;
ALTER TABLE `jurusan` AUTO_INCREMENT = 4;
ALTER TABLE `matkul` AUTO_INCREMENT = 16;
ALTER TABLE `jurusan_matkul` AUTO_INCREMENT = 16;
ALTER TABLE `kelas` AUTO_INCREMENT = 12;
ALTER TABLE `dosen` AUTO_INCREMENT = 11;
ALTER TABLE `kelas_dosen` AUTO_INCREMENT = 21;
ALTER TABLE `mahasiswa` AUTO_INCREMENT = 201;
ALTER TABLE `users` AUTO_INCREMENT = 212;
ALTER TABLE `users_groups` AUTO_INCREMENT = 212;
ALTER TABLE `tb_soal` AUTO_INCREMENT = 76;
ALTER TABLE `m_ujian` AUTO_INCREMENT = 16;
ALTER TABLE `h_ujian` AUTO_INCREMENT = 51;

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;