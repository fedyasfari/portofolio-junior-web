# T7 — Laporan Bug / Temuan Proyek Sendiri

**Asal temuan:** pemeriksaan langsung sumber proyek **PBL Hari 10 Sprint 1** yang tersedia di Library. Keenam item di bawah **terkonfirmasi dari kode dasar** (temuan analisis statis), bukan klaim uji browser/database telah dilakukan di komputer Anda. Hasil aktual setelah menjalankan dan screenshot harus dilengkapi.

| ID | Temuan nyata | Lokasi asal | Perbaikan Sprint 2 | Status pengujian ulang |
|---|---|---|---|---|
| T7-01 | Autentikasi bukan DB | `public/login.php (Sprint 1)` | Ubah menjadi cariAdmin(PDO, username), password_verify, session admin_id | Retest login database di XAMPP: belum |
| T7-02 | Skema belum punya kuota | `database/skema.sql (Sprint 1)` | Tambahkan kolom kuota lewat migrasi; demo SQL langsung punya kuota | Retest perhitungan kuota di MySQL: belum |
| T7-03 | Pendaftaran publik tidak cek kuota | `public/daftar.php (Sprint 1)` | Gunakan daftarkanDenganKuota() dengan FOR UPDATE+COUNT+INSERT dalam transaksi | Retest penuh dan konkurensi di XAMPP: belum |
| T7-04 | Tambah admin dapat melewati kuota | `public/tambah.php (Sprint 1)` | Lewatkan INSERT melalui daftarkanDenganKuota() | Retest tambah admin kelas penuh: belum |
| T7-05 | Ubah kelas dapat menerobos kuota | `public/ubah.php (Sprint 1)` | Gunakan ubahPendaftarDenganKuota() dan kunci kelas tujuan | Retest perpindahan kelas penuh: belum |
| T7-06 | Cetak peserta masih publik berdasar sesi | `public/cetak.php (Sprint 1)` | Tambahkan wajibLogin() pada cetak.php; halaman sukses publik jadi status sederhana | Retest incognito cetak.php: belum |

## Detail gejala, penyebab, bukti dan retest
### T7-01 — Autentikasi bukan DB
- Lokasi sumber lama: `public/login.php (Sprint 1)`
- Bukti kode asal: Login membandingkan email dan hash dalam config/config.php; tidak mencari baris tabel admin
- Perbaikan di paket Sprint 2: Ubah menjadi cariAdmin(PDO, username), password_verify, session admin_id
- Verifikasi awal: Inspeksi berkas Sprint 1 (terverifikasi statis)
- Verifikasi ulang: **belum dijalankan di MySQL/browser lokal**. Bukti screenshot: ______; hasil aktual: ______; status: ______.

### T7-02 — Skema belum punya kuota
- Lokasi sumber lama: `database/skema.sql (Sprint 1)`
- Bukti kode asal: CREATE TABLE kelas hanya memuat id dan nama_kelas; tidak ada kuota
- Perbaikan di paket Sprint 2: Tambahkan kolom kuota lewat migrasi; demo SQL langsung punya kuota
- Verifikasi awal: Inspeksi berkas SQL Sprint 1 (terverifikasi statis)
- Verifikasi ulang: **belum dijalankan di MySQL/browser lokal**. Bukti screenshot: ______; hasil aktual: ______; status: ______.

### T7-03 — Pendaftaran publik tidak cek kuota
- Lokasi sumber lama: `public/daftar.php (Sprint 1)`
- Bukti kode asal: Memanggil tambahPendaftar langsung; tidak ada transaksi/lock; dapat menerima lebih dari kuota
- Perbaikan di paket Sprint 2: Gunakan daftarkanDenganKuota() dengan FOR UPDATE+COUNT+INSERT dalam transaksi
- Verifikasi awal: Inspeksi berkas Sprint 1 (terverifikasi statis)
- Verifikasi ulang: **belum dijalankan di MySQL/browser lokal**. Bukti screenshot: ______; hasil aktual: ______; status: ______.

### T7-04 — Tambah admin dapat melewati kuota
- Lokasi sumber lama: `public/tambah.php (Sprint 1)`
- Bukti kode asal: Admin memanggil tambahPendaftar langsung; menghindari pemeriksaan kapasitas
- Perbaikan di paket Sprint 2: Lewatkan INSERT melalui daftarkanDenganKuota()
- Verifikasi awal: Inspeksi berkas Sprint 1 (terverifikasi statis)
- Verifikasi ulang: **belum dijalankan di MySQL/browser lokal**. Bukti screenshot: ______; hasil aktual: ______; status: ______.

### T7-05 — Ubah kelas dapat menerobos kuota
- Lokasi sumber lama: `public/ubah.php (Sprint 1)`
- Bukti kode asal: Admin memanggil ubahPendaftar langsung tanpa memeriksa kelas tujuan
- Perbaikan di paket Sprint 2: Gunakan ubahPendaftarDenganKuota() dan kunci kelas tujuan
- Verifikasi awal: Inspeksi berkas Sprint 1 (terverifikasi statis)
- Verifikasi ulang: **belum dijalankan di MySQL/browser lokal**. Bukti screenshot: ______; hasil aktual: ______; status: ______.

### T7-06 — Cetak peserta masih publik berdasar sesi
- Lokasi sumber lama: `public/cetak.php (Sprint 1)`
- Bukti kode asal: Mengizinkan peserta dengan izin sesi membuka cetak PDF, berbeda dari syarat Hari 11 untuk wajibLogin()
- Perbaikan di paket Sprint 2: Tambahkan wajibLogin() pada cetak.php; halaman sukses publik jadi status sederhana
- Verifikasi awal: Inspeksi berkas Sprint 1 (terverifikasi statis)
- Verifikasi ulang: **belum dijalankan di MySQL/browser lokal**. Bukti screenshot: ______; hasil aktual: ______; status: ______.

## Catatan tambahan
- Penemuan lima bug **baru saat eksekusi** tidak boleh direkayasa. Jika Anda menemukan masalah baru di lingkungan lokal, tulis entri T7-07 dst. dengan langkah reproduksi, hasil aktual, hasil diharapkan, akar penyebab, perbaikan, bukti, retest.
- Pengecekan akhir: debug=false, jalankan unit/integrasi, admin tidak bocor lewat halaman, CSRF aktif, output nama di-escape, pencarian server bila ditambah harus menggunakan parameter query.
