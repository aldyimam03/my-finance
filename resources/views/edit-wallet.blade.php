<x-focus-layout title="Edit Dompet - My Finance" back-url="{{ route('wallets') }}">
    <main class="pt-32 pb-20 px-4 sm:px-8 max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 relative z-10"
        x-data="{
            walletName: '{{ $wallet->name }}',
            balance: '{{ $wallet->balance }}',
            type: '{{ $wallet->type }}',
            colorClass: '{{ $wallet->color ?? 'bg-primary' }}',
            icon: '{{ $wallet->icon ?? 'account_balance_wallet' }}'
        }">
        <!-- Left Content: Form Section -->
        <form action="{{ route('wallets.update', $wallet) }}" method="POST" class="lg:col-span-7 space-y-12">
            @csrf
            @method('PUT')
            <!-- Header -->
            <header class="space-y-2">
                <h1 class="text-4xl sm:text-5xl font-semibold tracking-tight text-on-surface leading-tight">Edit Dompet</h1>
                <p class="text-on-surface-variant font-medium tracking-wide opacity-80 uppercase text-xs">Perbarui informasi dompet Anda</p>
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
                        <input name="name" x-model="walletName"
                            class="bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface placeholder:text-on-surface-variant/30 outline-none w-full"
                            placeholder="Contoh: Tabungan Utama" type="text" required />
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Mata Uang Utama</label>
                        <div class="relative">
                            <select name="currency"
                                class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface appearance-none outline-none cursor-pointer">
                                <option value="IDR" class="bg-surface-container" {{ $wallet->currency === 'IDR' ? 'selected' : '' }}>IDR - Indonesian Rupiah</option>
                            </select>
                            <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-on-surface-variant text-sm">expand_more</span>
                        </div>
                    </div>
                </div>

                <!-- Tipe Akun Selection -->
                <div class="space-y-4">
                    <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Tipe Akun</label>
                    <input type="hidden" name="type" x-model="type">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
                        @foreach(['Bank', 'E-Wallet', 'Investasi', 'Tunai', 'Kripto'] as $tipe)
                        @php $icons = ['Bank'=>'account_balance','E-Wallet'=>'account_balance_wallet','Investasi'=>'trending_up','Tunai'=>'payments','Kripto'=>'currency_bitcoin']; @endphp
                        <button type="button" @click="type = '{{ $tipe }}'"
                            :class="type === '{{ $tipe }}' ? 'border-primary/40 bg-primary/10' : 'bg-surface-container-low/40 backdrop-blur-md border border-white/5 hover:bg-white/10'"
                            class="p-4 rounded-xl flex flex-col items-center gap-2 transition-all active:scale-95 group">
                            <span class="material-symbols-outlined transition-colors"
                                :class="type === '{{ $tipe }}' ? 'text-primary' : 'text-on-surface/40 group-hover:text-on-surface'"
                                :style="type === '{{ $tipe }}' ? 'font-variation-settings: \'FILL\' 1;' : ''">{{ $icons[$tipe] }}</span>
                            <span class="text-[0.75rem] font-medium transition-colors"
                                :class="type === '{{ $tipe }}' ? 'text-on-surface' : 'text-on-surface/60 group-hover:text-on-surface'">{{ $tipe }}</span>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- Balance -->
                <div class="flex flex-col gap-2">
                    <label class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant">Saldo Saat Ini</label>
                    <div class="relative group">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-bold text-lg pointer-events-none">Rp</span>
                        <input name="balance" x-model="balance"
                            class="w-full bg-surface-container-lowest border border-white/5 rounded-xl pl-14 pr-4 py-4 text-2xl font-bold tracking-tight focus:ring-1 focus:ring-primary/50 focus:border-primary/50 transition-all text-on-surface outline-none placeholder:text-surface-container-highest"
                            placeholder="0" type="number" required />
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
                            <button type="button" @click="icon = '{{ $iconName }}'"
                                :class="icon === '{{ $iconName }}' ? 'bg-primary/20 text-primary border-primary/30' : 'bg-white/5 text-on-surface/60 hover:bg-primary/20 hover:text-primary'"
                                class="w-12 h-12 rounded-full flex items-center justify-center transition-all border border-transparent">
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
                            <button type="button" @click="colorClass = '{{ $color }}'"
                                :class="colorClass === '{{ $color }}' ? 'ring-4 ring-offset-4 ring-offset-surface scale-110' : 'hover:scale-110'"
                                class="w-10 h-10 rounded-full {{ $color }} transition-all"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            <!-- Action Buttons -->
            <footer class="flex items-center gap-6 pt-12">
                <button type="submit"
                    class="px-10 py-4 bg-linear-to-br from-primary to-primary-container text-on-primary-container font-bold tracking-wide rounded-xl hover:scale-[1.02] transition-all active:scale-95 shadow-xl shadow-primary/20">
                    Simpan Perubahan
                </button>
                <a href="{{ route('wallets') }}"
                    class="px-8 py-4 text-on-surface-variant font-medium hover:text-white hover:bg-surface-container-highest border border-transparent rounded-xl transition-all">
                    Batal
                </a>
            </footer>
        </form>

        <!-- Right Content: Real-time Preview Card -->
        <div class="lg:col-span-5 relative mt-8 lg:mt-0">
            <div class="sticky top-36">
                <p class="text-[0.6875rem] font-medium uppercase tracking-widest text-on-surface-variant mb-6">Preview</p>
                <div class="relative rounded-3xl overflow-hidden p-8 min-h-[220px] flex flex-col justify-between shadow-2xl" :class="colorClass">
                    <div class="absolute inset-0 opacity-20 bg-gradient-to-br from-white/30 to-transparent"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <p class="text-white/60 text-xs font-medium uppercase tracking-widest mb-1">Dompet</p>
                            <h3 class="text-white text-2xl font-bold tracking-tight" x-text="walletName || 'Nama Dompet'"></h3>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                            <span class="material-symbols-outlined text-white text-2xl" x-text="icon"></span>
                        </div>
                    </div>
                    <div class="relative z-10">
                        <p class="text-white/60 text-xs uppercase tracking-widest mb-1">Saldo</p>
                        <p class="text-white text-3xl font-bold tracking-tight">
                            Rp <span x-text="Number(balance || 0).toLocaleString('id-ID')"></span>
                        </p>
                        <p class="text-white/50 text-xs mt-2" x-text="type"></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-focus-layout>
