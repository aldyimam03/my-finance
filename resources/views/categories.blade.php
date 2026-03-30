<x-app-layout title="Kategori - My Finance">
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
        class="fixed top-6 right-6 z-[100] bg-secondary/20 border border-secondary/30 text-secondary px-6 py-4 rounded-2xl shadow-xl backdrop-blur-md text-sm font-semibold flex items-center gap-3">
        <span class="material-symbols-outlined text-lg">check_circle</span>
        {{ session('success') }}
    </div>
    @endif

    <div x-data="{
        showAddModal: false,
        editModal: false,
        editData: { id: null, name: '' },
        openEdit(id, name) {
            this.editData = { id, name };
            this.editModal = true;
        }
    }">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant block mb-2">Manajemen Data</span>
                <h2 class="font-['Inter'] text-3xl font-bold tracking-tight text-on-surface">Kategori Transaksi</h2>
                <p class="text-on-surface-variant/70 text-sm mt-1">Buat label kategori sendiri untuk mengorganisir transaksi Anda.</p>
            </div>
            <button @click="showAddModal = true"
                class="px-6 py-3 bg-primary text-on-primary font-bold rounded-xl flex items-center gap-2 shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all shrink-0">
                <span class="material-symbols-outlined">add</span>
                Tambah Kategori
            </button>
        </div>

        <!-- Stat -->
        <div class="bg-surface-container-low border border-white/5 rounded-2xl p-5 flex items-center gap-4 mb-8 w-fit">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary">category</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Total Kategori</p>
                <p class="text-2xl font-bold">{{ $categories->count() }}</p>
            </div>
        </div>

        <!-- Daftar Kategori -->
        <div class="bg-surface-container-low border border-white/5 rounded-3xl overflow-hidden">
            <div class="px-6 py-4 border-b border-white/5 flex items-center gap-3">
                <span class="material-symbols-outlined text-on-surface-variant">label</span>
                <h3 class="font-semibold text-sm">Semua Kategori</h3>
            </div>

            <div class="divide-y divide-white/5">
                @forelse($categories as $cat)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-white/5 transition-colors group">
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-on-surface">{{ $cat->name }}</p>
                        <p class="text-[10px] text-on-surface-variant/60 uppercase tracking-wider mt-0.5">
                            {{ $cat->transactions()->count() }} transaksi
                        </p>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}')"
                            class="p-2 rounded-lg hover:bg-primary/10 text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                        @if($cat->transactions()->count() === 0)
                        <form action="{{ route('categories.destroy', $cat) }}" method="POST"
                            onsubmit="return confirm('Hapus kategori \'{{ $cat->name }}\'?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="p-2 rounded-lg hover:bg-tertiary-container/10 text-on-surface-variant hover:text-tertiary-container transition-colors">
                                <span class="material-symbols-outlined text-sm">delete</span>
                            </button>
                        </form>
                        @else
                        <span class="p-2 text-on-surface-variant/20 cursor-not-allowed"
                            title="Tidak bisa dihapus — masih dipakai di {{ $cat->transactions()->count() }} transaksi">
                            <span class="material-symbols-outlined text-sm">lock</span>
                        </span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="px-6 py-16 text-center">
                    <span class="material-symbols-outlined text-4xl text-on-surface-variant/20 block mb-3">category</span>
                    <p class="text-on-surface-variant/50 text-sm italic">Belum ada kategori. Klik "Tambah Kategori" untuk mulai.</p>
                </div>
                @endforelse
            </div>
        </div>

        <p class="mt-4 text-[11px] text-on-surface-variant/40 text-center">
            <span class="material-symbols-outlined text-xs align-middle">info</span>
            Kategori yang sudah dipakai di transaksi tidak dapat dihapus.
        </p>

        <!-- ===== MODAL TAMBAH ===== -->
        <template x-teleport="body">
            <div x-show="showAddModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-surface/80 backdrop-blur-xl" @click="showAddModal = false"></div>

                <div class="relative bg-surface-container-low border border-white/10 w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click.stop>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="px-7 py-5 border-b border-white/5 flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Tambah Kategori</h3>
                            <button type="button" @click="showAddModal = false"
                                class="text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="p-7">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant block mb-2">Nama Kategori</label>
                            <input name="name" type="text" required autofocus
                                class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 outline-none placeholder:text-on-surface-variant/30"
                                placeholder="Contoh: Makan Siang, Gaji, Hiburan...">
                        </div>
                        <div class="px-7 py-5 bg-surface-container-high/40 border-t border-white/5 flex gap-3">
                            <button type="submit"
                                class="flex-1 py-3 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                Simpan
                            </button>
                            <button type="button" @click="showAddModal = false"
                                class="px-6 py-3 text-on-surface-variant font-medium hover:bg-white/5 rounded-xl transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

        <!-- ===== MODAL EDIT ===== -->
        <template x-teleport="body">
            <div x-show="editModal"
                class="fixed inset-0 z-50 flex items-center justify-center p-4"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0">
                <div class="absolute inset-0 bg-surface/80 backdrop-blur-xl" @click="editModal = false"></div>

                <div class="relative bg-surface-container-low border border-white/10 w-full max-w-sm rounded-3xl shadow-2xl overflow-hidden"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click.stop>
                    <form x-bind:action="'/categories/' + editData.id" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="px-7 py-5 border-b border-white/5 flex justify-between items-center">
                            <h3 class="text-lg font-semibold">Edit Kategori</h3>
                            <button type="button" @click="editModal = false"
                                class="text-on-surface-variant hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="p-7">
                            <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant block mb-2">Nama Kategori</label>
                            <input name="name" type="text" x-model="editData.name" required
                                class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 outline-none">
                        </div>
                        <div class="px-7 py-5 bg-surface-container-high/40 border-t border-white/5 flex gap-3">
                            <button type="submit"
                                class="flex-1 py-3 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                                Simpan Perubahan
                            </button>
                            <button type="button" @click="editModal = false"
                                class="px-6 py-3 text-on-surface-variant font-medium hover:bg-white/5 rounded-xl transition-all">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </template>

    </div>
</x-app-layout>
