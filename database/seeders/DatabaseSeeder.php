<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Mengecek agar tidak terjadi duplikasi email
        // UserObserver akan otomatis membuat dompet dan kategori default saat user dibuat
        // Kita tidak menggunakan WithoutModelEvents agar UserObserver tetap terpicu saat seeding
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
            ]);
        }
    }
}
