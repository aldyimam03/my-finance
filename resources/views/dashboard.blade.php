<x-app-layout title="Dasbor - My Finance">
    <!-- Summary Section: Editorial Scale -->
    <section class="mb-12">
        <div class="flex justify-between items-end mb-8">
            <div>
                <span class="label-sm text-[11px] uppercase tracking-[0.05em] text-on-surface-variant">Saldo Keseluruhan</span>
                <h2 class="text-[3.5rem] font-semibold tracking-tight text-on-surface leading-tight">Rp248.500.000</h2>
            </div>
            <div class="flex gap-4">
                <div class="glass-card px-6 py-4 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-secondary" data-icon="trending_up">trending_up</span>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-on-surface-variant">Pemasukan</p>
                        <p class="text-lg font-bold text-secondary">Rp12.450.000</p>
                    </div>
                </div>
                <div class="glass-card px-6 py-4 rounded-xl flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-tertiary-container/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-tertiary-container" data-icon="trending_down">trending_down</span>
                    </div>
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-on-surface-variant">Pengeluaran</p>
                        <p class="text-lg font-bold text-tertiary-container">Rp8.120.000</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-12 gap-6">
        <!-- Cashflow Chart: Large Span -->
        <div class="col-span-8 bg-surface-container-low p-8 rounded-xl shadow-lg border border-white/5 relative overflow-hidden">
            <div class="flex justify-between items-center mb-10">
                <h3 class="text-lg font-semibold">Arus Kas 7 Hari Terakhir</h3>
                <div class="flex gap-2">
                    <span class="flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-secondary font-bold">
                        <span class="w-2 h-2 rounded-full bg-secondary shadow-[0_0_8px_rgba(78,222,163,0.5)]"></span> Income
                    </span>
                    <span class="flex items-center gap-1.5 text-[10px] uppercase tracking-widest text-tertiary-container font-bold ml-4">
                        <span class="w-2 h-2 rounded-full bg-tertiary-container shadow-[0_0_8px_rgba(255,81,106,0.5)]"></span> Expense
                    </span>
                </div>
            </div>
            <div class="h-64 flex items-end justify-between gap-4 relative">
                <!-- SVG Chart Overlay for Premium Look -->
                <svg class="absolute inset-0 w-full h-full opacity-10 pointer-events-none" viewbox="0 0 800 200">
                    <path d="M0,150 Q100,100 200,160 T400,120 T600,180 T800,140" fill="none" stroke="#adc6ff" stroke-width="2"></path>
                </svg>
                <!-- Bars -->
                <div class="flex-1 flex flex-col justify-end group cursor-pointer">
                    <div class="flex gap-1 justify-center items-end h-full">
                        <div class="w-3 bg-secondary/80 rounded-t-sm transition-all group-hover:bg-secondary" style="height: 60%"></div>
                        <div class="w-3 bg-tertiary-container/80 rounded-t-sm transition-all group-hover:bg-tertiary-container" style="height: 40%"></div>
                    </div>
                    <p class="text-[10px] text-center mt-3 text-on-surface-variant font-medium">Sen</p>
                </div>
                <div class="flex-1 flex flex-col justify-end group cursor-pointer">
                    <div class="flex gap-1 justify-center items-end h-full">
                        <div class="w-3 bg-secondary/80 rounded-t-sm transition-all group-hover:bg-secondary" style="height: 80%"></div>
                        <div class="w-3 bg-tertiary-container/80 rounded-t-sm transition-all group-hover:bg-tertiary-container" style="height: 30%"></div>
                    </div>
                    <p class="text-[10px] text-center mt-3 text-on-surface-variant font-medium">Sel</p>
                </div>
                <div class="flex-1 flex flex-col justify-end group cursor-pointer">
                    <div class="flex gap-1 justify-center items-end h-full">
                        <div class="w-3 bg-secondary/80 rounded-t-sm transition-all group-hover:bg-secondary" style="height: 45%"></div>
                        <div class="w-3 bg-tertiary-container/80 rounded-t-sm transition-all group-hover:bg-tertiary-container" style="height: 70%"></div>
                    </div>
                    <p class="text-[10px] text-center mt-3 text-on-surface-variant font-medium">Rab</p>
                </div>
                <div class="flex-1 flex flex-col justify-end group cursor-pointer">
                    <div class="flex gap-1 justify-center items-end h-full">
                        <div class="w-3 bg-secondary/80 rounded-t-sm transition-all group-hover:bg-secondary" style="height: 95%"></div>
                        <div class="w-3 bg-tertiary-container/80 rounded-t-sm transition-all group-hover:bg-tertiary-container" style="height: 20%"></div>
                    </div>
                    <p class="text-[10px] text-center mt-3 text-on-surface-variant font-medium">Kam</p>
                </div>
                <div class="flex-1 flex flex-col justify-end group cursor-pointer">
                    <div class="flex gap-1 justify-center items-end h-full">
                        <div class="w-3 bg-secondary/80 rounded-t-sm transition-all group-hover:bg-secondary" style="height: 70%"></div>
                        <div class="w-3 bg-tertiary-container/80 rounded-t-sm transition-all group-hover:bg-tertiary-container" style="height: 55%"></div>
                    </div>
                    <p class="text-[10px] text-center mt-3 text-on-surface-variant font-medium">Jum</p>
                </div>
                <div class="flex-1 flex flex-col justify-end group cursor-pointer">
                    <div class="flex gap-1 justify-center items-end h-full">
                        <div class="w-3 bg-secondary/80 rounded-t-sm transition-all group-hover:bg-secondary" style="height: 40%"></div>
                        <div class="w-3 bg-tertiary-container/80 rounded-t-sm transition-all group-hover:bg-tertiary-container" style="height: 35%"></div>
                    </div>
                    <p class="text-[10px] text-center mt-3 text-on-surface-variant font-medium">Sab</p>
                </div>
                <div class="flex-1 flex flex-col justify-end group cursor-pointer">
                    <div class="flex gap-1 justify-center items-end h-full">
                        <div class="w-3 bg-secondary/80 rounded-t-sm transition-all group-hover:bg-secondary" style="height: 55%"></div>
                        <div class="w-3 bg-tertiary-container/80 rounded-t-sm transition-all group-hover:bg-tertiary-container" style="height: 45%"></div>
                    </div>
                    <p class="text-[10px] text-center mt-3 text-on-surface-variant font-medium">Min</p>
                </div>
            </div>
        </div>
        
        <!-- Budget Overview: Focused Journey -->
        <div class="col-span-4 space-y-6">
            <div class="bg-surface-container-low p-6 rounded-xl border border-white/5">
                <h3 class="text-sm font-semibold mb-6">Analisis Anggaran</h3>
                <div class="space-y-6">
                    <div>
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-on-surface">Makanan &amp; Minuman</span>
                            <span class="text-on-surface-variant font-medium">75%</span>
                        </div>
                        <div class="w-full h-1.5 bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-secondary-container rounded-full shadow-[0_0_10px_rgba(0,165,114,0.3)]" style="width: 75%"></div>
                        </div>
                        <p class="text-[10px] mt-2 text-on-surface-variant">Sisa: Rp1.250.000 / Rp5.000.000</p>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs mb-2">
                            <span class="text-on-surface">Hiburan &amp; Lifestyle</span>
                            <span class="text-on-surface-variant font-medium">40%</span>
                        </div>
                        <div class="w-full h-1.5 bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-primary rounded-full shadow-[0_0_10px_rgba(173,198,255,0.3)]" style="width: 40%"></div>
                        </div>
                        <p class="text-[10px] mt-2 text-on-surface-variant">Sisa: Rp1.800.000 / Rp3.000.000</p>
                    </div>
                </div>
            </div>
            
            <!-- Active Wallets: Tonal Depth -->
            <div class="bg-surface-container-low p-6 rounded-xl border border-white/5">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-sm font-semibold">Dompet Aktif</h3>
                    <button class="text-[10px] uppercase font-bold text-primary tracking-widest hover:text-primary-container transition-colors">Lihat Semua</button>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-surface-container-high/50 rounded-lg hover:bg-surface-container-high transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm text-primary" data-icon="account_balance">account_balance</span>
                            </div>
                            <span class="text-xs font-medium group-hover:text-primary transition-colors">Bank Utama</span>
                        </div>
                        <span class="text-xs font-bold">Rp185.2M</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-surface-container-high/50 rounded-lg hover:bg-surface-container-high transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm text-secondary" data-icon="monitoring">monitoring</span>
                            </div>
                            <span class="text-xs font-medium group-hover:text-secondary transition-colors">Investasi</span>
                        </div>
                        <span class="text-xs font-bold">Rp42.3M</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-surface-container-high/50 rounded-lg hover:bg-surface-container-high transition-colors group cursor-pointer">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-tertiary/10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm text-tertiary" data-icon="payments">payments</span>
                            </div>
                            <span class="text-xs font-medium group-hover:text-tertiary transition-colors">E-Wallet</span>
                        </div>
                        <span class="text-xs font-bold">Rp21.0M</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities: Editorial Table -->
        <div class="col-span-12 mt-4">
            <div class="bg-surface-container-low rounded-xl border border-white/5 overflow-hidden">
                <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Transaksi Terakhir</h3>
                    <div class="flex gap-4">
                        <button class="px-4 py-1.5 text-xs rounded-full bg-surface-container-highest text-on-surface font-medium border border-white/5 hover:bg-surface-container-highest/80 transition-colors">Semua</button>
                        <button class="px-4 py-1.5 text-xs rounded-full text-on-surface-variant font-medium hover:bg-surface-container-highest transition-colors">Pemasukan</button>
                        <button class="px-4 py-1.5 text-xs rounded-full text-on-surface-variant font-medium hover:bg-surface-container-highest transition-colors">Pengeluaran</button>
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
                            <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-surface-variant transition-colors">
                                            <span class="material-symbols-outlined text-on-surface" data-icon="shopping_bag">shopping_bag</span>
                                        </div>
                                        <span class="font-medium group-hover:text-primary transition-colors">Belanja Mingguan (Superindo)</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-full bg-surface-container-highest text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Kebutuhan</span>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">24 Okt 2023, 14:20</td>
                                <td class="px-8 py-5 text-right font-bold text-tertiary-container">- Rp450.000</td>
                            </tr>
                            <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-secondary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-secondary" data-icon="work">work</span>
                                        </div>
                                        <span class="font-medium group-hover:text-primary transition-colors">Gaji Bulanan</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-full bg-surface-container-highest text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Pendapatan</span>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">25 Okt 2023, 09:00</td>
                                <td class="px-8 py-5 text-right font-bold text-secondary">+ Rp12.000.000</td>
                            </tr>
                            <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-surface-variant transition-colors">
                                            <span class="material-symbols-outlined text-on-surface" data-icon="restaurant">restaurant</span>
                                        </div>
                                        <span class="font-medium group-hover:text-primary transition-colors">Makan Malam (Sushimoo)</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-full bg-surface-container-highest text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Gaya Hidup</span>
                                </td>
                                <td class="px-8 py-5 text-sm text-on-surface-variant">25 Okt 2023, 20:15</td>
                                <td class="px-8 py-5 text-right font-bold text-tertiary-container">- Rp285.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
