<x-focus-layout title="Tambah Dompet Baru - My Finance" back-url="{{ route('wallets') }}">
    <main class="pt-32 pb-20 px-4 sm:px-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 relative z-10" x-data="{ walletName: '', balance: '', type: 'Bank', colorClass: 'bg-primary', icon: 'account_balance_wallet' }">
        <!-- Left Content: Form Section -->
        <form action="{{ route('wallets.store') }}" method="POST" class="lg:col-span-7 space-y-12">
            @csrf
            <!-- Header -->
            <header class="space-y-2">
                <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight text-on-surface leading-tight">Tambah Dompet Baru</h1>
                <p class="text-on-surface-variant font-medium tracking-wide opacity-80 uppercase text-xs">Sesuaikan identitas finansial Anda</p>
            </header>

            @if ($errors->any())
            <div class="bg-tertiary-container/10 border border-tertiary-container/20 p-4 rounded-xl">
                <ul class="list-disc list-inside text-xs text-tertiary-container">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <section class="space-y-10">
                <!-- Basic Info Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Nama Dompet</label>
                        <input name="name" x-model="walletName" class="bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface placeholder:text-on-surface-variant/30 outline-none w-full" placeholder="Contoh: Tabungan Utama" type="text" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Mata Uang Utama</label>
                        <div class="relative">
                            <select name="currency" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface appearance-none outline-none cursor-pointer">
                                <option value="IDR" class="bg-surface-container">IDR - Indonesian Rupiah</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm border-none bg-transparent">expand_more</span>
                        </div>
                    </div>
                </div>

                <!-- Tipe Akun Selection -->
                <div class="space-y-4">
                    <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Tipe Akun</label>
                    <input type="hidden" name="type" x-model="type">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                        <button type="button" @click="type = 'Bank'" :class="type === 'Bank' ? 'border-primary/40 bg-primary/10' : 'bg-surface-container-low/40 backdrop-blur-md border border-white/5 hover:bg-white/10'" class="p-4 rounded-xl flex flex-col items-center gap-2 transition-all active:scale-95 group">
                            <span class="material-symbols-outlined transition-colors" :class="type === 'Bank' ? 'text-primary' : 'text-on-surface/40 group-hover:text-on-surface'" :style="type === 'Bank' ? 'font-variation-settings: \'FILL\' 1;' : ''">account_balance</span>
                            <span class="text-[0.75rem] font-medium transition-colors" :class="type === 'Bank' ? 'text-on-surface' : 'text-on-surface/60 group-hover:text-on-surface'">Bank</span>
                        </button>
                        <button type="button" @click="type = 'E-Wallet'" :class="type === 'E-Wallet' ? 'border-primary/40 bg-primary/10' : 'bg-surface-container-low/40 backdrop-blur-md border border-white/5 hover:bg-white/10'" class="p-4 rounded-xl flex flex-col items-center gap-2 transition-all active:scale-95 group">
                            <span class="material-symbols-outlined transition-colors" :class="type === 'E-Wallet' ? 'text-primary' : 'text-on-surface/40 group-hover:text-on-surface'" :style="type === 'E-Wallet' ? 'font-variation-settings: \'FILL\' 1;' : ''">account_balance_wallet</span>
                            <span class="text-[0.75rem] font-medium transition-colors" :class="type === 'E-Wallet' ? 'text-on-surface' : 'text-on-surface/60 group-hover:text-on-surface'">E-Wallet</span>
                        </button>
                        <button type="button" @click="type = 'Investasi'" :class="type === 'Investasi' ? 'border-primary/40 bg-primary/10' : 'bg-surface-container-low/40 backdrop-blur-md border border-white/5 hover:bg-white/10'" class="p-4 rounded-xl flex flex-col items-center gap-2 transition-all active:scale-95 group">
                            <span class="material-symbols-outlined transition-colors" :class="type === 'Investasi' ? 'text-primary' : 'text-on-surface/40 group-hover:text-on-surface'" :style="type === 'Investasi' ? 'font-variation-settings: \'FILL\' 1;' : ''">trending_up</span>
                            <span class="text-[0.75rem] font-medium transition-colors" :class="type === 'Investasi' ? 'text-on-surface' : 'text-on-surface/60 group-hover:text-on-surface'">Investasi</span>
                        </button>
                        <button type="button" @click="type = 'Tunai'" :class="type === 'Tunai' ? 'border-primary/40 bg-primary/10' : 'bg-surface-container-low/40 backdrop-blur-md border border-white/5 hover:bg-white/10'" class="p-4 rounded-xl flex flex-col items-center gap-2 transition-all active:scale-95 group">
                            <span class="material-symbols-outlined transition-colors" :class="type === 'Tunai' ? 'text-primary' : 'text-on-surface/40 group-hover:text-on-surface'" :style="type === 'Tunai' ? 'font-variation-settings: \'FILL\' 1;' : ''">payments</span>
                            <span class="text-[0.75rem] font-medium transition-colors" :class="type === 'Tunai' ? 'text-on-surface' : 'text-on-surface/60 group-hover:text-on-surface'">Tunai</span>
                        </button>
                        <button type="button" @click="type = 'Kripto'" :class="type === 'Kripto' ? 'border-primary/40 bg-primary/10' : 'bg-surface-container-low/40 backdrop-blur-md border border-white/5 hover:bg-white/10'" class="p-4 rounded-xl flex flex-col items-center gap-2 transition-all active:scale-95 group">
                            <span class="material-symbols-outlined transition-colors" :class="type === 'Kripto' ? 'text-primary' : 'text-on-surface/40 group-hover:text-on-surface'" :style="type === 'Kripto' ? 'font-variation-settings: \'FILL\' 1;' : ''">currency_bitcoin</span>
                            <span class="text-[0.75rem] font-medium transition-colors" :class="type === 'Kripto' ? 'text-on-surface' : 'text-on-surface/60 group-hover:text-on-surface'">Kripto</span>
                        </button>
                    </div>
                </div>

                <!-- Initial Balance -->
                <div class="flex flex-col gap-2">
                    <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Saldo Awal</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-bold text-lg pointer-events-none">Rp</span>
                        <input name="balance" x-model="balance" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl pl-14 pr-4 py-4 text-2xl font-bold tracking-tight focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface outline-none placeholder:text-surface-container-highest" placeholder="0" type="number" required />
                    </div>
                </div>

                <!-- Customization Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 pt-4">
                    <!-- Icon Grid -->
                    <div class="space-y-4">
                        <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Pilih Ikon</label>
                        <input type="hidden" name="icon" x-model="icon">
                        <div class="grid grid-cols-4 gap-3">
                            @foreach(['savings', 'credit_card', 'apartment', 'shopping_bag', 'flight', 'fastfood', 'directions_car', 'account_balance_wallet'] as $iconName)
                            <button type="button" @click="icon = '{{ $iconName }}'" :class="icon === '{{ $iconName }}' ? 'bg-primary/20 text-primary border-primary/30' : 'bg-white/5 text-on-surface/60 hover:bg-primary/20 hover:text-primary'" class="w-12 h-12 rounded-full flex items-center justify-center transition-all border border-transparent">
                                <span class="material-symbols-outlined">{{ $iconName }}</span>
                            </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Color Swatches -->
                    <div class="space-y-4">
                        <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Warna Aksen</label>
                        <input type="hidden" name="color" x-model="colorClass">
                        <div class="grid grid-cols-4 gap-4">
                            @foreach(['bg-primary', 'bg-secondary', 'bg-tertiary-container', 'bg-amber-400', 'bg-indigo-500', 'bg-fuchsia-500', 'bg-rose-500', 'bg-slate-400'] as $color)
                            <button type="button" @click="colorClass = '{{ $color }}'" :class="colorClass === '{{ $color }}' ? 'ring-4 ring-offset-4 ring-offset-surface scale-110' : 'hover:scale-110'" class="w-10 h-10 rounded-full {{ $color }} transition-all" style="{{ $color === 'bg-primary' ? 'ring-color: var(--primary);' : '' }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Action Buttons -->
            <footer class="flex items-center gap-6 pt-12">
                <button type="submit" class="px-10 py-4 bg-linear-to-br from-primary to-primary-container text-on-primary-container font-bold tracking-wide rounded-xl hover:scale-[1.02] transition-all active:scale-95 shadow-xl shadow-primary/20">
                    Simpan Dompet
                </button>
                <a href="{{ route('wallets') }}" class="px-8 py-4 text-on-surface-variant font-medium hover:text-white hover:bg-surface-container-highest border border-transparent rounded-xl transition-all">
                    Batal
                </a>
            </footer>
        </form>

        <!-- Right Content: Real-time Preview Card -->
        <div class="lg:col-span-5 relative mt-8 lg:mt-0">
            <div class="sticky top-28 space-y-8">
                <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant block mb-4">Preview Kartu</label>
                <!-- The Animated Wallet Card -->
                <div class="relative w-full aspect-[1.6/1] rounded-4xl p-8 overflow-hidden shadow-2xl transition-colors duration-500 border border-white/5" :class="colorClass">
                    <div class="absolute inset-0 bg-linear-to-bl from-white/20 to-transparent pointer-events-none mix-blend-overlay"></div>
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-linear-to-t from-black/20 to-transparent pointer-events-none"></div>
                    
                    <div class="relative h-full flex flex-col justify-between z-10">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <p class="text-[11px] font-medium text-white/70 uppercase tracking-widest drop-shadow-sm">Saldo Saat Ini</p>
                                <h3 class="text-3xl font-bold text-white tracking-tight drop-shadow-md">Rp <span x-text="balance ? balance : '0'"></span></h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center shadow-inner border border-white/10 shrink-0">
                                <span class="material-symbols-outlined text-white text-2xl" data-weight="fill">account_balance_wallet</span>
                            </div>
                        </div>
                        
                        <div class="space-y-5">
                            <div class="space-y-1">
                                <p class="text-[10px] text-white/50 uppercase tracking-[0.2em] font-medium">Nama Dompet</p>
                                <p class="text-xl font-medium text-white tracking-wide drop-shadow-sm truncate pr-4" x-text="walletName ? walletName : 'Tabungan Utama'"></p>
                            </div>
                            <div class="flex justify-between items-end">
                                <p class="text-sm text-white/80 tracking-widest font-mono drop-shadow-sm">•••• •••• 8890</p>
                                <div class="flex -space-x-3 drop-shadow-md opacity-90">
                                    <div class="w-8 h-8 rounded-full bg-rose-500"></div>
                                    <div class="w-8 h-8 rounded-full bg-amber-500 mix-blend-screen"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Preview Card (Inactive State Mock) -->
                <div class="bg-surface-container-low/40 backdrop-blur-md border border-white/5 p-6 rounded-3xl flex items-center gap-6 opacity-40 hover:opacity-100 transition-opacity">
                    <div class="w-14 h-14 rounded-2xl bg-surface-container-highest flex items-center justify-center border border-white/5 shrink-0">
                        <span class="material-symbols-outlined text-on-surface-variant">lock</span>
                    </div>
                    <div class="flex-1 space-y-3">
                        <div class="h-2.5 w-24 bg-surface-container-highest rounded-full"></div>
                        <div class="h-2 w-32 bg-surface-container-highest rounded-full"></div>
                    </div>
                </div>

                <!-- Information Box -->
                <div class="bg-surface-container-low border border-primary/20 p-6 rounded-3xl flex gap-4 shadow-xl">
                    <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Dompet baru akan langsung tersinkronisasi dengan riwayat transaksi Anda. Anda dapat mengubah pengaturan ini kapan saja melalui menu pengaturan aset.
                    </p>
                </div>
            </div>
        </div>
    </main>
</x-focus-layout>
