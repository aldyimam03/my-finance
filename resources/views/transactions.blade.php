<x-app-layout title="Transaksi - My Finance">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
        <div>
            <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant block mb-2">Manajemen Keuangan</span>
            <h2 class="font-['Inter'] text-3xl font-bold tracking-tight text-on-surface">Daftar Transaksi</h2>
        </div>
        <div class="flex gap-4">
            <div class="bg-surface-container-low px-8 py-4 rounded-xl shadow-lg border border-white/5 min-w-[200px]">
                <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-secondary/70 block mb-1">Total Pemasukan</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs text-secondary/60">Rp</span>
                    <span class="text-2xl font-bold text-secondary">42.500.000</span>
                </div>
            </div>
            <div class="bg-surface-container-low px-8 py-4 rounded-xl shadow-lg border border-white/5 min-w-[200px]">
                <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-tertiary/70 block mb-1">Total Pengeluaran</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs text-tertiary/60">Rp</span>
                    <span class="text-2xl font-bold text-tertiary">12.840.200</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Filter Section -->
    <section class="mb-12">
        <div class="bg-surface-container-low p-6 rounded-xl border border-white/5 shadow-xl flex flex-wrap items-center gap-6">
            <div class="flex-1 min-w-[200px]">
                <label class="block font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant mb-2 ml-1">Rentang Waktu</label>
                <select class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-lg py-2.5 px-4 text-on-surface font-body text-sm focus:border-primary/50 transition-colors outline-none">
                    <option>Bulan Ini</option>
                    <option>Minggu Ini</option>
                    <option>3 Bulan Terakhir</option>
                    <option>Tahun Ini</option>
                    <option>Custom</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant mb-2 ml-1">Kategori</label>
                <select class="w-full bg-surface-container-lowest border border-outline-variant/30 rounded-lg py-2.5 px-4 text-on-surface font-body text-sm focus:border-primary/50 transition-colors outline-none">
                    <option>Semua Kategori</option>
                    <option>Makanan &amp; Minuman</option>
                    <option>Transportasi</option>
                    <option>Hiburan</option>
                    <option>Belanja</option>
                </select>
            </div>
            <div class="flex-1 min-w-[200px]">
                <label class="block font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant mb-2 ml-1">Tipe</label>
                <div class="flex bg-surface-container-lowest p-1 rounded-lg border border-outline-variant/30">
                    <button class="flex-1 py-1.5 text-xs font-semibold rounded-md bg-primary text-on-primary shadow-sm hover:opacity-90 transition-opacity">Semua</button>
                    <button class="flex-1 py-1.5 text-xs font-semibold rounded-md text-on-surface-variant hover:text-on-surface transition-colors">Masuk</button>
                    <button class="flex-1 py-1.5 text-xs font-semibold rounded-md text-on-surface-variant hover:text-on-surface transition-colors">Keluar</button>
                </div>
            </div>
            <div class="pt-6">
                <button class="flex items-center gap-2 px-6 py-2.5 border border-primary text-primary hover:bg-primary/10 transition-all rounded-lg font-['Inter'] text-[11px] uppercase tracking-[0.05em] font-semibold active:scale-95">
                    <span class="material-symbols-outlined text-sm" data-icon="download">download</span>
                    Ekspor Laporan
                </button>
            </div>
        </div>
    </section>
    
    <!-- Transaction Table Section -->
    <section>
        <div class="bg-surface-container-low rounded-xl border border-white/5 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-white/5">
                            <th class="px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">Tanggal</th>
                            <th class="px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">Keterangan</th>
                            <th class="px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">Kategori</th>
                            <th class="px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">Dompet</th>
                            <th class="px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <!-- Row 1 -->
                        <tr class="hover:bg-white/2 transition-colors group cursor-pointer">
                            <td class="px-8 py-6 text-sm text-on-surface/80">14 Okt 2023</td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:scale-110 group-hover:bg-primary/20 transition-all">
                                        <span class="material-symbols-outlined" data-icon="coffee">coffee</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors">Starbucks Reserve</p>
                                        <p class="text-[10px] text-on-surface-variant">Kopi &amp; Sarapan</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-surface-container-highest text-on-surface-variant">Makanan</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_rgba(173,198,255,0.4)]"></span>
                                    <span class="text-sm text-on-surface/80">Bank BCA</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-bold text-tertiary">- 85.000</span>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-white/2 transition-colors group cursor-pointer">
                            <td class="px-8 py-6 text-sm text-on-surface/80">13 Okt 2023</td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-secondary group-hover:scale-110 group-hover:bg-secondary/20 transition-all">
                                        <span class="material-symbols-outlined" data-icon="payments">payments</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-on-surface group-hover:text-secondary transition-colors">Gaji Bulanan</p>
                                        <p class="text-[10px] text-on-surface-variant">PT. Teknologi Masa Depan</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-secondary-container/20 text-secondary">Pendapatan</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_rgba(173,198,255,0.4)]"></span>
                                    <span class="text-sm text-on-surface/80">Bank BCA</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-bold text-secondary">+ 25.000.000</span>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr class="hover:bg-white/2 transition-colors group cursor-pointer">
                            <td class="px-8 py-6 text-sm text-on-surface/80">12 Okt 2023</td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:scale-110 group-hover:bg-primary/20 transition-all">
                                        <span class="material-symbols-outlined" data-icon="directions_car">directions_car</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors">Bensin Pertamax</p>
                                        <p class="text-[10px] text-on-surface-variant">Pertamina Kuningan</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-surface-container-highest text-on-surface-variant">Transport</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-secondary shadow-[0_0_8px_rgba(78,222,163,0.4)]"></span>
                                    <span class="text-sm text-on-surface/80">E-Wallet</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-bold text-tertiary">- 450.000</span>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr class="hover:bg-white/2 transition-colors group cursor-pointer">
                            <td class="px-8 py-6 text-sm text-on-surface/80">10 Okt 2023</td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:scale-110 group-hover:bg-primary/20 transition-all">
                                        <span class="material-symbols-outlined" data-icon="shopping_bag">shopping_bag</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors">Uniqlo PIM 3</p>
                                        <p class="text-[10px] text-on-surface-variant">Belanja Pakaian</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-surface-container-highest text-on-surface-variant">Gaya Hidup</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_rgba(173,198,255,0.4)]"></span>
                                    <span class="text-sm text-on-surface/80">Bank BCA</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-bold text-tertiary">- 1.299.000</span>
                            </td>
                        </tr>
                        <!-- Row 5 -->
                        <tr class="hover:bg-white/2 transition-colors group border-b-0 cursor-pointer">
                            <td class="px-8 py-6 text-sm text-on-surface/80">08 Okt 2023</td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center text-secondary group-hover:scale-110 group-hover:bg-secondary/20 transition-all">
                                        <span class="material-symbols-outlined" data-icon="trending_up">trending_up</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-on-surface group-hover:text-secondary transition-colors">Dividen Saham BBCA</p>
                                        <p class="text-[10px] text-on-surface-variant">Passive Income</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold bg-secondary-container/20 text-secondary">Investasi</span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-secondary-fixed shadow-[0_0_8px_rgba(111,251,190,0.4)]"></span>
                                    <span class="text-sm text-on-surface/80">Rek. Saham</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <span class="text-sm font-bold text-secondary">+ 4.250.000</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-8 py-6 border-t border-white/5 flex items-center justify-between">
                <span class="text-xs text-on-surface-variant">Menampilkan 5 dari 124 transaksi</span>
                <div class="flex gap-2">
                    <button class="p-2 rounded-lg bg-surface-container-highest border border-white/5 text-on-surface hover:bg-white/10 transition-colors">
                        <span class="material-symbols-outlined text-sm" data-icon="chevron_left">chevron_left</span>
                    </button>
                    <button class="px-4 py-2 rounded-lg bg-primary text-on-primary text-xs font-bold hover:opacity-90 transition-opacity">1</button>
                    <button class="px-4 py-2 rounded-lg bg-surface-container-highest border border-white/5 text-on-surface hover:bg-white/10 transition-colors text-xs font-bold">2</button>
                    <button class="px-4 py-2 rounded-lg bg-surface-container-highest border border-white/5 text-on-surface hover:bg-white/10 transition-colors text-xs font-bold">3</button>
                    <button class="p-2 rounded-lg bg-surface-container-highest border border-white/5 text-on-surface hover:bg-white/10 transition-colors">
                        <span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Signature Trend Info -->
    <section class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card p-8 rounded-2xl flex flex-col gap-4">
            <span class="material-symbols-outlined text-secondary text-3xl" data-icon="insights">insights</span>
            <p class="text-sm text-on-surface-variant">Pengeluaran kamu 12% lebih rendah dibandingkan bulan lalu pada periode yang sama.</p>
            <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-auto">
                <div class="bg-secondary h-full shadow-[0_0_10px_rgba(78,222,163,0.5)]" style="width: 65%"></div>
            </div>
        </div>
        <div class="glass-card p-8 rounded-2xl flex flex-col gap-4">
            <span class="material-symbols-outlined text-primary text-3xl" data-icon="savings">savings</span>
            <p class="text-sm text-on-surface-variant">Kategori "Makanan" mendominasi 42% dari total pengeluaran operasional minggu ini.</p>
            <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-auto">
                <div class="bg-primary h-full shadow-[0_0_10px_rgba(173,198,255,0.5)]" style="width: 42%"></div>
            </div>
        </div>
        <div class="glass-card p-8 rounded-2xl flex flex-col gap-4">
            <span class="material-symbols-outlined text-tertiary text-3xl" data-icon="warning">warning</span>
            <p class="text-sm text-on-surface-variant">Anggaran hiburan tersisa Rp 200.000 lagi sebelum mencapai batas limit bulanan.</p>
            <div class="w-full bg-surface-variant h-1 rounded-full overflow-hidden mt-auto">
                <div class="bg-tertiary h-full shadow-[0_0_10px_rgba(255,81,106,0.5)]" style="width: 88%"></div>
            </div>
        </div>
    </section>
</x-app-layout>
