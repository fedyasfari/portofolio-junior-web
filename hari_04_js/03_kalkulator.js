
const input1 = "200";
const operator = "+";
const input2 = "-550";

if (
  input1 === null ||
  input2 === null ||
  operator === null ||
  input1.trim() === "" ||
  input2.trim() === "" ||
  !Number.isFinite(Number(input1)) ||
  !Number.isFinite(Number(input2))
) {
  console.log("Input angka tidak valid.");
} else {
  const a = Number(input1);
  const b = Number(input2);

  let hasil;
  let error = "";

  switch (operator.trim()) {
    case "+":
      hasil = a + b;
      break;
    case "-":
      hasil = a - b;
      break;
    case "*":
      hasil = a * b;
      break;
    case "/":
      if (b === 0) {
        error = "Tidak boleh membagi dengan nol.";
      } else {
        hasil = a / b;
      }
      break;
    default:
      error = "Operator tidak dikenal.";
  }

  if (error) {
    console.log(error);
  } else {
    console.log(`Hasil: ${hasil}`);
  }
}
