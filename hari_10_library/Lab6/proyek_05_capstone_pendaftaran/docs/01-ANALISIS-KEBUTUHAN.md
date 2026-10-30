# 01 — Analisis Kebutuhan Sistem

## A. Latar belakang
Lembaga pelatihan menerima pendaftaran kelas secara daring. Data pendaftar disimpan pada MySQL; admin memeriksa, mencari, mengubah, serta menghapus data. Peserta nantinya dapat mencetak bukti pendaftaran PDF. **Hari 9/Sprint 0 membangun fondasi dan CRUD**, bukan seluruh sistem final.

## B. Pengguna dan tujuan
| Aktor | Tujuan | Kebutuhan |
|---|---|---|
| Peserta | Mendaftar pada kelas pilihan | Formulir mudah dipahami, validasi, informasi berhasil |
| Admin | Mengelola pendaftar | Daftar, pencarian, paginasi, tambah, ubah, hapus |
| Admin (Hari 11) | Mengakses data secara terbatas | Login, session, logout, otorisasi |

## C. Kebutuhan fungsional
| Kode | Fitur | Sprint / status | Kriteria selesai |
|---|---|---|---|
| FR-01 | Form pendaftaran peserta | Sprint 0, dibuat | Input valid tersimpan pada database |
| FR-02 | Daftar pendaftar admin | Sprint 0, dibuat | Tabel JOIN kelas, terbaru di atas |
| FR-03 | Cari dan paginasi | Sprint 0, dibuat | Pencarian nama dan 10 item/halaman |
| FR-04 | Tambah, ubah, hapus admin | Sprint 0, dibuat | CRUD dengan POST untuk perubahan |
| FR-05 | Validasi email/HP/kelas | Sprint 0, dibuat | Input salah ditolak; email unik |
| FR-06 | Cetak bukti pendaftaran PDF | Hari 10, **belum dibuat** | File PDF sah berisi data pendaftaran |
| FR-07 | Login dan logout admin | Hari 11, **belum dibuat** | Hanya admin terautentikasi bisa mengelola |
| FR-08 | Pembatasan kuota kelas | Hari 11, **belum dibuat** | Tidak melebihi kapasitas; aman dari race condition |

## D. Fitur tambahan (nice to have)
- Filter berdasarkan kelas; ekspor CSV; dashboard statistik; pemberitahuan email; desain mobile lanjutan.
- Semuanya di luar Sprint 0 dan **tidak dianggap selesai** pada hari ini.

## E. Batasan dan asumsi
1. Pengembangan dan demo dilakukan di komputer lokal menggunakan XAMPP, PHP 8.1+ dan MySQL/MariaDB.
2. Database menggunakan nama `db_capstone_sprint0` **terpisah** dari `db_pelatihan` pada Lab 3.
3. Tabel `admin` dan kolom `kuota` disiapkan untuk perancangan Hari 11, tanpa akun default dan tanpa pemeriksaan kapasitas pada Sprint 0.
4. Halaman daftar/admin saat ini **belum memiliki autentikasi**, sehingga aplikasi **tidak layak diunggah ke server publik**.
5. Bukti PDF belum tersedia; wireframe mencantumkan tombol PDF sebagai **rencana fitur**, bukan aksi yang telah bekerja.
6. Satu alamat email hanya boleh dimiliki satu pendaftar sesuai ketentuan praktikum.
7. Belum ada pembayaran, unggah berkas, integrasi WhatsApp, atau email otomatis.
8. Seluruh data contoh bersifat fiktif; jika menggunakan data riil, wajib ada pembatasan akses dan kebijakan privasi.

## F. Kebutuhan nonfungsional
- Keamanan: nilai query diikat dalam PDO, output data di-escape, CSRF untuk operasi perubahan, konfigurasi kredensial tidak di-commit.
- Keterbacaan: folder terpisah untuk config, src, public, templates, docs, database.
- Keandalan: error dalam log server, bukan dibocorkan ke peserta; tidak ada Warning/Notice pada alur uji.
- Usability: label formulir, pesan validasi per bidang, navigasi konsisten, tabel responsif sederhana.
- Kinerja: paginasi 10 item per halaman untuk menghindari mengirim semua baris ke satu halaman.

## G. Alur bisnis
1. Peserta mengakses `daftar.php`, memilih kelas, lalu mengirim formulir.
2. Sistem memvalidasi input, email unik, dan ID kelas; jika valid sistem menyimpan pendaftar.
3. Sistem menampilkan pesan pendaftaran berhasil tanpa membeberkan data sensitif di URL.
4. Admin simulasi mengakses `index.php` untuk mencari, menambah, mengubah dan menghapus pendaftar.
5. **Pengembangan berikutnya:** PDF bukti (Hari 10), autentikasi dan pembatas kuota (Hari 11).

## H. Kriteria penerimaan Sprint 0
- Skema dapat diimpor dari kosong; halaman peserta dan CRUD admin simulasi bekerja.
- Input salah, email ganda, ID tidak valid, CSRF tidak sah tertangani.
- Query berparameter, output escaped, config lokal tidak terlacak Git.
- Tidak ada warning/notice pada pengujian yang dilaksanakan.
- Dokumen backlog minimal 10 story, ERD, wireframe 3 halaman, dan 4 commit tersedia.
