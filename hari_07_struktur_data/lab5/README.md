# Lab 5 — ESLint dan Prettier (Hari 7)

## Penting tentang sumber kode

- `referensi-sebelum/kode-buruk.js.txt` adalah **salinan asli** kode buruk Lab 4 dari arsip praktikum sebelumnya.
- `kode-bersih.js` adalah **hasil refactor asli** Lab 4.
- `proyek-2-kalkulator/` adalah **versi latihan yang disusun sesuai persyaratan Proyek 2 Kalkulator dan Form Validator**; source JavaScript asli Proyek 2 tidak ada dalam berkas yang tersedia saat penyiapan ini.
- `referensi-sebelum/proyek-2-kalkulator/` berisi **contoh simulasi kode awal**, bukan versi lama Proyek 2 milik pengguna.

## Persiapan di VS Code

1. Extract ZIP, lalu File > Open Folder pilih `hari-07-lab5-eslint-prettier`.
2. Pastikan Node.js modern tersedia: `node -v`. ESLint v10 mensyaratkan Node ^20.19.0, ^22.13.0, atau >=24.
3. Jika mulai dari kosong, instruksi tugas `npm init -y` diperlukan. Pada ZIP ini `package.json` sudah tersedia sehingga **jangan jalankan npm init ulang**.
4. Jalankan `npm install` (akan memasang versi semver sesuai `package.json`). Atau untuk mengikuti soal persis, jalankan `npm install --save-dev eslint @eslint/js prettier`.
5. Jalankan `npm run lint`, `npm run format`, kemudian `npm run lint` lagi.
6. Jalankan `npm test` untuk menguji perilaku kode.
7. Jalankan `npm run laporan:lint` untuk menghasilkan angka **error dan warning yang benar dari ESLint lokal** ke `HASIL-LINT.md`.

### Perintah setara instruksi soal

```bash
npx eslint .
npx prettier --write .
```

## Memeriksa file buruk tanpa mencampuri proyek bersih

Snapshot kode buruk disimpan sebagai `.js.txt` sehingga `npx eslint .` pada versi akhir tetap dapat bersih.
`npm run laporan:lint` menggunakan ESLint API `lintText()` dengan nama virtual `.js` untuk menghitung baseline asli Lab 4 dan simulasi baseline Proyek 2; pengujian kode akhir memakai `lintFiles()`.

Jika ingin melihat error dari file buruk secara eksplisit, **salin** `referensi-sebelum/kode-buruk.js.txt` ke `kode-buruk.js` sementara, lalu:

```bash
npx eslint kode-buruk.js
```

Setelah mengamati temuan, pindahkan atau hapus salinan `kode-buruk.js` agar `npx eslint .` tidak lagi menemukan kode sengaja buruk. Jangan menghapus file referensi `.txt`.

## Menjalankan Proyek 2

1. Klik kanan `proyek-2-kalkulator/kalkulator/index.html` → Open with Live Server.
2. Uji tombol 0.1 + 0.2 =, C, pembagian nol, dan riwayat.
3. Buka `proyek-2-kalkulator/validator/index.html` melalui Live Server.
4. Uji nama/email/sandi salah, lalu masukkan data valid.

## Jika kesalahan muncul

- `Cannot find package '@eslint/js'`: pastikan `npm install` berhasil, **bukan** membuat file konfigurasi baru.
- `Cannot use import statement outside a module`: periksa `"type": "module"` di `package.json`.
- `process is not defined` atau `document is not defined`: tambahkan globals yang sesuai dengan lingkungan kode; jangan matikan `no-undef` untuk seluruh proyek.
- Jika menjalankan `npx prettier --write .`, Prettier **menulis ulang file**; pertimbangkan membuat salinan atau commit Git terlebih dahulu.
- ESLint tidak secara otomatis memperbaiki semua error; gunakan `npm run lint:fix` untuk yang aman, lalu perbaiki sisanya secara manual.

## Berkas hasil

- `LAPORAN.md`: template jawaban praktikum beserta ruang data dan penjelasan.
- `HASIL-LINT.md`: otomatis dihasilkan **setelah** `npm run laporan:lint` pada komputer pengguna (tidak diklaim ada sebelum dijalankan).
- `test/`: tes perilaku sebelum pengumpulan tugas.

Referensi resmi: https://eslint.org/docs/latest/use/getting-started dan https://prettier.io/docs/cli
