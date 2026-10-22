
const inputBerat = "78";
const inputTinggi = "1.75";

if (
  inputBerat === null ||
  inputTinggi === null ||
  inputBerat.trim() === "" ||
  inputTinggi.trim() === "" ||
  !Number.isFinite(Number(inputBerat)) ||
  !Number.isFinite(Number(inputTinggi)) ||
  Number(inputBerat) <= 0 ||
  Number(inputTinggi) <= 0
) {
  console.log("Berat atau tinggi tidak valid.");
} else {
  const berat = Number(inputBerat);
  const tinggi = Number(inputTinggi);

  const bmi = berat / (tinggi * tinggi);

  let kategori;

  if (bmi < 18.5) {
    kategori = "Kurang";
  } else if (bmi < 25) {
    kategori = "Normal";
  } else if (bmi < 30) {
    kategori = "Lebih";
  } else {
    kategori = "Obesitas";
  }

  console.log(`BMI: ${bmi.toFixed(2)}`);
  console.log(`Kategori: ${kategori}`);
}
