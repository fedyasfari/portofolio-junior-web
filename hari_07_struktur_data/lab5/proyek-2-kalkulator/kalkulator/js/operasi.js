/** Operasi dasar kalkulator. Setiap fungsi bebas dari akses DOM. */
export function tambah(a, b) {
  return a + b;
}

export function kurang(a, b) {
  return a - b;
}

export function kali(a, b) {
  return a * b;
}

export function bagi(a, b) {
  if (b === 0) {
    throw new Error('Tidak bisa dibagi nol');
  }
  return a / b;
}

/**
 * Menghitung dua bilangan menggunakan operator yang dipilih.
 * @param {number} a Bilangan pertama.
 * @param {string} operator Salah satu +, -, *, /.
 * @param {number} b Bilangan kedua.
 * @returns {number} Hasil yang sudah dibulatkan untuk tampilan.
 */
export function hitung(a, operator, b) {
  if (!Number.isFinite(a) || !Number.isFinite(b)) {
    throw new TypeError('Masukkan dua angka yang valid');
  }

  let hasil;
  switch (operator) {
    case '+':
      hasil = tambah(a, b);
      break;
    case '-':
      hasil = kurang(a, b);
      break;
    case '*':
      hasil = kali(a, b);
      break;
    case '/':
      hasil = bagi(a, b);
      break;
    default:
      throw new Error('Operator tidak dikenal');
  }

  return Number(hasil.toFixed(10));
}
