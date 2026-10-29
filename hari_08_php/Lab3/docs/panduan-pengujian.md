# Panduan Pengujian Lab 3

Jalankan Apache di XAMPP lalu akses:
- Halaman utama: `http://localhost/hari-08/lab-03/index.php`
- Pengujian otomatis: `http://localhost/hari-08/lab-03/uji.php`

## Pengujian manual (wajib)

| No | Berat (kg) | Tinggi (cm) | Hasil yang diharapkan |
|---|---|---|---|
| 1 | (kosong) | (kosong) | Dua pesan galat; tidak ada hasil BMI |
| 2 | abc | xyz | Dua pesan galat; tidak ada hasil BMI |
| 3 | -70 | -175 | Dua pesan galat; tidak ada hasil BMI |
| 4 | 0 | 175 | Galat pada berat; tidak ada hasil BMI |
| 5 | 70 | 175 | `22.9 (Normal)` |
| 6 | 40 | 170 | `13.8 (Kurang)` |
| 7 | 80 | 170 | `27.7 (Lebih)` |
| 8 | 100 | 170 | `34.6 (Obesitas)` |
| 9 | `<script>alert(1)</script>` | 175 | Galat pada berat, skrip terlihat hanya sebagai teks pada nilai input; tidak ada popup |
| 10 | 70 | `<img src=x onerror=alert(1)>` | Galat pada tinggi; tidak ada gambar atau popup |

## Cara menguji HTML berbahaya

1. Ketik teks `<script>alert(1)</script>` di kolom berat.
2. Isi kolom tinggi dengan `175`.
3. Klik `Hitung BMI`.
4. Pastikan terdapat pesan galat dan teks tetap berada di kolom input sebagai teks biasa. Tidak boleh muncul popup JavaScript.
5. Ulangi dengan teks `<img src=x onerror=alert(1)>` di kolom tinggi.

**Mengapa menggunakan type=text?** HTML input type=number biasanya menolak huruf dan tag sebelum dikirim, sehingga tidak ideal untuk memperagakan validasi sisi server. Input HTML tetap diberi `inputmode=decimal` untuk kemudahan keyboard angka di ponsel.

## Pengujian otomatis

Buka `uji.php` dan pastikan laporan berisi **18/18 tes lulus**. Uji otomatis memeriksa rumus, batas kategori, validasi kosong/huruf/negatif/nol, angka valid, format desimal, pemangkasan spasi, dan keamanan escaping.

## Masalah umum

- `404 Not Found`: periksa penempatan folder `lab-03` di `htdocs/hari-08`.
- Hasil tetap kosong: pastikan menggunakan metode POST pada form dan menekan tombol `Hitung BMI`.
- PHP tampil sebagai kode: buka alamat `http://localhost/...`, bukan membuka file langsung dari Explorer.
- Perintah `match` tidak dikenali: gunakan PHP versi 8.0 atau lebih baru.
- Koma desimal (`62,5`) tidak diterima: masukkan `62.5` sesuai petunjuk form.
