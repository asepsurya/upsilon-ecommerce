@if ($paginator->hasPages())
    <div class="flex items-center space-x-1">
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <button disabled aria-label="Previous Page" class="w-8 h-8 flex items-center justify-center rounded border border-neutral-300 text-neutral-400 cursor-not-allowed" type="button">
                <i class="ph ph-caret-left"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous Page" class="w-8 h-8 flex items-center justify-center rounded border border-neutral-300 text-neutral-700 hover:bg-neutral-50 transition-colors" type="button">
                <i class="ph ph-caret-left"></i>
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="w-8 h-8 flex items-center justify-center text-neutral-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="w-8 h-8 flex items-center justify-center rounded bg-black text-white font-bold" type="button">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded border border-neutral-300 text-neutral-700 hover:bg-neutral-50 transition-colors" type="button">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" aria-label="Next Page" class="w-8 h-8 flex items-center justify-center rounded border border-neutral-300 text-neutral-700 hover:bg-neutral-50 transition-colors" type="button">
                <i class="ph ph-caret-right"></i>
            </a>
        @else
            <button disabled aria-label="Next Page" class="w-8 h-8 flex items-center justify-center rounded border border-neutral-300 text-neutral-400 cursor-not-allowed" type="button">
                <i class="ph ph-caret-right"></i>
            </button>
        @endif
    </div>
@endif
