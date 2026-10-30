# 06 — Repositori, .gitignore dan Riwayat 4 Commit

## A. Dua cara menyiapkan Git

### Cara 1 — Memulihkan riwayat Git yang telah dibuat (disarankan)
Paket ZIP utama memiliki file `riwayat-git-sprint0.bundle` di sebelah folder sumber.

Di Git Bash, dari folder ekstraksi:

```bash
git clone riwayat-git-sprint0.bundle capstone-dengan-git
cd capstone-dengan-git
git log --oneline -4
```

Hasil yang diharapkan: 4 commit yang mencerminkan tahapan berbeda, bukan satu commit besar. Salin `config/config.contoh.php` menjadi `config/config.php` di proyek hasil clone.

Untuk memakai XAMPP, pindahkan folder hasil clone ke `C:\xampp\htdocs\proyek-5-capstone-pendaftaran` (hindari konflik jika folder sudah ada). Jangan mengunggah direktori `.git` ke server publik.

### Cara 2 — Membuat riwayat Git milik sendiri
Jika menggunakan folder sumber biasa (tanpa `.git`), jalankan Git Bash:

```bash
git init
git add .gitignore README.md config/config.contoh.php config/database.php
git commit -m "chore: struktur proyek dan contoh konfigurasi aman"
git add docs/01-ANALISIS-KEBUTUHAN.md docs/02-BACKLOG-USER-STORY.md docs/03-DESAIN-BASIS-DATA.md
git commit -m "docs: analisis backlog dan desain basis data"
git add src/ public/ templates/ database/skema.sql
git commit -m "feat: CRUD pendaftar dengan PDO dan validasi"
git add docs/ wireframes/ tests/
git commit -m "test: tambah wireframe panduan dan skenario uji"
```

**Catatan:** Empat commit tersebut mencerminkan tahapan logis. Jika semua kode sudah tersedia sebelum `git init`, riwayat buatan sendiri tidak menggambarkan waktu pekerjaan yang sesungguhnya; gunakan cara 1 untuk melihat riwayat tahapan yang benar-benar dibuat dalam paket ini.

## B. Memastikan config tidak ikut Git

```bash
git check-ignore config/config.php
git ls-files config/config.php
git status --short
git log --oneline -4
```

- `check-ignore` menunjukkan nama file yang diabaikan.
- `git ls-files` **tidak boleh** menampilkan `config/config.php`.
- `git log` seharusnya menampilkan 4 commit.

## C. Catatan keamanan
`.gitignore` mencegah file yang belum terlacak ikut commit, tetapi **tidak menghapus riwayat file yang sudah pernah di-commit**. Jika pernah memasukkan password sungguhan ke Git, segera rotasi kredensial dan bersihkan riwayat dengan prosedur yang sesuai.
