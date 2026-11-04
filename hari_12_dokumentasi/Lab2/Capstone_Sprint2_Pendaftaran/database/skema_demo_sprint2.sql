-- KHUSUS DEMO BARU, tidak menghapus tabel lama.
-- Jalankan hanya jika ingin membuat lingkungan latihan terpisah.
CREATE DATABASE IF NOT EXISTS db_capstone_sprint2_demo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_capstone_sprint2_demo;
CREATE TABLE IF NOT EXISTS kelas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(150) NOT NULL UNIQUE,
    kuota INT UNSIGNED NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS pendaftar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT NULL,
    kelas_id INT UNSIGNED NOT NULL,
    tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_pendaftar_kelas (kelas_id),
    CONSTRAINT fk_pendaftar_kelas FOREIGN KEY (kelas_id) REFERENCES kelas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT IGNORE INTO kelas (id,nama_kelas,kuota) VALUES
 (1,'Web Development Dasar',3),(2,'Pemrograman PHP',5),(3,'Desain UI/UX',2);
