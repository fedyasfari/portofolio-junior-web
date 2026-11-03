<?php
// Jalankan di terminal: C:\xampp\php\php.exe tools\buat-hash-password.php
// Hash saja yang disalin ke config/config.php, bukan password mentah.
if (PHP_SAPI !== 'cli') {http_response_code(403);exit('Hanya untuk terminal.');}
echo "Ketik password admin baru (terlihat di terminal): ";
$password = trim((string) fgets(STDIN));
if (strlen($password) < 5) {fwrite(STDERR,"Gunakan minimal 12 karakter.\n");exit(1);}
echo "\nSalin hash ini ke admin_password_hash pada config/config.php:\n";
echo password_hash($password, PASSWORD_DEFAULT), "\n";
