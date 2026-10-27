# Lab 4 — Code Review dan Refactor (Hari 07)

Proyek latihan untuk pemula: mengubah kode JavaScript yang sulit dibaca menjadi kode yang rapi, menguji hasilnya, dan mendokumentasikan **10 temuan code review**.

## Isi folder

- `kode-buruk.js`: salinan kode soal yang belum dibersihkan.
- `kode-bersih.js`: fungsi hasil refactor, konstanta, validasi, dan JSDoc.
- `program.js`: menjalankan contoh kode bersih menggunakan Node.js.
- `test.js`: 18 tes otomatis (Node built-in, tidak memerlukan instalasi library).
- `index.html`, `style.css`, `browser.js`: halaman latihan interaktif.
- `tabel-review.csv`: 10 temuan dalam format tabel untuk laporan.
- `LAPORAN.md`: contoh isi laporan praktikum.

## A. Menjalankan di VS Code (Node.js)

1. Ekstrak ZIP lalu buka folder ini: **File > Open Folder**.
2. Buka **Terminal > New Terminal**.
3. Pastikan Node.js tersedia dengan perintah `node -v`.
4. Jalankan satu per satu:

   ```bash
   npm run asli
   npm start
   npm test
   ```

   Tidak perlu menjalankan `npm install` karena tidak menggunakan dependensi eksternal.

## B. Menjalankan di browser

1. Instal ekstensi **Live Server** di VS Code.
2. Klik kanan `index.html`, pilih **Open with Live Server**.
3. Coba `80, 65, 90` dan harga `100000`, kemudian klik **Hitung**.
4. Coba nilai kosong, nilai nonangka (`80, halo`), dan harga negatif. Perhatikan pesan validasi.

Alternatif: menggunakan XAMPP/Laragon, pindahkan folder ini ke `htdocs`/`www`, lalu akses melalui alamat `http://localhost/hari-07-lab4-code-review-refactor/` (sesuaikan nama folder).

**Jangan buka `index.html` dengan URL `file://`** jika browser memblokir impor modul JavaScript. Gunakan Live Server atau server lokal.

## C. Apa yang harus dilaporkan?

1. Tabel 10 pelanggaran, prinsip, dan perbaikannya.
2. Cuplikan `kode-bersih.js` sebagai hasil refactor.
3. Hasil `npm run asli`, `npm start`, dan `npm test`.
4. Penjelasan perubahan dan kesimpulan singkat.

## D. Hasil yang diharapkan

Data asli `[80,65,90]` memiliki rata-rata `235 / 3 = 78.333333...` sehingga grade **B**. Harga contoh `100000` dengan pajak 11% menghasilkan `111000`.

Kondisi asli `if (r == 80)` tidak menampilkan kata `bagus` pada data ini. Kode bersih mempertahankan kondisi tersebut dengan `===`, karena keduanya adalah angka.

**Peringatan:** perubahan fungsi untuk array kosong dari `NaN` menjadi `0` adalah peningkatan keamanan input sesuai instruksi tugas, bukan kesamaan output sepenuhnya pada kasus khusus tersebut. Penambahan validasi angka juga disengaja.

## E. Catatan Clean Code

- **Penamaan jelas** mempercepat pembacaan program.
- **DRY** mengurangi duplikasi fungsi h dan k.
- **KISS/guard clause** menyederhanakan fungsi grade.
- **JSDoc** membantu menjelaskan parameter, output, dan kesalahan.
- **Pengujian** membantu memastikan refactor tidak mengubah perilaku utama.
