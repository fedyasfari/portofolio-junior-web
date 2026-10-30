# 10 — Matriks Ketertelusuran (Deliverable → Bukti)

| Persyaratan dari tugas | Bukti file | Verifikasi |
|---|---|---|
| Analisis kebutuhan peserta/admin/fitur/batasan | `01-ANALISIS-KEBUTUHAN.md` | Cek peran dan tabel fitur |
| User story backlog minimal 10 butir dan prioritas | `02-BACKLOG-USER-STORY.md` | Hitung US-01 sampai US-14 |
| ERD kelas, pendaftar, admin | `03-DESAIN-BASIS-DATA.md` | Cek kardinalitas dan field admin |
| Skema SQL impor dari kosong | `database/skema.sql` | Impor dan `SHOW TABLES` |
| Wireframe form, daftar, bukti | `wireframes/*.svg` / `04-WIREFRAME-TIGA-HALAMAN.md` | Buka di browser |
| CRUD Lab 3 berfungsi | `src/pendaftar.php`, `public/` | TC-01 s.d. TC-18 di `05-RENCANA-PENGUJIAN-CRUD.md` |
| Struktur folder T5 + `.gitignore` + README | root repository | Inspect tree dan Git |
| Minimal 4 commit bermakna | `riwayat-git-sprint0.bundle` | Clone lalu `git log --oneline -4` |
| Semua query input berparameter | `src/pendaftar.php` | Review `prepare`, `execute`, `bindValue` |
| Output di-escape | `src/helpers.php`, `public/`, `templates/` | Uji XSS + inspect `e()` |
| config.php tidak ter-commit | `.gitignore`, riwayat Git | `git ls-files config/config.php` kosong |
| Tanpa warning/notice | log PHP/Apache | Perlu uji di XAMPP |
| PDF/login/kuota (hari berikutnya) | status & desain | **Bukan syarat implementasi Hari 9** |
