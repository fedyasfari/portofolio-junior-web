# Laporan PBL Hari 9 — Capstone Sprint 0

**Nama:** [isi nama]  
**Kelas:** [isi kelas]  
**Tanggal:** [isi tanggal]  
**Lingkungan:** Windows / XAMPP / PHP [versi] / MySQL [versi]

## 1. Tujuan
Menyusun analisis, backlog, ERD, wireframe dan modul CRUD pendaftaran pelatihan dengan PHP+PDO yang aman pada lingkungan latihan.

## 2. Analisis kebutuhan
Ringkas aktor peserta/admin, fitur Sprint 0, fitur hari lanjut, dan batasan. Lampirkan: `01-ANALISIS-KEBUTUHAN.md`.

## 3. Backlog
Lampirkan `02-BACKLOG-USER-STORY.md` (14 user story) dan jelaskan urutan P0 → P1 → P2.

## 4. Desain database
Lampirkan screenshot ERD, skema.sql, serta tangkapan layar tiga tabel di phpMyAdmin. Jelaskan `kelas.id` → `pendaftar.kelas_id` dan tabel admin untuk Hari 11.

## 5. Wireframe
Lampirkan tiga SVG: form peserta, daftar admin simulasi, dan bukti PDF rencana Hari 10.

## 6. Implementasi modul CRUD
Jelaskan peran `src/bootstrap.php`, `src/helpers.php`, `src/pendaftar.php`, `public/index.php`, `tambah.php`, `ubah.php`, `hapus.php`, `daftar.php`, dan `_form.php`.

## 7. Rekap pengujian
| TC | Skenario | Ekspektasi | Hasil aktual | Status (Lulus/Gagal) | Bukti |
|---|---|---|---|---|---|
| 01 | Koneksi | Berhasil | [isi] | [isi] | [foto] |
| 02 | Impor skema | 3 kelas, 12 pendaftar, 0 admin | [isi] | [isi] | [foto] |
| 03 | Form peserta valid | Tersimpan | [isi] | [isi] | [foto] |
| 04 | Tambah admin | Baris baru | [isi] | [isi] | [foto] |
| 05 | Form kosong | Validasi | [isi] | [isi] | [foto] |
| 06 | Email ganda | Ditolak | [isi] | [isi] | [foto] |
| 07 | Kelas kosong | Ditolak | [isi] | [isi] | [foto] |
| 08 | HP tidak valid | Ditolak | [isi] | [isi] | [foto] |
| 09 | Ubah | Tepat satu berubah | [isi] | [isi] | [foto] |
| 10 | Hapus | Tepat satu hilang | [isi] | [isi] | [foto] |
| 11 | Cari | Hasil cocok | [isi] | [isi] | [foto] |
| 12 | Paginasi | 2 halaman | [isi] | [isi] | [foto] |
| 13 | ID tak valid | HTTP 404 | [isi] | [isi] | [foto] |
| 14 | Hapus tanpa token | HTTP 403 | [isi] | [isi] | [foto] |
| 15 | XSS | Tampil sebagai teks | [isi] | [isi] | [foto] |
| 16 | SQL Injection pencarian | Tidak membocorkan hasil | [isi] | [isi] | [foto] |
| 17 | PHP warning/notice | Tidak ada | [isi] | [isi] | [foto] |
| 18 | .gitignore | Config tidak terlacak | [isi] | [isi] | [foto] |

## 8. Git
Lampirkan hasil `git log --oneline -4`, `git check-ignore config/config.php`, dan `git ls-files config/config.php`.

## 9. Kendala dan solusi
Tuliskan kendala nyata saat praktik, misalnya port MySQL, kredensial, driver PDO, atau salah URL.

## 10. Kesimpulan
Simpulkan fitur yang **sudah diuji benar-benar berfungsi**, fitur yang **baru dirancang**, dan rencana berikutnya. Hindari mengklaim hasil pengujian yang belum dilakukan.
