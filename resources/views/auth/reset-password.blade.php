<x-guest-layout title="Atur Ulang Kata Sandi - My Finance" :stats="$stats ?? []">
    <div class="mb-10">
        <h2 class="text-3xl font-semibold text-on-surface mb-2 tracking-tight">Atur Ulang Kata Sandi</h2>
        <p class="text-on-surface-variant body-md">Gunakan kata sandi baru yang kuat dan belum pernah dipakai sebelumnya.</p>
    </div>

    <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="space-y-2">
            <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1" for="email">Alamat Email</label>
            <input
                class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/30 rounded-xl px-4 py-4 text-on-surface focus:ring-primary/50 transition-all outline-none placeholder:text-on-surface-variant/30 @error('email') ring-red-500/50 focus:ring-red-500/50 @enderror"
                id="email" name="email" type="email" value="{{ old('email', $email) }}" placeholder="nama@email.com" required autofocus />
            @error('email')
                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2" x-data="{ show: false }">
            <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1" for="password">Kata Sandi Baru</label>
            <div class="relative">
                <input
                    class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/30 rounded-xl px-4 py-4 text-on-surface focus:ring-primary/50 transition-all outline-none placeholder:text-on-surface-variant/30 @error('password') ring-red-500/50 focus:ring-red-500/50 @enderror"
                    id="password" name="password" :type="show ? 'text' : 'password'" placeholder="Minimal 8 karakter" required />
                <button class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-on-surface transition-colors" type="button" @click="show = !show">
                    <span class="material-symbols-outlined text-xl" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                </button>
            </div>
            @error('password')
                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1" for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input
                class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/30 rounded-xl px-4 py-4 text-on-surface focus:ring-primary/50 transition-all outline-none placeholder:text-on-surface-variant/30"
                id="password_confirmation" name="password_confirmation" type="password" placeholder="Ulangi kata sandi baru" required />
        </div>

        <button
            class="w-full py-4 accent-gradient text-[#07111f] font-semibold rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
            type="submit">
            Simpan Kata Sandi Baru
            <span class="material-symbols-outlined text-xl">lock_reset</span>
        </button>
    </form>
</x-guest-layout>
