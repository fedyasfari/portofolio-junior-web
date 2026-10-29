# PANDUAN PRAKTIKUM LENGKAP — LAB 2
## Koneksi PDO dan Demonstrasi SQL Injection (untuk pemula)

### A. Target akhir
Setelah menyelesaikan lab, peserta dapat:
1. Membuat proyek PHP dengan pemisahan konfigurasi, logika, template, dan halaman publik.
2. Membuat koneksi PHP–MySQL menggunakan PDO (`getConnection()`).
3. Menampilkan, menambah, mengubah, dan menghapus data pendaftar (CRUD).
4. Menjelaskan alasan input langsung dalam query SQL berbahaya.
5. Membuktikan `prepare()` dan `execute()` memperlakukan input sebagai data.
6. Mencegah kredensial database ikut masuk repository Git lewat `.gitignore`.

### B. Persiapan perangkat lunak
- Windows dengan XAMPP yang menyediakan Apache, PHP dan MySQL/MariaDB.
- Browser dan editor (mis. VS Code).
- Pastikan PHP pada XAMPP menyediakan ekstensi `pdo_mysql`.

### C. Tahapan awal dari nol

**Langkah 1. Jalankan server.** Buka XAMPP Control Panel; Start Apache dan MySQL. Kedua layanan harus aktif.

**Langkah 2. Ekstrak proyek.** Letakkan folder persis di `C:\xampp\htdocs\proyek-5-capstone-pendaftaran\`. Nama folder harus cocok dengan URL yang akan digunakan.

**Langkah 3. Buat database.** Buka `http://localhost/phpmyadmin/`, pilih **Import**, pilih file `database/skema.sql`, klik **Go/Kirim**. Skrip SQL membuat database `db_pelatihan`, tabel `kelas` dan `pendaftar`, mengisi 3 kelas serta 8 pendaftar. Kelas Data Science dibiarkan tanpa pendaftar.

**Perhatian:** Impor ulang `skema.sql` mereset data tabel latihan karena memuat `DROP TABLE IF EXISTS`. Gunakan hanya untuk data praktik.

**Langkah 4. Cek konfigurasi.** Buka `config/config.php`. Default XAMPP pada komputer latihan biasanya menggunakan host `localhost`, database `db_pelatihan`, user `root`, sandi kosong, debug `true`. Jika ada password/port khusus, sesuaikan dengan lingkungan Anda. File `config/config.contoh.php` adalah contoh tanpa password pribadi.

**Langkah 5. Jalankan aplikasi.** Di browser buka:

```text
http://localhost/proyek-5-capstone-pendaftaran/public/index.php
```

Harus terlihat daftar pendaftar dan tombol Tambah, Ubah, Hapus.

**Langkah 6. Lakukan CRUD.** Klik `Tambah Pendaftar`, isi nama, email baru, nomor HP, kelas dan tanggal, kemudian Simpan. Di halaman daftar tekan `Ubah` untuk mengedit. Klik `Hapus` jika ingin menghapus data uji. Cek perubahannya pada tabel `pendaftar` di phpMyAdmin.

### D. Penjelasan folder dan file

| Path | Peran |
|---|---|
| `config/config.php` | Pengaturan lokal (hostname, nama DB, username, password). **Tidak dimasukkan Git**. |
| `config/config.contoh.php` | Template konfigurasi yang boleh dimasukkan Git; tanpa sandi nyata. |
| `config/database.php` | Fungsi koneksi `getConnection()` memakai PDO. |
| `src/bootstrap.php` | Memulai session dan memuat fungsi bersama. |
| `src/helpers.php` | Escape HTML, CSRF, redirect, notifikasi, validasi input. |
| `src/pendaftar.php` | Fungsi CRUD dengan parameter SQL yang aman. |
| `public/index.php` | Menampilkan semua pendaftar dan nama kelas (JOIN). |
| `public/tambah.php` | Menyimpan pendaftar baru setelah validasi. |
| `public/ubah.php` | Mengubah pendaftar berdasarkan ID. |
| `public/hapus.php` | Menghapus pendaftar via POST. |
| `public/_form.php` | Komponen HTML formulir bersama. |
| `public/injeksi.php` | Demo query raw SQL tidak aman vs prepared statement. |
| `templates/header.php`, `footer.php` | Kerangka HTML bersama agar tidak mengulang markup. |
| `database/skema.sql` | Membuat tabel, relasi dan data awal. |
| `.gitignore` | Memberitahu Git untuk tidak melacak file sensitif tertentu. |

