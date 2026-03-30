<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'Dashboard - My Finance' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary/30" x-data="{ isTransactionModalOpen: false }" @keydown.escape="isTransactionModalOpen = false" :class="isTransactionModalOpen ? 'overflow-hidden' : ''">
    <!-- SideNavBar Shell -->
    <aside class="h-screen w-64 fixed left-0 top-0 border-r border-white/5 bg-surface-container-low dark:bg-surface-container-low flex flex-col py-8 px-6 z-50 shadow-2xl shadow-black/40 font-['Inter'] antialiased tracking-tight">
        <div class="mb-10 px-2">
            <h1 class="text-xl font-semibold tracking-tight text-[#e5e2e1]">My Finance</h1>
            <p class="text-[11px] uppercase tracking-[0.05em] text-on-surface-variant opacity-60">Obsidian Ledger</p>
        </div>
        <nav class="flex-1 space-y-1">
            <!-- Active: Dasbor -->
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-[#adc6ff] font-semibold border-r-2 border-[#adc6ff] bg-white/5' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }} transition-all duration-200" href="{{ route('dashboard') }}">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="text-[14px]">Dasbor</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('transactions') ? 'text-[#adc6ff] font-semibold border-r-2 border-[#adc6ff] bg-white/5' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }} transition-all duration-200" href="{{ route('transactions') }}">
                <span class="material-symbols-outlined" data-icon="receipt_long">receipt_long</span>
                <span class="text-[14px]">Transaksi</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('wallets') ? 'text-[#adc6ff] font-semibold border-r-2 border-[#adc6ff] bg-white/5' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }} transition-all duration-200" href="{{ route('wallets') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('wallets') ? '[font-variation-settings:\'FILL\'_1]' : '' }}" data-icon="account_balance_wallet">account_balance_wallet</span>
                <span class="text-[14px]">Dompet</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('budgets') ? 'text-[#adc6ff] font-semibold border-r-2 border-[#adc6ff] bg-white/5' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }} transition-all duration-200" href="{{ route('budgets') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('budgets') ? '[font-variation-settings:\'FILL\'_1]' : '' }}" data-icon="pie_chart">pie_chart</span>
                <span class="text-[14px]">Anggaran</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('categories') ? 'text-[#adc6ff] font-semibold border-r-2 border-[#adc6ff] bg-white/5' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }} transition-all duration-200" href="{{ route('categories') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('categories') ? '[font-variation-settings:\'FILL\'_1]' : '' }}">category</span>
                <span class="text-[14px]">Kategori</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('reports') ? 'text-[#adc6ff] font-semibold border-r-2 border-[#adc6ff] bg-white/5' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }} transition-all duration-200" href="{{ route('reports') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('reports') ? '[font-variation-settings:\'FILL\'_1]' : '' }}" data-icon="assessment">assessment</span>
                <span class="text-[14px]">Laporan</span>
            </a>
        </nav>
        <div class="mt-auto space-y-1">
            <button @click="isTransactionModalOpen = true" class="w-full mb-6 py-3 bg-linear-to-br from-primary to-primary-container text-on-primary font-semibold rounded-xl text-sm shadow-lg shadow-primary/20 active:scale-[0.98] transition-transform">
                Tambah Transaksi
            </button>
            <a class="flex items-center gap-3 px-4 py-2 {{ request()->routeIs('settings') ? 'text-[#adc6ff] font-semibold border-r-2 border-[#adc6ff] bg-white/5' : 'text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5' }} transition-all duration-200" href="{{ route('settings') }}">
                <span class="material-symbols-outlined {{ request()->routeIs('settings') ? '[font-variation-settings:\'FILL\'_1]' : '' }}" data-icon="settings">settings</span>
                <span class="text-[14px]">Pengaturan</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-[#e5e2e1]/60 hover:text-[#e5e2e1] hover:bg-white/5 transition-all duration-200 text-left cursor-pointer">
                    <span class="material-symbols-outlined" data-icon="logout">logout</span>
                    <span class="text-[14px]">Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- TopNavBar Shell -->
    <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-[#353534]/40 backdrop-blur-md border-b border-white/5 flex justify-between items-center px-8 z-40 shadow-lg shadow-black/20 font-['Inter'] body-md:text-[14px]">
        <div class="flex items-center gap-4 bg-surface-container-lowest/50 px-4 py-2 rounded-full border border-white/5 focus-within:ring-1 focus-within:ring-[#adc6ff]/50 transition-all w-96">
            <span class="material-symbols-outlined text-on-surface-variant text-xl" data-icon="search">search</span>
            <input class="bg-transparent border-none focus:ring-0 text-sm w-full text-on-surface placeholder:text-on-surface-variant/50 outline-none" placeholder="Cari transaksi atau laporan..." type="text" />
        </div>
        <div class="flex items-center gap-6">
            <button class="relative text-[#e5e2e1]/80 hover:text-white transition-colors">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-0 right-0 w-2 h-2 bg-tertiary-container rounded-full border-2 border-surface-container-low"></span>
            </button>
            <div class="flex items-center gap-3 pl-6 border-l border-white/10">
                <div class="text-right">
                    <p class="text-xs font-semibold">{{ Auth::user()->name ?? 'Guest' }}</p>
                    <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">{{ Auth::user()->email ?? 'guest@example.com' }}</p>
                </div>
                <img alt="User Profile Avatar" class="w-8 h-8 rounded-full object-cover ring-1 ring-primary/20" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=2C3E50&color=FFFFFF" />
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-64 pt-24 px-12 pb-12 bg-surface min-h-screen">
        {{ $slot }}
    </main>

    <!-- Global Visual Floating FAB -->
    <button @click="isTransactionModalOpen = true" class="fixed bottom-8 right-8 w-14 h-14 bg-linear-to-br from-primary to-primary-container text-on-primary rounded-full shadow-2xl shadow-primary/40 flex items-center justify-center group active:scale-95 transition-all hover:opacity-90 z-40">
        <span class="material-symbols-outlined text-3xl transition-transform group-hover:rotate-90" data-icon="add">add</span>
    </button>
    
    <x-transaction-modal />
</body>

</html>
