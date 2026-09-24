@extends('admin.layouts.admin')

@section('title', 'Reviews - Admin')

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
                        <td>{{ $review->customer_name }}</td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span class="material-symbols-outlined text-warning text-sm">star</span>
                                @else
                                    <span class="material-symbols-outlined text-muted text-sm">star</span>
                                @endif
                            @endfor
                        </td>
                        <td class="text-muted">{{ Str::limit($review->comment, 50) }}</td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
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
