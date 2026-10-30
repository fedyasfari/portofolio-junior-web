<?php
declare(strict_types=1);

/**
 * Membuat satu koneksi PDO yang dipakai ulang selama satu request.
 * Prepared statements menggunakan parameter, bukan gabungan string input.
 */
function getConnection(): PDO
{
    static $connection = null;

    if ($connection instanceof PDO) {
        return $connection;
    }

    $configPath = __DIR__ . '/config.php';
    if (!is_file($configPath)) {
        throw new RuntimeException(
            'config/config.php belum ada. Salin config.contoh.php menjadi config.php.'
        );
    }

    $config = require $configPath;
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=utf8mb4',
        $config['host'],
        $config['nama_db']
    );

    $connection = new PDO(
        $dsn,
        $config['user'],
        $config['sandi'],
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]
    );

    return $connection;
}
