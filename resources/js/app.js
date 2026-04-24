import './bootstrap';
import Swal from 'sweetalert2';

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

window.Toast = Toast;
window.Confirm = Confirm;

const Alert = Swal.mixin({
    background: '#1e2530',
    color: '#e5e2e1',
    confirmButtonColor: '#adc6ff',
    confirmButtonText: 'Mengerti',
    customClass: {
        popup: 'swal-alert-popup',
        confirmButton: 'swal-btn-primary',
    },
});

window.Alert = Alert;

const financeFormValidation = (() => {
    let installed = false;
    let lastShownAt = 0;

    const shouldHandle = (form) => form instanceof HTMLFormElement && form.dataset.nativeValidate !== 'true';

    const getFieldLabel = (field) => {
        if (!(field instanceof HTMLElement)) return 'kolom ini';

        const ariaLabel = field.getAttribute('aria-label')?.trim();
        if (ariaLabel) return ariaLabel;

        const id = field.getAttribute('id');
        if (id) {
            const label = document.querySelector(`label[for="${CSS.escape(id)}"]`);
            const text = label?.textContent?.trim();
            if (text) return text;
        }

        const wrapper = field.closest('.space-y-2, .space-y-3, .flex-1, .flex.flex-col.gap-2');
        const label = wrapper?.querySelector('label');
        const labelText = label?.textContent?.trim();
        if (labelText) return labelText;

        const placeholder = (field instanceof HTMLInputElement || field instanceof HTMLTextAreaElement)
            ? field.placeholder?.trim()
            : null;
        if (placeholder) return placeholder;

        const name = field.getAttribute('name')?.trim();
        if (name) return name;

        return 'kolom ini';
    };

    const messageFor = (field) => {
        if (!(field instanceof HTMLInputElement || field instanceof HTMLSelectElement || field instanceof HTMLTextAreaElement)) {
            return 'Harap lengkapi input yang dibutuhkan.';
        }

        const v = field.validity;
        const label = getFieldLabel(field);

        if (v.valueMissing) return `Harap isi ${label}.`;
        if (v.typeMismatch) {
            if (field instanceof HTMLInputElement && field.type === 'email') return 'Masukkan alamat email yang valid.';
            if (field instanceof HTMLInputElement && field.type === 'url') return 'Masukkan URL yang valid.';
            return `Format ${label} tidak valid.`;
        }
        if (v.tooShort) return `${label} minimal ${field.minLength} karakter.`;
        if (v.tooLong) return `${label} maksimal ${field.maxLength} karakter.`;
        if (v.patternMismatch) return `Format ${label} tidak sesuai.`;
        if (v.rangeUnderflow) return `${label} minimal ${field.min}.`;
        if (v.rangeOverflow) return `${label} maksimal ${field.max}.`;
        if (v.stepMismatch) return `${label} tidak valid.`;
        if (v.badInput) return `Isi ${label} dengan nilai yang valid.`;
        if (v.customError && field.validationMessage) return field.validationMessage;

        return `Harap periksa kembali ${label}.`;
    };

    const focusField = (field) => {
        const target = field?._financeTrigger instanceof HTMLElement ? field._financeTrigger : field;
        if (!(target instanceof HTMLElement)) return;

        target.focus({ preventScroll: true });
        target.scrollIntoView({ block: 'center', behavior: 'smooth' });
    };

    const showInvalid = async (field) => {
        const now = Date.now();
        if (now - lastShownAt < 450) return;
        lastShownAt = now;

        await Alert.fire({
            icon: 'error',
            title: 'Form belum lengkap',
            text: messageFor(field),
        });

        focusField(field);
    };

    const validateForm = (form) => {
        if (!shouldHandle(form)) return true;
        const invalid = form.querySelector(':invalid');
        if (!invalid) return true;
        showInvalid(invalid);
        return false;
    };

    const install = () => {
        if (installed) return;
        installed = true;

        // Opt out browser bubble and let us handle the copy + theming.
        document.addEventListener(
            'invalid',
            (event) => {
                const field = event.target;
                if (field instanceof HTMLElement && shouldHandle(field.form)) {
                    event.preventDefault();
                }
            },
            true
        );

        // Cover Enter-to-submit and programmatic submit via user interaction.
        document.addEventListener(
            'submit',
            (event) => {
                const form = event.target;
                if (!(form instanceof HTMLFormElement) || !shouldHandle(form)) return;

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    validateForm(form);
                }
            },
            true
        );

        // Cover submit button clicks (runs before native validation UI).
        document.addEventListener(
            'click',
            (event) => {
                const target = event.target instanceof HTMLElement ? event.target : null;
                const submit = target?.closest('button[type="submit"], input[type="submit"]');
                if (!(submit instanceof HTMLElement)) return;

                const form = submit instanceof HTMLButtonElement || submit instanceof HTMLInputElement ? submit.form : null;
                if (!shouldHandle(form)) return;

                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopImmediatePropagation();
                    validateForm(form);
                }
            },
            true
        );

        document.querySelectorAll('form').forEach((form) => {
            if (shouldHandle(form)) form.noValidate = true;
        });
    };

    return { install };
})();

