-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2026 at 10:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nexus_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `session_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `user_id`, `session_id`, `created_at`, `updated_at`) VALUES
(1, NULL, 'fDsVPodlS5Zr0Ro6uxYGrKDEfmYS6CI1ibfT5SPC', '2026-06-05 13:55:06', '2026-06-05 13:55:06'),
(2, 2, NULL, '2026-06-05 14:04:12', '2026-06-05 14:04:12'),
(3, 3, NULL, '2026-06-05 14:29:57', '2026-06-05 14:29:57');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `cart_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `selected_attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`selected_attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `cart_id`, `product_id`, `quantity`, `unit_price`, `selected_attributes`, `created_at`, `updated_at`) VALUES
(1, 3, 2, 1, 349.00, NULL, '2026-06-05 14:32:44', '2026-06-05 14:32:44');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', 'Cutting-edge gadgets, devices, and consumer electronics.', NULL, NULL, 1, 1, '2026-06-05 14:02:32', '2026-06-05 14:02:32'),
(2, 'Clothing & Apparel', 'clothing-apparel', 'Premium fashion for men, women, and children.', NULL, NULL, 1, 2, '2026-06-05 14:02:32', '2026-06-05 14:02:32'),
(3, 'Home & Living', 'home-living', 'Everything to elevate your home environment.', NULL, NULL, 1, 3, '2026-06-05 14:02:32', '2026-06-05 14:02:32'),
(4, 'Sports & Outdoors', 'sports-outdoors', 'Gear and equipment for every active lifestyle.', NULL, NULL, 1, 4, '2026-06-05 14:02:32', '2026-06-05 14:02:32'),
(5, 'Books & Media', 'books-media', 'Expand your knowledge and entertainment collection.', NULL, NULL, 1, 5, '2026-06-05 14:02:32', '2026-06-05 14:02:32'),
(6, 'Beauty & Personal Care', 'beauty-personal-care', 'Premium skincare, grooming, and wellness products.', NULL, NULL, 1, 6, '2026-06-05 14:02:32', '2026-06-05 14:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_01_01_000002_create_categories_table', 1),
(5, '2024_01_01_000003_create_products_table', 1),
(6, '2024_01_01_000004_create_carts_table', 1),
(7, '2024_01_01_000005_create_cart_items_table', 1),
(8, '2024_01_01_000006_create_orders_table', 1),
(9, '2024_01_01_000007_create_order_items_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(50) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','refunded','failed') NOT NULL DEFAULT 'unpaid',
  `payment_method` varchar(50) DEFAULT NULL,
  `payment_transaction_id` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `tax_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `shipping_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_name` varchar(150) NOT NULL,
  `shipping_email` varchar(150) NOT NULL,
  `shipping_phone` varchar(30) DEFAULT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_country` varchar(100) NOT NULL,
  `shipping_postal_code` varchar(20) NOT NULL,
  `customer_notes` text DEFAULT NULL,
  `admin_notes` text DEFAULT NULL,
  `shipped_at` timestamp NULL DEFAULT NULL,
  `delivered_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(100) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `unit_price` decimal(10,2) NOT NULL,
  `quantity` int(10) UNSIGNED NOT NULL,
  `line_total` decimal(10,2) NOT NULL,
  `selected_attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`selected_attributes`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `sku` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `compare_price` decimal(10,2) DEFAULT NULL,
  `stock_quantity` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `primary_image` varchar(255) DEFAULT NULL,
  `gallery_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`gallery_images`)),
  `weight` decimal(8,3) DEFAULT NULL,
  `brand` varchar(150) DEFAULT NULL,
  `attributes` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`attributes`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `views_count` bigint(20) UNSIGNED NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `short_description`, `description`, `sku`, `price`, `compare_price`, `stock_quantity`, `primary_image`, `gallery_images`, `weight`, `brand`, `attributes`, `is_active`, `is_featured`, `views_count`, `created_at`, `updated_at`) VALUES
(1, 1, 'ProSound Wireless ANC Headphones', 'prosound-wireless-anc-headphones', 'Premium 40-hour battery life with active noise cancellation and Hi-Res audio certification.', '<p>Experience music the way the artist intended. The ProSound ANC Headphones deliver studio-quality sound with adaptive three-level noise cancellation. The 40mm dynamic drivers produce deep, punchy bass alongside crystal-clear highs.</p><p>Features: Bluetooth 5.3, 40-hour playback, 10-minute quick charge gives 3 hours of listening, foldable design, and built-in voice assistant support.</p>', 'ELC-HP-001', 179.99, 229.99, 45, 'products/jlhWGnNz3czPBCnllYA0lIvohumLkYLH1y3xC4ue.jpg', NULL, NULL, 'ProSound', NULL, 1, 1, 2078, '2026-06-05 14:02:35', '2026-06-05 16:34:27'),
(2, 1, 'UltraView 4K Portable Monitor', 'ultraview-4k-portable-monitor', 'Stunning 15.6\" 4K IPS display with USB-C single cable connectivity.', '<p>The UltraView portable monitor is the ultimate companion for professionals on the move. Its 15.6-inch IPS panel delivers 3840×2160 resolution with 100% sRGB color accuracy.</p><p>Single USB-C cable provides both power and video signal. Features include HDR400, 178° wide-view angle, and a built-in kickstand.</p>', 'ELC-MN-002', 349.00, NULL, 22, NULL, NULL, NULL, 'UltraView', NULL, 1, 1, 3964, '2026-06-05 14:02:35', '2026-06-05 16:33:59'),
(3, 1, 'NovaMech Mechanical Keyboard TKL', 'novamech-mechanical-keyboard-tkl', 'Compact tenkeyless layout with RGB per-key illumination and hot-swap switches.', '<p>Engineered for performance and customisation, the NovaMech TKL features hot-swappable PCB — change switches without soldering. Ships with NovaMech Red linear switches (45g actuation).</p><p>Aircraft-grade aluminium top plate, gasket-mounted PCB for quieter typing feel, USB-C detachable cable, and full RGB programmability via NovaMech software.</p>', 'ELC-KB-003', 129.99, 149.99, 60, NULL, NULL, NULL, 'NovaMech', NULL, 1, 0, 2864, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(4, 1, 'SwiftCharge 140W GaN Charger', 'swiftcharge-140w-gan-charger', '4-port GaN charger with 140W total output — charge your entire setup at once.', '<p>Power up to four devices simultaneously with this compact GaN charger. Features two USB-C ports (140W + 65W) and two USB-A ports with intelligent power distribution.</p>', 'ELC-CH-004', 64.99, NULL, 120, NULL, NULL, NULL, 'SwiftCharge', NULL, 1, 0, 3304, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(5, 2, 'Heritage Slim Fit Oxford Shirt', 'heritage-slim-fit-oxford-shirt', '100% premium Egyptian cotton slim-fit shirt with mother-of-pearl buttons.', '<p>Crafted from long-staple Egyptian cotton, this Heritage Oxford shirt is woven for breathability and durability. The slim-fit silhouette cuts a clean, modern line without sacrificing comfort.</p><p>Available in White, Pale Blue, Lavender, and Sage. Machine washable.</p>', 'APP-SH-001', 89.00, NULL, 200, NULL, NULL, NULL, 'Heritage Goods', NULL, 1, 1, 4088, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(6, 2, 'Alpine Merino Crew Neck Sweater', 'alpine-merino-crew-neck-sweater', 'Fine 100% Merino wool sweater — naturally temperature-regulating and itch-free.', '<p>The Alpine Merino Sweater is made from 17.5-micron fine Merino wool — the standard for luxury knitwear. Merino regulates body temperature naturally, keeps you warm in winter and cool in mild weather, and resists odour.</p>', 'APP-SW-002', 145.00, 180.00, 80, NULL, NULL, NULL, 'Alpine Thread', NULL, 1, 0, 868, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(7, 2, 'Velocity Performance Running Shorts', 'velocity-performance-running-shorts', 'Lightweight 4-way stretch shorts with built-in liner and hidden zip pocket.', '<p>Engineered for speed and comfort, the Velocity Running Shorts are made from our proprietary AeroWeave fabric — 87% recycled polyester, 13% elastane — offering maximum stretch, sweat-wicking, and UV50+ protection.</p>', 'APP-SH-003', 55.00, NULL, 150, NULL, NULL, NULL, 'Velocity Active', NULL, 1, 0, 3185, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(8, 3, 'Ember Ceramic Pour-Over Coffee Set', 'ember-ceramic-pour-over-coffee-set', 'Handcrafted ceramic dripper with borosilicate carafe for the perfect pour-over ritual.', '<p>Each Ember Pour-Over dripper is hand-thrown by artisan potters and features a carefully calibrated ribbed interior to optimise water flow and extraction. The set includes a 600ml borosilicate glass carafe, ceramic dripper, and stainless steel mesh filter.</p>', 'HOM-CF-001', 72.00, NULL, 35, NULL, NULL, NULL, 'Ember Workshop', NULL, 1, 1, 3195, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(9, 3, 'Dune Linen Duvet Cover Set — King', 'dune-linen-duvet-cover-set-king', 'Stone-washed 100% French linen in a relaxed, lived-in finish. King size set.', '<p>French flax linen, grown sustainably in Normandy, gets softer with every wash. The stone-washed finish creates an instantly relaxed aesthetic. Includes one king duvet cover (220×230cm) and two pillowcases (50×75cm).</p>', 'HOM-BD-002', 189.00, 239.00, 25, NULL, NULL, NULL, 'Dune Home', NULL, 1, 1, 4016, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(10, 3, 'Modular Walnut Shelf System', 'modular-walnut-shelf-system', 'FSC-certified solid walnut modular shelving — configure to any wall width.', '<p>Each module (90×30cm) connects seamlessly to create a bespoke shelving wall. FSC-certified solid American walnut with natural oil finish. Steel wall brackets included. Compatible with matching door and drawer modules.</p>', 'HOM-SH-003', 320.00, NULL, 15, NULL, NULL, NULL, 'Form & Grain', NULL, 1, 0, 1959, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(11, 4, 'Summit Pro 45L Hiking Backpack', 'summit-pro-45l-hiking-backpack', '45-litre technical hiking pack with integrated rain cover and adjustable torso fit.', '<p>The Summit Pro is built for multi-day alpine adventures. Features a suspended mesh back panel for airflow, hip-belt pockets, hydration reservoir sleeve (3L compatible), aluminium frame stays, and a roll-top main compartment with weather seal.</p>', 'SPT-BP-001', 215.00, 259.00, 30, NULL, NULL, NULL, 'Summit Gear', NULL, 1, 1, 684, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(12, 4, 'TrailGrip Carbon Trekking Poles (Pair)', 'trailgrip-carbon-trekking-poles-pair', 'Ultra-light 190g carbon fibre poles with ergonomic cork grips and quick-lock system.', '<p>At 190g per pole, TrailGrip Carbon poles set the benchmark for ultralight trekking. The 100% carbon fibre shaft absorbs vibration better than aluminium. Three-section QuickLock collapses to 63cm for pack attachment.</p>', 'SPT-TP-002', 109.99, NULL, 50, NULL, NULL, NULL, 'TrailGrip', NULL, 1, 0, 4878, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(13, 6, 'Lumière Daily SPF50 Moisturiser', 'lumiere-daily-spf50-moisturiser', 'Lightweight daily moisturiser with broad-spectrum SPF50 protection and hyaluronic acid.', '<p>Formulated by dermatologists, Lumière Daily SPF50 provides invisible broad-spectrum UV protection while deeply hydrating with three molecular weights of hyaluronic acid. Non-comedogenic, fragrance-free, and suitable for all skin types.</p>', 'BPC-SK-001', 42.00, NULL, 100, NULL, NULL, NULL, 'Lumière Labs', NULL, 1, 1, 1721, '2026-06-05 14:02:35', '2026-06-05 14:02:35'),
(14, 6, 'Obsidian Grooming Kit — 5 Piece', 'obsidian-grooming-kit-5-piece', 'Professional 5-piece grooming set with matte black stainless steel finish.', '<p>The Obsidian Grooming Kit includes precision nail scissors, cuticle pusher, nail file, blackhead extractor, and tweezers. Each tool is forged from 430-grade stainless steel with a PVD black coating for durability and corrosion resistance. Presented in a full-grain leather roll case.</p>', 'BPC-GR-002', 68.00, 85.00, 40, NULL, NULL, NULL, 'Obsidian Co.', NULL, 1, 0, 3717, '2026-06-05 14:02:35', '2026-06-05 14:02:35');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('ISrwzsy1r97ZGFqtJV1bj1nFvufSODq6eClm0ByM', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJGb0lUVGNXMXpIbFFBUEt5VXlxbmFWaWNGaThyNnRhSTJtTGNEdEtmIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL2FkbWluXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImFkbWluLmRhc2hib2FyZCJ9LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6Mn0=', 1780688194);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('customer','admin') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Test User', 'test@example.com', '2026-06-05 13:54:47', '$2y$12$djphvak6fzjMLuKT.TQox.pKJNAbLulk3rv4jVSDZKqAhak4YTLWW', 'D3OLOt1NAy', '2026-06-05 13:54:47', '2026-06-05 13:54:47', 'customer'),
(2, 'Admin', 'admin@nexusshop.com', NULL, '$2y$12$r6oWCO9YfUPSZGcd7s9e1eYtQrVQZGaySYRGfUJTKIow34ZsiVIBO', '39NsHOjJmZSJT5qq6ivgjVEGE8UlCqPxn6QBOWjTXc8emrdbKxS13sixUJm8', '2026-06-05 13:56:47', '2026-06-05 13:56:47', 'admin'),
(3, 'Ravza Çitil', 'ravzacitill@gmail.com', NULL, '$2y$12$8InwtRij68ske6pqUY8a1eaKPZU38c5jPJejDgIY0bZx4oes0l7hK', NULL, '2026-06-05 14:29:49', '2026-06-05 14:29:49', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carts_user_id_index` (`user_id`),
  ADD KEY `carts_session_id_index` (`session_id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cart_items_cart_id_product_id_unique` (`cart_id`,`product_id`),
  ADD KEY `cart_items_product_id_foreign` (`product_id`),
  ADD KEY `cart_items_cart_id_index` (`cart_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`),
  ADD KEY `categories_slug_index` (`slug`),
  ADD KEY `categories_is_active_index` (`is_active`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  ADD KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_index` (`user_id`),
  ADD KEY `orders_order_number_index` (`order_number`),
  ADD KEY `orders_status_index` (`status`),
  ADD KEY `orders_payment_status_index` (`payment_status`),
  ADD KEY `orders_created_at_index` (`created_at`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`),
  ADD KEY `order_items_order_id_index` (`order_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD UNIQUE KEY `products_sku_unique` (`sku`),
  ADD KEY `products_slug_index` (`slug`),
  ADD KEY `products_is_active_index` (`is_active`),
  ADD KEY `products_is_featured_index` (`is_featured`),
  ADD KEY `products_category_id_index` (`category_id`),
  ADD KEY `products_price_is_active_index` (`price`,`is_active`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

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
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_cart_id_foreign` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
