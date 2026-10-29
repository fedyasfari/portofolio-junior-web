-- Skema dan data LATIHAN. Jalankan sekali pada phpMyAdmin > Import.
-- PERINGATAN: Bagian DROP menghapus tabel latihan jika sudah ada!
-- Database LAB 2 bernama db_pelatihan (berbeda dengan Lab 1).
CREATE DATABASE IF NOT EXISTS db_pelatihan
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_pelatihan;

DROP TABLE IF EXISTS pendaftar;
DROP TABLE IF EXISTS kelas;

CREATE TABLE kelas (
    id_kelas INT NOT NULL AUTO_INCREMENT,
    nama_kelas VARCHAR(100) NOT NULL,
    deskripsi VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id_kelas)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pendaftar (
    id_pendaftar INT NOT NULL AUTO_INCREMENT,
    id_kelas INT NOT NULL,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    tanggal_daftar DATE NOT NULL,
    PRIMARY KEY (id_pendaftar),
    CONSTRAINT uq_pendaftar_email UNIQUE (email),
    CONSTRAINT fk_pendaftar_kelas FOREIGN KEY (id_kelas)
        REFERENCES kelas(id_kelas)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO kelas (id_kelas, nama_kelas, deskripsi) VALUES
(1, 'Web Development', 'Belajar HTML, CSS, JavaScript, PHP'),
(2, 'Desain Grafis', 'Belajar desain visual'),
(3, 'Data Science', 'Belajar mengolah data');

INSERT INTO pendaftar (id_pendaftar, id_kelas, nama, email, no_hp, tanggal_daftar) VALUES
(1, 1, 'Andi Pratama', 'andi@example.com', '081200000001', '2026-10-18'),
(2, 1, 'Budi Santoso', 'budi@example.com', '081200000002', '2026-10-19'),
(3, 2, 'Citra Maharani', 'citra@example.com', '081200000003', '2026-10-20'),
(4, 1, 'Dinda Putri', 'dinda@example.com', '081200000004', '2026-10-21'),
(5, 2, 'Eko Saputra', 'eko@example.com', '081200000005', '2026-10-22'),
(6, 1, 'Farhan Akbar', 'farhan@example.com', '081200000006', '2026-10-23'),
(7, 2, 'Gita Lestari', 'gita@example.com', '081200000007', '2026-10-24'),
(8, 2, 'Hana Rahma', 'hana@example.com', '081200000008', '2026-10-25');
