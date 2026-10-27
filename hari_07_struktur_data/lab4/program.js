// Jalankan: npm start atau node program.js
import {
  NILAI_PUJIAN,
  PAJAK,
  hitungRataRata,
  tentukanGrade,
  hitungHargaDenganPajak,
} from './kode-bersih.js';

const daftarNilai = [80, 65, 90];
const rataRata = hitungRataRata(daftarNilai);
const grade = tentukanGrade(rataRata);
const hargaAwal = 100_000;
const hargaAkhir = hitungHargaDenganPajak(hargaAwal);

console.log('=== HASIL KODE BERSIH ===');
console.log('Daftar nilai:', daftarNilai);
console.log('Rata-rata:', rataRata.toFixed(2));

// Mempertahankan perilaku kondisi "bagus" dari kode awal.
if (rataRata === NILAI_PUJIAN) {
  console.log('bagus');
}

console.log('Grade:', grade);
console.log('Pajak:', `${PAJAK * 100}%`);
console.log('Harga awal:', hargaAwal);
console.log('Harga setelah pajak:', hargaAkhir);
