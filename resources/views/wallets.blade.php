<x-app-layout title="Dompet & Aset - My Finance">

    <!-- Header Section -->
    <section class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div>
            <h2 class="font-['Inter'] font-semibold text-on-surface-variant uppercase tracking-widest text-[11px] mb-2">Ikhtisar Kekayaan</h2>
            <div class="flex flex-wrap items-baseline gap-4">
                <h3 class="text-on-surface text-[3.5rem] font-semibold tracking-tight leading-none">Rp {{ number_format($wallets->sum('balance'), 0, ',', '.') }}</h3>
            </div>
            <p class="text-on-surface-variant/60 mt-4 font-['Inter'] text-sm max-w-md">Kalkulasi total aset bersih Anda di seluruh instrumen keuangan per hari ini.</p>
        </div>
        <a href="{{ route('wallets.create') }}" class="px-6 py-4 bg-linear-to-br from-primary to-primary-container text-on-primary-container font-bold rounded-xl flex items-center gap-3 shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all shrink-0">
            <span class="material-symbols-outlined">add_card</span>
            Tambah Dompet Baru
        </a>
    </section>

    <!-- Bento Grid Layout -->
    <div class="grid grid-cols-12 gap-6" 
        x-data="{ 
            startIndex: 0, 
            pageSize: 4, 
            total: {{ $wallets->count() }},
            next() { if (this.startIndex + this.pageSize < this.total) this.startIndex += this.pageSize },
            prev() { if (this.startIndex - this.pageSize >= 0) this.startIndex -= this.pageSize }
        }">
        
        <!-- Wealth Distribution Chart Card -->
        <div class="col-span-12 lg:col-span-4 glass-card rounded-4xl p-8 flex flex-col justify-between">
            <div>
                <h4 class="text-on-surface font-semibold text-lg mb-6 flex items-center justify-between">
                    Distribusi Aset
                </h4>
                @php
                    $totalBalance = $wallets->sum('balance') ?: 1;
                    $distribution = $wallets->groupBy('type')->map(function($group) use ($totalBalance) {
                        return ($group->sum('balance') / $totalBalance) * 100;
                    });
                @endphp
                <div class="relative w-48 h-48 mx-auto my-8">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                        <circle class="stroke-surface-container-highest" cx="18" cy="18" fill="none" r="16" stroke-width="4"></circle>
                        @php $offset = 0; @endphp
                        @foreach($distribution as $type => $percent)
                        <circle class="{{ $loop->first ? 'stroke-primary' : ($loop->iteration == 2 ? 'stroke-secondary' : 'stroke-tertiary-container') }}" cx="18" cy="18" fill="none" r="16" stroke-dasharray="{{ $percent }}, 100" stroke-dashoffset="-{{ $offset }}" stroke-linecap="round" stroke-width="4"></circle>
                        @php $offset += $percent; @endphp
                        @endforeach
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Total</span>
                        <span class="text-xl font-bold">100%</span>
                    </div>
                </div>
            </div>
            <div class="space-y-4">
                @foreach($distribution as $type => $percent)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full {{ $loop->first ? 'bg-primary' : ($loop->iteration == 2 ? 'bg-secondary' : 'bg-tertiary-container') }} shadow-sm"></span>
                        <span class="text-sm font-medium text-on-surface-variant">{{ $type }}</span>
                    </div>
                    <span class="text-sm font-semibold">{{ round($percent) }}%</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Wallet Grid with Carousel -->
        <div class="col-span-12 lg:col-span-8 flex flex-col gap-6">
            <!-- Navigation Arrows -->
            <div class="flex justify-between items-center px-2">
                <h4 class="text-on-surface font-semibold text-lg">Daftar Dompet</h4>
                <div class="flex gap-2" x-show="total > 4">
                    <button @click="prev()" :disabled="startIndex === 0" 
                        class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center transition-all bg-surface-container-low hover:bg-surface-container-high disabled:opacity-30 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined">arrow_back</span>
                    </button>
                    <button @click="next()" :disabled="startIndex + pageSize >= total" 
                        class="w-10 h-10 rounded-full border border-white/10 flex items-center justify-center transition-all bg-surface-container-low hover:bg-surface-container-high disabled:opacity-30 disabled:cursor-not-allowed">
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 min-h-[500px]">
                @forelse($wallets as $wallet)
                <div 
                    x-show="{{ $loop->index }} >= startIndex && {{ $loop->index }} < startIndex + pageSize"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="bg-surface-container-high hover:bg-surface-container-highest transition-all duration-300 rounded-4xl p-8 border border-white/5 group relative overflow-hidden"
                >
                    <!-- Background Blur Accent -->
                    <div class="absolute -right-4 -top-4 w-32 h-32 blur-[60px] rounded-full transition-all pointer-events-none opacity-35"
                        style="background-color: {{ $wallet->resolvedColor() }}"></div>
                    
                    <div class="flex justify-between items-start mb-8 relative z-20">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-white/10"
                            style="background-color: {{ $wallet->resolvedColor() }}22; color: {{ $wallet->resolvedColor() }}">
                            <span class="material-symbols-outlined text-2xl">{{ $wallet->resolvedIcon() }}</span>
                        </div>
                        <div class="flex gap-3">
                            <!-- Detail -->
                            <a href="{{ route('wallets.show', $wallet) }}" class="text-on-surface-variant/40 hover:text-secondary transition-colors" title="Detail">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </a>
                            <!-- Edit -->
                            <a href="{{ route('wallets.edit', $wallet) }}" class="text-on-surface-variant/40 hover:text-primary transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <!-- Delete -->
                            <form action="{{ route('wallets.destroy', $wallet) }}" method="POST" data-confirm="Dompet '{{ $wallet->name }}' akan dihapus permanen. Lanjutkan?" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-on-surface-variant/40 hover:text-tertiary-container transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <a href="{{ route('wallets.show', $wallet) }}" class="block relative z-10">
                        <h5 class="text-on-surface text-lg font-bold mb-1 group-hover:text-primary transition-colors">{{ $wallet->name }}</h5>
                        <p class="text-on-surface-variant/60 text-xs font-mono mb-6 uppercase tracking-widest">{{ $wallet->type }}</p>
                        <div class="flex items-baseline gap-1">
                            <span class="text-xs text-on-surface-variant/40">Rp</span>
                            <p class="text-3xl font-bold tracking-tighter"> {{ number_format($wallet->balance, 0, ',', '.') }}</p>
                        </div>
                    </a>
                </div>
                @empty
                <div class="col-span-full bg-surface-container-high rounded-4xl p-12 text-center border border-dashed border-white/10 flex flex-col items-center justify-center gap-4">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant/20">account_balance_wallet</span>
                    <p class="text-on-surface-variant/60 italic font-medium">Belum ada dompet tercatat.</p>
                    <a href="{{ route('wallets.create') }}" class="text-primary font-bold hover:underline">Tambah Dompet Pertama</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transactions Preview -->
    <section class="mt-12">
        <h4 class="text-on-surface font-semibold text-lg mb-6 px-2">Aktivitas Terkini</h4>
        <div class="bg-surface-container-low rounded-4xl border border-white/5 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-white/5 border-b border-white/5">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Transaksi</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Dompet</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Jumlah</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @php
                            $recentActivities = Auth::user()->transactions()->with('wallet')->latest()->take(5)->get();
                        @endphp
                        @forelse($recentActivities as $activity)
                        <tr class="hover:bg-white/5 transition-colors group cursor-pointer" onclick="window.location='{{ route('transactions') }}'">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center group-hover:bg-secondary/10 transition-colors">
                                        <span class="material-symbols-outlined {{ $activity->type == 'income' ? 'text-secondary' : 'text-tertiary-container' }} text-[20px]">{{ $activity->type == 'income' ? 'arrow_downward' : 'arrow_upward' }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium group-hover:text-secondary transition-colors">{{ $activity->description }}</p>
                                        <p class="text-[10px] text-on-surface-variant/60 uppercase tracking-wider">{{ $activity->date->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <span class="text-[10px] font-bold px-3 py-1 rounded-full bg-white/5 border border-white/5 text-on-surface-variant">{{ $activity->wallet->name }}</span>
                            </td>
                            <td class="px-8 py-5 text-right font-bold {{ $activity->type == 'income' ? 'text-secondary' : 'text-tertiary-container' }}">
                                {{ $activity->type == 'income' ? '+' : '-' }} Rp {{ number_format($activity->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5 text-right">
                                <span class="text-[10px] font-bold uppercase tracking-widest text-secondary">Berhasil</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-10 text-center text-on-surface-variant/60 italic">Belum ada aktivitas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-6 text-center border-t border-white/5 bg-white/1">
                <a href="{{ route('transactions') }}" class="text-[11px] font-bold uppercase tracking-widest text-primary hover:scale-105 inline-block transition-transform">Lihat Semua Histori</a>
            </div>
        </div>
    </section>
</x-app-layout>
