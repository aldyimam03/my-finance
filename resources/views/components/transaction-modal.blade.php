<div 
    x-show="isTransactionModalOpen" 
    style="display: none;"
    class="relative z-50" 
    aria-labelledby="modal-title" 
    role="dialog" 
    aria-modal="true"
    x-data="{ 
        type: 'expense',
        amountRaw: '',
        amountDisplay: '',
        wallets: {{ $allWallets->toJson() }},
        categories: {{ $allCategories->toJson() }},
        setAmount(value) {
            this.amountRaw = window.financeNumber.sanitize(value);
            this.amountDisplay = window.financeNumber.format(this.amountRaw);
        }
    }"
>
    <!-- Background backdrop -->
    <div 
        x-show="isTransactionModalOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity"
    ></div>

    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <!-- Modal panel -->
            <div 
                x-show="isTransactionModalOpen"
                @click.away="isTransactionModalOpen = false"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="relative transform overflow-hidden rounded-3xl bg-surface-container-low text-left shadow-2xl shadow-black/60 border border-white/5 transition-all sm:my-8 sm:w-full sm:max-w-xl"
            >
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="type" x-model="type">

                    <!-- Modal Header -->
                    <div class="px-8 pt-8 pb-4 flex justify-between items-center border-b border-white/5">
                        <h2 class="text-xl text-on-surface font-semibold tracking-tight" id="modal-title">Tambah Transaksi</h2>
                        <button type="button" @click="isTransactionModalOpen = false" class="text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest p-2 rounded-full transition-colors outline-none focus:ring-2 focus:ring-primary/50">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                    
                    <div class="px-8 py-8 space-y-8">
                        <!-- Tipe Transaksi (Segmented Control) -->
                        <div class="p-1.5 bg-surface-container-lowest rounded-full flex gap-1 border border-white/5 shadow-inner">
                            <button type="button" @click="type = 'expense'" :class="type === 'expense' ? 'bg-tertiary-container text-on-primary shadow-md font-bold' : 'text-on-surface-variant hover:bg-white/5'" class="flex-1 py-2.5 rounded-full text-[11px] uppercase tracking-widest transition-all outline-none">Pengeluaran</button>
                            <button type="button" @click="type = 'income'" :class="type === 'income' ? 'bg-secondary text-on-secondary shadow-md font-bold' : 'text-on-surface-variant hover:bg-white/5'" class="flex-1 py-2.5 rounded-full text-[11px] uppercase tracking-widest transition-all outline-none">Pemasukan</button>
                        </div>
                        
                        <!-- Nominal (Large Input) -->
                        <div class="space-y-3 relative">
                            <label class="text-[11px] uppercase tracking-widest font-semibold text-on-surface-variant ml-1">Nominal Transaksi</label>
                            <div class="relative flex items-center group">
                                <span class="absolute left-0 text-3xl font-semibold text-on-surface-variant group-focus-within:text-on-surface transition-colors" :class="{'text-secondary': type === 'income', 'text-tertiary-container': type === 'expense'}">Rp</span>
                                <input type="hidden" name="amount" :value="amountRaw" />
                                <input x-model="amountDisplay" @input="setAmount($event.target.value)" inputmode="numeric" autocomplete="off" class="w-full bg-transparent border-0 border-b-2 border-surface-container-highest focus:border-primary focus:ring-0 text-4xl font-bold pl-12 py-3 text-on-surface transition-all placeholder:text-surface-container-highest outline-none" placeholder="0" type="text" required />
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Dompet -->
                            <div class="space-y-3">
                                <label class="text-[11px] uppercase tracking-widest font-semibold text-on-surface-variant ml-1">Dompet</label>
                                <div class="relative group">
                                    <select name="wallet_id" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3.5 text-sm appearance-none focus:ring-1 focus:ring-primary/50 focus:border-primary/50 text-on-surface cursor-pointer outline-none transition-colors shadow-inner" required>
                                        <template x-for="wallet in wallets" :key="wallet.id">
                                            <option :value="wallet.id" x-text="wallet.name" class="bg-surface-container"></option>
                                        </template>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm group-focus-within:text-primary transition-colors">account_balance_wallet</span>
                                </div>
                            </div>

                            <!-- Kategori -->
                            <div class="space-y-3">
                                <label class="text-[11px] uppercase tracking-widest font-semibold text-on-surface-variant ml-1">Kategori</label>
                                <div class="relative group">
                                    <select name="category_id" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3.5 text-sm appearance-none focus:ring-1 focus:ring-primary/50 focus:border-primary/50 text-on-surface cursor-pointer outline-none transition-colors shadow-inner" required>
                                        <template x-for="cat in categories" :key="cat.id">
                                            <option :value="cat.id" x-text="cat.name" class="bg-surface-container"></option>
                                        </template>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm group-focus-within:text-primary transition-colors">expand_more</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Tanggal -->
                            <div class="space-y-3">
                                <label class="text-[11px] uppercase tracking-widest font-semibold text-on-surface-variant ml-1">Tanggal</label>
                                <div class="relative group">
                                    <input name="date" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3.5 text-sm focus:ring-1 focus:ring-primary/50 focus:border-primary/50 text-on-surface outline-none transition-colors appearance-none shadow-inner" type="date" value="{{ date('Y-m-d') }}" required />
                                </div>
                            </div>
                            
                            <!-- Catatan -->
                            <div class="space-y-3">
                                <label class="text-[11px] uppercase tracking-widest font-semibold text-on-surface-variant ml-1">Deskripsi</label>
                                <input name="description" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3.5 text-sm focus:ring-1 focus:ring-primary/50 focus:border-primary/50 text-on-surface outline-none transition-colors placeholder:text-surface-container-highest shadow-inner" placeholder="Piknik, jajan, dll..." type="text" />
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="pt-6 flex flex-col gap-3">
                            <button type="submit" class="w-full py-4 rounded-xl accent-gradient text-[#07111f] font-bold tracking-wide hover:scale-[1.02] active:scale-[0.98] transition-all shadow-xl shadow-primary/20">
                                Simpan Transaksi
                            </button>
                            <button type="button" @click="isTransactionModalOpen = false" class="w-full py-3 rounded-xl text-center text-sm font-medium text-on-surface-variant hover:text-white hover:bg-surface-container-highest transition-colors">
                                Batal
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
