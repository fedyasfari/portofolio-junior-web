# Laporan Praktikum Lab 5 — ESLint dan Prettier

**Nama:** ................  **Tanggal:** ................

## Tujuan

Menjalankan ESLint untuk menemukan kesalahan/ketidakkonsistenan kode, menggunakan Prettier untuk merapikan gaya penulisan, dan mencatat error/warning sebelum serta sesudah.

## 1. Persiapan

`npm init -y` (bila mulai dari folder kosong), `npm install --save-dev eslint @eslint/js prettier`, menambahkan `"type": "module"`, membuat `eslint.config.js` dan `.prettierrc` sesuai soal.

## 2. Pemeriksaan sebelum perbaikan

Program awal Lab 4: `referensi-sebelum/kode-buruk.js.txt` (salinan kode awal asli). Untuk Proyek 2, snapshot sebelum yang disertakan hanya ilustrasi, karena kode Proyek 2 asli belum tersedia.

| Target | Sebelum error | Sebelum warning | Sesudah error | Sesudah warning |
|---|---:|---:|---:|---:|
| Lab 4 (snapshot kode buruk asli) | Jalankan `npm run laporan:lint` | ... | ... | ... |
| Proyek 2 (snapshot simulasi, bukan asli) | Jalankan `npm run laporan:lint` | ... | ... | ... |
| Proyek 2 *asli pengguna* | Belum diukur | Belum diukur | Belum diukur | Belum diukur |

**Isi dari output nyata** `HASIL-LINT.md` setelah `npm install` dan `npm run laporan:lint`.

## 3. Perbaikan dilakukan

1. Mengganti deklarasi `var` dengan `const` atau `let`.
2. Mengganti operator `==` menjadi `===` dan `!=` menjadi `!==` jika tidak memerlukan konversi tipe.
3. Menghapus variabel/fungsi yang tidak dipakai.
4. Menambahkan nama variabel yang jelas serta validasi input.
5. Menjalankan `npx prettier --write .` untuk format yang konsisten.
6. Memeriksa ulang dengan `npx eslint .`, `npx prettier --check .`, dan `npm test`.

## 4. Pembahasan

ESLint bertugas menemukan masalah kualitas kode, seperti penggunaan `var`, `==`, dan variabel yang tidak digunakan. Prettier memformat kode sehingga indentasi, petik tunggal, dan titik koma konsisten. Prettier tidak menggantikan ESLint dan tidak otomatis memperbaiki kesalahan logika.

`no-var` serta `eqeqeq` disetel pada level **error**, sedangkan `prefer-const` dan `no-unused-vars` disetel pada level **warning**. ESLint menganggap warning berbeda dari error; maka tabel sebaiknya menyebutkan keduanya secara terpisah.

## 5. Kesimpulan

Kode telah disusun ulang menjadi versi yang lebih terstruktur. Hasil akhir yang harus diverifikasi pada perangkat peserta adalah **0 error dan 0 warning** untuk berkas bersih. Jumlah temuan nyata dan screenshot terminal dilampirkan setelah program berjalan.
