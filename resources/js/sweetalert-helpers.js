import Swal from 'sweetalert2';

// Helper function untuk konfirmasi delete
window.confirmDelete = function(formId, itemName = '') {
    Swal.fire({
        title: '⚠️ Hapus Data?',
        html: `<p>Anda akan menghapus <strong>"${itemName || 'data ini'}"</strong></p>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '✓ Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
    return false;
};

// Helper function untuk konfirmasi return buku
window.confirmReturn = function(formId, itemName = 'buku') {
    Swal.fire({
        title: 'Kembalikan Buku',
        html: `<p>Apakah Anda yakin ${itemName} sudah dikembalikan?</p>
               <p class="text-sm text-gray-600 mt-2">Harap pastikan semua item benar-benar sudah diterima.</p>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Kembalikan',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
    return false;
};

// Helper function untuk alert sukses
window.showSuccess = function(message, title = 'Berhasil!') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'success',
        confirmButtonColor: '#10b981',
        confirmButtonText: 'OK',
        allowOutsideClick: false,
        allowEscapeKey: false
    });
};

// Helper function untuk alert error
window.showError = function(message, title = 'Gagal!') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'error',
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'OK',
        allowOutsideClick: false,
        allowEscapeKey: false
    });
};

// Helper function untuk alert info
window.showInfo = function(message, title = 'Informasi') {
    return Swal.fire({
        title: title,
        text: message,
        icon: 'info',
        confirmButtonColor: '#3b82f6',
        confirmButtonText: 'OK'
    });
};

// Auto-hide flash messages setelah 5 detik
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('[data-alert-auto-hide]');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transition = 'opacity 0.3s ease-out';
            setTimeout(() => {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });
});

export { Swal };
