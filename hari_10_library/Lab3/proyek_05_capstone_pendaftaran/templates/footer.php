<?php /* templates/footer.php - Lab 3: urutan skrip penting */ ?>
</main>
<footer class="border-top bg-white py-3 mt-auto">
    <div class="container text-center text-secondary">
        <small>&copy; <?= date('Y') ?> Pendaftaran Pelatihan</small>
    </div>
</footer>
<!-- Bootstrap JS bundle: membuka/menutup navbar di ponsel -->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"
></script>
<!-- SweetAlert2: harus dimuat sebelum app.js -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.26.25/dist/sweetalert2.all.min.js"></script>
<!-- JavaScript aplikasi: relatif terhadap halaman PHP di dalam folder public/ -->
<script src="assets/js/app.js"></script>
</body>
</html>
