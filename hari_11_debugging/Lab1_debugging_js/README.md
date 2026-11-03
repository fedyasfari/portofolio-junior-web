# Panduan Pemula — Lab 1 Debugging JavaScript

## Target tugas

Cari dan perbaiki empat bug pada `bug-keranjang.js`, satu per satu. Catat penyebab dan perbaikannya di `laporan-bug.md`. Bandingkan dengan `solusi-keranjang.js` **setelah mencoba sendiri**.

## Persiapan

1. Buka Visual Studio Code (VS Code).
2. Pilih **File → Open Folder**, pilih folder `Lab-1-Debugging-JavaScript` yang telah diekstrak dari ZIP.
3. Buka **Terminal → New Terminal**. Pastikan terminal berada di folder proyek (lihat baris lokasi terminal). Bila perlu gunakan `cd` ke folder tersebut.
4. Periksa apakah Node.js tersedia dengan `node -v`. Jika muncul nomor versi, Node.js siap digunakan. Bila `node` tidak dikenali, instal Node.js lalu buka ulang VS Code.
5. Perintah `node` tidak menggunakan `npm`, jadi tidak perlu memperbaiki pengaturan PowerShell untuk `npm` hanya untuk lab ini.

## Jalankan dan debug dari terminal

Langkah 1: Jalankan kode bermasalah dengan `node bug-keranjang.js`. Catat pesan syntax error.

Langkah 2: Perbaiki baris paling akhir (tambahkan `)` yang hilang). Simpan Ctrl+S, jalankan ulang. Akan muncul masalah runtime karena batas loop.

Langkah 3: Cari fungsi `hitungTotal`, ubah `i <= daftar.length` menjadi `i < daftar.length`. Simpan dan jalankan ulang. Kali ini hasil menjadi `RpNaN`, akibat data penghapus belum memiliki `jumlah`.

Langkah 4: Tambahkan `jumlah: 1` di objek penghapus. Simpan dan jalankan ulang. Perhatikan hasil Rp73.800. Periksa apakah diskon tepat pada Rp50.000 sudah benar; belum.

Langkah 5: Tambahkan sementara `console.assert(hitungDiskon(50000) === 5000, 'Diskon batas 50000');` pada baris paling bawah. Akan muncul `Assertion failed` karena `>` salah untuk batas minimal. Ubah `total > 50000` menjadi `total >= 50000`. Pengujian kini lulus.

Langkah 6: Bandingkan hasil kerja dengan solusi: `node solusi-keranjang.js`. Catat perhitungan manual dan isi `laporan-bug.md`.

## Debug menggunakan browser (alternatif)

1. Buka file `index.html` di Chrome (boleh klik dua kali; jika menggunakan Live Server, pilih **Open with Live Server**).
2. Tekan `F12`, pilih tab **Console** untuk melihat error.
3. Buka tab **Sources**, pilih `bug-keranjang.js`.
4. Setelah B-01 selesai, pasang breakpoint pada baris `total += hitungSubtotal(daftar[i]);` dengan mengeklik nomor baris.
5. Muat ulang halaman (`Ctrl+R`). Saat eksekusi berhenti, perhatikan nilai `i`, `daftar.length`, dan `daftar[i]` dengan mouse atau panel **Scope/Watch**. Saat `i === 3` dan panjang array 3, `daftar[3]` bernilai `undefined`.
6. Gunakan **Step over (F10)** dan **Resume (F8)** untuk mengamati alur. F10/F8 adalah tombol pintas DevTools Chrome yang lazim; jika tidak berfungsi, gunakan tombol Step/Resume di DevTools.
7. Simpan perbaikan di VS Code lalu muat ulang halaman.

Catatan: jangan mencoba breakpoint sebelum B-01 diperbaiki karena browser tidak dapat mem-parse script yang sintaksnya salah.

## Debug Node dengan --inspect-brk (opsional)

1. Jalankan `node --inspect-brk bug-keranjang.js`.
2. Buka Chrome dan akses `chrome://inspect`.
3. Klik **Open dedicated DevTools for Node** (atau tautan **inspect** pada target Node yang terdeteksi).
4. Buka **Sources** lalu amati kode, beri breakpoint, dan jalankan langkah demi langkah.
5. Hentikan proses dengan `Ctrl+C` di terminal jika selesai.

Saran: untuk pemula, lakukan debugging terminal biasa lebih dulu. Jika terdapat syntax error, perbaiki B-01 dulu sebelum mencoba menelusuri perulangan.

## Hasil yang diharapkan setelah semua bug diperbaiki

```text
Subtotal Buku: Rp50.000
Subtotal Pensil: Rp30.000
Subtotal Penghapus: Rp2.000
Total belanja: Rp82.000
Diskon 10%: Rp8.200
Total bayar: Rp73.800
```

Tidak ada pesan `Assertion failed` berarti semua `console.assert` yang diberikan telah lulus. `console.assert` tidak mencetak pesan saat kondisi benar.

## Isi folder

- `bug-keranjang.js`: kode awal untuk latihan, sengaja bermasalah.
- `solusi-keranjang.js`: solusi dan pengujian otomatis sederhana.
- `index.html`: menjalankan kode awal di browser untuk debugging dengan DevTools.
- `index-solusi.html`: menampilkan hasil solusi di browser.
- `laporan-bug.md`: contoh laporan berisi tabel, analisis dan hasil akhir.

**Tips:** Kesalahan `NaN` tidak selalu menghentikan program. Jangan hanya mengandalkan pesan error: bandingkan hasil program dengan perhitungan manual dan uji kasus batas.
