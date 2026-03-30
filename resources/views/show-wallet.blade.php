<x-app-layout title="Detail Dompet - My Finance">
    <div class="max-w-7xl mx-auto space-y-12">
        <!-- Header -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <a href="{{ route('wallets') }}" class="text-on-surface-variant/60 hover:text-primary flex items-center gap-2 mb-4 transition-colors group">
                    <span class="material-symbols-outlined text-sm group-hover:-translate-x-1 transition-transform">arrow_back</span>
                    <span class="text-xs uppercase tracking-widest font-bold">Kembali ke Daftar</span>
                </a>
                <h2 class="text-3xl font-bold tracking-tight text-on-surface">{{ $wallet->name }}</h2>
                <p class="text-on-surface-variant font-medium mt-1">{{ $wallet->type }} • {{ $wallet->currency }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('wallets.edit', $wallet) }}" class="px-6 py-3 bg-surface-container-high hover:bg-surface-container-highest text-on-surface font-bold rounded-xl transition-all border border-white/5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">edit</span>
                    Edit
                </a>
                <form action="{{ route('wallets.destroy', $wallet) }}" method="POST" onsubmit="return confirm('Hapus dompet ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-tertiary-container/10 hover:bg-tertiary-container text-tertiary-container hover:text-on-tertiary-container font-bold rounded-xl transition-all border border-tertiary-container/20 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px]">delete</span>
                        Hapus
                    </button>
                </form>
            </div>
        </header>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="glass-card p-8 rounded-3xl relative overflow-hidden">
                <div class="absolute -right-8 -top-8 w-32 h-32 {{ $wallet->color ?? 'bg-primary' }}/10 blur-[60px] rounded-full"></div>
                <span class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Saldo Saat Ini</span>
                <h3 class="text-4xl font-bold mt-4 tracking-tighter">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</h3>
            </div>
            <div class="glass-card p-8 rounded-3xl">
                <span class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Total Pemasukan (Bulan Ini)</span>
                <h3 class="text-3xl font-bold mt-4 text-secondary">+ Rp {{ number_format($wallet->transactions()->where('type', 'income')->whereMonth('date', now()->month)->sum('amount'), 0, ',', '.') }}</h3>
            </div>
            <div class="glass-card p-8 rounded-3xl">
                <span class="text-[10px] uppercase tracking-widest font-bold text-on-surface-variant/60">Total Pengeluaran (Bulan Ini)</span>
                <h3 class="text-3xl font-bold mt-4 text-tertiary-container">- Rp {{ number_format($wallet->transactions()->where('type', 'expense')->whereMonth('date', now()->month)->sum('amount'), 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Transaction History -->
        <section class="space-y-6">
            <h4 class="text-xl font-bold tracking-tight px-2">Riwayat Transaksi Dompet</h4>
            <div class="bg-surface-container-low rounded-3xl border border-white/5 overflow-hidden shadow-2xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white/5 border-b border-white/5">
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Tanggal</th>
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Deskripsi</th>
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Kategori</th>
                                <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Nominal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($transactions as $trx)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="px-8 py-5 text-sm text-on-surface-variant">{{ $trx->date->format('d M Y') }}</td>
                                <td class="px-8 py-5">
                                    <p class="text-sm font-medium">{{ $trx->description ?? '—' }}</p>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">{{ $trx->category->name ?? '—' }}</span>
                                </td>
                                <td class="px-8 py-5 text-right font-bold {{ $trx->type === 'income' ? 'text-secondary' : 'text-tertiary-container' }}">
                                    {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-16 text-center italic text-on-surface-variant/40">Belum ada transaksi untuk dompet ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($transactions->hasPages())
                <div class="px-8 py-6 border-t border-white/5 bg-white/1">
                    {{ $transactions->links() }}
                </div>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
