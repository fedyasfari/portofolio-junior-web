# LAB 1 — Evaluasi Library dan Lisensi

**Mata materi:** Library dan Komponen Pre-Existing  
**Proyek:** Sistem Pendaftaran Pelatihan — Capstone Hari 9 / Sprint 0  
**Lokasi dokumen:** `proyek-5-capstone-pendaftaran/docs/daftar-library.md`  
**Tanggal penelusuran sumber:** 30 Oktober 2026  
**Nama / kelas:** [ISI NAMA DAN KELAS]

> **Status verifikasi:** Versi dan lisensi Bootstrap/SweetAlert2 di bawah telah diperiksa dari sumber resmi daring pada 30 Oktober 2026. Hasil eksekusi perintah `npm view` di terminal komputer peserta **belum diisi**; tempel hasil nyata pada Bagian 5. Daftar paket yang benar-benar terpasang pada proyek juga harus diperiksa dengan `package.json` / `npm ls` dan pencarian pemanggilan library di kode. Jangan menyatakan library dipakai jika hanya menjadi kandidat.

## 1. Tujuan

Mengevaluasi komponen siap pakai berdasarkan fungsi, versi, kebutuhan proyek, alternatif, lisensi, aktivitas rilis, dependensi, penghematan waktu, dan risiko pemeliharaan. Evaluasi membantu memilih komponen yang legal dan tepat untuk proyek komersial maupun proyek latihan.

## 2. Lingkup proyek dan pemeriksaan awal

Capstone Hari 9 menggunakan HTML, CSS, JavaScript, PHP + PDO, MySQL/MariaDB, dan Apache lokal (misalnya melalui XAMPP). Materi T7 *stack pengembangan web* menyebut Bootstrap sebagai salah satu opsi antarmuka; instruksi Lab 1 juga secara eksplisit meminta evaluasi SweetAlert2. Oleh karena itu, keduanya dijadikan **kandidat library pihak ketiga** untuk dinilai. **PDO** dicatat terpisah karena merupakan ekstensi yang disertakan dalam PHP, bukan paket npm atau Composer tambahan.

HTML, CSS, dan JavaScript adalah teknologi bahasa/standar, sedangkan Apache, MySQL, npm, Composer, Git, VS Code, dan XAMPP memiliki fungsi berbeda. Jangan menyebut semuanya sebagai *library npm*.

**Bukti penggunaan pada proyek (lengkapi sesudah inspeksi):**

| Komponen | Status dalam proyek | Bukti berkas/hasil inspeksi |
| --- | --- | --- |
| Bootstrap | [belum diperiksa / sudah digunakan / kandidat] | [contoh: `templates/header.php`, `package.json`, atau link CDN] |
| SweetAlert2 | [belum diperiksa / sudah digunakan / kandidat] | [contoh: `public/*.php`, `assets/js/*`, `package.json`, atau link CDN] |
| PHP PDO + PDO_MYSQL | [belum diperiksa / digunakan] | [contoh: `config/database.php`, hasil `php -m`] |
| Library tambahan yang muncul di `package.json` / `composer.json` | [isi atau 'tidak ada'] | [nama berkas dan versi] |

## 3. Templat analisis library (T3)

Untuk **setiap library yang benar-benar digunakan** atau yang sedang dinilai sebagai calon pemakaian, catat:

1. **Nama dan fungsi:** masalah yang diselesaikan pada sistem pendaftaran.
2. **Versi:** versi yang dipilih / benar-benar terpasang; bedakan dengan versi terbaru di registry.
3. **Alasan memilih:** manfaat spesifik bagi fitur proyek.
4. **Alternatif:** setidaknya satu pilihan lain dan kekurangan/kelebihannya.
5. **Lisensi:** jenis lisensi, izin penggunaan komersial, dan kewajiban seperti penyertaan pemberitahuan hak cipta.
6. **Rilis terakhir:** tanggal rilis versi stabil yang dipakai dan aktivitas proyek terbaru; sertakan URL sumber.
7. **Dependency:** paket runtime/peer dependencies (bukan hanya paket pengembangan/devDependencies).
8. **Estimasi penghematan:** asumsi perbandingan pekerjaan manual vs penggunaan library; bukan angka hasil pengukuran aktual.
9. **Risiko/keputusan:** kompatibilitas, keamanan, dokumentasi, dan apakah dipakai atau tidak.

