<!DOCTYPE html>
<html class="dark" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>{{ $title ?? 'My Finance' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-surface text-on-surface font-body min-h-screen selection:bg-primary/30 relative">
    <!-- Top Navigation Bar (Focus Mode) -->
    <nav class="fixed top-0 w-full z-50 bg-[#131313]/40 backdrop-blur-xl border-b border-white/5 shadow-2xl shadow-black/40 flex justify-between items-center px-8 h-16">
        <div class="flex items-center gap-4">
            <a href="{{ $backUrl ?? url()->previous() }}" class="flex items-center justify-center w-10 h-10 rounded-full hover:bg-white/5 transition-all active:scale-95 text-on-surface">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <span class="text-xl font-bold tracking-tighter text-[#e5e2e1] hidden sm:block">My Finance</span>
        </div>
        <div class="flex items-center gap-6">
            <button class="relative text-[#e5e2e1]/80 hover:text-white transition-colors">
                <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                <span class="absolute top-0 right-0 w-2 h-2 bg-tertiary-container rounded-full border-2 border-surface-container-low hidden"></span>
            </button>
            <div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center overflow-hidden ring-1 ring-primary/20">
                <img alt="User profile avatar" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBZHjWC50aPjFa95O-fkHF69vzKeqsxBHVke7wV5LxAxggZXvdRu5GRyqOXp0xbinbQYI13d8MuI2AR2QGizpQHYgNKi0LE9EO1hY-JKdSiKm9iT3p4xXhj2MvOVG39hZp7CL11IoG4iSMXfYqozHmdeI59sbykYm1FdKmMmRwFsWOAxt0CaTORmei53cghv0rhwiCYUXex5nFFH2l7QeBtChDXHX-gwyazE9P8FswfWJlLLHqx6Bl9uSBl69qmUIBQmaptB6XSaoY" />
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    {{ $slot }}
    
    <!-- Background Subtle Glows Global -->
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[120px] -z-10 pointer-events-none"></div>
    <div class="fixed bottom-[-10%] right-[-10%] w-[30%] h-[30%] bg-secondary/10 rounded-full blur-[100px] -z-10 pointer-events-none"></div>
</body>

</html>
