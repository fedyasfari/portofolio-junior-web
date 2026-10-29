# Lab 3 – Form POST dan Validasi: Kalkulator BMI

Proyek PHP dasar untuk latihan `POST`, `filter_var()`, `trim()`, `match`, dan `htmlspecialchars()`.

## Kebutuhan
- XAMPP dengan Apache dan PHP 8.0+
- Browser modern, misalnya Chrome atau Edge
- VS Code (opsional)

## Menjalankan
1. Ekstrak folder `lab-03` ke `C:\xampp\htdocs\hari-08\lab-03\`.
2. Jalankan Apache di XAMPP.
3. Buka `http://localhost/hari-08/lab-03/index.php`.
4. Untuk pengujian, buka `http://localhost/hari-08/lab-03/uji.php`.

## Berkas
- `index.php`: menerima `$_POST`, memanggil validasi, menampilkan halaman HTML.
- `fungsi.php`: fungsi `hitungBmi`, `kategoriBmi`, `e`, `ambilIsian`, `prosesFormBmi`.
- `style.css`: tampilan responsif tanpa framework.
- `uji.php`: pengujian otomatis untuk 18 skenario.
- `docs/panduan-pengujian.md`: langkah dan expected output.

## Rumus

`BMI = berat(kg) / (tinggi(cm) / 100)^2`

Batas kategori **untuk latihan**:
- `< 18.5`: Kurang
- `18.5 <= BMI < 25`: Normal
- `25 <= BMI < 30`: Lebih
- `>= 30`: Obesitas

Contoh: berat 70 kg, tinggi 175 cm, BMI = 22.9 (Normal).

## Catatan keamanan
- Form menggunakan `method="post"`.
- Validasi harus dilakukan di PHP; jangan hanya mengandalkan input browser.
- `e()` membungkus `htmlspecialchars(..., ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')`.
- Input `type="text"` sengaja dipakai dengan `inputmode="decimal"` agar latihan menguji teks/huruf/HTML berbahaya dapat dijalankan melalui form.
- Input angka desimal menggunakan titik (`62.5`).
- Tidak ada data yang disimpan ke database atau dikirim ke layanan eksternal.

## Pengumpulan
Salin folder `lab-03` ke repositori `hari-08-php`. Ambil screenshot dari halaman utama (input valid dan tidak valid), dan dari `uji.php` (semua tes lulus). Jangan klaim hasil tes yang belum Anda jalankan sendiri.

> Catatan: BMI adalah indikator sederhana untuk tugas pemrograman, bukan diagnosis medis.