## 4. Analisis komponen

### 4.1 Bootstrap

| Aspek | Hasil analisis |
| --- | --- |
| Nama/fungsi | Bootstrap: framework CSS/komponen antarmuka responsif; cocok untuk tabel pendaftar, form, tombol, menu, dan layout dashboard admin. |
| Versi terbaru berlabel `latest` di npm saat diperiksa | **5.3.8** (stabil). **6.0.0-alpha.1** muncul sebagai versi pratinjau `next`; **jangan samakan alpha dengan stabil**. |
| Versi terpasang di Capstone | **[ISI SESUDAH CEK]**; jika memakai CDN, periksa angka versi pada URL; jika npm, gunakan `npm ls bootstrap --depth=0`. |
| Alasan memilih | Mempercepat tata letak yang konsisten dan responsif tanpa merancang seluruh CSS dari awal. |
| Alternatif | Bulma (CSS siap pakai, relatif sederhana); Tailwind CSS (utility-first dan kustomisasi tinggi, namun alur konfigurasi lebih kompleks untuk pemula); CSS sendiri (dependensi minimum, waktu pengerjaan lebih lama). |
| Lisensi | **MIT**. Dapat digunakan untuk aplikasi komersial tertutup, dengan mengikuti kewajiban lisensi, termasuk mempertahankan pemberitahuan hak cipta dan lisensi dalam distribusi yang relevan. |
| Rilis stabil versi 5.3.8 | Blog resmi mencatat **25 Agustus 2025**; rilis GitHub bertanggal **26 Agustus 2025** sesuai zona waktu GitHub. |
| Aktivitas lebih baru | Bootstrap 6 Alpha diumumkan **8 Oktober 2026**. Ini bukti aktivitas, tetapi masih **pratinjau**, bukan alasan langsung menaikkan proyek pemula ke versi alpha. |
| Dependensi | Untuk **CSS** Bootstrap tidak membutuhkan library JS. Komponen JS tertentu seperti dropdown, tooltip, dan popover memakai **Popper** (`@popperjs/core`); file `bootstrap.bundle.min.js` telah menyertakan Popper. Periksa `npm view bootstrap peerDependencies` jika menggunakan npm. Dependensi **development/build** tidak disamakan dengan dependensi runtime aplikasi. |
| Estimasi penghematan | Merancang 4–8 jam CSS/komponen dasar dari nol dibanding 1–2 jam adaptasi Bootstrap → perkiraan penghematan **3–6 jam** (ilustrasi; bervariasi sesuai kebutuhan dan pengalaman). |
| Risiko | Menggunakan kelas/komponen tanpa menyesuaikan desain, memuat CSS/JS berlebihan, konflik CSS, perubahan saat naik versi mayor. |
| Keputusan | **Direkomendasikan** jika Capstone membutuhkan form, tabel, dan halaman admin responsif; pastikan status benar-benar digunakan dari berkas proyek. |

**Sumber resmi:**
- https://www.npmjs.com/package/bootstrap
- https://www.npmjs.com/package/bootstrap?activeTab=versions
- https://blog.getbootstrap.com/2025/08/25/bootstrap-5-3-8/
- https://blog.getbootstrap.com/archive/
- https://getbootstrap.com/docs/5.3/getting-started/introduction/
- https://github.com/twbs/bootstrap/releases
- https://raw.githubusercontent.com/twbs/bootstrap/v5.3.8/package.json

### 4.2 SweetAlert2

