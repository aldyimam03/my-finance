<x-focus-layout title="Keamanan - My Finance" :back-url="route('login')">
    <main class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pt-24 pb-12">
        <section class="bg-surface-container-low border border-white/5 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/30">
            <span class="text-[11px] uppercase tracking-[0.12em] text-primary font-semibold">Keamanan</span>
            <h1 class="mt-3 text-3xl sm:text-4xl font-semibold tracking-tight">Aturan Keamanan Akun</h1>
            <div class="mt-6 grid gap-4">
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Gunakan kata sandi kuat</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Pakai minimal 8 karakter dengan kombinasi huruf besar, huruf kecil, angka, atau simbol. Hindari kata sandi yang mudah ditebak.</p>
                </article>
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Jaga kerahasiaan link reset</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Link reset kata sandi bersifat sensitif. Jangan bagikan email reset ke siapa pun karena link tersebut dapat dipakai untuk mengambil alih akun Anda.</p>
                </article>
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Gunakan perangkat yang tepercaya</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Hindari login dari perangkat umum tanpa logout. Jika Anda memakai komputer bersama, selalu keluar setelah selesai.</p>
                </article>
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Periksa perubahan data</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Bila ada transaksi, dompet, atau pengaturan yang terasa tidak Anda buat, segera ubah kata sandi dan periksa seluruh data akun.</p>
                </article>
            </div>
        </section>
    </main>
</x-focus-layout>
