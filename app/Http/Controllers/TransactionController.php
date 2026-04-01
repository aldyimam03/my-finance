<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->transactions()->with(['wallet', 'category', 'toWallet']);
        $sortBy = $request->input('sort_by', 'date');
        $sortDir = $request->input('sort_dir', 'desc');

        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('wallet_id') && $request->wallet_id != 'all') {
            $query->where('wallet_id', $request->wallet_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $allowedSorts = ['date', 'description', 'category', 'wallet', 'amount', 'type'];

        if (! in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'date';
        }

        if (! in_array($sortDir, ['asc', 'desc'], true)) {
            $sortDir = 'desc';
        }

        $transactions = $query->orderBy('date', 'desc')->orderBy('created_at', 'desc')->get()
            ->sortBy(
                fn (Transaction $transaction) => match ($sortBy) {
                    'description' => strtolower((string) ($transaction->description ?? '')),
                    'category' => strtolower((string) ($transaction->category->name ?? '')),
                    'wallet' => strtolower((string) ($transaction->wallet->name ?? '')),
                    'amount' => (float) $transaction->amount,
                    'type' => strtolower((string) $transaction->type),
                    default => $transaction->date?->timestamp ?? 0,
                },
                options: SORT_NATURAL,
                descending: $sortDir === 'desc'
            )
            ->values();

        $perPage = 10;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentItems = $transactions->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $transactions = new LengthAwarePaginator(
            $currentItems,
            $transactions->count(),
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        $wallets = Auth::user()->wallets()->get();
        $categories = Auth::user()->categories()->get();

        return view('transactions', compact('transactions', 'wallets', 'categories', 'sortBy', 'sortDir'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'category_id' => 'nullable|exists:categories,id',
            'to_wallet_id' => 'required_if:type,transfer|nullable|exists:wallets,id',
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        $wallet = Auth::user()->wallets()->findOrFail($validated['wallet_id']);

        DB::transaction(function () use ($validated, $wallet) {
            $transaction = Auth::user()->transactions()->create($validated);

            if ($validated['type'] === 'income') {
                $wallet->increment('balance', $validated['amount']);
            } elseif ($validated['type'] === 'expense') {
                $wallet->decrement('balance', $validated['amount']);
            } elseif ($validated['type'] === 'transfer') {
                $toWallet = Auth::user()->wallets()->findOrFail($validated['to_wallet_id']);
                $wallet->decrement('balance', $validated['amount']);
                $toWallet->increment('balance', $validated['amount']);
            }
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        DB::transaction(function () use ($transaction) {
            $wallet = $transaction->wallet;

            if ($transaction->type === 'income') {
                $wallet->decrement('balance', $transaction->amount);
            } elseif ($transaction->type === 'expense') {
                $wallet->increment('balance', $transaction->amount);
            } elseif ($transaction->type === 'transfer') {
                $toWallet = $transaction->toWallet;
                $wallet->increment('balance', $transaction->amount);
                $toWallet->decrement('balance', $transaction->amount);
            }

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
