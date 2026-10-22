
const tinggi = 5;

// A. Segitiga bintang
console.log("SEGITIGA BINTANG");

for (let i = 1; i <= tinggi; i++) {
  let pola = "";

  for (let j = 1; j <= i; j++) {
    pola += "*";
  }

  console.log(pola);
}

// B. Piramida bintang
console.log("\nPIRAMIDA BINTANG");

for (let i = 1; i <= tinggi; i++) {
  let pola = "";

  for (let spasi = 1; spasi <= tinggi - i; spasi++) {
    pola += " ";
  }

  for (let j = 1; j <= 2 * i - 1; j++) {
    pola += "*";
  }

  console.log(pola);
}

// C. Persegi angka
console.log("\nPERSEGI ANGKA");

for (let i = 1; i <= tinggi; i++) {
  let pola = "";

  for (let j = 1; j <= tinggi; j++) {
    pola += j + " ";
  }

  console.log(pola);
}
