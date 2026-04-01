<?php

namespace Database\Seeders;

use App\Models\Budget;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Administrator',
                'email' => 'admin@example.com',
                'password' => Hash::make('admin123'),
            ]);
        }

        for ($i = 1; $i <= 5; $i++) {
            $this->seedDummyUser($i);
        }
    }

    private function seedDummyUser(int $index): void
    {
        $user = User::updateOrCreate(
            ['email' => "user{$index}@example.com"],
            [
                'name' => "User {$index}",
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        $currentPeriod = now()->format('Y-m');
        $baseIncome = 5500000 + (($index - 1) * 750000);
        $expenseMultiplier = 1 + (($index - 1) * 0.08);

        $wallets = $user->wallets()->get()->keyBy('name');
        $categories = $user->categories()->get()->keyBy('name');

        Transaction::where('user_id', $user->id)->delete();
        Budget::where('user_id', $user->id)->delete();
        $user->wallets()->update(['balance' => 0]);

        $budgets = [
            'Belanja' => 900000 * $expenseMultiplier,
            'Hiburan' => 500000 * $expenseMultiplier,
            'Investasi' => 1400000 * $expenseMultiplier,
            'Makan & Minum' => 2000000 * $expenseMultiplier,
            'Transportasi' => 650000 * $expenseMultiplier,
            'Lain-lain' => 350000 * $expenseMultiplier,
        ];

        foreach ($budgets as $categoryName => $amount) {
            if (! $categories->has($categoryName)) {
                continue;
            }

            Budget::create([
                'user_id' => $user->id,
                'category_id' => $categories[$categoryName]->id,
                'amount' => round($amount),
                'period' => $currentPeriod,
            ]);
        }

        $transactions = [
            [
                'wallet' => 'BCA',
                'category' => 'Gaji',
                'type' => 'income',
                'amount' => $baseIncome,
                'description' => 'Gaji bulanan',
                'date' => Carbon::now()->startOfMonth()->addDays(1),
            ],
            [
                'wallet' => 'OVO',
                'category' => 'Gaji',
                'type' => 'income',
                'amount' => 350000 + ($index * 50000),
                'description' => 'Bonus freelance',
                'date' => Carbon::now()->startOfMonth()->addDays(4),
            ],
            [
                'wallet' => 'BCA',
                'category' => 'Belanja',
                'type' => 'expense',
                'amount' => round(275000 * $expenseMultiplier),
                'description' => 'Belanja kebutuhan rumah',
                'date' => Carbon::now()->startOfMonth()->addDays(5),
            ],
            [
                'wallet' => 'DANA',
                'category' => 'Belanja',
                'type' => 'expense',
                'amount' => round(180000 * $expenseMultiplier),
                'description' => 'Belanja online',
                'date' => Carbon::now()->startOfMonth()->addDays(8),
            ],
            [
                'wallet' => 'TUNAI',
                'category' => 'Makan & Minum',
                'type' => 'expense',
                'amount' => round(85000 * $expenseMultiplier),
                'description' => 'Makan siang',
                'date' => Carbon::now()->startOfMonth()->addDays(2),
            ],
            [
                'wallet' => 'OVO',
                'category' => 'Makan & Minum',
                'type' => 'expense',
                'amount' => round(125000 * $expenseMultiplier),
                'description' => 'Coffee shop dan snack',
                'date' => Carbon::now()->startOfMonth()->addDays(10),
            ],
            [
                'wallet' => 'GOPAY',
                'category' => 'Transportasi',
                'type' => 'expense',
                'amount' => round(95000 * $expenseMultiplier),
                'description' => 'Transportasi harian',
                'date' => Carbon::now()->startOfMonth()->addDays(7),
            ],
            [
                'wallet' => 'BCA',
                'category' => 'Investasi',
                'type' => 'expense',
                'amount' => round(400000 * $expenseMultiplier),
                'description' => 'Top up investasi bulanan',
                'date' => Carbon::now()->startOfMonth()->addDays(12),
            ],
            [
                'wallet' => 'Mandiri',
                'category' => 'Hiburan',
                'type' => 'expense',
                'amount' => round(175000 * $expenseMultiplier),
                'description' => 'Streaming dan bioskop',
                'date' => Carbon::now()->startOfMonth()->addDays(15),
            ],
            [
                'wallet' => 'TUNAI',
                'category' => 'Lain-lain',
                'type' => 'expense',
                'amount' => round(65000 * $expenseMultiplier),
                'description' => 'Keperluan mendadak',
                'date' => Carbon::now()->startOfMonth()->addDays(18),
            ],
            [
                'wallet' => 'BCA',
                'to_wallet' => 'DANA',
                'type' => 'transfer',
                'amount' => 500000,
                'description' => 'Top up e-wallet',
                'date' => Carbon::now()->startOfMonth()->addDays(3),
            ],
            [
                'wallet' => 'Mandiri',
                'to_wallet' => 'TUNAI',
                'type' => 'transfer',
                'amount' => 300000,
                'description' => 'Tarik tunai',
                'date' => Carbon::now()->startOfMonth()->addDays(11),
            ],
        ];

        foreach ($transactions as $transaction) {
            $wallet = $wallets->get($transaction['wallet']);

            if (! $wallet) {
                continue;
            }

            $categoryId = null;
            $toWalletId = null;

            if (isset($transaction['category']) && $categories->has($transaction['category'])) {
                $categoryId = $categories[$transaction['category']]->id;
            }

            if (isset($transaction['to_wallet'])) {
                $toWalletId = $wallets->get($transaction['to_wallet'])?->id;
            }

            Transaction::create([
                'user_id' => $user->id,
                'wallet_id' => $wallet->id,
                'category_id' => $categoryId,
                'to_wallet_id' => $toWalletId,
                'type' => $transaction['type'],
                'amount' => $transaction['amount'],
                'description' => $transaction['description'],
                'date' => $transaction['date']->toDateString(),
            ]);
        }

        $walletBalances = [];

        foreach ($user->transactions()->orderBy('date')->orderBy('id')->get() as $transaction) {
            $walletBalances[$transaction->wallet_id] = $walletBalances[$transaction->wallet_id] ?? 0;

            if ($transaction->type === 'income') {
                $walletBalances[$transaction->wallet_id] += $transaction->amount;
            } elseif ($transaction->type === 'expense') {
                $walletBalances[$transaction->wallet_id] -= $transaction->amount;
            } elseif ($transaction->type === 'transfer') {
                $walletBalances[$transaction->wallet_id] -= $transaction->amount;

                if ($transaction->to_wallet_id) {
                    $walletBalances[$transaction->to_wallet_id] = $walletBalances[$transaction->to_wallet_id] ?? 0;
                    $walletBalances[$transaction->to_wallet_id] += $transaction->amount;
                }
            }
        }

        foreach ($user->wallets as $wallet) {
            $wallet->update([
                'balance' => $walletBalances[$wallet->id] ?? 0,
            ]);
        }
    }
}
