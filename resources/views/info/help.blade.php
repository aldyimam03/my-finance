<x-focus-layout title="Bantuan - My Finance" :back-url="route('login')">
    <main class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pt-24 pb-12">
        <section class="bg-surface-container-low border border-white/5 rounded-3xl p-6 sm:p-8 shadow-2xl shadow-black/30">
            <span class="text-[11px] uppercase tracking-[0.12em] text-primary font-semibold">Bantuan</span>
            <h1 class="mt-3 text-3xl sm:text-4xl font-semibold tracking-tight">Panduan Penggunaan Dasar</h1>
            <p class="mt-4 text-on-surface-variant leading-relaxed">Halaman ini menjelaskan cara masuk, mengatur ulang kata sandi, mencatat transaksi, dan mengelola data keuangan Anda dengan aman.</p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Masuk dan Registrasi</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Gunakan email aktif untuk membuat akun. Setelah berhasil mendaftar, Anda dapat langsung mengakses dashboard dan mulai membuat dompet, kategori, serta transaksi.</p>
                </article>
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Lupa Kata Sandi</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Klik tautan <span class="text-on-surface">Lupa Kata Sandi?</span> di halaman login. Sistem akan mengirim link reset ke email Anda jika akun ditemukan.</p>
                </article>
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Mengelola Transaksi</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Selalu pilih dompet, kategori, nominal, dan tanggal dengan benar. Perubahan transaksi akan memengaruhi saldo dompet serta laporan yang tampil di aplikasi.</p>
                </article>
                <article class="rounded-2xl bg-white/[0.03] border border-white/5 p-5">
                    <h2 class="text-lg font-semibold">Dukungan</h2>
                    <p class="mt-2 text-sm text-on-surface-variant leading-relaxed">Jika menemukan bug atau data terasa tidak sinkron, periksa kembali input Anda dan gunakan halaman pengaturan untuk menyesuaikan preferensi akun.</p>
                </article>
            </div>
        </section>
    </main>
</x-focus-layout>
