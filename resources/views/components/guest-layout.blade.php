@props(['title' => 'My Finance'])
<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'My Finance' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-background text-on-surface font-body antialiased selection:bg-primary/30"
    x-data="{
        heroSlide: 0,
        heroInterval: null,
        init() {
            this.heroInterval = setInterval(() => {
                this.heroSlide = (this.heroSlide + 1) % 3;
            }, 4500);
        }
    }"
>
    <main class="min-h-screen flex flex-col md:flex-row overflow-hidden">
        <!-- Left Side: Visual Anchor -->
        <section
            class="relative hidden md:flex md:w-1/2 lg:w-3/5 items-center justify-center p-12 lg:p-24 overflow-hidden">
            <!-- Rotating Finance Visual -->
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(173,198,255,0.22),_transparent_40%),radial-gradient(circle_at_bottom_right,_rgba(78,222,163,0.16),_transparent_32%),linear-gradient(160deg,_#0d1320_0%,_#101827_44%,_#0a0f19_100%)]"></div>
                <div class="absolute -top-20 -left-20 w-72 h-72 rounded-full bg-primary/12 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-96 h-96 rounded-full bg-secondary/10 blur-3xl"></div>
                <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:44px_44px] opacity-25"></div>

                <div class="absolute inset-0 transition-opacity duration-700" x-show="heroSlide === 0" x-transition.opacity>
                    <div class="absolute top-20 left-16 w-64 rounded-[2rem] border border-white/10 bg-slate-950/55 p-5 shadow-2xl shadow-black/35 backdrop-blur-xl rotate-[-8deg]">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] uppercase tracking-[0.18em] text-on-surface-variant/60">Arus Kas</span>
                            <span class="material-symbols-outlined text-primary" style="font-variation-settings:'FILL' 1">trending_up</span>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-end gap-2 h-32">
                                <div class="w-8 rounded-t-xl bg-primary/45" style="height: 42%"></div>
                                <div class="w-8 rounded-t-xl bg-primary/60" style="height: 58%"></div>
                                <div class="w-8 rounded-t-xl bg-secondary/70" style="height: 76%"></div>
                                <div class="w-8 rounded-t-xl bg-primary" style="height: 92%"></div>
                                <div class="w-8 rounded-t-xl bg-tertiary-container/80" style="height: 63%"></div>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-on-surface-variant/70">Saldo bulan ini</span>
                                <span class="font-semibold text-secondary">+18.4%</span>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-24 right-20 w-72 rounded-[2rem] border border-white/10 bg-white/6 p-5 shadow-2xl shadow-black/35 backdrop-blur-xl">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-11 h-11 rounded-2xl bg-primary/15 flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">savings</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-on-surface">Dana Darurat</p>
                                <p class="text-xs text-on-surface-variant/65">Target 12 bulan pengeluaran</p>
                            </div>
                        </div>
                        <div class="w-full h-3 rounded-full bg-white/8 overflow-hidden">
                            <div class="h-full w-[74%] rounded-full bg-gradient-to-r from-primary via-secondary to-secondary"></div>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-xs">
                            <span class="text-on-surface-variant/65">Terkumpul Rp 18,5 jt</span>
                            <span class="text-on-surface font-semibold">74%</span>
                        </div>
                    </div>
                </div>

                <div class="absolute inset-0 transition-opacity duration-700" x-show="heroSlide === 1" x-transition.opacity>
                    <div class="absolute top-24 right-20 w-80 rounded-[2rem] border border-white/10 bg-slate-950/55 p-6 shadow-2xl shadow-black/35 backdrop-blur-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.18em] text-on-surface-variant/60">Dompet & Kartu</p>
                                <p class="mt-2 text-2xl font-semibold text-on-surface">Rp 48.750.000</p>
                            </div>
                            <span class="material-symbols-outlined text-secondary" style="font-variation-settings:'FILL' 1">account_balance_wallet</span>
                        </div>
                        <div class="mt-6 grid grid-cols-2 gap-3">
                            <div class="rounded-2xl bg-white/6 p-4">
                                <p class="text-xs text-on-surface-variant/65">Kas</p>
                                <p class="mt-2 font-semibold">Rp 6,2 jt</p>
                            </div>
                            <div class="rounded-2xl bg-white/6 p-4">
                                <p class="text-xs text-on-surface-variant/65">Bank</p>
                                <p class="mt-2 font-semibold">Rp 32,1 jt</p>
                            </div>
                            <div class="rounded-2xl bg-white/6 p-4">
                                <p class="text-xs text-on-surface-variant/65">E-Wallet</p>
                                <p class="mt-2 font-semibold">Rp 3,4 jt</p>
                            </div>
                            <div class="rounded-2xl bg-white/6 p-4">
                                <p class="text-xs text-on-surface-variant/65">Investasi</p>
                                <p class="mt-2 font-semibold">Rp 7,0 jt</p>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-20 left-14 w-72 rounded-[2rem] border border-primary/20 bg-primary/10 p-5 shadow-2xl shadow-primary/10 backdrop-blur-xl rotate-[7deg]">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-sm font-semibold">Anggaran Bulanan</span>
                            <span class="text-xs text-secondary font-semibold">Aman</span>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <div class="mb-1 flex items-center justify-between text-[11px] text-on-surface-variant/70">
                                    <span>Makan & Harian</span>
                                    <span>62%</span>
                                </div>
                                <div class="h-2 rounded-full bg-white/8 overflow-hidden"><div class="h-full w-[62%] rounded-full bg-secondary"></div></div>
                            </div>
                            <div>
                                <div class="mb-1 flex items-center justify-between text-[11px] text-on-surface-variant/70">
                                    <span>Transportasi</span>
                                    <span>48%</span>
                                </div>
                                <div class="h-2 rounded-full bg-white/8 overflow-hidden"><div class="h-full w-[48%] rounded-full bg-primary"></div></div>
                            </div>
                            <div>
                                <div class="mb-1 flex items-center justify-between text-[11px] text-on-surface-variant/70">
                                    <span>Tagihan</span>
                                    <span>81%</span>
                                </div>
                                <div class="h-2 rounded-full bg-white/8 overflow-hidden"><div class="h-full w-[81%] rounded-full bg-tertiary-container"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute inset-0 transition-opacity duration-700" x-show="heroSlide === 2" x-transition.opacity>
                    <div class="absolute top-20 left-16 right-16 h-72 rounded-[2.5rem] border border-white/10 bg-slate-950/45 p-8 shadow-2xl shadow-black/35 backdrop-blur-xl">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <p class="text-[11px] uppercase tracking-[0.18em] text-on-surface-variant/60">Investasi & Tujuan</p>
                                <p class="mt-2 text-3xl font-semibold">Portofolio tumbuh stabil</p>
                            </div>
                            <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings:'FILL' 1">monitoring</span>
                        </div>
                        <div class="grid grid-cols-[1.2fr_0.8fr] gap-6 h-[160px]">
                            <div class="rounded-[2rem] bg-white/6 p-5 flex items-end gap-3">
                                <div class="flex-1 h-16 rounded-t-3xl bg-primary/35"></div>
                                <div class="flex-1 h-24 rounded-t-3xl bg-primary/55"></div>
                                <div class="flex-1 h-20 rounded-t-3xl bg-secondary/70"></div>
                                <div class="flex-1 h-32 rounded-t-3xl bg-primary"></div>
                                <div class="flex-1 h-28 rounded-t-3xl bg-secondary"></div>
                            </div>
                            <div class="rounded-[2rem] bg-white/6 p-5 flex flex-col justify-between">
                                <div>
                                    <p class="text-xs text-on-surface-variant/65">Imbal hasil tahunan</p>
                                    <p class="mt-2 text-2xl font-semibold text-secondary">+12.8%</p>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-on-surface-variant/70">
                                    <span class="w-2.5 h-2.5 rounded-full bg-secondary"></span>
                                    Diversifikasi sehat
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="absolute bottom-16 right-20 rounded-[2rem] border border-white/10 bg-white/6 px-6 py-4 backdrop-blur-xl shadow-xl shadow-black/30">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-secondary/15 flex items-center justify-center">
                                <span class="material-symbols-outlined text-secondary">target</span>
                            </div>
                            <div>
                                <p class="text-sm font-semibold">Target Rumah Pertama</p>
                                <p class="text-xs text-on-surface-variant/65">Progres tabungan 68% dari target</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="absolute inset-0 bg-gradient-to-tr from-surface-container-lowest via-transparent to-transparent opacity-80"></div>
                <div class="absolute inset-0 bg-surface-container-lowest/20 backdrop-blur-[2px]"></div>
            </div>
            <!-- Content -->
            <div class="relative z-10 w-full max-w-2xl">
                <div class="mb-12">
                    <div class="flex items-center gap-3 mb-8">
                        <div
                            class="w-12 h-12 rounded-xl bg-gradient-to-br from-primary to-primary-container flex items-center justify-center shadow-lg shadow-primary/20">
                            <span class="material-symbols-outlined text-on-primary text-3xl"
                                data-icon="account_balance_wallet">account_balance_wallet</span>
                        </div>
                        <span class="text-2xl font-bold tracking-tight text-on-surface">My Finance</span>
                    </div>
                    <h1
                        class="font-headline font-semibold text-on-surface leading-[1.1] tracking-tight text-[3.5rem] mb-6">
                        Finansial Lebih <br />
                        <span class="text-primary">Terarah Setiap Hari.</span>
                    </h1>
                    <p class="text-on-surface-variant text-lg max-w-md leading-relaxed">
                        Pantau saldo, anggaran, tabungan, dan tujuan keuangan dalam satu dashboard yang terasa relevan sejak halaman pertama.
                    </p>
                </div>
                <div class="mb-8 flex items-center gap-3">
                    <button type="button" @click="heroSlide = 0" :class="heroSlide === 0 ? 'bg-primary w-10' : 'bg-white/15 w-3'" class="h-3 rounded-full transition-all duration-300"></button>
                    <button type="button" @click="heroSlide = 1" :class="heroSlide === 1 ? 'bg-primary w-10' : 'bg-white/15 w-3'" class="h-3 rounded-full transition-all duration-300"></button>
                    <button type="button" @click="heroSlide = 2" :class="heroSlide === 2 ? 'bg-primary w-10' : 'bg-white/15 w-3'" class="h-3 rounded-full transition-all duration-300"></button>
                    <div class="ml-3 rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[11px] uppercase tracking-[0.14em] text-on-surface-variant/70">
                        Visual finansial dinamis
                    </div>
                </div>
                @php
                    $platformStats = [
                        ['icon' => 'shield_lock', 'label' => 'Privasi Data', 'value' => 'Fokus pada data milik Anda'],
                        ['icon' => 'insights', 'label' => 'Ringkasan Cepat', 'value' => 'Arus kas dan anggaran mudah dipantau'],
                        ['icon' => 'task_alt', 'label' => 'Pencatatan Rapi', 'value' => 'Dompet, kategori, dan laporan dalam satu alur'],
                    ];
                @endphp
                <div class="grid grid-cols-3 gap-3 max-w-sm">
                    @foreach($platformStats as $stat)
                    <div class="obsidian-glass rounded-xl p-4 flex flex-col gap-2">
                        <span class="material-symbols-outlined text-[18px] text-primary opacity-70" style="font-variation-settings:'FILL' 1">{{ $stat['icon'] }}</span>
                        <span class="text-sm font-semibold text-on-surface leading-snug">{{ $stat['value'] }}</span>
                        <span class="text-[9px] uppercase tracking-[0.08em] text-on-surface-variant/60 leading-tight">{{ $stat['label'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            <!-- Branding Subtle Footer -->
            <div class="absolute bottom-12 left-12 lg:left-24">
                <span class="text-[11px] uppercase tracking-[0.2em] text-on-surface-variant/40">© {{ date('Y') }} My Finance</span>
            </div>
        </section>

        <!-- Right Side: Dynamic Content -->
        <section
            class="flex-1 flex items-center justify-center p-6 sm:p-12 lg:p-24 bg-surface md:bg-surface-container-low relative">
            <div class="w-full max-w-[420px]">
                <!-- Mobile Logo (Visible only on small screens) -->
                <div class="md:hidden flex items-center gap-3 mb-12">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary to-primary-container flex items-center justify-center">
                        <span class="material-symbols-outlined text-on-primary text-2xl"
                            data-icon="account_balance_wallet">account_balance_wallet</span>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-on-surface">My Finance</span>
                </div>

                <!-- Main Slot Content -->
                {{ $slot }}

                <!-- Legal/Help Subtle Links -->
                <div
                    class="mt-24 md:absolute md:bottom-12 md:left-1/2 md:-translate-x-1/2 flex items-center gap-6 justify-center w-full">
                    <a class="text-[10px] uppercase tracking-[0.1em] text-on-surface-variant/50 hover:text-on-surface transition-colors"
                        href="{{ route('help') }}">Bantuan</a>
                    <div class="w-1 h-1 rounded-full bg-outline-variant/30"></div>
                    <a class="text-[10px] uppercase tracking-[0.1em] text-on-surface-variant/50 hover:text-on-surface transition-colors"
                        href="{{ route('privacy') }}">Privasi</a>
                    <div class="w-1 h-1 rounded-full bg-outline-variant/30"></div>
                    <a class="text-[10px] uppercase tracking-[0.1em] text-on-surface-variant/50 hover:text-on-surface transition-colors"
                        href="{{ route('security') }}">Keamanan</a>
                </div>
            </div>
        </section>
    </main>
</body>

</html>
