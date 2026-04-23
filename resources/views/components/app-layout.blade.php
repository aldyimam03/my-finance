<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title ?? 'Dashboard - My Finance' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-surface text-on-surface font-body selection:bg-primary/30"
    @if(session('success')) data-flash-success="{{ session('success') }}" @endif
    @if(session('error'))   data-flash-error="{{ session('error') }}"     @endif
    @if(session('warning')) data-flash-warning="{{ session('warning') }}" @endif
    @if(session('info'))    data-flash-info="{{ session('info') }}"       @endif
    @if(session('status') === 'profile-updated')  data-flash-success="Profil berhasil diperbarui."  @endif
    @if(session('status') === 'password-updated') data-flash-success="Kata sandi berhasil diperbarui." @endif
    x-data="{
        isTransactionModalOpen: false,
        /* Desktop: persist collapse. Mobile: always start closed */
        sidebarOpen: window.innerWidth >= 1024 ? localStorage.getItem('sidebarOpen') !== 'false' : false,
        mobileMenuOpen: false,
        onboardingActive: @json(auth()->check() && !auth()->user()->onboarding_completed && request()->routeIs('dashboard')),
        onboardingStep: 1,
        onboardingStyle: { left: '0px', top: '0px', width: '0px', height: '0px' },
        onboardingPulse: false,
        isMobile() { return window.innerWidth < 1024; },
        toggleSidebar() {
            if (this.isMobile()) {
                this.mobileMenuOpen = !this.mobileMenuOpen;
            } else {
                this.sidebarOpen = !this.sidebarOpen;
                localStorage.setItem('sidebarOpen', this.sidebarOpen);
            }
        },
        closeMobileMenu() { this.mobileMenuOpen = false; },
        setOnboardingHighlight() {
            this.$nextTick(() => {
                const link = this.$refs.categoryLink;
                if (!link) return;
                const rect = link.getBoundingClientRect();
                this.onboardingStyle = {
                    left: `${rect.left - 8}px`,
                    top: `${rect.top - 8}px`,
                    width: `${rect.width + 16}px`,
                    height: `${rect.height + 16}px`,
                };
            });
        },
        startPulse() {
            this.onboardingPulse = true;
            setTimeout(() => this.onboardingPulse = false, 2000);
        },
        navigateToCategoryTour() {
            this.onboardingActive = false;
            setTimeout(() => {
                window.location = '{{ route('categories', ['tour' => 1]) }}';
            }, 200);
        },
        skipOnboarding() {
            this.onboardingActive = false;
            fetch('{{ route('onboarding.complete') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({})
            });
        },
        init() {
            if (this.onboardingActive) {
                if (!this.isMobile()) {
                    this.sidebarOpen = true;
                    localStorage.setItem('sidebarOpen', true);
                }
                this.setOnboardingHighlight();
                window.addEventListener('resize', () => this.setOnboardingHighlight());

                // Start pulse animation after modal appears
                setTimeout(() => this.startPulse(), 500);
            }
        }
    }"
    x-init="init()"
    @keydown.escape="isTransactionModalOpen = false; mobileMenuOpen = false"
    :class="isTransactionModalOpen ? 'overflow-hidden' : ''"
