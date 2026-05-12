-- ============================================================
--  SISTEM MANAJEMEN LAUNDRY MULTI-CABANG
--  Database: laundry_db
--  Dibuat untuk XAMPP / phpMyAdmin (MySQL / MariaDB)
-- ============================================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+07:00";
SET NAMES utf8mb4;

-- Buat & gunakan database
CREATE DATABASE IF NOT EXISTS `laundry_db`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `laundry_db`;

-- ============================================================
-- 1. TABEL CABANGS
-- ============================================================
CREATE TABLE `cabang` (
  `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama`       VARCHAR(100)    NOT NULL,
  `kode`       VARCHAR(10)     NOT NULL,
  `alamat`     TEXT            NOT NULL,
  `telepon`    VARCHAR(20)     DEFAULT NULL,
  `is_active`  TINYINT(1)      NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP       NULL DEFAULT NULL,
  `updated_at` TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cabang_kode_unique` (`kode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 2. TABEL USERS
-- ============================================================
CREATE TABLE `users` (
  `id`             BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama`           VARCHAR(100)    NOT NULL,
  `username`       VARCHAR(50)     NOT NULL,
  `password`       VARCHAR(255)    NOT NULL,
  `role`           ENUM('superadmin','admin_pusat','admin_cabang') NOT NULL,
  `cabang_id`      BIGINT UNSIGNED DEFAULT NULL,
  `is_active`      TINYINT(1)      NOT NULL DEFAULT 1,
  `remember_token` VARCHAR(100)    DEFAULT NULL,
  `created_at`     TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`     TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  KEY `users_cabang_id_foreign` (`cabang_id`),
  CONSTRAINT `users_cabang_id_foreign`
    FOREIGN KEY (`cabang_id`) REFERENCES `cabang` (`id`)
    ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 3. TABEL LAYANANS
-- ============================================================
CREATE TABLE `layanan` (
  `id`           BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `nama`         VARCHAR(100)     NOT NULL,
  `harga_per_kg` DECIMAL(10,2)   NOT NULL,
  `estimasi_jam` INT              NOT NULL DEFAULT 24,
  `deskripsi`    TEXT             DEFAULT NULL,
  `is_active`    TINYINT(1)       NOT NULL DEFAULT 1,
  `created_at`   TIMESTAMP        NULL DEFAULT NULL,
  `updated_at`   TIMESTAMP        NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 4. TABEL TRANSAKSIS
-- ============================================================
CREATE TABLE `transaksi` (
  `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_transaksi`   VARCHAR(30)     NOT NULL,
  `cabang_id`        BIGINT UNSIGNED NOT NULL,
  `layanan_id`       BIGINT UNSIGNED NOT NULL,
  `user_id`          BIGINT UNSIGNED NOT NULL,
  `nama_customer`    VARCHAR(100)    NOT NULL,
  `no_hp`            VARCHAR(20)     NOT NULL,
  `catatan`          TEXT            DEFAULT NULL,
  `berat_kg`         DECIMAL(8,2)    NOT NULL,
  `harga_per_kg`     DECIMAL(10,2)   NOT NULL,
  `total_harga`      DECIMAL(10,2)   NOT NULL,
  `status`           ENUM('diterima','diproses','selesai','diambil') NOT NULL DEFAULT 'diterima',
  `status_bayar`     ENUM('belum_bayar','lunas') NOT NULL DEFAULT 'belum_bayar',
  `tgl_masuk`        TIMESTAMP       NULL DEFAULT NULL,
  `estimasi_selesai` TIMESTAMP       NULL DEFAULT NULL,
  `tgl_selesai`      TIMESTAMP       NULL DEFAULT NULL,
  `tgl_diambil`      TIMESTAMP       NULL DEFAULT NULL,
  `tgl_bayar`        TIMESTAMP       NULL DEFAULT NULL,
  `created_at`       TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`       TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaksis_kode_transaksi_unique` (`kode_transaksi`),
  KEY `transaksis_cabang_id_foreign`  (`cabang_id`),
  KEY `transaksis_layanan_id_foreign` (`layanan_id`),
  KEY `transaksis_user_id_foreign`    (`user_id`),
  CONSTRAINT `transaksis_cabang_id_foreign`
    FOREIGN KEY (`cabang_id`)  REFERENCES `cabang`  (`id`),
  CONSTRAINT `transaksis_layanan_id_foreign`
    FOREIGN KEY (`layanan_id`) REFERENCES `layanan` (`id`),
  CONSTRAINT `transaksis_user_id_foreign`
    FOREIGN KEY (`user_id`)    REFERENCES `users`    (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 5. TABEL STATUS_LOGS
-- ============================================================
CREATE TABLE `status_logs` (
  `id`           BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `transaksi_id` BIGINT UNSIGNED NOT NULL,
  `user_id`      BIGINT UNSIGNED NOT NULL,
  `status`       ENUM('diterima','diproses','selesai','diambil') NOT NULL,
  `catatan`      TEXT            DEFAULT NULL,
  `created_at`   TIMESTAMP       NULL DEFAULT NULL,
  `updated_at`   TIMESTAMP       NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `status_logs_transaksi_id_foreign` (`transaksi_id`),
  KEY `status_logs_user_id_foreign`      (`user_id`),
  CONSTRAINT `status_logs_transaksi_id_foreign`
    FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `status_logs_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- 6. TABEL MIGRATIONS (wajib ada agar Laravel tidak error)
-- ============================================================
CREATE TABLE `migrations` (
  `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch`     INT          NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2024_01_01_000000_create_cabangs_table',     1),
('2024_01_01_000001_create_users_table',       1),
('2024_01_01_000002_create_layanans_table',    1),
('2024_01_01_000003_create_transaksis_table',  1),
('2024_01_01_000004_create_status_logs_table', 1);

-- ============================================================
-- DATA AWAL — CABANG
-- ============================================================
INSERT INTO `cabang` (`id`, `nama`, `kode`, `alamat`, `telepon`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cabang Jakarta Pusat', 'JKT', 'Jl. Sudirman No. 10, Jakarta Pusat',  '021-12345678', 1, NOW(), NOW()),
(2, 'Cabang Bandung',       'BDG', 'Jl. Asia Afrika No. 5, Bandung',       '022-87654321', 1, NOW(), NOW()),
(3, 'Cabang Surabaya',      'SBY', 'Jl. Pemuda No. 20, Surabaya',          '031-11223344', 1, NOW(), NOW()),
(4, 'Cabang Yogyakarta',    'YGY', 'Jl. Malioboro No. 15, Yogyakarta',     '0274-556677',  1, NOW(), NOW());

-- ============================================================
-- DATA AWAL — USERS
-- Password semua akun = "password"
-- Hash bcrypt dari string "password"
-- ============================================================
INSERT INTO `users` (`id`, `nama`, `username`, `password`, `role`, `cabang_id`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Super Administrator', 'superadmin',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin',   NULL, 1, NOW(), NOW()),
(2, 'Admin Pusat',         'adminpusat',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_pusat',  NULL, 1, NOW(), NOW()),
(3, 'Admin Jakarta',       'cabang_jkt',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_cabang', 1,    1, NOW(), NOW()),
(4, 'Admin Bandung',       'cabang_bdg',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_cabang', 2,    1, NOW(), NOW()),
(5, 'Admin Surabaya',      'cabang_sby',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_cabang', 3,    1, NOW(), NOW()),
(6, 'Admin Yogyakarta',    'cabang_ygy',  '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin_cabang', 4,    1, NOW(), NOW());

-- ============================================================
-- DATA AWAL — LAYANAN
-- ============================================================
INSERT INTO `layanan` (`id`, `nama`, `harga_per_kg`, `estimasi_jam`, `deskripsi`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Cuci & Kering',    5000,  24, 'Cuci dan keringkan pakaian',                       1, NOW(), NOW()),
(2, 'Cuci & Setrika',   7000,  48, 'Cuci, keringkan, dan setrika pakaian',             1, NOW(), NOW()),
(3, 'Express (6 Jam)',  12000,  6, 'Layanan kilat selesai dalam 6 jam',                1, NOW(), NOW()),
(4, 'Setrika Saja',     4000,  12, 'Setrika pakaian yang sudah dicuci',                1, NOW(), NOW()),
(5, 'Cuci Sepatu',      25000, 48, 'Cuci bersih sepatu (harga per pasang)',            1, NOW(), NOW()),
(6, 'Dry Cleaning',     20000, 72, 'Dry cleaning untuk pakaian khusus / jas / gaun',   1, NOW(), NOW());

-- ============================================================
-- DATA CONTOH — TRANSAKSI (30 transaksi sample)
-- ============================================================
INSERT INTO `transaksi`
  (`kode_transaksi`,`cabang_id`,`layanan_id`,`user_id`,`nama_customer`,`no_hp`,
   `berat_kg`,`harga_per_kg`,`total_harga`,`status`,`status_bayar`,
   `tgl_masuk`,`estimasi_selesai`,`tgl_selesai`,`tgl_diambil`,`tgl_bayar`,`created_at`,`updated_at`)
VALUES
-- Cabang Jakarta
('LDR-JKT-20240301-0001',1,1,3,'Budi Santoso',  '081234567890',3.5, 5000, 17500, 'diambil','lunas',  '2024-03-01 09:00:00','2024-03-02 09:00:00','2024-03-02 08:30:00','2024-03-02 10:00:00','2024-03-02 10:00:00','2024-03-01 09:00:00','2024-03-02 10:00:00'),
('LDR-JKT-20240302-0001',1,2,3,'Siti Rahayu',   '082345678901',5.0, 7000, 35000, 'diambil','lunas',  '2024-03-02 10:00:00','2024-03-04 10:00:00','2024-03-04 09:00:00','2024-03-04 11:00:00','2024-03-04 11:00:00','2024-03-02 10:00:00','2024-03-04 11:00:00'),
('LDR-JKT-20240310-0001',1,3,3,'Ahmad Fauzi',   '083456789012',2.0,12000, 24000, 'selesai','belum_bayar','2024-03-10 08:00:00','2024-03-10 14:00:00','2024-03-10 13:30:00',NULL,NULL,'2024-03-10 08:00:00','2024-03-10 13:30:00'),
('LDR-JKT-20240315-0001',1,1,3,'Dewi Kusuma',   '084567890123',4.0, 5000, 20000, 'diproses','belum_bayar','2024-03-15 11:00:00','2024-03-16 11:00:00',NULL,NULL,NULL,'2024-03-15 11:00:00','2024-03-15 14:00:00'),
('LDR-JKT-20240320-0001',1,6,3,'Rini Wulandari','085678901234',1.5,20000, 30000, 'diterima','belum_bayar','2024-03-20 09:30:00','2024-03-23 09:30:00',NULL,NULL,NULL,'2024-03-20 09:30:00','2024-03-20 09:30:00'),

-- Cabang Bandung
('LDR-BDG-20240301-0001',2,2,4,'Hendra Gunawan','086789012345',6.0, 7000, 42000, 'diambil','lunas',  '2024-03-01 08:30:00','2024-03-03 08:30:00','2024-03-03 08:00:00','2024-03-03 09:00:00','2024-03-03 09:00:00','2024-03-01 08:30:00','2024-03-03 09:00:00'),
('LDR-BDG-20240305-0001',2,1,4,'Rina Melati',   '087890123456',3.0, 5000, 15000, 'diambil','lunas',  '2024-03-05 10:00:00','2024-03-06 10:00:00','2024-03-06 09:30:00','2024-03-06 10:30:00','2024-03-06 10:30:00','2024-03-05 10:00:00','2024-03-06 10:30:00'),
('LDR-BDG-20240312-0001',2,4,4,'Agus Setiawan', '088901234567',2.5, 4000, 10000, 'selesai','belum_bayar','2024-03-12 09:00:00','2024-03-12 21:00:00','2024-03-12 20:00:00',NULL,NULL,'2024-03-12 09:00:00','2024-03-12 20:00:00'),
('LDR-BDG-20240318-0001',2,3,4,'Maya Putri',    '089012345678',1.0,12000, 12000, 'diproses','belum_bayar','2024-03-18 14:00:00','2024-03-18 20:00:00',NULL,NULL,NULL,'2024-03-18 14:00:00','2024-03-18 15:00:00'),
('LDR-BDG-20240322-0001',2,5,4,'Farid Hidayat', '081123456789',2.0,25000, 50000, 'diterima','belum_bayar','2024-03-22 10:00:00','2024-03-24 10:00:00',NULL,NULL,NULL,'2024-03-22 10:00:00','2024-03-22 10:00:00'),

-- Cabang Surabaya
('LDR-SBY-20240302-0001',3,1,5,'Bambang Utomo', '082234567890',7.0, 5000, 35000, 'diambil','lunas',  '2024-03-02 08:00:00','2024-03-03 08:00:00','2024-03-03 07:30:00','2024-03-03 09:00:00','2024-03-03 09:00:00','2024-03-02 08:00:00','2024-03-03 09:00:00'),
('LDR-SBY-20240308-0001',3,2,5,'Lestari Indah', '083345678901',4.5, 7000, 31500, 'diambil','lunas',  '2024-03-08 09:00:00','2024-03-10 09:00:00','2024-03-10 08:30:00','2024-03-10 10:00:00','2024-03-10 10:00:00','2024-03-08 09:00:00','2024-03-10 10:00:00'),
('LDR-SBY-20240314-0001',3,6,5,'Doni Pratama',  '084456789012',1.0,20000, 20000, 'selesai','belum_bayar','2024-03-14 11:00:00','2024-03-17 11:00:00','2024-03-17 10:00:00',NULL,NULL,'2024-03-14 11:00:00','2024-03-17 10:00:00'),
('LDR-SBY-20240319-0001',3,1,5,'Yuni Astuti',   '085567890123',3.0, 5000, 15000, 'diproses','belum_bayar','2024-03-19 13:00:00','2024-03-20 13:00:00',NULL,NULL,NULL,'2024-03-19 13:00:00','2024-03-19 15:00:00'),
('LDR-SBY-20240323-0001',3,3,5,'Rizky Aditya',  '086678901234',2.0,12000, 24000, 'diterima','belum_bayar','2024-03-23 09:00:00','2024-03-23 15:00:00',NULL,NULL,NULL,'2024-03-23 09:00:00','2024-03-23 09:00:00'),

-- Cabang Yogyakarta
('LDR-YGY-20240303-0001',4,2,6,'Putri Handayani','087789012345',5.5, 7000, 38500,'diambil','lunas',  '2024-03-03 08:00:00','2024-03-05 08:00:00','2024-03-05 07:30:00','2024-03-05 09:00:00','2024-03-05 09:00:00','2024-03-03 08:00:00','2024-03-05 09:00:00'),
('LDR-YGY-20240309-0001',4,1,6,'Wahyu Nugroho', '088890123456',4.0, 5000, 20000, 'diambil','lunas',  '2024-03-09 10:00:00','2024-03-10 10:00:00','2024-03-10 09:30:00','2024-03-10 11:00:00','2024-03-10 11:00:00','2024-03-09 10:00:00','2024-03-10 11:00:00'),
('LDR-YGY-20240316-0001',4,4,6,'Sri Mulyani',   '089901234567',3.0, 4000, 12000, 'selesai','belum_bayar','2024-03-16 09:00:00','2024-03-16 21:00:00','2024-03-16 20:30:00',NULL,NULL,'2024-03-16 09:00:00','2024-03-16 20:30:00'),
('LDR-YGY-20240321-0001',4,5,6,'Eko Prasetyo',  '081012345678',3.0,25000, 75000, 'diproses','belum_bayar','2024-03-21 10:00:00','2024-03-23 10:00:00',NULL,NULL,NULL,'2024-03-21 10:00:00','2024-03-21 12:00:00'),
('LDR-YGY-20240324-0001',4,3,6,'Nita Sari',     '082112345678',1.5,12000, 18000, 'diterima','belum_bayar','2024-03-24 08:30:00','2024-03-24 14:30:00',NULL,NULL,NULL,'2024-03-24 08:30:00','2024-03-24 08:30:00'),

-- Transaksi bulan April (untuk grafik)
('LDR-JKT-20240401-0001',1,1,3,'Budi Santoso',  '081234567890',4.0, 5000, 20000, 'diambil','lunas',  '2024-04-01 09:00:00','2024-04-02 09:00:00','2024-04-02 08:30:00','2024-04-02 10:00:00','2024-04-02 10:00:00','2024-04-01 09:00:00','2024-04-02 10:00:00'),
('LDR-BDG-20240401-0001',2,2,4,'Hendra Gunawan','086789012345',5.0, 7000, 35000, 'diambil','lunas',  '2024-04-01 10:00:00','2024-04-03 10:00:00','2024-04-03 09:00:00','2024-04-03 11:00:00','2024-04-03 11:00:00','2024-04-01 10:00:00','2024-04-03 11:00:00'),
('LDR-SBY-20240402-0001',3,3,5,'Bambang Utomo', '082234567890',2.0,12000, 24000, 'diambil','lunas',  '2024-04-02 08:00:00','2024-04-02 14:00:00','2024-04-02 13:30:00','2024-04-02 15:00:00','2024-04-02 15:00:00','2024-04-02 08:00:00','2024-04-02 15:00:00'),
('LDR-YGY-20240403-0001',4,1,6,'Putri Handayani','087789012345',6.0, 5000, 30000,'diambil','lunas',  '2024-04-03 09:00:00','2024-04-04 09:00:00','2024-04-04 08:30:00','2024-04-04 10:00:00','2024-04-04 10:00:00','2024-04-03 09:00:00','2024-04-04 10:00:00'),
('LDR-JKT-20240410-0001',1,2,3,'Ahmad Fauzi',   '083456789012',3.5, 7000, 24500, 'diambil','lunas',  '2024-04-10 10:00:00','2024-04-12 10:00:00','2024-04-12 09:30:00','2024-04-12 11:00:00','2024-04-12 11:00:00','2024-04-10 10:00:00','2024-04-12 11:00:00'),
('LDR-BDG-20240412-0001',2,6,4,'Maya Putri',    '089012345678',1.0,20000, 20000, 'diambil','lunas',  '2024-04-12 09:00:00','2024-04-15 09:00:00','2024-04-15 08:30:00','2024-04-15 10:00:00','2024-04-15 10:00:00','2024-04-12 09:00:00','2024-04-15 10:00:00'),
('LDR-SBY-20240415-0001',3,1,5,'Lestari Indah', '083345678901',5.0, 5000, 25000, 'selesai','belum_bayar','2024-04-15 08:00:00','2024-04-16 08:00:00','2024-04-16 07:30:00',NULL,NULL,'2024-04-15 08:00:00','2024-04-16 07:30:00'),
('LDR-YGY-20240416-0001',4,2,6,'Wahyu Nugroho', '088890123456',4.0, 7000, 28000, 'diproses','belum_bayar','2024-04-16 10:00:00','2024-04-18 10:00:00',NULL,NULL,NULL,'2024-04-16 10:00:00','2024-04-16 12:00:00'),
('LDR-JKT-20240420-0001',1,5,3,'Dewi Kusuma',   '084567890123',2.0,25000, 50000, 'diterima','belum_bayar','2024-04-20 11:00:00','2024-04-22 11:00:00',NULL,NULL,NULL,'2024-04-20 11:00:00','2024-04-20 11:00:00'),
('LDR-BDG-20240421-0001',2,3,4,'Agus Setiawan', '088901234567',1.5,12000, 18000, 'diterima','belum_bayar','2024-04-21 09:00:00','2024-04-21 15:00:00',NULL,NULL,NULL,'2024-04-21 09:00:00','2024-04-21 09:00:00'),
('LDR-SBY-20240422-0001',3,4,5,'Doni Pratama',  '084456789012',3.0, 4000, 12000, 'diterima','belum_bayar','2024-04-22 14:00:00','2024-04-23 02:00:00',NULL,NULL,NULL,'2024-04-22 14:00:00','2024-04-22 14:00:00');

-- ============================================================
-- DATA CONTOH — STATUS LOGS
-- ============================================================
INSERT INTO `status_logs` (`transaksi_id`,`user_id`,`status`,`catatan`,`created_at`,`updated_at`) VALUES
-- Transaksi 1 (diambil)
(1,3,'diterima','Transaksi diterima','2024-03-01 09:00:00','2024-03-01 09:00:00'),
(1,3,'diproses','Mulai dicuci',      '2024-03-01 10:00:00','2024-03-01 10:00:00'),
(1,3,'selesai', 'Sudah selesai',     '2024-03-02 08:30:00','2024-03-02 08:30:00'),
(1,3,'diambil', 'Customer mengambil','2024-03-02 10:00:00','2024-03-02 10:00:00'),
-- Transaksi 2 (diambil)
(2,4,'diterima','Transaksi diterima','2024-03-02 10:00:00','2024-03-02 10:00:00'),
(2,4,'diproses','Sedang diproses',   '2024-03-02 11:00:00','2024-03-02 11:00:00'),
(2,4,'selesai', 'Selesai dicuci',    '2024-03-04 09:00:00','2024-03-04 09:00:00'),
(2,4,'diambil', 'Sudah diambil',     '2024-03-04 11:00:00','2024-03-04 11:00:00'),
-- Transaksi 3 (selesai)
(3,3,'diterima','Transaksi diterima','2024-03-10 08:00:00','2024-03-10 08:00:00'),
(3,3,'diproses','Proses express',    '2024-03-10 09:00:00','2024-03-10 09:00:00'),
(3,3,'selesai', 'Express selesai',   '2024-03-10 13:30:00','2024-03-10 13:30:00'),
-- Transaksi 4 (diproses)
(4,3,'diterima','Transaksi diterima','2024-03-15 11:00:00','2024-03-15 11:00:00'),
(4,3,'diproses','Sedang diproses',   '2024-03-15 14:00:00','2024-03-15 14:00:00'),
-- Transaksi 5 (diterima)
(5,3,'diterima','Transaksi diterima','2024-03-20 09:30:00','2024-03-20 09:30:00');

-- ============================================================
-- SELESAI
-- ============================================================
