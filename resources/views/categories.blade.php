<x-app-layout title="Kategori - My Finance">

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('categoriesTour', () => ({
                showAddModal: false,
                editModal: false,
                showTour: @json(request('tour') === '1' && auth()->check() && !auth()->user()->onboarding_completed),
                tourStep: 1,
                iconOptions: [
                    'label',
                    'category',
                    'payments',
                    'account_balance_wallet',
                    'credit_card',
                    'savings',
                    'trending_up',
                    'shopping_cart',
                    'shopping_bag',
                    'restaurant',
                    'local_cafe',
                    'directions_car',
                    'local_gas_station',
                    'movie',
                    'subscriptions',
                    'wifi',
                    'phone_android',
                    'school',
                    'fitness_center',
                    'medical_services',
                    'home',
                    'pets',
                    'celebration',
                    'volunteer_activism',
                    'groups',
                    'handyman',
                    'bolt',
                    'more_horiz',
                ],
                tourSteps: [
                    { ref: 'sidebarCategory', title: 'Menu Kategori', text: 'Klik menu ini untuk membuka halaman pengelolaan kategori transaksi.' },
                    { ref: 'tourHeader', title: 'Halaman Kategori', text: 'Di sini kamu dapat membuat dan mengelola kategori transaksi seperti Belanja, Gaji, atau Investasi.' },
                    { ref: 'tourTotal', title: 'Total Kategori', text: 'Card ini menampilkan jumlah kategori yang sudah kamu buat.' },
                    { ref: 'tourAddButton', title: 'Tambah Kategori Baru', text: 'Gunakan tombol ini untuk menambahkan kategori transaksi baru.' },
                    { ref: 'tourCategoryList', title: 'Daftar Kategori', text: 'Semua kategori yang sudah dibuat akan muncul di bagian ini.' },
                    { ref: 'tourAddButton', title: 'Akses Cepat', text: 'Tombol ini adalah shortcut untuk menambahkan kategori dengan cepat.' }
                ],
                tourHighlight: { left: '0px', top: '0px', width: '0px', height: '0px' },
                tooltipStyle: { top: '50%', left: '50%', transform: 'translate(-50%, -50%)', width: 'min(95vw, 30rem)' },
                addData: { name: '', icon: 'label' },
                editData: { id: null, name: '', icon: 'label' },
                openEdit(id, name, icon) {
                    this.editData = { id, name, icon: icon || 'label' };
                    this.editModal = true;
                },
                openAddModal() {
                    this.addData = { name: '', icon: 'label' };
                    this.showAddModal = true;
                },
                selectAddIcon(icon) {
                    this.addData.icon = icon;
                },
                selectEditIcon(icon) {
                    this.editData.icon = icon;
                },
                get activeTourStep() {
                    return this.tourSteps[this.tourStep - 1];
                },
                setTourHighlight() {
                    this.$nextTick(() => {
                        const refName = this.activeTourStep?.ref;
                        let target = this.$refs[refName];

                        if (!target && refName === 'sidebarCategory') {
                            target = document.querySelector('a[title="Kategori"]');
                        }

                        if (!target) {
                            return;
                        }

                        const targetRect = target.getBoundingClientRect();
                        const topNav = document.querySelector('header');
                        const headerOffset = topNav ? topNav.getBoundingClientRect().height + 12 : 80;
                        const offscreen = targetRect.top < headerOffset || targetRect.bottom > window.innerHeight - 16;
                        if (offscreen) {
                            target.scrollIntoView({ block: 'center', behavior: 'auto' });
                        }

                        let rect = target.getBoundingClientRect();
                        if (rect.top < headerOffset) {
                            window.scrollBy({ top: rect.top - headerOffset, behavior: 'auto' });
                            rect = target.getBoundingClientRect();
                        }

                        const padding = 14;
                        const tooltipWidth = Math.min(300, window.innerWidth - 48);
                        const tooltipHeight = 165;
                        const spaceRight = window.innerWidth - rect.right - padding;
                        const spaceLeft = rect.left - padding;
                        const spaceBottom = window.innerHeight - rect.bottom - padding;
                        const placeLeft = spaceRight < tooltipWidth && spaceLeft > tooltipWidth;
                        const placeAbove = rect.top > tooltipHeight + padding;
                        const placeBelow = spaceBottom > tooltipHeight;

                        let tooltipLeft = placeLeft ? rect.left - tooltipWidth - padding : rect.right + padding;
                        tooltipLeft = Math.max(16, Math.min(tooltipLeft, window.innerWidth - tooltipWidth - 16));

                        let tooltipTop;
                        if (placeBelow) {
                            tooltipTop = rect.bottom + padding;
                        } else if (placeAbove) {
                            tooltipTop = rect.top - tooltipHeight - padding;
                        } else {
                            tooltipTop = Math.max(16, Math.min(rect.top + rect.height / 2 - tooltipHeight / 2, window.innerHeight - tooltipHeight - 16));
                        }

                        this.tourHighlight = {
                            left: `${rect.left - 12}px`,
                            top: `${rect.top - 12}px`,
                            width: `${rect.width + 24}px`,
                            height: `${rect.height + 24}px`,
                        };
                        this.tooltipStyle = {
                            position: 'fixed',
                            top: `${tooltipTop}px`,
                            left: `${tooltipLeft}px`,
                            transform: 'none',
                            width: `${tooltipWidth}px`,
                            'max-width': `${tooltipWidth}px`,
                        };
                    });
                },
                nextTourStep() {
                    if (this.tourStep < this.tourSteps.length) {
                        this.tourStep++;
                        this.setTourHighlight();
                    }
                },
                prevTourStep() {
                    if (this.tourStep > 1) {
                        this.tourStep--;
                        this.setTourHighlight();
                    }
                },
                skipTour() {
                    this.showTour = false;
                    document.body.style.overflow = '';
                    document.documentElement.style.overflow = '';
                    fetch(@json(route('onboarding.complete')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token()),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).finally(() => {
                        history.replaceState(null, '', @json(route('categories')));
                    });
                },
                finishTour() {
                    this.showTour = false;
                    document.body.style.overflow = '';
                    document.documentElement.style.overflow = '';
                    fetch(@json(route('onboarding.complete')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token()),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).finally(() => {
                        history.replaceState(null, '', @json(route('categories')));
                    });
                },
                init() {
                    this.$watch('showTour', value => {
                        document.body.style.overflow = value ? 'hidden' : '';
                    });

                    if (this.showTour) {
                        if (window.innerWidth >= 1024) {
                            window.scrollTo({ top: 0, left: 0, behavior: 'smooth' });
                        }
                        this.setTourHighlight();
                        window.addEventListener('resize', () => this.setTourHighlight());
                        setTimeout(() => {
                            document.body.style.overflow = 'hidden';
                            document.documentElement.style.overflow = 'hidden';
                        }, 150);
                    }
                }
            }));
        });
    </script>

    <div x-data="categoriesTour()" x-init="init()">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div x-ref="tourHeader">
                <span class="font-['Inter'] text-[11px] uppercase tracking-[0.05em] text-on-surface-variant block mb-2">Manajemen Data</span>
                <h2 class="font-['Inter'] text-3xl font-bold tracking-tight text-on-surface">Kategori Transaksi</h2>
                <p class="text-on-surface-variant/70 text-sm mt-1">Buat label kategori sendiri untuk mengorganisir transaksi Anda.</p>
            </div>
            <button x-ref="tourAddButton" @click="openAddModal()"
                class="px-6 py-3 bg-primary text-on-primary font-bold rounded-xl flex items-center gap-2 shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all shrink-0">
                <span class="material-symbols-outlined">add</span>
                Tambah Kategori
            </button>
        </div>

        <div x-show="showTour" x-cloak style="display:none" class="fixed inset-0 z-50 pointer-events-none">
            <div class="absolute inset-0 bg-black/20"></div>
            <div class="absolute rounded-3xl border-2 border-primary/90 bg-transparent shadow-[0_0_0_9999px_rgba(0,0,0,0.75)] pointer-events-none transition-all duration-300" :style="tourHighlight"></div>
            <div class="absolute pointer-events-auto z-50" :style="tooltipStyle">
                <div class="rounded-3xl bg-surface-container-low border border-white/10 p-5 shadow-2xl w-full min-w-72 max-w-96">
                    <div class="flex items-start gap-3 mb-4">
                        <span class="material-symbols-outlined text-[28px] text-primary onboarding-icon">lightbulb</span>
                        <div>
                            <h3 class="text-lg font-semibold text-on-surface" x-text="activeTourStep.title"></h3>
                            <p class="text-sm text-on-surface-variant mt-1" x-text="activeTourStep.text"></p>
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 text-sm">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <button type="button" @click="skipTour()" class="px-2.5 py-2 rounded-xl border border-white/10 text-on-surface-variant hover:bg-white/5 transition text-xs">Lewati</button>
                                <button type="button" @click="prevTourStep()" class="px-2.5 py-2 rounded-xl border border-white/10 text-on-surface-variant hover:bg-white/5 transition text-xs" x-show="tourStep > 1">Sebelumnya</button>
                                <button type="button" @click="tourStep < tourSteps.length ? nextTourStep() : finishTour()" class="px-3 py-2 rounded-xl bg-primary text-on-primary font-semibold hover:bg-primary/90 transition text-xs whitespace-nowrap">
                                    <span x-text="tourStep < tourSteps.length ? 'Berikutnya' : 'Selesai'"></span>
                                </button>
                            </div>
                            <div class="text-[11px] text-on-surface-variant text-right">Langkah <span x-text="tourStep"></span> / <span x-text="tourSteps.length"></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stat -->
        <div x-ref="tourTotal" class="bg-surface-container-low border border-white/5 rounded-2xl p-5 flex items-center gap-4 mb-8 w-fit">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                <span class="material-symbols-outlined text-primary">category</span>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest text-on-surface-variant">Total Kategori</p>
                <p class="text-2xl font-bold">{{ $categories->count() }}</p>
            </div>
        </div>

        <!-- Daftar Kategori -->
        <div x-ref="tourCategoryList" class="bg-surface-container-low border border-white/5 rounded-3xl">
            <div class="px-6 py-4 border-b border-white/5 flex items-center gap-3">
                <span class="material-symbols-outlined text-on-surface-variant">label</span>
                <h3 class="font-semibold text-sm">Semua Kategori</h3>
            </div>

            <div class="divide-y divide-white/5">
                @forelse($categories as $cat)
                <div class="flex items-center gap-4 px-6 py-4 hover:bg-white/5 transition-colors group">
                    <div class="h-10 w-10 shrink-0 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">{{ $cat->icon ?? 'label' }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm text-on-surface">{{ $cat->name }}</p>
                        <p class="text-[10px] text-on-surface-variant/60 uppercase tracking-wider mt-0.5">
                            {{ $cat->transactions()->count() }} transaksi
                        </p>
                    </div>
                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <button @click="openEdit({{ $cat->id }}, '{{ addslashes($cat->name) }}', '{{ addslashes($cat->icon ?? 'label') }}')"
                            class="p-2 rounded-lg hover:bg-primary/10 text-on-surface-variant hover:text-primary transition-colors">
                            <span class="material-symbols-outlined text-sm">edit</span>
                        </button>
                        @if($cat->transactions()->count() === 0)
                        <form action="{{ route('categories.destroy', $cat) }}" method="POST"
                            onsubmit="return false" data-confirm="Hapus kategori &apos;{{ $cat->name }}&apos;? Tindakan ini tidak bisa dibatalkan.">
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
                            <input name="name" type="text" required autofocus x-model="addData.name"
                                class="w-full bg-surface-container-highest border-none rounded-xl px-4 py-3 text-sm text-on-surface focus:ring-2 focus:ring-primary/30 outline-none placeholder:text-on-surface-variant/30"
                                placeholder="Contoh: Makan Siang, Gaji, Hiburan...">

                            <div class="mt-6">
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant block">Ikon</label>
                                    <div class="flex items-center gap-2 text-[11px] text-on-surface-variant/70">
                                        <span class="material-symbols-outlined text-[18px] text-primary">auto_awesome</span>
                                        <span x-text="addData.icon"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="icon" :value="addData.icon" />
                                <div class="grid grid-cols-7 gap-2">
                                    <template x-for="ic in iconOptions" :key="ic">
                                        <button type="button"
                                            @click="selectAddIcon(ic)"
                                            class="h-11 rounded-xl border transition-all flex items-center justify-center"
                                            :class="addData.icon === ic ? 'border-primary/50 bg-primary/10 text-primary shadow-lg shadow-primary/10 scale-[1.02]' : 'border-white/10 bg-surface-container-highest text-on-surface-variant hover:bg-white/5 hover:text-on-surface'">
                                            <span class="material-symbols-outlined text-[20px]" x-text="ic"></span>
                                        </button>
                                    </template>
                                </div>
                                <p class="mt-2 text-[11px] text-on-surface-variant/50">
                                    Pilih ikon yang paling menggambarkan kategori ini.
                                </p>
                            </div>
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

                            <div class="mt-6">
                                <div class="flex items-center justify-between gap-3 mb-2">
                                    <label class="text-[10px] font-bold uppercase tracking-widest text-on-surface-variant block">Ikon</label>
                                    <div class="flex items-center gap-2 text-[11px] text-on-surface-variant/70">
                                        <span class="material-symbols-outlined text-[18px] text-primary">auto_awesome</span>
                                        <span x-text="editData.icon"></span>
                                    </div>
                                </div>
                                <input type="hidden" name="icon" :value="editData.icon" />
                                <div class="grid grid-cols-7 gap-2">
                                    <template x-for="ic in iconOptions" :key="ic">
                                        <button type="button"
                                            @click="selectEditIcon(ic)"
                                            class="h-11 rounded-xl border transition-all flex items-center justify-center"
                                            :class="editData.icon === ic ? 'border-primary/50 bg-primary/10 text-primary shadow-lg shadow-primary/10 scale-[1.02]' : 'border-white/10 bg-surface-container-highest text-on-surface-variant hover:bg-white/5 hover:text-on-surface'">
                                            <span class="material-symbols-outlined text-[20px]" x-text="ic"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
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
