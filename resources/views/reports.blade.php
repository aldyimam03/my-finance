<x-app-layout title="Laporan & Analitik - My Finance">
    <div class="max-w-7xl mx-auto space-y-12">
        <!-- Page Header & Time Range Picker -->
        <section class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div>
                <h2 class="text-3xl font-semibold tracking-tight text-on-surface font-body mb-2">Analitik Keuangan</h2>
                <p class="text-outline text-sm">Pantau aliran dana dan performa anggaran bulanan Anda.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="glass-card flex items-center gap-2 px-4 py-2.5 rounded-xl border border-white/10">
                    <span class="material-symbols-outlined text-[20px] text-primary">calendar_today</span>
                    <select class="bg-transparent border-none text-sm font-medium focus:ring-0 cursor-pointer pr-8 text-on-surface">
                        <option class="bg-surface-container">1 Apr 2024 - 30 Apr 2024</option>
                        <option class="bg-surface-container">Maret 2024</option>
                        <option class="bg-surface-container">Kuartal 1 2024</option>
                        <option class="bg-surface-container">Kustom Rentang...</option>
                    </select>
                </div>
                <button class="glass-card p-2.5 rounded-xl hover:bg-white/10 transition-colors border border-white/10 shrink-0">
                    <span class="material-symbols-outlined">download</span>
                </button>
            </div>
        </section>

        <!-- Analytics Grid -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Large Spending Breakdown (Doughnut Chart Visual) -->
            <div class="col-span-12 lg:col-span-5 bg-surface-container-low rounded-4xl p-8 shadow-xl">
                <h3 class="text-lg font-semibold mb-8">Distribusi Pengeluaran</h3>
                <div class="relative flex justify-center items-center py-4">
                    <!-- Abstract Doughnut Representation -->
                    <div class="w-64 h-64 rounded-full border-24 border-surface-container-highest flex items-center justify-center relative">
                        <div class="absolute inset-0 rounded-full border-24 border-tertiary-container border-t-transparent border-r-transparent rotate-45 shadow-[0_0_15px_rgba(255,81,106,0.3)] hover:scale-105 transition-transform duration-500 cursor-pointer"></div>
                        <div class="absolute inset-0 rounded-full border-24 border-primary border-l-transparent border-b-transparent -rotate-12 hover:scale-105 transition-transform duration-500 cursor-pointer"></div>
                        <div class="text-center z-10 w-32 h-32 rounded-full bg-surface-container-low flex flex-col items-center justify-center shadow-inner">
                            <p class="text-[11px] uppercase tracking-widest text-outline mb-1 font-semibold">Total</p>
                            <p class="text-3xl font-bold tracking-tight">Rp 8,4M</p>
                        </div>
                    </div>
                </div>
                <div class="mt-10 space-y-4">
                    <div class="flex items-center justify-between group cursor-pointer hover:bg-white/5 p-2 -mx-2 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-tertiary-container shadow-[0_0_8px_rgba(255,81,106,0.5)]"></span>
                            <span class="text-sm text-on-surface/80 group-hover:text-on-surface transition-colors">Kebutuhan Pokok</span>
                        </div>
                        <span class="text-sm font-semibold">45%</span>
                    </div>
                    <div class="flex items-center justify-between group cursor-pointer hover:bg-white/5 p-2 -mx-2 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-primary shadow-[0_0_8px_rgba(173,198,255,0.5)]"></span>
                            <span class="text-sm text-on-surface/80 group-hover:text-on-surface transition-colors">Hiburan & Lifestyle</span>
                        </div>
                        <span class="text-sm font-semibold">30%</span>
                    </div>
                    <div class="flex items-center justify-between group cursor-pointer hover:bg-white/5 p-2 -mx-2 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-secondary shadow-[0_0_8px_rgba(78,222,163,0.5)]"></span>
                            <span class="text-sm text-on-surface/80 group-hover:text-on-surface transition-colors">Transportasi</span>
                        </div>
                        <span class="text-sm font-semibold">15%</span>
                    </div>
                    <div class="flex items-center justify-between group cursor-pointer hover:bg-white/5 p-2 -mx-2 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="w-3 h-3 rounded-full bg-surface-container-highest"></span>
                            <span class="text-sm text-on-surface/80 group-hover:text-on-surface transition-colors">Lainnya</span>
                        </div>
                        <span class="text-sm font-semibold">10%</span>
                    </div>
                </div>
            </div>

            <!-- Income vs Expense & AI Insights -->
            <div class="col-span-12 lg:col-span-7 space-y-6 flex flex-col">
                <!-- Bar Chart Visual -->
                <div class="bg-surface-container-low rounded-4xl p-8 shadow-xl flex flex-col flex-1">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-semibold">Arus Kas Bulanan</h3>
                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-secondary shadow-[0_0_8px_rgba(78,222,163,0.5)]"></span>
                                <span class="text-[11px] text-outline uppercase tracking-wider font-semibold">Pemasukan</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-tertiary-container shadow-[0_0_8px_rgba(255,81,106,0.5)]"></span>
                                <span class="text-[11px] text-outline uppercase tracking-wider font-semibold">Pengeluaran</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Visual Bar Representation -->
                    <div class="flex items-end justify-between h-56 gap-4 px-2 mt-auto pb-4">
                        <div class="flex-1 flex flex-col items-center gap-3 group cursor-pointer">
                            <div class="w-full flex justify-center gap-1.5 h-full items-end group-hover:opacity-80 transition-opacity">
                                <div class="w-6 bg-secondary/80 hover:bg-secondary rounded-t-lg h-3/4 transition-colors"></div>
                                <div class="w-6 bg-tertiary-container/80 hover:bg-tertiary-container rounded-t-lg h-1/2 transition-colors"></div>
                            </div>
                            <span class="text-[11px] font-medium text-outline uppercase tracking-wider group-hover:text-on-surface transition-colors">Jan</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3 group cursor-pointer">
                            <div class="w-full flex justify-center gap-1.5 h-full items-end group-hover:opacity-80 transition-opacity">
                                <div class="w-6 bg-secondary/80 hover:bg-secondary rounded-t-lg h-4/5 transition-colors"></div>
                                <div class="w-6 bg-tertiary-container/80 hover:bg-tertiary-container rounded-t-lg h-2/5 transition-colors"></div>
                            </div>
                            <span class="text-[11px] font-medium text-outline uppercase tracking-wider group-hover:text-on-surface transition-colors">Feb</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3 group cursor-pointer">
                            <div class="w-full flex justify-center gap-1.5 h-full items-end group-hover:opacity-80 transition-opacity">
                                <div class="w-6 bg-secondary/80 hover:bg-secondary rounded-t-lg h-full transition-colors"></div>
                                <div class="w-6 bg-tertiary-container/80 hover:bg-tertiary-container rounded-t-lg h-3/5 transition-colors"></div>
                            </div>
                            <span class="text-[11px] font-medium text-outline uppercase tracking-wider group-hover:text-on-surface transition-colors">Mar</span>
                        </div>
                        <div class="flex-1 flex flex-col items-center gap-3 group cursor-pointer relative">
                            <!-- Helper tooltip for current month -->
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-surface-container-highest px-3 py-1.5 rounded-lg text-[10px] font-medium whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-10 shadow-lg border border-white/5">Surplus +15%</div>
                            
                            <div class="w-full flex justify-center gap-1.5 h-full items-end">
                                <div class="w-6 bg-secondary rounded-t-lg h-[90%] shadow-[0_0_12px_rgba(78,222,163,0.3)]"></div>
                                <div class="w-6 bg-tertiary-container rounded-t-lg h-[45%] shadow-[0_0_12px_rgba(255,81,106,0.3)]"></div>
                            </div>
                            <span class="text-[11px] font-bold text-on-surface uppercase tracking-wider">Apr</span>
                        </div>
                    </div>
                </div>

                <!-- AI Insights Panel -->
                <div class="glass-card rounded-4xl p-8 border-primary/20 bg-linear-to-br from-primary/5 to-transparent relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-primary/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div class="flex items-center gap-3 mb-6 relative z-10">
                        <span class="material-symbols-outlined text-primary text-2xl" style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                        <h3 class="text-lg font-semibold tracking-tight text-white">Wawasan Obsidian AI</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 relative z-10">
                        <div class="bg-surface-container-highest/80 backdrop-blur-md p-5 rounded-2xl border border-white/5 hover:border-secondary/20 transition-colors cursor-default">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-secondary text-sm">trending_down</span>
                                <span class="text-[11px] uppercase tracking-widest text-secondary font-bold">Positif</span>
                            </div>
                            <p class="text-[13px] text-on-surface-variant leading-relaxed">Pengeluaran makan Anda turun 5% bulan ini. Pertahankan tren ini untuk mencapai target tabungan.</p>
                        </div>
                        <div class="bg-surface-container-highest/80 backdrop-blur-md p-5 rounded-2xl border border-white/5 hover:border-tertiary-container/20 transition-colors cursor-default">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="material-symbols-outlined text-tertiary-container text-sm">warning</span>
                                <span class="text-[11px] uppercase tracking-widest text-tertiary-container font-bold">Perhatian</span>
                            </div>
                            <p class="text-[13px] text-on-surface-variant leading-relaxed">Biaya langganan digital meningkat 12%. Ada 2 layanan yang jarang digunakan menurut data log.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Transactions / Bottom Section -->
        <section class="mt-12">
            <div class="flex items-center justify-between mb-8 px-2">
                <h3 class="text-xl font-semibold tracking-tight">Anomali Pengeluaran</h3>
                <a class="text-primary text-sm font-medium hover:text-primary-container transition-colors tracking-wide flex items-center gap-1 group" href="#">
                    Lihat Semua Anomali
                    <span class="material-symbols-outlined text-lg group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Bento Card 1 -->
                <div class="bg-surface-container-high p-6 rounded-3xl flex flex-col justify-between h-44 hover:bg-surface-container-highest transition-colors cursor-pointer group border border-transparent hover:border-white/5 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 rounded-2xl bg-primary-container/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings: 'FILL' 1;">shopping_bag</span>
                        </div>
                        <span class="text-[10px] font-bold bg-tertiary-container/20 text-tertiary-container px-2.5 py-1 rounded-full shadow-inner tracking-wider">+24%</span>
                    </div>
                    <div>
                        <p class="text-outline text-xs uppercase tracking-widest mb-1.5 font-medium">Belanja Retail</p>
                        <p class="text-2xl font-bold tracking-tight text-on-surface group-hover:text-primary transition-colors">Rp 1.250.000</p>
                    </div>
                </div>
                
                <!-- Bento Card 2 -->
                <div class="bg-surface-container-high p-6 rounded-3xl flex flex-col justify-between h-44 hover:bg-surface-container-highest transition-colors cursor-pointer group border border-transparent hover:border-white/5 shadow-lg">
                    <div class="flex justify-between items-start">
                        <div class="w-12 h-12 rounded-2xl bg-secondary-container/20 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-secondary" style="font-variation-settings: 'FILL' 1;">restaurant</span>
                        </div>
                        <span class="text-[10px] font-bold bg-secondary/20 text-secondary px-2.5 py-1 rounded-full shadow-inner tracking-wider">-12%</span>
                    </div>
                    <div>
                        <p class="text-outline text-xs uppercase tracking-widest mb-1.5 font-medium">Kuliner & Cafe</p>
                        <p class="text-2xl font-bold tracking-tight text-on-surface group-hover:text-secondary transition-colors">Rp 840.000</p>
                    </div>
                </div>
                
                <!-- Bento Card 3 (Trend Micro-Chart) -->
                <div class="bg-surface-container-high p-6 rounded-3xl flex flex-col justify-between h-44 hover:bg-surface-container-highest transition-colors cursor-pointer group border border-transparent hover:border-white/5 shadow-lg relative overflow-hidden">
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-primary/5 blur-3xl rounded-full group-hover:bg-primary/20 transition-all duration-700 pointer-events-none"></div>
                    <div class="flex justify-between items-start relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-surface-container-highest flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">show_chart</span>
                        </div>
                        <!-- Micro sparkline svg -->
                        <svg class="w-16 h-8 group-hover:stroke-primary transition-all duration-300" viewBox="0 0 100 40">
                            <path d="M0 35 Q 25 35, 40 15 T 70 25 T 100 5" fill="none" class="stroke-outline group-hover:stroke-primary transition-colors duration-300" stroke-width="2.5" stroke-linecap="round"></path>
                        </svg>
                    </div>
                    <div class="relative z-10">
                        <p class="text-outline text-xs uppercase tracking-widest mb-1.5 font-medium">Volatilitas Mingguan</p>
                        <div class="flex items-center gap-2">
                            <p class="text-2xl font-bold text-secondary tracking-tight">Stabil</p>
                            <span class="text-[10px] text-outline px-2 py-0.5 border border-white/5 rounded-full mt-1">Aman</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
