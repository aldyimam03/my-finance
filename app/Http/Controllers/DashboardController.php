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

        // Total Balance Calculation across all wallets
        $totalBalance = $user->wallets()->sum('balance');

        // Monthly Stats (Current Month)
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
            $income = $user->transactions()
                ->where('type', 'income')
                ->whereDate('date', $date)
                ->sum('amount');
            $expense = $user->transactions()
                ->where('type', 'expense')
                ->whereDate('date', $date)
                ->sum('amount');

            $cashflowRaw[] = [
                'day' => $date->isoFormat('ddd'),
                'income' => $income,
                'expense' => $expense,
            ];
            
            $maxTotal = max($maxTotal, $income, $expense);
        }

        $maxTotal = $maxTotal ?: 1; // Prevent division by zero
        $cashflowData = array_map(function($data) use ($maxTotal) {
            $data['income_height'] = $data['income'] > 0 ? max(5, ($data['income'] / $maxTotal) * 100) : 0;
            $data['expense_height'] = $data['expense'] > 0 ? max(5, ($data['expense'] / $maxTotal) * 100) : 0;
            return $data;
        }, $cashflowRaw);

        // Active Wallets (Top 3 or recent)
        $activeWallets = $user->wallets()->orderBy('updated_at', 'desc')->take(3)->get();

        // Recent Transactions (Last 5)
        $recentTransactions = $user->transactions()
            ->with(['wallet', 'category'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Budget Analysis (Current Month)
        $budgets = $user->budgets()->with('category')->get()->map(function ($budget) use ($user, $startOfMonth, $endOfMonth) {
            $spent = $user->transactions()
                ->where('category_id', $budget->category_id)
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $percentage = $budget->amount > 0 ? min(100, ($spent / $budget->amount) * 100) : 0;
            $remaining = max(0, $budget->amount - $spent);

            return [
                'name' => $budget->category->name,
                'amount' => $budget->amount,
                'spent' => $spent,
                'percentage' => $percentage,
                'remaining' => $remaining,
            ];
        });

        return view('dashboard', compact(
            'totalBalance',
            'monthlyIncome',
            'monthlyExpense',
            'cashflowData',
            'activeWallets',
            'recentTransactions',
            'budgets'
        ));
    }
}
