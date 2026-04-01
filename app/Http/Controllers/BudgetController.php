<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BudgetController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $currentPeriod = now()->format('Y-m');
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $budgets = $user->budgets()
            ->with('category')
            ->where('period', $currentPeriod)
            ->get()
            ->map(function ($budget) use ($user, $startOfMonth, $endOfMonth) {
            $spent = $user->transactions()
                ->where('category_id', $budget->category_id)
                ->where('type', 'expense')
                ->whereBetween('date', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            $percentage = $budget->amount > 0 ? min(100, ($spent / $budget->amount) * 100) : 0;
            $remaining = max(0, $budget->amount - $spent);

            return [
                'id'          => $budget->id,
                'category_id' => $budget->category_id,
                'name'        => $budget->category->name,
                'icon'        => $budget->category->icon ?? 'category',
                'amount'      => $budget->amount,
                'spent'       => $spent,
                'percentage'  => $percentage,
                'remaining'   => $remaining,
                'period'      => $budget->period,
            ];
        });

        $categories = $user->categories()->get();

        return view('budgets', compact('budgets', 'categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('user_id', $user->id),
            ],
            'amount' => 'required|numeric|min:0.01',
            'period' => 'required|string',
        ]);

        $existingBudget = $user->budgets()
            ->where('category_id', $validated['category_id'])
            ->where('period', $validated['period'])
            ->first();

        if ($existingBudget) {
            $existingBudget->increment('amount', $validated['amount']);

            return redirect()->back()->with('success', 'Anggaran kategori ini sudah ada, nominalnya langsung digabung.');
        }

        $user->budgets()->create($validated);

        return redirect()->back()->with('success', 'Anggaran baru berhasil ditetapkan.');
    }

    public function update(Request $request, Budget $budget)
    {
        $this->authorize('update', $budget);

        $user = Auth::user();

        $validated = $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('user_id', $user->id),
            ],
            'amount' => 'required|numeric|min:0.01',
            'period' => 'required|string',
        ]);

        DB::transaction(function () use ($budget, $validated, $user) {
            $duplicateBudget = $user->budgets()
                ->where('category_id', $validated['category_id'])
                ->where('period', $validated['period'])
                ->whereKeyNot($budget->id)
                ->lockForUpdate()
                ->first();

            if ($duplicateBudget) {
                $duplicateBudget->update([
                    'amount' => $duplicateBudget->amount + $validated['amount'],
                ]);

                $budget->delete();

                return;
            }

            $budget->update($validated);
        });

        return redirect()->back()->with('success', 'Anggaran berhasil diperbarui.');
    }

    public function destroy(Budget $budget)
    {
        $this->authorize('delete', $budget);
        $budget->delete();

        return redirect()->back()->with('success', 'Anggaran berhasil dihapus.');
    }
}
