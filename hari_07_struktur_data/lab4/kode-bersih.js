/** Persentase pajak yang ditambahkan pada harga (11%). */
export const PAJAK = 0.11;

/** Ambang batas minimal untuk masing-masing grade. */
export const BATAS_GRADE = Object.freeze({
  A: 85,
  B: 70,
  C: 55,
});

/** Nilai rata-rata yang memunculkan pesan "bagus" pada program asal. */
export const NILAI_PUJIAN = 80;

/**
 * Menghitung rata-rata daftar nilai numerik.
 * @param {number[]} daftarNilai - Daftar nilai yang akan dihitung.
 * @returns {number} Rata-rata, atau 0 jika array kosong.
 * @throws {TypeError} Jika input bukan array atau ada nilai bukan angka valid.
 */
export function hitungRataRata(daftarNilai) {
  if (!Array.isArray(daftarNilai)) {
    throw new TypeError('Daftar nilai harus berupa array.');
  }

  if (daftarNilai.length === 0) {
    return 0;
  }

  if (!daftarNilai.every((nilai) => typeof nilai === 'number' && Number.isFinite(nilai))) {
    throw new TypeError('Seluruh nilai harus berupa angka yang valid.');
  }

  const jumlah = daftarNilai.reduce((total, nilai) => total + nilai, 0);
  return jumlah / daftarNilai.length;
}

/**
 * Menentukan grade A, B, C, atau D berdasarkan nilai.
 * @param {number} nilai - Angka nilai yang dinilai.
 * @returns {'A' | 'B' | 'C' | 'D'} Grade nilai.
 * @throws {TypeError} Jika nilai bukan angka valid.
 */
export function tentukanGrade(nilai) {
  if (typeof nilai !== 'number' || !Number.isFinite(nilai)) {
    throw new TypeError('Nilai harus berupa angka yang valid.');
  }

  if (nilai >= BATAS_GRADE.A) return 'A';
  if (nilai >= BATAS_GRADE.B) return 'B';
  if (nilai >= BATAS_GRADE.C) return 'C';
  return 'D';
}

/**
 * Menghitung harga akhir setelah tambahan pajak 11%.
 * Menggantikan fungsi h() dan k() yang sebelumnya duplikat.
 * @param {number} harga - Harga awal, tidak boleh negatif.
 * @returns {number} Harga setelah pajak.
 * @throws {RangeError} Jika harga negatif atau bukan angka valid.
 */
export function hitungHargaDenganPajak(harga) {
  if (typeof harga !== 'number' || !Number.isFinite(harga) || harga < 0) {
    throw new RangeError('Harga harus berupa angka tidak negatif yang valid.');
  }

  // Sama seperti fungsi asal: hitung pajak, kemudian tambahkan ke harga awal.
  return harga + harga * PAJAK;
}
