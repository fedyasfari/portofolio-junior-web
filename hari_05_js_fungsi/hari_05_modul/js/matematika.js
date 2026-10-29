
/**
 * Menghitung rata-rata dari kumpulan nilai.
 * @param {number[]} daftar - Array nilai siswa.
 * @returns {number} Hasil rata-rata.
 */
export function hitungRataRata(daftar) {
  if (daftar.length === 0) return 0;

  return daftar.reduce(
    (jumlah, nilai) => jumlah + nilai, 0
  ) / daftar.length;
}

/**
 * Mencari nilai tertinggi.
 * @param {number[]} daftar - Array nilai siswa.
 * @returns {number|null} Nilai tertinggi.
 */
export function cariTertinggi(daftar) {
  return daftar.length === 0
    ? null
    : Math.max(...daftar);
}

/**
 * Mencari nilai terendah.
 * @param {number[]} daftar - Array nilai siswa.
 * @returns {number|null} Nilai terendah.
 */
export function cariTerendah(daftar) {
  return daftar.length === 0
    ? null
    : Math.min(...daftar);
}