const financeModalPicker = (() => {
    let modalRoot;
    let titleEl;
    let subtitleEl;
    let contentEl;
    let footerEl;
    let currentCalendarDate = new Date();

    const monthFormatter = new Intl.DateTimeFormat('id-ID', { month: 'long', year: 'numeric' });
    const dayFormatter = new Intl.DateTimeFormat('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });

    const parseDateValue = (value) => {
        if (!value) return null;
        const [year, month, day] = value.split('-').map(Number);
        if (!year || !month || !day) return null;
        return new Date(year, month - 1, day);
    };

    const formatDateValue = (date) => {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    };

    const getFieldLabel = (field) => {
        const wrapper = field.closest('.space-y-2, .space-y-3, .flex-1, .flex.flex-col.gap-2');
        const label = wrapper?.querySelector('label');
        return label?.textContent?.trim() || field.dataset.modalTitle || 'Pilih Nilai';
    };

    const dispatchFieldEvents = (field) => {
        field.dispatchEvent(new Event('input', { bubbles: true }));
        field.dispatchEvent(new Event('change', { bubbles: true }));
    };

    const ensureModal = () => {
        if (modalRoot) return;

        modalRoot = document.createElement('div');
        modalRoot.className = 'finance-picker-modal hidden';
        modalRoot.innerHTML = `
            <div class="finance-picker-backdrop" data-close-modal></div>
            <div class="finance-picker-dialog" role="dialog" aria-modal="true" aria-labelledby="finance-picker-title">
                <div class="finance-picker-header">
                    <div>
                        <p class="finance-picker-kicker">Input Custom</p>
                        <h3 id="finance-picker-title" class="finance-picker-title"></h3>
                        <p class="finance-picker-subtitle"></p>
                    </div>
                    <button type="button" class="finance-picker-close" data-close-modal aria-label="Tutup">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <div class="finance-picker-content"></div>
                <div class="finance-picker-footer"></div>
            </div>
        `;

        document.body.appendChild(modalRoot);
        titleEl = modalRoot.querySelector('.finance-picker-title');
        subtitleEl = modalRoot.querySelector('.finance-picker-subtitle');
        contentEl = modalRoot.querySelector('.finance-picker-content');
        footerEl = modalRoot.querySelector('.finance-picker-footer');

        modalRoot.addEventListener('click', (event) => {
            if (event.target instanceof HTMLElement && event.target.closest('[data-close-modal]')) {
                closeModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && !modalRoot.classList.contains('hidden')) {
                closeModal();
            }
        });
    };

    const closeModal = () => {
        if (!modalRoot) return;
        modalRoot.classList.add('hidden');
        document.body.classList.remove('finance-picker-open');
        contentEl.innerHTML = '';
        footerEl.innerHTML = '';
    };

    const openModalShell = (field, subtitle) => {
        ensureModal();
        titleEl.textContent = getFieldLabel(field);
        subtitleEl.textContent = subtitle;
        modalRoot.classList.remove('hidden');
        document.body.classList.add('finance-picker-open');
    };

    const syncTriggerLabel = (field) => {
        const trigger = field._financeTrigger;
        if (!trigger) return;

        const valueEl = trigger.querySelector('[data-picker-value]');
        if (!valueEl) return;

        if (field.tagName === 'SELECT') {
            const selectedOption = field.options[field.selectedIndex];
            valueEl.textContent = selectedOption?.textContent?.trim() || field.dataset.placeholder || 'Pilih opsi';
            trigger.classList.toggle('is-placeholder', !selectedOption || selectedOption.value === '');
            return;
        }

        const selectedDate = parseDateValue(field.value);
        valueEl.textContent = selectedDate ? dayFormatter.format(selectedDate) : field.dataset.placeholder || 'Pilih tanggal';
        trigger.classList.toggle('is-placeholder', !selectedDate);
    };

    const setFieldValue = (field, value) => {
        field.value = value;
        dispatchFieldEvents(field);
        syncTriggerLabel(field);
    };

    const renderSelectModal = (field) => {
        openModalShell(field, 'Pilih opsi dari modal agar tampilannya konsisten di semua halaman.');

        const list = document.createElement('div');
        list.className = 'finance-picker-list';

        Array.from(field.options).forEach((option) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'finance-picker-option';
            if (option.selected) button.classList.add('is-active');
            if (option.disabled) button.disabled = true;
            button.innerHTML = `
                <span class="finance-picker-option-text">${option.textContent?.trim() || '-'}</span>
                <span class="material-symbols-outlined finance-picker-option-check">check</span>
            `;
            button.addEventListener('click', () => {
                setFieldValue(field, option.value);
                closeModal();
            });
            list.appendChild(button);
        });

        contentEl.replaceChildren(list);
        footerEl.innerHTML = '<button type="button" class="finance-picker-secondary" data-close-modal>Tutup</button>';
    };

    const renderDateModal = (field) => {
        openModalShell(field, 'Pilih tanggal dari kalender custom tanpa date picker bawaan browser.');
        currentCalendarDate = parseDateValue(field.value) ?? new Date();

        const drawCalendar = () => {
            const year = currentCalendarDate.getFullYear();
            const month = currentCalendarDate.getMonth();
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const startOffset = (firstDay.getDay() + 6) % 7;
            const totalCells = Math.ceil((startOffset + lastDay.getDate()) / 7) * 7;

            const wrapper = document.createElement('div');
            wrapper.className = 'finance-calendar';
            wrapper.innerHTML = `
                <div class="finance-calendar-toolbar">
                    <button type="button" class="finance-picker-icon-btn" data-nav="-1">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <div class="finance-calendar-month">${monthFormatter.format(currentCalendarDate)}</div>
                    <button type="button" class="finance-picker-icon-btn" data-nav="1">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </div>
                <div class="finance-calendar-weekdays"></div>
                <div class="finance-calendar-grid"></div>
            `;

            const weekdays = wrapper.querySelector('.finance-calendar-weekdays');
            ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'].forEach((day) => {
                const dayEl = document.createElement('span');
                dayEl.textContent = day;
                weekdays?.appendChild(dayEl);
            });

            const grid = wrapper.querySelector('.finance-calendar-grid');
            for (let index = 0; index < totalCells; index += 1) {
                const dayNumber = index - startOffset + 1;
                const date = new Date(year, month, dayNumber);
                const button = document.createElement('button');
                button.type = 'button';
                button.className = 'finance-calendar-day';
                button.textContent = String(date.getDate());
                if (date.getMonth() !== month) button.classList.add('is-muted');
                if (field.value === formatDateValue(date)) button.classList.add('is-selected');
                if (formatDateValue(date) === formatDateValue(new Date())) button.classList.add('is-today');
                button.addEventListener('click', () => {
                    setFieldValue(field, formatDateValue(date));
                    closeModal();
                });
                grid?.appendChild(button);
            }

            wrapper.querySelectorAll('[data-nav]').forEach((button) => {
                button.addEventListener('click', () => {
                    const direction = Number(button.getAttribute('data-nav'));
                    currentCalendarDate = new Date(year, month + direction, 1);
                    drawCalendar();
                });
            });

            contentEl.replaceChildren(wrapper);
            footerEl.innerHTML = '';

            if (!field.required && field.value) {
                const clearButton = document.createElement('button');
                clearButton.type = 'button';
                clearButton.className = 'finance-picker-secondary';
                clearButton.textContent = 'Hapus';
                clearButton.addEventListener('click', () => {
                    setFieldValue(field, '');
                    closeModal();
                });
                footerEl.appendChild(clearButton);
            }

            const todayButton = document.createElement('button');
            todayButton.type = 'button';
            todayButton.className = 'finance-picker-primary';
            todayButton.textContent = 'Pilih Hari Ini';
            todayButton.addEventListener('click', () => {
                setFieldValue(field, formatDateValue(new Date()));
                closeModal();
            });
            footerEl.appendChild(todayButton);
        };

        drawCalendar();
    };

    const hideNativeAdornment = (field) => {
        const parent = field.parentElement;
        if (!parent) return;
        parent.querySelectorAll('span.pointer-events-none').forEach((element) => {
            element.classList.add('hidden');
        });
    };

    const enhanceField = (field) => {
        if (!(field instanceof HTMLSelectElement || (field instanceof HTMLInputElement && field.type === 'date'))) return;
        if (field.multiple || field.dataset.financePickerEnhanced === 'true') return;

        field.dataset.financePickerEnhanced = 'true';
        field.classList.add('finance-picker-native');
        hideNativeAdornment(field);

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'finance-picker-trigger is-placeholder';
        trigger.innerHTML = `
            <span class="finance-picker-trigger-copy">
                <span class="finance-picker-trigger-value" data-picker-value></span>
            </span>
            <span class="material-symbols-outlined finance-picker-trigger-icon">${field.tagName === 'SELECT' ? 'unfold_more' : 'calendar_month'}</span>
        `;

        trigger.addEventListener('click', () => {
            if (field.disabled) return;
            if (field.tagName === 'SELECT') {
                renderSelectModal(field);
            } else {
                renderDateModal(field);
            }
        });

        field.insertAdjacentElement('afterend', trigger);
        field._financeTrigger = trigger;

        field.addEventListener('change', () => syncTriggerLabel(field));
        field.addEventListener('input', () => syncTriggerLabel(field));

        const observer = new MutationObserver(() => syncTriggerLabel(field));
        observer.observe(field, {
            attributes: true,
            childList: true,
            subtree: true,
            characterData: true,
        });

        syncTriggerLabel(field);
    };

    const enhanceAll = (root = document) => {
        root.querySelectorAll('select, input[type="date"]').forEach(enhanceField);
    };

    return { enhanceAll };
})();

document.addEventListener('DOMContentLoaded', () => {
    financeFormValidation.install();

    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', async (event) => {
            event.preventDefault();
            const message = form.dataset.confirm ?? 'Apakah Anda yakin?';
            const result = await Confirm.fire({
                title: 'Konfirmasi Hapus',
                text: message,
                icon: 'warning',
                confirmButtonText: 'Ya, Hapus!',
            });
            if (result.isConfirmed) form.submit();
        });
    });

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

    financeModalPicker.enhanceAll(document);

    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node instanceof HTMLElement) {
                    financeModalPicker.enhanceAll(node);
                }
            });
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
    });
});
