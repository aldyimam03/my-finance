<x-app-layout title="Pengaturan Profil - My Finance">
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Header Section -->
        <header class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <p class="text-primary font-medium text-sm uppercase tracking-wider mb-2">Akun Saya</p>
                <h2 class="text-4xl font-bold tracking-tight text-on-surface">Pengaturan Profil</h2>
            </div>
            <div class="bg-surface-container-high px-4 py-2 rounded-full border border-white/5 flex items-center gap-2">
                <span class="material-symbols-outlined text-secondary text-sm" style="font-variation-settings: 'FILL' 1;">workspace_premium</span>
                <span class="text-[12px] font-bold text-on-surface uppercase tracking-wider">Status Keanggotaan: <span class="text-primary">Obsidian Tier</span></span>
            </div>
        </header>

        <!-- Bento Grid Layout -->
        <div class="grid grid-cols-12 gap-8">
            <!-- Left Column: Personal Info & Avatar -->
            <section class="col-span-12 lg:col-span-8 space-y-8">
                <!-- Personal Info Card -->
                <div class="bg-surface-container-low p-8 rounded-3xl shadow-2xl shadow-black/20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-6">
                        <div class="flex items-center gap-8">
                            <div class="relative group cursor-pointer">
                                <img alt="User Avatar Large" class="w-24 h-24 rounded-2xl border-2 border-white/5 object-cover group-hover:opacity-80 transition-opacity" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDwosYvHrmfInKoQA57WPCEEneawjojBJgGb9hHySWmtcDSaEFL_aSXaXuMKV_1KWOXHlL9lW51677Enz_pQQFMnJtETy_X0690kjts65WQjmrc9j-oI8bMbujl8S6jnfWz4F56ciMUMEtCCiHVOAoiAtPOJhmnf4UUXzxmvyXUd4BucKITfFhjwi1hbFN9OfxiGeHjTrunV9A5mNlGPA0t1Jzz_RZ3pT6f-Lp3FWLsbzF86eiB3UicwaIlmrOSJTEBpBP2-Pqqo0o"/>
                                <button class="absolute -bottom-2 -right-2 bg-linear-to-br from-primary to-primary-container w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                                    <span class="material-symbols-outlined text-on-primary text-xl">photo_camera</span>
                                </button>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-1">Informasi Pribadi</h3>
                                <p class="text-sm text-on-surface-variant opacity-70">Perbarui identitas dan foto profil Anda.</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase tracking-widest text-on-surface-variant">Nama Lengkap</label>
                            <input class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none" type="text" value="Aria Obsidian"/>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase tracking-widest text-on-surface-variant">Alamat Email</label>
                            <input class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none" type="email" value="aria.obsidian@finance.com"/>
                        </div>
                    </div>
                </div>

                <!-- Security Section -->
                <div class="bg-surface-container-low p-8 rounded-3xl shadow-2xl shadow-black/20">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-primary">security</span>
                        <h3 class="text-xl font-semibold">Keamanan & Akses</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-surface-container-lowest rounded-xl border border-white/5 gap-4 hover:border-white/10 transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm">lock</span>
                                </div>
                                <div>
                                    <p class="font-medium text-sm">Kata Sandi</p>
                                    <p class="text-[12px] text-on-surface-variant">Terakhir diubah 3 bulan lalu</p>
                                </div>
                            </div>
                            <button class="px-4 py-2 text-primary font-medium hover:bg-primary/10 rounded-lg transition-colors text-sm w-full sm:w-auto mt-2 sm:mt-0">Ubah Sandi</button>
                        </div>
                        <div class="flex items-center justify-between p-4 bg-surface-container-lowest rounded-xl border border-white/5 hover:border-white/10 transition-colors cursor-pointer group" onclick="document.getElementById('2fa-toggle').click()">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-4 w-full justify-between pointer-events-none">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-highest flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-sm">vibration</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-sm">Autentikasi 2-Faktor (2FA)</p>
                                        <p class="text-[12px] text-on-surface-variant mt-0.5">Amankan akun dengan verifikasi tambahan</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer mt-3 sm:mt-0 shrink-0 pointer-events-auto">
                                    <input id="2fa-toggle" checked="" class="sr-only peer" type="checkbox"/>
                                    <div class="w-11 h-6 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-secondary"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Right Column: Preferences & Notifications -->
            <section class="col-span-12 lg:col-span-4 space-y-8 flex flex-col">
                <!-- Preferences Card -->
                <div class="glass-card p-8 rounded-3xl">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-primary">tune</span>
                        <h3 class="text-xl font-semibold">Preferensi</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase tracking-widest text-on-surface-variant">Mata Uang Utama</label>
                            <div class="relative">
                                <select class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface appearance-none focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none cursor-pointer">
                                    <option class="bg-surface-container">IDR - Rupiah Indonesia</option>
                                    <option class="bg-surface-container">USD - US Dollar</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-50">expand_more</span>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase tracking-widest text-on-surface-variant">Bahasa Aplikasi</label>
                            <div class="relative">
                                <select class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface appearance-none focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none cursor-pointer">
                                    <option class="bg-surface-container">Bahasa Indonesia</option>
                                    <option class="bg-surface-container">English (US)</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none opacity-50">expand_more</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notifications Card -->
                <div class="bg-surface-container-low p-8 rounded-3xl shadow-2xl shadow-black/20 flex-1">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="material-symbols-outlined text-primary">notifications_active</span>
                        <h3 class="text-xl font-semibold">Notifikasi</h3>
                    </div>
                    <div class="space-y-6">
                        <div class="flex items-center justify-between group cursor-pointer" onclick="document.getElementById('notif-1').click()">
                            <div>
                                <p class="font-medium text-sm group-hover:text-primary transition-colors">Laporan Mingguan</p>
                                <p class="text-[11px] text-on-surface-variant mt-0.5 pointer-events-none">Terima ringkasan finansial</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0 pointer-events-auto">
                                <input id="notif-1" checked="" class="sr-only peer" type="checkbox"/>
                                <div class="w-9 h-5 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between group cursor-pointer" onclick="document.getElementById('notif-2').click()">
                            <div>
                                <p class="font-medium text-sm group-hover:text-primary transition-colors">Peringatan Anggaran</p>
                                <p class="text-[11px] text-on-surface-variant mt-0.5 pointer-events-none">Saat pengeluaran melebihi 80%</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0 pointer-events-auto">
                                <input id="notif-2" checked="" class="sr-only peer" type="checkbox"/>
                                <div class="w-9 h-5 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between opacity-50 hover:opacity-100 transition-opacity cursor-pointer group" onclick="document.getElementById('notif-3').click()">
                            <div>
                                <p class="font-medium text-sm group-hover:text-primary transition-colors">Tips Investasi</p>
                                <p class="text-[11px] text-on-surface-variant mt-0.5 pointer-events-none">Analisis pasar harian</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer shrink-0 pointer-events-auto">
                                <input id="notif-3" class="sr-only peer" type="checkbox"/>
                                <div class="w-9 h-5 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- CTA Save -->
                <div class="space-y-3 pt-4 shrink-0">
                    <button class="w-full bg-linear-to-br from-primary to-primary-container py-4 rounded-xl font-bold tracking-wide text-on-primary-container shadow-2xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Simpan Perubahan
                    </button>
                    <button class="w-full bg-surface-container-high py-4 rounded-xl font-medium text-on-surface-variant hover:bg-surface-container-highest hover:text-white transition-colors">
                        Batalkan
                    </button>
                </div>
            </section>
        </div>

        <!-- Footnote -->
        <footer class="mt-24 pb-8 text-center border-t border-white/5 pt-8">
            <p class="text-[12px] text-on-surface-variant opacity-40">My Finance Obsidian Edition &copy; {{ date('Y') }}. Melindungi privasi Anda adalah prioritas kami.</p>
        </footer>
    </div>
</x-app-layout>
