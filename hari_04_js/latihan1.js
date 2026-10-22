//deklarasi variabel
const nama = "Fedy";
let umur = 45;
const tinggiBadan = 1.80;
let statusAktif = true;

console.log(`Halo: ${nama}`);
console.log(`Umur: ${umur} tahun`);
console.log(`Tinggi badan: ${tinggiBadan} m`);
console.log(`Status aktif: ${statusAktif}`);

//cek tipe data 1
console.log(typeof "Halo");
console.log(typeof 25);
console.log(typeof true);
console.log(typeof undefined);
console.log(typeof { kota: "Solo" });

//cek tipe data 2
console.log(typeof ('5' + 3));
console.log(typeof (0.1 + 0.2));
console.log(typeof (Number('abc')));
console.log(typeof (10 / 3));
console.log(typeof (10 % 3));
console.log(typeof (2 ** 10));

//hitung keliling lingkaran
const phi = 3.14;
let jariJari = 10;
let kelilingLingkaran = 2 * phi * jariJari;
console.log(`Keliling lingkaran dengan jari-jari ${jariJari} cm adalah ${kelilingLingkaran} cm`);

//hitung luas lingkaran
let luasLingkaran = phi * jariJari ** 10;
console.log(`Luas lingkaran dengan jari-jari ${jariJari} cm adalah ${luasLingkaran} cm^2`);

//hitung luas dan keliling lingkaran 1
let jariJari2 = 20;
let kelilingLingkaran2 = 2 * phi * jariJari2;
let luasLingkaran2 = phi * jariJari2 ** 2;
console.log(`Keliling lingkaran dengan jari-jari ${jariJari2} cm adalah ${kelilingLingkaran2} cm`);
console.log(`Luas lingkaran dengan jari-jari ${jariJari2} cm adalah ${luasLingkaran2} cm^2`);

//hitung luas dan keliling lingkaran 2
let jariJari3= 10;
let luaslingkaran3 = Math.PI * jariJari3 ** 2;
console.log(`Luas lingkaran dengan jari-jari ${jariJari3} cm adalah ${luaslingkaran3} cm^2`);
let kelilinglingkaran3 = 2 * Math.PI * jariJari3;
console.log(`Keliling lingkaran dengan jari-jari ${jariJari3} cm adalah ${kelilinglingkaran3} cm`);
//harus bener tulisnya >> Math.PI atau phi = 3.14, karena Math.PI adalah nilai konstanta dari pi yang lebih akurat daripada phi = 3.14

//hitung jumlah detik dalam satu hari
const jamPerHari = 24;
const menitPerJam = 60;
const detikPerMenit = 60;

const totalDetik =
  jamPerHari * menitPerJam * detikPerMenit;

console.log(`Total detik: ${totalDetik}`);


//Konversi suhu Celsius ke Fahrenheit
const suhuCelsius = 30;

const fahrenheit = suhuCelsius * 9 / 5 + 32;

console.log(`${suhuCelsius}°C = ${fahrenheit}°F`);


//Tarif Parkir
const input = ("2 (jam):");

if (
  input === null ||
  input.trim() === "" ||
  !Number.isFinite(Number(input)) ||
  Number(input) <= 0
) {
  console.log("error.");
} else {
  const lama = Math.ceil(Number(input));

  const hariPenuh = Math.floor(lama / 24);
  const sisaJam = lama % 24;

  let biayaSisa = 0;

  if (sisaJam > 0 && sisaJam <= 2) {
    biayaSisa = 3000;
  } else if (sisaJam > 2) {
    biayaSisa = 3000 + (sisaJam - 2) * 2000;
  }

  if (biayaSisa > 15000) {
    biayaSisa = 15000;
  }

  const total = hariPenuh * 15000 + biayaSisa;

  console.log(`Lama tagihan: ${lama} jam`);
  console.log(`Biaya: Rp${total.toLocaleString("id-ID")}`);
}
