@extends("layouts.home")

@section("title")
    Edit Review - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('account.reviews') }}" class="inline-flex items-center gap-2 text-sm text-on-surface-variant hover:text-on-surface">
                    <span class="material-symbols-outlined text-base">arrow_back</span>
                    Back to My Reviews
                </a>
            </div>

            <div class="bg-surface border border-outline-variant/40">
                <div class="px-8 py-6 border-b border-outline-variant/40">
                    <h1 class="text-2xl font-headline-md">Edit Review</h1>
                    <p class="text-sm text-on-surface-variant mt-1">Update your review for {{ $review->product->name ?? 'this product' }}</p>
                </div>

                <div class="px-8 py-6">
                    <form method="POST" action="{{ route('account.reviews.update', $review) }}">
                        @csrf

                        {{-- Rating Section --}}
                        <div class="mb-8">
                            <label class="block text-sm font-semibold text-on-surface mb-3">Your Rating*</label>
                            <div class="flex items-center gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        class="review-star-btn w-10 h-10 rounded-full border-2 {{ $i <= $review->rating ? 'border-primary-500 bg-primary-50' : 'border-outline-variant/40 hover:border-outline-variant/60' }} transition-all flex items-center justify-center"
                                        data-value="{{ $i }}"
                                        aria-label="{{ $i }} star">
                                        <span class="material-symbols-outlined {{ $i <= $review->rating ? 'text-primary-600' : 'text-on-surface-variant' }} text-xl">star</span>
                                    </button>
                                @endfor
                                <input type="hidden" name="rating" id="review-rating-input" value="{{ $review->rating }}" required>
                                <span id="rating-selected-text" class="text-sm font-medium ml-3">
                                    {{ $review->rating == 5 ? 'Very Satisfied' : ($review->rating == 4 ? 'Satisfied' : ($review->rating == 3 ? 'Average' : ($review->rating == 2 ? 'Dissatisfied' : 'Very Dissatisfied'))) }}
                                </span>
                            </div>
                        </div>

                        {{-- Review Content --}}
                        <div class="mb-8">
                            <label for="review-textarea" class="block text-sm font-semibold text-on-surface mb-3">Your Review*</label>
                            <textarea name="review" id="review-textarea" rows="6" required
                                placeholder="How is the size and comfort? Tell other buyers..."
                                class="w-full px-4 py-3 bg-background border border-outline-variant/40 rounded-lg text-sm text-on-surface placeholder-on-surface-variant focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all">{{ $review->review }}</textarea>
                            <p class="text-xs text-on-surface-variant mt-2">Minimum 10 characters. Maximum 2000 characters.</p>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit"
                                class="bg-primary-600 hover:bg-primary-700 text-white px-6 py-3 text-sm font-semibold rounded-lg transition-colors">
                                Save Changes
                            </button>
                            <a href="{{ route('account.reviews') }}"
                                class="px-6 py-3 text-sm font-medium text-on-surface-variant hover:text-on-surface transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
