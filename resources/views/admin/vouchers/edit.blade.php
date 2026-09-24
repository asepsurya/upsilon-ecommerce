@extends('admin.layouts.admin')

@section('title', 'Edit Voucher - Admin')

@section('page-title', 'Edit Voucher')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Edit Voucher</h3>
            <p class="admin-card-description">Update voucher details</p>
        </div>
        <a href="{{ route('admin.vouchers.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Back to Vouchers</a>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.vouchers.update', $voucher) }}">
            @csrf
            @method('PATCH')
            <div class="admin-form-group">
                <label class="admin-form-label">Voucher Code</label>
                <input type="text" name="code" value="{{ old('code', $voucher->code) }}" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Discount Type</label>
                <select name="type" class="admin-form-input">
                    <option value="percentage" {{ old('type', $voucher->type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed" {{ old('type', $voucher->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Discount Value</label>
                <input type="number" name="value" value="{{ old('value', $voucher->value) }}" step="0.01" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Minimum Purchase</label>
                <input type="number" name="min_purchase" value="{{ old('min_purchase', $voucher->min_purchase) }}" step="0.01" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Max Discount</label>
                <input type="number" name="max_discount" value="{{ old('max_discount', $voucher->max_discount) }}" step="0.01" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit', $voucher->usage_limit) }}" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Starts At</label>
                <input type="date" name="starts_at" value="{{ old('starts_at', $voucher->starts_at ? $voucher->starts_at->format('Y-m-d') : '') }}" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Expires At</label>
                <input type="date" name="expires_at" value="{{ old('expires_at', $voucher->expires_at ? $voucher->expires_at->format('Y-m-d') : '') }}" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $voucher->is_active) ? 'checked' : '' }}>
                    Active
                </label>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Update Voucher</button>
        </form>
    </div>
</div>
@endsection
