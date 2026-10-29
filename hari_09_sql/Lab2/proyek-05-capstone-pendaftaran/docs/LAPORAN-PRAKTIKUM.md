# LAPORAN PRAKTIKUM LAB 2

**Nama:** ___________________________
**Kelas:** ___________________________
**Tanggal:** _________________________

## 1. Tujuan Praktikum
Memahami koneksi PHP ke MySQL menggunakan PDO, pengelolaan data sederhana (CRUD), perlindungan kredensial melalui `.gitignore`, dan alasan penggunaan prepared statement dalam pencegahan SQL Injection.

## 2. Lingkungan Praktikum
- Sistem operasi: ____________________
- XAMPP versi: ______________________
- PHP versi: ________________________
- MySQL/MariaDB versi: ______________
- Browser: _________________________

## 3. Langkah Pelaksanaan
1. Menjalankan Apache dan MySQL pada XAMPP.
2. Memasang folder proyek dalam `htdocs`.
3. Mengimpor `database/skema.sql` ke phpMyAdmin.
4. Memeriksa `config/config.php` dan `config/database.php`.
5. Membuka aplikasi pada `public/index.php`.
6. Mencoba fitur tambah, ubah, dan hapus.
7. Melakukan pengujian SQL Injection di `public/injeksi.php` dengan input normal dan payload latihan.

## 4. Hasil Pengujian

| Pengujian | Hasil di komputer sendiri | Bukti screenshot |
|---|---|---|
| Koneksi database berhasil | __________________ | __________________ |
| Tampil data pendaftar | __________________ | __________________ |
| Tambah, ubah, hapus | __________________ | __________________ |
| Email normal, query rentan | __________________ | __________________ |
| Email normal, query aman | __________________ | __________________ |
| Injeksi, query rentan | __________________ | __________________ |
| Injeksi, query aman | __________________ | __________________ |
| config.php terabaikan Git | __________________ | __________________ |

## 5. Analisis SQL Injection
**Masukan yang diuji:** `x' OR '1'='1`

**Versi tidak aman:** Input ditambahkan langsung ke teks SQL. Tanda apostrof dan operator OR mengubah struktur klausa WHERE menjadi kondisi yang selalu benar, sehingga dapat menampilkan seluruh baris.

**Versi aman:** PDO menggunakan prepared statement dan parameter `:email`. Input diperlakukan sebagai satu nilai email literal, bukan ekspresi SQL. Oleh sebab itu tidak ada baris yang cocok untuk payload tersebut.

## 6. Kesimpulan
PDO membantu aplikasi mengakses database secara terstruktur. Prepared statement wajib digunakan untuk memasukkan data pengguna ke query karena memisahkan data dari sintaks SQL. Pemisahan konfigurasi dan penggunaan `.gitignore` membantu menjaga informasi koneksi tetap di komputer pengembang. Pengujian dilakukan hanya pada lingkungan lokal.

## 7. Lampiran Screenshot
Tempel screenshot asli dari komputer Anda di bagian ini sebelum mengumpulkan.