>
    <!-- ===== Mobile Overlay Backdrop ===== -->
    <div
        x-show="mobileMenuOpen"
        @click="closeMobileMenu()"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
        style="display:none"
    ></div>

    <!-- ===== SideNavBar ===== -->
    <aside
        :class="{
            /* Desktop collapsed/expanded */
            'w-60': !isMobile() && sidebarOpen,
            'w-[72px]': !isMobile() && !sidebarOpen,
            /* Mobile: slide in/out */
            'translate-x-0 w-72 shadow-2xl shadow-black/60': isMobile() && mobileMenuOpen,
            '-translate-x-full w-72': isMobile() && !mobileMenuOpen,
        }"
        class="h-screen fixed left-0 top-0 border-r border-white/5 bg-surface-container-low flex flex-col py-6 z-50 font-['Inter'] antialiased tracking-tight transition-all duration-300 overflow-hidden"
    >
        <!-- Logo & Toggle -->
        <div class="flex items-center gap-3 mb-8 px-4 shrink-0">
            <button
                @click="toggleSidebar()"
                class="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors shrink-0"
                :title="sidebarOpen || mobileMenuOpen ? 'Tutup Sidebar' : 'Buka Sidebar'"
            >
                <span class="material-symbols-outlined text-[20px] text-on-surface-variant transition-transform duration-300"
                    :class="(sidebarOpen && !isMobile()) ? 'rotate-0' : 'rotate-180'">menu_open</span>
            </button>
            <div x-show="sidebarOpen || mobileMenuOpen"
                x-transition:enter="transition ease-out duration-200 delay-100"
                x-transition:enter-start="opacity-0 -translate-x-2"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-100"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="overflow-hidden">
                <h1 class="text-[15px] font-semibold tracking-tight text-[#e5e2e1] whitespace-nowrap">My Finance</h1>
                <p class="text-[10px] uppercase tracking-[0.05em] text-on-surface-variant opacity-60 whitespace-nowrap">Pengelolaan Keuangan</p>
            </div>
        </div>

        <!-- Nav Links -->
        <nav class="flex-1 space-y-0.5 px-2 overflow-y-auto overflow-x-hidden">
            @php
                $navItems = [
                    ['route' => 'dashboard',    'icon' => 'dashboard',              'label' => 'Dasbor'],
                    ['route' => 'transactions', 'icon' => 'receipt_long',           'label' => 'Transaksi'],
                    ['route' => 'wallets',      'icon' => 'account_balance_wallet', 'label' => 'Dompet'],
                    ['route' => 'budgets',      'icon' => 'pie_chart',              'label' => 'Anggaran'],
                    ['route' => 'categories',   'icon' => 'category',               'label' => 'Kategori'],
                    ['route' => 'reports',      'icon' => 'assessment',             'label' => 'Laporan'],
                ];
            @endphp

            @foreach($navItems as $item)
            @php $active = request()->routeIs($item['route']); @endphp
            <a
                href="{{ route($item['route']) }}"
                @click="if(isMobile()) closeMobileMenu()"
                title="{{ $item['label'] }}"
                {{ $item['route'] === 'categories' ? 'x-ref="categoryLink"' : '' }}
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative
                    {{ $active ? 'text-primary bg-primary/10 font-semibold' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }}"
            >
                <span class="material-symbols-outlined text-[22px] shrink-0 {{ $active ? '[font-variation-settings:\'FILL\'_1]' : '' }}">{{ $item['icon'] }}</span>
                <span x-show="sidebarOpen || mobileMenuOpen"
                    x-transition:enter="transition ease-out duration-200 delay-75"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="text-[14px] whitespace-nowrap overflow-hidden">{{ $item['label'] }}</span>
                @if($active)
                <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-l-full"></span>
                @endif
            </a>
            @endforeach
        </nav>

        <!-- Bottom Actions -->
        <div class="px-2 pt-4 pb-6 space-y-0.5 border-t border-white/5 mt-2 shrink-0">
            {{-- <!-- Tambah Transaksi -->
            <button
                @click="isTransactionModalOpen = true; if(isMobile()) closeMobileMenu()"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-primary/10 hover:bg-primary/20 text-primary transition-all font-semibold group"
                title="Tambah Transaksi"
            >
                <span class="material-symbols-outlined text-[22px] shrink-0">add_circle</span>
                <span x-show="sidebarOpen || mobileMenuOpen" class="text-[14px] whitespace-nowrap overflow-hidden">Tambah Transaksi</span>
            </button> --}}

            <!-- Pengaturan -->
            <a
                href="{{ route('settings') }}"
                @click="if(isMobile()) closeMobileMenu()"
                title="Pengaturan"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs('settings') ? 'text-primary bg-primary/10 font-semibold' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }}"
            >
                <span class="material-symbols-outlined text-[22px] shrink-0 {{ request()->routeIs('settings') ? '[font-variation-settings:\'FILL\'_1]' : '' }}">settings</span>
                <span x-show="sidebarOpen || mobileMenuOpen" class="text-[14px] whitespace-nowrap overflow-hidden">Pengaturan</span>
            </a>

            <!-- Keluar -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button
                    type="submit"
                    title="Keluar"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-[#e5e2e1]/50 hover:text-tertiary-container hover:bg-tertiary-container/10 transition-all duration-200 text-left cursor-pointer"
                >
                    <span class="material-symbols-outlined text-[22px] shrink-0">logout</span>
                    <span x-show="sidebarOpen || mobileMenuOpen" class="text-[14px] whitespace-nowrap overflow-hidden">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <div x-show="onboardingActive" x-cloak style="display:none" class="fixed inset-0 z-[1000] pointer-events-none">
        <div class="absolute inset-0 bg-slate-950/70 backdrop-blur-sm transition-all duration-500 ease-out" x-show="onboardingActive" x-transition:enter="opacity-100" x-transition:leave="opacity-0"></div>
        <div class="absolute rounded-3xl border-2 border-primary/90 shadow-[0_0_0_20px_rgba(99,102,241,0.08)] pointer-events-none transition-all duration-300" :class="{ 'onboarding-highlight': onboardingPulse }" :style="onboardingStyle"></div>
        <div class="relative flex items-center justify-center min-h-screen p-4 pointer-events-auto">
            <div class="w-full max-w-md rounded-3xl bg-surface-container-low border border-white/10 p-6 shadow-2xl transform transition-all duration-500 ease-out scale-95 opacity-0 onboarding-modal" x-show="onboardingActive" x-transition:enter="scale-100 opacity-100" x-transition:leave="scale-95 opacity-0">
                <div class="flex items-start gap-3 mb-4">
                    <span class="material-symbols-outlined text-[28px] text-primary onboarding-icon">lightbulb</span>
                    <div>
                        <h3 class="text-lg font-semibold text-on-surface">Panduan Kategori</h3>
                        <p class="text-sm text-on-surface-variant mt-1">Selamat datang! Klik menu Kategori untuk mulai membuat label transaksi. Dengan kategori, semua pengeluaran dan pemasukan akan lebih mudah dipantau.</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="button" @click="navigateToCategoryTour()" class="flex-1 px-5 py-3 bg-primary text-on-primary rounded-xl font-semibold transition-all duration-200 hover:bg-primary/90 hover:scale-105 active:scale-95 shadow-lg shadow-primary/20">Lanjutkan Tour</button>
                    <button type="button" @click="skipOnboarding()" class="flex-1 px-5 py-3 border border-white/10 rounded-xl text-on-surface font-semibold transition-all duration-200 hover:bg-white/5 hover:scale-105 active:scale-95">Lewati</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== TopNavBar ===== -->
    <header
        :class="{
            'left-60': !isMobile() && sidebarOpen,
            'left-[72px]': !isMobile() && !sidebarOpen,
            'left-0': isMobile(),
        }"
        class="fixed top-0 right-0 h-16 bg-[#353534]/40 backdrop-blur-md border-b border-white/5 flex justify-between items-center px-4 md:px-8 z-40 shadow-lg shadow-black/20 font-['Inter'] transition-[left] duration-300"
    >
        <!-- Mobile hamburger + Search -->
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <!-- Hamburger (mobile only) -->
            <button
                @click="toggleSidebar()"
                class="lg:hidden w-9 h-9 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors shrink-0"
            >
                <span class="material-symbols-outlined text-[20px] text-on-surface-variant">menu</span>
            </button>

            <!-- Search bar — hidden on small phones, visible tablet+ -->
            <div
                x-data="{
                    query: @js((string) request('q', '')),
                    open: false,
                    loading: false,
                    results: { transactions: [], reports: [] },
                    activeIndex: -1,
                    debounceId: null,
                    get flattenedResults() {
                        return [
                            ...(this.results.transactions ?? []).map(item => ({ ...item, kind: 'transaction' })),
                            ...(this.results.reports ?? []).map(item => ({ ...item, kind: 'report' })),
                        ];
                    },
                    resetActive() {
                        this.activeIndex = this.flattenedResults.length ? 0 : -1;
                    },
                    moveSelection(step) {
                        if (!this.flattenedResults.length) return;
                        if (this.activeIndex === -1) {
                            this.activeIndex = 0;
                            return;
                        }
                        const total = this.flattenedResults.length;
                        this.activeIndex = (this.activeIndex + step + total) % total;
                    },
                    goToActive() {
                        const item = this.flattenedResults[this.activeIndex];
                        if (item?.url) {
                            window.location.href = item.url;
                            return;
                        }
                        this.$refs.searchForm?.requestSubmit();
                    },
                    async fetchResults() {
                        const q = this.query.trim();
                        if (this.debounceId) clearTimeout(this.debounceId);
                        if (q.length < 2) {
                            this.results = { transactions: [], reports: [] };
                            this.open = false;
                            this.loading = false;
                            this.activeIndex = -1;
                            return;
                        }
                        this.loading = true;
                        this.debounceId = setTimeout(async () => {
                            try {
                                const response = await fetch(`{{ route('search.suggest') }}?q=${encodeURIComponent(q)}`, {
                                    headers: { Accept: 'application/json' }
                                });
                                const data = await response.json();
                                this.results = data;
                                this.open = (data.transactions?.length ?? 0) > 0 || (data.reports?.length ?? 0) > 0;
                                this.resetActive();
                            } catch (error) {
                                this.results = { transactions: [], reports: [] };
                                this.open = false;
                                this.activeIndex = -1;
                            } finally {
                                this.loading = false;
                            }
                        }, 220);
                    }
                }"
                @click.outside="open = false"
                @keydown.escape.window="open = false"
                class="hidden sm:block relative w-full max-w-xs lg:max-w-md"
            >
                <form
                    x-ref="searchForm"
                    action="{{ route('search') }}"
                    method="GET"
                    @keydown.arrow-down.prevent="moveSelection(1); open = true"
                    @keydown.arrow-up.prevent="moveSelection(-1); open = true"
                    @keydown.enter.prevent="if (open && flattenedResults.length) { goToActive() } else { $refs.searchForm.requestSubmit() }"
                    class="flex items-center gap-4 bg-surface-container-lowest/50 px-4 py-2 rounded-full border border-white/5 focus-within:ring-1 focus-within:ring-[#adc6ff]/50 transition-all w-full"
                >
                    <span class="material-symbols-outlined text-on-surface-variant text-xl shrink-0">search</span>
                    <input
                        class="bg-transparent border-none focus:ring-0 text-sm w-full text-on-surface placeholder:text-on-surface-variant/50 outline-none"
                        name="q"
                        x-model="query"
                        @focus="if ((results.transactions?.length ?? 0) || (results.reports?.length ?? 0)) open = true"
                        @input="fetchResults()"
                        placeholder="Cari transaksi atau laporan..."
                        type="text"
                    />
                </form>

                <div
                    x-show="open || loading"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute top-full left-0 right-0 mt-3 rounded-3xl border border-white/10 bg-surface-container-low shadow-2xl shadow-black/40 overflow-hidden z-50"
                    style="display: none;"
                >
                    <div x-show="loading" class="px-5 py-4 text-sm text-on-surface-variant/70">
                        Mencari...
                    </div>

                    <template x-if="!loading">
                        <div>
                            <template x-if="results.transactions.length">
                                <div class="border-b border-white/5">
                                    <div class="px-5 pt-4 pb-2 text-[10px] uppercase tracking-[0.12em] text-on-surface-variant/55">Transaksi</div>
                                    <template x-for="(item, index) in results.transactions" :key="`${item.url}-${item.description}-${item.date}`">
                                        <a
                                            :href="item.url"
                                            class="block px-5 py-3 hover:bg-white/5 transition-colors"
                                            :class="activeIndex === index ? 'bg-white/5' : ''"
                                            @mouseenter="activeIndex = index"
                                        >
                                            <div class="flex items-center justify-between gap-3">
                                                <div class="min-w-0">
                                                    <p class="text-sm font-medium text-on-surface truncate" x-text="item.description"></p>
                                                    <p class="text-[11px] text-on-surface-variant/60 mt-1 truncate">
                                                        <span x-text="`${item.category} • ${item.wallet} • ${item.date}`"></span>
                                                    </p>
                                                </div>
                                                <p class="text-xs font-semibold shrink-0" :class="item.type === 'income' ? 'text-secondary' : 'text-tertiary-container'" x-text="`${item.type === 'income' ? '+' : '-'} Rp ${item.amount}`"></p>
                                            </div>
                                        </a>
                                    </template>
                                </div>
                            </template>

                            <template x-if="results.reports.length">
                                <div class="px-5 py-3">
                                    <div class="pb-2 text-[10px] uppercase tracking-[0.12em] text-on-surface-variant/55">Laporan</div>
                                    <div class="space-y-2">
                                        <template x-for="(item, index) in results.reports" :key="item.url">
                                            <a
                                                :href="item.url"
                                                class="block rounded-2xl bg-white/[0.03] px-4 py-3 hover:bg-white/[0.05] transition-colors"
                                                :class="activeIndex === (results.transactions.length + index) ? 'bg-white/[0.07] ring-1 ring-white/10' : ''"
                                                @mouseenter="activeIndex = results.transactions.length + index"
                                            >
                                                <p class="text-sm font-medium text-on-surface" x-text="item.label"></p>
                                                <p class="text-[11px] text-on-surface-variant/60 mt-1">Buka laporan bulanan</p>
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3 md:gap-6 shrink-0">
            <!-- Notification Bell with Dropdown -->
            <div class="relative" x-data="{ notifOpen: false }" @click.outside="notifOpen = false">
                <button
                    @click="notifOpen = !notifOpen"
                    class="relative text-[#e5e2e1]/80 hover:text-white transition-colors p-1 rounded-lg hover:bg-white/5"
                >
                    <span class="material-symbols-outlined text-[24px]" :style="notifOpen ? 'font-variation-settings: \'FILL\' 1;' : ''">notifications</span>
                    @if($notifCount > 0)
                    <span class="notif-badge absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-tertiary-container text-on-tertiary-container text-[10px] font-bold rounded-full flex items-center justify-center px-1 border-2 border-surface-container-low">
                        {{ $notifCount > 9 ? '9+' : $notifCount }}
                    </span>
                    @endif
                </button>

                <!-- Dropdown Panel — responsive width -->
                <div
                    x-show="notifOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                    class="absolute right-0 top-full mt-3 w-[calc(100vw-2rem)] sm:w-96 bg-surface-container-low border border-white/10 rounded-2xl shadow-2xl shadow-black/50 overflow-hidden z-50"
                    style="display:none"
                >
                    <!-- Header -->
                    <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-semibold text-on-surface">Notifikasi</h3>
                            <p class="text-[11px] text-on-surface-variant/60 mt-0.5">Ringkasan keuangan Anda</p>
                        </div>
                        @if($notifCount > 0)
                        <span class="text-[11px] bg-tertiary-container/20 text-tertiary-container px-2.5 py-1 rounded-full font-semibold">
                            {{ $notifCount }} peringatan
                        </span>
                        @endif
                    </div>

                    <!-- Notification Items -->
                    <div class="max-h-80 overflow-y-auto divide-y divide-white/5">
                        @foreach($notifications as $notif)
                        @php
                            $colors = [
                                'danger'  => ['bg' => 'bg-red-500/10',    'icon' => 'text-red-400',    'border' => 'border-l-red-500'],
                                'warning' => ['bg' => 'bg-amber-500/10',  'icon' => 'text-amber-400',  'border' => 'border-l-amber-500'],
                                'success' => ['bg' => 'bg-emerald-500/10','icon' => 'text-emerald-400','border' => 'border-l-emerald-500'],
                                'info'    => ['bg' => 'bg-blue-500/10',   'icon' => 'text-blue-400',   'border' => 'border-l-blue-500'],
                            ];
                            $c = $colors[$notif['type']] ?? $colors['info'];
                        @endphp
                        <div class="px-5 py-4 hover:bg-white/5 transition-colors flex gap-3 border-l-4 {{ $c['border'] }}">
                            <div class="w-9 h-9 rounded-xl {{ $c['bg'] }} flex items-center justify-center shrink-0 mt-0.5">
                                <span class="material-symbols-outlined text-[18px] {{ $c['icon'] }}" style="font-variation-settings: 'FILL' 1;">{{ $notif['icon'] }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[13px] font-semibold text-on-surface leading-tight">{{ $notif['title'] }}</p>
                                <p class="text-[12px] text-on-surface-variant/70 leading-relaxed mt-0.5">{{ $notif['message'] }}
                                    @if(($notif['setting'] ?? null) === null && $notif['type'] === 'success')
                                        <a href="{{ route('settings') }}" class="text-primary underline ml-1">Pengaturan →</a>
                                    @endif
                                </p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <p class="text-[10px] text-on-surface-variant/40 uppercase tracking-wide">{{ $notif['time'] }}</p>
                                    @if($notif['setting'] ?? null)
                                    <a href="{{ route('settings') }}" class="text-[10px] text-on-surface-variant/30 hover:text-primary/70 flex items-center gap-0.5 transition-colors" title="Ubah di Pengaturan">
                                        <span class="material-symbols-outlined text-[12px]">tune</span>
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Footer -->
                    <div class="px-5 py-3 border-t border-white/5 bg-surface-container-high/30 flex items-center justify-between gap-3">
                        <a href="{{ route('reports') }}" class="text-[12px] text-primary font-semibold hover:underline flex items-center gap-1.5 shrink-0">
                            <span class="material-symbols-outlined text-[16px]">assessment</span>
                            Lihat laporan
                        </a>
                        @if(!$notifIsRead)
                        <button
                            @click="
                                fetch('{{ route('notifications.mark-read') }}', {
                                    method: 'POST',
                                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                                }).then(() => {
                                    notifOpen = false;
                                    $el.closest('[x-data]').querySelectorAll('.notif-badge').forEach(el => el.remove());
                                });
                            "
                            class="text-[12px] text-on-surface-variant/60 hover:text-on-surface transition-colors flex items-center gap-1.5 shrink-0"
                        >
                            <span class="material-symbols-outlined text-[16px]">done_all</span>
                            Tandai sudah dibaca
                        </button>
                        @else
                        <span class="text-[12px] text-emerald-400/70 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[16px]" style="font-variation-settings:'FILL' 1">check_circle</span>
                            Sudah dibaca
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- User Profile — hide email on mobile -->
            <div class="flex items-center gap-2 md:gap-3 pl-3 md:pl-6 border-l border-white/10">
                <div class="text-right hidden md:block">
                    <p class="text-xs font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">{{ Auth::user()->email ?? 'guest@example.com' }}</p>
                </div>
                <img alt="User Profile Avatar" class="w-8 h-8 rounded-full object-cover ring-1 ring-primary/20" src="{{ Auth::user()?->avatarUrl() }}" />
            </div>
        </div>
    </header>

    <!-- ===== Main Content ===== -->
    <main
        :class="{
            'ml-60': !isMobile() && sidebarOpen,
            'ml-[72px]': !isMobile() && !sidebarOpen,
            'ml-0': isMobile(),
        }"
        class="pt-20 px-4 sm:px-6 lg:px-10 pb-24 bg-surface min-h-screen transition-[margin-left] duration-300"
    >
        {{ $slot }}
    </main>

    <!-- Global FAB -->
    <button @click="isTransactionModalOpen = true" class="fixed bottom-6 right-6 w-14 h-14 bg-linear-to-br from-primary to-primary-container text-on-primary rounded-full shadow-2xl shadow-primary/40 flex items-center justify-center group active:scale-95 transition-all hover:opacity-90 z-40">
        <span class="material-symbols-outlined text-3xl transition-transform group-hover:rotate-90" data-icon="add">add</span>
    </button>

    <x-transaction-modal />
</body>

</html>
