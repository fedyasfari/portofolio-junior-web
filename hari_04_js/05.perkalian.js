
for (let baris = 1; baris <= 10; baris++) {
  let hasilBaris = "";

  for (let kolom = 1; kolom <= 10; kolom++) {
    let hasil = baris * kolom;
    hasilBaris += hasil + "\t";
  }

  console.log(hasilBaris);
}
