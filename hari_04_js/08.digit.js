
const input = "1568";

if (
  input === null ||
  input.trim() === "" ||
  !Number.isSafeInteger(Number(input))
) {
  console.log("Input tidak valid.");
} else {
  let angka = Math.abs(Number(input));
  let jumlah = 0;

  while (angka > 0) {
    const digit = angka % 10;
    jumlah += digit;
    angka = Math.floor(angka / 10);
  }

  console.log(`Jumlah digit: ${jumlah}`);
}
