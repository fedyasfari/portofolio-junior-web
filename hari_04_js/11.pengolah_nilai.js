// PBL Hari 4 - Aplikasi Konsol Pengolah Nilai
// Node.js 18+ | Tanpa fungsi tambahan (refactor dikerjakan pada Hari 5)

const readline = require('node:readline/promises');
const { stdin: input, stdout: output } = require('node:process');

const NILAI_MIN = 0;
const NILAI_MAKS = 100;
const BATAS_LULUS = 70;
const BATAS_A = 85;
const BATAS_B = 70;
const BATAS_C = 55;

async function main() {
  const rl = readline.createInterface({ input, output });
  const daftarNama = [];
  const daftarNilai = [];
  let jalan = true;

  try {
    while (jalan) {
      console.log('\n===== PENGOLAH NILAI =====');
      console.log('1. Input nilai siswa');
      console.log('2. Tampilkan statistik');
      console.log('3. Tampilkan predikat per siswa');
      console.log('4. Keluar');
      const pilihan = (await rl.question('Pilih menu (1-4): ')).trim();

      switch (pilihan) {
        case '1': {
          const nama = (await rl.question('Nama siswa: ')).trim();
          if (nama === '') {
            console.log('Error: nama siswa tidak boleh kosong.');
            break;
          }

          const teksNilai = (await rl.question('Nilai (0-100): ')).trim();
          const nilai = Number(teksNilai);
          // Penting: Number('') adalah 0, sehingga input kosong perlu dicek tersendiri.
          if (
            teksNilai === '' ||
            Number.isNaN(nilai) ||
            !Number.isFinite(nilai) ||
            nilai < NILAI_MIN ||
            nilai > NILAI_MAKS
          ) {
            console.log('Error: nilai harus berupa angka 0-100.');
            break;
          }

          daftarNama.push(nama);
          daftarNilai.push(nilai);
          console.log(`Berhasil menyimpan ${nama} dengan nilai ${nilai}.`);
          break;
        }

        case '2': {
          if (daftarNilai.length === 0) {
            console.log('Belum ada data siswa. Pilih menu 1 terlebih dahulu.');
            break;
          }

          let jumlah = 0;
          let tertinggi = daftarNilai[0];
          let terendah = daftarNilai[0];
          let namaTertinggi = daftarNama[0];
          let namaTerendah = daftarNama[0];
          let jumlahLulus = 0;
          let jumlahTidakLulus = 0;
          let jumlahA = 0;
          let jumlahB = 0;
          let jumlahC = 0;
          let jumlahD = 0;

          for (let i = 0; i < daftarNilai.length; i++) {
            const nilai = daftarNilai[i];
            jumlah += nilai;

            if (nilai > tertinggi) {
              tertinggi = nilai;
              namaTertinggi = daftarNama[i];
            }
            if (nilai < terendah) {
              terendah = nilai;
              namaTerendah = daftarNama[i];
            }

            if (nilai >= BATAS_LULUS) jumlahLulus++;
            else jumlahTidakLulus++;

            if (nilai >= BATAS_A) jumlahA++;
            else if (nilai >= BATAS_B) jumlahB++;
            else if (nilai >= BATAS_C) jumlahC++;
            else jumlahD++;
          }

          const rataRata = jumlah / daftarNilai.length;
          console.log('\n--- STATISTIK KELAS ---');
          console.log(`Jumlah siswa : ${daftarNilai.length}`);
          console.log(`Rata-rata    : ${rataRata.toFixed(2)}`);
          console.log(`Tertinggi    : ${tertinggi} (${namaTertinggi})`);
          console.log(`Terendah     : ${terendah} (${namaTerendah})`);
          console.log(`Lulus        : ${jumlahLulus}`);
          console.log(`Tidak lulus  : ${jumlahTidakLulus}`);

          // Tantangan tambahan: bubble sort manual, tanpa Array.sort().
          // Array salinan digunakan supaya urutan input asli tidak berubah.
          const namaUrut = [...daftarNama];
          const nilaiUrut = [...daftarNilai];
          for (let i = 0; i < nilaiUrut.length - 1; i++) {
            for (let j = 0; j < nilaiUrut.length - 1 - i; j++) {
              if (nilaiUrut[j] < nilaiUrut[j + 1]) {
                const nilaiSementara = nilaiUrut[j];
                nilaiUrut[j] = nilaiUrut[j + 1];
                nilaiUrut[j + 1] = nilaiSementara;

                const namaSementara = namaUrut[j];
                namaUrut[j] = namaUrut[j + 1];
                namaUrut[j + 1] = namaSementara;
              }
            }
          }

          console.log('\n--- PERINGKAT (BUBBLE SORT) ---');
          for (let i = 0; i < nilaiUrut.length; i++) {
            console.log(`${i + 1}. ${namaUrut[i]} - ${nilaiUrut[i]}`);
          }

          console.log('\n--- HISTOGRAM BINTANG PER GRADE ---');
          const labelGrade = ['A', 'B', 'C', 'D'];
          const jumlahGrade = [jumlahA, jumlahB, jumlahC, jumlahD];
          for (let i = 0; i < labelGrade.length; i++) {
            console.log(`${labelGrade[i]} | ${'*'.repeat(jumlahGrade[i])} (${jumlahGrade[i]})`);
          }
          break;
        }

        case '3': {
          if (daftarNilai.length === 0) {
            console.log('Belum ada data siswa. Pilih menu 1 terlebih dahulu.');
            break;
          }

          console.log('\n--- PREDIKAT NILAI PER SISWA ---');
          for (let i = 0; i < daftarNama.length; i++) {
            const nilai = daftarNilai[i];
            let grade;
            if (nilai >= BATAS_A) grade = 'A';
            else if (nilai >= BATAS_B) grade = 'B';
            else if (nilai >= BATAS_C) grade = 'C';
            else grade = 'D';

            const status = nilai >= BATAS_LULUS ? 'Lulus' : 'Tidak Lulus';
            console.log(`${i + 1}. ${daftarNama[i]} | Nilai: ${nilai} | Grade: ${grade} | ${status}`);
          }
          break;
        }

        case '4':
          jalan = false;
          console.log('Terima kasih.');
          break;

        default:
          console.log('Pilihan tidak valid. Masukkan 1, 2, 3, atau 4.');
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
