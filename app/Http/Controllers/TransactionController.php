<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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
        $validated = $this->validateTransaction($request);

        $wallet = Auth::user()->wallets()->findOrFail($validated['wallet_id']);

        DB::transaction(function () use ($validated, $wallet) {
            $transaction = Auth::user()->transactions()->create($validated);

            $this->applyTransactionEffect($transaction, $wallet, $validated['to_wallet_id'] ? Auth::user()->wallets()->findOrFail($validated['to_wallet_id']) : null);
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dicatat.');
    }

    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('update', $transaction);

        $validated = $this->validateTransaction($request, $transaction);

        DB::transaction(function () use ($transaction, $validated) {
            $oldWallet = Auth::user()->wallets()->findOrFail($transaction->wallet_id);
            $oldToWallet = $transaction->to_wallet_id
                ? Auth::user()->wallets()->findOrFail($transaction->to_wallet_id)
                : null;

            $this->revertTransactionEffect($transaction, $oldWallet, $oldToWallet);

            $transaction->update($validated);

            $newWallet = Auth::user()->wallets()->findOrFail($transaction->wallet_id);
            $newToWallet = $transaction->to_wallet_id
                ? Auth::user()->wallets()->findOrFail($transaction->to_wallet_id)
                : null;

            $this->applyTransactionEffect($transaction, $newWallet, $newToWallet);
        });

        return redirect()->back()->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        DB::transaction(function () use ($transaction) {
            $wallet = $transaction->wallet;
            $toWallet = $transaction->toWallet;

            $this->revertTransactionEffect($transaction, $wallet, $toWallet);

            $transaction->delete();
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }

    private function validateTransaction(Request $request, ?Transaction $transaction = null): array
    {
        $user = Auth::user();

        $validated = $request->validate([
            'wallet_id' => [
                'required',
                Rule::exists('wallets', 'id')->where('user_id', $user->id),
            ],
            'category_id' => [
                'nullable',
                Rule::exists('categories', 'id')->where('user_id', $user->id),
            ],
            'to_wallet_id' => [
                'required_if:type,transfer',
                'nullable',
                Rule::exists('wallets', 'id')->where('user_id', $user->id),
            ],
            'type' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:255',
            'date' => 'required|date',
        ]);

        if ($validated['type'] !== 'transfer') {
            $validated['to_wallet_id'] = null;
        }

        if ($validated['type'] === 'transfer') {
            $validated['category_id'] = null;
        }

        if (
            $validated['type'] === 'transfer'
            && isset($validated['to_wallet_id'])
            && (int) $validated['wallet_id'] === (int) $validated['to_wallet_id']
        ) {
            abort(422, 'Dompet tujuan transfer harus berbeda.');
        }

        return $validated;
    }

    private function applyTransactionEffect(Transaction $transaction, $wallet, $toWallet = null): void
    {
        if ($transaction->type === 'income') {
            $wallet->increment('balance', $transaction->amount);
            return;
        }

        if ($transaction->type === 'expense') {
            $wallet->decrement('balance', $transaction->amount);
            return;
        }

        if ($transaction->type === 'transfer' && $toWallet) {
            $wallet->decrement('balance', $transaction->amount);
            $toWallet->increment('balance', $transaction->amount);
        }
    }

    private function revertTransactionEffect(Transaction $transaction, $wallet, $toWallet = null): void
    {
        if ($transaction->type === 'income') {
            $wallet->decrement('balance', $transaction->amount);
            return;
        }

        if ($transaction->type === 'expense') {
            $wallet->increment('balance', $transaction->amount);
            return;
        }

        if ($transaction->type === 'transfer' && $toWallet) {
            $wallet->increment('balance', $transaction->amount);
            $toWallet->decrement('balance', $transaction->amount);
        }
    }
}
