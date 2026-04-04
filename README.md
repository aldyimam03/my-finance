# My Finance

[![License](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Aplikasi manajemen keuangan pribadi berbasis web yang dibangun dengan Laravel.

## Fitur Utama

- **Manajemen Akun Pengguna**
  - Sistem reset password dengan notifikasi email
  - Template email untuk reset password

- **Fitur Pencarian**
  - Pencarian dengan hasil dan saran otomatis

- **Antarmuka Pengguna**
  - Tampilan untuk tamu (guest layout)
  - Halaman welcome yang informatif
  - Favicon dan apple touch icon untuk branding

## Instalasi

1. Clone repository ini
2. Jalankan `composer install`
3. Buat file `.env` dari `.env.example` dan konfigurasikan
4. Jalankan `php artisan key:generate`
5. Migrasi database: `php artisan migrate`
6. Jalankan server: `php artisan serve`

## Kontribusi

Kontribusi dipersilakan! Silakan buka issue atau pull request untuk saran dan perbaikan.

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).