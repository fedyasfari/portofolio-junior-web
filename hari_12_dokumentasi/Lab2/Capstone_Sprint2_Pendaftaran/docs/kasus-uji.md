# T6 — Tabel Kasus Uji PBL Hari 11 Sprint 2

**Pengisian:** Hasil aktual, status dan bukti adalah tempat mencatat *hasil pelaksanaan Anda sendiri*. Jangan menyalin hasil diharapkan sebagai hasil aktual tanpa mengetes.

| ID | Skenario | Input / Langkah | Hasil diharapkan | Hasil aktual | Status | Bukti |
|---|---|---|---|---|---|---|
| T6-01 | Pendaftaran valid | nama=Andi, email=unik, HP=0812345678, kelas tersedia | Data tersimpan; status sukses | *belum diuji* | *belum diuji* | — |
| T6-02 | Nama kosong | nama kosong, data lain valid | Ditolak: galat nama | *belum diuji* | *belum diuji* | — |
| T6-03 | Email kosong | email kosong, data lain valid | Ditolak: galat email | *belum diuji* | *belum diuji* | — |
| T6-04 | Nomor HP kosong | no_hp kosong, data lain valid | Ditolak: galat nomor HP | *belum diuji* | *belum diuji* | — |
| T6-05 | Kelas kosong | kelas_id kosong, data lain valid | Ditolak: pilih kelas | *belum diuji* | *belum diuji* | — |
| T6-06 | Alamat kosong | alamat kosong (opsional), data lain valid | Lolos pendaftaran | *belum diuji* | *belum diuji* | — |
| T6-07 | Email ganda | submit email terdaftar lagi | Ditolak: email sudah dipakai | *belum diuji* | *belum diuji* | — |
| T6-08 | HP 9 digit | 081234567 | Ditolak: nomor HP salah | *belum diuji* | *belum diuji* | — |
| T6-09 | HP 10 digit | 0812345678 | Diterima (jika kelas tersedia) | *belum diuji* | *belum diuji* | — |
| T6-10 | HP 13 digit | 0812345678901 | Diterima (jika kelas tersedia) | *belum diuji* | *belum diuji* | — |
| T6-11 | HP 14 digit | 08123456789012 | Ditolak: nomor HP salah | *belum diuji* | *belum diuji* | — |
| T6-12 | Kuota kursi terakhir | kuota=1, peserta pertama daftar | Pendaftaran pertama berhasil | *belum diuji* | *belum diuji* | — |
| T6-13 | Kuota penuh | kelas penuh, peserta kedua email unik | Ditolak: Kuota kelas sudah penuh | *belum diuji* | *belum diuji* | — |
| T6-14 | Login benar | username admin dan password benar | Redirect index.php; session admin_id ada | *belum diuji* | *belum diuji* | — |
| T6-15 | Login salah | username benar, sandi salah | Ditolak: pesan generik; tidak masuk | *belum diuji* | *belum diuji* | — |
| T6-16 | Akses admin tanpa login | mode incognito → index.php | Redirect login.php | *belum diuji* | *belum diuji* | — |
| T6-17 | ID non numerik | ubah.php?id=abc setelah login | HTTP 404; tanpa query berbahaya | *belum diuji* | *belum diuji* | — |
| T6-18 | XSS pada nama | Nama <script>alert(1)</script> di data uji | Tampil sebagai teks, tidak dieksekusi | *belum diuji* | *belum diuji* | — |
| T6-19 | SQL Injection input pencarian | masukkan string uji SQL pada pencarian server ?q=... | Tidak merusak data dan tidak membocorkan seluruh tabel | *belum diuji* | *belum diuji* | — |
| T6-20 | Hapus tanpa token | POST hapus.php id=1 tanpa csrf, login sudah ada | HTTP 403; data tidak terhapus | *belum diuji* | *belum diuji* | — |
| T6-21 | Hapus GET | akses hapus.php?id=1 via GET, login sudah ada | HTTP 405 | *belum diuji* | *belum diuji* | — |
| T6-22 | Logout GET | akses logout.php via GET saat login | HTTP 405; masih login | *belum diuji* | *belum diuji* | — |
| T6-23 | Logout POST valid | POST csrf valid dari navbar | Logout; masuk lagi diperlukan | *belum diuji* | *belum diuji* | — |
| T6-24 | Login 6 kali salah | kirim 6 percobaan salah dalam sesi sama | Terkunci sementara setelah 5 gagal | *belum diuji* | *belum diuji* | — |
| T6-25 | Cetak tanpa login | incognito cetak.php?id=1 | Redirect login.php | *belum diuji* | *belum diuji* | — |
| T6-26 | Ubah pindah ke kelas penuh | admin ubah peserta ke kelas sisa 0 | Ditolak: kuota kelas tujuan penuh | *belum diuji* | *belum diuji* | — |
| T6-27 | XSS pada daftar admin | nama HTML tampil di index setelah login | Dienkode, tidak mengeksekusi script | *belum diuji* | *belum diuji* | — |

## Cara melakukan pengujian
1. Jalankan database XAMPP dan login admin melalui browser. Pakai email dummy unik setiap pendaftaran; jika kelas penuh, buat kelas uji melalui phpMyAdmin pada database latihan.
2. Catat respons (pesan berhasil/error), perubahan isi tabel database, dan status Network HTTP jika relevan.
3. Untuk XSS dan SQL Injection gunakan hanya aplikasi **lokal milik sendiri**; uji apakah input ditampilkan sebagai teks dan query menggunakan placeholder. Pada Sprint 2 terdapat pencarian server di `index.php` (parameter `q`); verifikasi `cariPendaftar()` memakai PDO prepared statement dan hasil tidak bocor.
4. Pada pengujian Hapus Tanpa Token, login dulu. Login yang belum dilakukan akan menyebabkan redirect dan belum menguji CSRF.
5. Uji dua request bersamaan (race condition) tidak dibuktikan oleh test berurutan; butuh pengujian concurrent di MySQL sesungguhnya.

## Referensi hasil otomatis (BUKAN pengganti uji manual)
`tests/jalankan.php` menguji 16 kasus fungsi murni. `tests/uji-integrasi.php` menguji tiga pemeriksaan kuota berurutan memakai DB XAMPP (jika dijalankan di lokal).
