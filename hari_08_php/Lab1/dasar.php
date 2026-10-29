<?php
// LAB 1 - PHP Dasar
// Atur zona waktu supaya kalender sesuai waktu Indonesia Barat (WIB).
date_default_timezone_set('Asia/Jakarta');

// Bagian 1: variabel dan tipe data.
$nama = 'Andi';
$umur = 20;
$status = true;

// Bagian 4: contoh nilai ujian yang akan dikonversi dengan match.
$nilai = 85;
$grade = match (true) {
    $nilai >= 90 => 'A',
    $nilai >= 80 => 'B',
    $nilai >= 70 => 'C',
    $nilai >= 60 => 'D',
    default => 'E',
};

// Bagian 5: kalender dan nama hari berbahasa Indonesia.
$daftarHari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
$nomorHari = (int) date('w'); // 0=Minggu, 1=Senin, ..., 6=Sabtu.
$hariIni = $daftarHari[$nomorHari];
$tanggalHariIni = date('d-m-Y');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 1 - PHP Dasar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 24px; background: #f3f6fa; color: #172033; }
        main { max-width: 980px; margin: auto; }
        section { background: white; border: 1px solid #dbe3ed; border-radius: 10px; padding: 20px; margin-bottom: 18px; }
        h1 { margin-top: 0; }
        h2 { margin-top: 0; color: #184e8b; }
        table { border-collapse: collapse; width: 100%; margin-top: 12px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px; text-align: center; }
        th { background: #e9f1fc; }
        pre { background: #f1f5f9; padding: 12px; border-radius: 6px; white-space: pre-wrap; }
        .overflow { overflow-x: auto; }
        .hasil { font-size: 1.1rem; font-weight: bold; }
    </style>
</head>
<body>
<main>
    <h1>Lab 1 - PHP Dasar</h1>
    <p>Latihan variabel, perulangan, percabangan, match, dan kalender sederhana.</p>

    <section>
        <h2>1. Variabel dan var_dump()</h2>
        <p>Nama: <strong><?= htmlspecialchars($nama, ENT_QUOTES, 'UTF-8') ?></strong></p>
        <p>Umur: <strong><?= $umur ?> tahun</strong></p>
        <p>Status: <strong><?= $status ? 'Aktif' : 'Tidak aktif' ?></strong></p>

        <h3>Tipe data setiap variabel</h3>
        <p><code>$nama</code>:</p>
        <pre><?php var_dump($nama); ?></pre>
        <p><code>$umur</code>:</p>
        <pre><?php var_dump($umur); ?></pre>
        <p><code>$status</code>:</p>
        <pre><?php var_dump($status); ?></pre>
    </section>

    <section>
        <h2>2. Tabel perkalian 1 sampai 10</h2>
        <p>Perulangan <code>for</code> luar menentukan baris, <code>for</code> dalam menentukan kolom.</p>
        <div class="overflow">
            <table>
                <thead>
                    <tr>
                        <th scope="col">×</th>
                        <?php for ($kolom = 1; $kolom <= 10; $kolom++): ?>
                            <th scope="col"><?= $kolom ?></th>
                        <?php endfor; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($baris = 1; $baris <= 10; $baris++): ?>
                        <tr>
                            <th scope="row"><?= $baris ?></th>
                            <?php for ($kolom = 1; $kolom <= 10; $kolom++): ?>
                                <td><?= $baris * $kolom ?></td>
                            <?php endfor; ?>
                        </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <h2>3. Bilangan ganjil dan genap (1–20)</h2>
        <table>
            <thead><tr><th scope="col">Bilangan</th><th scope="col">Jenis</th></tr></thead>
            <tbody>
                <?php for ($angka = 1; $angka <= 20; $angka++): ?>
                    <tr>
                        <td><?= $angka ?></td>
                        <td><?= $angka % 2 === 0 ? 'Genap' : 'Ganjil' ?></td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>4. FizzBuzz (1–30)</h2>
        <p>Kelipatan 3: Fizz; kelipatan 5: Buzz; kelipatan keduanya: FizzBuzz.</p>
        <table>
            <thead><tr><th scope="col">Angka</th><th scope="col">Hasil</th></tr></thead>
            <tbody>
                <?php for ($angka = 1; $angka <= 30; $angka++): ?>
                    <?php
                    if ($angka % 15 === 0) {
                        $hasil = 'FizzBuzz';
                    } elseif ($angka % 3 === 0) {
                        $hasil = 'Fizz';
                    } elseif ($angka % 5 === 0) {
                        $hasil = 'Buzz';
                    } else {
                        $hasil = (string) $angka;
                    }
                    ?>
                    <tr><td><?= $angka ?></td><td><?= $hasil ?></td></tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </section>

    <section>
        <h2>5. Konversi nilai ke grade dengan match</h2>
        <p>Rentang: A = 90–100, B = 80–89, C = 70–79, D = 60–69, E = kurang dari 60.</p>
        <p class="hasil">Nilai <?= $nilai ?> mendapatkan grade <?= $grade ?>.</p>
        <p>Ubah nilai pada variabel <code>$nilai</code> di bagian awal berkas untuk mencoba grade lainnya.</p>
    </section>

    <section>
        <h2>6. Kalender sederhana (hari ini)</h2>
        <p class="hasil">Hari ini: <?= $hariIni ?>, <?= $tanggalHariIni ?></p>
        <p>Indeks dari <code>date('w')</code>: <?= $nomorHari ?> (0 = Minggu, 6 = Sabtu).</p>
        <p>Zona waktu: Asia/Jakarta (WIB).</p>
    </section>
</main>
</body>
</html>
