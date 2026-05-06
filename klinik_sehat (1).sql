-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Bulan Mei 2026 pada 18.18
-- Versi server: 10.4.28-MariaDB-log
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `klinik_sehat`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `admins`
--

INSERT INTO `admins` (`id`, `nama_lengkap`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Manager Klinik', 'admin', '$2y$12$0Mt37dFdT0c61TJt9HZAqOxYiMaHIJucd2clVUyZ3t6nJuoKapNSy', '2026-04-25 13:09:27', '2026-04-25 13:09:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `alkes`
--

CREATE TABLE `alkes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga_beli` int(11) NOT NULL DEFAULT 0,
  `harga_jual` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `alkes`
--

INSERT INTO `alkes` (`id`, `nama`, `satuan`, `stok`, `harga_beli`, `harga_jual`, `aktif`, `created_at`, `updated_at`) VALUES
(5, 'Abocat Gea 26', 'buah', 100, 6000, 7000, 1, '2026-04-25 19:31:00', '2026-04-25 19:34:07'),
(6, 'Abocat Gea 24', 'buah', 100, 5000, 6000, 1, '2026-04-25 19:31:00', '2026-04-25 19:34:07'),
(7, 'Infuset Gea Dewasa', 'buah', 100, 6000, 7000, 1, '2026-04-25 19:31:00', '2026-04-25 19:34:07'),
(8, 'Infuset Gea Anak', 'buah', 100, 6000, 10000, 1, '2026-04-25 19:31:00', '2026-04-25 19:48:43'),
(9, 'Spuit Onemed 3ml', 'buah', 100, 750, 1750, 1, '2026-04-25 19:31:00', '2026-04-25 19:34:07'),
(10, 'Spuit Onemed 5ml', 'buah', 100, 800, 1800, 1, '2026-04-25 19:31:00', '2026-04-25 19:34:07'),
(11, 'Spuit BD 3ml', 'buah', 100, 1650, 2650, 1, '2026-04-25 19:31:00', '2026-04-25 19:34:07'),
(12, 'RL Grapa', 'botol', 100, 9750, 11000, 1, '2026-04-25 19:31:00', '2026-04-25 19:52:49'),
(13, 'RL Otsu', 'botol', 100, 12000, 14000, 1, '2026-04-25 19:31:00', '2026-04-25 19:52:56'),
(14, 'RL Braun', 'botol', 100, 11500, 13000, 1, '2026-04-25 19:31:00', '2026-04-25 19:52:35'),
(15, 'RL Emjebe', 'botol', 100, 10500, 12000, 1, '2026-04-25 19:31:00', '2026-04-25 19:52:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `antreans`
--

CREATE TABLE `antreans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nomor_rm` varchar(255) DEFAULT NULL,
  `nomor_antrian` int(11) NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') NOT NULL,
  `jenis_pasien` enum('lokal','luar_negeri') NOT NULL DEFAULT 'lokal',
  `nomor_hp` varchar(255) NOT NULL,
  `nama_ibu_kandung` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `status` enum('menunggu_dokter','dipanggil_dokter','sedang_diperiksa','menunggu_kasir','menunggu_obat','selesai') NOT NULL DEFAULT 'menunggu_dokter',
  `dokter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `antreans`
--

INSERT INTO `antreans` (`id`, `nomor_rm`, `nomor_antrian`, `tanggal_kunjungan`, `nama_lengkap`, `tanggal_lahir`, `jenis_kelamin`, `jenis_pasien`, `nomor_hp`, `nama_ibu_kandung`, `alamat`, `status`, `dokter_id`, `created_at`, `updated_at`) VALUES
(10, '00001', 1, '2026-04-25', 'bedjo', '1998-12-02', 'laki-laki', 'lokal', '0987656765', 'ibu siti', 'Semarang', 'selesai', 2, '2026-04-24 11:20:44', '2026-04-24 18:29:40'),
(11, '00002', 2, '2026-04-25', 'ibu sri', '1988-11-02', 'perempuan', 'lokal', '0876542133213', 'alm.yati', 'Kendal', 'selesai', 2, '2026-04-24 18:34:46', '2026-04-24 18:38:33'),
(12, '00003', 3, '2026-04-25', 'bruno fernandes', '1990-04-03', 'laki-laki', 'luar_negeri', '071315225122', 'antonella rodriguez', 'Portugal', 'selesai', 2, '2026-04-24 18:47:54', '2026-04-24 18:49:59'),
(13, '00004', 4, '2026-04-25', 'pak karyo', '1978-05-03', 'laki-laki', 'lokal', '089765231452', 'alm. tarmi', 'Pekalongan', 'menunggu_kasir', 2, '2026-04-24 19:09:09', '2026-04-24 19:12:48'),
(14, '00005', 5, '2026-04-25', 'pak daryo', '1987-04-01', 'laki-laki', 'lokal', '089776564645', 'ibu tuminah', 'Semarang', 'menunggu_kasir', 2, '2026-04-24 19:10:19', '2026-04-24 19:14:09'),
(15, '00006', 6, '2026-04-25', 'Pak kasmidi', '1975-04-05', 'laki-laki', 'lokal', '08977786763', 'ibu dariah', 'Pekalongan', 'menunggu_kasir', 2, '2026-04-24 19:11:21', '2026-04-25 12:59:01'),
(17, '00002', 7, '2026-04-25', 'ibu sri', NULL, 'perempuan', 'lokal', '0876542133213', 'alm.yati', 'Kendal', 'sedang_diperiksa', 2, '2026-04-24 19:42:03', '2026-04-25 13:01:40'),
(18, '00003', 1, '2026-04-26', 'bruno fernandes', NULL, 'laki-laki', 'luar_negeri', '071315225122', 'antonella rodriguez', 'Portugal', 'selesai', 2, '2026-04-25 18:20:37', '2026-04-25 20:03:26'),
(19, '00007', 2, '2026-04-26', 'Bpk Hartono', '1977-05-04', 'laki-laki', 'lokal', '08765464353', 'ibu munipah', 'Semarang', 'selesai', 2, '2026-04-26 10:01:52', '2026-04-26 10:38:25'),
(20, '00008', 3, '2026-04-26', 'muhammad Alif Abdillah', '2004-02-06', 'laki-laki', 'lokal', '08766545454', 'ibu Nikita willy', 'Blora', 'selesai', 2, '2026-04-26 10:04:35', '2026-04-26 10:36:16'),
(21, '00009', 4, '2026-04-26', 'Darsono', '1984-04-07', 'laki-laki', 'lokal', '08765432132', 'ibu Tarmi', 'Semarang', 'selesai', 2, '2026-04-26 11:55:23', '2026-04-26 12:00:34'),
(22, '00001', 5, '2026-04-26', 'bedjo', NULL, 'laki-laki', 'lokal', '0987656765', 'ibu siti', 'Semarang', 'selesai', 2, '2026-04-26 11:55:49', '2026-04-26 12:18:21'),
(23, '00010', 6, '2026-04-26', 'Putri', '2013-04-02', 'perempuan', 'lokal', '0876555333', 'ibu julaeha', 'Cisarua', 'selesai', 2, '2026-04-26 11:57:21', '2026-04-26 12:35:11'),
(24, '00011', 7, '2026-04-26', 'David villa', '1999-12-01', 'laki-laki', 'luar_negeri', '07212121223', 'emely', 'Spanyol', 'sedang_diperiksa', 2, '2026-04-26 12:25:35', '2026-04-26 12:35:52'),
(25, '00002', 8, '2026-04-26', 'ibu sri', NULL, 'perempuan', 'lokal', '0876542133213', 'alm.yati', 'Kendal', 'selesai', 2, '2026-04-26 14:12:55', '2026-04-26 14:14:04');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawans`
--

CREATE TABLE `karyawans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `peran` enum('pendaftaran','dokter','kasir','apoteker') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `karyawans`
--

INSERT INTO `karyawans` (`id`, `nama_lengkap`, `username`, `password`, `peran`, `created_at`, `updated_at`) VALUES
(1, 'Petugas Pendaftaran', 'pendaftaran', '$2y$12$p.YfILFpaaJH273C/t.ZzOl.RBhxpS8.Tsc/OulVpcWrDcAnhzRee', 'pendaftaran', '2026-04-23 07:22:50', '2026-04-23 07:22:50'),
(2, 'Dr. Anna tobelly', 'dokter', '$2y$12$IC7cqyySz2nIJcrOcSU8E.ZeW8eWtl7GFlj.gioZkMWQ8p7L/Dgsi', 'dokter', '2026-04-23 07:22:51', '2026-04-23 07:22:51'),
(3, 'Petugas Kasir', 'kasir', '$2y$12$7kAM/nnCZUW6U8wWMS7YrOE40JrKsNhLd0GVSAl4e3SpjjIp0fZjq', 'kasir', '2026-04-23 07:22:51', '2026-04-23 07:22:51'),
(4, 'Petugas Apotek', 'apoteker', '$2y$12$PjEOsR28OQQpT2D0hHItPOc3TLC1FVmFUajex5k9pAexv1QuOcmD6', 'apoteker', '2026-04-23 07:22:51', '2026-04-23 07:22:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `labs`
--

CREATE TABLE `labs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `labs`
--

INSERT INTO `labs` (`id`, `nama`, `harga`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Darah Rutin', 100000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(2, 'H2TL', 80000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(3, 'Widal', 80000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(4, 'Paket H2TL + Widal', 160000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(5, 'Hema Lengkap', 95000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(6, 'Trigliserida', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(7, 'Cholesterol Total', 40000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(8, 'HDL', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(9, 'LDL', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(10, 'Asam Urat', 35000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(11, 'Gula Darah Sewaktu', 40000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(12, 'Gula Darah Puasa', 40000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(13, 'Gula Darah 2PP', 40000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(14, 'HbA1C', 175000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(15, 'SGOT', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(16, 'SGPT', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(17, 'Ureum', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(18, 'Creatinin', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(19, 'HbsAg', 100000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(20, 'HIV', 100000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(21, 'Sifilis', 100000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(22, 'Urin Rutin', 40000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(23, 'Tes Narkoba', 120000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(24, 'Anti Dengue', 120000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(25, 'Golongan Darah', 75000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(26, 'NS1 + H2TL', 200000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_04_23_042308_create_karyawans_table', 1),
(5, '2026_04_23_042315_create_antreans_table', 1),
(6, '2026_04_23_042327_create_pemeriksaans_table', 1),
(7, '2026_04_23_042333_create_pembayarans_table', 1),
(8, '2026_04_23_150037_add_jenis_pasien_to_antreans_table', 2),
(9, '2026_04_24_160408_add_nomor_rm_to_antreans_table', 3),
(10, '2026_04_25_024133_remove_unique_nomor_rm_from_antreans_table', 4),
(11, '2026_04_25_194414_add_lab_to_pemeriksaans_table', 5),
(12, '2026_04_25_200538_create_admins_table', 6),
(13, '2026_04_25_200539_create_alkes_table', 6),
(14, '2026_04_25_200539_create_labs_table', 6),
(15, '2026_04_25_200539_create_obats_table', 6),
(16, '2026_04_25_200539_create_tindakans_table', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `obats`
--

CREATE TABLE `obats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `harga_beli` int(11) NOT NULL DEFAULT 0,
  `harga_jual` int(11) NOT NULL DEFAULT 0,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `obats`
--

INSERT INTO `obats` (`id`, `nama`, `satuan`, `stok`, `harga_beli`, `harga_jual`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Amoxicillin 500mg', 'tablet', 200, 800, 1500, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(2, 'Ibuprofen 400mg', 'tablet', 150, 1000, 2000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(3, 'Paracetamol 500mg', 'tablet', 296, 400, 800, 1, '2026-04-25 13:09:28', '2026-05-06 15:39:16'),
(4, 'Antasida', 'tablet', 100, 600, 1200, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(5, 'Vitamin C 500mg', 'tablet', 200, 500, 1000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(6, 'Vitamin B Complex', 'tablet', 100, 900, 1800, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(7, 'OBH Combi', 'botol', 78, 15000, 25000, 1, '2026-04-25 13:09:28', '2026-04-26 14:14:04'),
(8, 'Oralit', 'sachet', 150, 1500, 2500, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(9, 'Metformin 500mg', 'tablet', 100, 1200, 2200, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(10, 'Cetirizine 10mg', 'tablet', 120, 800, 1500, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(11, 'Salep Betametason', 'tube', 50, 10000, 18000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(12, 'Antimo', 'tablet', 80, 1500, 3000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(24, 'paramex', 'tablet', 0, 1500, 4000, 1, '2026-04-25 19:20:44', '2026-05-04 07:38:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `antrian_id` bigint(20) UNSIGNED NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `dibayar_pada` timestamp NULL DEFAULT NULL,
  `kasir_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayarans`
--

INSERT INTO `pembayarans` (`id`, `antrian_id`, `total_bayar`, `dibayar_pada`, `kasir_id`, `created_at`, `updated_at`) VALUES
(9, 10, 154400, '2026-04-24 18:29:05', 3, '2026-04-24 18:27:55', '2026-04-24 18:29:05'),
(10, 11, 89800, '2026-04-24 18:38:14', 3, '2026-04-24 18:37:57', '2026-04-24 18:38:14'),
(11, 12, 56200, '2026-04-24 18:49:40', 3, '2026-04-24 18:49:15', '2026-04-24 18:49:40'),
(12, 13, 158100, NULL, NULL, '2026-04-24 19:12:48', '2026-04-24 19:12:48'),
(13, 14, 128900, NULL, NULL, '2026-04-24 19:14:09', '2026-04-24 19:14:09'),
(14, 15, 201500, NULL, NULL, '2026-04-25 12:59:01', '2026-04-25 12:59:01'),
(15, 18, 121000, '2026-04-25 20:03:06', 3, '2026-04-25 20:02:46', '2026-04-25 20:03:06'),
(16, 20, 133000, '2026-04-26 10:35:55', 3, '2026-04-26 10:35:16', '2026-04-26 10:35:55'),
(17, 19, 53000, '2026-04-26 10:37:59', 3, '2026-04-26 10:37:42', '2026-04-26 10:37:59'),
(18, 21, 56000, '2026-04-26 12:00:17', 3, '2026-04-26 12:00:06', '2026-04-26 12:00:17'),
(19, 22, 53000, '2026-04-26 12:18:13', 3, '2026-04-26 12:18:04', '2026-04-26 12:18:13'),
(20, 23, 82000, '2026-04-26 12:35:03', 3, '2026-04-26 12:34:55', '2026-04-26 12:35:03'),
(21, 25, 350000, '2026-04-26 14:13:57', 3, '2026-04-26 14:13:49', '2026-04-26 14:13:57');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pemeriksaans`
--

CREATE TABLE `pemeriksaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `antrian_id` bigint(20) UNSIGNED NOT NULL,
  `diagnosa_utama` text NOT NULL,
  `catatan_tambahan` text DEFAULT NULL,
  `perlu_observasi` tinyint(1) NOT NULL DEFAULT 0,
  `biaya_konsultasi` int(11) NOT NULL DEFAULT 50000,
  `tindakan` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`tindakan`)),
  `lab` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`lab`)),
  `resep_obat` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`resep_obat`)),
  `total_biaya` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pemeriksaans`
--

INSERT INTO `pemeriksaans` (`id`, `antrian_id`, `diagnosa_utama`, `catatan_tambahan`, `perlu_observasi`, `biaya_konsultasi`, `tindakan`, `lab`, `resep_obat`, `total_biaya`, `created_at`, `updated_at`) VALUES
(9, 10, 'demam', 'keluhan sering mengigil', 0, 50000, '[{\"nama\":\"Pemasangan Infus\",\"harga\":100000}]', NULL, '[{\"nama_obat\":\"Paracetamol 500mg\",\"jumlah\":3,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":800},{\"nama_obat\":\"Vitamin C 500mg\",\"jumlah\":2,\"aturan_pakai\":\"2x sehari\",\"harga_satuan\":1000}]', 154400, '2026-04-24 18:27:55', '2026-04-24 18:27:55'),
(10, 11, 'Penyakit diabetes', 'lemas dan pusing berlebihan', 0, 50000, '[{\"nama\":\"Tes Gula Darah\",\"harga\":30000}]', NULL, '[{\"nama_obat\":\"Antasida\",\"jumlah\":3,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":1200},{\"nama_obat\":\"Vitamin C 500mg\",\"jumlah\":4,\"aturan_pakai\":\"2x sehari\",\"harga_satuan\":1000},{\"nama_obat\":\"Metformin 500mg\",\"jumlah\":1,\"aturan_pakai\":\"1x sehari\",\"harga_satuan\":2200}]', 89800, '2026-04-24 18:37:57', '2026-04-24 18:37:57'),
(11, 12, 'Penyakit demam tinggi', NULL, 0, 50000, '[]', NULL, '[{\"nama_obat\":\"Paracetamol 500mg\",\"jumlah\":4,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":800},{\"nama_obat\":\"Amoxicillin 500mg\",\"jumlah\":2,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":1500}]', 56200, '2026-04-24 18:49:15', '2026-04-24 18:49:15'),
(12, 13, 'Penyakit asma', 'sesak nafas, dada terasa nyeri', 0, 50000, '[{\"nama\":\"Pemasangan Infus\",\"harga\":100000}]', NULL, '[{\"nama_obat\":\"Cetirizine 10mg\",\"jumlah\":3,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":1500},{\"nama_obat\":\"Vitamin B Complex\",\"jumlah\":2,\"aturan_pakai\":\"1x sehari\",\"harga_satuan\":1800}]', 158100, '2026-04-24 19:12:48', '2026-04-24 19:12:48'),
(13, 14, 'Penyakit lambung', 'Perut terasa mual jika makan nasi', 0, 50000, '[]', NULL, '[{\"nama_obat\":\"Antasida\",\"jumlah\":2,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":1200},{\"nama_obat\":\"OBH Combi\",\"jumlah\":3,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":25000},{\"nama_obat\":\"Cetirizine 10mg\",\"jumlah\":1,\"aturan_pakai\":\"1x sehari\",\"harga_satuan\":1500}]', 128900, '2026-04-24 19:14:09', '2026-04-24 19:14:09'),
(14, 15, 'HIV', NULL, 0, 50000, '[{\"nama\":\"Corpus Alienum Telinga\",\"harga\":50000}]', '[{\"nama\":\"HIV\",\"harga\":100000}]', '[{\"nama_obat\":\"Cetirizine 10mg\",\"jumlah\":1,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":1500}]', 201500, '2026-04-25 12:59:01', '2026-04-25 12:59:01'),
(15, 18, 'cidera acl', NULL, 0, 50000, '[]', '[{\"nama\":\"Asam Urat\",\"harga\":35000}]', '[{\"nama_obat\":\"Salep Betametason\",\"jumlah\":2,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":18000}]', 121000, '2026-04-25 20:02:46', '2026-04-25 20:02:46'),
(16, 20, 'sakit kepala', NULL, 0, 50000, '[{\"nama\":\"Nebulizer\",\"harga\":80000}]', '[]', '[{\"nama_obat\":\"paramex\",\"jumlah\":1,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":3000}]', 133000, '2026-04-26 10:35:16', '2026-04-26 10:35:16'),
(17, 19, 'demam', NULL, 0, 50000, '[]', '[]', '[{\"nama_obat\":\"paramex\",\"jumlah\":1,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":3000}]', 53000, '2026-04-26 10:37:42', '2026-04-26 10:37:42'),
(18, 21, 'sakit gigi', 'rasa sakit pada gigi disertai panas', 0, 50000, '[]', '[]', '[{\"nama_obat\":\"paramex\",\"jumlah\":2,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":3000}]', 56000, '2026-04-26 12:00:06', '2026-04-26 12:00:06'),
(19, 22, 'sakit kepala', NULL, 0, 50000, '[]', '[]', '[{\"nama_obat\":\"paramex\",\"jumlah\":1,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":3000}]', 53000, '2026-04-26 12:18:04', '2026-04-26 12:18:04'),
(20, 23, 'sakit demam', NULL, 0, 50000, '[]', '[]', '[{\"nama_obat\":\"paramex\",\"jumlah\":8,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":4000}]', 82000, '2026-04-26 12:34:55', '2026-04-26 12:34:55'),
(21, 25, 'Penyakit Asma', NULL, 0, 50000, '[{\"nama\":\"Pasang Tampon Hidung\",\"harga\":250000}]', '[]', '[{\"nama_obat\":\"OBH Combi\",\"jumlah\":2,\"aturan_pakai\":\"3x sehari\",\"harga_satuan\":25000}]', 350000, '2026-04-26 14:13:49', '2026-04-26 14:13:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('jECGfjxomblbUaRX90eGyaanzXpNMLTU4HUtRmfJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiU2lMR0tLc3pjOUoyZWdmZ014WVVNbEJPZGQ3UTdka1pCY0pWcTlTTCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcG90ZWtlci9yaXdheWF0IjtzOjU6InJvdXRlIjtzOjE2OiJhcG90ZWtlci5yaXdheWF0Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czoxMToia2FyeWF3YW5faWQiO2k6NDtzOjEzOiJrYXJ5YXdhbl9uYW1hIjtzOjE0OiJQZXR1Z2FzIEFwb3RlayI7czoxNDoia2FyeWF3YW5fcGVyYW4iO3M6ODoiYXBvdGVrZXIiO30=', 1778081958),
('PPHqxWhlvnhrUX3ux5JdnD3SscouQJlqjV5HfDDl', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiekgweVNnRVF5d241eVdqRG1VTmdQbTJkam1zOVhQZm1BZDlKOFJtVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rYXNpciI7czo1OiJyb3V0ZSI7czoxMToia2FzaXIuaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiJrYXJ5YXdhbl9pZCI7aTozO3M6MTM6Imthcnlhd2FuX25hbWEiO3M6MTM6IlBldHVnYXMgS2FzaXIiO3M6MTQ6Imthcnlhd2FuX3BlcmFuIjtzOjU6Imthc2lyIjt9', 1778081943),
('SvRi9hX7OiH5fpImI8WAAH7md9txecnL1tAqDon6', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiRDZ5MzVRR2d0c3NzWnhPbzkyRG53RnhDSTFsYU9OVXN2bHNpaEpCNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9kb2t0ZXIvcml3YXlhdCI7czo1OiJyb3V0ZSI7czoxNDoiZG9rdGVyLnJpd2F5YXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiJrYXJ5YXdhbl9pZCI7aToyO3M6MTM6Imthcnlhd2FuX25hbWEiO3M6MTY6IkRyLiBBbm5hIHRvYmVsbHkiO3M6MTQ6Imthcnlhd2FuX3BlcmFuIjtzOjY6ImRva3RlciI7fQ==', 1778083697),
('U9GeeuipZ8BhPhA8syDCvogjFUZwCvkot09f3trS', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoidDN4dUlBWnlHRVlCdjBBa0x3bjN1M0Z4bjBsYkU3SHI3anVGSHk1eSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzM6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9wZW5kYWZ0YXJhbiI7czo1OiJyb3V0ZSI7czoxNzoicGVuZGFmdGFyYW4uaW5kZXgiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjExOiJrYXJ5YXdhbl9pZCI7aToxO3M6MTM6Imthcnlhd2FuX25hbWEiO3M6MTk6IlBldHVnYXMgUGVuZGFmdGFyYW4iO3M6MTQ6Imthcnlhd2FuX3BlcmFuIjtzOjExOiJwZW5kYWZ0YXJhbiI7czo4OiJhZG1pbl9pZCI7aToxO3M6MTA6ImFkbWluX25hbWEiO3M6MTQ6Ik1hbmFnZXIgS2xpbmlrIjt9', 1778083885);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tindakans`
--

CREATE TABLE `tindakans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `aktif` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tindakans`
--

INSERT INTO `tindakans` (`id`, `nama`, `harga`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'Eksisi Clavus', 150000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(2, 'Insisi Abses', 100000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(3, 'Nebulizer', 80000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(4, 'Pasang Tampon Hidung', 250000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(5, 'Pasang Kateter', 150000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(6, 'Irigasi Telinga', 100000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(7, 'Irigasi Mata', 150000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(8, 'Ekstraksi Kuku', 150000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(9, 'Sirkumsisi', 350000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(10, 'Insisi Lipoma', 200000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(11, 'Aff Hecting', 75000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(12, 'Corpus Alienum Hidung', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(13, 'Corpus Alienum Telinga', 50000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(14, 'Ekstraksi Serumen', 150000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28'),
(15, 'Oksigen', 100000, 1, '2026-04-25 13:09:28', '2026-04-25 13:09:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_username_unique` (`username`);

--
-- Indeks untuk tabel `alkes`
--
ALTER TABLE `alkes`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `antreans`
--
ALTER TABLE `antreans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `antreans_dokter_id_foreign` (`dokter_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `karyawans`
--
ALTER TABLE `karyawans`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawans_username_unique` (`username`);

--
-- Indeks untuk tabel `labs`
--
ALTER TABLE `labs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `obats`
--
ALTER TABLE `obats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayarans_antrian_id_foreign` (`antrian_id`),
  ADD KEY `pembayarans_kasir_id_foreign` (`kasir_id`);

--
-- Indeks untuk tabel `pemeriksaans`
--
ALTER TABLE `pemeriksaans`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pemeriksaans_antrian_id_foreign` (`antrian_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tindakans`
--
ALTER TABLE `tindakans`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `alkes`
--
ALTER TABLE `alkes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `antreans`
--
ALTER TABLE `antreans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karyawans`
--
ALTER TABLE `karyawans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `labs`
--
ALTER TABLE `labs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `obats`
--
ALTER TABLE `obats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `pemeriksaans`
--
ALTER TABLE `pemeriksaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `tindakans`
--
ALTER TABLE `tindakans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `antreans`
--
ALTER TABLE `antreans`
  ADD CONSTRAINT `antreans_dokter_id_foreign` FOREIGN KEY (`dokter_id`) REFERENCES `karyawans` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_antrian_id_foreign` FOREIGN KEY (`antrian_id`) REFERENCES `antreans` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayarans_kasir_id_foreign` FOREIGN KEY (`kasir_id`) REFERENCES `karyawans` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pemeriksaans`
--
ALTER TABLE `pemeriksaans`
  ADD CONSTRAINT `pemeriksaans_antrian_id_foreign` FOREIGN KEY (`antrian_id`) REFERENCES `antreans` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
