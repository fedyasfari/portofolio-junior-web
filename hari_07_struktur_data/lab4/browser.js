import {
  PAJAK,
  hitungRataRata,
  tentukanGrade,
  hitungHargaDenganPajak,
} from './kode-bersih.js';

const formulir = document.querySelector('#formulir');
const inputNilai = document.querySelector('#nilai');
const inputHarga = document.querySelector('#harga');
const areaHasil = document.querySelector('#hasil');
const tombolContoh = document.querySelector('#contoh');
const tombolReset = document.querySelector('#reset');

function bacaDaftarNilai(teks) {
  if (teks.trim() === '') return [];

  return teks.split(',').map((bagian) => {
    const angkaTeks = bagian.trim();
    if (angkaTeks === '' || !Number.isFinite(Number(angkaTeks))) {
      throw new TypeError('Masukkan angka yang dipisahkan koma, misalnya 80, 65, 90.');
    }
    return Number(angkaTeks);
  });
}

function tampilkanHasil(teks, kesalahan = false) {
  areaHasil.textContent = teks;
  areaHasil.classList.toggle('gagal', kesalahan);
}

function proses() {
  try {
    const daftarNilai = bacaDaftarNilai(inputNilai.value);
    const hargaTeks = inputHarga.value.trim();
    if (hargaTeks === '' || !Number.isFinite(Number(hargaTeks))) {
      throw new TypeError('Harga harus berupa angka yang valid.');
    }

    const harga = Number(hargaTeks);
    const rataRata = hitungRataRata(daftarNilai);
    const grade = tentukanGrade(rataRata);
    const hargaAkhir = hitungHargaDenganPajak(harga);
    const rupiah = new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });

    tampilkanHasil([
      `Daftar nilai   : [${daftarNilai.join(', ')}]`,
      `Jumlah data    : ${daftarNilai.length}`,
      `Rata-rata      : ${rataRata.toFixed(2)}`,
      `Grade          : ${grade}`,
      `Pajak          : ${PAJAK * 100}%`,
      `Harga awal     : ${rupiah.format(harga)}`,
      `Setelah pajak  : ${rupiah.format(hargaAkhir)}`,
    ].join('\n'));
  } catch (error) {
    tampilkanHasil(`Input tidak valid: ${error.message}`, true);
  }
}

formulir.addEventListener('submit', (event) => {
  event.preventDefault();
  proses();
});

tombolContoh.addEventListener('click', () => {
  inputNilai.value = '80, 65, 90';
  inputHarga.value = '100000';
  proses();
});

tombolReset.addEventListener('click', () => {
  formulir.reset();
  tampilkanHasil('Klik "Hitung" untuk melihat hasil.');
});

proses();
