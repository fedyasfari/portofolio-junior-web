/**
 * LAB 3 — Pencarian dan Pengurutan (JavaScript ES Modules)
 * Semua fungsi pengurutan mengembalikan ARRAY BARU; input asli tidak diubah.
 * Pencarian mengembalikan indeks berbasis nol, atau -1 bila tidak ditemukan.
 */

/** O(n): bisa dipakai pada array yang belum terurut. */
export function cariLinear(data, target) {
  for (let i = 0; i < data.length; i++) {
    if (data[i] === target) return i;
  }
  return -1;
}

/** O(log n): data WAJIB sudah terurut menaik. Jika duplikat, indeks pertama. */
export function cariBiner(dataTerurut, target) {
  let kiri = 0;
  let kanan = dataTerurut.length - 1;
  let hasil = -1;

  while (kiri <= kanan) {
    const tengah = Math.floor((kiri + kanan) / 2);
    if (dataTerurut[tengah] === target) {
      hasil = tengah;
      kanan = tengah - 1; // terus cari ke kiri agar indeks pertama
    } else if (dataTerurut[tengah] < target) {
      kiri = tengah + 1;
    } else {
      kanan = tengah - 1;
    }
  }
  return hasil;
}

/**
 * Bubble Sort O(n^2) pada rata-rata/terburuk; O(n) untuk data sudah urut
 * berkat penghentian lebih awal. statistik opsional: { perbandingan: 0 }.
 * Penghitung hanya mencatat pembandingan NILAI, bukan pengecekan loop.
 */
export function bubbleSort(data, statistik = null) {
  const hasil = [...data];
  if (statistik) statistik.perbandingan = 0;

  for (let batas = hasil.length - 1; batas > 0; batas--) {
    let adaPertukaran = false;
    // Tepat 'batas' perbandingan NILAI berlangsung pada putaran ini.
    if (statistik) statistik.perbandingan += batas;

    for (let j = 0; j < batas; j++) {
      if (hasil[j] > hasil[j + 1]) {
        const sementara = hasil[j];
        hasil[j] = hasil[j + 1];
        hasil[j + 1] = sementara;
        adaPertukaran = true;
      }
    }
    if (!adaPertukaran) break;
  }
  return hasil;
}

/** Insertion Sort: O(n) jika sudah urut, O(n^2) rata-rata/terburuk. */
export function insertionSort(data, statistik = null) {
  const hasil = [...data];
  if (statistik) statistik.perbandingan = 0;

  for (let i = 1; i < hasil.length; i++) {
    const nilai = hasil[i];
    let j = i - 1;

    while (j >= 0) {
      // Hanya menghitung 'hasil[j] > nilai', bukan pemeriksaan j >= 0.
      if (statistik) statistik.perbandingan++;
      if (hasil[j] > nilai) {
        hasil[j + 1] = hasil[j];
        j--;
      } else {
        break;
      }
    }
    hasil[j + 1] = nilai;
  }
  return hasil;
}

/** Merge Sort: O(n log n) dalam semua kasus, tambahan memori O(n). */
export function mergeSort(data) {
  const hasil = [...data];
  const sementara = new Array(hasil.length);

  // Mengurutkan rentang [mulai, akhir) secara rekursif.
  function urutkan(mulai, akhir) {
    if (akhir - mulai <= 1) return; // kasus dasar rekursi
    const tengah = Math.floor((mulai + akhir) / 2);
    urutkan(mulai, tengah);
    urutkan(tengah, akhir);

    let i = mulai;
    let j = tengah;
    let k = mulai;
    while (i < tengah && j < akhir) {
      sementara[k++] = hasil[i] <= hasil[j] ? hasil[i++] : hasil[j++];
    }
    while (i < tengah) sementara[k++] = hasil[i++];
    while (j < akhir) sementara[k++] = hasil[j++];
    for (let pos = mulai; pos < akhir; pos++) hasil[pos] = sementara[pos];
  }

  urutkan(0, hasil.length);
  return hasil;
}

/** Data acak deterministik: hasil sama selama seed dan n sama. */
export function buatDataAcak(n, seed = 20261027) {
  if (!Number.isInteger(n) || n < 0) {
    throw new RangeError('Jumlah elemen harus bilangan bulat >= 0.');
  }
  let x = seed >>> 0;
  return Array.from({ length: n }, () => {
    x = (Math.imul(1664525, x) + 1013904223) >>> 0;
    return x % 1000000;
  });
}
