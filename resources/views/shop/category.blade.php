@extends("layouts.app")

@section("title")
{{ $category->name }} - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24 bg-surface border-b border-outline-variant/40">
            <div class="max-w-7xl mx-auto">
                <nav class="text-sm text-on-surface-variant mb-4">
                    <a href="{{ route('shop') }}" class="hover:text-on-surface">Shop</a>
                    <span class="mx-2">/</span>
                    <span class="text-on-surface">{{ $category->name }}</span>
                </nav>
                <h1 class="text-3xl md:text-4xl font-headline-md">{{ $category->name }}</h1>
            </div>
        </section>

        <section class="py-8 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <div class="flex items-center justify-between mb-8">
                    <p class="text-sm text-on-surface-variant">{{ $products->total() }} Products</p>
                    <div class="flex items-center gap-4">
                        <select onchange="window.location.href=this.value" class="border border-outline-variant/50 px-4 py-2 text-sm bg-transparent focus:outline-none focus:border-outline-variant">
                            <option value="">Sort by: Featured</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12">
                    @forelse($products as $product)
                        @include('components.product-card', ['product' => $product])
                    @empty
                        <div class="col-span-full text-center py-24">
                            <p class="text-on-surface-variant">No products found in this category.</p>
                        </div>
                    @endforelse
                </div>
                <div class="mt-16">
                    {{ $products->links() }}
                </div>
            </div>
        </section>
@endsection
