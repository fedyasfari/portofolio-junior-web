
const rahasia = Math.floor(Math.random() * 100) + 1;

let tebakan;
let percobaan = 0;

do {
  const input = prompt("Tebak angka (1-100):");

  if (input === null) {
    console.log("Permainan dibatalkan.");
    break;
  }

  tebakan = Number(input);

  if (
    input.trim() === "" ||
    !Number.isInteger(tebakan) ||
    tebakan < 1 ||
    tebakan > 100
  ) {
    alert("Masukkan angka bulat 1-100!");
    continue;
  }

  percobaan++;

  if (tebakan < rahasia) {
    alert("Tebak lebih tinggi!");
  } else if (tebakan > rahasia) {
    alert("Tebak lebih rendah!");
  } else {
    alert(`Benar! ${percobaan} percobaan.`);
    console.log(`Angka rahasia: ${rahasia}`);
  }
} while (tebakan !== rahasia);
