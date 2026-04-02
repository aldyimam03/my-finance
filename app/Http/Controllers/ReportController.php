<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;

class ReportController extends Controller
{
    private function getData(string $month): array
    {
        $user = Auth::user();
        $startDate = Carbon::parse($month . '-01')->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $totalIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $totalExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->sum('amount');

        $netBalance = $totalIncome - $totalExpense;

        $expenseByCategory = $user->transactions()
            ->with('category')
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->groupBy('category_id')
            ->map(function ($transactions) use ($totalExpense) {
                $cat = $transactions->first()->category;
                $amount = $transactions->sum('amount');
                return [
                    'name'       => $cat ? $cat->name : 'Tanpa Kategori',
                    'icon'       => $cat ? ($cat->icon ?? 'category') : 'category',
                    'amount'     => $amount,
                    'percentage' => $totalExpense > 0 ? round(($amount / $totalExpense) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        $monthlyCashflow = [];
        $maxMonthly = 0;
        for ($i = 5; $i >= 0; $i--) {
            $monthDate = Carbon::now()->subMonths($i);
            $mStart = $monthDate->copy()->startOfMonth();
            $mEnd = $monthDate->copy()->endOfMonth();

            $inc = $user->transactions()->where('type', 'income')->whereBetween('date', [$mStart, $mEnd])->sum('amount');
            $exp = $user->transactions()->where('type', 'expense')->whereBetween('date', [$mStart, $mEnd])->sum('amount');
            $maxMonthly = max($maxMonthly, $inc, $exp);

            $monthlyCashflow[] = ['month' => $monthDate->isoFormat('MMM'), 'income' => $inc, 'expense' => $exp];
        }

        $maxMonthly = $maxMonthly ?: 1;
        $monthlyCashflow = array_map(function ($d) use ($maxMonthly) {
            $d['income_height']  = $d['income']  > 0 ? max(5, ($d['income']  / $maxMonthly) * 100) : 0;
            $d['expense_height'] = $d['expense'] > 0 ? max(5, ($d['expense'] / $maxMonthly) * 100) : 0;
            return $d;
        }, $monthlyCashflow);

        $topTransactions = $user->transactions()
            ->with(['category', 'wallet'])
            ->where('type', 'expense')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderByDesc('amount')
            ->take(10)
            ->get();

        $allTransactions = $user->transactions()
            ->with(['category', 'wallet'])
            ->whereBetween('date', [$startDate, $endDate])
            ->orderByDesc('date')
            ->orderByDesc('created_at')
            ->get();

        $budgetPerformance = $user->budgets()
            ->with('category')
            ->where('period', $month)
            ->get()
            ->map(function ($budget) use ($user, $startDate, $endDate) {
                $spent = $user->transactions()
                    ->where('category_id', $budget->category_id)
                    ->where('type', 'expense')
                    ->whereBetween('date', [$startDate, $endDate])
                    ->sum('amount');
                $pct = $budget->amount > 0 ? min(100, ($spent / $budget->amount) * 100) : 0;
                return [
                    'name'       => $budget->category->name,
                    'icon'       => $budget->category->icon ?? 'category',
                    'amount'     => $budget->amount,
                    'spent'      => $spent,
                    'remaining'  => max(0, $budget->amount - $spent),
                    'percentage' => round($pct),
                ];
            })
            ->sortByDesc('percentage')
            ->values();

        $monthOptions = [];
        for ($i = 0; $i < 12; $i++) {
            $d = Carbon::now()->subMonths($i);
            $monthOptions[] = ['value' => $d->format('Y-m'), 'label' => $d->isoFormat('MMMM YYYY')];
        }

        return compact(
            'totalIncome', 'totalExpense', 'netBalance',
            'expenseByCategory', 'monthlyCashflow',
            'topTransactions', 'allTransactions',
            'budgetPerformance', 'monthOptions'
        );
    }

    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $data = $this->getData($month);
        return view('reports', array_merge($data, ['month' => $month]));
    }

    public function downloadPdf(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $monthLabel = Carbon::parse($month . '-01')->isoFormat('MMMM YYYY');
        $data = $this->getData($month);

        $pdf = Pdf::loadView('exports.report-pdf', array_merge($data, [
            'month'      => $month,
            'monthLabel' => $monthLabel,
        ]))->setPaper('a4', 'portrait');

        $filename = 'Laporan_Keuangan_' . str_replace('-', '_', $month) . '.pdf';
        return $pdf->download($filename);
    }

    public function downloadExcel(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $monthLabel = Carbon::parse($month . '-01')->isoFormat('MMMM YYYY');
        $data = $this->getData($month);

        $summary = [
            'income'  => $data['totalIncome'],
            'expense' => $data['totalExpense'],
            'net'     => $data['netBalance'],
        ];

        $filename = 'Laporan_Keuangan_' . str_replace('-', '_', $month) . '.xlsx';

        return Excel::download(new ReportExport(
            summary: $summary,
            expenseByCategory: $data['expenseByCategory'],
            allTransactions: $data['allTransactions'],
            budgetPerformance: $data['budgetPerformance'],
            month: $month,
            monthLabel: $monthLabel,
        ), $filename);
    }
}
