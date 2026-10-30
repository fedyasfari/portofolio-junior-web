# 09 — Status Sprint 0 dan Rencana Hari Berikutnya

| Fitur | Implementasi kode di paket | Pengujian PHP lint | Pengujian browser/MySQL XAMPP |
|---|---|---|---|
| Form pendaftaran peserta | Tersedia | Diperiksa | Harus diuji pengguna |
| CRUD admin simulasi | Tersedia | Diperiksa | Harus diuji pengguna |
| Cari nama & paginasi | Tersedia | Diperiksa | Harus diuji pengguna |
| CSRF, output escaped, validasi | Tersedia | Diperiksa | Harus diuji pengguna |
| PDF bukti | **Belum; wireframe saja** | Tidak berlaku | Hari 10 |
| Login dan otorisasi admin | **Belum; skema admin saja** | Tidak berlaku | Hari 11 |
| Pembatas kuota | **Belum; kolom kuota saja** | Tidak berlaku | Hari 11 |

**PERINGATAN:** Daftar/admin belum dilindungi autentikasi, sehingga hasil Sprint 0 hanya untuk demo lokal. Tidak memenuhi persyaratan keamanan untuk dipublikasikan ke internet.

## Definition of Done yang harus dibuktikan pengguna
- [ ] CRUD bekerja di XAMPP dan uji wajib dicatat.
- [ ] Tidak ada Warning/Notice pada log saat pengujian.
- [x] Sumber query input menggunakan parameter PDO.
- [x] Data yang ditampilkan pada HTML di-escape.
- [x] `config/config.php` masuk `.gitignore` dan tidak menjadi bagian riwayat yang dibuat.
- [x] File `database/skema.sql` tersedia untuk membuat tiga tabel dari awal.
- [x] Backlog, analisis, desain, wireframe tersedia.
- [x] Disediakan riwayat 4 commit melalui bundle Git.

Checklist yang belum dicentang adalah hal yang memerlukan pengujian di komputer XAMPP pengguna, bukan kegagalan yang sudah terkonfirmasi.
