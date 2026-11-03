<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
if (sudahLogin()) alihkan('index.php');
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    $now = time();
    $tries = $_SESSION['login_tries'] ?? ['count' => 0, 'since' => $now];
    if ($now - (int) $tries['since'] > 900) $tries = ['count' => 0, 'since' => $now];
    if ((int) $tries['count'] >= 5) {
        $error = 'Terlalu banyak percobaan. Coba lagi setelah 15 menit.';
    } else {
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        $hash = (string) ($config['admin_password_hash'] ?? '');
        if ($hash !== '' && hash_equals((string) ($config['admin_email'] ?? ''), $email)
            && password_verify($password, $hash)) {
            session_regenerate_id(true);
            $_SESSION['admin_login'] = true;
            $_SESSION['login_tries'] = ['count' => 0, 'since' => $now];
            setFlash('Berhasil masuk sebagai admin.', 'success');
            alihkan('index.php');
        }
        $_SESSION['login_tries'] = ['count' => (int) $tries['count'] + 1, 'since' => (int) $tries['since']];
        $error = 'Email atau password salah, atau akun admin belum dikonfigurasi.';
    }
}
$judul = 'Login Admin';
require __DIR__ . '/../templates/header.php';
?>
<div class="row justify-content-center"><div class="col-md-6 col-lg-5">
  <div class="card shadow-sm border-0"><div class="card-body p-4">
    <h1 class="h4 mb-3">Login Admin</h1>
    <?php if ($error): ?><div class="alert alert-danger" role="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
      <div class="mb-3"><label for="email" class="form-label">Email admin</label>
        <input class="form-control" type="email" id="email" name="email" autocomplete="username" required></div>
      <div class="mb-3"><label for="password" class="form-label">Password</label>
        <input class="form-control" type="password" id="password" name="password" autocomplete="current-password" required></div>
      <button class="btn btn-primary w-100" type="submit">Masuk</button>
    </form>
  </div></div>
</div></div>
<?php require __DIR__ . '/../templates/footer.php'; ?>
