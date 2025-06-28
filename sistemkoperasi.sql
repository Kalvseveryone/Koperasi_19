-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 28, 2025 at 12:08 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_koperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kolektor_id` bigint UNSIGNED DEFAULT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nik` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `simpanan_pokok` decimal(10,2) NOT NULL DEFAULT '0.00',
  `simpanan_wajib` decimal(10,2) NOT NULL DEFAULT '0.00',
  `simpanan_sukarela` decimal(10,2) NOT NULL DEFAULT '0.00',
  `saldo_simpanan` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_pinjaman` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_denda` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `kolektor_id`, `nama`, `email`, `password`, `alamat`, `no_telepon`, `nik`, `simpanan_pokok`, `simpanan_wajib`, `simpanan_sukarela`, `saldo_simpanan`, `total_pinjaman`, `total_denda`, `created_at`, `updated_at`) VALUES
('075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 5, 'haekal', 'haekal@gmail.com', '$2y$12$WrrNr1QJSLkMgTN779h9i.Jz/XPsY1KKRm7fpxXfHFAXIgK5s.hTW', 'sadas', NULL, NULL, '450000.00', '100000.00', '0.00', '675000.00', '175000.00', '0.00', '2025-06-07 22:29:33', '2025-06-26 23:37:01'),
('781f8e51-11c0-45f9-afcd-9d86f88c2af2', NULL, 'OjakKun', 'ojak1@gmail.com', '$2y$12$0JgMogB5udU/VtACKp3EZ.hVpEVHRRZVpxN0qGinMRuUgM.Ak7gDu', 'dasa', '0821239963122', '2313125412311', '0.00', '0.00', '0.00', '0.00', '0.00', '0.00', '2025-06-09 05:37:29', '2025-06-09 05:38:27'),
('82f0ef3c-e9cc-420d-877f-adac28ce405f', 4, 'teshalo', 'halo@gmail.com', '$2y$12$D15cIZjrKlBhpupoI1Fzt..pSsXSPZMkApPuVjn6OYvirAG91Lxuy', 'sadas', '082123996312', '23131254123112', '0.00', '0.00', '0.00', '100000.00', '0.00', '0.00', '2025-06-07 23:32:55', '2025-06-26 23:36:15'),
('b0e093ef-3763-4b91-8377-fd138ad2ee18', 1, 'vivi', 'vivi@gmail.com', '$2y$12$SwI7Pw46WkC7Sfa4jf868uO694o9GhhrCijrh8ZYbs20H71cfIqDu', 'dsad', NULL, NULL, '0.00', '10000000.00', '0.00', '13000000.00', '0.00', '0.00', '2025-05-26 09:59:30', '2025-05-27 00:47:21'),
('d8248ff3-44c9-4dbc-bdb0-634f00db88a9', NULL, 'test2', 'test2@gmail.com', '$2y$12$ffpyUDY3ZyR0naB/aBmyUurP1DnYgVqzDBAPabJ/YvIx1BcsN/d2m', 'asdas', '082123991231', '2313125412312', '0.00', '0.00', '0.00', '315000.00', '0.00', '0.00', '2025-06-07 22:18:22', '2025-06-22 01:08:20'),
('e77c3cd0-c7cf-4d41-ab30-b724c191b50f', NULL, 'Muhamad Ojan', 'ojan@gmail.com', '$2y$12$XgmAxc5WygNVXNYImi8rmO.xh5XWXD72HhDjCnIRk1qgjAt6o6Jzi', 'adasd', '0821239963124', '23131254123114', '50000.00', '0.00', '0.00', '100000.00', '0.00', '0.00', '2025-06-19 05:08:31', '2025-06-26 23:36:20'),
('feafe83c-f0b5-439b-93a1-6b84e57a2bc7', 2, 'desi', 'desi@gmail.com', '$2y$12$cbzpPsB/f78seEigXrWgMed/262cUS1xf1iRy3Zh/aXj6lL36fkam', 'jl waru dfdsf', NULL, NULL, '0.00', '0.00', '0.00', '300000.00', '0.00', '0.00', '2025-05-26 16:40:45', '2025-06-26 22:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kolektor`
--

CREATE TABLE `kolektor` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_telepon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kolektors`
--

CREATE TABLE `kolektors` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kolektors`
--

INSERT INTO `kolektors` (`id`, `anggota_id`, `nama`, `nomor_telp`, `email`, `password`, `created_at`, `updated_at`, `remember_token`) VALUES
(1, 'b0e093ef-3763-4b91-8377-fd138ad2ee18', 'wayan', NULL, 'wayan@gmail.com', '$2y$12$cTNWej3W5Khl8ev9pEaztuOzKb8koLnJYE.Uf0T/.tCppp8u8KrH.', '2025-05-26 10:17:31', '2025-05-26 23:44:07', NULL),
(2, 'feafe83c-f0b5-439b-93a1-6b84e57a2bc7', 'Adit', NULL, 'adit@gmail.com', '$2y$12$bxF5RuNoLvQfxr2yVzgFke7nmPBK1OcwJXds2PV8VXgP6lGRhZe6W', '2025-05-26 16:48:52', '2025-05-26 16:48:52', NULL),
(4, '82f0ef3c-e9cc-420d-877f-adac28ce405f', 'test1', NULL, 'test1@gmail.com', '$2y$12$au29P9QVsqVel1ZtbcrX0ubVa97i97wLNP4kpztmdsOFEVBAWcR3C', '2025-06-07 22:33:53', '2025-06-26 23:36:15', NULL),
(5, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'test2', NULL, 'test2@gmail.com', '$2y$12$Nxii5CUWwOKYqQp94BRtjOQSzIR99pj2lNCMxRkqPtG8DHoL0SuyW', '2025-06-07 22:40:35', '2025-06-26 23:36:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2025_05_07_040500_create_anggotas_table', 1),
(6, '2025_05_07_041746_create_kolektors_table', 1),
(7, '2025_05_07_042559_create_pinjaman_table', 1),
(8, '2025_05_07_045924_create_transaksis_table', 1),
(9, '2025_05_07_075541_add_role_to_users', 1),
(10, '2025_05_07_090311_create_notifications_table', 1),
(11, '2025_05_26_120850_add_auth_fields_to_kolektors', 1),
(12, '2025_05_26_232212_create_simpanan_transactions_table', 1),
(13, '2024_06_08_000000_create_kolektor_table', 2),
(14, '2024_03_19_add_denda_to_pinjaman_table', 3),
(15, '2025_06_08_052706_update_tokenable_id_column_type', 3),
(16, '2024_03_19_add_keterangan_to_transaksi_table', 4),
(17, '2024_03_19_add_pinjaman_denda_to_anggota_table', 5),
(18, '2024_03_19_create_pembayaran_pinjaman_table', 6),
(20, '2019_12_14_000001_create_personal_access_tokens_table', 7),
(21, '2024_03_19_create_payment_submissions_table', 8),
(22, '2024_03_19_add_columns_to_payment_submissions_table', 9),
(23, '2024_03_19_add_columns_to_pinjaman_table', 10),
(24, '2024_03_19_add_lunas_to_pinjaman_status', 11);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `notifiable_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_submissions`
--

CREATE TABLE `payment_submissions` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kolektor_id` bigint UNSIGNED NOT NULL,
  `jumlah_pembayaran` int NOT NULL,
  `tanggal_pembayaran` date NOT NULL,
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bulan_pembayaran` int DEFAULT NULL,
  `tahun_pembayaran` int DEFAULT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan_admin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payment_submissions`
--

INSERT INTO `payment_submissions` (`id`, `anggota_id`, `kolektor_id`, `jumlah_pembayaran`, `tanggal_pembayaran`, `metode_pembayaran`, `bulan_pembayaran`, `tahun_pembayaran`, `bukti_pembayaran`, `status`, `catatan`, `catatan_admin`, `created_at`, `updated_at`) VALUES
(1, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', 5, 100000, '2025-06-10', NULL, NULL, NULL, 'bukti-pembayaran/rHTe0pWrcQvlKmb2eN2EeVaz8208BhtFsimMdGR0.png', 'approved', NULL, NULL, '2025-06-09 18:24:45', '2025-06-09 18:29:45'),
(2, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', 5, 100000, '2025-06-10', NULL, NULL, NULL, 'bukti-pembayaran/DPRfAcwvoW2XwKGxOft3WeQqmPaFOxjW6c5s9Yoh.png', 'rejected', NULL, NULL, '2025-06-09 18:34:17', '2025-06-09 18:37:58'),
(3, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', 5, 50000, '2025-06-10', NULL, NULL, NULL, 'bukti-pembayaran/GLJ0EWF3TqpLWKQLLvWSgsVkxlL3qLcGIXx5lxat.png', 'approved', NULL, NULL, '2025-06-09 18:41:48', '2025-06-09 18:42:07'),
(4, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', 5, 100000, '2025-06-10', NULL, NULL, NULL, 'bukti-pembayaran/CcTGlWJh0ethkDXZ6iOm2YufVFDpyWk77ORJIZaW.png', 'rejected', NULL, NULL, '2025-06-09 20:14:15', '2025-06-09 20:21:41'),
(5, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', 5, 45000, '2025-06-22', NULL, NULL, NULL, 'bukti-pembayaran/0bMXoFJs6lRKyy2sv91Nc5xytvV9Ys9g2cHkymQB.png', 'approved', NULL, NULL, '2025-06-22 00:44:17', '2025-06-22 00:50:15'),
(6, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', 5, 20000, '2025-06-22', 'tunai', 1, 2025, 'bukti-pembayaran/k03qTbNgNCsqK2vZGLgy8C4gkDMXZBs6MRnDsRz8.png', 'approved', NULL, NULL, '2025-06-22 00:53:15', '2025-06-22 00:53:31'),
(7, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', 5, 50000, '2025-06-22', 'tunai', 1, 2025, 'bukti-pembayaran/5yrzPcMOVvexbforc37GHKivQLXPXc2OWaaGNu6i.png', 'approved', NULL, NULL, '2025-06-22 01:08:51', '2025-06-22 01:09:25'),
(8, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', 5, 25000, '2025-06-27', NULL, NULL, NULL, 'bukti-pembayaran/KZyEy2KlBOWLtGI3W3wL2oQg1zSFEFFl4y8WvOv4.png', 'rejected', NULL, NULL, '2025-06-26 23:31:55', '2025-06-26 23:34:03'),
(9, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', 5, 10000, '2025-06-27', NULL, NULL, NULL, 'bukti-pembayaran/Ye1ayiXrQEJw93yJ0Qh5YccVM2pyCLCvTskp6l2o.png', 'pending', NULL, NULL, '2025-06-26 23:34:40', '2025-06-26 23:34:40'),
(10, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', 5, 10000, '2025-06-27', NULL, NULL, NULL, 'bukti-pembayaran/FRAiavALaNp0CJ6TrEv36l2tJwujkkDR5ANcvTIg.png', 'pending', NULL, NULL, '2025-06-26 23:35:19', '2025-06-26 23:35:19'),
(11, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 5, 25000, '2025-06-27', NULL, NULL, NULL, 'bukti-pembayaran/hUzslfRzyrHPsGFR7v6ZvaudR9fbUtcTq5DrGlpQ.png', 'approved', NULL, NULL, '2025-06-26 23:36:43', '2025-06-26 23:37:01');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_pinjaman`
--

CREATE TABLE `pembayaran_pinjaman` (
  `id` bigint UNSIGNED NOT NULL,
  `pinjaman_id` bigint UNSIGNED NOT NULL,
  `kolektor_id` bigint UNSIGNED NOT NULL,
  `jumlah_pembayaran` decimal(12,2) NOT NULL,
  `jumlah_denda` decimal(12,2) NOT NULL DEFAULT '0.00',
  `metode_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bukti_pembayaran` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` varchar(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'api_token', '0354d13a4afc128a55296db2f0b27ec090b0ea3bb647a02f605072f0c8281351', '[\"*\"]', '2025-06-09 06:28:02', NULL, '2025-06-09 06:22:52', '2025-06-09 06:28:02'),
(2, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'api_token', '32c7f875c7267337f1e1475a2a788f003ea55181c3895605e0664122565cd86b', '[\"*\"]', '2025-06-09 06:29:30', NULL, '2025-06-09 06:28:54', '2025-06-09 06:29:30'),
(3, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'api_token', '1139dd2c2056c282007a267268f9bc674d15d3569df696b7d9b544c50600eb57', '[\"*\"]', NULL, NULL, '2025-06-09 06:37:38', '2025-06-09 06:37:38'),
(4, 'App\\Models\\Anggota', 'feafe83c-f0b5-439b-93a1-6b84e57a2bc7', 'api_token', '5ae989f996b48b24aaf295848a1e86e94cfe18137267f7363dae6625b7a5e8c5', '[\"*\"]', NULL, NULL, '2025-06-09 06:51:53', '2025-06-09 06:51:53'),
(5, 'App\\Models\\Anggota', 'feafe83c-f0b5-439b-93a1-6b84e57a2bc7', 'api_token', '2cc3b0d41d67b50f274616ac14a20c8a5c7510294ed2ed23fa522d2a5eea2d7d', '[\"*\"]', NULL, NULL, '2025-06-09 07:00:53', '2025-06-09 07:00:53'),
(6, 'App\\Models\\Anggota', 'feafe83c-f0b5-439b-93a1-6b84e57a2bc7', 'api_token', '0653f55ef22befab768092b7734d4ec44c001b679c412e324e5d25064e3cea77', '[\"*\"]', NULL, NULL, '2025-06-09 20:16:55', '2025-06-09 20:16:55'),
(7, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'api_token', '63844f41a4671064b0587a63125c6cf5490dd5e6ca95518aa4334c9e872ea4b0', '[\"*\"]', NULL, NULL, '2025-06-12 19:32:50', '2025-06-12 19:32:50'),
(8, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'api_token', '079bf39c1b670458126e876a518ee6803dd52e897c231c3eb8fd9a9ec72f0fb5', '[\"*\"]', '2025-06-13 20:26:34', NULL, '2025-06-13 20:25:55', '2025-06-13 20:26:34'),
(9, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', 'fb554093c414b0edb45f4bc93c0cc44a5b753a122c5e2894a170ee17b891ae0f', '[\"*\"]', NULL, NULL, '2025-06-18 16:28:17', '2025-06-18 16:28:17'),
(10, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', '051ea3e90716912a2c18d7ed3322a68f3e9528702ace66ea602e564a57b7c95b', '[\"*\"]', '2025-06-18 16:30:32', NULL, '2025-06-18 16:28:39', '2025-06-18 16:30:32'),
(11, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', '4ab64bff512d50d2203e9ffb37f8386d22b6e1d4a03022fb3c609b69a0299fa4', '[\"*\"]', NULL, NULL, '2025-06-19 04:22:18', '2025-06-19 04:22:18'),
(12, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', 'adb3a2d19b318f11450fddbd61a1a5339739ba4509d9638fc3cdd676812f51c3', '[\"*\"]', '2025-06-19 04:43:09', NULL, '2025-06-19 04:24:03', '2025-06-19 04:43:09'),
(13, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', '6142475ccc4598978bcf3fbe87104f49997078a4919b2793c2cca7bcb3e2aa22', '[\"*\"]', NULL, NULL, '2025-06-19 04:38:17', '2025-06-19 04:38:17'),
(14, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', '354bbcf373bfe5ed4667d8e585de1b178e80f37ef28f34baabd77d9f1e71b785', '[\"*\"]', '2025-06-19 04:43:19', NULL, '2025-06-19 04:43:18', '2025-06-19 04:43:19'),
(15, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', '16ee9ed32b3006b295e7a38e5221762cbf467f25564d2945110e7ae7f2dd7710', '[\"*\"]', '2025-06-19 04:56:59', NULL, '2025-06-19 04:56:37', '2025-06-19 04:56:59'),
(18, 'App\\Models\\Anggota', 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', 'anggota_token', 'f4ed37c11d2d9a46e90f8d56b5f89b5506d802a1c5fb2088cde2b78a51aca4a5', '[\"*\"]', '2025-06-19 05:09:44', NULL, '2025-06-19 05:09:25', '2025-06-19 05:09:44'),
(20, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', 'd2e1288bedfb27f2a01a36af652005dbf7358b6629bbc2af48586ac4986ffca6', '[\"*\"]', '2025-06-19 05:13:56', NULL, '2025-06-19 05:13:34', '2025-06-19 05:13:56'),
(21, 'App\\Models\\Anggota', 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', 'anggota_token', '833f8b8e57cf52a625c02abeb89a163dcb7b5fbf2418129718d5ba96226f7c65', '[\"*\"]', '2025-06-19 05:41:29', NULL, '2025-06-19 05:40:47', '2025-06-19 05:41:29'),
(23, 'App\\Models\\Anggota', '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'anggota_token', 'ef7d864a5d2015ffe77af14978ae46a102dc90d7e8fdffbcac1c441344240a4b', '[\"*\"]', '2025-06-20 19:54:12', NULL, '2025-06-20 19:54:09', '2025-06-20 19:54:12');

-- --------------------------------------------------------

--
-- Table structure for table `pinjaman`
--

CREATE TABLE `pinjaman` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `denda` decimal(10,2) NOT NULL DEFAULT '0.00',
  `jangka_waktu` int NOT NULL,
  `tujuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','disetujui','ditolak','aktif','lunas') COLLATE utf8mb4_unicode_ci DEFAULT 'pending',
  `catatan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_lunas` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pinjaman`
--

INSERT INTO `pinjaman` (`id`, `anggota_id`, `jumlah`, `denda`, `jangka_waktu`, `tujuan`, `status`, `catatan`, `tanggal_pinjam`, `tanggal_lunas`, `created_at`, `updated_at`) VALUES
(5, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '0.00', '0.00', 1, 'sada', 'lunas', NULL, '2025-06-09', NULL, '2025-06-09 04:38:00', '2025-06-26 23:03:32'),
(7, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', '50000.00', '0.00', 1, 'asd', 'lunas', 'asdsa', '2025-06-19', '2025-06-25', '2025-06-19 05:09:39', '2025-06-22 01:07:03'),
(9, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '175000.00', '0.00', 2, 'asdas', 'aktif', NULL, '2025-06-27', NULL, '2025-06-26 23:04:13', '2025-06-26 23:37:01'),
(10, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', '100000.00', '0.00', 1, 'sad', 'pending', NULL, '2025-06-27', NULL, '2025-06-26 23:15:49', '2025-06-26 23:15:49');

-- --------------------------------------------------------

--
-- Table structure for table `simpanan_transactions`
--

CREATE TABLE `simpanan_transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_simpanan` enum('pokok','wajib','sukarela') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(12,2) NOT NULL,
  `type` enum('masuk','keluar') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `simpanan_transactions`
--

INSERT INTO `simpanan_transactions` (`id`, `anggota_id`, `jenis_simpanan`, `jumlah`, `type`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'b0e093ef-3763-4b91-8377-fd138ad2ee18', 'wajib', '10000000.00', 'masuk', 'okelah', '2025-05-27 00:47:21', '2025-05-27 00:47:21'),
(2, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'pokok', '500000.00', 'masuk', 'test', '2025-06-07 22:41:55', '2025-06-07 22:41:55'),
(3, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'wajib', '100000.00', 'masuk', 'asdsa', '2025-06-09 04:54:21', '2025-06-09 04:54:21'),
(4, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', 'pokok', '50000.00', 'keluar', 'asd', '2025-06-09 04:54:31', '2025-06-09 04:54:31'),
(5, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', 'pokok', '50000.00', 'masuk', 'ghj', '2025-06-19 05:09:00', '2025-06-19 05:09:00');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `jenis_transaksi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_simpanan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `anggota_id`, `jumlah`, `jenis_transaksi`, `jenis_simpanan`, `status`, `tanggal_transaksi`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'feafe83c-f0b5-439b-93a1-6b84e57a2bc7', '100000.00', 'denda', NULL, 'sukses', '2025-06-09 04:23:04', 'miss 1 hari', '2025-06-09 04:23:04', '2025-06-09 04:23:04'),
(2, 'feafe83c-f0b5-439b-93a1-6b84e57a2bc7', '-200000.00', 'denda', NULL, 'sukses', '2025-06-09 04:29:50', 'Penghapusan denda: asd', '2025-06-09 04:29:50', '2025-06-09 04:29:50'),
(3, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '100000.00', 'denda', NULL, 'sukses', '2025-06-09 04:52:45', 'SAD', '2025-06-09 04:52:45', '2025-06-09 04:52:45'),
(4, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '-100000.00', 'denda', NULL, 'sukses', '2025-06-09 05:21:07', 'Penghapusan denda: done', '2025-06-09 05:21:07', '2025-06-09 05:21:07'),
(5, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', '100000.00', 'pembayaran angsuran', NULL, 'completed', '2025-06-09 17:00:00', NULL, '2025-06-09 18:29:45', '2025-06-09 18:29:45'),
(6, 'd8248ff3-44c9-4dbc-bdb0-634f00db88a9', '50000.00', 'pembayaran angsuran', NULL, 'completed', '2025-06-09 17:00:00', NULL, '2025-06-09 18:42:07', '2025-06-09 18:42:07'),
(7, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '200000.00', 'denda', NULL, 'sukses', '2025-06-09 20:15:39', 'lebih 1 hari', '2025-06-09 20:15:39', '2025-06-09 20:15:39'),
(8, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '50000.00', 'denda', NULL, 'sukses', '2025-06-19 04:04:41', 'dfs', '2025-06-19 04:04:41', '2025-06-19 04:04:41'),
(9, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '40000.00', 'denda', NULL, 'sukses', '2025-06-20 21:06:25', 'ada', '2025-06-20 21:06:25', '2025-06-20 21:06:25'),
(10, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '-290000.00', 'denda', NULL, 'sukses', '2025-06-20 21:06:33', 'Penghapusan denda: asd', '2025-06-20 21:06:33', '2025-06-20 21:06:33'),
(11, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', '-50000.00', 'pinjaman', NULL, 'sukses', '2025-06-22 01:03:54', 'Penyesuaian jumlah pinjaman', '2025-06-22 01:03:54', '2025-06-22 01:03:54'),
(12, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '100000.00', 'angsuran', NULL, 'sukses', '2025-06-26 17:00:00', 'Pembayaran angsuran pinjaman #5 oleh admin', '2025-06-26 22:48:02', '2025-06-26 22:48:02'),
(13, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', '50000.00', 'angsuran', NULL, 'sukses', '2025-06-26 17:00:00', 'Pembayaran angsuran pinjaman #8 oleh admin', '2025-06-26 22:58:49', '2025-06-26 22:58:49'),
(14, 'e77c3cd0-c7cf-4d41-ab30-b724c191b50f', '50000.00', 'angsuran', NULL, 'sukses', '2025-06-26 17:00:00', 'Pembayaran angsuran pinjaman #8 oleh admin', '2025-06-26 22:59:53', '2025-06-26 22:59:53'),
(15, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '50000.00', 'angsuran', NULL, 'sukses', '2025-06-26 17:00:00', 'Pembayaran angsuran pinjaman #9 oleh admin', '2025-06-26 23:05:04', '2025-06-26 23:05:04'),
(16, '075d0d10-fd80-46d8-815c-5bf3fb3ce7ad', '25000.00', 'pembayaran angsuran', NULL, 'completed', '2025-06-26 17:00:00', NULL, '2025-06-26 23:37:01', '2025-06-26 23:37:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anggota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', 'admin@admin.com', NULL, '$2y$12$76FnAPiOUbCobrCoYDdHYOgvwV7j9.LiVJFm/He6jhimqH.c.DH2y', NULL, NULL, NULL, 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anggota_email_unique` (`email`),
  ADD KEY `anggota_kolektor_id_foreign` (`kolektor_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kolektor`
--
ALTER TABLE `kolektor`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kolektor_email_unique` (`email`);

--
-- Indexes for table `kolektors`
--
ALTER TABLE `kolektors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kolektors_email_unique` (`email`),
  ADD KEY `kolektors_anggota_id_foreign` (`anggota_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_id_foreign` (`notifiable_id`);

--
-- Indexes for table `payment_submissions`
--
ALTER TABLE `payment_submissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payment_submissions_kolektor_id_foreign` (`kolektor_id`),
  ADD KEY `payment_submissions_anggota_id_foreign` (`anggota_id`);

--
-- Indexes for table `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_pinjaman_pinjaman_id_foreign` (`pinjaman_id`),
  ADD KEY `pembayaran_pinjaman_kolektor_id_foreign` (`kolektor_id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjaman_anggota_id_index` (`anggota_id`);

--
-- Indexes for table `simpanan_transactions`
--
ALTER TABLE `simpanan_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `simpanan_transactions_anggota_id_foreign` (`anggota_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_anggota_id_index` (`anggota_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kolektor`
--
ALTER TABLE `kolektor`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kolektors`
--
ALTER TABLE `kolektors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `payment_submissions`
--
ALTER TABLE `payment_submissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pinjaman`
--
ALTER TABLE `pinjaman`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `simpanan_transactions`
--
ALTER TABLE `simpanan_transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `anggota`
--
ALTER TABLE `anggota`
  ADD CONSTRAINT `anggota_kolektor_id_foreign` FOREIGN KEY (`kolektor_id`) REFERENCES `kolektors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `kolektors`
--
ALTER TABLE `kolektors`
  ADD CONSTRAINT `kolektors_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_notifiable_id_foreign` FOREIGN KEY (`notifiable_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payment_submissions`
--
ALTER TABLE `payment_submissions`
  ADD CONSTRAINT `payment_submissions_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`),
  ADD CONSTRAINT `payment_submissions_kolektor_id_foreign` FOREIGN KEY (`kolektor_id`) REFERENCES `kolektors` (`id`);

--
-- Constraints for table `pembayaran_pinjaman`
--
ALTER TABLE `pembayaran_pinjaman`
  ADD CONSTRAINT `pembayaran_pinjaman_kolektor_id_foreign` FOREIGN KEY (`kolektor_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pembayaran_pinjaman_pinjaman_id_foreign` FOREIGN KEY (`pinjaman_id`) REFERENCES `pinjaman` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pinjaman`
--
ALTER TABLE `pinjaman`
  ADD CONSTRAINT `pinjaman_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `simpanan_transactions`
--
ALTER TABLE `simpanan_transactions`
  ADD CONSTRAINT `simpanan_transactions_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggota` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
