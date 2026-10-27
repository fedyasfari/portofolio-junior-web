/** Mengembalikan pesan kesalahan atau string kosong jika valid. */
export function validasiNama(nilai) {
  return nilai.trim().length >= 3 ? '' : 'Nama minimal 3 karakter.';
}

export function validasiEmail(nilai) {
  const pola = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return pola.test(nilai) ? '' : 'Format email tidak valid.';
}

export function validasiSandi(nilai) {
  return nilai.length >= 8 && /[A-Za-z]/.test(nilai) && /[0-9]/.test(nilai)
    ? ''
    : 'Kata sandi minimal 8 karakter, harus ada huruf dan angka.';
}

export function validasiKonfirmasi(sandi, konfirmasi) {
  return sandi === konfirmasi && konfirmasi !== ''
    ? ''
    : 'Konfirmasi kata sandi tidak sama.';
}
