<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Khusus terminal.'); }
require_once __DIR__ . '/../src/bootstrap.php';
$pdo = getConnection();
// TIDAK menghapus/mengubah data pendaftar yang sudah ada.
$pdo->exec('CREATE TABLE IF NOT EXISTS admin (
 id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50) NOT NULL UNIQUE,
 password_hash VARCHAR(255) NOT NULL, dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
$cek = $pdo->query("SHOW COLUMNS FROM kelas LIKE 'kuota'")->fetch();
if ($cek === false) {
    $pdo->exec('ALTER TABLE kelas ADD COLUMN kuota INT UNSIGNED NOT NULL DEFAULT 30');
    echo "Kolom kuota ditambahkan (default 30).\n";
} else {
    echo "Kolom kuota sudah tersedia.\n";
}
// Pastikan ada index yang membantu COUNT kelas_id
$cekIndex = $pdo->query("SHOW INDEX FROM pendaftar WHERE Column_name = 'kelas_id'")->fetch();
if ($cekIndex === false) $pdo->exec('CREATE INDEX idx_pendaftar_kelas ON pendaftar(kelas_id)');
echo "Migrasi Sprint 2 selesai. Verifikasi jumlah peserta vs kuota per kelas di phpMyAdmin.\n";
