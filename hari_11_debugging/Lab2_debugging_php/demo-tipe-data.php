<?php
declare(strict_types=1);

// Buktikan perbedaan string numerik dan string bukan numerik.
echo '<pre>';
$nilaiString = '68';
var_dump($nilaiString);     // string(2) "68"
var_dump(0 + $nilaiString); // int(68), tanpa TypeError di PHP 8

try {
    $bukanAngka = 'enam puluh delapan';
    var_dump(0 + $bukanAngka);
} catch (TypeError $e) {
    echo 'Contoh TypeError nyata: ' . $e->getMessage() . "
";
}
echo '</pre>';
