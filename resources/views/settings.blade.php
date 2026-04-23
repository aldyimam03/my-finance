<x-app-layout title="Pengaturan Profil - My Finance">
    <div x-data="{ isPasswordModalOpen: {{ $errors->has('current_password') || $errors->has('password') ? 'true' : 'false' }}, isDeleteModalOpen: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }" class="max-w-7xl mx-auto space-y-8">
        
        @if (session('status') === 'profile-updated')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500/10 text-green-500 p-4 rounded-xl mb-4 border border-green-500/20 font-medium">
                Profil berhasil diperbarui.
            </div>
        @endif
        @if (session('status') === 'password-updated')
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-green-500/10 text-green-500 p-4 rounded-xl mb-4 border border-green-500/20 font-medium">
                Kata sandi berhasil diperbarui.
            </div>
        @endif

        <!-- Header Section -->
        <header class="mb-12 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <p class="text-primary font-medium text-sm uppercase tracking-wider mb-2">Akun Saya</p>
                <h2 class="text-4xl font-bold tracking-tight text-on-surface">Pengaturan Profil</h2>
            </div>
        </header>

        <!-- Bento Grid Layout -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-12 gap-8">
            @csrf
            @method('PUT')
            <!-- Left Column: Personal Info & Avatar -->
            <section class="col-span-12 lg:col-span-8 space-y-8">
                <!-- Personal Info Card -->
                <div class="bg-surface-container-low p-8 rounded-3xl shadow-2xl shadow-black/20">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8 gap-6">
                        <div class="flex items-center gap-8">
                            <div class="relative group cursor-pointer">
                                <img alt="User Avatar Large" class="w-24 h-24 rounded-2xl border-2 border-white/5 object-cover group-hover:opacity-80 transition-opacity" src="{{ auth()->user()->avatarUrl() }}"/>
                                <label for="avatar" class="absolute -bottom-2 -right-2 bg-linear-to-br from-primary to-primary-container w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-primary/20 hover:scale-105 transition-transform cursor-pointer">
                                    <span class="material-symbols-outlined text-on-primary text-xl">photo_camera</span>
                                </label>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold mb-1">Informasi Pribadi</h3>
                                <p class="text-sm text-on-surface-variant opacity-70">Perbarui identitas dan foto profil Anda.</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <input id="avatar" name="avatar" type="file" accept=".jpg,.jpeg,.png,.webp" class="block w-full text-sm text-on-surface-variant file:mr-4 file:rounded-xl file:border-0 file:bg-primary/15 file:px-4 file:py-2 file:font-medium file:text-primary hover:file:bg-primary/20" />
                            <p class="text-[11px] text-on-surface-variant/70">Format: JPG, PNG, atau WEBP. Maksimal 2MB.</p>
                            @error('avatar') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase tracking-widest text-on-surface-variant" for="name">Nama Lengkap</label>
                            <input id="name" name="name" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none @error('name') border-red-500/50 focus:ring-red-500/50 @enderror" type="text" value="{{ old('name', auth()->user()->name) }}" required/>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase tracking-widest text-on-surface-variant" for="email">Alamat Email</label>
                            <input id="email" name="email" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none @error('email') border-red-500/50 focus:ring-red-500/50 @enderror" type="email" value="{{ old('email', auth()->user()->email) }}" required/>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                                    <p class="text-[12px] text-on-surface-variant">Perbarui kata sandi secara berkala untuk menjaga keamanan akun.</p>
                                </div>
                            </div>
                            <button type="button" @click="isPasswordModalOpen = true" class="px-4 py-2 text-primary font-medium hover:bg-primary/10 rounded-lg transition-colors text-sm w-full sm:w-auto mt-2 sm:mt-0">Ubah Sandi</button>
                        </div>
                        
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between p-4 bg-red-500/10 rounded-xl border border-red-500/20 gap-4 hover:border-red-500/30 transition-colors mt-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-lg bg-red-500/20 flex items-center justify-center shrink-0">
                                    <span class="material-symbols-outlined text-sm text-red-500">warning</span>
                                </div>
                                <div>
                                    <p class="font-medium text-sm text-red-500">Hapus Akun Secara Permanen</p>
                                    <p class="text-[12px] text-on-surface-variant">Tindakan ini tidak bisa dibatalkan</p>
                                </div>
                            </div>
                            <button type="button" @click="isDeleteModalOpen = true" class="px-4 py-2 bg-red-500 text-white font-medium hover:bg-red-600 rounded-lg transition-colors text-sm w-full sm:w-auto mt-2 sm:mt-0 shadow-lg shadow-red-500/20">Hapus Akun</button>
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
                            <div>
                                <select name="currency" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface appearance-none focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none cursor-pointer">
                                    <option value="IDR" class="bg-surface-container" {{ old('currency', auth()->user()->currency ?? 'IDR') === 'IDR' ? 'selected' : '' }}>IDR - Rupiah Indonesia</option>
                                </select>
                            </div>
                            @error('currency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm font-medium uppercase tracking-widest text-on-surface-variant">Bahasa Aplikasi</label>
                            <div>
                                <select name="locale" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface appearance-none focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none cursor-pointer">
                                    <option value="id" class="bg-surface-container" {{ old('locale', auth()->user()->locale ?? 'id') === 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                </select>
                            </div>
                            @error('locale') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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
                        <label for="notif-1" class="flex items-center justify-between group cursor-pointer">
                            <div>
                                <p class="font-medium text-sm group-hover:text-primary transition-colors">Ringkasan Bulanan</p>
                                <p class="text-[11px] text-on-surface-variant mt-0.5">Terima ringkasan pemasukan dan pengeluaran bulan berjalan</p>
                            </div>
                            <span class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="hidden" name="notify_weekly_report" value="0" />
                                <input id="notif-1" name="notify_weekly_report" value="1" {{ old('notify_weekly_report', auth()->user()->notify_weekly_report) ? 'checked' : '' }} class="sr-only peer" type="checkbox"/>
                                <div class="w-9 h-5 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                            </span>
                        </label>
                        <label for="notif-2" class="flex items-center justify-between group cursor-pointer">
                            <div>
                                <p class="font-medium text-sm group-hover:text-primary transition-colors">Peringatan Anggaran</p>
                                <p class="text-[11px] text-on-surface-variant mt-0.5">Saat pengeluaran melebihi 80%</p>
                            </div>
                            <span class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="hidden" name="notify_budget_alert" value="0" />
                                <input id="notif-2" name="notify_budget_alert" value="1" {{ old('notify_budget_alert', auth()->user()->notify_budget_alert) ? 'checked' : '' }} class="sr-only peer" type="checkbox"/>
                                <div class="w-9 h-5 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                            </span>
                        </label>
                        <label for="notif-3" class="flex items-center justify-between opacity-50 hover:opacity-100 transition-opacity cursor-pointer group">
                            <div>
                                <p class="font-medium text-sm group-hover:text-primary transition-colors">Tips Finansial</p>
                                <p class="text-[11px] text-on-surface-variant mt-0.5">Tampilkan insight dari pola transaksi dan pengeluaran terbaru</p>
                            </div>
                            <span class="relative inline-flex items-center cursor-pointer shrink-0">
                                <input type="hidden" name="notify_marketing_tips" value="0" />
                                <input id="notif-3" name="notify_marketing_tips" value="1" {{ old('notify_marketing_tips', auth()->user()->notify_marketing_tips) ? 'checked' : '' }} class="sr-only peer" type="checkbox"/>
                                <div class="w-9 h-5 bg-surface-container-highest rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary"></div>
                            </span>
                        </label>
                    </div>
                </div>

                <!-- CTA Save -->
                <div class="space-y-3 pt-4 shrink-0">
                    <button type="submit" class="w-full bg-linear-to-br from-primary to-primary-container py-4 rounded-xl font-bold tracking-wide text-on-primary-container shadow-2xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                        Simpan Perubahan
                    </button>
                    <button type="reset" class="w-full bg-surface-container-high py-4 rounded-xl font-medium text-on-surface-variant hover:bg-surface-container-highest hover:text-white transition-colors">
                        Batalkan
                    </button>
                </div>
            </section>
        </form>
        <!-- Delete Account Modal -->
        <div x-cloak x-show="isDeleteModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="isDeleteModalOpen" x-transition.opacity.duration.300ms @click="isDeleteModalOpen = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
            
            <div x-show="isDeleteModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="relative bg-surface-container-low border border-red-500/20 rounded-3xl shadow-2xl p-8 w-full max-w-md overflow-hidden">
                
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-red-500">warning</span>
                        <h3 class="text-xl font-bold text-on-surface">Konfirmasi Hapus Akun</h3>
                    </div>
                    <button @click="isDeleteModalOpen = false" class="text-on-surface-variant hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-on-surface-variant">Apakah Anda yakin ingin menghapus akun secara permanen? Seluruh data transaksi, dompet, dan profil Anda akan hilang dan <strong>tidak dapat dikembalikan</strong>. Silakan masukkan kata sandi Anda untuk memverifikasi langkah ini.</p>
                </div>

                <form action="{{ route('profile.destroy') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('DELETE')

                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="password_delete" class="text-[11px] font-medium uppercase tracking-widest text-on-surface-variant">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input id="password_delete" name="password" :type="show ? 'text' : 'password'" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-red-500/50 focus:ring-1 focus:ring-red-500/50 transition-colors outline-none pr-12" required>
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[18px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('password', 'userDeletion') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="isDeleteModalOpen = false" class="flex-1 bg-surface-container-highest py-3 rounded-xl font-medium text-on-surface-variant hover:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 bg-red-500 text-white py-3 rounded-xl font-semibold hover:opacity-90 transition-opacity flex items-center justify-center">
                            Hapus Permanen
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Modal -->
        <div x-cloak x-show="isPasswordModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div x-show="isPasswordModalOpen" x-transition.opacity.duration.300ms @click="isPasswordModalOpen = false" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
            
            <div x-show="isPasswordModalOpen" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="relative bg-surface-container-low border border-white/10 rounded-3xl shadow-2xl p-8 w-full max-w-md overflow-hidden">
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-on-surface">Ubah Kata Sandi</h3>
                    <button @click="isPasswordModalOpen = false" class="text-on-surface-variant hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form action="{{ route('profile.password') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="current_password" class="text-[11px] font-medium uppercase tracking-widest text-on-surface-variant">Sandi Saat Ini</label>
                        <div class="relative">
                            <input id="current_password" name="current_password" :type="show ? 'text' : 'password'" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none pr-12" required>
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[18px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('current_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="new_password" class="text-[11px] font-medium uppercase tracking-widest text-on-surface-variant">Sandi Baru</label>
                        <div class="relative">
                            <input id="new_password" name="password" :type="show ? 'text' : 'password'" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none pr-12" required>
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[18px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2" x-data="{ show: false }">
                        <label for="confirm_password" class="text-[11px] font-medium uppercase tracking-widest text-on-surface-variant">Konfirmasi Sandi Baru</label>
                        <div class="relative">
                            <input id="confirm_password" name="password_confirmation" :type="show ? 'text' : 'password'" class="w-full bg-surface-container-lowest border border-white/5 rounded-xl px-4 py-3 text-on-surface focus:border-primary/50 focus:ring-1 focus:ring-primary/50 transition-colors outline-none pr-12" required>
                            <button type="button" @click="show = !show" class="absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-white transition-colors">
                                <span class="material-symbols-outlined text-[18px]" x-text="show ? 'visibility_off' : 'visibility'">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" @click="isPasswordModalOpen = false" class="flex-1 bg-surface-container-highest py-3 rounded-xl font-medium text-on-surface-variant hover:text-white transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="flex-1 bg-primary text-on-primary py-3 rounded-xl font-semibold hover:opacity-90 transition-opacity">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>
