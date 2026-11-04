<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(403); exit('Khusus terminal.'); }
require_once __DIR__ . '/../src/bootstrap.php';
$username = (string)($argv[1] ?? '');
$sandi = (string)($argv[2] ?? '');
if (!preg_match('/^[a-zA-Z0-9_.-]{3,50}$/', $username) || strlen($sandi) < 12) {
    fwrite(STDERR, "Cara: php database/buat-admin.php admin SandiKuat123\nUsername 3-50 karakter, password minimal 12 karakter.\n");
    exit(1);
}
$stmt = getConnection()->prepare('INSERT INTO admin (username, password_hash) VALUES (:u, :p)');
try {
    $stmt->execute(['u'=>$username, 'p'=>password_hash($sandi, PASSWORD_DEFAULT)]);
    echo "Admin dibuat.\n";
} catch (PDOException $e) {
    fwrite(STDERR, "Gagal membuat admin (mungkin username sudah ada).\n");
    exit(1);
}
