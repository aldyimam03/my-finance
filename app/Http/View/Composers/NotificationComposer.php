<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationComposer
{
    public function compose(View $view): void
    {
        $user = Auth::user();
        if (!$user) {
            $view->with('notifications', collect());
            $view->with('notifCount', 0);
            $view->with('notifIsRead', true);
            return;
        }

        $notifications = collect();
        $now           = Carbon::now();
        $startOfMonth  = $now->copy()->startOfMonth();
        $endOfMonth    = $now->copy()->endOfMonth();

        // Baca preferensi dari DB (default true jika kolom belum ada)
        $wantBudgetAlert  = (bool) ($user->notify_budget_alert  ?? true);
        $wantWeeklyReport = (bool) ($user->notify_weekly_report ?? true);
        $wantMarketingTips = (bool) ($user->notify_marketing_tips ?? false);

        // 1. Peringatan Anggaran — hanya jika diaktifkan di pengaturan
        if ($wantBudgetAlert) {
            $budgets = $user->budgets()->with('category')->get();
            foreach ($budgets as $budget) {
                $spent = $user->transactions()
                    ->where('category_id', $budget->category_id)
                    ->where('type', 'expense')
                    ->whereBetween('date', [$startOfMonth, $endOfMonth])
                    ->sum('amount');

                $pct = $budget->amount > 0 ? ($spent / $budget->amount) * 100 : 0;

                if ($pct >= 100) {
                    $notifications->push([
                        'type'    => 'danger',
                        'icon'    => 'warning',
                        'title'   => 'Anggaran Habis!',
                        'message' => 'Anggaran ' . $budget->category->name . ' sudah terpakai penuh (Rp ' . number_format($budget->amount, 0, ',', '.') . ').',
                        'time'    => 'Bulan ini',
                        'setting' => 'notify_budget_alert',
                    ]);
                } elseif ($pct >= 80) {
                    $notifications->push([
                        'type'    => 'warning',
                        'icon'    => 'error_outline',
                        'title'   => 'Anggaran Hampir Habis',
                        'message' => 'Anggaran ' . $budget->category->name . ' sudah ' . round($pct) . '% terpakai.',
                        'time'    => 'Bulan ini',
                        'setting' => 'notify_budget_alert',
                    ]);
                }
            }
        }

        // 2. Ringkasan Bulanan — hanya jika "Laporan Mingguan" diaktifkan di pengaturan
        if ($wantWeeklyReport) {
            $income = $user->transactions()
                ->where('type', 'income')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $expense = $user->transactions()
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $net = $income - $expense;
            $notifications->push([
                'type'    => $net >= 0 ? 'success' : 'warning',
                'icon'    => $net >= 0 ? 'trending_up' : 'trending_down',
                'title'   => 'Ringkasan ' . $now->isoFormat('MMMM YYYY'),
                'message' => 'Pemasukan Rp ' . number_format($income, 0, ',', '.') .
                             ' · Pengeluaran Rp ' . number_format($expense, 0, ',', '.') .
                             ' · ' . ($net >= 0 ? 'Surplus +' : 'Defisit ') . 'Rp ' . number_format(abs($net), 0, ',', '.'),
                'time'    => $now->format('d M'),
                'setting' => 'notify_weekly_report',
            ]);
        }

        // 3. Tips Finansial — hanya jika "Tips Finansial" diaktifkan di pengaturan
        if ($wantMarketingTips) {
            $largeTransactions = $user->transactions()
                ->with('category')
                ->where('type', 'expense')
                ->whereBetween('date', [Carbon::now()->subDays(7), Carbon::now()])
                ->orderByDesc('amount')
                ->take(1)
                ->get();

            foreach ($largeTransactions as $trx) {
                $notifications->push([
                    'type'    => 'info',
                    'icon'    => 'payments',
                    'title'   => 'Pengeluaran Terbesar Minggu Ini',
                    'message' => ($trx->description ?? 'Tanpa deskripsi') . ' — Rp ' .
                                 number_format($trx->amount, 0, ',', '.') . ' (' . ($trx->category->name ?? '-') . ')',
                    'time'    => $trx->date->diffForHumans(),
                    'setting' => 'notify_marketing_tips',
                ]);
            }
        }

        // Jika semua notif dimatikan atau tidak ada data → tampilkan pesan kosong
        if ($notifications->isEmpty()) {
            $notifications->push([
                'type'    => 'success',
                'icon'    => 'check_circle',
                'title'   => 'Semua Aman!',
                'message' => $wantBudgetAlert || $wantWeeklyReport
                    ? 'Tidak ada peringatan atau catatan keuangan terbaru.'
                    : 'Semua notifikasi dinonaktifkan. Aktifkan di Pengaturan.',
                'time'    => 'Sekarang',
                'setting' => null,
            ]);
        }

        // Cek status sudah dibaca (via session timestamp)
        $readAt     = session('notif_read_at', 0);
        $isRead     = $readAt >= $now->copy()->startOfHour()->timestamp;
        $alertCount = $notifications->where('type', '!=', 'success')->count();

        $view->with('notifications', $notifications);
        $view->with('notifCount', $isRead ? 0 : $alertCount);
        $view->with('notifIsRead', $isRead || $alertCount === 0);
    }
}
