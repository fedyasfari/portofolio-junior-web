<?php
// File tampilan ini memerlukan $daftarTampil (array) dari index.php.
// Semua data dinamis pada teks HTML diproses dengan e() / htmlspecialchars().
?>
<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th scope="col">No.</th>
        <th scope="col">Nama</th>
        <th scope="col">Kelas</th>
        <th scope="col">Nilai</th>
        <th scope="col">Grade</th>
      </tr>
    </thead>
    <tbody>
    <?php if ($daftarTampil === []): ?>
      <tr><td colspan="5" class="empty">Belum ada data peserta.</td></tr>
    <?php else: ?>
      <?php foreach ($daftarTampil as $nomor => $orang): ?>
        <tr>
          <td><?= e($nomor + 1) ?></td>
          <td><?= e($orang['nama']) ?></td>
          <td><?= e($orang['kelas']) ?></td>
          <td><?= e($orang['nilai']) ?></td>
          <td><span class="grade grade-<?= e(nilaiKeGrade($orang['nilai'])) ?>"><?= e(nilaiKeGrade($orang['nilai'])) ?></span></td>
        </tr>
      <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
  </table>
</div>
