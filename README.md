# My Finance

[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Aplikasi manajemen keuangan pribadi berbasis web (Laravel) untuk mencatat transaksi, dompet, kategori, dan anggaran.

## Fitur

- Autentikasi + reset password via email
- Pencarian transaksi/laporan dengan saran otomatis
- UI modern (Vite) dengan layout guest + dashboard
- Seed data untuk development

## Cara Menggunakan

1. Daftar akun atau login.
2. Buat atau pilih `Dompet` (mis. BCA, Mandiri, Tunai).
3. Buat `Kategori` transaksi (mis. Belanja, Makan, Transport).
4. Tambahkan `Transaksi` pemasukan/pengeluaran, pilih dompet + kategori, isi nominal dan tanggal.
5. (Opsional) Atur `Anggaran` per kategori, lalu pantau analisis pemakaian anggaran.
6. Lihat ringkasan dan laporan di dashboard.

## Teknologi

- Laravel + Blade
- Vite (build assets)
- Tailwind CSS

## Quick Start (Local)

### Prasyarat

- PHP + Composer
- Node.js + npm
- Database (default: SQLite)

### Setup

Linux/macOS:

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

php artisan migrate:fresh --seed
npm run build
php artisan serve
```

Windows (PowerShell):

```powershell
composer install
npm install

Copy-Item .env.example .env
php artisan key:generate

php artisan migrate:fresh --seed
npm run build
php artisan serve
```

## Testing

```bash
composer test
```

## Kontribusi

Issue dan pull request dipersilakan.

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
