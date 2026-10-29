-- LAB 1: DATA CONTOH
-- Langkah 2: isi data. Jalankan SETELAH skema.sql.
-- Jangan import berulang kali: id/email yang sama akan menimbulkan error duplikat.

USE db_pendaftaran_kursus;

-- Ada 3 kelas; kelas ke-3 sengaja belum memiliki pendaftar untuk soal 6.
INSERT INTO kelas (id_kelas, nama_kelas, deskripsi) VALUES
(1, 'Web Development', 'Belajar membangun website'),
(2, 'Desain Grafis', 'Belajar desain visual'),
(3, 'Data Science', 'Belajar analisis data');

-- Ada 8 pendaftar. Beberapa nama mengandung 'an' untuk soal 3.
INSERT INTO pendaftar
  (id_pendaftar, id_kelas, nama, email, no_hp, tanggal_daftar)
VALUES
(1, 1, 'Andi Pratama',   'andi@example.com',   '081234567801', '2026-10-18'),
(2, 1, 'Budi Santoso',   'budi@example.com',   '081234567802', '2026-10-19'),
(3, 2, 'Citra Maharani', 'citra@example.com',  '081234567803', '2026-10-20'),
(4, 1, 'Dinda Putri',    'dinda@example.com',  '081234567804', '2026-10-21'),
(5, 2, 'Eko Saputra',    'eko@example.com',    '081234567805', '2026-10-22'),
(6, 1, 'Farhan Akbar',   'farhan@example.com', '081234567806', '2026-10-23'),
(7, 2, 'Gita Lestari',   'gita@example.com',   '081234567807', '2026-10-24'),
(8, 2, 'Hana Rahma',     'hana@example.com',   '081234567808', '2026-10-25');