| Aspek | Hasil analisis |
| --- | --- |
| Nama/fungsi | SweetAlert2: library popup/konfirmasi/toast yang dapat diakses (accessible); dapat dipakai untuk konfirmasi hapus pendaftar dan notifikasi berhasil/gagal. |
| Versi terbaru pada saat pemeriksaan | **11.26.25**. |
| Versi terpasang di Capstone | **[ISI SESUDAH CEK]**; jika CDN, catat versi dari URL; jika npm, gunakan `npm ls sweetalert2 --depth=0`. |
| Alasan memilih | Dialog rapi dan konsisten, tombol konfirmasi/batal, lebih mudah dikustomisasi dibanding `window.confirm()` atau `window.alert()`. |
| Alternatif | API browser `window.confirm()` (tanpa dependensi tetapi tampilan terbatas), modal Bootstrap (tidak perlu library popup baru bila Bootstrap sudah dipakai), library Notyf untuk toast tertentu. |
| Lisensi | **MIT**; diperbolehkan untuk produk komersial tertutup dengan memenuhi persyaratan atribusi/pemberitahuan lisensi. |
| Rilis terbaru yang terverifikasi | **23 Mei 2026**, v11.26.25, tercatat dalam GitHub Releases. |
| Dependensi | **0 runtime dependencies** menurut npm. Ada `devDependencies` untuk mengembangkan/mengetes library itu sendiri; bukan berarti aplikasi harus memasang semua paket pengembangan tersebut. |
| Estimasi penghematan | Membangun dialog aksesibel/konsisten 2–3 jam dibanding integrasi 0,5–1 jam → penghematan kira-kira **1–2,5 jam** (estimasi ilustratif). |
| Risiko | Jangan menganggap popup JS sebagai pengganti validasi server, CSRF token, atau otorisasi. Jika JS tidak aktif atau popup gagal, aksi kritis tetap harus dilindungi server. |
| Keputusan | **Opsional dan direkomendasikan** untuk meningkatkan pengalaman pengguna, khususnya dialog hapus; hanya masukkan ke daftar 'digunakan' jika benar-benar terintegrasi. |

**Sumber resmi:**
- https://www.npmjs.com/package/sweetalert2
- https://github.com/sweetalert2/sweetalert2/releases
- https://raw.githubusercontent.com/sweetalert2/sweetalert2/v11.26.25/package.json
- https://sweetalert2.github.io/

### 4.3 PHP PDO (komponen bawaan, bukan package npm)

| Aspek | Hasil analisis |
| --- | --- |
| Nama/fungsi | PDO (PHP Data Objects) menyediakan API koneksi dan prepared statements ke database MySQL/MariaDB untuk proses CRUD. |
| Versi | Mengikuti versi **PHP yang terpasang**; isi output `php -v` dan pastikan ekstensi `pdo_mysql` aktif. Tidak ada versi paket npm terpisah. |
| Alasan | Konsistensi akses database dan dukungan prepared statements untuk menghindari SQL injection jika parameter digunakan dengan benar. |
| Alternatif | MySQLi (fitur MySQL spesifik), abstraksi database lain seperti Doctrine DBAL (menambah dependensi dan kompleksitas). |
| Lisensi | Ikuti ketentuan lisensi PHP sesuai **versi distribusi PHP** yang dipakai. Sejak PHP 8.6 lisensi proyek PHP diperbarui menjadi PHP License v4 / BSD-3-Clause; versi sebelumnya dapat membawa PHP License v3.01. Verifikasi dari paket PHP yang digunakan. |
| Rilis terakhir | Mengikuti rilis PHP; **[ISI VERSI PHP DAN TANGGAL RILIS DARI php.net/releases]**. |
| Dependency | Ekstensi PDO dan driver `pdo_mysql`, koneksi ke server MySQL/MariaDB. |
| Estimasi penghematan | **Tidak dinilai sebagai library pihak ketiga**; memakai API bawaan menghindari kebutuhan merancang lapisan koneksi sendiri. |
| Keputusan | **Dipakai dalam Capstone Hari 9**, verifikasi pada `config/database.php` dan `php -m`. |

