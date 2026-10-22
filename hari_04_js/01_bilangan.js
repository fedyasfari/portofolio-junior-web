
const input = "100";

if (
  input === null ||
  input.trim() === "" ||
  !Number.isInteger(Number(input))
) {
  console.log("10");
} else {
  const angka = Number(input);
  let jenis;
  let sifat;

  
  if (angka % 2 === 0) {
    jenis = "Genap";
  } else {
    jenis = "Ganjil";
  }

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
