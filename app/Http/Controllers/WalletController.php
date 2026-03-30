<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $wallets = Auth::user()->wallets()->get();
        return view('wallets', compact('wallets'));
    }

    public function show(Wallet $wallet)
    {
        if ($wallet->user_id != Auth::id()) {
            abort(403);
        }

        $transactions = $wallet->transactions()->latest()->paginate(10);
        return view('show-wallet', compact('wallet', 'transactions'));
    }

    public function create()
    {
        return view('create-wallet');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string',
            'balance'  => 'required|numeric|min:0',
            'currency' => 'required|string',
            'icon'     => 'nullable|string',
            'color'    => 'nullable|string',
        ]);

        Auth::user()->wallets()->create($validated);

        return redirect()->route('wallets')->with('success', 'Dompet berhasil ditambahkan.');
    }

    public function edit(Wallet $wallet)
    {
        // Pastikan dompet milik user yang login
        if ($wallet->user_id != Auth::id()) {
            abort(403);
        }

        return view('edit-wallet', compact('wallet'));
    }

    public function update(Request $request, Wallet $wallet)
    {
        if ($wallet->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|string',
            'balance'  => 'required|numeric',
            'currency' => 'required|string',
            'icon'     => 'nullable|string',
            'color'    => 'nullable|string',
        ]);

        $wallet->update($validated);

        return redirect()->route('wallets')->with('success', 'Dompet berhasil diperbarui.');
    }

    public function destroy(Wallet $wallet)
    {
        if ($wallet->user_id != Auth::id()) {
            abort(403);
        }

        $wallet->delete();

        return redirect()->route('wallets')->with('success', 'Dompet berhasil dihapus.');
    }
}
