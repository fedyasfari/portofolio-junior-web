<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';
if (sudahLogin()) redirect('index.php');
$galat = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cekCsrf();
    $sekarang = time();
    $percobaan = $_SESSION['gagal_login'] ?? ['jumlah' => 0, 'awal' => $sekarang];
    if ($sekarang - (int)$percobaan['awal'] >= 900) {
        $percobaan = ['jumlah' => 0, 'awal' => $sekarang];
    }
    if ((int)$percobaan['jumlah'] >= 5) {
        $galat = 'Terlalu banyak percobaan. Coba lagi setelah 15 menit.';
    } elseif (prosesLogin(getConnection(), trim((string)($_POST['username'] ?? '')), (string)($_POST['sandi'] ?? ''))) {
        unset($_SESSION['gagal_login']);
        setFlash('Berhasil masuk sebagai admin.');
        redirect('index.php');
    } else {
        $_SESSION['gagal_login'] = ['jumlah' => (int)$percobaan['jumlah'] + 1, 'awal' => (int)$percobaan['awal']];
        $galat = 'Username atau kata sandi salah.';
    }
}
$judul = 'Login Admin';
require __DIR__ . '/../templates/header.php';
?>
<section class="row justify-content-center"><div class="col-md-6 col-lg-5">
  <div class="card border-0 shadow-sm"><div class="card-body p-4">
    <h1 class="h4 mb-3">Login Admin</h1>
    <?php if ($galat !== ''): ?><div class="alert alert-danger" role="alert"><?= e($galat) ?></div><?php endif; ?>
    <form method="post">
      <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
      <div class="mb-3"><label for="username" class="form-label">Username</label>
        <input id="username" name="username" class="form-control" maxlength="50" autocomplete="username" required></div>
      <div class="mb-3"><label for="sandi" class="form-label">Kata sandi</label>
        <input id="sandi" name="sandi" type="password" class="form-control" autocomplete="current-password" required></div>
      <button class="btn btn-primary w-100" type="submit">Masuk</button>
    </form>
    <p class="small text-muted mt-3">Batas 5 percobaan per sesi selama 15 menit (hanya untuk latihan).</p>
  </div></div>
</div></section>
<?php require __DIR__ . '/../templates/footer.php';
