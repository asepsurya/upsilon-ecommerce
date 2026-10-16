@extends("layouts.home")

@section("title")
    My Reviews - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-headline-md mb-12">My Reviews</h1>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    @include('account.sidebar')
                </aside>
                <div class="lg:col-span-3">
                    <div class="bg-surface border border-outline-variant/40">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b border-outline-variant/40">
                                    <tr
                                        class="text-left text-xs font-semibold tracking-widest uppercase text-on-surface-variant">
                                        <th class="px-8 py-4">Product</th>
                                        <th class="px-8 py-4">Rating</th>
                                        <th class="px-8 py-4">Comment</th>
                                        <th class="px-8 py-4">Date</th>
                                        <th class="px-8 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/30">
                                    @forelse($reviews as $review)
                                        <tr class="hover:bg-background">
                                            <td class="px-8 py-4">
                                                <a href="{{ route('product.show', $review->product) }}"
                                                    class="font-medium hover:text-on-surface-variant">{{ $review->product->name ?? 'Unknown Product' }}</a>
                                            </td>
                                            <td class="px-8 py-4">
                                                <div class="flex items-center gap-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <span class="material-symbols-outlined text-warning text-sm">star</span>
                                                        @else
                                                            <span class="material-symbols-outlined text-muted text-sm">star</span>
                                                        @endif
                                                    @endfor
                                                    <span class="text-xs text-on-surface-variant ml-1">({{ $review->rating }})</span>
                                                </div>
                                            </td>
                                            <td class="px-8 py-4 text-on-surface-variant">{{ Str::limit($review->review, 50) }}</td>
                                            <td class="px-8 py-4 text-on-surface-variant">{{ $review->created_at->format('M d, Y') }}</td>
                                            <td class="px-8 py-4 text-right">
                                                <a href="{{ route('account.reviews.edit', $review) }}"
                                                    class="inline-flex items-center gap-1 text-xs text-primary-600 hover:text-primary-800 font-medium">
                                                    <span class="material-symbols-outlined text-base">edit</span>
                                                    Edit
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-12 text-center text-on-surface-variant">
                                                You haven't submitted any reviews yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($reviews->hasPages())
                            <div class="px-8 py-4 border-t border-outline-variant/40">
                                {{ $reviews->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
