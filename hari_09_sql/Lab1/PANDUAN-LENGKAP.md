# Panduan Praktikum Lab 1 – Database dan SQL

## Tujuan

Memahami database dan tabel, membuat relasi antartabel, memasukkan data, menggunakan SELECT/WHERE/ORDER BY/LIMIT/JOIN/GROUP BY/LEFT JOIN, memperbarui serta menghapus data, dan menguji UNIQUE dan FOREIGN KEY.

**Penting:** Foto tugas menyebut "DDL pada T2", tetapi materi T2 tidak diberikan. Proyek ini memakai skema contoh yang lengkap, sehingga bisa langsung dipraktikkan. Jika pengajar sudah menentukan nama kolom di T2, sesuaikan skema dan query dengan ketentuan pengajar.

## A. Mengenal istilah sederhana

- **Database**: wadah yang berisi tabel-tabel.
- **Tabel**: kumpulan data; contoh `kelas` dan `pendaftar`.
- **Baris / record**: satu data lengkap, misalnya pendaftar Andi.
- **Kolom / field**: atribut data, misalnya `nama`, `email`, `no_hp`.
- **Primary Key**: penanda unik tiap baris, misalnya `id_pendaftar`.
- **Foreign Key**: kolom yang menghubungkan tabel, misalnya `pendaftar.id_kelas` ke `kelas.id_kelas`.
- **DDL**: perintah pembentuk struktur, contoh `CREATE DATABASE`, `CREATE TABLE`.
- **DML**: perintah penambahan/perubahan/penghapusan data, contoh `INSERT`, `UPDATE`, `DELETE`.
- **SQL**: bahasa untuk mengelola dan menanyakan database.
- **phpMyAdmin**: antarmuka web untuk menjalankan SQL pada MySQL/MariaDB.

Relasi: `kelas (1)` -> `(banyak) pendaftar`. Satu kelas bisa memiliki banyak pendaftar; setiap pendaftar di proyek contoh ini memilih satu kelas.

## B. Menyiapkan aplikasi

1. Instal dan jalankan **XAMPP**, jika belum tersedia.
2. Buka **XAMPP Control Panel**; klik **Start** di baris **Apache** dan **MySQL**.
3. Pastikan kedua baris berstatus berjalan/hijau.
4. Buka browser dan kunjungi `http://localhost/phpmyadmin/`.
5. Jika phpMyAdmin tidak tampil, periksa apakah Apache/MySQL benar-benar berjalan dan apakah port layanan tidak bentrok.

> Catatan: Pada beberapa versi XAMPP, layanan yang berlabel **MySQL** menggunakan MariaDB. Query dalam panduan ini kompatibel dengan MySQL/MariaDB untuk latihan dasar.

## C. Membuat database dan mengimpor skema

