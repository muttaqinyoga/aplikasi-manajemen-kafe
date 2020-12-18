-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Des 2020 pada 16.55
-- Versi server: 10.4.10-MariaDB
-- Versi PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cafe_cashier`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `menus`
--

CREATE TABLE `menus` (
  `uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `menu_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `menu_price` double NOT NULL,
  `status_stock` enum('Tersedia','Tidak tersedia') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `menus`
--

INSERT INTO `menus` (`uid`, `menu_name`, `menu_price`, `status_stock`, `created_at`, `updated_at`) VALUES
('076c72e7-295a-11eb-841b-2cfda12b034d', 'Teh Manis (Hangat & Dingin)', 5000, 'Tersedia', '2020-11-17 14:53:41', '2020-11-17 14:53:41'),
('28c16ef3-295a-11eb-841b-2cfda12b034d', 'Teh botol Sosro', 6000, 'Tersedia', '2020-11-17 14:54:37', '2020-11-17 14:54:37'),
('4eff3b88-295a-11eb-841b-2cfda12b034d', 'Tebs', 7000, 'Tersedia', '2020-11-17 14:55:41', '2020-11-17 14:55:41'),
('509f1ebc-2959-11eb-841b-2cfda12b034d', 'Nasi Goreng Ayam Penyet', 18000, 'Tersedia', '2020-11-17 14:48:34', '2020-11-17 14:48:34'),
('6345e8d0-295a-11eb-841b-2cfda12b034d', 'Kopi Hitam (Hangat & Dingin)', 5000, 'Tersedia', '2020-11-17 14:56:15', '2020-11-17 14:56:15'),
('736458ed-295a-11eb-841b-2cfda12b034d', 'Capucino (Hangat & Dingin)', 8000, 'Tersedia', '2020-11-17 14:56:42', '2020-11-17 14:56:42'),
('736a3e25-2959-11eb-841b-2cfda12b034d', 'Nasi Goreng Ayam Bakar', 20000, 'Tersedia', '2020-11-17 14:49:33', '2020-11-17 14:49:33'),
('79f2bc0f-295a-11eb-841b-2cfda12b034d', 'Capucino + susu (Hangat & Dingin)', 10000, 'Tersedia', '2020-11-17 14:56:53', '2020-11-17 14:56:53'),
('83eeabdb-295a-11eb-841b-2cfda12b034d', 'Kopi Luwak (Hangat & Dingin)', 7000, 'Tersedia', '2020-11-17 14:57:10', '2020-11-17 14:57:10'),
('84e1c173-2959-11eb-841b-2cfda12b034d', 'Nasi Ayam Penyet', 15000, 'Tersedia', '2020-11-17 14:50:02', '2020-11-17 14:50:02'),
('8b16c72e-295a-11eb-841b-2cfda12b034d', 'Kopi Luwak + Susu (Hangat & Dingin)', 9000, 'Tersedia', '2020-11-17 14:57:22', '2020-11-17 14:57:22'),
('8d1a95a8-2959-11eb-841b-2cfda12b034d', 'Nasi Ayam Bakar', 17000, 'Tersedia', '2020-11-17 14:50:16', '2020-11-17 14:50:16'),
('94573f51-2958-11eb-841b-2cfda12b034d', 'Nasi Goreng', 10000, 'Tersedia', '2020-11-17 14:43:18', '2020-11-17 14:43:18'),
('98bb286b-295a-11eb-841b-2cfda12b034d', 'Teh Tarik (Hangat & Dingin)', 10000, 'Tersedia', '2020-11-17 14:57:45', '2020-11-17 14:57:45'),
('a82a8205-2959-11eb-841b-2cfda12b034d', 'Indomie Goreng', 10000, 'Tersedia', '2020-11-17 14:51:01', '2020-11-17 14:51:01'),
('ae2353e0-2959-11eb-841b-2cfda12b034d', 'Indomie Kuah', 9000, 'Tersedia', '2020-11-17 14:51:11', '2020-11-17 14:51:11'),
('c4de0aac-2959-11eb-841b-2cfda12b034d', 'Mie Aceh Goreng', 10000, 'Tersedia', '2020-11-17 14:51:49', '2020-11-17 14:51:49'),
('c7e677d5-2986-11eb-9003-2cfda12b034d', 'Bakso', 12000, 'Tersedia', '2020-11-17 20:14:02', '2020-12-18 14:24:22'),
('cc8edc7b-2a0e-11eb-902a-2cfda12b034d', 'Fruit Tea', 7000, 'Tersedia', '2020-11-18 12:27:41', '2020-11-18 12:27:41'),
('d07197b8-2959-11eb-841b-2cfda12b034d', 'Mie Aceh Kuah', 10000, 'Tersedia', '2020-11-17 14:52:09', '2020-11-17 14:52:09'),
('e83b79ec-2959-11eb-841b-2cfda12b034d', 'Nasi Goreng Seafood', 25000, 'Tersedia', '2020-11-17 14:52:48', '2020-11-17 14:52:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2020_11_14_033944_create_menus_table', 1),
(3, '2020_11_14_034201_create_orders_table', 1),
(4, '2020_11_14_034704_create_payments_table', 1),
(5, '2020_11_21_111417_create_order_details_table', 1),
(6, '2020_11_21_112249_create_tables_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `created_by` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `table_number` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_price` double(8,2) UNSIGNED NOT NULL,
  `invoice_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('Belum dibayar','Telah dibayar','Dibatalkan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`uid`, `created_by`, `table_number`, `total_price`, `invoice_number`, `status`, `created_at`, `updated_at`) VALUES
('0018cfde-40ef-11eb-a549-2cfda12b034d', '4b949107-321a-11eb-9936-2cfda12b034d', '3127dc7c-2f00-11eb-980c-2cfda12b034d', 25000.00, '20201218120800', 'Telah dibayar', '2020-12-18 05:08:00', '2020-12-18 05:11:24'),
('113c5b6d-322b-11eb-9936-2cfda12b034d', '4b949107-321a-11eb-9936-2cfda12b034d', '3127dc7c-2f00-11eb-980c-2cfda12b034d', 46000.00, '20201129171011', 'Telah dibayar', '2020-11-29 10:10:11', '2020-11-29 10:38:54'),
('32e87600-32ef-11eb-9475-2cfda12b034d', '5a98d4b6-321a-11eb-9936-2cfda12b034d', '3127dc7c-2f00-11eb-980c-2cfda12b034d', 24000.00, '20201130163409', 'Telah dibayar', '2020-11-30 09:34:09', '2020-11-30 09:34:41'),
('4cba0c63-4103-11eb-81c0-2cfda12b034d', '4b949107-321a-11eb-9936-2cfda12b034d', '3109adda-2f00-11eb-980c-2cfda12b034d', 25000.00, '20201218143319', 'Telah dibayar', '2020-12-18 07:33:19', '2020-12-18 07:36:00'),
('688be764-4103-11eb-81c0-2cfda12b034d', '4b949107-321a-11eb-9936-2cfda12b034d', '3117545b-2f00-11eb-980c-2cfda12b034d', 27000.00, '20201218143405', 'Telah dibayar', '2020-12-18 07:34:05', '2020-12-18 07:37:04'),
('6e59a8d7-4140-11eb-a487-2cfda12b034d', '4b949107-321a-11eb-9936-2cfda12b034d', '311eccf5-2f00-11eb-980c-2cfda12b034d', 17000.00, '20201218215054', 'Telah dibayar', '2020-12-18 14:50:54', '2020-12-18 14:56:42'),
('9f7d0813-32e6-11eb-9475-2cfda12b034d', '5a98d4b6-321a-11eb-9936-2cfda12b034d', '3127dc7c-2f00-11eb-980c-2cfda12b034d', 28000.00, '20201130153246', 'Telah dibayar', '2020-11-30 08:32:46', '2020-11-30 09:16:48'),
('a5ffc64b-3228-11eb-9936-2cfda12b034d', '4b949107-321a-11eb-9936-2cfda12b034d', '3109adda-2f00-11eb-980c-2cfda12b034d', 40000.00, '20201129165252', 'Telah dibayar', '2020-11-29 09:52:53', '2020-11-29 09:55:48'),
('c2dac537-4139-11eb-a487-2cfda12b034d', '5a98d4b6-321a-11eb-9936-2cfda12b034d', '3117545b-2f00-11eb-980c-2cfda12b034d', 28000.00, '20201218210310', 'Telah dibayar', '2020-12-18 14:03:10', '2020-12-18 14:11:07'),
('f8d58a19-32ec-11eb-9475-2cfda12b034d', '5a98d4b6-321a-11eb-9936-2cfda12b034d', 'cc40d17a-319b-11eb-b8e1-2cfda12b034d', 22000.00, '20201130161813', 'Telah dibayar', '2020-11-30 09:18:13', '2020-11-30 09:28:45'),
('ffe965b2-4141-11eb-a487-2cfda12b034d', '5a98d4b6-321a-11eb-9936-2cfda12b034d', '3117545b-2f00-11eb-980c-2cfda12b034d', 34000.00, '20201218220208', 'Telah dibayar', '2020-12-18 15:02:08', '2020-12-18 15:03:56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_details`
--

