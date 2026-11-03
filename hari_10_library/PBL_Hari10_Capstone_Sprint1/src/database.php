<?php
declare(strict_types=1);

function getConnection(): PDO
{
    static $pdo = null;
    if ($pdo instanceof PDO) return $pdo;
    global $config;
    $host = (string) ($config['db_host'] ?? '127.0.0.1');
    $port = (string) ($config['db_port'] ?? '3306');
    $db = (string) ($config['db_name'] ?? '');
    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
    try {
        $pdo = new PDO($dsn, (string) ($config['db_user'] ?? ''), (string) ($config['db_password'] ?? ''), [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        error_log('Koneksi DB gagal: ' . $e->getMessage());
        http_response_code(503);
        exit('Database tidak dapat diakses. Periksa XAMPP, konfigurasi, dan skema SQL.');
    }
}
