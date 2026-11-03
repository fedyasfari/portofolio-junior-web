-- Database BARU agar data Capstone Hari 9 Anda tidak tertimpa.
CREATE DATABASE IF NOT EXISTS db_pendaftaran_sprint1
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_pendaftaran_sprint1;
CREATE TABLE IF NOT EXISTS kelas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama_kelas VARCHAR(150) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE IF NOT EXISTS pendaftar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT NULL,
    kelas_id INT UNSIGNED NOT NULL,
    tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pendaftar_kelas FOREIGN KEY (kelas_id) REFERENCES kelas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT IGNORE INTO kelas (id,nama_kelas) VALUES
    (1,'Web Development Dasar'),(2,'Pemrograman PHP'),(3,'Desain UI/UX');
