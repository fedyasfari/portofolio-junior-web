-- OPSIONAL: Jalankan SETELAH skema Lab 3 dibuat.
-- Tambahkan 4 pendaftar untuk menguji >10 data (total awal 8 menjadi 12).
-- File ini diimpor satu kali, kecuali Anda reset skema.
USE db_pelatihan;
INSERT INTO pendaftar (kelas_id, nama, email, no_hp, alamat) VALUES
(1, 'Ilham Nugraha', 'ilham@example.com', '081200000009', 'Solo'),
(2, 'Jihan Aulia', 'jihan@example.com', '081200000010', 'Klaten'),
(3, 'Kevin Prakoso', 'kevin@example.com', '081200000011', 'Sragen'),
(3, 'Laila Safitri', 'laila@example.com', '081200000012', 'Kartasura');
