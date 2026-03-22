<x-app-layout title="Manajemen Anggaran - My Finance">
    <div class="max-w-[1400px] mx-auto space-y-12">
        <!-- Header Section -->
        <section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 relative">
            <div>
                <h2 class="font-['Inter'] text-3xl font-bold tracking-tight mb-2">Manajemen Anggaran</h2>
                <p class="text-on-surface-variant/70 text-base">Lacak pengeluaran bulanan dan jaga kesehatan finansial Anda.</p>
            </div>
            <button class="flex items-center gap-2 px-6 py-3 border border-outline/20 rounded-xl hover:bg-white/5 transition-all group shrink-0 shadow-lg shadow-black/10">
                <span class="material-symbols-outlined text-primary group-hover:rotate-180 transition-transform duration-500" data-icon="tune">tune</span>
                <span class="text-sm font-semibold text-primary">Sesuaikan Batas Anggaran</span>
            </button>
        </section>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Main Summary Card -->
            <div class="col-span-12 lg:col-span-4 glass-card p-8 rounded-4xl flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-primary/10 blur-[80px] rounded-full"></div>
                <div>
                    <span class="text-sm font-medium text-on-surface-variant uppercase tracking-widest">Total Sisa Anggaran</span>
                    <h3 class="text-[3.5rem] font-bold tracking-tight leading-none mt-4 text-secondary">Rp 4.250k</h3>
                    <p class="text-on-surface-variant/60 mt-2">Dari total anggaran bulanan Rp 12.000k</p>
                </div>
                <div class="mt-12 space-y-6">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-xs text-on-surface-variant/50 uppercase mb-1">Terpakai</p>
                            <p class="text-xl font-semibold text-on-surface">Rp 7.750.000</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-on-surface-variant/50 uppercase mb-1">Efisiensi</p>
                            <p class="text-xl font-semibold text-secondary">+12%</p>
                        </div>
                    </div>
                    <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full bg-secondary w-[64.5%] shadow-[0_0_12px_rgba(78,222,163,0.3)]"></div>
                    </div>
                </div>
            </div>

            <!-- Monthly Allocation Progress Bars -->
            <div class="col-span-12 lg:col-span-8 bg-surface-container-low p-8 rounded-4xl space-y-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                    <h4 class="text-xl font-semibold">Alokasi Bulanan</h4>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">Oktober 2023</span>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    <!-- Category: Makanan -->
                    <div class="group">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined" data-icon="restaurant">restaurant</span>
                                </div>
                                <span class="font-medium text-sm">Makanan & Minuman</span>
                            </div>
                            <span class="text-xs font-mono text-on-surface-variant">45%</span>
                        </div>
                        <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-secondary w-[45%] transition-all duration-500 shadow-[0_0_8px_rgba(78,222,163,0.2)]"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] text-on-surface-variant/40">Rp 1.350.000 terpakai</span>
                            <span class="text-[10px] text-on-surface-variant/40">Limit Rp 3.000.000</span>
                        </div>
                    </div>
                    
                    <!-- Category: Transportasi -->
                    <div class="group">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined" data-icon="commute">commute</span>
                                </div>
                                <span class="font-medium text-sm">Transportasi</span>
                            </div>
                            <span class="text-xs font-mono text-on-surface-variant">78%</span>
                        </div>
                        <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-primary-container w-[78%] transition-all duration-500"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] text-on-surface-variant/40">Rp 1.560.000 terpakai</span>
                            <span class="text-[10px] text-on-surface-variant/40">Limit Rp 2.000.000</span>
                        </div>
                    </div>

                    <!-- Category: Hiburan (Yellow Alert) -->
                    <div class="group">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined" data-icon="theater_comedy">theater_comedy</span>
                                </div>
                                <span class="font-medium text-sm">Hiburan</span>
                            </div>
                            <span class="text-xs font-mono text-tertiary">89%</span>
                        </div>
                        <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-amber-400 w-[89%] transition-all duration-500 shadow-[0_0_8px_rgba(251,191,36,0.2)]"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] text-tertiary/70 font-semibold">Hampir mencapai batas</span>
                            <span class="text-[10px] text-on-surface-variant/40">Limit Rp 1.500.000</span>
                        </div>
                    </div>

                    <!-- Category: Belanja (Red Alert) -->
                    <div class="group">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-tertiary-container">
                                    <span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
                                </div>
                                <span class="font-medium text-sm">Belanja</span>
                            </div>
                            <span class="text-xs font-mono text-tertiary-container">96%</span>
                        </div>
                        <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full bg-tertiary-container w-[96%] transition-all duration-500 shadow-[0_0_12px_rgba(255,81,106,0.3)]"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] text-tertiary-container font-bold uppercase tracking-tighter">Kritis! Sisa Rp 100.000</span>
                            <span class="text-[10px] text-on-surface-variant/40">Limit Rp 2.500.000</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Risk Assessment Alert Section -->
            <div class="col-span-12 lg:col-span-5 space-y-6">
                <h5 class="text-sm font-bold uppercase tracking-[0.15em] text-on-surface-variant/60 px-2 mt-4 lg:mt-0">Penilaian Risiko</h5>
                <div class="bg-tertiary-container/10 border border-tertiary-container/20 p-6 rounded-3xl relative overflow-hidden group hover:bg-tertiary-container/15 transition-colors">
                    <div class="flex items-start gap-4">
                        <div class="bg-tertiary-container text-on-tertiary p-2 rounded-lg shrink-0">
                            <span class="material-symbols-outlined" data-icon="warning">warning</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">Mendekati Batas: Belanja Bulanan</p>
                            <p class="text-sm text-on-surface-variant/80 leading-relaxed">Anda telah menggunakan 96% dari anggaran belanja. Disarankan untuk menunda pembelian non-esensial hingga bulan depan.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-low p-6 rounded-3xl border border-white/5 hover:border-primary/20 transition-all cursor-pointer shadow-lg shadow-black/5">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xs font-bold uppercase tracking-widest text-primary">Insight Cerdas</span>
                        <span class="material-symbols-outlined text-sm text-primary" data-icon="auto_awesome">auto_awesome</span>
                    </div>
                    <p class="text-sm text-on-surface-variant leading-relaxed italic">"Berdasarkan pola 7 hari terakhir, kategori 'Transportasi' diprediksi akan melebihi batas dalam 4 hari jika tren penggunaan berlanjut."</p>
                </div>
            </div>

            <!-- Trend Visualization / Micro-Charts -->
            <div class="col-span-12 lg:col-span-7 bg-surface-container-low p-8 rounded-4xl">
                <h4 class="text-lg font-semibold mb-8">Tren Pengeluaran vs Anggaran</h4>
                <div class="h-48 w-full flex items-end gap-2 mb-4">
                    <!-- Bar chart elements with varied heights for trend representation -->
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[40%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[55%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[45%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-primary-container rounded-t-lg h-[85%] relative">
                        <div class="absolute -top-8 left-1/2 -translate-x-1/2 text-[10px] font-bold text-primary">Peak</div>
                    </div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[60%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[50%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[65%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[40%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[30%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[45%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-surface-container-highest rounded-t-lg h-[55%] transition-all hover:bg-primary-container/40"></div>
                    <div class="flex-1 bg-secondary-container/60 rounded-t-lg h-[20%]"></div>
                </div>
                <div class="flex justify-between text-[10px] text-on-surface-variant/40 font-mono uppercase">
                    <span>Minggu 1</span>
                    <span>Minggu 2</span>
                    <span>Minggu 3</span>
                    <span>Minggu 4</span>
                </div>
            </div>
        </div>

        <!-- Detailed Table Section (Editorial Style) -->
        <section class="space-y-6">
            <div class="flex justify-between items-center px-4 mt-8">
                <h4 class="text-xl font-semibold">Breakdown Kategori</h4>
                <button class="text-sm font-medium text-primary hover:underline hover:text-primary-container transition-colors">Lihat Semua Kategori</button>
            </div>
            <div class="overflow-hidden rounded-4xl border border-white/5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-white/5">
                                <th class="py-5 px-8 text-sm font-bold uppercase tracking-widest text-on-surface-variant/60">Kategori</th>
                                <th class="py-5 px-8 text-sm font-bold uppercase tracking-widest text-on-surface-variant/60">Anggaran</th>
                                <th class="py-5 px-8 text-sm font-bold uppercase tracking-widest text-on-surface-variant/60">Penggunaan</th>
                                <th class="py-5 px-8 text-sm font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Sisa Selisih</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5 bg-surface-container-low/50">
                            <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                                <td class="py-6 px-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                            <span class="material-symbols-outlined text-primary text-lg" data-icon="house">house</span>
                                        </div>
                                        <div>
                                            <p class="font-medium group-hover:text-primary transition-colors">Tagihan & Properti</p>
                                            <p class="text-xs text-on-surface-variant/60">Fixed Expenses</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-6 px-8 text-sm font-mono text-on-surface-variant/80 group-hover:text-on-surface transition-colors">Rp 5.000.000</td>
                                <td class="py-6 px-8">
                                    <div class="flex items-center gap-3">
                                        <div class="h-1.5 w-24 bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full bg-secondary w-full shadow-[0_0_8px_rgba(78,222,163,0.3)]"></div>
                                        </div>
                                        <span class="text-xs text-secondary font-bold uppercase tracking-wider">Paid</span>
                                    </div>
                                </td>
                                <td class="py-6 px-8 text-right font-medium text-on-surface-variant">Rp 0</td>
                            </tr>
                            
                            <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                                <td class="py-6 px-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                            <span class="material-symbols-outlined text-primary text-lg" data-icon="health_and_safety">health_and_safety</span>
                                        </div>
                                        <div>
                                            <p class="font-medium group-hover:text-primary transition-colors">Kesehatan</p>
                                            <p class="text-xs text-on-surface-variant/60">Asuransi & Obat</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-6 px-8 text-sm font-mono text-on-surface-variant/80 group-hover:text-on-surface transition-colors">Rp 1.000.000</td>
                                <td class="py-6 px-8">
                                    <div class="flex items-center gap-3">
                                        <div class="h-1.5 w-24 bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full bg-secondary w-[30%]"></div>
                                        </div>
                                        <span class="text-xs text-on-surface-variant font-mono">30%</span>
                                    </div>
                                </td>
                                <td class="py-6 px-8 text-right font-medium text-secondary group-hover:scale-105 origin-right transition-transform">Rp 700.000</td>
                            </tr>
                            
                            <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                                <td class="py-6 px-8">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                                            <span class="material-symbols-outlined text-primary text-lg" data-icon="fitness_center">fitness_center</span>
                                        </div>
                                        <div>
                                            <p class="font-medium group-hover:text-primary transition-colors">Gaya Hidup</p>
                                            <p class="text-xs text-on-surface-variant/60">Gym & Hobi</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-6 px-8 text-sm font-mono text-on-surface-variant/80 group-hover:text-on-surface transition-colors">Rp 1.200.000</td>
                                <td class="py-6 px-8">
                                    <div class="flex items-center gap-3">
                                        <div class="h-1.5 w-24 bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full bg-secondary w-[85%]"></div>
                                        </div>
                                        <span class="text-xs text-on-surface-variant font-mono">85%</span>
                                    </div>
                                </td>
                                <td class="py-6 px-8 text-right font-medium text-secondary group-hover:scale-105 origin-right transition-transform">Rp 180.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