Sumber: https://www.php.net/manual/en/book.pdo.php , https://www.php.net/license/ dan https://www.php.net/releases/

## 5. Pemeriksaan melalui npm — wajib dilaksanakan di komputer peserta

### 5.1 Perintah yang diminta lab

Buka terminal VS Code atau PowerShell. Jalankan **persis perintah tugas**:

```powershell
npm view bootstrap license version time.modified
npm view sweetalert2 license version
```

**Hasil verifikasi informasi publik pada 30 Oktober 2026:**

| Perintah | Field | Hasil yang terverifikasi secara daring | Hasil terminal saya |
| --- | --- | --- | --- |
| `npm view bootstrap license version time.modified` | `license` | `MIT` | **[TEMPEL HASIL]** |
| Sama | `version` | `5.3.8` (tag `latest` stabil) | **[TEMPEL HASIL]** |
| Sama | `time.modified` | **[ISI WAKTU TEPAT DARI TERMINAL; belum berhasil dieksekusi di lingkungan penyusun]** | **[TEMPEL HASIL]** |
| `npm view sweetalert2 license version` | `license` | `MIT` | **[TEMPEL HASIL]** |
| Sama | `version` | `11.26.25` | **[TEMPEL HASIL]** |

> `time.modified` menunjukkan waktu **metadata paket npm berubah**, tidak otomatis waktu terbit rilis stabil. Untuk melihat tanggal rilis suatu versi spesifik, gunakan `npm view bootstrap "time[5.3.8]"` dan `npm view sweetalert2 "time[11.26.25]"`.

### 5.2 Perintah tambahan (opsional, berguna untuk analisis)

```powershell
node -v
npm -v
npm view bootstrap dependencies peerDependencies --json
npm view sweetalert2 dependencies --json
npm view bootstrap dist-tags --json
npm view bootstrap "time[5.3.8]"
npm view sweetalert2 "time[11.26.25]"
```

Jika proyek menggunakan npm:

```powershell
npm ls bootstrap sweetalert2 --depth=0
```

Jika tidak ada `package.json`, hasil `npm ls` bisa kosong. Itu **bukan bukti library tidak digunakan** karena aplikasi PHP bisa menyertakan library melalui URL CDN atau berkas manual. Periksa HTML/PHP dan folder aset.

### 5.3 Rekam bukti

- **Bukti 1:** tangkapan layar terminal perintah Bootstrap.
- **Bukti 2:** tangkapan layar terminal perintah SweetAlert2.
- **Bukti 3:** tangkapan layar `package.json`/HTML/PHP yang menunjukkan library yang dipakai (jika ada).
- **Bukti 4:** catat tanggal akses npm/GitHub.

## 6. Contoh library yang tidak direkomendasikan untuk proyek baru: Moment.js

**Status:** Moment.js adalah **proyek legacy dalam mode maintenance**, bukan proyek mati total dan bukan bukti otomatis ada kerentanan. Tim resminya mengimbau agar aplikasi baru mempertimbangkan alternatif.

**Tanda-tandanya:** dokumentasi resmi menyebut *legacy/maintenance mode*, tidak menambah fitur baru, tidak mengubah API menjadi immutable, tidak berencana memperbaiki kelemahan terkait tree shaking / ukuran bundle, dan tidak mengembangkan versi mayor baru. Di dokumentasi, versi Moment yang dicantumkan ialah 2.30.1.

**Alternatif untuk kebutuhan tanggal di Capstone:**

1. **PHP `DateTimeImmutable`** untuk pemrosesan tanggal di server (tanpa library JS tambahan).
2. **`Intl.DateTimeFormat`** bawaan browser untuk menampilkan tanggal/waktu sederhana.
3. **Luxon** atau **date-fns** bila memerlukan operasi tanggal kompleks di JavaScript, setelah mengevaluasi versi/lisensinya sendiri.

