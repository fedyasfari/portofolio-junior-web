import { Worker } from 'node:worker_threads';
import { writeFileSync } from 'node:fs';

// npm run benchmark        : n=10.000 dan 100.000, pembatas aman 15 detik / metode
// npm run benchmark:cepat  : hanya n=10.000
// npm run benchmark:penuh  : tanpa batas 15 detik, khusus pengguna berpengalaman
const hanyaCepat = process.argv.includes('--cepat');
const tanpaBatas = process.argv.includes('--tanpa-batas');
const batasMs = tanpaBatas ? 0 : 15_000;
const ukuran = hanyaCepat ? [10_000] : [10_000, 100_000];
const algoritma = ['bubbleSort', 'mergeSort', 'Array.sort'];

/** Waktu penciptaan worker, pembentukan data, dan pengecekan tidak dihitung. */
function ukur(n, nama) {
  return new Promise((resolve, reject) => {
    const worker = new Worker(new URL('./benchmark-worker.js', import.meta.url), {
      workerData: { n, algoritma: nama, seed: 20261027 }
    });
    let selesai = false;
    const timer = batasMs > 0 ? setTimeout(() => {
      if (selesai) return;
      selesai = true;
      // Angka 15.000 bukan waktu akhir, melainkan batas tunggu untuk pekerjaan worker.
      worker.terminate();
      resolve({ waktuMs: null, valid: null, status: `> ${batasMs} ms (batas waktu)` });
    }, batasMs) : null;
    const bersihkan = () => { if (timer) clearTimeout(timer); };
    worker.on('message', msg => {
      if (selesai) return;
      selesai = true;
      bersihkan();
      resolve({ ...msg, status: 'SELESAI' });
    });
    worker.on('error', err => {
      if (selesai) return;
      selesai = true;
      bersihkan();
      reject(err);
    });
    worker.on('exit', code => {
      if (!selesai && code !== 0) {
        selesai = true;
        bersihkan();
        reject(new Error(`Worker ${nama} keluar dengan kode ${code}`));
      }
    });
  });
}

const hasil = [];
console.log('\nLAB 3 — BENCHMARK PENCARIAN DAN PENGURUTAN');
console.log('Dataset: integer acak yang sama untuk semua algoritma; seed = 20261027.');
console.log('Durasi: hanya fungsi sort (termasuk salin input); tidak termasuk verifikasi/pembuatan data/worker.');
console.log(batasMs ? `Batas aman: ${batasMs} ms per pengujian, proses dapat dihentikan bila terlampaui.` : 'PERINGATAN: tanpa batas waktu; Bubble Sort 100.000 acak dapat sangat lama.');
for (const n of ukuran) {
  for (const nama of algoritma) {
    console.log(`Mengukur ${nama} (n=${n.toLocaleString('id-ID')})...`);
    const r = await ukur(n, nama);
    hasil.push({ 'Jumlah data': n, Algoritma: nama, 'Waktu (ms)': r.waktuMs ?? '—', Status: r.status, Valid: r.valid === true ? 'YA' : r.valid === false ? 'TIDAK' : 'belum diverifikasi' });
  }
}
console.log('\nHASIL:');
console.table(hasil);
const csv = [['Jumlah data', 'Algoritma', 'Waktu (ms)', 'Status', 'Valid'].join(',')];
for (const r of hasil) csv.push([r['Jumlah data'],r.Algoritma,r['Waktu (ms)'],`"${r.Status}"`,r.Valid].join(','));
writeFileSync('hasil-benchmark.csv', csv.join('\n') + '\n');
const bentuk = (n, metode) => {
  const row = hasil.find(r => r['Jumlah data'] === n && r.Algoritma === metode);
  return typeof row['Waktu (ms)'] === 'number'
    ? row['Waktu (ms)'].toLocaleString('id-ID', {maximumFractionDigits:3})
    : row.Status;
};
const md = [
  '# Hasil Benchmark Lab 3',
  '',
  `Lingkungan: Node.js ${process.version}; data angka acak dengan seed 20261027.`,
  '',
  '| Jumlah data | bubbleSort (ms) | mergeSort (ms) | Array.sort (ms) |',
  '|---:|---:|---:|---:|',
  ...ukuran.map(n => `| ${n.toLocaleString('id-ID')} | ${bentuk(n,'bubbleSort')} | ${bentuk(n,'mergeSort')} | ${bentuk(n,'Array.sort')} |`),
  '',
  'Jika muncul "> 15000 ms (batas waktu)", itu artinya **belum selesai**, BUKAN hasil waktu yang tepat.',
  'Untuk mengukur penuh tanpa cutoff: `node benchmark.js --tanpa-batas` (mungkin sangat lama).',
  '',
  'Bubble Sort rata-rata O(n²), Merge Sort O(n log n), sedangkan Array.sort menggunakan optimasi bawaan JS.',
  ''
].join('\n');
writeFileSync('hasil-benchmark.md', md);
console.log('\nTabel disimpan: hasil-benchmark.csv dan hasil-benchmark.md');
console.log('Catatan: satu kali pengukuran rentan variasi; untuk penelitian gunakan beberapa ulangan.\n');
