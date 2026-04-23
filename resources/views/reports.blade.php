<x-app-layout title="Laporan & Analitik - My Finance">
    <div class="max-w-7xl mx-auto space-y-12">

        {{-- Header & Month Picker --}}
        <section class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div>
                <h2 class="text-3xl font-semibold tracking-tight text-on-surface mb-2">Analitik Keuangan</h2>
                <p class="text-on-surface-variant/60 text-sm">Pantau aliran dana dan performa anggaran Anda.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                {{-- Month Picker --}}
                <form method="GET" action="{{ route('reports') }}" id="monthForm">
                    <div class="glass-card flex items-center gap-2 px-4 py-2.5 rounded-xl border border-white/10">
                        <span class="material-symbols-outlined text-[20px] text-primary">calendar_month</span>
                        <select name="month" data-modal-title="Periode Laporan" onchange="document.getElementById('monthForm').submit()" class="bg-transparent border-none text-sm font-medium focus:ring-0 cursor-pointer text-on-surface outline-none pr-4">
                            @foreach($monthOptions as $opt)
                                <option value="{{ $opt['value'] }}" {{ $opt['value'] === $month ? 'selected' : '' }} class="bg-surface-container">
                                    {{ $opt['label'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                {{-- Download PDF --}}
                <a href="{{ route('reports.pdf', ['month' => $month]) }}"
                   class="flex items-center gap-2 px-5 py-2.5 bg-tertiary-container/20 border border-tertiary-container/30 text-tertiary-container rounded-xl hover:bg-tertiary-container/30 transition-all font-semibold text-sm">
                    <span class="material-symbols-outlined text-[18px]">picture_as_pdf</span>
                    PDF
                </a>

                {{-- Download Excel --}}
                <a href="{{ route('reports.excel', ['month' => $month]) }}"
                   class="flex items-center gap-2 px-5 py-2.5 bg-secondary/20 border border-secondary/30 text-secondary rounded-xl hover:bg-secondary/30 transition-all font-semibold text-sm">
                    <span class="material-symbols-outlined text-[18px]">table_chart</span>
                    Excel
                </a>
            </div>
        </section>

        {{-- Summary Cards --}}
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-surface-container-low rounded-3xl p-6 border border-white/5">
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/60 mb-2">Total Pemasukan</p>
                <p class="text-3xl font-bold text-secondary">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
            <div class="bg-surface-container-low rounded-3xl p-6 border border-white/5">
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/60 mb-2">Total Pengeluaran</p>
                <p class="text-3xl font-bold text-tertiary-container">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
            </div>
            <div class="bg-surface-container-low rounded-3xl p-6 border border-white/5">
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant/60 mb-2">Selisih Bersih</p>
                <p class="text-3xl font-bold {{ $netBalance >= 0 ? 'text-secondary' : 'text-tertiary-container' }}">
                    {{ $netBalance >= 0 ? '+' : '' }}Rp {{ number_format($netBalance, 0, ',', '.') }}
                </p>
            </div>
        </section>

        {{-- Analytics Grid --}}
        <div class="grid grid-cols-12 gap-6">

            {{-- Doughnut: Distribusi Pengeluaran --}}
            <div class="col-span-12 lg:col-span-5 bg-surface-container-low rounded-4xl p-8 shadow-xl">
                <h3 class="text-lg font-semibold mb-6">Distribusi Pengeluaran</h3>
                @if($expenseByCategory->count() > 0)
                    <div class="relative h-64">
                        <canvas id="categoryDoughnut"></canvas>
                    </div>
                    <div class="mt-6 space-y-3">
                        @php
                            $colors = ['rgba(78,222,163,0.9)', 'rgba(173,198,255,0.9)', 'rgba(255,81,106,0.9)', 'rgba(255,171,64,0.9)', 'rgba(129,199,132,0.9)', 'rgba(206,147,216,0.9)'];
                        @endphp
                        @foreach($expenseByCategory->take(6) as $i => $cat)
                        <div class="flex items-center justify-between p-2 hover:bg-white/5 rounded-lg transition-colors group">
                            <div class="flex items-center gap-3">
                                <span class="w-3 h-3 rounded-full shrink-0" style="background: {{ $colors[$i % count($colors)] }}"></span>
                                <span class="text-sm text-on-surface/80">{{ $cat['name'] }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-sm font-semibold">{{ $cat['percentage'] }}%</span>
                                <p class="text-[10px] text-on-surface-variant/60">Rp {{ number_format($cat['amount'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="h-64 flex items-center justify-center">
                        <p class="text-on-surface-variant/50 italic text-sm">Belum ada data pengeluaran bulan ini.</p>
                    </div>
                @endif
            </div>

            {{-- Arus Kas Bulanan (6 bulan) --}}
            <div class="col-span-12 lg:col-span-7 bg-surface-container-low rounded-4xl p-8 shadow-xl flex flex-col">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold">Arus Kas 6 Bulan Terakhir</h3>
                    <div class="flex items-center gap-4">
                        <span class="flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-secondary font-bold">
                            <span class="w-2 h-2 rounded-full bg-secondary"></span> Pemasukan
                        </span>
                        <span class="flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-tertiary-container font-bold">
                            <span class="w-2 h-2 rounded-full bg-tertiary-container"></span> Pengeluaran
                        </span>
                    </div>
                </div>
                <div class="relative h-56 flex-1">
                    <canvas id="monthlyCashflowChart"></canvas>
                </div>
            </div>

            {{-- Performa Anggaran --}}
            @if($budgetPerformance->count() > 0)
            <div class="col-span-12 lg:col-span-6 bg-surface-container-low rounded-4xl p-8 shadow-xl">
                <h3 class="text-lg font-semibold mb-6">Performa Anggaran</h3>
                <div class="space-y-5">
                    @foreach($budgetPerformance as $b)
                    @php
                        $pctColor = $b['percentage'] >= 90 ? 'bg-tertiary-container' : ($b['percentage'] >= 75 ? 'bg-amber-400' : 'bg-secondary');
                        $textColor = $b['percentage'] >= 90 ? 'text-tertiary-container' : ($b['percentage'] >= 75 ? 'text-amber-400' : 'text-secondary');
                    @endphp
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm {{ $textColor }}">{{ $b['icon'] }}</span>
                                <span class="text-sm font-medium">{{ $b['name'] }}</span>
                            </div>
                            <span class="text-xs font-mono {{ $textColor }}">{{ $b['percentage'] }}%</span>
                        </div>
                        <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full {{ $pctColor }} transition-all duration-700" style="width: {{ min(100, $b['percentage']) }}%"></div>
                        </div>
                        <div class="flex justify-between mt-1.5">
                            <span class="text-[10px] text-on-surface-variant/50">Rp {{ number_format($b['spent'], 0, ',', '.') }} terpakai</span>
                            <span class="text-[10px] text-on-surface-variant/50">Limit Rp {{ number_format($b['amount'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Top Pengeluaran Terbesar --}}
            <div class="col-span-12 {{ $budgetPerformance->count() > 0 ? 'lg:col-span-6' : '' }} bg-surface-container-low rounded-4xl p-8 shadow-xl">
                <h3 class="text-lg font-semibold mb-6">Pengeluaran Terbesar</h3>
                @if($topTransactions->count() > 0)
                <div class="space-y-3">
                    @foreach($topTransactions as $trx)
                    <div class="flex items-center justify-between p-3 bg-surface-container-high/50 rounded-xl hover:bg-surface-container-highest transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-sm text-tertiary-container">{{ $trx->category->icon ?? 'payments' }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-medium group-hover:text-primary transition-colors">{{ $trx->description ?? 'Tanpa Deskripsi' }}</p>
                                <p class="text-[10px] text-on-surface-variant/60">{{ $trx->category->name ?? '-' }} · {{ $trx->date->format('d M') }}</p>
                            </div>
                        </div>
                        <span class="text-sm font-bold text-tertiary-container">-Rp {{ number_format($trx->amount, 0, ',', '.') }}</span>
                    </div>
                    @endforeach
                </div>
                @else
                    <p class="text-on-surface-variant/50 italic text-sm text-center py-8">Belum ada pengeluaran bulan ini.</p>
                @endif
            </div>
        </div>

        {{-- Semua Transaksi Bulan Ini --}}
        <section>
            <h3 class="text-xl font-semibold mb-6">Semua Transaksi Bulan Ini</h3>
            <div class="bg-surface-container-low rounded-4xl border border-white/5">
                <div class="overflow-x-auto rounded-b-4xl">
                    <table class="w-full text-left">
                        <thead class="bg-white/5 border-b border-white/5">
                            <tr>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Deskripsi</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Kategori</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Dompet</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Tanggal</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @forelse($allTransactions as $trx)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium">{{ $trx->description ?? 'Tanpa Deskripsi' }}</td>
                                <td class="px-6 py-4">
                                    <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-white/5 border border-white/5 text-on-surface-variant">
                                        {{ $trx->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant/70">{{ $trx->wallet->name ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant/70">{{ $trx->date->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-right font-bold {{ $trx->type === 'income' ? 'text-secondary' : 'text-tertiary-container' }}">
                                    {{ $trx->type === 'income' ? '+' : '-' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant/50 italic">Belum ada transaksi pada periode ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    const formatRp = (v) => 'Rp ' + new Intl.NumberFormat('id-ID').format(v);

    // ==== DOUGHNUT CHART ====
    const doughnutCtx = document.getElementById('categoryDoughnut');
    if (doughnutCtx) {
        const catData = @json($expenseByCategory);
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: catData.map(d => d.name),
                datasets: [{
                    data: catData.map(d => d.amount),
                    backgroundColor: [
                        'rgba(78,222,163,0.85)', 'rgba(173,198,255,0.85)', 'rgba(255,81,106,0.85)',
                        'rgba(255,171,64,0.85)', 'rgba(129,199,132,0.85)', 'rgba(206,147,216,0.85)',
                        'rgba(100,181,246,0.85)',
                    ],
                    borderColor: 'rgba(255,255,255,0.05)',
                    borderWidth: 2,
                    hoverOffset: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(22,27,34,0.95)',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 12,
                        callbacks: {
                            label: (ctx) => ` ${ctx.label}: ${formatRp(ctx.parsed)} (${catData[ctx.dataIndex].percentage}%)`
                        }
                    }
                }
            }
        });
    }

    // ==== MONTHLY CASHFLOW CHART ====
    const monthlyCtx = document.getElementById('monthlyCashflowChart');
    if (monthlyCtx) {
        const mData = @json($monthlyCashflow);
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: mData.map(d => d.month),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: mData.map(d => d.income),
                        backgroundColor: 'rgba(78,222,163,0.7)',
                        borderColor: 'rgba(78,222,163,1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    },
                    {
                        label: 'Pengeluaran',
                        data: mData.map(d => d.expense),
                        backgroundColor: 'rgba(255,81,106,0.7)',
                        borderColor: 'rgba(255,81,106,1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(22,27,34,0.95)',
                        borderColor: 'rgba(255,255,255,0.08)',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 12,
                        callbacks: {
                            label: (ctx) => ` ${ctx.dataset.label}: ${formatRp(ctx.parsed.y)}`
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { color: 'rgba(255,255,255,0.04)', drawTicks: false },
                        ticks: { color: 'rgba(255,255,255,0.4)', font: { size: 11, family: 'Inter' }, padding: 8 },
                        border: { display: false },
                    },
                    y: {
                        grid: { color: 'rgba(255,255,255,0.04)', drawTicks: false },
                        ticks: {
                            color: 'rgba(255,255,255,0.4)',
                            font: { size: 10, family: 'Inter' },
                            padding: 8,
                            callback: (v) => {
                                if (v >= 1000000) return 'Rp ' + (v/1000000).toFixed(1) + 'jt';
                                if (v >= 1000) return 'Rp ' + (v/1000).toFixed(0) + 'rb';
                                return 'Rp ' + v;
                            }
                        },
                        border: { display: false },
                    }
                }
            }
        });
    }
})();
</script>
