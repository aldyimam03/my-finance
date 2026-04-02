<x-app-layout title="Pencarian - My Finance">
    <div class="max-w-6xl mx-auto space-y-8">
        <section class="flex flex-col gap-3">
            <span class="text-[11px] uppercase tracking-[0.08em] text-on-surface-variant">Pencarian</span>
            <h1 class="text-3xl font-semibold tracking-tight">
                @if($query !== '')
                    Hasil untuk "{{ $query }}"
                @else
                    Masukkan kata kunci pencarian
                @endif
            </h1>
            <p class="text-sm text-on-surface-variant/70">
                Cari transaksi berdasarkan deskripsi, kategori, dompet, atau gunakan kata seperti bulan dan "laporan" untuk membuka laporan terkait.
            </p>
        </section>

        @if($query === '')
            <section class="rounded-3xl border border-white/5 bg-surface-container-low p-8 text-center">
                <p class="text-on-surface-variant/70">Search bar di navbar sekarang aktif. Ketik kata kunci lalu tekan Enter.</p>
            </section>
        @else
            <section class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 rounded-3xl border border-white/5 bg-surface-container-low overflow-hidden">
                    <div class="px-6 py-5 border-b border-white/5 flex items-center justify-between gap-4">
                        <h2 class="text-lg font-semibold">Transaksi</h2>
                        <span class="text-xs text-on-surface-variant/60">{{ $transactions->count() }} hasil</span>
                    </div>

                    @if($transactions->isEmpty())
                        <div class="px-6 py-10 text-sm text-on-surface-variant/70">
                            Tidak ada transaksi yang cocok dengan kata kunci ini.
                        </div>
                    @else
                        <div class="divide-y divide-white/5">
                            @foreach($transactions as $transaction)
                                <div class="px-6 py-4 flex items-center justify-between gap-4 hover:bg-white/5 transition-colors">
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-on-surface truncate">
                                            {{ $transaction->description ?: 'Tanpa Deskripsi' }}
                                        </p>
                                        <p class="text-xs text-on-surface-variant/65 mt-1">
                                            {{ $transaction->category->name ?? 'Tanpa Kategori' }} • {{ $transaction->wallet->name ?? '-' }} • {{ $transaction->date->format('d M Y') }}
                                        </p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <p class="text-sm font-bold {{ $transaction->type === 'income' ? 'text-secondary' : 'text-tertiary-container' }}">
                                            {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </p>
                                        <a href="{{ route('transactions') }}" class="text-[11px] text-primary hover:underline">Buka transaksi</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="rounded-3xl border border-white/5 bg-surface-container-low overflow-hidden">
                    <div class="px-6 py-5 border-b border-white/5">
                        <h2 class="text-lg font-semibold">Laporan Terkait</h2>
                    </div>

                    @if($reportMatches->isEmpty())
                        <div class="px-6 py-10 text-sm text-on-surface-variant/70">
                            Tidak ada laporan yang cocok. Coba kata kunci seperti "laporan", "April 2026", atau "2026-04".
                        </div>
                    @else
                        <div class="p-4 space-y-3">
                            @foreach($reportMatches as $report)
                                <a href="{{ route('reports', ['month' => $report['value']]) }}"
                                   class="block rounded-2xl border border-white/5 bg-white/[0.03] px-4 py-4 hover:bg-white/[0.05] transition-colors">
                                    <p class="text-sm font-semibold text-on-surface">{{ $report['label'] }}</p>
                                    <p class="text-[11px] uppercase tracking-[0.08em] text-on-surface-variant/60 mt-1">Buka laporan bulanan</p>
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif
    </div>
</x-app-layout>
