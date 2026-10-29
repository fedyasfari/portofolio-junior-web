-- LAB 1: JAWABAN 10 SOAL SQL
-- Prasyarat: import skema.sql dan data-contoh.sql.
-- Untuk belajar, salin dan jalankan SATU SOAL setiap kali lewat tab SQL phpMyAdmin.
-- Soal 1-6 hanya membaca; soal 7-8 mengubah data; soal 9-10 sengaja memicu error.

USE db_pendaftaran_kursus;

-- SOAL 1: Tampilkan semua pendaftar, urutkan nama A-Z.
SELECT *
FROM pendaftar
ORDER BY nama ASC;

-- SOAL 2: Tampilkan 5 pendaftar terbaru menurut tanggal pendaftaran.
-- id_pendaftar DESC menjadi pemutus urutan jika tanggalnya sama.
SELECT *
FROM pendaftar
ORDER BY tanggal_daftar DESC, id_pendaftar DESC
LIMIT 5;

-- SOAL 3: Cari nama yang mengandung 'an' (kolasi _ci: tidak peka kapital).
SELECT *
FROM pendaftar
WHERE nama LIKE '%an%'
ORDER BY nama ASC;

-- SOAL 4: Nama pendaftar dan nama kelas (INNER JOIN).
SELECT p.nama AS nama_pendaftar, k.nama_kelas
FROM pendaftar AS p
INNER JOIN kelas AS k ON p.id_kelas = k.id_kelas
ORDER BY p.nama ASC;

-- SOAL 5: Hitung pendaftar per kelas termasuk kelas kosong (LEFT JOIN + GROUP BY).
SELECT k.id_kelas, k.nama_kelas,
       COUNT(p.id_pendaftar) AS jumlah_pendaftar
FROM kelas AS k
LEFT JOIN pendaftar AS p ON p.id_kelas = k.id_kelas
GROUP BY k.id_kelas, k.nama_kelas
ORDER BY k.id_kelas ASC;

-- SOAL 6: Cari kelas yang belum mempunyai pendaftar.
SELECT k.id_kelas, k.nama_kelas
FROM kelas AS k
LEFT JOIN pendaftar AS p ON p.id_kelas = k.id_kelas
WHERE p.id_pendaftar IS NULL
ORDER BY k.id_kelas ASC;

-- SOAL 7: Ubah nomor HP pendaftar id 1; WHERE mencegah semua baris berubah.
UPDATE pendaftar
SET no_hp = '081299990001'
WHERE id_pendaftar = 1;

-- Periksa hasil soal 7.
SELECT id_pendaftar, nama, no_hp
FROM pendaftar
WHERE id_pendaftar = 1;

-- SOAL 8: Hapus pendaftar id 8. Hanya satu baris yang dihapus.
DELETE FROM pendaftar
WHERE id_pendaftar = 8;

-- Periksa hasil soal 8: seharusnya tersisa 7 pendaftar.
SELECT COUNT(*) AS total_pendaftar
FROM pendaftar;

-- SOAL 9: Sengaja masukkan EMAIL yang sudah dipakai (andi@example.com).
-- Harus muncul MySQL error 1062 (Duplicate entry) berkat UNIQUE(email).
-- PERHATIAN: perintah sengaja dikomentari agar 'Import' file ini tidak terhenti.
-- Jalankan secara TERPISAH dengan menghapus awalan '--' dari 3 baris di bawah.
-- INSERT INTO pendaftar (id_kelas, nama, email, no_hp, tanggal_daftar)
-- VALUES (1, 'Contoh Duplikat', 'andi@example.com', '081299990009', '2026-10-29');

-- SOAL 10: Sengaja coba hapus kelas id 1 yang masih mempunyai pendaftar.
-- Harus muncul MySQL error 1451 (Cannot delete or update a parent row).
-- PERHATIAN: perintah sengaja dikomentari agar 'Import' file ini tidak terhenti.
-- Jalankan secara TERPISAH dengan menghapus awalan '--' dari baris di bawah.
-- DELETE FROM kelas WHERE id_kelas = 1;
