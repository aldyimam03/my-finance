import './bootstrap';
import Swal from 'sweetalert2';

// ─── Global financeNumber helper ──────────────────────────────────────────────
window.financeNumber = {
    sanitize(value) {
        return String(value ?? '')
            .replace(/\D/g, '')
            .replace(/^0+(?=\d)/, '');
    },
    format(value) {
        const sanitized = this.sanitize(value);
        return sanitized ? new Intl.NumberFormat('id-ID').format(Number(sanitized)) : '';
    },
};

// ─── SweetAlert2 themed instance ──────────────────────────────────────────────
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500,
    timerProgressBar: true,
    background: '#1e2530',
    color: '#e5e2e1',
    customClass: {
        popup: 'swal-toast-popup',
        timerProgressBar: 'swal-progress',
    },
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});

const Confirm = Swal.mixin({
    background: '#1e2530',
    color: '#e5e2e1',
    showCancelButton: true,
    confirmButtonColor: '#FF516A',
    cancelButtonColor: '#374151',
    cancelButtonText: 'Batal',
    customClass: {
        popup: 'swal-confirm-popup',
        confirmButton: 'swal-btn-confirm',
        cancelButton: 'swal-btn-cancel',
    },
    reverseButtons: true,
});

window.Toast   = Toast;
window.Confirm = Confirm;

// ─── Delete confirmation helper ───────────────────────────────────────────────
// Ganti confirm() biasa pada form delete
// Usage: <form ... onsubmit="return false" data-confirm="Hapus X ini?">
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            const msg = form.dataset.confirm ?? 'Apakah Anda yakin?';
            const result = await Confirm.fire({
                title: 'Konfirmasi Hapus',
                text: msg,
                icon: 'warning',
                confirmButtonText: 'Ya, Hapus!',
            });
            if (result.isConfirmed) form.submit();
        });
    });

    // ─── Auto-show flash toast dari session (data-flash-* di body) ────────────
    const body = document.body;
    if (body.dataset.flashSuccess) {
        Toast.fire({ icon: 'success', title: body.dataset.flashSuccess });
    }
    if (body.dataset.flashError) {
        Toast.fire({ icon: 'error', title: body.dataset.flashError });
    }
    if (body.dataset.flashWarning) {
        Toast.fire({ icon: 'warning', title: body.dataset.flashWarning });
    }
    if (body.dataset.flashInfo) {
        Toast.fire({ icon: 'info', title: body.dataset.flashInfo });
    }
});
