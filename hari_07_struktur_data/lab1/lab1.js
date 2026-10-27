import { LinkedList, LinkedQueue, Stack, Queue } from './structures.js';

// Penampung pesan pengujian (ditampilkan di halaman dan console).
const barisHasil = [];

function tulis(pesan) {
  barisHasil.push(pesan);
  console.log(pesan);
  const area = typeof document === 'undefined'
    ? null
    : document.getElementById('hasil');
  if (area) area.textContent = barisHasil.join('\n');
}

function cek(judul, kondisi) {
  if (!kondisi) {
    tulis('❌ GAGAL: ' + judul);
    throw new Error('Pengujian gagal: ' + judul);
  }
  tulis('✅ LULUS: ' + judul);
}

function samaArray(a, b) {
  return JSON.stringify(a) === JSON.stringify(b);
}

// -------------------------
// BAGIAN 2: UJI LINKEDLIST
// -------------------------
export function jalankanPengujian() {
  barisHasil.length = 0;
  tulis('=== PENGUJIAN LINKED LIST ===');

  // Kasus list kosong.
  const kosong = new LinkedList();
  cek('List baru kosong', kosong.isEmpty());
  cek('toArray() pada kosong menghasilkan []', samaArray(kosong.toArray(), []));
  cek('removeFirst() pada kosong menghasilkan undefined', kosong.removeFirst() === undefined);
  cek('find() pada kosong menghasilkan null', kosong.find(10) === null);
  cek('remove() pada kosong menghasilkan false', kosong.remove(10) === false);
  cek('head dan tail kosong adalah null', kosong.head === null && kosong.tail === null);

  // Kasus satu elemen.
  const tunggal = new LinkedList();
  tunggal.addFirst(10);
  cek('addFirst() pada list kosong', samaArray(tunggal.toArray(), [10]));
  cek('Head dan tail menunjuk node sama', tunggal.head === tunggal.tail);
  cek('removeFirst() mengembalikan elemen tunggal', tunggal.removeFirst() === 10);
  cek('Setelah elemen tunggal dihapus, list kosong lagi',
    tunggal.isEmpty() && tunggal.head === null && tunggal.tail === null);

  // Kasus banyak elemen dan pencarian.
  const daftar = new LinkedList();
  daftar.addLast(10);
  daftar.addLast(20);
  daftar.addLast(30);
  daftar.addFirst(5);
  cek('addFirst() dan addLast() membentuk urutan benar',
    samaArray(daftar.toArray(), [5, 10, 20, 30]));
  cek('find(20) mengembalikan node berisi 20', daftar.find(20)?.data === 20);
  cek('find(99) pada nilai tak ada menghasilkan null', daftar.find(99) === null);
  cek('size() menghitung empat elemen', daftar.size() === 4);
  cek('removeFirst() menghapus kepala',
    daftar.removeFirst() === 5 && samaArray(daftar.toArray(), [10, 20, 30]));

  // BAGIAN 3: uji remove(data) di kepala, tengah, ekor, tidak ada.
  cek('remove(10) menghapus kepala',
    daftar.remove(10) === true && samaArray(daftar.toArray(), [20, 30]));

  const tengah = new LinkedList();
  [10, 20, 30, 40].forEach((angka) => tengah.addLast(angka));
  cek('remove(20) menghapus node tengah',
    tengah.remove(20) === true && samaArray(tengah.toArray(), [10, 30, 40]));
  cek('remove(40) menghapus ekor serta memperbarui tail',
    tengah.remove(40) === true &&
    samaArray(tengah.toArray(), [10, 30]) && tengah.tail.data === 30);
  cek('remove(99) tidak mengubah list',
    tengah.remove(99) === false && samaArray(tengah.toArray(), [10, 30]));

  const duplikat = new LinkedList();
  [2, 3, 2].forEach((angka) => duplikat.addLast(angka));
  cek('remove(2) hanya menghapus kemunculan pertama',
    duplikat.remove(2) === true && samaArray(duplikat.toArray(), [3, 2]));

  const satuRemove = new LinkedList();
  satuRemove.addLast(7);
  cek('remove(7) untuk satu elemen mereset head dan tail',
    satuRemove.remove(7) === true && satuRemove.isEmpty() &&
    satuRemove.head === null && satuRemove.tail === null);

  // Pastikan dua kelas Hari 6 tersedia.
  const stack = new Stack();
  stack.push('A'); stack.push('B');
  cek('Stack: pop() mengikuti LIFO', stack.pop() === 'B' && stack.pop() === 'A');

  const queue = new Queue();
  queue.enqueue('A'); queue.enqueue('B');
  cek('Queue Hari 6: dequeue() mengikuti FIFO',
    queue.dequeue() === 'A' && queue.dequeue() === 'B');

  const linkedQueue = new LinkedQueue();
  linkedQueue.enqueue('A'); linkedQueue.enqueue('B');
  cek('LinkedQueue: dequeue() mengikuti FIFO',
    linkedQueue.dequeue() === 'A' && linkedQueue.dequeue() === 'B');
  cek('LinkedQueue: setelah habis head dan tail null',
    linkedQueue.head === null && linkedQueue.tail === null);

  tulis('=== SEMUA PENGUJIAN LULUS ===');
}

// Queue khusus eksperimen: sengaja memakai shift(), bukan Queue Hari 6.
class QueueShift {
  constructor() {
    this.items = [];
  }
  enqueue(data) {
    this.items.push(data);
  }
  dequeue() {
    return this.items.shift();
  }
}

// -------------------------------------
// BAGIAN 4: BENCHMARK 100.000 ELEMEN
// -------------------------------------
export function jalankanBenchmark() {
  const N = 100_000;
  const totalSeharusnya = (N * (N - 1)) / 2;

  // Kedua kelas mengerjakan tugas yang sama:
  // memasukkan angka 0..99.999 dan mengeluarkan semuanya.
  function ukur(nama, antrean) {
    let total = 0;
    console.time(nama);
    const mulai = performance.now();

    for (let i = 0; i < N; i++) antrean.enqueue(i);
    for (let i = 0; i < N; i++) total += antrean.dequeue();

    const durasi = performance.now() - mulai;
    console.timeEnd(nama);
    if (total !== totalSeharusnya) {
      throw new Error('Hasil antrean salah: ' + nama);
    }
    return Number(durasi.toFixed(2));
  }

  const waktuShift = ukur('Queue Array shift', new QueueShift());
  const waktuLinked = ukur('LinkedQueue', new LinkedQueue());
  const dataTabel = [
    { 'Struktur Data': 'Queue Array shift()', 'Jumlah Elemen': N, 'Waktu (ms)': waktuShift },
    { 'Struktur Data': 'LinkedQueue', 'Jumlah Elemen': N, 'Waktu (ms)': waktuLinked }
  ];
  console.table(dataTabel);
  tulis('=== HASIL BENCHMARK (100.000 ELEMEN) ===');
  tulis('Queue Array shift(): ' + waktuShift + ' ms');
  tulis('LinkedQueue:         ' + waktuLinked + ' ms');
  tulis('Perbandingan: ' + (waktuShift / waktuLinked).toFixed(2) + 'x');
  tulis('Catatan: waktu berbeda menurut komputer dan browser.');
  return dataTabel;
}

// Di browser: tombol memicu tes dan benchmark.
if (typeof document !== 'undefined') {
  document.getElementById('tombol-uji')?.addEventListener('click', jalankanPengujian);
  document.getElementById('tombol-benchmark')?.addEventListener('click', jalankanBenchmark);
}
