
/* =========================================
   LAB 2 - ARRAY DAN METHOD ARRAY
   ========================================= */

// 1. MENENTUKAN BATAS KELULUSAN
const BATAS_LULUS = 70;

// 2. MEMBUAT DATA PESERTA
const peserta = [
  {
    nama: "Andi",
    kelas: "A",
    nilai: 90,
    email: "andi@gmail.com"
  },
  {
    nama: "Budi",
    kelas: "B",
    nilai: 80,
    email: "budi@gmail.com"
  },
  {
    nama: "Citra",
    kelas: "A",
    nilai: 60,
    email: "citra@gmail.com"
  },
  {
    nama: "Dini",
    kelas: "B",
    nilai: 40,
    email: "dini@gmail.com"
  },
  {
    nama: "Eko",
    kelas: "A",
    nilai: 75,
    email: "eko@gmail.com"
  },
  {
    nama: "Fani",
    kelas: "B",
    nilai: 88,
    email: "fani@gmail.com"
  },
  {
    nama: "Gita",
    kelas: "A",
    nilai: 95,
    email: "gita@gmail.com"
  },
  {
    nama: "Hendra",
    kelas: "B",
    nilai: 70,
    email: "hendra@gmail.com"
  },
  {
    nama: "Intan",
    kelas: "A",
    nilai: 67,
    email: "intan@gmail.com"
  },
  {
    nama: "Joko",
    kelas: "B",
    nilai: 82,
    email: "joko@gmail.com"
  },
  {
    nama: "Kiki",
    kelas: "A",
    nilai: 90,
    email: "kiki@gmail.com"
  },
  {
    nama: "Lina",
    kelas: "B",
    nilai: 55,
    email: "lina@gmail.com"
  }
];

// 3. MEMBUAT FUNGSI DAFTAR NAMA PESERTA LULUS
function daftarNamaLulus(data) {
  return data
    .filter((orang) => orang.nilai >= BATAS_LULUS)
    .map((orang) => orang.nama);
}

// 4. MENJALANKAN FUNGSI
const hasilLulus = daftarNamaLulus(peserta);

// 5. MENAMPILKAN HASIL
console.log("===== DAFTAR PESERTA LULUS =====");
console.log(hasilLulus);

// 6. MENENTUKAN RATA-RATA NILAI PER KELAS
function rataRataPerKelas(data) {
  const hasil = {};

  const kelasUnik = [
    ...new Set(data.map((orang) => orang.kelas))
  ];

  for (const kelas of kelasUnik) {
    const nilaiKelas = data
      .filter((orang) => orang.kelas === kelas)
      .map((orang) => orang.nilai);

    const total = nilaiKelas.reduce(
      (jumlah, nilai) => jumlah + nilai, 0
    );

    hasil[kelas] = total / nilaiKelas.length;
  }

  return hasil;
}

// 7. MENAMPILKAN RATA-RATA NILAI PER KELAS
console.log("===== RATA-RATA NILAI PER KELAS =====");
console.log(rataRataPerKelas(peserta));


// 8. MENENTUKAN PESERTA DENGAN NILAI TERTINGGI
function pesertaNilaiTertinggi(data) {
  if (data.length === 0) return null;

  return data.reduce((tertinggi, orang) =>
    orang.nilai > tertinggi.nilai ? orang : tertinggi
  );
}

// 9. MENAMPILKAN PESERTA DENGAN NILAI TERTINGGI
console.log("===== PESERTA DENGAN NILAI TERTINGGI =====");
const terbaik = pesertaNilaiTertinggi(peserta);
console.log(terbaik.nama);
console.log(terbaik.nilai);


// 10. MENENTUKAN PESERTA DENGAN NILAI TERENDAH
function cariPeserta(data, kataKunci) {
  const kata = kataKunci.trim().toLowerCase();

  if (kata === '') return [];

  return data.filter((orang) =>
    orang.nama.toLowerCase().includes(kata)
  );
}

// 11. MENAMPILKAN PESERTA YANG NAMA MENGANDUNG "an"
console.log("===== PENCARIAN PESERTA =====");
const hasilCari = cariPeserta(peserta, 'an');
console.log(hasilCari.map((orang) => orang.nama));


// 12. MENENTUKAN PERINGKAT PESERTA BERDASARKAN NILAI
function daftarPeringkat(data) {
  return [...data]
    .sort((a, b) =>
      b.nilai - a.nilai || a.nama.localeCompare(b.nama)
    )
    .map((orang, indeks) => ({
      peringkat: indeks + 1,
      ...orang
    }));
}

// 13. MENAMPILKAN DAFTAR PERINGKAT PESERTA
console.log("===== DAFTAR PERINGKAT PESERTA =====");
const peringkat = daftarPeringkat(peserta);
console.log(peringkat.map((orang) => ({
  peringkat: orang.peringkat,
  nama: orang.nama,
  nilai: orang.nilai
})));


// 14. MENENTUKAN EMAIL UNIK PESERTA
const daftarEmail = [
  'andi@example.com',
  'budi@example.com',
  'andi@example.com',
  'citra@example.com',
  'budi@example.com'
];

// 15. MENENTUKAN EMAIL UNIK PESERTA
const emailUnik = [...new Set(daftarEmail)];
// catatan: const emailUnik = [...new Set(daftarEmail)]; ini sama dengan fungsi ini: function emailUnik(daftarEmail) { return [...new Set(daftarEmail)]; }

// 15. MENAMPILKAN EMAIL UNIK PESERTA
console.log("===== EMAIL UNIK PESERTA =====");
console.log(emailUnik);


// 16. PENGUJIAN FUNGSI
console.assert(
  daftarNamaLulus(peserta).length === 8,
  'Peserta lulus seharusnya 8'
);

console.assert(
  rataRataPerKelas(peserta).A === 79.5,
  'Rata-rata kelas A seharusnya 79.5'
);

console.assert(
  pesertaNilaiTertinggi(peserta).nama === 'Gita',
  'Gita seharusnya tertinggi'
);

console.assert(
  cariPeserta(peserta, 'aN').length === 3,
  'Pencarian aN harus menghasilkan 3 peserta'
);

console.assert(
  daftarPeringkat(peserta)[0].nama === 'Gita',
  'Peringkat pertama seharusnya Gita'
);