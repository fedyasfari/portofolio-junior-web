-- PBL Hari 9 Sprint 0: basis data terpisah dari Lab 3.
-- PERINGATAN: pengimporan ulang MENGHAPUS tabel/data latihan di db_capstone_sprint0!
CREATE DATABASE IF NOT EXISTS db_capstone_sprint0
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_capstone_sprint0;

DROP TABLE IF EXISTS pendaftar;
DROP TABLE IF EXISTS admin;
DROP TABLE IF EXISTS kelas;

CREATE TABLE kelas (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(100) NOT NULL,
    deskripsi VARCHAR(255) DEFAULT NULL,
    kuota INT NOT NULL DEFAULT 20 COMMENT 'Rencana fitur kuota Hari 11; belum ditegakkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pendaftar (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    kelas_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT DEFAULT NULL,
    tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_pendaftar_email UNIQUE (email),
    CONSTRAINT fk_pendaftar_kelas FOREIGN KEY (kelas_id)
        REFERENCES kelas(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Persiapan autentikasi Hari 11. Sengaja tidak diisi akun default.
CREATE TABLE admin (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(60) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    dibuat_pada TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT uq_admin_username UNIQUE (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO kelas (id, nama_kelas, deskripsi, kuota) VALUES
(1, 'Web Development', 'HTML CSS JavaScript PHP', 20),
(2, 'Desain Grafis', 'Desain visual digital', 15),
(3, 'Data Science', 'Dasar analisis data', 10);

-- 12 peserta fiktif agar pagination 10 per halaman dapat diuji langsung.
INSERT INTO pendaftar (id, kelas_id, nama, email, no_hp, alamat, tanggal_daftar) VALUES
(1, 1, 'Andi Pratama', 'andi@example.com', '081200000001', 'Surakarta', '2026-10-18 09:00:00'),
(2, 1, 'Budi Santoso', 'budi@example.com', '081200000002', 'Sukoharjo', '2026-10-19 09:00:00'),
(3, 2, 'Citra Maharani', 'citra@example.com', '081200000003', 'Karanganyar', '2026-10-20 09:00:00'),
(4, 1, 'Dinda Putri', 'dinda@example.com', '081200000004', 'Surakarta', '2026-10-21 09:00:00'),
(5, 2, 'Eko Saputra', 'eko@example.com', '081200000005', 'Sragen', '2026-10-22 09:00:00'),
(6, 1, 'Farhan Akbar', 'farhan@example.com', '081200000006', 'Sukoharjo', '2026-10-23 09:00:00'),
(7, 2, 'Gita Lestari', 'gita@example.com', '081200000007', 'Klaten', '2026-10-24 09:00:00'),
(8, 2, 'Hana Rahma', 'hana@example.com', '081200000008', 'Surakarta', '2026-10-25 09:00:00'),
(9, 3, 'Intan Puspita', 'intan@example.com', '081200000009', 'Kartasura', '2026-10-26 09:00:00'),
(10, 3, 'Joko Permana', 'joko@example.com', '081200000010', 'Sragen', '2026-10-27 09:00:00'),
(11, 1, 'Kiki Andriana', 'kiki@example.com', '081200000011', 'Boyolali', '2026-10-28 09:00:00'),
(12, 2, 'Lina Safitri', 'lina@example.com', '081200000012', 'Surakarta', '2026-10-29 09:00:00');
