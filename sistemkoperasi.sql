-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 09, 2025 at 07:29 AM
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
-- Database: `sistemkoperasi`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggotas`
--

CREATE TABLE `anggotas` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo_simpanan` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggotas`
--

INSERT INTO `anggotas` (`id`, `nama`, `email`, `password`, `alamat`, `saldo_simpanan`, `created_at`, `updated_at`) VALUES
('4464dbb7-a497-4206-8ec3-739fc05c507f', 'hakal', 'm.haekal1140@gmail.com', '$2y$12$J1pvuz7euotCzl61rjheSeRZrTQ8ERuOCfVYRw1KIvq.VwrbNolcS', 'asdasd', '100000.00', '2025-05-08 06:23:27', '2025-05-08 06:23:27'),
('d518dc29-60e1-403a-adba-7426ae6a36b9', 'Jane Smith', 'janesmith@example.com', '$2y$12$3ZfketRuZGozkvR5uBI64eL2UuubrNZXFJub.puC2W7G8qKvG06iO', 'Jl. Melati No. 12', '500.00', '2025-05-08 05:29:32', '2025-05-08 05:29:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kolektors`
--

CREATE TABLE `kolektors` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kolektors`
--

INSERT INTO `kolektors` (`id`, `anggota_id`, `nama`, `created_at`, `updated_at`) VALUES
(1, '4464dbb7-a497-4206-8ec3-739fc05c507f', 'HaekalKolektor', '2025-05-08 07:58:03', '2025-05-08 07:58:03');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2025_05_07_042559_create_pinjamen_table', 3),
(43, '2025_05_07_090946_update_notifications_table', 7),
(73, '2014_10_12_000000_create_users_table', 8),
(74, '2014_10_12_100000_create_password_reset_tokens_table', 8),
(75, '2019_08_19_000000_create_failed_jobs_table', 8),
(76, '2019_12_14_000001_create_personal_access_tokens_table', 8),
(77, '2025_05_07_040500_create_anggotas_table', 8),
(78, '2025_05_07_041746_create_kolektors_table', 8),
(79, '2025_05_07_042559_create_pinjaman_table', 8),
(80, '2025_05_07_045924_create_transaksis_table', 8),
(81, '2025_05_07_075541_add_role_to_users', 8),
(82, '2025_05_07_090311_create_notifications_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `notifiable_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
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
(1, 'App\\Models\\User', 2, 'Personal Access Token', 'a43c4c0e871be36ec15ada58b22c8a90d0af544f5b742a7ef7f5342451e46699', '[\"*\"]', '2025-05-08 05:45:01', NULL, '2025-05-08 05:28:23', '2025-05-08 05:45:01'),
(2, 'App\\Models\\User', 2, 'Personal Access Token', '6d5e6b85ddc8c159d114256c8c1a7b3fc5a63c8d7ec137e895c70d13fd1026dc', '[\"*\"]', '2025-05-08 18:14:05', NULL, '2025-05-08 18:12:15', '2025-05-08 18:14:05'),
(3, 'App\\Models\\User', 2, 'Personal Access Token', '07c651f5fab95c6924930d5f57853bd58fa64507532d10ad87c62b0de39a7e41', '[\"*\"]', NULL, NULL, '2025-05-08 20:14:47', '2025-05-08 20:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `pinjamen`
--

CREATE TABLE `pinjamen` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah_pinjaman` decimal(10,2) NOT NULL,
  `status` enum('pending','disetujui','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `tanggal_pinjam` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pinjamen`
--

INSERT INTO `pinjamen` (`id`, `anggota_id`, `jumlah_pinjaman`, `status`, `tanggal_pinjam`, `created_at`, `updated_at`) VALUES
(1, 'd518dc29-60e1-403a-adba-7426ae6a36b9', '10000.00', 'pending', '2025-05-09 01:14:05', '2025-05-08 18:14:05', '2025-05-08 18:14:05');

-- --------------------------------------------------------

--
-- Table structure for table `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint UNSIGNED NOT NULL,
  `anggota_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `jenis_transaksi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'anggota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'admin', 'admin@admin.com', NULL, 'admin123', NULL, NULL, NULL, 'admin'),
(2, 'John Doe', 'hekal@admin.com', NULL, '$2y$12$IjOOkCNSBTO538GAAIjGLea.TixVj8L4Lv39hB0W9Rc15azGb8Mkq', NULL, '2025-05-08 05:27:59', '2025-05-08 05:27:59', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggotas`
--
ALTER TABLE `anggotas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `anggotas_email_unique` (`email`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `kolektors`
--
ALTER TABLE `kolektors`
  ADD PRIMARY KEY (`id`),
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
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `pinjamen`
--
ALTER TABLE `pinjamen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pinjamen_anggota_id_index` (`anggota_id`);

--
-- Indexes for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_anggota_id_index` (`anggota_id`);

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
-- AUTO_INCREMENT for table `kolektors`
--
ALTER TABLE `kolektors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pinjamen`
--
ALTER TABLE `pinjamen`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kolektors`
--
ALTER TABLE `kolektors`
  ADD CONSTRAINT `kolektors_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_notifiable_id_foreign` FOREIGN KEY (`notifiable_id`) REFERENCES `anggotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pinjamen`
--
ALTER TABLE `pinjamen`
  ADD CONSTRAINT `pinjamen_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggotas` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_anggota_id_foreign` FOREIGN KEY (`anggota_id`) REFERENCES `anggotas` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
