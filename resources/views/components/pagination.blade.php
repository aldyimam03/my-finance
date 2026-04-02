@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center gap-2">
        @if ($paginator->onFirstPage())
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-surface-container-highest text-on-surface-variant/30">
                <span class="material-symbols-outlined text-base">chevron_left</span>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-surface-container-highest text-on-surface-variant transition-colors hover:bg-white/5 hover:text-on-surface">
                <span class="material-symbols-outlined text-base">chevron_left</span>
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 text-sm text-on-surface-variant/50">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span aria-current="page" class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-primary/20 bg-primary px-3 text-sm font-semibold text-on-primary">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="inline-flex h-10 min-w-10 items-center justify-center rounded-lg border border-white/10 bg-surface-container-highest px-3 text-sm font-semibold text-on-surface-variant transition-colors hover:bg-white/5 hover:text-on-surface">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-surface-container-highest text-on-surface-variant transition-colors hover:bg-white/5 hover:text-on-surface">
                <span class="material-symbols-outlined text-base">chevron_right</span>
            </a>
        @else
            <span class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-surface-container-highest text-on-surface-variant/30">
                <span class="material-symbols-outlined text-base">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
