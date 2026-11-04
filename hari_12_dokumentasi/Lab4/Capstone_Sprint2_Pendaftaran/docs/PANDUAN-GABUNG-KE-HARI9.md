# Cara menggabungkan Sprint 1 ke Capstone Hari 9 yang sudah ada

**Penting:** Proyek contoh Sprint 1 merupakan aplikasi referensi independen; jangan mengganti proyek Hari 9 dengan folder ini karena struktur fungsi, database, dan autentikasi admin mungkin berbeda.

1. **Backup** folder Capstone Hari 9 dan database MySQL melalui phpMyAdmin → Export.
2. Jalankan ZIP Sprint 1 di **database terpisah** lebih dahulu; jika sudah berjalan, bandingkan kode menggunakan VS Code Compare Selected.
3. Periksa apakah database Hari 9 menggunakan `tanggal_daftar` atau `tgl_daftar`. Sesuaikan kedua fungsi `ambilSemuaPendaftar()` dan `ambilBuktiPendaftar()`.
4. Periksa fungsi yang sudah ada dalam `src/helpers.php`, `src/database.php`, `src/pendaftar.php`. Jangan mendefinisikan ulang fungsi bernama sama karena akan menghasilkan *Cannot redeclare function*.
5. Tambahkan halaman publik `public/daftar.php`, `public/sukses.php` serta kontrol aksesnya; gabungkan pemanggilan yang sesuai dengan struktur Hari 9. Tinjau ulang login admin dalam proyek Hari 9, jangan menghapus proteksi yang sudah tersedia.
6. Gabungkan markup Bootstrap dari `templates/header.php`, `footer.php` dan `_form.php`; periksa `app.js` hanya dimuat sekali dan `jQuery` dimuat sebelum DataTables 1.x.
7. Gunakan `cetak.php` dan `templates/bukti.php` sebagai referensi, dengan nomor bukti `REG-YYYY-NNNNNN` dan `isRemoteEnabled=false`. Pastikan akses PDF dibatasi.
8. Gabungkan entri `composer.json`, lalu **jalankan Composer pada proyek hasil gabungan** untuk mendapatkan lock yang valid. Jangan menyalin `composer.lock` buatan tangan.
9. Gabungkan daftar library, lalu ulangi pengujian seluruh rute termasuk CRUD + CSRF.
10. Setelah lulus, commit perubahan bersama `composer.lock`; rahasia config dan vendor tidak ikut.