1. Di halaman utama phpMyAdmin (klik ikon rumah atau **Server** di navigasi), pilih tab **Import**.
2. Klik **Choose File**/**Pilih File** dan pilih `database/skema.sql`.
3. Pastikan format **SQL**, lalu klik **Import**/**Go**/**Kirim**.
4. Jika berhasil, di panel kiri akan ada database `db_pendaftaran_kursus` dengan dua tabel: `kelas` dan `pendaftar`.
5. Klik nama database, lalu klik **Structure/Struktur** untuk memeriksa nama tabel.

**Alternatif:** Buka tab **SQL**, tempel seluruh isi `database/skema.sql`, lalu klik **Go/Kirim**.

Jangan bingung: `CREATE TABLE` membuat struktur, belum mengisi baris data. Untuk melihat data, lanjut ke langkah D.

## D. Mengisi 3 kelas dan 8 pendaftar

1. Pilih database `db_pendaftaran_kursus` pada panel kiri.
2. Buka tab **Import**.
3. Pilih `database/data-contoh.sql`, kemudian **Go/Kirim**.
4. Klik tabel `kelas` lalu tab **Browse/Jelajahi**. Seharusnya terlihat **3 baris**.
5. Klik tabel `pendaftar` lalu **Browse/Jelajahi**. Seharusnya terlihat **8 baris**.

Ringkasan data: kelas 1 = Web Development (4 pendaftar); kelas 2 = Desain Grafis (4 pendaftar); kelas 3 = Data Science (0 pendaftar). Kelas ketiga sengaja kosong untuk menguji soal 6. Beberapa nama mengandung **an**, seperti Andi, Santoso, Maharani, Farhan dan Hana.

**Jangan impor data-contoh.sql dua kali**: ID/email yang sama akan memicu kesalahan duplikat. Jika data sudah terlanjur dimodifikasi, lihat bagian H tentang mengulang praktikum.

## E. Mengerjakan 10 soal

Pilih database `db_pendaftaran_kursus`, buka tab **SQL**, lalu salin/jalankan query berikut **satu demi satu**.

### 1. Semua pendaftar dari A sampai Z

```sql
SELECT * FROM pendaftar ORDER BY nama ASC;
```

`SELECT *` = semua kolom; `ORDER BY nama ASC` = mengurutkan berdasarkan nama naik (A–Z). Hasil sebelum ada perubahan: Andi, Budi, Citra, Dinda, Eko, Farhan, Gita, Hana.

### 2. Lima pendaftar terbaru

```sql
SELECT *
FROM pendaftar
ORDER BY tanggal_daftar DESC, id_pendaftar DESC
LIMIT 5;
```

`DESC` = urut turun/terbaru lebih dahulu; `LIMIT 5` = ambil lima. Kolom ID membantu mengurutkan jika dua pendaftar mempunyai tanggal yang sama. Sebelum data dihapus: Hana, Gita, Farhan, Eko, Dinda.

### 3. Nama mengandung "an"

```sql
SELECT * FROM pendaftar
WHERE nama LIKE '%an%'
ORDER BY nama ASC;
```

`WHERE` menyaring baris; `LIKE` mencocokkan pola; `%` berarti karakter apa pun, termasuk kosong. Dengan kolasi contoh yang tidak peka huruf kapital, hasil awal: Andi Pratama, Budi Santoso, Citra Maharani, Farhan Akbar, Hana Rahma.

### 4. Nama pendaftar beserta nama kelas (JOIN)

```sql
SELECT p.nama AS nama_pendaftar, k.nama_kelas
FROM pendaftar AS p
INNER JOIN kelas AS k ON p.id_kelas = k.id_kelas
ORDER BY p.nama ASC;
```

`p` singkatan tabel pendaftar dan `k` singkatan tabel kelas; `ON` menentukan kolom penghubung. Tampil 8 baris sebelum penghapusan.

### 5. Jumlah pendaftar per kelas (GROUP BY)

```sql
SELECT k.id_kelas, k.nama_kelas,
       COUNT(p.id_pendaftar) AS jumlah_pendaftar
FROM kelas AS k
LEFT JOIN pendaftar AS p ON p.id_kelas = k.id_kelas
GROUP BY k.id_kelas, k.nama_kelas
ORDER BY k.id_kelas ASC;
```

`COUNT(p.id_pendaftar)` menghitung pendaftar yang benar-benar ada; `LEFT JOIN` memastikan kelas dengan nol pendaftar tetap muncul. Hasil awal: Web Development = 4, Desain Grafis = 4, Data Science = 0.

### 6. Kelas tanpa pendaftar

```sql
SELECT k.id_kelas, k.nama_kelas
FROM kelas AS k
LEFT JOIN pendaftar AS p ON p.id_kelas = k.id_kelas
WHERE p.id_pendaftar IS NULL;
```

Untuk kelas yang tidak memiliki pasangan pendaftar, kolom `p.id_pendaftar` bernilai `NULL`. Hasil: **Data Science**.

### 7. Mengubah nomor HP satu pendaftar

```sql
UPDATE pendaftar
SET no_hp = '081299990001'
WHERE id_pendaftar = 1;

SELECT id_pendaftar, nama, no_hp
FROM pendaftar
WHERE id_pendaftar = 1;
```

Hanya nomor Andi (ID 1) berubah. **Jangan hilangkan WHERE**, karena dapat mengubah nomor semua pendaftar.

### 8. Menghapus satu pendaftar

```sql
DELETE FROM pendaftar
WHERE id_pendaftar = 8;

SELECT COUNT(*) AS total_pendaftar
FROM pendaftar;
```

Hana (ID 8) terhapus. Jumlah pendaftar berubah dari 8 menjadi **7**. **Jangan hilangkan WHERE**, karena bisa menghapus semua data pendaftar.

### 9. Menguji email ganda (error 1062)

Jalankan secara terpisah, jangan langsung bersama soal 10:

```sql
INSERT INTO pendaftar (id_kelas, nama, email, no_hp, tanggal_daftar)
VALUES (1, 'Contoh Duplikat', 'andi@example.com', '081299990009', '2026-10-29');
```

Email `andi@example.com` sudah dipakai Andi. Karena kolom `email` memiliki batasan `UNIQUE`, database akan menolak data baru dan menampilkan error **1062 – Duplicate entry**. **Ini hasil yang diharapkan, bukan kesalahan pengerjaan.**

### 10. Menguji penghapusan kelas yang dipakai (error 1451)

```sql
DELETE FROM kelas WHERE id_kelas = 1;
```

Kelas ID 1 masih dipakai Andi, Budi, Dinda, dan Farhan. Relasi foreign key `ON DELETE RESTRICT` menolak penghapusan kelas. Database menampilkan error **1451 – Cannot delete or update a parent row**. **Ini juga hasil yang diharapkan**. Kelas ID 1 tetap ada.

Untuk menghindari dua error terencana itu menghentikan impor, query nomor 9 dan 10 disimpan sebagai komentar (`--`) dalam `database/latihan.sql`. Buka file untuk membaca semua jawaban; jika ingin pengujian error, salin SQL pada bagian di atas dan jalankan secara terpisah.

## F. Cara menyimpan bukti/screenshots

Ambil screenshot ketika: (1) XAMPP Apache + MySQL berjalan; (2) database dan dua tabel; (3) tabel kelas berisi 3 baris; (4) tabel pendaftar berisi 8 baris; (5) hasil query 1–6; (6) hasil perubahan nomor HP; (7) total pendaftar menjadi 7; (8) error 1062; (9) error 1451. Masukkan screenshot ke laporan sesuai format dari pengajar.

## G. Struktur folder untuk dikumpulkan

```text
Lab1-Database-SQL/
  database/
    skema.sql
    data-contoh.sql
    latihan.sql
  PANDUAN-LENGKAP.md
```

`skema.sql` menyimpan DDL. `data-contoh.sql` menyimpan INSERT untuk persiapan latihan. `latihan.sql` menyimpan jawaban query soal 1–10, termasuk komentar untuk dua pengujian error.

## H. Jika ingin mengulangi dari awal

**HANYA lakukan ini pada database latihan yang dibuat dalam panduan, bukan database lain:**

```sql
DROP DATABASE IF EXISTS db_pendaftaran_kursus;
```

Sesudah itu, impor ulang `skema.sql`, lalu `data-contoh.sql`. Perintah `DROP DATABASE` **menghapus semua isi database tersebut**, jadi jangan digunakan apabila ada data penting.

## I. Troubleshooting

- `#1049 Unknown database`: file skema belum diimpor atau database yang dipilih salah.
- `#1146 Table doesn't exist`: tabel belum terbentuk atau ada kesalahan nama.
- `#1062 Duplicate entry` saat mengimpor data contoh: kemungkinan skrip data sudah pernah diimpor. Pada soal 9, error ini justru hasil yang diminta.
- `#1452 Cannot add or update a child row`: nilai `id_kelas` pendaftar tidak tersedia di tabel `kelas`. Isi tabel kelas lebih dahulu.
- `#1451 Cannot delete or update a parent row`: kelas masih dirujuk oleh pendaftar. Pada soal 10, error ini hasil yang diminta.
- `#1064 SQL syntax`: periksa koma, tanda kutip, titik koma `;`, nama kolom, dan huruf yang tertukar.
- Tabel hanya memiliki 7 pendaftar: soal 8 sudah dijalankan; jika membutuhkan kondisi awal lagi, ikuti bagian H.

Semoga latihan berjalan lancar! Fokus pada perbedaan antara perintah yang *melihat* data (SELECT), *mengubah* (UPDATE), *menghapus* (DELETE), dan *mengatur aturan* (CREATE TABLE, UNIQUE, FOREIGN KEY).
