<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Category;
use App\Models\Budget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        $totalBalance = $user->wallets()->sum('balance');

        $monthlyIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        // Cashflow Chart Data (Last 7 Days)
        $cashflowRaw = [];
        $maxTotal = 0;
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $income = $user->transactions()->where('type', 'income')->whereDate('date', $date)->sum('amount');
            $expense = $user->transactions()->where('type', 'expense')->whereDate('date', $date)->sum('amount');
            $cashflowRaw[] = ['day' => $date->isoFormat('ddd'), 'income' => $income, 'expense' => $expense];
            $maxTotal = max($maxTotal, $income, $expense);
        }

        $maxTotal = $maxTotal ?: 1;
        $cashflowData = array_map(function ($data) use ($maxTotal) {
            $data['income_height']  = $data['income']  > 0 ? max(5, ($data['income']  / $maxTotal) * 100) : 0;
            $data['expense_height'] = $data['expense'] > 0 ? max(5, ($data['expense'] / $maxTotal) * 100) : 0;
            return $data;
        }, $cashflowRaw);

        $activeWallets = $user->wallets()->orderBy('updated_at', 'desc')->take(3)->get();

        $recentTransactions = $user->transactions()
            ->with(['wallet', 'category'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $budgets = $user->budgets()->with('category')->get()->map(function ($budget) use ($user, $startOfMonth, $endOfMonth) {
            $spent = $user->transactions()
                ->where('category_id', $budget->category_id)
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            return [
                'name'       => $budget->category->name,
                'amount'     => $budget->amount,
                'spent'      => $spent,
                'percentage' => $budget->amount > 0 ? min(100, ($spent / $budget->amount) * 100) : 0,
                'remaining'  => max(0, $budget->amount - $spent),
            ];
        });

        $aiInsights = $this->generateAiInsights($user, $now, $startOfMonth, $endOfMonth, $monthlyIncome, $monthlyExpense, $budgets);

        return view('dashboard', compact(
            'totalBalance', 'monthlyIncome', 'monthlyExpense',
            'cashflowData', 'activeWallets', 'recentTransactions',
            'budgets', 'aiInsights'
        ));
    }

    private function generateAiInsights($user, $now, $startOfMonth, $endOfMonth, $monthlyIncome, $monthlyExpense, $budgets): array
    {
        $insights = [];

        // === 1. RASIO TABUNGAN ===
        if ($monthlyIncome > 0) {
            $savingsRate = (($monthlyIncome - $monthlyExpense) / $monthlyIncome) * 100;
            if ($savingsRate >= 30) {
                $insights[] = [
                    'type' => 'success', 'icon' => 'savings',
                    'title' => 'Rasio Tabungan Sangat Baik',
                    'detail' => 'Anda berhasil menabung ' . round($savingsRate) . '% dari pemasukan bulan ini (Rp ' . number_format($monthlyIncome - $monthlyExpense, 0, ',', '.') . '). Target ideal ≥ 20% sudah terlampaui!',
                    'badge' => round($savingsRate) . '% saved',
                    'score' => 95,
                ];
            } elseif ($savingsRate >= 10) {
                $insights[] = [
                    'type' => 'info', 'icon' => 'account_balance',
                    'title' => 'Rasio Tabungan Cukup',
                    'detail' => 'Tabungan bulan ini ' . round($savingsRate) . '% dari pemasukan. Kurangi pengeluaran non-esensial untuk mencapai target 20%.',
                    'badge' => round($savingsRate) . '% saved',
                    'score' => 70,
                ];
            } elseif ($savingsRate < 0) {
                $insights[] = [
                    'type' => 'danger', 'icon' => 'money_off',
                    'title' => 'Defisit! Pengeluaran Melebihi Pemasukan',
                    'detail' => 'Bulan ini defisit Rp ' . number_format(abs($monthlyExpense - $monthlyIncome), 0, ',', '.') . '. Tinjau pengeluaran dan pertimbangkan sumber pemasukan tambahan.',
                    'badge' => 'Defisit ' . round(abs($savingsRate)) . '%',
                    'score' => 10,
                ];
            } else {
                $insights[] = [
                    'type' => 'warning', 'icon' => 'trending_flat',
                    'title' => 'Tabungan Masih Rendah',
                    'detail' => 'Rasio tabungan ' . round($savingsRate) . '% masih di bawah target 20%. Coba terapkan aturan 50/30/20 untuk mengoptimalkan keuangan Anda.',
                    'badge' => round($savingsRate) . '% saved',
                    'score' => 45,
                ];
            }
        }

        // === 2. ANALISIS ANGGARAN ===
        $criticalBudgets = $budgets->filter(fn($b) => $b['percentage'] >= 100);
        $warningBudgets  = $budgets->filter(fn($b) => $b['percentage'] >= 80 && $b['percentage'] < 100);

        if ($criticalBudgets->count() > 0) {
            $names = $criticalBudgets->pluck('name')->join(', ');
            $insights[] = [
                'type' => 'danger', 'icon' => 'warning',
                'title' => 'Anggaran Terlampaui',
                'detail' => 'Kategori ' . $names . ' sudah melebihi batas anggaran bulan ini. Pertimbangkan untuk mengurangi pengeluaran atau revisi batas anggaran.',
                'badge' => $criticalBudgets->count() . ' kategori',
                'score' => 25,
            ];
        } elseif ($warningBudgets->count() > 0) {
            $names = $warningBudgets->pluck('name')->join(', ');
            $daysLeft = $now->daysUntilEndOfMonth();
            $insights[] = [
                'type' => 'warning', 'icon' => 'error_outline',
                'title' => 'Anggaran Mendekati Batas',
                'detail' => 'Kategori ' . $names . ' sudah 80%+ terpakai, masih ' . $daysLeft . ' hari hingga akhir bulan. Pertimbangkan untuk mengerem pengeluaran di sini.',
                'badge' => $warningBudgets->count() . ' kategori',
                'score' => 50,
            ];
        } elseif ($budgets->count() > 0) {
            $insights[] = [
                'type' => 'success', 'icon' => 'check_circle',
                'title' => 'Semua Anggaran Terkendali',
                'detail' => 'Seluruh ' . $budgets->count() . ' kategori anggaran masih dalam batas aman. Pertahankan pola belanja ini hingga akhir bulan.',
                'badge' => 'Semua aman',
                'score' => 90,
            ];
        }

        // === 3. PROYEKSI AKHIR BULAN ===
        $daysInMonth   = $now->daysInMonth;
        $daysPassed    = $now->day;
        $daysRemaining = $daysInMonth - $daysPassed;
        if ($daysPassed > 3 && $monthlyExpense > 0) {
            $dailyBurnRate    = $monthlyExpense / $daysPassed;
            $projectedExpense = $dailyBurnRate * $daysInMonth;
            $projLabel = $projectedExpense >= 1000000
                ? 'Rp ' . round($projectedExpense / 1000000, 1) . ' jt'
                : 'Rp ' . number_format($projectedExpense, 0, ',', '.');
            $insights[] = [
                'type'   => $projectedExpense > $monthlyIncome ? 'warning' : 'info',
                'icon'   => 'analytics',
                'title'  => 'Proyeksi Pengeluaran Akhir Bulan',
                'detail' => 'Dengan rata-rata harian Rp ' . number_format($dailyBurnRate, 0, ',', '.') . '/hari, perkiraan total pengeluaran bulan ini mencapai ' . $projLabel . '. Sisa ' . $daysRemaining . ' hari lagi.',
                'badge'  => 'Proj. ' . $projLabel,
                'score'  => $projectedExpense > $monthlyIncome ? 35 : 75,
            ];
        }

        // === 4. KATEGORI TERBOROS ===
        $topCategory = $user->transactions()
            ->selectRaw('category_id, SUM(amount) as total')
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->with('category')
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->first();

        if ($topCategory && $monthlyExpense > 0) {
            $pct = round(($topCategory->total / $monthlyExpense) * 100);
            $insights[] = [
                'type'   => $pct > 50 ? 'warning' : 'info',
                'icon'   => 'pie_chart',
                'title'  => 'Dominan: ' . ($topCategory->category->name ?? 'Lainnya'),
                'detail' => 'Pengeluaran terbesar di kategori ' . ($topCategory->category->name ?? 'Lainnya') . ' sebesar Rp ' . number_format($topCategory->total, 0, ',', '.') . ' (' . $pct . '% dari total pengeluaran bulan ini).',
                'badge'  => $pct . '% dari total',
                'score'  => $pct > 50 ? 45 : 72,
            ];
        }

        // === 5. DETEKSI LONJAKAN PENGELUARAN ===
        $last7 = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [Carbon::today()->subDays(6), Carbon::today()])
            ->sum('amount');
        $prev7 = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [Carbon::today()->subDays(13), Carbon::today()->subDays(7)])
            ->sum('amount');

        if ($prev7 > 0 && $last7 > 0) {
            $spike = (($last7 - $prev7) / $prev7) * 100;
            if ($spike > 50) {
                $insights[] = [
                    'type'   => 'danger', 'icon' => 'bolt',
                    'title'  => 'Lonjakan Pengeluaran Terdeteksi!',
                    'detail' => 'Pengeluaran 7 hari terakhir (Rp ' . number_format($last7, 0, ',', '.') . ') naik ' . round($spike) . '% vs minggu sebelumnya (Rp ' . number_format($prev7, 0, ',', '.') . '). Tinjau transaksi terkini.',
                    'badge'  => '+' . round($spike) . '% minggu ini',
                    'score'  => 15,
                ];
            } elseif ($spike < -20) {
                $insights[] = [
                    'type'   => 'success', 'icon' => 'trending_down',
                    'title'  => 'Pengeluaran Berhasil Ditekan',
                    'detail' => 'Pengeluaran 7 hari terakhir turun ' . round(abs($spike)) . '% dibanding minggu sebelumnya. Pertahankan pola hemat ini!',
                    'badge'  => round(abs($spike)) . '% lebih hemat',
                    'score'  => 88,
                ];
            }
        }

        usort($insights, fn ($a, $b) => $a['score'] <=> $b['score']);
        return array_slice($insights, 0, 4);
    }
}
