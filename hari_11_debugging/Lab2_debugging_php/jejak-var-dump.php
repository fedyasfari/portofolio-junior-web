<?php
declare(strict_types=1);

// Contoh penelusuran sesuai tugas: var_dump + print_r.
$nilai = ['Sari' => 90, 'Budi' => '68', 'Citra' => 82, 'Dewi' => 70];

echo '<pre>';
echo "1. Data awal:
";
print_r($nilai);

echo "
2. Cek tipe data satu per satu:
";
foreach ($nilai as $nama => $n) {
    echo "$nama: ";
    var_dump($n);
}

echo "
3. Lacak akumulasi nilai (angka dalam string tetap dapat dijumlahkan):
";
$total = 0;
foreach ($nilai as $nama => $n) {
    $total += $n;
    echo "Sesudah $nama, total = ";
    var_dump($total);
}

echo "
4. Bandingkan rata-rata salah dan benar:
";
var_dump($total / (count($nilai) - 1));
var_dump($total / count($nilai));

echo "
5. Cek nilai kelulusan tepat 70:
";
var_dump($nilai['Dewi'] > 70);
var_dump($nilai['Dewi'] >= 70);

echo "
6. Cek kunci Eko dengan aman:
";
var_dump(isset($nilai['Eko']));
var_dump($nilai['Eko'] ?? 'Data tidak ditemukan');
echo '</pre>';
