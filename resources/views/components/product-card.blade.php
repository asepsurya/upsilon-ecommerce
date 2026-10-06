@props([
    'product',
    'showStock' => false,
])

@php
    $isModel = $product instanceof \App\Models\Product;

    if ($isModel) {
        $imageUrl = optional($product->images?->firstWhere('is_primary', true))?->url
            ?? optional($product->images?->first())?->url
            ?? null;
        $productLink = route('product.show', $product->slug ?? $product->id);
        $brand = $product->subtitle ?? optional($product->category)->name ?? 'Upsilon';
        $inStock = $product->activeVariants()->exists();
    } else {
        $imageUrl = $product->image_url ?? $product->image ?? null;
        $productLink = $product->permalink ?? route('shop');
        $brand = $product->brand ?? 'Upsilon';
        $inStock = true;
    }

    $basePrice = $product->base_price;
    $salePrice = $product->sale_price;
    $hasDiscount = $salePrice && $salePrice < $basePrice;
    $displayPrice = $salePrice ?? $basePrice;
@endphp

<div class="group relative flex flex-col bg-white border border-gray-200 shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden rounded">
    <div class="relative aspect-[3/4] w-full overflow-hidden bg-gray-100">
        @if($imageUrl)
            <img class="w-full h-full object-cover object-center transition-transform duration-500 group-hover:scale-105"
                src="{{ $imageUrl }}" alt="{{ $product->name }}">
        @else
            <div class="w-full h-full flex items-center justify-center">
                <span class="text-gray-400 text-xs uppercase tracking-wider">No Image</span>
            </div>
        @endif

        @if($isModel && $product->category)
            <span class="absolute top-2 left-2 bg-black text-white text-[10px] font-bold uppercase px-2 py-0.5 rounded">
                {{ $product->category->name }}
            </span>
        @endif

        @if($isModel && $product->labels->isNotEmpty())
            <div class="absolute top-2 right-2 flex flex-wrap gap-1 justify-end max-w-[60%]">
                @foreach($product->labels->take(2) as $label)
                    @if($label->image)
                        <img src="{{ $label->image_url }}" alt="{{ $label->name }}" class="h-4 w-auto object-contain">
                    @else
                        <span class="inline-block px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wider rounded-sm" style="background-color: {{ $label->color ?? '#000' }}; color: {{ $label->text_color ?? '#fff' }};">
                            {{ $label->name }}
                        </span>
                    @endif
                @endforeach
            </div>
        @endif

        @if($showStock)
            <span class="absolute top-2 right-2 {{ $inStock ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-[10px] font-bold px-2 py-0.5 rounded">
                {{ $inStock ? 'In Stock' : 'Out of Stock' }}
            </span>
        @endif

        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300 flex justify-center py-3">
            <a href="https://wa.me/{{ config('services.whatsapp.number', '6281234567890') }}?text={{ urlencode('Hi, I would like to buy ' . $product->name . ' for ' . currency_format($displayPrice) . '. Can you give me info?') }}"
                class="text-[10px] font-bold uppercase tracking-wider text-white hover:text-brand-yellow transition-colors"
                target="_blank" rel="noopener">
                Chat on WhatsApp
            </a>
        </div>
    </div>

    <div class="p-3 flex flex-col flex-1">
        <div class="flex items-center justify-between text-[10px] text-gray-500 uppercase tracking-wider mb-1">
            <span class="font-semibold text-black">{{ $brand }}</span>
            @if($product->edition ?? null)
                <span>{{ $product->edition }}</span>
            @endif
        </div>

        <h3 class="text-sm font-semibold text-black line-clamp-1">
            <a href="{{ $productLink }}">{{ $product->name }}</a>
        </h3>

        @if($product->material ?? null)
            <p class="text-xs text-gray-500 line-clamp-1 mt-0.5">{{ $product->material }}</p>
        @endif

        <div class="flex items-center justify-between mt-auto pt-2 border-t border-gray-200">
            <div class="flex flex-col">
                @if($hasDiscount)
                    <span class="text-sm font-bold text-brand-orange">{{ currency_format($salePrice) }}</span>
                    <span class="text-xs text-gray-400 line-through">{{ currency_format($basePrice) }}</span>
                @else
                    <span class="text-sm font-bold text-black">{{ currency_format($displayPrice) }}</span>
                @endif
            </div>
            @if($showStock && !$inStock)
                <span class="text-[10px] font-bold text-red-600 uppercase">Out of Stock</span>
            @endif
        </div>
    </div>
</div>
