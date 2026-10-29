# Panduan pengujian mandiri - Lab 1 PHP Dasar

| Yang diperiksa | Tindakan | Hasil yang diharapkan |
|---|---|---|
| Variabel | Buka bagian 1 | Nama Andi, umur 20, status Aktif |
| `var_dump` | Baca 3 blok hasil | `string(4) "Andi"`, `int(20)`, `bool(true)` |
| Tabel perkalian | Cari perpotongan baris 7 dan kolom 8 | 56 |
| Tabel perkalian | Cari perpotongan baris 10 dan kolom 10 | 100 |
| Ganjil genap | Periksa angka 1, 2, 19, dan 20 | Ganjil, Genap, Ganjil, Genap |
| FizzBuzz | Periksa 3, 5, 15, 30, dan 29 | Fizz, Buzz, FizzBuzz, FizzBuzz, 29 |
| Grade | Ubah `$nilai` menjadi 95, 85, 75, 65, 55 lalu refresh tiap perubahan | A, B, C, D, E |
| Kalender | Buka bagian terakhir | Nama hari Indonesia dan tanggal sesuai waktu Asia/Jakarta |

## Catatan untuk laporan

Sertakan tangkapan layar bagian variabel, tabel perkalian, ganjil/genap, FizzBuzz, grade, dan kalender dari browser. Tangkapan layar harus dibuat di komputer sendiri setelah berkas dijalankan; jangan mengaku telah menguji di XAMPP bila belum.

## Jika program tidak tampil

1. Periksa apakah Apache di XAMPP sudah berstatus **Running**.
2. Periksa apakah URL benar: `http://localhost/hari-08/dasar.php`.
3. Periksa apakah berkas benar-benar bernama `dasar.php` (bukan `dasar.php.txt`).
4. Periksa versi PHP: `php -v` bila perintah PHP tersedia di terminal.
5. Untuk pesan kesalahan pada `match`, pastikan PHP versi 8.0 ke atas.
6. Jika kode PHP malah ditampilkan sebagai teks, kemungkinan berkas dibuka via `file://` alih-alih melalui server PHP.
