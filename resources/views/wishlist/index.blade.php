@extends("layouts.app")

@section("title")
My Wishlist - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-12">My Wishlist</h1>
                @if($wishlist->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12">
                        @foreach($wishlist as $item)
                            <div class="group">
                                <div class="relative aspect-[3/4] bg-surface-container mb-4 overflow-hidden">
                                    <img src="{{ $item->product->images->first()?->url ?? 'https://placehold.co/400x500/stone-200/stone-500?text=No+Image' }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <form method="POST" action="{{ route('wishlist.destroy', $item) }}" class="absolute top-4 right-4">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 bg-surface flex items-center justify-center hover:bg-surface-container-high transition-colors">
                                            <svg class="w-4 h-4 text-on-surface-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                                <h3 class="font-headline-md text-on-surface mb-1">{{ $item->product->name }}</h3>
                                <p class="text-sm text-on-surface-variant mb-3">$ {{ number_format($item->product->base_price, 0, '.', ',') }}</p>
                                <a
                                    href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ urlencode('Hello, I am interested in ' . $item->product->name . ' priced at $ ' . number_format($item->product->base_price, 0, '.', ',') . '. Is it still available?') }}"
                                    class="w-full border border-outline-variant text-on-surface py-3 text-xs tracking-widest uppercase hover:bg-surface-container-lowest hover:text-tertiary transition-all duration-300 text-center block"
                                    target="_blank" rel="noopener">
                                    Order via WhatsApp
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-24">
                        <p class="text-on-surface-variant mb-8">Your wishlist is empty.</p>
                        <a href="{{ route('shop') }}" class="inline-block bg-surface-container-lowest text-tertiary px-10 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300">Continue Shopping</a>
                    </div>
                @endif
            </div>
        </section>
@endsection
