@extends('admin.layouts.admin')

@section('title', 'Reviews | Upsilon')

@section('page-title', 'Reviews')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Reviews</h3>
            <p class="admin-card-description">Monitor and manage customer reviews</p>
        </div>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                    <tr>
                        <td class="font-medium">{{ $review->product->name ?? 'Unknown Product' }}</td>
                        <td>{{ $review->user->name ?? 'Guest' }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span class="material-symbols-outlined text-warning text-sm">star</span>
                                @else
                                    <span class="material-symbols-outlined text-muted text-sm">star</span>
                                @endif
                            @endfor
                        </td>
                        <td class="text-muted">{{ Str::limit($review->review, 50) }}</td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            @if($review->is_approved)
                                <span class="inline-flex items-center gap-1 text-xs text-emerald-600 font-medium">
                                    <span class="material-symbols-outlined text-base">check_circle</span>
                                    Approved
                                </span>
                            @else
                                <form method="POST" action="{{ route('admin.reviews.update', $review) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="is_approved" value="1">
                                    <input type="hidden" name="rating" value="{{ $review->rating }}">
                                    <button type="submit" class="admin-btn admin-btn-success admin-btn-sm">Approve</button>
                                </form>
                            @endif
                            <button type="button" class="admin-btn admin-btn-sm" onclick="document.getElementById('reply-form-{{ $review->id }}').classList.toggle('hidden')">Reply</button>
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @if($review->replies->isNotEmpty())
                        <tr>
                            <td colspan="6" class="p-0">
                                <div class="p-4 bg-neutral-50">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-neutral-700 mb-2">Replies</h4>
                                    @foreach($review->replies as $reply)
                                        <div class="mb-3 last:mb-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-xs font-bold text-neutral-900">{{ $reply->user->name ?? 'Admin' }}</span>
                                                <span class="text-[10px] text-neutral-400">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-xs text-neutral-700">{{ $reply->body }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endif
                    <tr id="reply-form-{{ $review->id }}" class="hidden">
                        <td colspan="6" class="p-0">
                            <form method="POST" action="{{ route('admin.reviews.replies.store', $review) }}" class="p-4 bg-white border-t border-neutral-200">
                                @csrf
                                <div class="flex gap-2">
                                    <textarea name="body" rows="2" required class="flex-1 text-xs border border-neutral-300 rounded-sm p-2" placeholder="Write your reply..."></textarea>
                                    <button type="submit" class="admin-btn admin-btn-sm">Send</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($reviews->hasPages())
        <div class="admin-card-footer">
            {{ $reviews->links() }}
        </div>
    @endif
</div>
@endsection