**Keputusan:** tidak menambahkan Moment.js hanya untuk menampilkan tanggal pendaftaran; gunakan fitur bawaan kecuali ada kebutuhan khusus.

Sumber resmi: https://momentjs.com/docs/ dan https://momentjs.com/docs/#/-project-status/

## 7. Jawaban teori: kapan GPL bermasalah untuk aplikasi komersial tertutup?

**Jawaban:** GPL bukan larangan menjual aplikasi. Masalah dapat muncul ketika pengembang **menggabungkan kode/library GPL ke dalam satu karya turunan atau gabungan yang wajib tunduk pada GPL, lalu mendistribusikan aplikasi itu kepada pelanggan sambil ingin mempertahankan bagian gabungan tersebut sebagai kode tertutup**. Dalam keadaan yang terkena kewajiban GPL, penerima harus mendapatkan hak-hak GPL dan akses ke *corresponding source* sesuai ketentuannya; bukan cukup menyembunyikan kode lalu menjual aplikasinya.

**Perbedaan situasi:**

| Situasi | Dampak umum |
| --- | --- |
| Aplikasi komersial memakai library **MIT** seperti Bootstrap/SweetAlert2 | Umumnya kompatibel dengan closed-source, tetapi tetap harus mengikuti pemberitahuan hak cipta/lisensi. |
| Aplikasi menggabungkan kode berlisensi **GPL** dan **mendistribusikan** karya yang tercakup ke pelanggan | Kewajiban GPL dapat bertentangan dengan rencana mempertahankan karya gabungan itu sebagai closed-source. |
| Program GPL dimodifikasi tetapi **hanya dipakai internal** dalam satu organisasi, tanpa distribusi | GPL pada umumnya tidak mewajibkan publikasi kode sumber karena tidak didistribusikan. |
| Program **GPL server-side** dipakai sebagai layanan web, tanpa distribusi program | GPL biasa pada umumnya tidak otomatis mewajibkan pemberian kode sumber kepada pengguna web; **AGPL berbeda** dan dapat memicu kewajiban bagi pengguna yang berinteraksi melalui jaringan. |
| Dua aplikasi berdiri sendiri/terpisah | Tidak otomatis menjadi satu karya turunan; keterkaitan teknis dan ketentuan lisensi perlu dianalisis per kasus. |

**Contoh kasus:** Perusahaan menjual aplikasi desktop tertutup yang menyertakan dan menautkan library GPL sebagai bagian dari satu program. Jika gabungan itu tercakup dalam GPL dan didistribusikan, syarat GPL dapat mewajibkan penyediaan kode sumber gabungan kepada penerima. Alternatifnya pilih library permisif (MIT, BSD, Apache-2.0), gunakan opsi lisensi komersial yang sah bila tersedia, atau minta tinjauan hukum untuk kasus rumit.

**Catatan:** Ini pembahasan pendidikan, bukan nasihat hukum untuk semua skenario. Batas 'karya turunan', linking, plugin, LGPL, dan distribusi dapat bergantung pada situasi konkret.

Sumber GNU: https://www.gnu.org/licenses/gpl-faq.en.html

## 8. Kesimpulan dan keputusan akhir

Bootstrap 5.3.8 (MIT) sesuai untuk mempercepat halaman responsif; SweetAlert2 11.26.25 (MIT) sesuai sebagai opsional untuk konfirmasi dan notifikasi; PDO adalah fasilitas PHP yang sudah dipakai di Capstone, dengan driver `pdo_mysql` untuk MySQL/MariaDB. Tim harus mengutamakan **versi stabil**, memverifikasi library yang **benar-benar digunakan**, menyimpan catatan lisensi, serta memperlakukan hasil perintah terminal sebagai bukti terpisah dari informasi yang dibaca di web.

**Checklist pengumpulan:**

