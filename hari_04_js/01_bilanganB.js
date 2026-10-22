
const input = 1111; // Tipe data Number

if (
  typeof input !== "number" ||
  !Number.isFinite(input) ||
  !Number.isInteger(input)
) {
  console.log("Input harus berupa bilangan bulat.");
} else {
  const angka = input;
  let jenis;
  let sifat;

  // Menentukan ganjil atau genap
  if (angka % 2 === 0) {
    jenis = "Genap";
  } else {
    jenis = "Ganjil";
  }

  // Menentukan positif, negatif, atau nol
  if (angka > 0) {
    sifat = "Positif";
  } else if (angka < 0) {
    sifat = "Negatif";
  } else {
    sifat = "Nol";
  }

  console.log(`Bilangan: ${angka}`);
  console.log(`Jenis: ${jenis}`);
  console.log(`Sifat: ${sifat}`);
}
