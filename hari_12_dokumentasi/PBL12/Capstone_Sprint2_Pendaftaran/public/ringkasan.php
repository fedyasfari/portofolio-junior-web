<?php
declare(strict_types=1);

// Halaman baru, tidak mengganti halaman index.php yang sudah ada.
require_once __DIR__ . '/../src/bootstrap.php';
require_once __DIR__ . '/../src/struktur_data.php';
wajibLogin(); // Hanya dapat diakses oleh admin yang sudah masuk.

$pdo = getConnection();
$terbaru = limaPendaftarTerbaru(ambilSemuaPendaftar($pdo), 5);
$peringkat = peringkatKelasBerdasarkanJumlah(daftarKelas($pdo));
$judul = 'Ringkasan Admin';
require __DIR__ . '/../templates/header.php';
?>
<main class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <h1 class="h3 mb-0">Ringkasan Pendaftaran</h1>
    <a href="index.php" class="btn btn-outline-secondary">Kembali ke daftar peserta</a>
  </div>
  <div class="row g-4">
    <section class="col-lg-7">
      <div class="card h-100"><div class="card-body">
        <h2 class="h5">5 pendaftar terbaru (SplQueue)</h2>
        <p class="text-muted small">Berdasarkan ID pendaftaran, terbaru ditampilkan paling atas.</p>
        <div class="table-responsive">
          <table class="table table-striped align-middle">
            <thead><tr><th scope="col">ID</th><th scope="col">Nama</th><th scope="col">Kelas</th></tr></thead>
            <tbody>
              <?php foreach ($terbaru as $peserta): ?>
                <tr>
                  <td><?= (int) $peserta['id'] ?></td>
                  <td><?= e($peserta['nama']) ?></td>
                  <td><?= e($peserta['nama_kelas']) ?></td>
                </tr>
              <?php endforeach; ?>
              <?php if ($terbaru === []): ?><tr><td colspan="3">Belum ada pendaftar.</td></tr><?php endif; ?>
            </tbody>
          </table>
        </div>
      </div></div>
    </section>
    <section class="col-lg-5">
      <div class="card h-100"><div class="card-body">
        <h2 class="h5">Peringkat kelas (usort)</h2>
        <p class="text-muted small">Jumlah peserta berasal dari database; kelas kosong tetap ditampilkan.</p>
        <div class="table-responsive">
          <table class="table table-striped align-middle">
            <thead><tr><th scope="col">Kelas</th><th scope="col">Terdaftar</th></tr></thead>
            <tbody>
              <?php foreach ($peringkat as $kelas): ?>
                <tr><td><?= e($kelas['nama_kelas']) ?></td><td><?= (int) $kelas['terisi'] ?></td></tr>
              <?php endforeach; ?>
              <?php if ($peringkat === []): ?><tr><td colspan="2">Belum ada kelas.</td></tr><?php endif; ?>
            </tbody>
          </table>
        </div>
      </div></div>
    </section>
  </div>
</main>
<?php require __DIR__ . '/../templates/footer.php'; ?>