- [ ] File `docs/daftar-library.md` berada di dalam root Capstone Hari 9.
- [ ] Nama, kelas, dan tanggal diisi.
- [ ] Status penggunaan Bootstrap/SweetAlert2/komponen tambahan dicek dari proyek.
- [ ] Versi **terpasang** dan alternatif setiap library dijelaskan.
- [ ] Screenshot `npm view bootstrap license version time.modified` tersimpan.
- [ ] Screenshot `npm view sweetalert2 license version` tersimpan.
- [ ] Nilai `time.modified` nyata dari terminal ditempel ke Bagian 5.
- [ ] Contoh Moment.js dan pengganti dijelaskan.
- [ ] Jawaban lisensi GPL dan perbedaannya dengan AGPL lengkap.
- [ ] Perubahan dokumentasi di-commit ke Git jika diminta pengajar.

---

## Lampiran Lab 4 — DataTables pada Daftar Pendaftar (30 Oktober 2026)

| Aspek | Hasil analisis |
|---|---|
| Library | DataTables Core 1.13.8 dan integrasi Bootstrap 5 1.13.8 |
| Fungsi | Pencarian, urut kolom, pagination 10 baris/halaman, UI bahasa Indonesia |
| Alasan dipilih | Mempercepat pembuatan tabel interaktif tanpa merancang pencarian/sorting/paging JS dari nol |
| Alternatif | Paginasi PHP sisi server (Hari 9) untuk dataset besar; TanStack Table atau Tabulator untuk tabel interaktif lain |
| Lisensi | MIT untuk DataTables Core; boleh digunakan komersial, pertahankan pemberitahuan lisensi/copyright |
| Versi yang dipakai | 1.13.8 (dipatok untuk kompatibilitas dengan contoh Lab 3; **bukan** klaim versi paling baru pada 2026) |
| Rilis terakhir | DataTables modern memiliki rilis lebih baru; untuk tanggal rilis versi terbaru cek laman resmi/registry pada saat pengumpulan |
| Dependency | Implementasi 1.13.8 membutuhkan jQuery. Penggunaan tema Bootstrap 5 membutuhkan CSS Bootstrap dan file integrasi CSS/JS `dataTables.bootstrap5.*` |
| Bahasa | `https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json` |
| Estimasi penghematan | Manual pencarian/urut/paginasi di JS 4–8 jam vs integrasi DataTables 1–2 jam: **perkiraan** hemat 3–6 jam, bukan hasil pengukuran |
| Keputusan | **Gunakan client-side pada Capstone latihan** untuk ratusan sampai beberapa ribu baris, evaluasi kinerja dengan data nyata |
| Batasan | Semua baris dibaca dari DB dan dikirim ke browser; tidak sesuai untuk banyak data sensitif yang tidak boleh diterima pengguna, dan beban awal meningkat seiring jumlah data |
| Opsi skala besar | Kembalikan paginasi/searching SQL PHP dengan `LIMIT`/`OFFSET`, atau implementasikan `serverSide: true` + endpoint AJAX & pengolahan data server |

**Alasan pengambilan keputusan:** Capstone ini adalah sistem latihan dengan jumlah pendaftar relatif kecil, sehingga pencarian dan pagination di browser sederhana dan responsif. Ketika jumlah data terus membesar atau ada pembatasan akses per pengguna, pengambilan seluruh baris harus dievaluasi kembali. Mode `serverSide` DataTables **tidak cukup diaktifkan dengan mengubah satu nilai**: dibutuhkan endpoint PHP untuk menangani parameter `draw`, `start`, `length`, pencarian dan urutan, serta menghasilkan JSON yang sesuai.

**Sumber resmi:**
- https://datatables.net/manual/core/data/
- https://datatables.net/manual/core/server-side
- https://datatables.net/license/
- https://cdn.datatables.net/1.13.8/
- https://datatables.net/download/plug-ins/i18n/Indonesian.html
