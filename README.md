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
2. Install dependency: `composer install` dan `npm install`
3. Buat file `.env` dari `.env.example` lalu sesuaikan bila perlu
4. Jalankan `php artisan key:generate`
5. Migrasi + seed database: `php artisan migrate:fresh --seed`
6. Build asset: `npm run build`
7. Jalankan server: `php artisan serve`

## Alur Branch & CI

Repository ini memakai alur promosi branch berikut:

- `development` untuk kerja harian
- `staging` untuk kandidat rilis
- `main` untuk rilis production

Workflow GitHub Actions yang sudah disiapkan:

- `CI` akan jalan di `development`, `staging`, dan `main`
- push ke `development` akan membuat PR promosi ke `staging`
- push ke `staging` akan membuat PR promosi ke `main`

File workflow:

- `.github/workflows/ci.yml`
- `.github/workflows/promote-branches.yml`

### GitHub Settings yang harus diaktifkan

Lakukan ini di GitHub repository settings:

1. Buka `Settings -> Branches`
2. Tambahkan branch protection rule untuk `staging`
3. Tambahkan branch protection rule untuk `main`
4. Aktifkan `Require a pull request before merging`
5. Aktifkan `Require status checks to pass before merging`
6. Pilih status check `CI / test-and-build`
7. Aktifkan `Restrict who can push to matching branches` bila diperlukan
8. Nonaktifkan direct push ke `staging` dan `main` untuk developer biasa

Catatan untuk workflow promosi:
- Jika GitHub menolak pembuatan PR dari GitHub Actions (error `GitHub Actions is not permitted to create or approve pull requests`), aktifkan `Settings -> Actions -> General -> Workflow permissions` ke `Read and write permissions` dan centang `Allow GitHub Actions to create and approve pull requests`.
- Alternatif tanpa mengubah setting di atas: buat secret repo bernama `PROMOTION_TOKEN` berisi Personal Access Token (PAT) yang punya akses `pull requests` dan `contents`, lalu workflow akan otomatis memakai token tersebut.

### Flow kerja yang disarankan

1. Kerja dan merge perubahan ke `development`
2. Setelah push ke `development`, review PR promosi `development -> staging`
3. Setelah lolos verifikasi staging, merge ke `staging`
4. Setelah push ke `staging`, review PR promosi `staging -> main`
5. Merge ke `main` hanya setelah final verification

## Kontribusi

Kontribusi dipersilakan! Silakan buka issue atau pull request untuk saran dan perbaikan.

## Lisensi

Proyek ini menggunakan lisensi [MIT](https://opensource.org/licenses/MIT).
