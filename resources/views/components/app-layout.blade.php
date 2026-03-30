<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'Dashboard - My Finance' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-surface text-on-surface font-body selection:bg-primary/30"
    x-data="{
        isTransactionModalOpen: false,
        sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
        toggleSidebar() {
            this.sidebarOpen = !this.sidebarOpen;
            localStorage.setItem('sidebarOpen', this.sidebarOpen);
        }
    }"
    @keydown.escape="isTransactionModalOpen = false"
    :class="isTransactionModalOpen ? 'overflow-hidden' : ''"
>
    <!-- SideNavBar Shell -->
    <aside
        :class="sidebarOpen ? 'w-60' : 'w-[72px]'"
        class="h-screen fixed left-0 top-0 border-r border-white/5 bg-surface-container-low flex flex-col py-6 z-50 shadow-2xl shadow-black/40 font-['Inter'] antialiased tracking-tight transition-[width] duration-300 overflow-hidden"
    >
        <!-- Logo & Toggle -->
        <div class="flex items-center gap-3 mb-8 px-4 shrink-0">
            <button
                @click="toggleSidebar()"
                class="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-colors shrink-0"
                :title="sidebarOpen ? 'Tutup Sidebar' : 'Buka Sidebar'"
            >
                <span class="material-symbols-outlined text-[20px] text-on-surface-variant transition-transform duration-300" :class="sidebarOpen ? 'rotate-0' : 'rotate-180'">menu_open</span>
            </button>
            <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-100" x-transition:enter-start="opacity-0 -translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="overflow-hidden">
                <h1 class="text-[15px] font-semibold tracking-tight text-[#e5e2e1] whitespace-nowrap">My Finance</h1>
                <p class="text-[10px] uppercase tracking-[0.05em] text-on-surface-variant opacity-60 whitespace-nowrap">Obsidian Ledger</p>
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
                title="{{ $item['label'] }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative
                    {{ $active ? 'text-primary bg-primary/10 font-semibold' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }}"
            >
                <span class="material-symbols-outlined text-[22px] shrink-0 {{ $active ? '[font-variation-settings:\'FILL\'_1]' : '' }}">{{ $item['icon'] }}</span>
                <span x-show="sidebarOpen" x-transition:enter="transition ease-out duration-200 delay-75" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="text-[14px] whitespace-nowrap overflow-hidden">{{ $item['label'] }}</span>
                <!-- Active indicator -->
                @if($active)
                <span class="absolute right-0 top-1/2 -translate-y-1/2 w-1 h-6 bg-primary rounded-l-full"></span>
                @endif
            </a>
            @endforeach
        </nav>

        <!-- Bottom Actions -->
        <div class="px-2 pt-4 pb-2 space-y-0.5 border-t border-white/5 mt-2 shrink-0">
            <!-- Tambah Transaksi -->
            <button
                @click="isTransactionModalOpen = true"
                class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl bg-primary/10 hover:bg-primary/20 text-primary transition-all font-semibold group"
                title="Tambah Transaksi"
            >
                <span class="material-symbols-outlined text-[22px] shrink-0">add_circle</span>
                <span x-show="sidebarOpen" class="text-[14px] whitespace-nowrap overflow-hidden">Tambah Transaksi</span>
            </button>

            <!-- Pengaturan -->
            <a
                href="{{ route('settings') }}"
                title="Pengaturan"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
                    {{ request()->routeIs('settings') ? 'text-primary bg-primary/10 font-semibold' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }}"
            >
                <span class="material-symbols-outlined text-[22px] shrink-0 {{ request()->routeIs('settings') ? '[font-variation-settings:\'FILL\'_1]' : '' }}">settings</span>
                <span x-show="sidebarOpen" class="text-[14px] whitespace-nowrap overflow-hidden">Pengaturan</span>
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
                    <span x-show="sidebarOpen" class="text-[14px] whitespace-nowrap overflow-hidden">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- TopNavBar Shell -->
    <header
        :class="sidebarOpen ? 'left-60' : 'left-[72px]'"
        class="fixed top-0 right-0 h-16 bg-[#353534]/40 backdrop-blur-md border-b border-white/5 flex justify-between items-center px-8 z-40 shadow-lg shadow-black/20 font-['Inter'] transition-[left] duration-300"
    >
        <div class="flex items-center gap-4 bg-surface-container-lowest/50 px-4 py-2 rounded-full border border-white/5 focus-within:ring-1 focus-within:ring-[#adc6ff]/50 transition-all w-96">
            <span class="material-symbols-outlined text-on-surface-variant text-xl" data-icon="search">search</span>
            <input class="bg-transparent border-none focus:ring-0 text-sm w-full text-on-surface placeholder:text-on-surface-variant/50 outline-none" placeholder="Cari transaksi atau laporan..." type="text" />
        </div>
        <div class="flex items-center gap-6">
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

                <!-- Dropdown Panel -->
                <div
                    x-show="notifOpen"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                    x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                    class="absolute right-0 top-full mt-3 w-96 bg-surface-container-low border border-white/10 rounded-2xl shadow-2xl shadow-black/50 overflow-hidden z-50"
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

            <div class="flex items-center gap-3 pl-6 border-l border-white/10">
                <div class="text-right">
                    <p class="text-xs font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">{{ Auth::user()->email ?? 'guest@example.com' }}</p>
                </div>
                <img alt="User Profile Avatar" class="w-8 h-8 rounded-full object-cover ring-1 ring-primary/20" src="{{ Auth::user()?->avatarUrl() }}" />
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main
        :class="sidebarOpen ? 'ml-60' : 'ml-[72px]'"
        class="pt-24 px-10 pb-12 bg-surface min-h-screen transition-[margin-left] duration-300"
    >
        {{ $slot }}
    </main>

    <!-- Global FAB -->
    <button @click="isTransactionModalOpen = true" class="fixed bottom-8 right-8 w-14 h-14 bg-linear-to-br from-primary to-primary-container text-on-primary rounded-full shadow-2xl shadow-primary/40 flex items-center justify-center group active:scale-95 transition-all hover:opacity-90 z-40">
        <span class="material-symbols-outlined text-3xl transition-transform group-hover:rotate-90" data-icon="add">add</span>
    </button>

    <x-transaction-modal />
</body>

</html>
