<?php
// Diperlukan: $lama, $galat, $kelas, $judulTampilan, $labelSimpan.
?>
<section class="card shadow-sm border-0">
 <div class="card-body p-3 p-md-4">
  <h1 class="h4 mb-3"><?= e($judulTampilan) ?></h1>
  <form method="post" novalidate>
    <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label" for="nama">Nama lengkap</label>
        <input class="form-control<?= isset($galat['nama']) ? ' is-invalid' : '' ?>" id="nama" name="nama"
               value="<?= e($lama['nama'] ?? '') ?>" autocomplete="name" maxlength="150" required>
        <?php if (isset($galat['nama'])): ?><div class="invalid-feedback"><?= e($galat['nama']) ?></div><?php endif; ?>
      </div>
      <div class="col-md-6">
        <label class="form-label" for="email">Email</label>
        <input type="email" class="form-control<?= isset($galat['email']) ? ' is-invalid' : '' ?>"
               id="email" name="email" value="<?= e($lama['email'] ?? '') ?>" autocomplete="email" maxlength="190" required>
        <?php if (isset($galat['email'])): ?><div class="invalid-feedback"><?= e($galat['email']) ?></div><?php endif; ?>
      </div>
      <div class="col-md-6">
        <label class="form-label" for="no_hp">No. HP</label>
        <input type="tel" class="form-control<?= isset($galat['no_hp']) ? ' is-invalid' : '' ?>"
               id="no_hp" name="no_hp" value="<?= e($lama['no_hp'] ?? '') ?>" autocomplete="tel" required>
        <?php if (isset($galat['no_hp'])): ?><div class="invalid-feedback"><?= e($galat['no_hp']) ?></div><?php endif; ?>
      </div>
      <div class="col-md-6">
        <label class="form-label" for="kelas_id">Kelas pelatihan</label>
        <select class="form-select<?= isset($galat['kelas_id']) ? ' is-invalid' : '' ?>" id="kelas_id" name="kelas_id" required>
          <option value="">-- Pilih kelas --</option>
          <?php foreach ($kelas as $k): ?>
            <option value="<?= (int) $k['id'] ?>" <?= (int) ($lama['kelas_id'] ?? 0) === (int) $k['id'] ? 'selected' : '' ?>><?= e($k['nama_kelas']) ?> — sisa <?= hitungSisaKuota((int)$k['kuota'], (int)$k['terisi']) ?> / <?= (int)$k['kuota'] ?><?= (int)$k['sisa'] === 0 ? ' (PENUH)' : '' ?></option>
          <?php endforeach; ?>
        </select>
        <?php if (isset($galat['kelas_id'])): ?><div class="invalid-feedback"><?= e($galat['kelas_id']) ?></div><?php endif; ?>
      </div>
      <div class="col-12">
        <label class="form-label" for="alamat">Alamat (opsional)</label>
        <textarea class="form-control<?= isset($galat['alamat']) ? ' is-invalid' : '' ?>"
                  id="alamat" name="alamat" rows="3"><?= e($lama['alamat'] ?? '') ?></textarea>
        <?php if (isset($galat['alamat'])): ?><div class="invalid-feedback"><?= e($galat['alamat']) ?></div><?php endif; ?>
      </div>
      <div class="col-12 d-flex gap-2 flex-wrap">
        <button type="submit" class="btn btn-primary"><?= e($labelSimpan) ?></button>
        <a class="btn btn-secondary" href="<?= sudahLogin() ? 'index.php' : 'daftar.php' ?>">Batal</a>
      </div>
    </div>
  </form>
 </div>
</section>
