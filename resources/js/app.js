import './bootstrap';

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
