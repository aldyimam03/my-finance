<x-app-layout title="Dasbor - My Finance">
    <!-- Summary Section: Editorial Scale -->
    <section class="mb-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <span class="label-sm text-[11px] uppercase tracking-[0.05em] text-on-surface-variant">Saldo Keseluruhan</span>
                <h2 class="text-[3.5rem] font-semibold tracking-tight text-on-surface leading-tight">Rp {{ number_format($totalBalance, 0, ',', '.') }}</h2>
            </div>
            <div class="flex gap-4">
                <div class="glass-card px-6 py-4 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary" data-icon="trending_up">trending_up</span>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-on-surface-variant">Pemasukan</p>
                        <p class="text-lg font-bold text-secondary">Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="glass-card px-6 py-4 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-tertiary-container/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary-container" data-icon="trending_down">trending_down</span>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-on-surface-variant">Pengeluaran</p>
                        <p class="text-lg font-bold text-tertiary-container">Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-12 gap-6">
        <!-- Cashflow Chart: Large Span -->
        <div class="col-span-12 lg:col-span-8 bg-surface-container-low p-8 rounded-xl shadow-lg border border-white/5 relative overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold">Arus Kas 7 Hari Terakhir</h3>
                <div class="flex gap-4">
                    <span class="flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-secondary font-bold">
                        <span class="w-2 h-2 rounded-full bg-secondary shadow-[0_0_8px_rgba(78,222,163,0.5)]"></span> Income
                    </span>
                    <span class="flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-tertiary-container font-bold">
                        <span class="w-2 h-2 rounded-full bg-tertiary-container shadow-[0_0_8px_rgba(255,81,106,0.5)]"></span> Expense
                    </span>
                </div>
            </div>
            <div class="relative h-64">
                <canvas id="cashflowChart"></canvas>
            </div>
        </div>
        
        <!-- Budget Overview: Focused Journey -->
        <div class="col-span-12 lg:col-span-4 space-y-6">
            <div class="bg-surface-container-low p-6 rounded-xl border border-white/5">
                <h3 class="text-sm font-semibold mb-6">Analisis Anggaran</h3>
                <div class="space-y-6">
                    @forelse($budgets as $budget)
                    <div>
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-on-surface">{{ $budget['name'] }}</span>
                            <span class="text-on-surface-variant font-medium">{{ round($budget['percentage']) }}%</span>
                        </div>
                        <div class="w-full h-1.5 bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full {{ $budget['percentage'] > 90 ? 'bg-tertiary-container' : 'bg-primary' }} rounded-full shadow-[0_0_10px_rgba(173,198,255,0.3)]" style="width: {{ $budget['percentage'] }}%"></div>
                        </div>
                        <p class="text-[10px] mt-2 text-on-surface-variant">Sisa: Rp {{ number_format($budget['remaining'], 0, ',', '.') }} / Rp {{ number_format($budget['amount'], 0, ',', '.') }}</p>
                    </div>
                    @empty
                    <p class="text-xs text-on-surface-variant/60 italic text-center py-4">Belum ada anggaran ditetapkan.</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Active Wallets: Tonal Depth -->
            <div class="bg-surface-container-low p-6 rounded-xl border border-white/5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-semibold">Dompet Aktif</h3>
                    <a href="{{ route('wallets') }}" class="text-[10px] uppercase font-bold text-primary tracking-widest hover:text-primary-container transition-colors">Lihat Semua</a>
                </div>
                <div class="space-y-3">
                    @foreach($activeWallets as $wallet)
                    <div class="flex items-center justify-between p-3 bg-surface-container-high/50 rounded-lg hover:bg-surface-container-high transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full {{ $wallet->color ?? 'bg-primary/10' }} flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm {{ $wallet->color ? 'text-white' : 'text-primary' }}">{{ $wallet->icon ?? 'account_balance' }}</span>
                            </div>
                            <span class="text-xs font-medium group-hover:text-primary transition-colors">{{ $wallet->name }}</span>
                        </div>
                        <span class="text-xs font-bold">Rp {{ number_format($wallet->balance, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Activities: Editorial Table -->
        <div class="col-span-12 mt-4">
            <div class="bg-surface-container-low rounded-xl border border-white/5 overflow-hidden">
                <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Transaksi Terakhir</h3>
                    <div class="flex gap-4">
                        <a href="{{ route('transactions') }}" class="px-4 py-1.5 text-xs rounded-full bg-surface-container-highest text-on-surface font-medium border border-white/5 hover:bg-surface-container-highest/80 transition-colors">Lihat Semua</a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="text-left font-['Inter']">
                                <th class="px-8 py-4 text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Aktivitas</th>
                                <th class="px-8 py-4 text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Kategori</th>
                                <th class="px-8 py-4 text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Tanggal</th>
                                <th class="px-8 py-4 text-[10px] uppercase tracking-widest text-on-surface-variant font-bold text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($recentTransactions as $transaction)
                            <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-surface-variant transition-colors">
                                            <span class="material-symbols-outlined text-on-surface">{{ $transaction->category->icon ?? 'payments' }}</span>
                                        </div>
                                        <span class="font-medium group-hover:text-primary transition-colors">{{ $transaction->description ?? 'Tanpa Deskripsi' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-full bg-surface-container-highest text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">
                                        {{ $transaction->category->name ?? 'Uncategorized' }}
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">{{ $transaction->date->format('d M Y') }}</td>
                                <td class="px-8 py-5 text-right font-bold {{ $transaction->type === 'income' ? 'text-secondary' : 'text-tertiary-container' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-10 text-center text-on-surface-variant/60 italic">Belum ada transaksi tercatat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const chartData = @json($cashflowData);
    const labels = chartData.map(d => d.day);
    const incomeData = chartData.map(d => d.income);
    const expenseData = chartData.map(d => d.expense);

    const formatRupiah = (value) => {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
    };

    const ctx = document.getElementById('cashflowChart');
    if (!ctx) return;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Pemasukan',
                    data: incomeData,
                    borderColor: 'rgba(78, 222, 163, 0.9)',
                    backgroundColor: 'rgba(78, 222, 163, 0.08)',
                    pointBackgroundColor: 'rgba(78, 222, 163, 1)',
                    pointBorderColor: 'rgba(78, 222, 163, 1)',
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                },
                {
                    label: 'Pengeluaran',
                    data: expenseData,
                    borderColor: 'rgba(255, 81, 106, 0.9)',
                    backgroundColor: 'rgba(255, 81, 106, 0.08)',
                    pointBackgroundColor: 'rgba(255, 81, 106, 1)',
                    pointBorderColor: 'rgba(255, 81, 106, 1)',
                    pointRadius: 5,
                    pointHoverRadius: 8,
                    borderWidth: 2.5,
                    tension: 0.4,
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    display: false,
                },
                tooltip: {
                    backgroundColor: 'rgba(22, 27, 34, 0.95)',
                    borderColor: 'rgba(255,255,255,0.08)',
                    borderWidth: 1,
                    padding: 14,
                    titleColor: 'rgba(255,255,255,0.7)',
                    titleFont: { size: 11, weight: 'bold', family: 'Inter' },
                    bodyColor: 'rgba(255,255,255,0.9)',
                    bodyFont: { size: 13, family: 'Inter' },
                    cornerRadius: 12,
                    callbacks: {
                        label: function(ctx) {
                            return ' ' + ctx.dataset.label + ': ' + formatRupiah(ctx.parsed.y);
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.04)',
                        drawTicks: false,
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.4)',
                        font: { size: 10, family: 'Inter' },
                        padding: 8,
                    },
                    border: { display: false },
                },
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.04)',
                        drawTicks: false,
                    },
                    ticks: {
                        color: 'rgba(255, 255, 255, 0.4)',
                        font: { size: 10, family: 'Inter' },
                        padding: 8,
                        callback: (value) => {
                            if (value >= 1000000) return 'Rp ' + (value/1000000).toFixed(1) + 'jt';
                            if (value >= 1000) return 'Rp ' + (value/1000).toFixed(0) + 'rb';
                            return 'Rp ' + value;
                        }
                    },
                    border: { display: false },
                }
            }
        }
    });
})();
</script>
