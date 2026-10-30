// Lab 3 — SweetAlert2 untuk notifikasi dan konfirmasi hapus
// JavaScript hanya membantu antarmuka. Keamanan tetap divalidasi PHP di server.

document.addEventListener('DOMContentLoaded', () => {
  // 1. Flash message dari PHP ditampilkan sebagai toast SweetAlert2.
  const flash = document.getElementById('flash');
  if (flash && typeof window.Swal !== 'undefined') {
    // Sembunyikan alert HTML hanya setelah SweetAlert2 benar-benar tersedia.
    flash.hidden = true;
    window.Swal.fire({
      toast: true,
      position: 'top-end',
      icon: 'success',
      title: flash.dataset.pesan || flash.textContent.trim(),
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
    });
  }

  // 2. Tangkap submit form hapus, beri pilihan Batal atau Ya, hapus.
  document.querySelectorAll('.form-hapus').forEach((form) => {
    form.addEventListener('submit', (event) => {
      const nama = form.dataset.nama || 'ini';
      if (typeof window.Swal === 'undefined') {
        // Jika CDN SweetAlert2 gagal tetapi app.js termuat, tetap ada konfirmasi bawaan.
        if (!window.confirm(`Data ${nama} akan dihapus permanen. Lanjutkan?`)) {
          event.preventDefault();
        }
        return;
      }

      event.preventDefault();
      window.Swal.fire({
        title: 'Hapus data?',
        text: `Data ${nama} akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        reverseButtons: true,
        focusCancel: true,
      }).then((hasil) => {
        // form.submit() mengirim input hidden CSRF ke hapus.php seperti semula.
        if (hasil.isConfirmed) form.submit();
      });
    });
  });

  // 3. Persiapan DataTables untuk Lab 4. TIDAK aktif sebelum plugin dipasang.
  const tabel = document.getElementById('tabelPendaftar');
  if (
    tabel &&
    window.jQuery &&
    window.jQuery.fn &&
    typeof window.jQuery.fn.DataTable === 'function'
  ) {
    window.jQuery(tabel).DataTable({
      pageLength: 10,
      language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.8/i18n/id.json',
      },
      columnDefs: [{ orderable: false, targets: -1 }],
    });
  }
});
