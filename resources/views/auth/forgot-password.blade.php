<x-guest-layout title="Lupa Kata Sandi - My Finance" :stats="$stats ?? []">
    <div class="mb-10">
        <h2 class="text-3xl font-semibold text-on-surface mb-2 tracking-tight">Lupa Kata Sandi</h2>
        <p class="text-on-surface-variant body-md">Masukkan email akun Anda. Kami akan mengirim link untuk mengatur ulang kata sandi.</p>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-2xl border border-secondary/20 bg-secondary/10 px-4 py-3 text-sm text-secondary">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
        @csrf
        <div class="space-y-2">
            <label class="block text-[11px] uppercase tracking-[0.05em] text-on-surface-variant font-medium ml-1" for="email">Alamat Email</label>
            <div class="relative">
                <input
                    class="w-full bg-surface-container-lowest border-none ring-1 ring-outline-variant/30 rounded-xl px-4 py-4 text-on-surface focus:ring-primary/50 transition-all outline-none placeholder:text-on-surface-variant/30 @error('email') ring-red-500/50 focus:ring-red-500/50 @enderror"
                    id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@email.com" required autofocus />
            </div>
            @error('email')
                <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p>
            @enderror
        </div>

        <button
            class="w-full py-4 accent-gradient text-[#07111f] font-semibold rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2"
            type="submit">
            Kirim Link Reset
            <span class="material-symbols-outlined text-xl">mail</span>
        </button>
    </form>

    <div class="mt-10 text-center">
        <a class="text-sm text-primary hover:text-primary-container transition-colors font-medium" href="{{ route('login') }}">Kembali ke login</a>
    </div>
</x-guest-layout>
