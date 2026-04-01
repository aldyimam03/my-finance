<x-app-layout title="Transaksi - My Finance">
    <div x-data="{
            showModal: false,
            showEditModal: false,
            type: 'expense',
            amountRaw: '',
            amountDisplay: '',
            editType: 'expense',
            editAmountRaw: '',
            editAmountDisplay: '',
            editTransaction: { id: null, wallet_id: '', category_id: '', to_wallet_id: '', description: '', date: '', type: 'expense' },
            wallets: {{ $wallets->toJson() }},
            categories: {{ $categories->toJson() }},
            setAmount(value) {
                this.amountRaw = window.financeNumber.sanitize(value);
                this.amountDisplay = window.financeNumber.format(this.amountRaw);
            },
            setEditAmount(value) {
                this.editAmountRaw = window.financeNumber.sanitize(value);
                this.editAmountDisplay = window.financeNumber.format(this.editAmountRaw);
            },
            openEditModal(transaction) {
                this.editTransaction = {
                    id: transaction.id,
                    wallet_id: String(transaction.wallet_id ?? ''),
                    category_id: transaction.category_id ? String(transaction.category_id) : '',
                    to_wallet_id: transaction.to_wallet_id ? String(transaction.to_wallet_id) : '',
                    description: transaction.description ?? '',
                    date: transaction.date,
                    type: transaction.type,
                };
                this.editType = transaction.type;
                this.editAmountRaw = String(transaction.amount ?? '');
                this.editAmountDisplay = window.financeNumber.format(this.editAmountRaw);
                this.showEditModal = true;
            }
        }">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 md:gap-8 mb-8 md:mb-12">
        <div>
            <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant block mb-2">Manajemen Keuangan</span>
            <h2 class="font-['Inter'] text-3xl font-bold tracking-tight text-on-surface">Daftar Transaksi</h2>
        </div>
        <div class="w-full md:w-auto flex flex-col gap-3 md:gap-4">
            <div class="grid grid-cols-2 gap-3 md:flex md:gap-4 md:items-center">
            <div class="bg-surface-container-low px-4 py-4 sm:px-6 rounded-xl shadow-lg border border-white/5 min-w-0">
                <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-secondary/70 block mb-1">Total Pemasukan</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs text-secondary/60">Rp</span>
                    <span class="text-lg sm:text-2xl font-bold text-secondary break-all">{{ number_format(auth()->user()->transactions()->where('type','income')->whereMonth('date', now()->month)->sum('amount'), 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="bg-surface-container-low px-4 py-4 sm:px-6 rounded-xl shadow-lg border border-white/5 min-w-0">
                <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-tertiary-container/70 block mb-1">Total Pengeluaran</span>
                <div class="flex items-baseline gap-1">
                    <span class="text-xs text-tertiary-container/60">Rp</span>
                    <span class="text-lg sm:text-2xl font-bold text-tertiary-container break-all">{{ number_format(auth()->user()->transactions()->where('type','expense')->whereMonth('date', now()->month)->sum('amount'), 0, ',', '.') }}</span>
                </div>
            </div>
            </div>
            <button @click="showModal = true"
                class="w-full md:w-auto px-5 py-4 bg-primary text-on-primary font-bold rounded-xl flex items-center justify-center gap-3 shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all whitespace-nowrap">
                <span class="material-symbols-outlined">add</span>
                Tambah Transaksi
            </button>
        </div>

        <!-- Add Transaction Modal -->
        <template x-teleport="body">
            <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-surface/80 backdrop-blur-xl" @click="showModal = false"></div>

                <!-- Modal Content -->
                <div class="relative bg-surface-container-low border border-white/10 w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden max-h-[calc(100vh-2rem)] flex flex-col"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click.stop>
                    <form action="{{ route('transactions.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" x-model="type">

                        <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center shrink-0">
                            <h3 class="text-lg font-semibold">Catat Transaksi</h3>
                            <button type="button" @click="showModal = false" class="text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>

                        <div class="p-6 space-y-5 overflow-y-auto">
                            <!-- Type Toggle -->
                            <div class="flex p-1 bg-surface-container-high rounded-xl border border-white/5">
                                <button type="button" @click="type = 'expense'"
                                    :class="type === 'expense' ? 'bg-tertiary-container text-on-primary font-bold' : 'text-on-surface-variant hover:text-on-surface'"
                                    class="flex-1 py-2.5 rounded-lg text-[11px] uppercase tracking-widest transition-all">
                                    Pengeluaran
                                </button>
                                <button type="button" @click="type = 'income'"
                                    :class="type === 'income' ? 'bg-secondary text-on-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface'"
                                    class="flex-1 py-2.5 rounded-lg text-[11px] uppercase tracking-widest transition-all">
                                    Pemasukan
                                </button>
                            </div>

                            <!-- Amount -->
                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Jumlah</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg font-bold text-on-surface-variant">Rp</span>
                                    <input type="hidden" name="amount" :value="amountRaw">
                                    <input x-model="amountDisplay" @input="setAmount($event.target.value)" type="text" inputmode="numeric" autocomplete="off"
                                        class="w-full bg-surface-container-highest border-none rounded-xl pl-12 pr-5 py-4 text-2xl font-bold tracking-tight text-on-surface focus:ring-2 focus:ring-primary/30 outline-none placeholder:text-on-surface-variant/20"
                                        placeholder="0" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Wallet -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Dompet</label>
                                    <div class="relative">
                                        <select name="wallet_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface appearance-none outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer" required>
                                            <template x-for="wallet in wallets" :key="wallet.id">
                                                <option :value="wallet.id" x-text="wallet.name"></option>
                                            </template>
                                        </select>
                                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                                    </div>
                                </div>
                                <!-- Category -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Kategori</label>
                                    <div class="relative">
                                        <select name="category_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface appearance-none outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer" required>
                                            <template x-for="cat in categories" :key="cat.id">
                                                <option :value="cat.id" x-text="cat.name"></option>
                                            </template>
                                        </select>
                                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Description -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Deskripsi</label>
                                    <input name="description" type="text"
                                        class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 outline-none placeholder:text-on-surface-variant/30"
                                        placeholder="Untuk apa transaksi ini?">
                                </div>

                                <!-- Date -->
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Tanggal</label>
                                    <input name="date" type="date" value="{{ date('Y-m-d') }}"
                                        class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 outline-none" required>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-surface-container-high/50 border-t border-white/5 flex gap-3 shrink-0">
                            <button type="submit"
                                class="flex-1 py-3.5 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                Simpan
                            </button>
                            <button type="button" @click="showModal = false"
                                class="px-5 py-3.5 text-on-surface-variant font-medium hover:bg-white/5 rounded-xl transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- Edit Transaction Modal -->
        <template x-teleport="body">
            <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-surface/80 backdrop-blur-xl" @click="showEditModal = false"></div>

                <div class="relative bg-surface-container-low border border-white/10 w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden max-h-[calc(100vh-2rem)] flex flex-col"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click.stop>
                    <form :action="'{{ url('transactions') }}/' + editTransaction.id" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="type" :value="editType">
                        <input type="hidden" name="amount" :value="editAmountRaw">

                        <div class="px-6 py-4 border-b border-white/5 flex justify-between items-center shrink-0">
                            <h3 class="text-lg font-semibold">Edit Transaksi</h3>
                            <button type="button" @click="showEditModal = false" class="text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>

                        <div class="p-6 space-y-5 overflow-y-auto">
                            <div class="flex p-1 bg-surface-container-high rounded-xl border border-white/5">
                                <button type="button" @click="editType = 'expense'"
                                    :class="editType === 'expense' ? 'bg-tertiary-container text-on-primary font-bold' : 'text-on-surface-variant hover:text-on-surface'"
                                    class="flex-1 py-2.5 rounded-lg text-[11px] uppercase tracking-widest transition-all">
                                    Pengeluaran
                                </button>
                                <button type="button" @click="editType = 'income'"
                                    :class="editType === 'income' ? 'bg-secondary text-on-secondary font-bold' : 'text-on-surface-variant hover:text-on-surface'"
                                    class="flex-1 py-2.5 rounded-lg text-[11px] uppercase tracking-widest transition-all">
                                    Pemasukan
                                </button>
                                <button type="button" @click="editType = 'transfer'"
                                    :class="editType === 'transfer' ? 'bg-primary text-on-primary font-bold' : 'text-on-surface-variant hover:text-on-surface'"
                                    class="flex-1 py-2.5 rounded-lg text-[11px] uppercase tracking-widest transition-all">
                                    Transfer
                                </button>
                            </div>

                            <div class="space-y-2">
                                <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Jumlah</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg font-bold text-on-surface-variant">Rp</span>
                                    <input x-model="editAmountDisplay" @input="setEditAmount($event.target.value)" type="text" inputmode="numeric" autocomplete="off"
                                        class="w-full bg-surface-container-highest border-none rounded-xl pl-12 pr-5 py-4 text-2xl font-bold tracking-tight text-on-surface focus:ring-2 focus:ring-primary/30 outline-none placeholder:text-on-surface-variant/20"
                                        placeholder="0" required>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Dompet</label>
                                    <div class="relative">
                                        <select name="wallet_id" x-model="editTransaction.wallet_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface appearance-none outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer" required>
                                            <template x-for="wallet in wallets" :key="'edit-wallet-' + wallet.id">
                                                <option :value="String(wallet.id)" x-text="wallet.name"></option>
                                            </template>
                                        </select>
                                        <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                                    </div>
                                </div>

                                <template x-if="editType === 'transfer'">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Ke Dompet</label>
                                        <div class="relative">
                                            <select name="to_wallet_id" x-model="editTransaction.to_wallet_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface appearance-none outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer" :required="editType === 'transfer'">
                                                <option value="">Pilih dompet tujuan</option>
                                                <template x-for="wallet in wallets" :key="'edit-dest-wallet-' + wallet.id">
                                                    <option :value="String(wallet.id)" x-text="wallet.name"></option>
                                                </template>
                                            </select>
                                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="editType !== 'transfer'">
                                    <div class="space-y-2">
                                        <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Kategori</label>
                                        <div class="relative">
                                            <select name="category_id" x-model="editTransaction.category_id" class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface appearance-none outline-none focus:ring-2 focus:ring-primary/20 cursor-pointer" :required="editType !== 'transfer'">
                                                <option value="">Pilih kategori</option>
                                                <template x-for="cat in categories" :key="'edit-cat-' + cat.id">
                                                    <option :value="String(cat.id)" x-text="cat.name"></option>
                                                </template>
                                            </select>
                                            <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Deskripsi</label>
                                    <input name="description" type="text" x-model="editTransaction.description"
                                        class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 outline-none placeholder:text-on-surface-variant/30"
                                        placeholder="Untuk apa transaksi ini?">
                                </div>

                                <div class="space-y-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant ml-1">Tanggal</label>
                                    <input name="date" type="date" x-model="editTransaction.date"
                                        class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/20 outline-none" required>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-surface-container-high/50 border-t border-white/5 flex gap-3 shrink-0">
                            <button type="submit"
                                class="flex-1 py-3.5 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                Update
                            </button>
                            <button type="button" @click="showEditModal = false"
                                class="px-5 py-3.5 text-on-surface-variant font-medium hover:bg-white/5 rounded-xl transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>
    </div>

    <!-- Filter Section -->
    <section class="mb-8">
        <div class="bg-surface-container-low p-5 rounded-xl border border-white/5 shadow-xl flex flex-wrap items-center gap-4">
            <form method="GET" action="{{ route('transactions') }}" class="flex flex-wrap gap-4 items-end w-full">
                <div class="flex-1 min-w-[180px]">
                    <label class="block font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant mb-2">Filter Tipe</label>
                    <div class="flex bg-surface-container-lowest p-1 rounded-lg border border-white/10">
                        <button type="submit" name="type" value="all"
                            class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('type', 'all') === 'all' ? 'bg-primary text-on-primary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                            Semua
                        </button>
                        <button type="submit" name="type" value="income"
                            class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('type') === 'income' ? 'bg-secondary text-on-secondary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                            Masuk
                        </button>
                        <button type="submit" name="type" value="expense"
                            class="flex-1 py-1.5 text-xs font-semibold rounded-md transition-all {{ request('type') === 'expense' ? 'bg-tertiary-container text-on-primary shadow-sm' : 'text-on-surface-variant hover:text-on-surface' }}">
                            Keluar
                        </button>
                    </div>
                </div>
                <div class="flex-1 min-w-[180px]">
                    <label class="block font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant mb-2">Dompet</label>
                    <select name="wallet_id" onchange="this.form.submit()"
                        class="w-full bg-surface-container-lowest border border-white/10 rounded-lg py-2.5 px-4 text-on-surface text-sm focus:border-primary/50 transition-colors outline-none">
                        <option value="all">Semua Dompet</option>
                        @foreach(auth()->user()->wallets as $w)
                        <option value="{{ $w->id }}" {{ request('wallet_id') == $w->id ? 'selected' : '' }}>{{ $w->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-1 min-w-[180px]">
                    <label class="block font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                        class="w-full bg-surface-container-lowest border border-white/10 rounded-lg py-2.5 px-4 text-on-surface text-sm focus:border-primary/50 transition-colors outline-none">
                </div>
                <div class="flex items-center gap-3">
                    <button type="submit"
                        class="px-4 py-2.5 bg-primary text-on-primary text-sm font-semibold rounded-lg shadow-lg shadow-primary/15 hover:scale-[1.02] transition-all">
                        Terapkan
                    </button>
                    <a href="{{ route('transactions') }}"
                        class="px-4 py-2.5 bg-surface-container-lowest border border-white/10 text-on-surface-variant text-sm font-semibold rounded-lg hover:text-on-surface transition-colors">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </section>

    <!-- Transaction Table Section -->
    @php
        $sortLink = function (string $column, string $direction) {
            return route('transactions', array_merge(request()->query(), [
                'sort_by' => $column,
                'sort_dir' => $direction,
            ]));
        };

        $sortIconClass = function (string $column, string $direction) use ($sortBy, $sortDir) {
            return $sortBy === $column && $sortDir === $direction
                ? 'text-primary'
                : 'text-on-surface-variant/35 hover:text-on-surface-variant';
        };
    @endphp
    <section>
        <div class="bg-surface-container-low rounded-xl border border-white/5 shadow-2xl">
            <div class="overflow-x-auto rounded-b-xl">
                <table class="w-full min-w-[1180px] text-left border-collapse">
                    <thead>
                        <tr class="border-b border-white/5 bg-surface-container">
                            <th class="w-16 px-6 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold text-center">No</th>
                            <th class="w-40 px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">
                                <div class="inline-flex items-center gap-3 whitespace-nowrap">
                                    <span>Tanggal</span>
                                    <div class="inline-flex items-center rounded-md border border-white/8 bg-surface-container-highest/70 px-1 py-0.5">
                                        <a href="{{ $sortLink('date', 'asc') }}" class="{{ $sortIconClass('date', 'asc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_up</span></a>
                                        <a href="{{ $sortLink('date', 'desc') }}" class="{{ $sortIconClass('date', 'desc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_down</span></a>
                                    </div>
                                </div>
                            </th>
                            <th class="w-[360px] px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">
                                <div class="inline-flex items-center gap-3 whitespace-nowrap">
                                    <span>Keterangan</span>
                                    <div class="inline-flex items-center rounded-md border border-white/8 bg-surface-container-highest/70 px-1 py-0.5">
                                        <a href="{{ $sortLink('description', 'asc') }}" class="{{ $sortIconClass('description', 'asc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_up</span></a>
                                        <a href="{{ $sortLink('description', 'desc') }}" class="{{ $sortIconClass('description', 'desc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_down</span></a>
                                    </div>
                                </div>
                            </th>
                            <th class="w-44 px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">
                                <div class="inline-flex items-center gap-3 whitespace-nowrap">
                                    <span>Kategori</span>
                                    <div class="inline-flex items-center rounded-md border border-white/8 bg-surface-container-highest/70 px-1 py-0.5">
                                        <a href="{{ $sortLink('category', 'asc') }}" class="{{ $sortIconClass('category', 'asc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_up</span></a>
                                        <a href="{{ $sortLink('category', 'desc') }}" class="{{ $sortIconClass('category', 'desc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_down</span></a>
                                    </div>
                                </div>
                            </th>
                            <th class="w-40 px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold">
                                <div class="inline-flex items-center gap-3 whitespace-nowrap">
                                    <span>Dompet</span>
                                    <div class="inline-flex items-center rounded-md border border-white/8 bg-surface-container-highest/70 px-1 py-0.5">
                                        <a href="{{ $sortLink('wallet', 'asc') }}" class="{{ $sortIconClass('wallet', 'asc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_up</span></a>
                                        <a href="{{ $sortLink('wallet', 'desc') }}" class="{{ $sortIconClass('wallet', 'desc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_down</span></a>
                                    </div>
                                </div>
                            </th>
                            <th class="w-48 px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold text-right">
                                <div class="inline-flex items-center justify-end gap-3 whitespace-nowrap">
                                    <span>Nominal</span>
                                    <div class="inline-flex items-center rounded-md border border-white/8 bg-surface-container-highest/70 px-1 py-0.5">
                                        <a href="{{ $sortLink('amount', 'asc') }}" class="{{ $sortIconClass('amount', 'asc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_up</span></a>
                                        <a href="{{ $sortLink('amount', 'desc') }}" class="{{ $sortIconClass('amount', 'desc') }}"><span class="material-symbols-outlined text-[15px] leading-none">keyboard_arrow_down</span></a>
                                    </div>
                                </div>
                            </th>
                            <th class="w-28 px-8 py-5 font-['Inter'] text-[11px] uppercase tracking-widest text-on-surface-variant font-bold text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <span>Aksi</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($transactions as $transaction)
                        <tr class="hover:bg-white/5 transition-colors group cursor-pointer">
                            <td class="px-6 py-5 text-center text-sm text-on-surface-variant/70 whitespace-nowrap">
                                {{ $transactions->firstItem() + $loop->index }}
                            </td>
                            <td class="w-40 px-8 py-5 text-sm text-on-surface/80 whitespace-nowrap">
                                {{ $transaction->date->format('d M Y') }}
                            </td>
                            <td class="w-[360px] px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="h-10 w-10 shrink-0 rounded-xl bg-surface-container-highest flex items-center justify-center {{ $transaction->type === 'income' ? 'text-secondary group-hover:bg-secondary/20' : 'text-primary group-hover:bg-primary/20' }} transition-all group-hover:scale-110">
                                        <span class="material-symbols-outlined">{{ $transaction->category->icon ?? 'payments' }}</span>
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-semibold text-on-surface group-hover:text-primary transition-colors">
                                            {{ $transaction->description ?? '—' }}
                                        </p>
                                        <p class="text-[10px] text-on-surface-variant capitalize">{{ $transaction->type }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="w-44 px-8 py-5">
                                <span class="inline-flex whitespace-nowrap px-3 py-1 rounded-full text-[10px] uppercase tracking-wider font-bold
                                    {{ $transaction->type === 'income' ? 'bg-secondary/10 text-secondary' : 'bg-surface-container-highest text-on-surface-variant' }}">
                                    {{ $transaction->category->name ?? 'Tidak Ada' }}
                                </span>
                            </td>
                            <td class="w-40 px-8 py-5">
                                <div class="flex items-center gap-2 whitespace-nowrap">
                                    <span class="w-2 h-2 rounded-full {{ $transaction->wallet->color ?? 'bg-primary' }} shadow-sm"></span>
                                    <span class="text-sm text-on-surface/80">{{ $transaction->wallet->name }}</span>
                                </div>
                            </td>
                            <td class="w-48 px-8 py-5 text-right whitespace-nowrap">
                                <span class="text-sm font-bold {{ $transaction->type === 'income' ? 'text-secondary' : 'text-tertiary-container' }}">
                                    {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="w-28 px-8 py-5 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button type="button"
                                        x-on:click="openEditModal(@js([
                                            'id' => $transaction->id,
                                            'wallet_id' => $transaction->wallet_id,
                                            'category_id' => $transaction->category_id,
                                            'to_wallet_id' => $transaction->to_wallet_id,
                                            'type' => $transaction->type,
                                            'amount' => (float) $transaction->amount,
                                            'description' => $transaction->description,
                                            'date' => $transaction->date->format('Y-m-d'),
                                        ]))"
                                        class="opacity-100 md:opacity-70 md:group-hover:opacity-100 transition-opacity p-2 hover:bg-primary/10 rounded-lg text-on-surface-variant/60 hover:text-primary">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                    </button>
                                    <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                                        data-confirm="Transaksi ini akan dihapus dan saldo dompet akan dikembalikan. Lanjutkan?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="opacity-100 md:opacity-70 md:group-hover:opacity-100 transition-opacity p-2 hover:bg-tertiary-container/10 rounded-lg text-on-surface-variant/60 hover:text-tertiary-container">
                                            <span class="material-symbols-outlined text-sm">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-8 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="material-symbols-outlined text-5xl text-on-surface-variant/20">receipt_long</span>
                                    <p class="text-on-surface-variant/60 italic">Belum ada transaksi tercatat.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transactions->hasPages())
            <div class="px-8 py-6 border-t border-white/5 flex items-center justify-between">
                <span class="text-xs text-on-surface-variant">
                    Menampilkan {{ $transactions->firstItem() }} – {{ $transactions->lastItem() }} dari {{ $transactions->total() }} transaksi
                </span>
                <div class="text-sm text-on-surface-variant">
                    {{ $transactions->withQueryString()->links('components.pagination') }}
                </div>
            </div>
            @else
            <div class="px-8 py-4 border-t border-white/5">
                <span class="text-xs text-on-surface-variant">{{ $transactions->total() }} transaksi</span>
            </div>
            @endif
        </div>
    </section>

    <!-- Insight Cards -->
    @if($transactions->count() > 0)
    <section class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="glass-card p-8 rounded-2xl flex flex-col gap-4">
            <span class="material-symbols-outlined text-secondary text-3xl">insights</span>
            <p class="text-sm text-on-surface-variant">Rata-rata pengeluaran harian bulan ini.</p>
            <p class="text-2xl font-bold text-secondary">
                Rp {{ number_format(auth()->user()->transactions()->where('type','expense')->whereMonth('date', now()->month)->sum('amount') / max(now()->day, 1), 0, ',', '.') }}
            </p>
        </div>
        <div class="glass-card p-8 rounded-2xl flex flex-col gap-4">
            <span class="material-symbols-outlined text-primary text-3xl">savings</span>
            <p class="text-sm text-on-surface-variant">Total transaksi bulan ini.</p>
            <p class="text-2xl font-bold text-primary">
                {{ auth()->user()->transactions()->whereMonth('date', now()->month)->count() }} transaksi
            </p>
        </div>
        <div class="glass-card p-8 rounded-2xl flex flex-col gap-4">
            <span class="material-symbols-outlined text-tertiary-container text-3xl">account_balance_wallet</span>
            <p class="text-sm text-on-surface-variant">Saldo bersih bulan ini (pemasukan - pengeluaran).</p>
            @php
                $netBalance = auth()->user()->transactions()->where('type','income')->whereMonth('date',now()->month)->sum('amount')
                            - auth()->user()->transactions()->where('type','expense')->whereMonth('date',now()->month)->sum('amount');
            @endphp
            <p class="text-2xl font-bold {{ $netBalance >= 0 ? 'text-secondary' : 'text-tertiary-container' }}">
                {{ $netBalance >= 0 ? '+' : '' }}Rp {{ number_format($netBalance, 0, ',', '.') }}
            </p>
        </div>
    </section>
    @endif
    </div>
</x-app-layout>
