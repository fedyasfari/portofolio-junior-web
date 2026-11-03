<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
hanyaPost(); cekCsrf();
unset($_SESSION['admin_login']);
session_regenerate_id(true);
setFlash('Anda telah keluar dari akun admin.', 'info');
alihkan('login.php');
