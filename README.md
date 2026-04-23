# My Finance

[![CI](https://github.com/aldyimam03/my-finance/actions/workflows/ci.yml/badge.svg)](https://github.com/aldyimam03/my-finance/actions/workflows/ci.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](https://opensource.org/licenses/MIT)

Aplikasi manajemen keuangan pribadi berbasis web (Laravel) untuk mencatat transaksi, dompet, kategori, dan anggaran.

## Fitur

- Autentikasi + reset password via email
- Pencarian transaksi/laporan dengan saran otomatis
- UI modern (Vite) dengan layout guest + dashboard
- Seed data untuk development

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

## Alur Branch & CI

Branch yang dipakai:

- `development`: kerja harian
- `staging`: kandidat rilis
- `main`: production

Workflow yang tersedia:

- `CI` jalan di `development`, `staging`, `main`
- `Promote Branches` membuat PR promosi:
  - push ke `development` -> PR ke `staging`
  - push ke `staging` -> PR ke `main`

File workflow:

- `.github/workflows/ci.yml`
- `.github/workflows/promote-branches.yml`

### Branch Protection (Disarankan)

Atur di GitHub:

1. `Settings -> Branches`
2. Buat rule untuk `staging` dan `main`
3. Aktifkan `Require a pull request before merging`
4. Aktifkan `Require status checks to pass before merging`
5. Pilih status check `CI / test-and-build`

### Permission Untuk Workflow Promosi

Jika muncul error `GitHub Actions is not permitted to create or approve pull requests`:

1. `Settings -> Actions -> General -> Workflow permissions`
2. Pilih `Read and write permissions`
3. Centang `Allow GitHub Actions to create and approve pull requests`

Alternatif (lebih stabil): buat repo secret `PROMOTION_TOKEN` berisi PAT yang punya akses `Contents` + `Pull requests`.

## Kontribusi

Issue dan pull request dipersilakan.

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
