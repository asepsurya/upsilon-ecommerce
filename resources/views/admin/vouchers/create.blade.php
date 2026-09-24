@extends('admin.layouts.admin')

@section('title', 'Create Voucher - Admin')

@section('page-title', 'Create Voucher')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Create Voucher</h3>
            <p class="admin-card-description">Add a new discount voucher</p>
        </div>
        <a href="{{ route('admin.vouchers.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Back to Vouchers</a>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.vouchers.store') }}">
            @csrf
            <div class="admin-form-group">
                <label class="admin-form-label">Voucher Code</label>
                <input type="text" name="code" value="{{ old('code') }}" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Discount Type</label>
                <select name="type" class="admin-form-input">
                    <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                </select>
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Discount Value</label>
                <input type="number" name="value" value="{{ old('value') }}" step="0.01" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Minimum Purchase</label>
                <input type="number" name="min_purchase" value="{{ old('min_purchase') }}" step="0.01" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Max Discount</label>
                <input type="number" name="max_discount" value="{{ old('max_discount') }}" step="0.01" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Usage Limit</label>
                <input type="number" name="usage_limit" value="{{ old('usage_limit') }}" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Starts At</label>
                <input type="date" name="starts_at" value="{{ old('starts_at') }}" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Expires At</label>
                <input type="date" name="expires_at" value="{{ old('expires_at') }}" class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    Active
                </label>
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Create Voucher</button>
        </form>
    </div>
</div>
@endsection
