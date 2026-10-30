<?php /* templates/footer.php — muat JS sesuai urutan dependensi */ ?>
</main>
<footer class="border-top bg-white py-3 mt-auto">
    <div class="container text-center text-secondary">
        <small>&copy; <?= date('Y') ?> Pendaftaran Pelatihan</small>
    </div>
</footer>
<!-- Bootstrap untuk menu ponsel -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery HARUS dimuat sebelum DataTables 1.13.8 -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Inti DataTables kemudian integrasi Bootstrap 5 -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- SweetAlert2 dan kode aplikasi: selalu di akhir -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js"></script>
<script src="assets/js/app.js"></script>
</body>
</html>
