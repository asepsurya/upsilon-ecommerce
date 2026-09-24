@extends('admin.layouts.admin')

@section('title', 'Vouchers - Admin')

@section('page-title', 'Vouchers')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Vouchers</h3>
            <p class="admin-card-description">Create and manage discount vouchers</p>
        </div>
        <a href="{{ route('admin.vouchers.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Voucher</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Code</th>
                    <th>Discount</th>
                    <th>Min Purchase</th>
                    <th>Usage</th>
                    <th>Expires</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vouchers as $voucher)
                    <tr>
                        <td class="font-medium">{{ $voucher->code }}</td>
                        <td>
                            @if($voucher->discount_type == 'percentage')
                                {{ $voucher->discount_value }}%
                            @else
                                $ {{ number_format($voucher->discount_value, 0) }}
                            @endif
                        </td>
                        <td>$ {{ number_format($voucher->min_purchase, 0) }}</td>
                        <td>{{ $voucher->used_count }} / {{ $voucher->max_usage }}</td>
                        <td>{{ $voucher->expires_at->format('M d, Y') }}</td>
                        <td class="text-right">
                            <a href="{{ route('admin.vouchers.edit', $voucher) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.vouchers.destroy', $voucher) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
</div>
@endsection
