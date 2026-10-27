import { workerData, parentPort } from 'node:worker_threads';
import { performance } from 'node:perf_hooks';
import { bubbleSort, mergeSort, buatDataAcak } from './algoritma.js';

// Dijalankan dari benchmark.js pada worker thread sehingga Bubble Sort 100.000
// dapat dihentikan secara aman saat melampaui batas waktu pilihan pengguna.
const { n, algoritma, seed } = workerData;
const data = buatDataAcak(n, seed);
const pembanding = [...data].sort((a, b) => a - b);
const fungsi = {
  bubbleSort,
  mergeSort,
  'Array.sort': arr => [...arr].sort((a, b) => a - b)
}[algoritma];
if (!fungsi) throw new Error('Algoritma tidak dikenal');

// Pemanasan dilakukan di worker, tidak tercatat sebagai waktu ukur.
fungsi(buatDataAcak(250, 123));
const mulai = performance.now();
const hasil = fungsi(data);
const waktuMs = performance.now() - mulai;
let valid = hasil.length === pembanding.length;
if (valid) {
  for (let i = 0; i < hasil.length; i++) {
    if (hasil[i] !== pembanding[i]) { valid = false; break; }
  }
}
parentPort.postMessage({ waktuMs: Number(waktuMs.toFixed(3)), valid });
