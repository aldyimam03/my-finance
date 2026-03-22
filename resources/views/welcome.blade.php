<x-guest-layout title="Login - My Finance">
    <div class="mb-10">
        <h2 class="text-3xl font-semibold text-on-surface mb-2 tracking-tight">Selamat Datang</h2>
        <p class="text-on-surface-variant body-md">Silakan masuk ke akun Obsidian Ledger Anda.</p>
    </div>
    
    <form action="{{ route('dashboard') }}" class="space-y-6">
        <!-- Email Field -->
        <div class="space-y-2">
            <label
                class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1"
                for="email">Alamat Email</label>
            <div class="relative">
                <input
                    class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/30 rounded-xl px-4 py-4 text-on-surface focus:ring-primary/50 transition-all outline-none placeholder:text-on-surface-variant/30"
                    id="email" placeholder="nama@email.com" type="email" />
            </div>
        </div>
        
        <!-- Password Field -->
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <label
                    class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1"
                    for="password">Kata Sandi</label>
            </div>
            <div class="relative group">
                <input
                    class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/30 rounded-xl px-4 py-4 text-on-surface focus:ring-primary/50 transition-all outline-none placeholder:text-on-surface-variant/30"
                    id="password" placeholder="••••••••" type="password" />
                <button
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors"
                    type="button">
                    <span class="material-symbols-outlined text-xl" data-icon="visibility">visibility</span>
                </button>
            </div>
        </div>
        
        <!-- Options -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2 group cursor-pointer">
                <div class="relative flex items-center">
                    <input
                        class="peer appearance-none w-5 h-5 rounded border border-outline-variant bg-transparent checked:bg-primary checked:border-primary transition-all cursor-pointer"
                        id="remember" type="checkbox" />
                    <span
                        class="material-symbols-outlined absolute text-[14px] text-on-primary opacity-0 peer-checked:opacity-100 left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none"
                        data-icon="check">check</span>
                </div>
                <label
                    class="text-sm text-on-surface-variant group-hover:text-on-surface transition-colors cursor-pointer"
                    for="remember">Ingat Saya</label>
            </div>
            <a class="text-sm text-primary hover:text-primary-container transition-colors font-medium"
                href="#">Lupa Kata Sandi?</a>
        </div>
        
        <!-- Submit Button -->
        <button
            class="w-full py-4 bg-gradient-to-r from-primary to-primary-container text-on-primary font-semibold rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2 mt-4"
            type="submit">
            Masuk
            <span class="material-symbols-outlined text-xl" data-icon="arrow_forward">arrow_forward</span>
        </button>
    </form>
    
    <!-- Footer Links -->
    <div class="mt-12 text-center">
        <p class="text-on-surface-variant text-sm">
            Belum memiliki akun?
            <a class="text-primary font-semibold hover:underline decoration-primary/30 underline-offset-4 ml-1"
                href="{{ route('register') }}">Daftar Sekarang</a>
        </p>
    </div>
</x-guest-layout>
