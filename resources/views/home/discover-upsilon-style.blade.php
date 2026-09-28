@extends('layouts.home')

@section('title', 'Discover Upsilon Style | Upsilon')
@section('description', 'Discover the latest style editorial, sneaker culture, and fashion stories from Upsilon.')
@section('ogUrl', url()->current())
@section('ogImage', asset('storage/images/upsilon/hero-banner.jpg'))

@section('content')
    <a href="#main-content"
        class="sr-only focus:not-sr-only focus:absolute focus:z-[60] focus:bg-black focus:px-4 focus:py-2 focus:text-white">
        Skip to main content
    </a>

    <main id="main-content">
        <section class="bg-[#F25C19] pb-12 text-white" aria-labelledby="editorial-heading">
            <div class="mx-auto max-w-7xl px-4 lg:px-8">
                <div class="mb-6 flex items-center justify-between">
                    <h1 id="editorial-heading" class="text-2xl font-condensed font-black tracking-wide md:text-3xl">
                        Discover Upsilon Style
                    </h1>
                    <a href="{{ route('home') }}" class="text-xs font-bold uppercase tracking-wider hover:underline">Back to Home</a>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($articlesList as $article)
                        @php
                            $articleImage = $article->image_url
                                ?? ($article->image ?: null)
                                ?? asset('storage/images/upsilon/article-1.jpg');
                            $articleUrl = $article->permalink ?? '#';
                        @endphp
                        <article class="flex flex-col justify-between overflow-hidden rounded bg-white text-black shadow">
                            <a href="{{ $articleUrl }}" class="block aspect-square w-full overflow-hidden">
                                <img src="{{ $articleImage }}" alt="{{ $article->title }}" loading="lazy"
                                    class="h-full w-full object-cover transition duration-300 hover:scale-105">
                            </a>
                            <div class="p-4">
                                <h2 class="text-sm font-bold leading-snug line-clamp-2">{{ $article->title }}</h2>
                                <p class="mt-2 text-xs leading-relaxed text-gray-600 line-clamp-3">
                                    {{ $article->excerpt }}</p>
                                <a href="{{ $articleUrl }}"
                                    class="mt-3 inline-flex items-center gap-1 text-xs font-bold uppercase hover:underline">
                                    Read More <span aria-hidden="true">&rarr;</span>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($articlesList->isEmpty())
                    <p class="mt-8 text-center text-sm text-white/80">No articles available yet.</p>
                @endif
            </div>
        </section>
    </main>
@endsection
