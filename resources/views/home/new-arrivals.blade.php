<section class="py-24 bg-surface">
    <div class="px-6 md:px-12 lg:px-24">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-headline-md tracking-tight text-on-surface">New Arrivals</h2>
                <div class="w-12 h-px bg-surface-container-lowest mx-auto mt-6"></div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12">
                @foreach($newArrivals as $product)
                    @include('components.product-card', ['product' => $product])
                @endforeach
            </div>
            <div class="text-center mt-16">
                <a href="{{ route('shop') }}" class="inline-block border border-outline-variant text-on-surface px-10 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-lowest hover:text-tertiary transition-all duration-300">View All</a>
            </div>
        </div>
    </div>
</section>