### E. Memahami getConnection() secara bertahap

Kode utama pada `config/database.php`:

```php
$config = require __DIR__ . '/config.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',
    $config['host'], $config['nama_db']);
$pdo = new PDO($dsn, $config['user'], $config['sandi'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);
```

- `require` membaca pengaturan dari file lokal.
- `dsn` menjelaskan jenis database, alamat host, nama database dan charset.
- `new PDO(...)` membuat koneksi ke MySQL.
- `ERRMODE_EXCEPTION` menyebabkan kesalahan database melempar exception untuk ditangani.
- `FETCH_ASSOC` mengembalikan baris sebagai array dengan key nama kolom.
- `ATTR_EMULATE_PREPARES => false` menggunakan native prepared statements bila didukung driver.

Versi `getConnection()` di proyek menyimpan objek dalam `static $connection` sehingga dipakai ulang selama satu request.

### F. Perbedaan query rentan dan aman

**1. Tidak aman (sengaja, hanya dalam `injeksi.php`):**

```php
$email = $_GET['email'] ?? '';
$sql = "SELECT * FROM pendaftar WHERE email = '$email'";
$hasil = $pdo->query($sql)->fetchAll();
```

Masukan dikombinasikan langsung ke kode SQL, sehingga quote `'` dari pengguna dapat mengubah struktur query.

**2. Aman (disarankan untuk aplikasi nyata):**

```php
$email = $_GET['email'] ?? '';
$stmt = $pdo->prepare('SELECT * FROM pendaftar WHERE email = :email');
$stmt->execute(['email' => $email]);
$hasil = $stmt->fetchAll();
```

`:email` merupakan placeholder. Input pengguna dikirim sebagai parameter, bukan disisipkan ke sintaks SQL. Contoh ini juga menolak upaya memanipulasi struktur query lewat email.

**3. Jalankan demonstrasi di komputer sendiri:**

```text
http://localhost/proyek-5-capstone-pendaftaran/public/injeksi.php
```

Isikan email normal `andi@example.com` dan tekan Bandingkan. Keduanya akan menghasilkan 1 data. Setelah itu isi:

```text
x' OR '1'='1
```

atau gunakan URL yang telah ter-encode:

```text
http://localhost/proyek-5-capstone-pendaftaran/public/injeksi.php?email=x%27%20OR%20%271%27%3D%271
```

Versi tidak aman berubah menjadi:

```sql
SELECT id_pendaftar, nama, email
FROM pendaftar
WHERE email = 'x' OR '1'='1'
ORDER BY id_pendaftar;
```

`'1'='1'` selalu benar dan kondisi `OR` menjadikan setiap baris cocok. Dengan data awal, versi raw SQL menunjukkan **8** data sedangkan versi aman **0** data. Versi aman berusaha mencari alamat email yang secara literal sama persis dengan `x' OR '1'='1`, yang memang tidak ada.

**Penting:** Simulasi injeksi terbatas di `127.0.0.1` / `::1`, tidak diperuntukkan bagi jaringan bersama atau internet. Jangan mencoba payload ini pada sistem pihak lain.

### G. Mengapa pengaturan Git diperlukan?

Isi `.gitignore`:

```gitignore
config/config.php
vendor/
node_modules/
.env
```

`config/config.php` dapat berisi password database lokal. File tersebut tidak boleh dilacak oleh Git. Sebaliknya, `config/config.contoh.php` hanya memuat contoh dan aman disertakan ke repository.

Jika Git tersedia, di terminal pada folder proyek jalankan:

```bash
git init
git status --short --ignored
```

Jika muncul `!! config/config.php`, berarti file konfigurasi dikenali sebagai diabaikan. Jangan pernah menjalankan `git add -f config/config.php`.

