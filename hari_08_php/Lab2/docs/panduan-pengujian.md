# Panduan Pengujian Lab 2

## 1. Cek halaman
- Jalankan Apache di XAMPP.
- Akses http://localhost/hari-08/lab-02/index.php
- Pastikan data: Sari 90 A; Budi 68 D; Citra 82 B.
- Rata-rata 80,00; tertinggi Sari 90; lulus 2.
- Filter lulus: Sari dan Citra.
- Urutan nilai: Sari, Citra, Budi.
- Kelas Web: Sari dan Budi; Data: Citra.

## 2. Cek otomatis
Buka http://localhost/hari-08/lab-02/uji.php
Semua 15 pengujian diharapkan LULUS.

## 3. Coba perubahan data
Ubah angka Sari pada `data.php` menjadi 95, simpan, lalu refresh. Data/grade/tabel akan ikut berubah sesuai perubahan tersebut.

## 4. Coba batas kelulusan
Di `index.php` ubah `$lulus = filterLulus($peserta);` menjadi `$lulus = filterLulus($peserta, 85);`, lalu refresh. Hanya Sari yang lulus pada data awal.

## 5. Coba kasus data kosong
Sementara ubah isi `data.php` menjadi `return [];`. Halaman tetap bisa dibuka: rata-rata 0,00, nilai tertinggi '-', tabel menampilkan pesan tidak ada data.
Kembalikan isi data semula setelah selesai.

## 6. Uji escaping data HTML
Ubah sementara nama salah satu peserta menjadi `<script>alert('tes')</script>`. Halaman seharusnya menampilkannya sebagai teks, bukan menjalankan kode JavaScript. Kembalikan data awal setelah diuji.

## 7. Bukti untuk dikumpulkan
Simpan screenshot `index.php` (ringkasan, tabel peserta, filter, urutan, dan kelompok) serta `uji.php` (15/15 lulus) ke folder dokumentasi repositori.
