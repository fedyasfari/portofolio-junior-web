import { hitungRataRata, tentukanGrade, hitungHargaDenganPajak } from './kode-bersih.js';

const daftarNilai = [80, 65, 90];
const rataRata = hitungRataRata(daftarNilai);
console.log('=== Lab 5: Hasil Refactor Lab 4 ===');
console.log('Rata-rata:', rataRata.toFixed(2));
console.log('Grade:', tentukanGrade(rataRata));
console.log('Harga setelah pajak:', hitungHargaDenganPajak(100000));
