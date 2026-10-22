
const input = "100";

if (
  input === null ||
  input.trim() === "" ||
  !Number.isFinite(Number(input)) ||
  Number(input) <= 0
) {
  console.log("Lama parkir tidak valid.");
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
