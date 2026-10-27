# LAPORAN PRAKTIKUM LAB 4 — CODE REVIEW DAN REFACTOR

**Mata materi:** Struktur Data II, Algoritma, dan Clean Code  
**Bahasa:** JavaScript  
**Nama peserta:** (isi nama)  
**Tanggal:** (isi tanggal)

## 1. Tujuan

Mengidentifikasi pelanggaran clean code pada file `kode-buruk.js`, memperbaiki kode tersebut, dan menguji agar perilaku utama tetap benar.

## 2. Tabel temuan

| No | Pelanggaran | Prinsip | Perbaikan |
|---:|---|---|---|
| 1 | Nama `d`, `f`, `g`, `r`, `h`, `k` tidak bermakna | Penamaan | `daftarNilai`, `hitungRataRata`, `tentukanGrade`, dll. |
| 2 | Menggunakan `var` | Guideline modern | `const` untuk data tetap, `let` saat perlu perubahan |
| 3 | Penulisan terlalu rapat dan tidak terindentasi | Format | Rapikan spasi, baris, dan indentasi (bisa memakai Prettier) |
| 4 | Menggunakan `==` untuk membandingkan | Perbandingan aman | Gunakan `===` |
| 5 | Nilai 85, 70, 55, 0.11, 80 tersebar tanpa nama | Magic number | `BATAS_GRADE`, `PAJAK`, dan `NILAI_PUJIAN` |
| 6 | Fungsi `h()` dan `k()` memiliki isi yang sama | DRY | Satu fungsi `hitungHargaDenganPajak()` |
| 7 | `if/else` grade terlalu bersarang | KISS / guard clause | Beberapa `if` dengan `return` awal |
| 8 | Tidak memeriksa array kosong | Error handling | Hasil 0 untuk array kosong, validasi input lain |
| 9 | Titik koma tidak konsisten | Konsistensi | Selalu gunakan titik koma dan formatter |
| 10 | Tidak ada penjelasan fungsi | Dokumentasi | Tambahkan komentar JSDoc |

## 3. Inti perbaikan

- Semua rumus dikumpulkan di `kode-bersih.js` dan dapat diimpor dengan `import`.
- Fungsi diubah dari nama satu huruf menjadi nama yang mencerminkan tujuannya.
- Fungsi yang sama (`h` dan `k`) digabung menjadi satu untuk mencegah duplikasi.
- Percabangan grade ditulis dengan `return` awal agar lebih mudah dibaca.
- Rata-rata array kosong dikembalikan sebagai 0 sesuai spesifikasi soal.
- Input tidak valid ditangani dengan pesan yang jelas.
- Kode diuji otomatis melalui `npm test`.

## 4. Hasil pengujian

| Skenario | Input | Hasil yang diharapkan |
|---|---|---|
| Kode awal | `[80,65,90]` | Grade `B` |
| Rata-rata | `[80,65,90]` | `78.33` jika dibulatkan 2 desimal |
| Rata-rata kosong | `[]` | `0` |
| Rata-rata satu angka | `[90]` | `90` |
| Batas grade A | `85` | `A` |
| Batas grade B | `70` | `B` |
| Batas grade C | `55` | `C` |
| Grade D | `50` | `D` |
| Pajak | `100000` | `111000` |
| Harga negatif | `-1000` | Pesan kesalahan |

**Perintah pengujian:** `npm run asli`, `npm start`, dan `npm test`.

**Hasil aktual:** (salin hasil yang muncul pada komputer sendiri; contoh pengujian pengembang: 18 tes lulus, 0 gagal).

## 5. Analisis

Sebelum diperbaiki, nama fungsi dan variabel tidak menjelaskan maksudnya, logika grade terlalu bersarang, terdapat fungsi harga duplikat, dan array kosong menyebabkan rata-rata `NaN`. Sesudah diperbaiki, tugas masing-masing fungsi jelas, kondisi grade dapat dibaca secara berurutan, pajak hanya memiliki satu rumus, serta tersedia validasi untuk mencegah input bermasalah.

Program awal dan versi refactor sama-sama menghasilkan grade **B** untuk data asli. Refactor sengaja mengubah perlakuan terhadap array kosong menjadi 0 dan menolak input tidak valid untuk meningkatkan keandalan.

## 6. Kesimpulan

Refactoring membuat kode lebih mudah dibaca, dipelihara, dan diuji tanpa mengubah hasil utama perhitungan yang valid. Prinsip yang diterapkan meliputi meaningful naming, modern JavaScript, DRY, KISS, perbandingan ketat, konsistensi penulisan, penanganan kondisi kosong, dan dokumentasi JSDoc.
