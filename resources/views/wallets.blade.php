<x-app-layout title="Dompet & Aset - My Finance">
    <!-- Header Section -->
    <section class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <h2 class="font-['Inter'] font-semibold text-on-surface-variant uppercase tracking-widest text-[11px] mb-2">Ikhtisar Kekayaan</h2>
            <div class="flex flex-wrap items-baseline gap-4">
                <h3 class="font-['Inter'] text-[3.5rem] font-semibold tracking-tight text-on-surface leading-none">Rp 1.450.800.000</h3>
                <span class="flex items-center text-secondary font-medium text-sm px-2 py-1 rounded-full bg-secondary/10 border border-secondary/20 h-fit">
                    <span class="material-symbols-outlined text-[18px] mr-1" data-icon="trending_up">trending_up</span>
                    +12.5%
                </span>
            </div>
            <p class="text-on-surface-variant/60 mt-4 font-['Inter'] text-sm max-w-md">Kalkulasi total aset bersih Anda di seluruh instrumen keuangan per hari ini.</p>
        </div>
        <a href="{{ route('wallets.create') }}" class="px-6 py-4 bg-linear-to-br from-primary to-primary-container text-on-primary-container font-bold rounded-xl flex items-center gap-3 shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all shrink-0">
            <span class="material-symbols-outlined" data-icon="add_card">add_card</span>
            Tambah Dompet Baru
        </a>
    </section>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-12 gap-6">
        <!-- Wealth Distribution Chart Card -->
        <div class="col-span-12 lg:col-span-4 glass-card rounded-4xl p-8 flex flex-col justify-between">
            <div>
                <h4 class="text-on-surface font-semibold text-lg mb-6 flex items-center justify-between">
                    Distribusi Aset
                    <span class="material-symbols-outlined text-on-surface-variant/40" data-icon="more_vert">more_vert</span>
                </h4>
                <!-- Abstract Donut Representation -->
                <div class="relative w-48 h-48 mx-auto my-8">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <circle class="stroke-surface-container-highest" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                        <!-- Bank (65%) -->
                        <circle class="stroke-primary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="65, 100" stroke-linecap="round" stroke-width="4"></circle>
                        <!-- Crypto (25%) -->
                        <circle class="stroke-secondary" cx="18" cy="18" fill="none" r="16" stroke-dasharray="25, 100" stroke-dashoffset="-65" stroke-linecap="round" stroke-width="4"></circle>
                        <!-- Cash (10%) -->
                        <circle class="stroke-tertiary-container" cx="18" cy="18" fill="none" r="16" stroke-dasharray="10, 100" stroke-dashoffset="-90" stroke-linecap="round" stroke-width="4"></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Total</span>
                        <span class="text-xl font-bold">100%</span>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_rgba(173,198,255,0.6)]"></span>
                        <span class="text-sm font-medium text-on-surface-variant">Bank</span>
                    </div>
                    <span class="text-sm font-semibold">65%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-secondary shadow-[0_0_8px_rgba(78,222,163,0.6)]"></span>
                        <span class="text-sm font-medium text-on-surface-variant">Kripto</span>
                    </div>
                    <span class="text-sm font-semibold">25%</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-tertiary-container shadow-[0_0_8px_rgba(255,81,106,0.6)]"></span>
                        <span class="text-sm font-medium text-on-surface-variant">Tunai</span>
                    </div>
                    <span class="text-sm font-semibold">10%</span>
                </div>
            </div>
        </div>

        <!-- Wallet Grid -->
        <div class="col-span-12 lg:col-span-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card: BCA -->
            <div class="bg-surface-container-high hover:bg-surface-container-highest transition-all duration-300 rounded-4xl p-8 border border-white/5 group relative overflow-hidden cursor-pointer">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-primary/10 blur-[60px] rounded-full group-hover:bg-primary/20 transition-all"></div>
                <div class="flex justify-between items-start mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-2xl" data-icon="account_balance">account_balance</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 bg-primary/20 text-primary rounded-full">Primary</span>
                </div>
                <div>
                    <h5 class="text-on-surface-variant text-sm font-medium mb-1 group-hover:text-primary transition-colors">BCA Priority</h5>
                    <p class="text-on-surface-variant/40 text-xs font-mono mb-4">**** **** 8921</p>
                    <p class="text-2xl font-bold tracking-tight">Rp 842.500.000</p>
                </div>
                <div class="mt-8 flex gap-2">
                    <div class="h-1 flex-1 bg-surface-variant rounded-full overflow-hidden">
                        <div class="h-full bg-primary w-3/4 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Card: Mandiri -->
            <div class="bg-surface-container-high hover:bg-surface-container-highest transition-all duration-300 rounded-4xl p-8 border border-white/5 group relative overflow-hidden cursor-pointer">
                <div class="flex justify-between items-start mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-surface-variant text-2xl" data-icon="credit_card">credit_card</span>
                    </div>
                </div>
                <div>
                    <h5 class="text-on-surface-variant text-sm font-medium mb-1 group-hover:text-on-surface transition-colors">Mandiri Savings</h5>
                    <p class="text-on-surface-variant/40 text-xs font-mono mb-4">**** **** 1044</p>
                    <p class="text-2xl font-bold tracking-tight">Rp 125.300.000</p>
                </div>
                <div class="mt-8 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity items-center">
                    <button class="text-[10px] uppercase font-bold tracking-wider text-primary hover:text-primary-container">Detail</button>
                    <span class="text-on-surface-variant/20">•</span>
                    <button class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant hover:text-on-surface">Mutasi</button>
                </div>
            </div>

            <!-- Card: Binance -->
            <div class="bg-surface-container-high hover:bg-surface-container-highest transition-all duration-300 rounded-4xl p-8 border border-white/5 group relative overflow-hidden cursor-pointer">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-secondary/10 blur-[60px] rounded-full group-hover:bg-secondary/20 transition-all"></div>
                <div class="flex justify-between items-start mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary text-2xl" data-icon="currency_bitcoin">currency_bitcoin</span>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] text-secondary font-bold uppercase tracking-wider">Kripto</p>
                        <p class="text-[9px] text-on-surface-variant/40">+4.2% (24h)</p>
                    </div>
                </div>
                <div>
                    <h5 class="text-on-surface-variant text-sm font-medium mb-1 group-hover:text-secondary transition-colors">Binance Global</h5>
                    <p class="text-on-surface-variant/40 text-xs font-mono mb-4">Spot Wallet (BTC/USDT)</p>
                    <p class="text-2xl font-bold tracking-tight">Rp 368.000.000</p>
                </div>
                <div class="mt-8">
                    <!-- Trend Micro-Chart -->
                    <div class="flex items-end gap-1 h-6">
                        <div class="w-1 bg-secondary/20 h-2 rounded-full"></div>
                        <div class="w-1 bg-secondary/30 h-3 rounded-full"></div>
                        <div class="w-1 bg-secondary/40 h-4 rounded-full"></div>
                        <div class="w-1 bg-secondary/60 h-2 rounded-full"></div>
                        <div class="w-1 bg-secondary/40 h-5 rounded-full"></div>
                        <div class="w-1 bg-secondary/80 h-4 rounded-full"></div>
                        <div class="w-1 bg-secondary h-6 rounded-full shadow-[0_0_8px_rgba(78,222,163,0.4)]"></div>
                    </div>
                </div>
            </div>

            <!-- Card: Cash -->
            <div class="bg-surface-container-high hover:bg-surface-container-highest transition-all duration-300 rounded-4xl p-8 border border-white/5 group relative overflow-hidden cursor-pointer">
                <div class="flex justify-between items-start mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-white/5 flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary-container text-2xl" data-icon="payments" style="font-variation-settings: 'FILL' 1;">payments</span>
                    </div>
                </div>
                <div>
                    <h5 class="text-on-surface-variant text-sm font-medium mb-1 group-hover:text-tertiary-container transition-colors">Kas Tunai (Dompet)</h5>
                    <p class="text-on-surface-variant/40 text-xs font-mono mb-4">IDR • Physical</p>
                    <p class="text-2xl font-bold tracking-tight">Rp 115.000.000</p>
                </div>
                <div class="mt-8 flex justify-between items-center">
                    <span class="text-[10px] text-on-surface-variant font-medium">Terakhir diupdate: 2 jam lalu</span>
                    <span class="material-symbols-outlined text-on-surface-variant/20 text-lg group-hover:rotate-180 transition-transform duration-500" data-icon="sync">sync</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Preview (Contextual to Wallets) -->
    <section class="mt-12">
        <h4 class="text-on-surface font-semibold text-lg mb-6 px-2">Aktivitas Terkini</h4>
        <div class="bg-surface-container-low rounded-4xl border border-white/5 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-b border-white/5 bg-white/5">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Transaksi</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Dompet</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Jumlah</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-secondary/10 transition-colors">
                                        <span class="material-symbols-outlined text-secondary text-[20px]" data-icon="arrow_downward">arrow_downward</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium group-hover:text-secondary transition-colors">Dividen Saham BBCA</p>
                                        <p class="text-xs text-on-surface-variant/60">12 Okt 2023 • 14:20</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-surface-container-highest border border-white/5">BCA Priority</span>
                            </td>
                            <td class="px-8 py-5 text-right font-semibold text-secondary">+ Rp 12.450.000</td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-secondary">Berhasil</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-tertiary-container/10 transition-colors">
                                        <span class="material-symbols-outlined text-tertiary-container text-[20px]" data-icon="shopping_bag">shopping_bag</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium group-hover:text-primary transition-colors">Apple Store Singapore</p>
                                        <p class="text-xs text-on-surface-variant/60">10 Okt 2023 • 09:15</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-surface-container-highest border border-white/5">Mandiri Savings</span>
                            </td>
                            <td class="px-8 py-5 text-right font-semibold text-tertiary-container">- Rp 24.999.000</td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Selesai</span>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                        <span class="material-symbols-outlined text-primary text-[20px]" data-icon="currency_exchange">currency_exchange</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium group-hover:text-primary transition-colors">Beli Bitcoin (BTC)</p>
                                        <p class="text-xs text-on-surface-variant/60">08 Okt 2023 • 22:45</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[10px] font-medium px-3 py-1 rounded-full bg-surface-container-highest border border-white/5">Binance Global</span>
                            </td>
                            <td class="px-8 py-5 text-right font-semibold text-tertiary-container">- Rp 50.000.000</td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Selesai</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="p-6 text-center border-t border-white/5 bg-white/1">
                <button class="text-[11px] font-bold uppercase tracking-widest text-primary hover:text-primary-container transition-colors">Lihat Semua Histori</button>
            </div>
        </div>
    </section>
</x-app-layout>
