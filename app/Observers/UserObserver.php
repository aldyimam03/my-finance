<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // 1. Determine Default Categories based on user email
        if ($user->email === 'admin@example.com') {
            // Full Admin Categories
            $categories = [
                ['name' => 'Makan', 'icon' => 'restaurant', 'color' => 'bg-orange-500'],
                ['name' => 'Minum', 'icon' => 'local_cafe', 'color' => 'bg-blue-400'],
                ['name' => 'Bensin', 'icon' => 'local_gas_station', 'color' => 'bg-yellow-600'],
                ['name' => 'Transportasi', 'icon' => 'directions_car', 'color' => 'bg-blue-600'],
                ['name' => 'Paket Internet', 'icon' => 'wifi', 'color' => 'bg-indigo-500'],
                ['name' => 'Kopi', 'icon' => 'coffee', 'color' => 'bg-brown-500'],
                ['name' => 'Parkir', 'icon' => 'local_parking', 'color' => 'bg-gray-500'],
                ['name' => 'Gaji', 'icon' => 'payments', 'color' => 'bg-green-500'],
                ['name' => 'Amal', 'icon' => 'volunteer_activism', 'color' => 'bg-pink-500'],
                ['name' => 'Anjem', 'icon' => 'electric_rickshaw', 'color' => 'bg-cyan-500'],
                ['name' => 'Jastip', 'icon' => 'shopping_bag', 'color' => 'bg-purple-500'],
                ['name' => 'Top Up', 'icon' => 'account_balance_wallet', 'color' => 'bg-teal-500'],
                ['name' => 'Patungan', 'icon' => 'groups', 'color' => 'bg-emerald-500'],
                ['name' => 'Lain - lain', 'icon' => 'more_horiz', 'color' => 'bg-slate-400'],
            ];
        } else {
            // Simplified User Categories
            $categories = [
                ['name' => 'Belanja', 'icon' => 'shopping_cart', 'color' => 'bg-orange-500'],
                ['name' => 'Gaji', 'icon' => 'payments', 'color' => 'bg-green-500'],
                ['name' => 'Hiburan', 'icon' => 'movie', 'color' => 'bg-blue-500'],
                ['name' => 'Investasi', 'icon' => 'trending_up', 'color' => 'bg-indigo-500'],
                ['name' => 'Lain-lain', 'icon' => 'more_horiz', 'color' => 'bg-slate-400'],
                ['name' => 'Makan & Minum', 'icon' => 'restaurant', 'color' => 'bg-pink-500'],
                ['name' => 'Transportasi', 'icon' => 'directions_car', 'color' => 'bg-blue-600'],
            ];
        }

        foreach ($categories as $cat) {
            $user->categories()->create([
                'name'  => $cat['name'],
                'icon'  => $cat['icon'],
                'color' => $cat['color'],
                'type'  => 'general',
            ]);
        }

        // 2. Seed Default Wallets (All users get the same wallets)
        $wallets = [
            ['name' => 'BCA', 'color' => 'bg-blue-700', 'icon' => 'account_balance', 'type' => 'Bank'],
            ['name' => 'Mandiri', 'color' => 'bg-yellow-600', 'icon' => 'account_balance', 'type' => 'Bank'],
            ['name' => 'BRI', 'color' => 'bg-blue-600', 'icon' => 'account_balance', 'type' => 'Bank'],
            ['name' => 'BSI', 'color' => 'bg-emerald-600', 'icon' => 'account_balance', 'type' => 'Bank'],
            ['name' => 'OVO', 'color' => 'bg-purple-600', 'icon' => 'account_balance_wallet', 'type' => 'E-Wallet'],
            ['name' => 'DANA', 'color' => 'bg-blue-500', 'icon' => 'account_balance_wallet', 'type' => 'E-Wallet'],
            ['name' => 'GOPAY', 'color' => 'bg-blue-400', 'icon' => 'account_balance_wallet', 'type' => 'E-Wallet'],
            ['name' => 'SEABANK', 'color' => 'bg-orange-500', 'icon' => 'account_balance', 'type' => 'Bank'],
            ['name' => 'SHOPEEPAY', 'color' => 'bg-orange-600', 'icon' => 'account_balance_wallet', 'type' => 'E-Wallet'],
            ['name' => 'TUNAI', 'color' => 'bg-green-600', 'icon' => 'payments', 'type' => 'Tunai'],
        ];

        foreach ($wallets as $wallet) {
            $user->wallets()->create([
                'name'     => $wallet['name'],
                'type'     => $wallet['type'],
                'balance'  => 0,
                'currency' => 'IDR',
                'icon'     => $wallet['icon'],
                'color'    => $wallet['color'],
            ]);
        }
    }
}
