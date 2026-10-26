
// ========================================
// LAB 5 - MENGUKUR EFISIENSI
// ========================================

import { performance } from 'node:perf_hooks';
import { Queue } from './structures.js';

const N = 100000;
const angka = Array.from(
  { length: N },
  (_, i) => i
);

const himpunan = new Set(angka);
const JUMLAH_UJI = 3;

const hasil = {
  includes: [],
  has: [],
  shift: [],
  dequeue: []
};

// Fungsi stopwatch
function ukurWaktu(fungsi) {
  const mulai = performance.now();
  fungsi();
  const selesai = performance.now();

  return selesai - mulai;
}

// Ulangi seluruh pengujian 3 kali
for (let uji = 1; uji <= JUMLAH_UJI; uji++) {

  console.log(`=== PENGUJIAN ${uji} ===`);

  // 1. Array.includes x 1000
  const waktuIncludes = ukurWaktu(() => {
    let ditemukan = 0;

    for (let i = 0; i < 1000; i++) {
      if (angka.includes(N - 1)) ditemukan++;
    }

    if (ditemukan !== 1000) {
      throw new Error('Pencarian Array gagal');
    }
  });

  hasil.includes.push(waktuIncludes);

  // 2. Set.has x 1000
  const waktuHas = ukurWaktu(() => {
    let ditemukan = 0;

    for (let i = 0; i < 1000; i++) {
      if (himpunan.has(N - 1)) ditemukan++;
    }

    if (ditemukan !== 1000) {
      throw new Error('Pencarian Set gagal');
    }
  });

  hasil.has.push(waktuHas);

  // 3. Array.shift hingga kosong
  const arr = [...angka];

  const waktuShift = ukurWaktu(() => {
    while (arr.length > 0) {
      arr.shift();
    }
  });

  hasil.shift.push(waktuShift);

  // 4. Queue.dequeue hingga kosong
  const q = new Queue();

  for (let i = 0; i < N; i++) {
    q.enqueue(i);
  }

  const waktuDequeue = ukurWaktu(() => {
    while (!q.isEmpty()) {
      q.dequeue();
    }
  });

  hasil.dequeue.push(waktuDequeue);

  console.log('Array.includes:', waktuIncludes.toFixed(3), 'ms');
  console.log('Set.has:', waktuHas.toFixed(3), 'ms');
  console.log('Array.shift:', waktuShift.toFixed(3), 'ms');
  console.log('Queue.dequeue:', waktuDequeue.toFixed(3), 'ms');
  console.log('');
}

// Menghitung rata-rata
function rataRata(daftar) {
  const total = daftar.reduce(
    (jumlah, nilai) => jumlah + nilai, 0
  );

  return (total / daftar.length).toFixed(3);
}

// Menampilkan tabel ringkasan
console.log('=== HASIL RATA-RATA ===');

console.table([
  {
    operasi: 'Array.includes x1000',
    waktu: rataRata(hasil.includes),
    bigO: 'O(n) per pencarian'
  },
  {
    operasi: 'Set.has x1000',
    waktu: rataRata(hasil.has),
    bigO: 'O(1) rata-rata'
  },
  {
    operasi: 'Array.shift hingga kosong',
    waktu: rataRata(hasil.shift),
    bigO: 'O(n) per operasi'
  },
  {
    operasi: 'Queue.dequeue hingga kosong',
    waktu: rataRata(hasil.dequeue),
    bigO: 'O(1) per operasi'
  }
]);
