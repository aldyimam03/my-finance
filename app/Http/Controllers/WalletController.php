<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    private array $walletTypes = ['Bank', 'E-Wallet', 'Investasi', 'Tunai', 'Kripto'];

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
        $walletTypes = $this->walletTypes;
        $walletColorPresets = array_values(Wallet::TYPE_COLORS);

        return view('create-wallet', compact('walletTypes', 'walletColorPresets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|in:' . implode(',', $this->walletTypes),
            'balance'  => 'required|numeric|min:0',
            'currency' => 'required|in:IDR',
            'color'    => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        Auth::user()->wallets()->create($this->buildWalletPayload($validated));

        return redirect()->route('wallets')->with('success', 'Dompet berhasil ditambahkan.');
    }

    public function edit(Wallet $wallet)
    {
        // Pastikan dompet milik user yang login
        if ($wallet->user_id != Auth::id()) {
            abort(403);
        }

        $walletTypes = $this->walletTypes;
        $walletColorPresets = array_values(Wallet::TYPE_COLORS);

        return view('edit-wallet', compact('wallet', 'walletTypes', 'walletColorPresets'));
    }

    public function update(Request $request, Wallet $wallet)
    {
        if ($wallet->user_id != Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'type'     => 'required|in:' . implode(',', $this->walletTypes),
            'balance'  => 'required|numeric',
            'currency' => 'required|in:IDR',
            'color'    => ['nullable', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $wallet->update($this->buildWalletPayload($validated));

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

    private function buildWalletPayload(array $validated): array
    {
        $validated['icon'] = Wallet::defaultIconForType($validated['type']);
        $validated['color'] = $validated['color'] ?: Wallet::defaultColorForType($validated['type']);

        return $validated;
    }
}
