<x-focus-layout title="Tambah Dompet Baru - My Finance" back-url="{{ route('wallets') }}">
    <main class="pt-32 pb-20 px-4 sm:px-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 relative z-10"
        x-data="{
            walletName: '{{ old('name', '') }}',
            balanceRaw: '{{ old('balance', '') }}',
            balanceDisplay: '',
            type: '{{ old('type', 'Bank') }}',
            colorHex: '{{ old('color', \App\Models\Wallet::defaultColorForType(old('type', 'Bank'))) }}',
            typeIcons: {{ \Illuminate\Support\Js::from(\App\Models\Wallet::TYPE_ICONS) }},
            typeColors: {{ \Illuminate\Support\Js::from(\App\Models\Wallet::TYPE_COLORS) }},
            init() {
                this.setBalance(this.balanceRaw);
            },
            syncColorWithType(selectedType) {
                if (this.typeColors[selectedType]) this.colorHex = this.typeColors[selectedType];
            },
            setBalance(value) {
                this.balanceRaw = window.financeNumber.sanitize(value);
                this.balanceDisplay = window.financeNumber.format(this.balanceRaw);
            },
            previewBackground() {
                return `linear-gradient(135deg, ${this.colorHex} 0%, ${this.colorHex}CC 55%, #131313 160%)`;
            }
        }">
        <form action="{{ route('wallets.store') }}" method="POST" class="lg:col-span-7 space-y-12">
            @csrf
            <header class="space-y-2">
                <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight text-on-surface leading-tight">Tambah Dompet Baru</h1>
                <p class="text-on-surface-variant font-medium tracking-wide opacity-80 uppercase text-xs">Buat dompet dengan tipe dan warna yang konsisten</p>
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
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Nama Dompet</label>
                        <input name="name" x-model="walletName" class="bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface placeholder:text-on-surface-variant/30 outline-none w-full" placeholder="Contoh: Tabungan Utama" type="text" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Mata Uang Utama</label>
                        <div class="relative">
                            <select name="currency" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface appearance-none outline-none cursor-pointer">
                                <option value="IDR" class="bg-surface-container" {{ old('currency', 'IDR') === 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Tipe Akun</label>
                    <input type="hidden" name="type" x-model="type">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                        @foreach($walletTypes as $walletType)
                        <button type="button"
                            @click="type = '{{ $walletType }}'; syncColorWithType('{{ $walletType }}')"
                            :class="type === '{{ $walletType }}' ? 'border-primary/40 bg-primary/10' : 'bg-surface-container-low/40 backdrop-blur-md border border-white/5 hover:bg-white/10'"
                            class="p-4 rounded-xl flex flex-col items-center gap-2 transition-all active:scale-95 group">
                            <span class="material-symbols-outlined transition-colors"
                                :class="type === '{{ $walletType }}' ? 'text-primary' : 'text-on-surface/40 group-hover:text-on-surface'"
                                :style="type === '{{ $walletType }}' ? 'font-variation-settings: \'FILL\' 1;' : ''">{{ \App\Models\Wallet::TYPE_ICONS[$walletType] }}</span>
                            <span class="text-[0.75rem] font-medium transition-colors"
                                :class="type === '{{ $walletType }}' ? 'text-on-surface' : 'text-on-surface/60 group-hover:text-on-surface'">{{ $walletType }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Saldo Awal</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-bold text-lg pointer-events-none">Rp</span>
                        <input type="hidden" name="balance" :value="balanceRaw" />
                        <input x-model="balanceDisplay" @input="setBalance($event.target.value)" inputmode="numeric" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl pl-14 pr-4 py-4 text-2xl font-bold tracking-tight focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface outline-none placeholder:text-surface-container-highest" placeholder="0" type="text" autocomplete="off" required />
                    </div>
                </div>

                <div class="space-y-5 pt-4">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Warna Aksen</label>
                            <p class="text-xs text-on-surface-variant/60 mt-2">Icon mengikuti tipe dompet secara otomatis agar konsisten dengan daftar dompet.</p>
                        </div>
                        <div class="flex items-center gap-3 bg-surface-container-lowest border border-white/5 rounded-xl px-3 py-2">
                            <input type="color" name="color" x-model="colorHex" class="h-10 w-10 rounded-lg border-0 bg-transparent p-0 cursor-pointer" />
                            <span class="text-sm font-mono text-on-surface-variant" x-text="colorHex"></span>
                        </div>
                    </div>
                    <div class="grid grid-cols-5 sm:grid-cols-6 gap-4">
                        @foreach($walletColorPresets as $presetColor)
                        <button type="button" @click="colorHex = '{{ $presetColor }}'"
                            :class="colorHex === '{{ $presetColor }}' ? 'ring-4 ring-white/80 ring-offset-4 ring-offset-surface scale-110' : 'hover:scale-105'"
                            class="w-11 h-11 rounded-full border border-white/10 transition-all"
                            style="background-color: {{ $presetColor }}"></button>
                        @endforeach
                    </div>
                </div>
            </section>

            <footer class="flex items-center gap-6 pt-12">
                <button type="submit" class="px-10 py-4 bg-linear-to-br from-primary to-primary-container text-on-primary-container font-bold tracking-wide rounded-xl hover:scale-[1.02] transition-all active:scale-95 shadow-xl shadow-primary/20">
                    Simpan Dompet
                </button>
                <a href="{{ route('wallets') }}" class="px-8 py-4 text-on-surface-variant font-medium hover:text-white hover:bg-surface-container-highest border border-transparent rounded-xl transition-all">
                    Batal
                </a>
            </footer>
        </form>

        <div class="lg:col-span-5 relative mt-8 lg:mt-0">
            <div class="sticky top-28 space-y-8">
                <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant block mb-4">Preview Dompet</label>
                <div class="relative w-full aspect-[1.6/1] rounded-4xl p-8 overflow-hidden shadow-2xl transition-colors duration-500 border border-white/5"
                    :style="`background: ${previewBackground()}`">
                    <div class="absolute inset-0 bg-linear-to-bl from-white/15 to-transparent pointer-events-none"></div>
                    <div class="absolute inset-x-0 bottom-0 h-1/2 bg-linear-to-t from-black/20 to-transparent pointer-events-none"></div>

                    <div class="relative h-full flex flex-col justify-between z-10">
                        <div class="flex justify-between items-start">
                            <div class="space-y-1">
                                <p class="text-[11px] font-medium text-white/70 uppercase tracking-widest">Saldo Saat Ini</p>
                                <h3 class="text-3xl font-bold text-white tracking-tight">Rp <span x-text="balanceDisplay || '0'"></span></h3>
                            </div>
                            <div class="w-12 h-12 rounded-2xl bg-black/15 backdrop-blur-md flex items-center justify-center border border-white/15 shrink-0">
                                <span class="material-symbols-outlined text-white text-2xl" x-text="typeIcons[type] ?? 'account_balance_wallet'"></span>
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-1">
                                <p class="text-[10px] text-white/55 uppercase tracking-[0.2em] font-medium">Nama Dompet</p>
                                <p class="text-xl font-semibold text-white tracking-wide truncate pr-4" x-text="walletName ? walletName : 'Tabungan Utama'"></p>
                            </div>
                            <div class="flex justify-between items-end">
                                <div>
                                    <p class="text-sm text-white/80 tracking-wide font-medium" x-text="type"></p>
                                    <p class="text-[11px] text-white/60 uppercase tracking-widest">IDR</p>
                                </div>
                                <div class="w-12 h-12 rounded-2xl bg-white/12 border border-white/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-white/90" x-text="typeIcons[type] ?? 'account_balance_wallet'"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-surface-container-low border border-primary/20 p-6 rounded-3xl flex gap-4 shadow-xl">
                    <span class="material-symbols-outlined text-primary text-xl shrink-0 mt-0.5" style="font-variation-settings: 'FILL' 1;">info</span>
                    <p class="text-sm text-on-surface-variant leading-relaxed">
                        Ikon dompet sekarang otomatis mengikuti tipe akun. Anda cukup mengatur nama, saldo, dan warna aksennya.
                    </p>
                </div>
            </div>
        </div>
    </main>
</x-focus-layout>
