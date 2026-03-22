<x-guest-layout title="Register - My Finance">
    <div class="mb-10">
        <h2 class="text-3xl font-semibold text-on-surface mb-2 tracking-tight">Buat Akun Baru</h2>
        <p class="text-on-surface-variant body-md">Lengkapi detail di bawah untuk memulai pengelolaan aset Anda secara profesional.</p>
    </div>
    
    <form action="{{ route('dashboard') }}" class="space-y-6">
        <!-- Name Input -->
        <div class="space-y-2">
            <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1"
                for="full_name">Nama Lengkap</label>
            <div class="relative group">
                <input
                    class="w-full px-4 py-4 bg-surface-container-lowest border-none rounded-xl focus:ring-1 focus:ring-primary/50 transition-all text-on-surface placeholder:text-on-surface-variant/30 ring-1 ring-outline-variant/30 outline-none"
                    id="full_name" placeholder="John Doe" type="text" />
            </div>
        </div>
        
        <!-- Email Input -->
        <div class="space-y-2">
            <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1"
                for="email">Alamat Email</label>
            <div class="relative group">
                <input
                    class="w-full px-4 py-4 bg-surface-container-lowest border-none rounded-xl focus:ring-1 focus:ring-primary/50 transition-all text-on-surface placeholder:text-on-surface-variant/30 ring-1 ring-outline-variant/30 outline-none"
                    id="email" placeholder="name@example.com" type="email" />
            </div>
        </div>
        
        <!-- Password Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1"
                    for="password">Kata Sandi</label>
                <div class="relative group">
                    <input
                        class="w-full px-4 py-4 bg-surface-container-lowest border-none rounded-xl focus:ring-1 focus:ring-primary/50 transition-all text-on-surface placeholder:text-on-surface-variant/30 ring-1 ring-outline-variant/30 outline-none"
                        id="password" placeholder="••••••••" type="password" />
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1"
                    for="confirm_password">Konfirmasi Sandi</label>
                <div class="relative group">
                    <input
                        class="w-full px-4 py-4 bg-surface-container-lowest border-none rounded-xl focus:ring-1 focus:ring-primary/50 transition-all text-on-surface placeholder:text-on-surface-variant/30 ring-1 ring-outline-variant/30 outline-none"
                        id="confirm_password" placeholder="••••••••" type="password" />
                </div>
            </div>
        </div>
        
        <!-- Terms Checkbox -->
        <div class="flex items-start gap-3 py-2">
            <div class="flex items-center h-5">
                <input
                    class="peer appearance-none w-5 h-5 rounded border border-outline-variant bg-transparent checked:bg-primary checked:border-primary transition-all cursor-pointer"
                    id="terms" type="checkbox" />
                <span
                    class="material-symbols-outlined absolute text-[14px] text-on-primary opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none mt-[2px] ml-[2px]"
                    data-icon="check">check</span>
            </div>
            <label class="text-sm text-on-surface-variant leading-snug cursor-pointer" for="terms">
                Saya menyetujui <span
                    class="text-on-surface font-medium cursor-pointer hover:text-primary transition-colors">Syarat
                    &amp; Ketentuan</span> serta <span
                    class="text-on-surface font-medium cursor-pointer hover:text-primary transition-colors">Kebijakan
                    Privasi</span>.
            </label>
        </div>
        
        <!-- CTA Button -->
        <button
            class="w-full py-4 accent-gradient text-on-primary font-semibold rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-4"
            type="submit">
            Daftar Sekarang
        </button>
    </form>
    
    <!-- Footer Link -->
    <div class="mt-10 text-center">
        <p class="text-on-surface-variant body-md">
            Sudah memiliki akun?
            <a class="text-primary font-semibold ml-1 hover:underline underline-offset-4 decoration-primary/30"
                href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </div>
</x-guest-layout>
