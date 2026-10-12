@extends("layouts.home")

@section("title")
{{ $category->name }} - Coming Soon | {{ config('app.name', 'Upsilon') }}
@endsection

@section("description")
The {{ $category->name }} collection is currently unavailable at Upsilon Store. Check back soon.
@endsection

@section("content")
    <main id="main-content">
        <section class="py-24 px-6 md:px-12 lg:px-24 bg-surface border-b border-outline-variant/40">
            <div class="max-w-7xl mx-auto text-center">
                <nav class="text-sm text-on-surface-variant mb-8">
                    <a href="{{ route('shop') }}" class="hover:text-on-surface">Shop</a>
                    <span class="mx-2">/</span>
                    <span class="text-on-surface">{{ $category->name }}</span>
                </nav>

                <span class="inline-block rounded bg-yellow-500/15 px-3 py-1 text-xs font-bold uppercase tracking-wider text-yellow-600">
                    Disabled
                </span>

                <h1 class="mt-4 text-3xl md:text-4xl font-headline-md">Coming Soon</h1>

                <p class="mt-4 max-w-md mx-auto text-on-surface-variant">
                    The {{ $category->name }} collection is currently disabled and will be back soon.
                    Browse other categories in the meantime.
                </p>

                <a href="{{ route('shop') }}"
                    class="mt-8 inline-block bg-on-surface px-8 py-3 text-sm font-bold uppercase tracking-wider text-surface transition hover:opacity-90">
                    Back to Shop
                </a>
            </div>
        </section>
    </main>
@endsection
