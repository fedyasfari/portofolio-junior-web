-- LAB 3: INISIALISASI BARU / RESET DATA CONTOH.
-- PERINGATAN: DROP TABLE akan MENGHAPUS data dalam database db_pelatihan.
-- Jika sudah menyelesaikan LAB 2 dan ingin mempertahankan data,
-- JANGAN jalankan file ini: pilih database/migrasi-dari-lab2.sql.
CREATE DATABASE IF NOT EXISTS db_pelatihan
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_pelatihan;

DROP TABLE IF EXISTS pendaftar;
DROP TABLE IF EXISTS kelas;

CREATE TABLE kelas (
    id INT NOT NULL AUTO_INCREMENT,
    nama_kelas VARCHAR(100) NOT NULL,
    deskripsi VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pendaftar (
    id INT NOT NULL AUTO_INCREMENT,
    kelas_id INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    alamat TEXT DEFAULT NULL,
    tanggal_daftar DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    CONSTRAINT uq_pendaftar_email UNIQUE (email),
    CONSTRAINT fk_pendaftar_kelas FOREIGN KEY (kelas_id)
        REFERENCES kelas(id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO kelas (id, nama_kelas, deskripsi) VALUES
(1, 'Web Development', 'HTML, CSS, JavaScript, PHP'),
(2, 'Desain Grafis', 'Desain visual dan konten digital'),
(3, 'Data Science', 'Pengolahan data');

INSERT INTO pendaftar (id, kelas_id, nama, email, no_hp, alamat, tanggal_daftar) VALUES
(1, 1, 'Andi Pratama', 'andi@example.com', '081200000001', 'Surakarta', '2026-10-18 09:00:00'),
(2, 1, 'Budi Santoso', 'budi@example.com', '081200000002', 'Sukoharjo', '2026-10-19 09:00:00'),
(3, 2, 'Citra Maharani', 'citra@example.com', '081200000003', 'Karanganyar', '2026-10-20 09:00:00'),
(4, 1, 'Dinda Putri', 'dinda@example.com', '081200000004', 'Surakarta', '2026-10-21 09:00:00'),
(5, 2, 'Eko Saputra', 'eko@example.com', '081200000005', 'Sragen', '2026-10-22 09:00:00'),
(6, 1, 'Farhan Akbar', 'farhan@example.com', '081200000006', 'Sukoharjo', '2026-10-23 09:00:00'),
(7, 2, 'Gita Lestari', 'gita@example.com', '081200000007', 'Klaten', '2026-10-24 09:00:00'),
(8, 2, 'Hana Rahma', 'hana@example.com', '081200000008', 'Surakarta', '2026-10-25 09:00:00');
