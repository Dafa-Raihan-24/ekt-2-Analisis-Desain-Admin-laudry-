-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Jul 2026 pada 08.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_freshy_laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'admin', '0192023a7bbd73250516f069df18b500', 'Dafa ganteng');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(11) NOT NULL,
  `kode_pesanan` varchar(20) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `no_hp` varchar(20) NOT NULL,
  `layanan` varchar(50) NOT NULL,
  `berat` float NOT NULL,
  `total_harga` int(11) NOT NULL,
  `estimasi_selesai` varchar(30) NOT NULL,
  `status_pembayaran` varchar(20) DEFAULT 'Belum Bayar',
  `status_laundry` enum('Diterima','Dicuci','Dikeringkan','Disetrika','Packing','Bisa Diambil') DEFAULT 'Diterima',
  `tanggal_masuk` timestamp NOT NULL DEFAULT current_timestamp(),
  `dibayar_pada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id`, `kode_pesanan`, `nama_pelanggan`, `no_hp`, `layanan`, `berat`, `total_harga`, `estimasi_selesai`, `status_pembayaran`, `status_laundry`, `tanggal_masuk`, `dibayar_pada`) VALUES
(2, 'LDR-001', 'Faishal#001', '08933475687', 'Cuci Setrika', 8, 56000, '3 hari', 'Lunas', 'Packing', '2026-06-26 18:11:19', NULL),
(3, 'LDR-003', 'Dafa#001', '0813423848', 'Cuci Express', 20, 200000, '1', 'Lunas', 'Bisa Diambil', '2026-06-26 18:22:59', NULL),
(4, 'LDR-004', 'Azwan#05', '089544765476', 'Cuci Setrika', 10, 70000, '3 hari', 'Lunas', 'Bisa Diambil', '2026-06-26 18:30:09', NULL),
(5, 'LDR-005', 'Syifa23', '0835637647', 'Setrika', 20, 100000, '3 hari', 'Belum Bayar', NULL, '2026-06-26 20:06:20', NULL),
(6, 'LDR-006', 'dafakece', '081381294303', 'Cuci Express', 10, 100000, '1 hari', 'Diambil', 'Diterima', '2026-06-28 06:53:47', NULL),
(7, 'LDR-007', 'nanda', '08459837449', 'Cuci Express', 10, 100000, '1 hari', 'lunas', '', '2026-06-28 14:08:28', '2026-06-28 20:30:00'),
(8, 'LDR-008', 'syahdan', '0894723857', 'Cuci Setrika', 100, 700000, '3 hari', 'Diambil', 'Diterima', '2026-06-30 06:47:05', NULL),
(9, 'LDR-009', 'salsa', '089657482234', 'Cuci Express', 4, 40000, '1 hari', 'Diambil', 'Diterima', '2026-07-03 07:25:47', '2026-07-03 09:26:16'),
(10, 'LDR-010', 'Nurul003', '0864769354', 'Cuci Setrika', 4, 28000, '3 hari', 'Lunas', 'Bisa Diambil', '2026-07-03 07:37:28', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_pesanan` (`kode_pesanan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