CREATE TABLE `order_details` (
  `uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `order_uid` char(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `menu_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity_ordered` smallint(6) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `order_details`
--

INSERT INTO `order_details` (`uid`, `order_uid`, `menu_uid`, `quantity_ordered`, `created_at`, `updated_at`) VALUES
('0053aa24-40ef-11eb-a549-2cfda12b034d', '0018cfde-40ef-11eb-a549-2cfda12b034d', '84e1c173-2959-11eb-841b-2cfda12b034d', 1, '2020-12-18 05:08:01', '2020-12-18 05:08:01'),
('006a92f1-40ef-11eb-a549-2cfda12b034d', '0018cfde-40ef-11eb-a549-2cfda12b034d', '79f2bc0f-295a-11eb-841b-2cfda12b034d', 1, '2020-12-18 05:08:01', '2020-12-18 05:08:01'),
('114a1b06-322b-11eb-9936-2cfda12b034d', '113c5b6d-322b-11eb-9936-2cfda12b034d', '736a3e25-2959-11eb-841b-2cfda12b034d', 1, '2020-11-29 10:10:11', '2020-11-29 10:10:11'),
('1156ada0-322b-11eb-9936-2cfda12b034d', '113c5b6d-322b-11eb-9936-2cfda12b034d', '6345e8d0-295a-11eb-841b-2cfda12b034d', 1, '2020-11-29 10:10:12', '2020-11-29 10:10:12'),
('116273cd-322b-11eb-9936-2cfda12b034d', '113c5b6d-322b-11eb-9936-2cfda12b034d', '84e1c173-2959-11eb-841b-2cfda12b034d', 1, '2020-11-29 10:10:12', '2020-11-29 10:10:12'),
('11702254-322b-11eb-9936-2cfda12b034d', '113c5b6d-322b-11eb-9936-2cfda12b034d', '28c16ef3-295a-11eb-841b-2cfda12b034d', 1, '2020-11-29 10:10:12', '2020-11-29 10:10:12'),
('330f1211-32ef-11eb-9475-2cfda12b034d', '32e87600-32ef-11eb-9475-2cfda12b034d', '8d1a95a8-2959-11eb-841b-2cfda12b034d', 1, '2020-11-30 09:34:09', '2020-11-30 09:34:09'),
('331efac9-32ef-11eb-9475-2cfda12b034d', '32e87600-32ef-11eb-9475-2cfda12b034d', '4eff3b88-295a-11eb-841b-2cfda12b034d', 1, '2020-11-30 09:34:10', '2020-11-30 09:34:10'),
('4ce23fcf-4103-11eb-81c0-2cfda12b034d', '4cba0c63-4103-11eb-81c0-2cfda12b034d', '84e1c173-2959-11eb-841b-2cfda12b034d', 1, '2020-12-18 07:33:19', '2020-12-18 07:33:19'),
('4ce93a7c-4103-11eb-81c0-2cfda12b034d', '4cba0c63-4103-11eb-81c0-2cfda12b034d', '79f2bc0f-295a-11eb-841b-2cfda12b034d', 1, '2020-12-18 07:33:19', '2020-12-18 07:33:19'),
('696a777f-4103-11eb-81c0-2cfda12b034d', '688be764-4103-11eb-81c0-2cfda12b034d', '8d1a95a8-2959-11eb-841b-2cfda12b034d', 1, '2020-12-18 07:34:07', '2020-12-18 07:34:07'),
('699446d7-4103-11eb-81c0-2cfda12b034d', '688be764-4103-11eb-81c0-2cfda12b034d', '98bb286b-295a-11eb-841b-2cfda12b034d', 1, '2020-12-18 07:34:07', '2020-12-18 07:34:07'),
('6e716d86-4140-11eb-a487-2cfda12b034d', '6e59a8d7-4140-11eb-a487-2cfda12b034d', 'c4de0aac-2959-11eb-841b-2cfda12b034d', 1, '2020-12-18 14:50:55', '2020-12-18 14:50:55'),
('6e7b319b-4140-11eb-a487-2cfda12b034d', '6e59a8d7-4140-11eb-a487-2cfda12b034d', 'cc8edc7b-2a0e-11eb-902a-2cfda12b034d', 1, '2020-12-18 14:50:55', '2020-12-18 14:50:55'),
('9f9869f8-32e6-11eb-9475-2cfda12b034d', '9f7d0813-32e6-11eb-9475-2cfda12b034d', '509f1ebc-2959-11eb-841b-2cfda12b034d', 1, '2020-11-30 08:32:46', '2020-11-30 08:32:46'),
('9fa27edd-32e6-11eb-9475-2cfda12b034d', '9f7d0813-32e6-11eb-9475-2cfda12b034d', '79f2bc0f-295a-11eb-841b-2cfda12b034d', 1, '2020-11-30 08:32:46', '2020-11-30 08:32:46'),
('a60648f7-3228-11eb-9936-2cfda12b034d', 'a5ffc64b-3228-11eb-9936-2cfda12b034d', '736a3e25-2959-11eb-841b-2cfda12b034d', 1, '2020-11-29 09:52:53', '2020-11-29 09:52:53'),
('a60e5797-3228-11eb-9936-2cfda12b034d', 'a5ffc64b-3228-11eb-9936-2cfda12b034d', '79f2bc0f-295a-11eb-841b-2cfda12b034d', 1, '2020-11-29 09:52:53', '2020-11-29 09:52:53'),
('c2e78287-4139-11eb-a487-2cfda12b034d', 'c2dac537-4139-11eb-a487-2cfda12b034d', '79f2bc0f-295a-11eb-841b-2cfda12b034d', 1, '2020-12-18 14:03:10', '2020-12-18 14:03:10'),
('c2f0c429-4139-11eb-a487-2cfda12b034d', 'c2dac537-4139-11eb-a487-2cfda12b034d', '509f1ebc-2959-11eb-841b-2cfda12b034d', 1, '2020-12-18 14:03:10', '2020-12-18 14:03:10'),
('e1aee071-3228-11eb-9936-2cfda12b034d', 'a5ffc64b-3228-11eb-9936-2cfda12b034d', 'd07197b8-2959-11eb-841b-2cfda12b034d', 1, '2020-11-29 09:54:33', '2020-11-29 09:54:33'),
('f8e21c1d-32ec-11eb-9475-2cfda12b034d', 'f8d58a19-32ec-11eb-9475-2cfda12b034d', 'd07197b8-2959-11eb-841b-2cfda12b034d', 1, '2020-11-30 09:18:13', '2020-11-30 09:18:13'),
('f8e7e87c-32ec-11eb-9475-2cfda12b034d', 'f8d58a19-32ec-11eb-9475-2cfda12b034d', '076c72e7-295a-11eb-841b-2cfda12b034d', 1, '2020-11-30 09:18:13', '2020-11-30 09:18:13'),
('f8f51c14-32ec-11eb-9475-2cfda12b034d', 'f8d58a19-32ec-11eb-9475-2cfda12b034d', '83eeabdb-295a-11eb-841b-2cfda12b034d', 1, '2020-11-30 09:18:13', '2020-11-30 09:18:13'),
('fff06d3f-4141-11eb-a487-2cfda12b034d', 'ffe965b2-4141-11eb-a487-2cfda12b034d', 'e83b79ec-2959-11eb-841b-2cfda12b034d', 1, '2020-12-18 15:02:08', '2020-12-18 15:02:08'),
('fffc50e2-4141-11eb-a487-2cfda12b034d', 'ffe965b2-4141-11eb-a487-2cfda12b034d', '8b16c72e-295a-11eb-841b-2cfda12b034d', 1, '2020-12-18 15:02:08', '2020-12-18 15:02:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payments`
--

CREATE TABLE `payments` (
  `uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `order_uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `moneyPaid` double(8,2) NOT NULL,
  `moneyTurn` double(8,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `payments`
--

INSERT INTO `payments` (`uid`, `order_uid`, `amount`, `moneyPaid`, `moneyTurn`, `created_at`, `updated_at`) VALUES
('0ebe9bfc-3229-11eb-9936-2cfda12b034d', 'a5ffc64b-3228-11eb-9936-2cfda12b034d', 40000.00, 50000.00, 10000.00, '2020-11-29 09:55:48', '2020-11-29 09:55:48'),
('13ec1764-322f-11eb-9936-2cfda12b034d', '113c5b6d-322b-11eb-9936-2cfda12b034d', 46000.00, 50000.00, 4000.00, '2020-11-29 10:38:54', '2020-11-29 10:38:54'),
('3d67c427-4141-11eb-a487-2cfda12b034d', '6e59a8d7-4140-11eb-a487-2cfda12b034d', 17000.00, 20000.00, 3000.00, '2020-12-18 14:56:42', '2020-12-18 14:56:42'),
('408b00c4-4142-11eb-a487-2cfda12b034d', 'ffe965b2-4141-11eb-a487-2cfda12b034d', 34000.00, 50000.00, 16000.00, '2020-12-18 15:03:57', '2020-12-18 15:03:57'),
('461d25a7-32ef-11eb-9475-2cfda12b034d', '32e87600-32ef-11eb-9475-2cfda12b034d', 24000.00, 30000.00, 6000.00, '2020-11-30 09:34:41', '2020-11-30 09:34:41'),
('71916d68-32ee-11eb-9475-2cfda12b034d', 'f8d58a19-32ec-11eb-9475-2cfda12b034d', 22000.00, 30000.00, 8000.00, '2020-11-30 09:28:45', '2020-11-30 09:28:45'),
('79da405f-40ef-11eb-a549-2cfda12b034d', '0018cfde-40ef-11eb-a549-2cfda12b034d', 25000.00, 30000.00, 5000.00, '2020-12-18 05:11:25', '2020-12-18 05:11:25'),
('ac9db6fb-4103-11eb-81c0-2cfda12b034d', '4cba0c63-4103-11eb-81c0-2cfda12b034d', 25000.00, 30000.00, 5000.00, '2020-12-18 07:36:00', '2020-12-18 07:36:00'),
('c6e3bbd1-32ec-11eb-9475-2cfda12b034d', '9f7d0813-32e6-11eb-9475-2cfda12b034d', 28000.00, 30000.00, 2000.00, '2020-11-30 09:16:49', '2020-11-30 09:16:49'),
('d2ee3ea0-4103-11eb-81c0-2cfda12b034d', '688be764-4103-11eb-81c0-2cfda12b034d', 27000.00, 30000.00, 3000.00, '2020-12-18 07:37:04', '2020-12-18 07:37:04'),
('df422bb4-413a-11eb-a487-2cfda12b034d', 'c2dac537-4139-11eb-a487-2cfda12b034d', 28000.00, 30000.00, 2000.00, '2020-12-18 14:11:07', '2020-12-18 14:11:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tables`
--

CREATE TABLE `tables` (
  `uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `table_number` tinyint(4) NOT NULL,
  `status` enum('Kosong','Telah dipesan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tables`
--

INSERT INTO `tables` (`uid`, `table_number`, `status`, `created_at`, `updated_at`) VALUES
('3109adda-2f00-11eb-980c-2cfda12b034d', 1, 'Kosong', '2020-11-25 09:25:33', '2020-12-18 07:36:00'),
('3117545b-2f00-11eb-980c-2cfda12b034d', 3, 'Kosong', '2020-11-25 09:25:33', '2020-12-18 15:03:57'),
('311eccf5-2f00-11eb-980c-2cfda12b034d', 4, 'Kosong', '2020-11-25 09:25:33', '2020-12-18 14:56:42'),
('3127dc7c-2f00-11eb-980c-2cfda12b034d', 5, 'Kosong', '2020-11-25 09:25:33', '2020-12-18 05:11:25'),
('312f854f-2f00-11eb-980c-2cfda12b034d', 6, 'Kosong', '2020-11-25 09:25:33', '2020-11-25 09:25:33'),
('3155654b-2f00-11eb-980c-2cfda12b034d', 7, 'Kosong', '2020-11-25 09:25:33', '2020-11-25 09:25:33'),
('318b2079-2f00-11eb-980c-2cfda12b034d', 8, 'Kosong', '2020-11-25 09:25:34', '2020-11-25 09:25:34'),
('31af4086-2f00-11eb-980c-2cfda12b034d', 9, 'Kosong', '2020-11-25 09:25:34', '2020-11-25 09:25:34'),
('31d339af-2f00-11eb-980c-2cfda12b034d', 10, 'Kosong', '2020-11-25 09:25:34', '2020-11-25 09:25:34'),
('31dab226-2f00-11eb-980c-2cfda12b034d', 11, 'Kosong', '2020-11-25 09:25:34', '2020-11-26 10:51:50'),
('31e0a5be-2f00-11eb-980c-2cfda12b034d', 12, 'Kosong', '2020-11-25 09:25:34', '2020-11-25 09:25:34'),
('31ff5e0b-2f00-11eb-980c-2cfda12b034d', 13, 'Kosong', '2020-11-25 09:25:35', '2020-11-25 09:25:35'),
('32058e65-2f00-11eb-980c-2cfda12b034d', 14, 'Kosong', '2020-11-25 09:25:35', '2020-11-25 09:25:35'),
('32113137-2f00-11eb-980c-2cfda12b034d', 15, 'Kosong', '2020-11-25 09:25:35', '2020-11-25 09:25:35'),
('325b237b-2f00-11eb-980c-2cfda12b034d', 16, 'Kosong', '2020-11-25 09:25:35', '2020-11-25 09:25:35'),
('32861a17-2f00-11eb-980c-2cfda12b034d', 17, 'Kosong', '2020-11-25 09:25:35', '2020-11-25 09:25:35'),
('32c0bb89-2f00-11eb-980c-2cfda12b034d', 18, 'Kosong', '2020-11-25 09:25:36', '2020-11-25 09:25:36'),
('32f04c2c-2f00-11eb-980c-2cfda12b034d', 19, 'Kosong', '2020-11-25 09:25:36', '2020-11-25 09:25:36'),
('331cf676-2f00-11eb-980c-2cfda12b034d', 20, 'Kosong', '2020-11-25 09:25:36', '2020-11-25 09:25:36'),
('cc40d17a-319b-11eb-b8e1-2cfda12b034d', 2, 'Kosong', '2020-11-28 17:04:38', '2020-11-30 09:28:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `uid` char(36) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT uuid(),
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` smallint(6) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`uid`, `name`, `email`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
('3102b64b-2f00-11eb-980c-2cfda12b034d', 'Owner', 'admin@kafe.com', '$2y$10$2Ps15vGFccNM5N2bxRiZPuqkR4r.Qyh/NVYEJMDe8MR8DCxWBZVAm', 62, 'hxZEh6xrGkgy1QiIzexKuhAIYlmoR3qOv90YLZVWJBMNnRcH6DYCG1S3Bsl6', '2020-11-25 09:25:33', '2020-11-25 09:25:33'),
('4b949107-321a-11eb-9936-2cfda12b034d', 'Rizky Al', 'rizky@kafe.com', '$2y$10$PjEBiEeUhZu/iIEZpPrCfezzi45DowOD0syVhiV5KKBLz.XIyKkli', 26, 'b7mv9uOVH2LzJgOavoPv2vmDB8EGrOT11BDJRC9e59vfVtIiV0BKl2EdKRkc', '2020-11-29 08:10:08', '2020-11-29 08:10:08'),
('5a98d4b6-321a-11eb-9936-2cfda12b034d', 'Fariz Ha', 'fariz@kafe.com', '$2y$10$1KyCJDtCJaIAUicWEyd7WeU8pDoAMHxsCCKWvV.mypgDop37ZsPca', 26, 'P43l8xuVZg44l6tJYsFXBoI8EdnAu9lh3v4cmEYfjGvaa4vkONCK0QyYfMv9', '2020-11-29 08:10:33', '2020-11-29 08:10:33');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`uid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`uid`);

--
-- Indeks untuk tabel `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`uid`);

--
-- Indeks untuk tabel `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`uid`);

--
-- Indeks untuk tabel `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`uid`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
