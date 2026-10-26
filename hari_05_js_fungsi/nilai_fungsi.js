
const readline = require('readline/promises');
const { stdin: input, stdout: output } = require('process');

const BATAS_LULUS = 70;

/**
 * Menghitung rata-rata nilai siswa.
 * @param {number[]} daftar - Array nilai siswa.
 * @returns {number} Hasil rata-rata.
 */
function hitungRataRata(daftar) {
  if (daftar.length === 0) return 0;
  return daftar.reduce((jumlah, n) => jumlah + n, 0) / daftar.length;
}

/**
 * Mencari nilai tertinggi.
 * @param {number[]} daftar - Array nilai siswa.
 * @returns {number|null} Nilai tertinggi atau null.
 */
function cariTertinggi(daftar) {
  return daftar.length === 0 ? null : Math.max(...daftar);
}

/**
 * Mencari nilai terendah.
 * @param {number[]} daftar - Array nilai siswa.
 * @returns {number|null} Nilai terendah atau null.
 */
function cariTerendah(daftar) {
  return daftar.length === 0 ? null : Math.min(...daftar);
}

/**
 * Menentukan grade siswa.
 * @param {number} nilai - Nilai siswa.
 * @returns {'A'|'B'|'C'|'D'} Grade siswa.
 */
function tentukanGrade(nilai) {
  if (nilai >= 85) return 'A';
  if (nilai >= 70) return 'B';
  if (nilai >= 55) return 'C';
  return 'D';
}

/**
 * Menentukan status kelulusan.
 * @param {number} nilai - Nilai siswa.
 * @returns {string} Status kelulusan.
 */
function tentukanStatus(nilai) {
  return nilai >= BATAS_LULUS ? 'Lulus' : 'Tidak lulus';
}

/**
 * Memeriksa validitas nilai.
 * @param {number} nilai - Nilai yang diperiksa.
 * @returns {boolean} true jika valid, false jika tidak.
 */
function nilaiValid(nilai) {
  return Number.isFinite(nilai) && nilai >= 0 && nilai <= 100;
}

/**
 * Menampilkan menu program.
 * @returns {void}
 */
function tampilkanMenu() {
  console.log('\n===== PENGOLAH NILAI =====');
  console.log('1. Input nilai siswa');
  console.log('2. Tampilkan rata-rata, nilai tertinggi, dan terendah');
  console.log('3. Tampilkan predikat lulus/tidak lulus per siswa');
  console.log('4. Keluar');
}

/**
 * Menampilkan laporan nilai seluruh siswa.
 * @param {string[]} nama - Array nama siswa.
 * @param {number[]} nilai - Array nilai siswa.
 * @returns {void}
 */
function tampilkanLaporan(nama, nilai) {
  if (nilai.length === 0) {
    console.log('Belum ada data siswa. Silakan pilih menu 1.');
    return;
  }

  console.log('\n===== LAPORAN NILAI SISWA =====');

  for (let i = 0; i < nilai.length; i++) {
    console.log(
      `${i + 1}. ${nama[i]} | Nilai: ${nilai[i]} | ` +
      `Grade: ${tentukanGrade(nilai[i])} | ` +
      `Status: ${tentukanStatus(nilai[i])}`
    );
  }
}

// PENGUJIAN FUNGSI
console.assert(
  hitungRataRata([80, 90]) === 85,
  'rata-rata 80,90 harus 85'
);

console.assert(
  hitungRataRata([]) === 0,
  'rata-rata array kosong harus 0'
);

console.assert(
  tentukanGrade(85) === 'A',
  'nilai 85 harus A'
);

console.assert(
  tentukanGrade(69) === 'C',
  'nilai 69 harus C'
);

console.assert(
  nilaiValid(101) === false,
  '101 tidak valid'
);

/**
 * Menjalankan seluruh proses program.
 * @returns {Promise<void>}
 */
async function main() {
  const rl = readline.createInterface({ input, output });

  const daftarNama = [];
  const daftarNilai = [];

  let jalan = true;

  try {
    while (jalan) {
      tampilkanMenu();

      const pilihan = (
        await rl.question('Pilih menu (1-4): ')
      ).trim();

      switch (pilihan) {

        case '1': {
          const nama = (
            await rl.question('Nama siswa: ')
          ).trim();

          if (nama === '') {
            console.log('Nama tidak boleh kosong.');
            break;
          }

          const teksNilai = (
            await rl.question('Nilai (0-100): ')
          ).trim();

          const nilai = Number(teksNilai);

          if (teksNilai === '' || !nilaiValid(nilai)) {
            console.log('Nilai tidak valid. Masukkan angka 0 sampai 100.');
            break;
          }

          daftarNama.push(nama);
          daftarNilai.push(nilai);

          console.log(`Data ${nama} berhasil disimpan.`);
          break;
        }

        case '2': {
          if (daftarNilai.length === 0) {
            console.log('Belum ada data siswa. Silakan pilih menu 1.');
            break;
          }

          console.log('\n===== STATISTIK NILAI =====');
          console.log(`Jumlah siswa: ${daftarNilai.length}`);
          console.log(
            `Rata-rata: ${hitungRataRata(daftarNilai).toFixed(2)}`
          );
          console.log(
            `Nilai tertinggi: ${cariTertinggi(daftarNilai)}`
          );
          console.log(
            `Nilai terendah: ${cariTerendah(daftarNilai)}`
          );

          break;
        }

        case '3': {
          tampilkanLaporan(daftarNama, daftarNilai);
          break;
        }

        case '4': {
          jalan = false;
          console.log('Terima kasih.');
          break;
        }

        default:
          console.log('Pilihan tidak valid. Pilih angka 1 sampai 4.');
      }
    }
  } finally {
    rl.close();
  }
}

main().catch((error) => {
  console.error('Program berhenti:', error.message);
  process.exitCode = 1;
});
