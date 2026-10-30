<?php /* public/_form.php - gunakan $lama, $galat, $kelas dari tambah.php / ubah.php */ ?>
<section class="card shadow-sm" aria-labelledby="judul-form">
    <div class="card-body p-3 p-md-4">
        <h1 class="h4 mb-3" id="judul-form"><?= e($judul ?? 'Form Pendaftaran') ?></h1>
        <form method="post" novalidate>
            <!-- Token dari aplikasi Hari 9: nama field csrf JANGAN diubah -->
            <input type="hidden" name="csrf" value="<?= e(tokenCsrf()) ?>">

            <!-- row + col-md-6 = 1 kolom di ponsel, 2 kolom mulai lebar 768 px -->
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input
                        type="text" id="nama" name="nama" autocomplete="name"
                        class="form-control<?= isset($galat['nama']) ? ' is-invalid' : '' ?>"
                        value="<?= e((string) ($lama['nama'] ?? '')) ?>"
                        <?= isset($galat['nama']) ? 'aria-invalid="true" aria-describedby="nama-error"' : '' ?>
                    >
                    <?php if (isset($galat['nama'])): ?>
                        <div id="nama-error" class="invalid-feedback"><?= e($galat['nama']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input
                        type="email" id="email" name="email" autocomplete="email"
                        class="form-control<?= isset($galat['email']) ? ' is-invalid' : '' ?>"
                        value="<?= e((string) ($lama['email'] ?? '')) ?>"
                        <?= isset($galat['email']) ? 'aria-invalid="true" aria-describedby="email-error"' : '' ?>
                    >
                    <?php if (isset($galat['email'])): ?>
                        <div id="email-error" class="invalid-feedback"><?= e($galat['email']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input
                        type="tel" id="no_hp" name="no_hp" autocomplete="tel"
                        class="form-control<?= isset($galat['no_hp']) ? ' is-invalid' : '' ?>"
                        value="<?= e((string) ($lama['no_hp'] ?? '')) ?>"
                        <?= isset($galat['no_hp']) ? 'aria-invalid="true" aria-describedby="no-hp-error"' : '' ?>
                    >
                    <?php if (isset($galat['no_hp'])): ?>
                        <div id="no-hp-error" class="invalid-feedback"><?= e($galat['no_hp']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-md-6">
                    <label for="kelas_id" class="form-label">Kelas</label>
                    <select
                        id="kelas_id" name="kelas_id"
                        class="form-select<?= isset($galat['kelas_id']) ? ' is-invalid' : '' ?>"
                        <?= isset($galat['kelas_id']) ? 'aria-invalid="true" aria-describedby="kelas-error"' : '' ?>
                    >
                        <option value="">-- Pilih kelas --</option>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= (int) $k['id'] ?>" <?= (int) ($lama['kelas_id'] ?? 0) === (int) $k['id'] ? 'selected' : '' ?>><?= e($k['nama_kelas']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (isset($galat['kelas_id'])): ?>
                        <div id="kelas-error" class="invalid-feedback"><?= e($galat['kelas_id']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea
                        id="alamat" name="alamat" rows="3"
                        class="form-control<?= isset($galat['alamat']) ? ' is-invalid' : '' ?>"
                        <?= isset($galat['alamat']) ? 'aria-invalid="true" aria-describedby="alamat-error"' : '' ?>
                    ><?= e((string) ($lama['alamat'] ?? '')) ?></textarea>
                    <?php if (isset($galat['alamat'])): ?>
                        <div id="alamat-error" class="invalid-feedback"><?= e($galat['alamat']) ?></div>
                    <?php endif; ?>
                </div>

                <div class="col-12 d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="index.php" class="btn btn-secondary">Batal</a>
                </div>
            </div>
        </form>
    </div>
</section>
