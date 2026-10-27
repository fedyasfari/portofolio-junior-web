import { ESLint } from 'eslint';
import { readFile, writeFile } from 'node:fs/promises';

const eslint = new ESLint();

// Snapshot Lab 4 berasal dari kode-buruk.js yang sebenarnya.
// Snapshot Proyek 2 adalah contoh awal simulasi, bukan hasil audit kode asli.
const awal = [
  {
    kelompok: 'Lab 4 (asli)',
    sumber: 'referensi-sebelum/kode-buruk.js.txt',
    namaVirtual: 'kode-buruk.js',
  },
  ...[
    'kalkulator/js/operasi.js',
    'kalkulator/js/app.js',
    'validator/js/aturan.js',
    'validator/js/app.js',
  ].map((nama) => ({
    kelompok: 'Proyek 2 (simulasi awal)',
    sumber: `referensi-sebelum/proyek-2-kalkulator/${nama}.txt`,
    namaVirtual: `proyek-2-kalkulator/${nama}`,
  })),
];

const akhir = [
  { kelompok: 'Lab 4 (asli)', lokasi: 'kode-bersih.js' },
  ...[
    'kalkulator/js/operasi.js',
    'kalkulator/js/app.js',
    'validator/js/aturan.js',
    'validator/js/app.js',
  ].map((nama) => ({ kelompok: 'Proyek 2 (simulasi awal)', lokasi: `proyek-2-kalkulator/${nama}` })),
];

function totalPesan(daftar) {
  return daftar.reduce(
    (jumlah, hasil) => ({
      error: jumlah.error + hasil.errorCount,
      warning: jumlah.warning + hasil.warningCount,
    }),
    { error: 0, warning: 0 },
  );
}

const baris = [];
for (const kelompok of ['Lab 4 (asli)', 'Proyek 2 (simulasi awal)']) {
  const hasilAwal = [];
  for (const file of awal.filter((item) => item.kelompok === kelompok)) {
    const isi = await readFile(file.sumber, 'utf8');
    // lintText memeriksa isi kode contoh tanpa menjadikannya .js yang ikut lint .
    hasilAwal.push(...(await eslint.lintText(isi, { filePath: file.namaVirtual })));
  }
  const lokasiAkhir = akhir.filter((item) => item.kelompok === kelompok).map((item) => item.lokasi);
  const hasilAkhir = await eslint.lintFiles(lokasiAkhir);
  baris.push({ kelompok, tahap: 'Sebelum', ...totalPesan(hasilAwal) });
  baris.push({ kelompok, tahap: 'Sesudah', ...totalPesan(hasilAkhir) });
}

console.table(baris);
const teks = [
  '# Hasil ESLint Lab 5',
  '',
  'Data diperoleh dengan ESLint terinstal di komputer yang menjalankan perintah `npm run laporan:lint`.',
  '',
  '| Kelompok | Tahap | Error | Warning |',
  '|---|---|---:|---:|',
  ...baris.map((item) => `| ${item.kelompok} | ${item.tahap} | ${item.error} | ${item.warning} |`),
  '',
  '**Penting:** Baris "Lab 4 (asli)" memakai snapshot dari `kode-buruk.js` pada Lab 4.',
  'Baris "Proyek 2 (simulasi awal)" memakai contoh kode sengaja bermasalah;',
  '**bukan pengukuran sebelum dari source Proyek 2 asli Anda**.',
  'Untuk laporan final atas proyek asli, gantilah snapshot simulasi dengan salinan kode asli kemudian jalankan lagi.',
  '',
].join('\n');
await writeFile('HASIL-LINT.md', teks, 'utf8');
console.log('Hasil disimpan ke HASIL-LINT.md');
