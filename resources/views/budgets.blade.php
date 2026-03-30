<x-app-layout title="Manajemen Anggaran - My Finance">
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-6 right-6 z-[100] bg-secondary/20 border border-secondary/30 text-secondary px-6 py-4 rounded-2xl shadow-xl backdrop-blur-md text-sm font-semibold flex items-center gap-3">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <div class="max-w-[1400px] mx-auto space-y-12" x-data="{ showAddModal: false, showEditModal: false, editBudget: { id: null, category_id: null, amount: 0, period: '' } }">
        <!-- Header Section -->
        <section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 relative">
            <div>
                <h2 class="font-['Inter'] text-3xl font-bold tracking-tight mb-2">Manajemen Anggaran</h2>
                <p class="text-on-surface-variant/70 text-base">Lacak pengeluaran bulanan dan jaga kesehatan finansial Anda.</p>
            </div>
            <button @click="showAddModal = true"
                class="flex items-center gap-2 px-6 py-3 bg-primary text-on-primary rounded-xl hover:scale-[1.02] transition-all group shrink-0 shadow-lg shadow-primary/20 font-bold">
                <span class="material-symbols-outlined">add</span>
                Tambah Anggaran
            </button>
        </section>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-12 gap-6">
            <!-- Main Summary Card -->
            @php
                $totalBudget = $budgets->sum('amount');
                $totalSpent = $budgets->sum('spent');
                $totalRemaining = max(0, $totalBudget - $totalSpent);
                $overallPercent = $totalBudget > 0 ? min(100, ($totalSpent / $totalBudget) * 100) : 0;
            @endphp
            <div class="col-span-12 lg:col-span-4 glass-card p-8 rounded-4xl flex flex-col justify-between overflow-hidden relative">
                <div class="absolute -top-12 -right-12 w-48 h-48 bg-primary/10 blur-[80px] rounded-full"></div>
                <div>
                    <span class="text-sm font-medium text-on-surface-variant uppercase tracking-widest">Total Sisa Anggaran</span>
                    <h3 class="text-[3.5rem] font-bold tracking-tight leading-none mt-4 {{ $overallPercent > 90 ? 'text-tertiary-container' : 'text-secondary' }}">
                        Rp {{ number_format($totalRemaining, 0, ',', '.') }}
                    </h3>
                    <p class="text-on-surface-variant/60 mt-2">Dari total anggaran Rp {{ number_format($totalBudget, 0, ',', '.') }}</p>
                </div>
                <div class="mt-12 space-y-6">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-xs text-on-surface-variant/50 uppercase mb-1">Terpakai</p>
                            <p class="text-xl font-semibold text-on-surface">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xs text-on-surface-variant/50 uppercase mb-1">Penggunaan</p>
                            <p class="text-xl font-semibold {{ $overallPercent > 90 ? 'text-tertiary-container' : 'text-secondary' }}">
                                {{ round($overallPercent) }}%
                            </p>
                        </div>
                    </div>
                    <div class="h-2 w-full bg-surface-container rounded-full overflow-hidden">
                        <div class="h-full {{ $overallPercent > 90 ? 'bg-tertiary-container' : 'bg-secondary' }} transition-all duration-700"
                            style="width: {{ $overallPercent }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Monthly Allocation Progress Bars -->
            <div class="col-span-12 lg:col-span-8 bg-surface-container-low p-8 rounded-4xl space-y-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                    <h4 class="text-xl font-semibold">Alokasi Bulanan</h4>
                    <div class="flex gap-2">
                        <span class="px-3 py-1 bg-surface-container-highest rounded-full text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">
                            {{ now()->isoFormat('MMMM YYYY') }}
                        </span>
                    </div>
                </div>

                @if($budgets->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                    @foreach($budgets as $budget)
                    @php
                        $pct = $budget['percentage'];
                        $colorClass = $pct >= 90 ? 'bg-tertiary-container' : ($pct >= 75 ? 'bg-amber-400' : 'bg-secondary');
                        $textColor = $pct >= 90 ? 'text-tertiary-container' : ($pct >= 75 ? 'text-amber-400' : 'text-secondary');
                    @endphp
                    <div class="group">
                        <div class="flex justify-between items-center mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-surface-container-highest flex items-center justify-center {{ $textColor }}">
                                    <span class="material-symbols-outlined">{{ $budget['icon'] ?? 'category' }}</span>
                                </div>
                                <span class="font-medium text-sm">{{ $budget['name'] }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-mono {{ $textColor }}">{{ round($pct) }}%</span>
                                    <button type="button" 
                                        @click="editBudget = {{ json_encode($budget) }}; showEditModal = true"
                                        class="opacity-0 group-hover:opacity-100 transition-opacity text-on-surface-variant/40 hover:text-primary">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </button>
                                    <form action="{{ route('budgets.destroy', $budget['id']) }}" method="POST"
                                        onsubmit="return confirm('Hapus anggaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="opacity-0 group-hover:opacity-100 transition-opacity text-on-surface-variant/40 hover:text-tertiary-container">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                            </div>
                        </div>
                        <div class="h-1.5 w-full bg-surface-variant rounded-full overflow-hidden">
                            <div class="h-full {{ $colorClass }} transition-all duration-700"
                                style="width: {{ min(100, $pct) }}%"></div>
                        </div>
                        <div class="flex justify-between mt-2">
                            <span class="text-[10px] {{ $pct >= 90 ? $textColor . ' font-bold' : 'text-on-surface-variant/40' }}">
                                @if($pct >= 90)
                                    ⚠ Kritis! Sisa Rp {{ number_format($budget['remaining'], 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($budget['spent'], 0, ',', '.') }} terpakai
                                @endif
                            </span>
                            <span class="text-[10px] text-on-surface-variant/40">Limit Rp {{ number_format($budget['amount'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="flex flex-col items-center justify-center py-12 gap-4">
                    <span class="material-symbols-outlined text-5xl text-on-surface-variant/20">savings</span>
                    <p class="text-on-surface-variant/60 italic text-sm">Belum ada anggaran ditetapkan. Klik "Tambah Anggaran" untuk memulai.</p>
                </div>
                @endif
            </div>

            <!-- Risk Assessment -->
            @if($budgets->count() > 0)
            <div class="col-span-12 lg:col-span-5 space-y-6">
                <h5 class="text-sm font-bold uppercase tracking-[0.15em] text-on-surface-variant/60 px-2 mt-4 lg:mt-0">Penilaian Risiko</h5>
                @php $criticals = collect($budgets)->where('percentage', '>=', 80); @endphp
                @if($criticals->count() > 0)
                @foreach($criticals as $b)
                <div class="bg-{{ $b['percentage'] >= 90 ? 'tertiary-container' : 'amber-400' }}/10 border border-{{ $b['percentage'] >= 90 ? 'tertiary-container' : 'amber-400' }}/20 p-6 rounded-3xl">
                    <div class="flex items-start gap-4">
                        <div class="bg-{{ $b['percentage'] >= 90 ? 'tertiary-container' : 'amber-400' }} text-white p-2 rounded-lg shrink-0">
                            <span class="material-symbols-outlined">warning</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">{{ $b['percentage'] >= 90 ? 'Kritis' : 'Mendekati Batas' }}: {{ $b['name'] }}</p>
                            <p class="text-sm text-on-surface-variant/80 leading-relaxed">
                                Anda telah menggunakan {{ round($b['percentage']) }}% dari anggaran {{ $b['name'] }}.
                                Sisa: Rp {{ number_format($b['remaining'], 0, ',', '.') }}.
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @else
                <div class="bg-secondary/10 border border-secondary/20 p-6 rounded-3xl">
                    <div class="flex items-start gap-4">
                        <div class="bg-secondary text-on-secondary p-2 rounded-lg shrink-0">
                            <span class="material-symbols-outlined">check_circle</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface mb-1">Anggaran Sehat</p>
                            <p class="text-sm text-on-surface-variant/80">Semua kategori masih dalam batas aman. Pertahankan!</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Breakdown Table -->
            <div class="col-span-12 lg:col-span-7 bg-surface-container-low p-8 rounded-4xl">
                <h4 class="text-lg font-semibold mb-6">Breakdown Kategori</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-white/5">
                                <th class="pb-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Kategori</th>
                                <th class="pb-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Anggaran</th>
                                <th class="pb-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60">Terpakai</th>
                                <th class="pb-4 text-[10px] font-bold uppercase tracking-widest text-on-surface-variant/60 text-right">Sisa</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($budgets as $budget)
                            <tr class="hover:bg-white/5 transition-colors group">
                                <td class="py-4">
                                    <div class="flex items-center gap-3">
                                        <span class="material-symbols-outlined text-primary text-lg">{{ $budget['icon'] ?? 'category' }}</span>
                                        <p class="font-medium text-sm group-hover:text-primary transition-colors">{{ $budget['name'] }}</p>
                                    </div>
                                </td>
                                <td class="py-4 text-sm font-mono text-on-surface-variant/80">Rp {{ number_format($budget['amount'], 0, ',', '.') }}</td>
                                <td class="py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-20 bg-surface-variant rounded-full overflow-hidden">
                                            <div class="h-full {{ $budget['percentage'] >= 90 ? 'bg-tertiary-container' : 'bg-secondary' }}"
                                                style="width: {{ min(100, $budget['percentage']) }}%"></div>
                                        </div>
                                        <span class="text-xs text-on-surface-variant font-mono">{{ round($budget['percentage']) }}%</span>
                                    </div>
                                </td>
                                <td class="py-4 text-right font-medium {{ $budget['remaining'] === 0 ? 'text-tertiary-container' : 'text-secondary' }}">
                                    Rp {{ number_format($budget['remaining'], 0, ',', '.') }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Add Budget Modal -->
        <template x-teleport="body">
            <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-surface/80 backdrop-blur-xl" @click="showAddModal = false"></div>
                <div class="relative bg-surface-container-low border border-white/10 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click.stop>
                    <form action="{{ route('budgets.store') }}" method="POST">
                        @csrf
                        <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Tambah Anggaran</h3>
                            <button type="button" @click="showAddModal = false" class="text-on-surface-variant hover:text-on-surface">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Kategori</label>
                                <div class="relative">
                                    <select name="category_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface appearance-none outline-none focus:ring-2 focus:ring-primary/20" required>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Batas Anggaran (Rp)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-on-surface-variant">Rp</span>
                                    <input name="amount" type="number" step="1000" min="0"
                                        class="w-full bg-surface-container-highest border-none rounded-xl pl-12 pr-4 py-3 text-on-surface text-lg font-bold outline-none focus:ring-2 focus:ring-primary/20"
                                        placeholder="0" required>
                                </div>
                            </div>
                            <input type="hidden" name="period" value="{{ now()->format('Y-m') }}">
                        </div>
                        <div class="px-8 py-5 bg-surface-container-high/50 border-t border-white/5 flex gap-3">
                            <button type="submit"
                                class="flex-1 py-3 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">
                                Simpan Anggaran
                            </button>
                            <button type="button" @click="showAddModal = false"
                                class="px-6 py-3 text-on-surface-variant font-medium hover:bg-white/5 rounded-xl transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Edit Budget Modal -->
        <template x-teleport="body">
            <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-surface/80 backdrop-blur-xl" @click="showEditModal = false"></div>
                <div class="relative bg-surface-container-low border border-white/10 w-full max-w-md rounded-3xl shadow-2xl overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click.stop>
                    <form :action="'{{ url('budgets') }}/' + editBudget.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="px-8 py-6 border-b border-white/5 flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Edit Anggaran</h3>
                            <button type="button" @click="showEditModal = false" class="text-on-surface-variant hover:text-on-surface">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Kategori</label>
                                <div class="relative">
                                    <select name="category_id" x-model="editBudget.category_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface appearance-none outline-none focus:ring-2 focus:ring-primary/20" required>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant">Batas Anggaran (Rp)</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-on-surface-variant">Rp</span>
                                    <input name="amount" type="number" step="1000" min="0" x-model="editBudget.amount"
                                        class="w-full bg-surface-container-highest border-none rounded-xl pl-12 pr-4 py-3 text-on-surface text-lg font-bold outline-none focus:ring-2 focus:ring-primary/20"
                                        placeholder="0" required>
                                </div>
                            </div>
                            <input type="hidden" name="period" x-model="editBudget.period">
                        </div>
                        <div class="px-8 py-5 bg-surface-container-high/50 border-t border-white/5 flex gap-3">
                            <button type="submit"
                                class="flex-1 py-3 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">
                                Update Anggaran
                            </button>
                            <button type="button" @click="showEditModal = false"
                                class="px-6 py-3 text-on-surface-variant font-medium hover:bg-white/5 rounded-xl transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>
</x-app-layout>
