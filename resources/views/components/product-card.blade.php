<div class="group relative bg-surface-container flex flex-col justify-between border border-outline-variant/30 hover:border-primary/50 transition-all duration-500 shadow-md">
    <div class="relative w-full aspect-[3/4] overflow-hidden bg-surface-container-highest">
        @php
            $primaryImage = $product->images->firstWhere('is_primary', true) ?? $product->images->first();
        @endphp

        @if($primaryImage)
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                src="{{ $primaryImage->url }}" alt="{{ $product->name }}">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <span class="text-outline-variant text-xs uppercase tracking-wider">No Image</span>
            </div>
        @endif

        @if($product->badge)
            <span
                class="absolute top-3 left-3 bg-surface-container-lowest/90 backdrop-blur-md px-2.5 py-1 text-primary border border-primary/20 font-label-caps text-[10px] uppercase tracking-widest">
                {{ $product->badge }}
            </span>
        @endif

        <button aria-label="Add to wishlist"
            class="absolute top-3 right-3 w-8 h-8 rounded-full bg-surface-container-lowest/80 backdrop-blur-md flex items-center justify-center text-on-surface hover:text-primary transition-colors">
            <span class="material-symbols-outlined text-[18px]">favorite</span>
        </button>

        <div
            class="absolute inset-x-0 bottom-0 p-space-sm bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/90 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex gap-2">
            <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Buy Product: I would like to buy ' . $product->name . ' priced at $' . number_format($product->sale_price ?? $product->base_price, 2) . '. Please provide details.') }}"
                class="flex-1 py-2.5 bg-primary text-on-primary font-label-caps text-[11px] tracking-widest uppercase hover:bg-primary/90 transition-colors font-semibold text-center"
                target="_blank" rel="noopener">
                Buy Product
            </a>
        </div>
    </div>

    <div class="p-space-md flex flex-col gap-1.5">
        <div class="flex items-center justify-between text-outline text-[11px]">
            <span
                class="font-label-caps tracking-widest uppercase text-primary">{{ $product->subtitle ?? ($product->category->name ?? 'Atelier') }}</span>
            <span class="font-body-sm">{{ $product->edition ?? '' }}</span>
        </div>
        <h3
            class="font-title-editorial text-title-editorial text-on-surface group-hover:text-primary transition-colors leading-tight">
            <a href="{{ route('product.show', $product) }}">{{ $product->name }}</a>
        </h3>
        <p class="font-body-sm text-body-sm text-on-surface-variant font-light line-clamp-1">
            {{ $product->material }}
        </p>
        <div class="flex items-center justify-between pt-space-xs border-t border-outline-variant/20 mt-1">
            <div class="flex flex-col">
                @if($product->sale_price && $product->sale_price < $product->base_price)
                    <span class="font-label-sm text-base text-primary font-semibold">${{ number_format($product->sale_price, 0) }}</span>
                    <span class="text-xs text-on-surface-variant line-through">${{ number_format($product->base_price, 0) }}</span>
                @else
                    <span class="font-label-sm text-base text-on-surface font-semibold">${{ number_format($product->base_price, 0) }}</span>
                @endif
            </div>
            <span
                class="font-label-caps text-[10px] {{ $product->bottom_label == 'Immediate Dispatch' ? 'text-tertiary' : 'text-primary' }} tracking-widest uppercase">
                {{ $product->bottom_label ?? 'Includes Fitting' }}
            </span>
        </div>
    </div>
</div>
