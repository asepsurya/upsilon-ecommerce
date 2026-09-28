@extends('layouts.home')

@section('title', 'Bundles | Upsilon')
@section('description', 'Shop exclusive bundles and deals at Upsilon.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    @include('components.site-header')

    <section class="bg-white py-8 text-black" data-purpose="product-bundles">
        <div class="mx-auto max-w-7xl px-4 lg:px-8">
            <div class="mb-6 flex items-center justify-between">
                <h1 class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                    Bundles
                </h1>
            </div>

            @if($bundles->isNotEmpty())
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    @foreach($bundles as $bundle)
                        <div class="group relative bg-white rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                            <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                @if($bundle->thumbnail)
                                    <img src="{{ asset('storage/' . $bundle->thumbnail) }}" alt="{{ $bundle->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @else
                                    <img src="https://placehold.co/600x600/f3f4f6/111111?text={{ urlencode($bundle->name) }}"
                                        alt="{{ $bundle->name }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                @endif
                                @if($bundle->discount_percent > 0)
                                    <div
                                        class="absolute top-4 left-4 bg-brand-yellow text-black px-3 py-1 font-condensed text-[10px] uppercase tracking-wider rounded">
                                        Save {{ $bundle->discount_percent }}%
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex flex-col gap-3">
                                <h3 class="font-condensed text-sm text-black uppercase tracking-widest">
                                    {{ $bundle->name }}
                                </h3>
                                <p class="font-body-sm text-xs text-gray-600 font-light">
                                    {{ $bundle->items->count() }} products
                                </p>
                                @php
                                    $shownItems = $bundle->items->take(4);
                                    $moreCount = $bundle->items->count() - $shownItems->count();
                                @endphp
                                <div class="flex flex-wrap gap-2">
                                    @foreach($shownItems as $item)
                                        @php
                                            $image = null;
                                            if (!empty($item->product->images)) {
                                                $image = $item->product->images->first()->url ?? $item->product->images->first()->image;
                                            }
                                            if (!$image) {
                                                $image = 'https://placehold.co/80x80/f3f4f6/111111?text=' . urlencode($item->product->name ?? 'Product');
                                            }
                                        @endphp
                                        <img src="{{ $image }}" alt="{{ $item->product->name ?? 'Product' }}" class="h-12 w-12 rounded object-cover">
                                    @endforeach
                                    @if($moreCount > 0)
                                        <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center text-black text-xs font-bold">
                                            +{{ $moreCount }}
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($bundle->bundle_price)
                                        <span class="font-condensed text-xl text-black font-black">
                                            ${{ number_format($bundle->bundle_price, 0) }}
                                        </span>
                                        @if($bundle->original_price > 0)
                                            <span class="font-body-sm text-xs text-gray-500 line-through">
                                                ${{ number_format($bundle->original_price, 0) }}
                                            </span>
                                        @endif
                                    @endif
                                </div>
                                <a href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Hello, I am interested in ' . $bundle->name . ' bundle.') }}"
                                    class="w-full bg-brand-yellow text-black font-condensed text-xs font-bold px-6 py-2.5 rounded-sm hover:bg-yellow-300 transition flex items-center justify-center gap-2"
                                    target="_blank" rel="noopener">
                                    <span>Order Bundle</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-300">No bundles available at the moment.</p>
            @endif
        </div>
    </section>
@endsection
