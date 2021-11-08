-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Agu 2021 pada 06.43
-- Versi server: 10.4.13-MariaDB
-- Versi PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_reynaldo`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `id` int(11) NOT NULL,
  `nama` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `no_hp` varchar(256) NOT NULL,
  `alamat` varchar(256) NOT NULL,
  `jenis_kelamin` varchar(256) NOT NULL,
  `kode_pos` int(11) NOT NULL,
  `asal_sekolah` varchar(256) NOT NULL,
  `tahun_lulus` int(11) NOT NULL,
  `jurusan` varchar(256) NOT NULL,
  `document` text DEFAULT NULL,
  `foto` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `mahasiswa`
--

INSERT INTO `mahasiswa` (`id`, `nama`, `email`, `no_hp`, `alamat`, `jenis_kelamin`, `kode_pos`, `asal_sekolah`, `tahun_lulus`, `jurusan`, `document`, `foto`) VALUES
(2, 'reynaldo saut lumbantobing', 'test@test.com', '087824073414', 'Jakarta', 'Laki-Laki', 53223, 'Sma N 2 Cilacap', 2014, 'IPA', 'ijazah_1626855527_roy.pdf', 'foto_1626855526_roy.jpg'),
(4, 'Bentaeee', 'yuhu@ahha.com', '087824073515', 'Jakarta', 'Laki-Laki', 53223, 'Sma N 2 Cilacap', 2014, 'Teknik Informatika', 'ijazah_1626875272_Bentaeee.pdf', 'foto_1626875271_Bentaeee.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name_user` varchar(256) NOT NULL,
  `nim` char(11) NOT NULL,
  `username` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `jurusan` varchar(256) NOT NULL,
  `fakultas` varchar(256) NOT NULL,
  `date_created` int(11) NOT NULL,
  `photo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `name_user`, `nim`, `username`, `email`, `password`, `jurusan`, `fakultas`, `date_created`, `photo`) VALUES
(1, 'Virgy Aldi Rizki Utama', '41518120009', 'admin', '41518120009@student.mercubuana.ac.id', '$2y$10$ih/9kDA/56J9QmcCD8Ud8.4wtMeKBHbA8QfUJUUnYAQGbnIeioN6u', 'Teknik Informatika', 'Ilmu Komputer', 1625983999, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `mahasiswa`
--
ALTER TABLE `mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
