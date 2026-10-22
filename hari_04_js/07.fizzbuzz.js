
for (let angka = 1; angka <= 50; angka++) {
  if (angka % 3 === 0 && angka % 5 === 0) {
    console.log("FizzBuzz");
  } else if (angka % 3 === 0) {
    console.log("Fizz");
  } else if (angka % 5 === 0) {
    console.log("Buzz");
  } else {
    console.log(angka);
  }
}
