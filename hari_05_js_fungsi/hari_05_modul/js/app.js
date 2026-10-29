
// 1. IMPORT FUNGSI DARI MATEMATIKA.JS
import {
  hitungRataRata,
  cariTertinggi,
  cariTerendah
} from './matematika.js';

// 2. MENGAMBIL ELEMEN HTML
const form = document.getElementById('form-nilai');
const inputNilai = document.getElementById('input-nilai');
const pesan = document.getElementById('pesan');
const hasil = document.getElementById('hasil');

const daftarNilai = document.getElementById('daftar-nilai');
const hasilRataRata = document.getElementById('hasil-rata-rata');
const hasilTertinggi = document.getElementById('hasil-tertinggi');
const hasilTerendah = document.getElementById('hasil-terendah');

// 3. FUNGSI UNTUK MENGOLAH INPUT NILAI
function olahNilai(event) {

  // Mencegah halaman refresh
  event.preventDefault();

  // Bersihkan pesan sebelumnya
  pesan.textContent = '';
  hasil.hidden = true;

  // Ambil teks dari input
  const teks = inputNilai.value.trim();

  if (teks === '') {
    pesan.textContent = 'Masukkan nilai terlebih dahulu.';
    return;
  }

  // 4. MEMISAHKAN NILAI BERDASARKAN KOMA
  const bagian = teks
    .split(',')
    .map((item) => item.trim());

  // Cek apakah ada input kosong
  if (bagian.some((item) => item === '')) {
    pesan.textContent = 'Ada nilai yang kosong.';
    return;
  }

  // Mengubah teks menjadi angka
  const nilai = bagian.map((item) => Number(item));

  // 5. VALIDASI ANGKA
  if (nilai.some((angka) => !Number.isFinite(angka))) {
    pesan.textContent = 'Masukkan angka yang valid.';
    return;
  }

  // 6. MENGGUNAKAN FUNGSI HASIL IMPORT
  const rataRata = hitungRataRata(nilai);
  const tertinggi = cariTertinggi(nilai);
  const terendah = cariTerendah(nilai);

  // 7. MENAMPILKAN HASIL KE HTML
  daftarNilai.textContent = nilai.join(', ');
  hasilRataRata.textContent = rataRata.toFixed(2);
  hasilTertinggi.textContent = tertinggi;
  hasilTerendah.textContent = terendah;

  hasil.hidden = false;
}

// 8. MENJALANKAN FUNGSI SAAT FORM DIKIRIM
form.addEventListener('submit', olahNilai);