### H. Pengujian yang dianjurkan dan hasilnya

| No | Pengujian | Hasil yang diharapkan |
|---|---|---|
| 1 | Buka `public/index.php` | Tabel 8 pendaftar tampil (jika belum diubah). |
| 2 | Tambah pendaftar baru | Data muncul di daftar dan phpMyAdmin. |
| 3 | Ubah nomor HP | Nilai baru tersimpan. |
| 4 | Hapus pendaftar | Data hilang dari daftar. |
| 5 | Isi email duplikat | Pesan validasi: email sudah digunakan. |
| 6 | Buka `injeksi.php?email=andi%40example.com` | Rentan 1 data, aman 1 data. |
| 7 | Buka payload `x' OR '1'='1` | Rentan seluruh data, aman 0 data. |
| 8 | Akses `hapus.php` lewat GET langsung | HTTP 405, penghapusan tidak dijalankan. |
| 9 | Periksa `.gitignore` | `config/config.php` diabaikan oleh Git. |

### I. Pertanyaan laporan dan jawaban

**1. Apa itu PDO?**
PDO adalah antarmuka PHP untuk berkomunikasi dengan database secara konsisten, termasuk MySQL, melalui objek koneksi dan metode query.

**2. Mengapa perlu `config.php` terpisah?**
Supaya pengaturan koneksi dapat diganti tanpa mengedit seluruh aplikasi dan rahasia lokal tidak ikut masuk repository.

**3. Apa itu SQL Injection?**
SQL Injection adalah manipulasi perintah SQL melalui input yang langsung disusun menjadi bagian dari query tanpa pemisahan yang benar antara data dan sintaks.

**4. Mengapa prepared statement lebih aman?**
Karena struktur query dipersiapkan terlebih dahulu sedangkan input dikirim sebagai nilai parameter; input tidak bisa mengubah operator/struktur query melalui placeholder tersebut.

**5. Mengapa versi rentan mengembalikan seluruh data?**
Karena string `OR '1'='1'` yang disisipkan mengubah klausa WHERE sehingga benar untuk semua baris.

**6. Apakah prepared statement satu-satunya perlindungan?**
Tidak. Aplikasi juga membutuhkan autentikasi, otorisasi, validasi, escape output, CSRF protection, dan pengaturan database dengan hak akses minimal, khususnya untuk produksi.

### J. Masalah yang sering terjadi

1. **Apache/MySQL belum aktif:** Jalankan XAMPP dan pastikan status berubah menjadi Running.
2. **404:** Pastikan folder berada di `C:\xampp\htdocs\` dan URL memuat `/public/index.php`.
3. **Unknown database:** Impor `database/skema.sql` ke phpMyAdmin.
4. **Access denied:** Periksa `user`/`sandi` di `config/config.php`.
5. **could not find driver:** Aktifkan `extension=pdo_mysql` pada PHP yang digunakan Apache.
6. **Cannot modify header information:** Jangan menambahkan echo/HTML sebelum logika redirect POST di awal file.
7. **403 pada demo injeksi:** Buka lewat `localhost` dari mesin tempat XAMPP berjalan (bukan dari komputer lain).
8. **Data berkurang:** Jika sudah melakukan operasi hapus, jumlah hasil versi rentan akan mengikuti data saat itu; impor ulang skema untuk reset **khusus database latihan**.

### K. Rekomendasi screenshot untuk tugas

- Screenshot 1 — XAMPP Apache dan MySQL berjalan.
- Screenshot 2 — phpMyAdmin menampilkan database `db_pelatihan` dan tabel.
- Screenshot 3 — `index.php` menampilkan daftar pendaftar.
- Screenshot 4 — formulir `tambah.php`.
- Screenshot 5 — demonstrasi email normal (1 vs 1).
- Screenshot 6 — demonstrasi payload (semua vs 0).
- Screenshot 7 — `.gitignore` dan `config.contoh.php` di VS Code.

Simpan screenshot Anda sendiri, karena gambar dari komputer orang lain tidak membuktikan praktik telah dilakukan.
