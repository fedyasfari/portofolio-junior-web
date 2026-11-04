# Daftar Library dan Keputusan Teknis — PBL Hari 10 Sprint 1

**Tanggal pemeriksaan sumber:** 2 November 2026. **Status versi terpasang:** hanya akan dapat dipastikan dari komputer setelah menjalankan npm/Composer. Versi di bawah adalah **versi yang ditetapkan pada kode Sprint 1**, bukan klaim semua library merupakan rilis teranyar.

| Library | Versi digunakan | Fungsi | Lisensi | Alternatif | Dependency | Rilis/status | Alasan dipilih |
|---|---|---|---|---|---|---|---|
| Bootstrap | 5.3.8 | UI responsif, navbar, form, tabel, alert | MIT | Tailwind CSS | Popper sudah dalam `bootstrap.bundle.min.js` untuk komponen yang memerlukannya | Dirilis 25-08-2025; Bootstrap 6 masih alpha (2-11-2026) | Komponen UI siap pakai, dokumentasi banyak |
| jQuery | 3.7.1 | Dependency DataTables 1.13.8 | MIT | JavaScript vanilla + DataTables 2/3 yang sesuai | - | Dirilis 28-08-2023; dipilih demi kompatibilitas latihan | Memenuhi kebutuhan DataTables 1.13.8 |
| DataTables Core + Bootstrap 5 | 1.13.8 | Cari, urut, paginasi tabel admin | MIT | Tabulator, Grid.js, pagination PHP | jQuery (versi 1.x), CSS Bootstrap dan JS/CSS integrasi DataTables | Versi 1.x lama, digunakan konsisten dengan Lab 4; tersedia versi lebih baru | Integrasi mudah; tabel interaktif tanpa manual JS |
| SweetAlert2 | 11.26.25 | Konfirmasi Hapus, toast sukses | MIT | Toastify + modal Bootstrap | Tidak ada dependency JS wajib | Rilis 23-05-2026 | Dialog responsif, cepat diimplementasikan |
| Dompdf | ^3.1 pada composer.json (rilis terverifikasi 3.1.6) | HTML ke PDF A5 | LGPL-2.1 | FPDF, TCPDF | PHP, ext-dom, ext-mbstring, php-font-lib, php-svg-lib, masterminds/html5 | Rilis 3.1.6 pada 20-07-2026; versi yang dipasang cek `composer show` | Template bukti menggunakan HTML + CSS, lebih mudah dirawat |

## Sumber dan referensi
- Bootstrap: https://blog.getbootstrap.com/2025/08/25/bootstrap-5-3-8/ ; https://www.npmjs.com/package/bootstrap
- jQuery: https://blog.jquery.com/2023/08/28/jquery-3-7-1-released-reliable-table-row-dimensions/
- DataTables: https://datatables.net/license/mit ; https://cdn.datatables.net/1.13.8/
- SweetAlert2: https://github.com/sweetalert2/sweetalert2/releases ; https://sweetalert2.github.io/
- Dompdf: https://packagist.org/packages/dompdf/dompdf ; https://github.com/dompdf/dompdf
- Composer: https://getcomposer.org/doc/01-basic-usage.md

## Pertimbangan desain

**Mengapa DataTables client-side?** Data praktikum diperkirakan puluhan–ratusan baris. Seluruh daftar dimuat satu kali, lalu pencarian, sorting, dan pagination berjalan tanpa reload. Untuk ribuan hingga puluhan ribu baris, perangkat lambat, serta kebutuhan akses data yang lebih ketat, evaluasi paginasi SQL atau DataTables mode server-side (`serverSide: true`) dengan endpoint AJAX dan pembatasan hak akses. Pastikan hanya admin yang boleh mengakses data lengkap.

**Mengapa Dompdf?** Bukti berisi judul, tabel identitas, nomor, dan tanggal, sehingga HTML/CSS lebih ringkas daripada menggambar posisi dengan FPDF. Alternatif FPDF lebih sederhana untuk dokumen sangat minimal dan kontrol koordinat manual. `isRemoteEnabled = false` mencegah Dompdf meminta aset eksternal pada proses pencetakan; CSS disimpan inline.

**Lisensi:** MIT umumnya mengizinkan pemakaian dan modifikasi komersial dengan kewajiban mempertahankan pemberitahuan hak cipta/lisensi. LGPL-2.1 memungkinkan penggunaan dalam perangkat lunak komersial dalam kondisi tertentu, tetapi kewajiban lisensi harus ditinjau bila mendistribusikan ulang library/modifikasi.

## Perkiraan waktu penghematan (estimasi, bukan eksperimen)

| Komponen | Tanpa library | Dengan library | Hemat estimasi |
|---|---:|---:|---:|
| UI Bootstrap | 5–9 jam | 1–2 jam | 4–7 jam |
| DataTables | 4–8 jam | 1–2 jam | 3–6 jam |
| SweetAlert2 | 1–3 jam | 0,5–1 jam | 0,5–2 jam |
| Dompdf | 5–10 jam | 1–3 jam | 4–7 jam |

## Pemeriksaan dependency dan keamanan aktual — ISI DI KOMPUTER

| Perintah | Tanggal & waktu | Hasil terminal | Tindak lanjut |
|---|---|---|---|
| `composer show dompdf/dompdf` | [isi] | [isi] | [isi] |
| `composer outdated` | [isi] | [isi] | [isi] |
| `composer audit` | [isi] | [isi] | [isi] |
| `composer licenses` | [isi] | [isi] | [isi] |
| `npm outdated` jika memiliki `package.json` | [isi / tidak berlaku] | [isi] | [isi] |

**Penting:** Aplikasi referensi ini memakai CDN untuk JS/CSS sehingga **tidak menggunakan npm di root**. Jika `npm outdated` dipanggil dari root tanpa `package.json`, hasilnya bukan audit empat CDN tersebut. Untuk evaluasi npm, gunakan folder percobaan Hari 10 yang memang memiliki `package.json`. Nilai audit tidak boleh diisi sebagai "aman" sebelum perintah nyata dijalankan.

## Manajemen versi dan Git
- **Versi CDN dipatok**, tidak `@latest`; perubahan versi harus diuji.
- `composer.json` menyatakan batas dependency, `composer.lock` harus dibuat dengan Composer lalu **di-commit**.
- `vendor/` dan `node_modules/` tetap di `.gitignore`.
- `config/config.php` berisi password DB + hash login dan **tidak boleh di-commit**.
