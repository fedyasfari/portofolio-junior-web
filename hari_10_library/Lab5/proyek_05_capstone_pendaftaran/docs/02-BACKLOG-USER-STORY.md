# 02 — User Story & Product Backlog (14 Butir)

**Prioritas:** P0 = penting diselesaikan pada Sprint 0; P1 = wajib pada hari lanjutan; P2 = tambahan. Kolom "Target" menyatakan waktu rencana, bukan klaim implementasi.

| ID | Sebagai | Saya ingin | Agar | Prioritas | Target | Status |
|---|---|---|---|---|---|---|
| US-01 | Peserta | Mengisi form pendaftaran | Terdaftar di kelas pilihan | P0 / Wajib | Hari 9 | Dibuat |
| US-02 | Admin | Melihat daftar pendaftar dengan pencarian dan paginasi | Mengelola data dengan cepat | P0 / Wajib | Hari 9 | Dibuat (akses simulasi) |
| US-03 | Admin | Mengubah dan menghapus data pendaftar | Memperbaiki kesalahan data | P0 / Wajib | Hari 9 | Dibuat (akses simulasi) |
| US-04 | Peserta | Mencetak bukti pendaftaran PDF | Memiliki bukti resmi | P1 / Wajib | Hari 10 | Dirancang |
| US-05 | Admin | Login dengan akun | Data tidak dapat diubah orang lain | P1 / Wajib | Hari 11 | Dirancang |
| US-06 | Admin | Membatasi kuota kelas | Pendaftar tidak melebihi kapasitas | P1 / Wajib | Hari 11 | Dirancang |
| US-07 | Peserta | Melihat alasan ketika formulir tidak valid | Mudah memperbaiki input | P0 / Wajib | Hari 9 | Dibuat |
| US-08 | Admin | Menambah pendaftar secara manual | Dapat membantu peserta | P0 / Wajib | Hari 9 | Dibuat |
| US-09 | Admin | Mencegah email terdaftar dua kali | Data tetap konsisten | P0 / Wajib | Hari 9 | Dibuat |
| US-10 | Admin | Form terlindungi CSRF dan tampilan aman dari XSS | Risiko perubahan tak sah lebih kecil | P0 / Wajib | Hari 9 | Dibuat |
| US-11 | Peserta | Melihat konfirmasi setelah mendaftar | Tahu pengiriman berhasil | P0 / Wajib | Hari 9 | Dibuat |
| US-12 | Admin | Mencari nama dan berpindah halaman dengan filter tetap aktif | Dapat memeriksa banyak data | P0 / Wajib | Hari 9 | Dibuat |
| US-13 | Admin | Melihat sisa kuota dan status kelas | Mudah mengawasi kapasitas | P2 / Tambahan | Setelah Hari 11 | Backlog |
| US-14 | Admin | Mengunduh rekap CSV | Mempermudah pelaporan | P2 / Tambahan | Sprint berikutnya | Backlog |

## Kriteria penerimaan penting

**US-01:** Semua field wajib tervalidasi; email unik; kelas dipilih dari data MySQL; sukses hanya setelah tersimpan.

**US-02:** Daftar memuat nama, email, HP dan nama kelas; pencarian dengan query terparameter; 10 data per halaman, query pencarian dipertahankan.

**US-03:** Perubahan hanya dengan POST+CSRF; ID tidak valid mengembalikan 404; menghapus satu ID tidak menghapus baris lain.

**US-04 (Hari 10):** PDF dapat diunduh melalui mekanisme otorisasi/token yang aman, memuat identitas pendaftaran dan kelas; belum diterapkan.

**US-05 (Hari 11):** Password disimpan menggunakan `password_hash`; login menggunakan `password_verify` serta session aman; belum diterapkan.

**US-06 (Hari 11):** Pengecekan kuota dilakukan secara transaksional sebelum INSERT agar pendaftaran serentak tidak melebihi kapasitas; belum diterapkan.

**US-07/09:** Email kosong/tidak valid/duplikat mendapat pesan yang dapat dipahami dan tidak menghasilkan error fatal.

**US-10:** Form tanpa CSRF ditolak 403; teks `<script>` di keluaran tetap teks; seluruh input query ditangani sebagai data.

**US-11:** Redirect setelah POST ke halaman sukses untuk mencegah kirim ulang saat refresh.

**US-12:** Ketika `q=an` dan halaman berubah, filter tetap dikirim dalam URL navigasi.

## Urutan pengerjaan yang direkomendasikan
Hari 9: US-01, US-02, US-03, US-07 s.d. US-12 → Hari 10: US-04 → Hari 11: US-05 dan US-06 → sprint tambahan: US-13 dan US-14.
