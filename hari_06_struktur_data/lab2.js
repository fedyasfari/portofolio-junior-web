
// ==========================================
// LAB 2 - MAP DAN SET
// ==========================================

// SOAL 1 - Frekuensi kata dengan Map
function hitungFrekuensiKata(kalimat) {
  const kataKata = kalimat
    .toLowerCase()
    .trim()
    .split(/\s+/)
    .filter(Boolean);

  const frekuensi = new Map();

  for (const kata of kataKata) {
    frekuensi.set(
      kata,
      (frekuensi.get(kata) ?? 0) + 1
    );
  }

  return [...frekuensi.entries()]
    .sort((a, b) => b[1] - a[1]);
}

console.log('=== SOAL 1 ===');

const kalimat = 'saya belajar web saya suka web';

console.log('Kalimat:', kalimat);

const hasilFrekuensi = hitungFrekuensiKata(kalimat);

console.table(
  hasilFrekuensi.map(([kata, jumlah]) => ({
    kata,
    jumlah
  }))
);


// SOAL 2 - Hilangkan duplikat email dengan Set
function hapusEmailDuplikat(email) {
  return [...new Set(email)];
}

console.log('=== SOAL 2 ===');

const daftarEmail = [
  'sari@gmail.com',
  'budi@gmail.com',
  'sari@gmail.com',
  'citra@gmail.com',
  'budi@gmail.com',
  'dewi@gmail.com'
];

console.log('Sebelum:', daftarEmail);

const emailUnik = hapusEmailDuplikat(daftarEmail);

console.log('Sesudah:', emailUnik);


// SOAL 3 - Irisan dua kelas menggunakan Set
function cariIrisan(kelasA, kelasB) {
  const setA = new Set(kelasA);
  const setB = new Set(kelasB);

  return [...setA].filter((nama) =>
    setB.has(nama)
  );
}

console.log('=== SOAL 3 ===');

const kelasA = ['Sari', 'Budi', 'Citra', 'Deni'];
const kelasB = ['Citra', 'Deni', 'Eka', 'Fajar'];

console.log('Kelas A:', kelasA);
console.log('Kelas B:', kelasB);

console.log(
  'Irisan:',
  cariIrisan(kelasA, kelasB)
);


// SOAL 4 - Deteksi duplikat dengan Set
function adaDuplikat(daftar) {
  return new Set(daftar).size !== daftar.length;
}

console.log('=== SOAL 4 ===');

console.log('Array kosong:', adaDuplikat([]));

console.log(
  'Satu elemen:',
  adaDuplikat(['Sari'])
);

console.log(
  'Elemen berulang:',
  adaDuplikat(['Sari', 'Budi', 'Sari'])
);

console.log(
  'Tanpa duplikat:',
  adaDuplikat(['Sari', 'Budi', 'Citra'])
);
