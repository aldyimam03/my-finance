@props(['title' => 'My Finance', 'stats' => []])
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

<body class="bg-background text-on-surface font-body antialiased selection:bg-primary/30">
    <main class="min-h-screen flex flex-col md:flex-row overflow-hidden">
        <!-- Left Side: Visual Anchor -->
        <section
            class="relative hidden md:flex md:w-1/2 lg:w-3/5 items-center justify-center p-12 lg:p-24 overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <img alt="Dark obsidian textures with glass reflections" class="w-full h-full object-cover"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCueAow910rrdi3aHEySryMm6yJUuNtDzV8ziQvjUZsp0PizZmp6bjt370X4Jl0hR6UlUBibg_SRoi6N13oFLfdnZkHRQ5G5yvwmFowhlE_TgRIgQN0MI70H-cbLIDsRqclm40seK_ez_i7VrF2KM4ZY0zok4HwtRAhtRMubXHKRtZZ2NnrUmURdc_9OGf3PxH2uQbXnmpV1hPgdSAY9RCk4Ya-IGb_IBbGVhPmXNupNEV4CIiiBgo88pf65jNA8d1HVxtITGVRcY" />
                <div
                    class="absolute inset-0 bg-gradient-to-tr from-surface-container-lowest via-transparent to-transparent opacity-80">
                </div>
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
                        Masa Depan <br />
                        <span class="text-primary">Kekayaan Pribadi.</span>
                    </h1>
                    <p class="text-on-surface-variant text-lg max-w-md leading-relaxed">
                        Kelola aset Anda dengan My Finance. Keamanan dompet pribadi dalam genggaman Anda.
                    </p>
                </div>
                <!-- Subtle Data Point Visualization (Signature Component) -->
                @php
                    $s = array_merge([
                        'users' => 0,
                        'transactions' => 0,
                        'totalAssets' => 0,
                    ], $stats ?? []);

                    // Format angka ringkas
                    $fmtNum = fn($n) => $n >= 1_000_000 ? number_format($n/1_000_000, 1, ',', '.').'M'
                                      : ($n >= 1_000 ? number_format($n/1_000, 1, ',', '.').'K'
                                      : $n);
                    $fmtRp  = fn($n) => $n >= 1_000_000_000 ? 'Rp '.number_format($n/1_000_000_000, 1, ',', '.').'B'
                                      : ($n >= 1_000_000 ? 'Rp '.number_format($n/1_000_000, 1, ',', '.').'M'
                                      : 'Rp '.number_format($n/1_000, 0, ',', '.').'K');

                    $platformStats = [
                        ['icon' => 'group',              'label' => 'Pengguna Aktif',       'value' => $fmtNum($s['users'])],
                        ['icon' => 'receipt_long',       'label' => 'Transaksi Tercatat',   'value' => $fmtNum($s['transactions'])],
                        ['icon' => 'account_balance',    'label' => 'Total Aset Dikelola',  'value' => $fmtRp($s['totalAssets'])],
                    ];
                @endphp
                <div class="grid grid-cols-3 gap-3 max-w-sm">
                    @foreach($platformStats as $stat)
                    <div class="obsidian-glass rounded-xl p-4 flex flex-col gap-2">
                        <span class="material-symbols-outlined text-[18px] text-primary opacity-70" style="font-variation-settings:'FILL' 1">{{ $stat['icon'] }}</span>
                        <span class="text-lg font-bold text-on-surface leading-tight">{{ $stat['value'] }}</span>
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
