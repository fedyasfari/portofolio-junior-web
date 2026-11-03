# Laporan Bug — Lab 2 Debugging PHP

**Berkas awal:** `bug-nilai.php`  
**Spesifikasi:** tampilkan rata-rata nilai siswa dan jumlah siswa yang lulus (minimal 70).

| ID | Jenis | Lokasi | Gejala | Penyebab | Perbaikan |
|---|---|---|---|---|---|
| B-01 | Syntax | `hitungLulus()` pada `return $lulus` | `Parse error`, `unexpected token "}"`, PHP mengharapkan `;` | Titik koma setelah `return` tidak ada | `return $lulus;` |
| B-02 | Kualitas data / potensi runtime | Data Budi dan penjumlahan dalam `hitungRataRata()` | `'68'` bertipe string, tetapi **pada PHP 8 string numerik ini tidak menyebabkan TypeError pada operator `+`**. Catatan soal yang menyatakan TypeError tidak sesuai perilaku PHP 8 | Tipe input tidak konsisten | Ubah `'68'` menjadi `68`; validasi input jika sumber datanya eksternal |
| B-03 | Logic | `hitungRataRata()` | Rata-rata keliru `103,333...` sebelum perbaikan | Membagi dengan `count($daftar) - 1` = 3, bukan 4 | Bagi dengan `count($daftar)`, dan tangani array kosong |
| B-04 | Logic | `hitungLulus()` | Dewi dengan nilai tepat 70 tidak dinyatakan lulus; hasil lama 2 siswa | Syarat memakai `> 70` | Ganti dengan `>= 70`; hasil 3 siswa |
| B-05 | Warning | `$nilai['Eko']` | `Warning: Undefined array key "Eko"` | Kunci `Eko` tidak ada | Gunakan `$nilai['Eko'] ?? 'Data tidak ditemukan'` atau cek `isset()` |
| B-06 | Warning HTTP | `header('X-Debug: selesai')` | Di server web, dapat muncul `Cannot modify header information - headers already sent` | `header()` dipanggil setelah `echo` yang sudah mengirim body | Pindahkan `header()` ke sebelum output; warning mungkin tidak muncul bila output buffering aktif atau menggunakan CLI |

## Catatan reproduksi

1. `php -l bug-nilai.php` -> gagal karena B-01.
2. `php -l tahap-01-sintaks.php` -> tidak ada kesalahan sintaks.
3. `php tahap-01-sintaks.php` -> menunjukkan rata-rata `103.33333333333`, lulus `2`, dan warning untuk Eko. Dalam pengujian PHP CLI 8.4, kedua warning (Eko dan header setelah output) juga muncul; perilakunya dapat berbeda bila output buffering aktif.
4. Jalankan `tahap-01-sintaks.php` lewat server HTTP dengan buffering nonaktif untuk mengamati kemungkinan warning B-06.
5. `php solusi-nilai.php` -> jawaban logis rata-rata `77,5`, lulus `3`, dan Eko tidak ditemukan.
6. `php uji-nilai.php` -> enam pengujian lulus.
7. `php demo-tipe-data.php` -> string numerik `'68'` aman untuk penjumlahan, string nonnumerik memicu TypeError pada PHP 8.

## Hasil akhir

- Total nilai = `90 + 68 + 82 + 70 = 310`.
- Jumlah siswa = `4`.
- Rata-rata = `310 / 4 = 77,5`.
- Jumlah lulus untuk nilai >= 70 = `3` siswa: Sari, Citra, Dewi.
- Nilai Eko = `Data tidak ditemukan`.

**Kesimpulan:** B-01, B-03, B-04, B-05, dan B-06 sesuai jenis masalah yang ditulis soal (dengan catatan warning B-06 bergantung lingkungan); B-02 perlu klarifikasi fakta perilaku PHP 8.
