@extends('admin.layouts.admin')

@section('title', 'Create Size Guide | Upsilon')

@section('page-title', 'Create Size Guide')

@section('content')
<div class="admin-card" style="max-width: 800px;">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">New Size Guide</h3>
            <p class="admin-card-description">Add clothing size measurements</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.size-guides.store') }}">
        @csrf
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div class="admin-form-group">
                <label class="admin-form-label" for="size_label">Size Label</label>
                <input type="text" id="size_label" name="size_label" value="{{ old('size_label') }}" class="admin-form-input" placeholder="S, M, L, XL, XXL" required>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="size_type">Size Type</label>
                <select id="size_type" name="size_type" class="admin-form-input" required>
                    <option value="tshirt" {{ old('size_type') === 'tshirt' ? 'selected' : '' }}>T-Shirt</option>
                    <option value="shirt" {{ old('size_type') === 'shirt' ? 'selected' : '' }}>Shirt</option>
                    <option value="pants" {{ old('size_type') === 'pants' ? 'selected' : '' }}>Pants</option>
                    <option value="jacket" {{ old('size_type') === 'jacket' ? 'selected' : '' }}>Jacket</option>
                    <option value="hoodie" {{ old('size_type') === 'hoodie' ? 'selected' : '' }}>Hoodie</option>
                    <option value="other" {{ old('size_type') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="chest_cm">Chest (cm)</label>
                <input type="text" id="chest_cm" name="chest_cm" value="{{ old('chest_cm') }}" class="admin-form-input" placeholder="88-92">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="chest_inch">Chest (inch)</label>
                <input type="text" id="chest_inch" name="chest_inch" value="{{ old('chest_inch') }}" class="admin-form-input" placeholder="34.5-36.2">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="waist_cm">Waist (cm)</label>
                <input type="text" id="waist_cm" name="waist_cm" value="{{ old('waist_cm') }}" class="admin-form-input" placeholder="76-80">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="waist_inch">Waist (inch)</label>
                <input type="text" id="waist_inch" name="waist_inch" value="{{ old('waist_inch') }}" class="admin-form-input" placeholder="29.9-31.5">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="hip_cm">Hip (cm)</label>
                <input type="text" id="hip_cm" name="hip_cm" value="{{ old('hip_cm') }}" class="admin-form-input" placeholder="92-96">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="hip_inch">Hip (inch)</label>
                <input type="text" id="hip_inch" name="hip_inch" value="{{ old('hip_inch') }}" class="admin-form-input" placeholder="36.2-37.8">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="shoulder_cm">Shoulder (cm)</label>
                <input type="text" id="shoulder_cm" name="shoulder_cm" value="{{ old('shoulder_cm') }}" class="admin-form-input" placeholder="42-44">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="sleeve_length_cm">Sleeve Length (cm)</label>
                <input type="text" id="sleeve_length_cm" name="sleeve_length_cm" value="{{ old('sleeve_length_cm') }}" class="admin-form-input" placeholder="60-62">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="body_length_cm">Body Length (cm)</label>
                <input type="text" id="body_length_cm" name="body_length_cm" value="{{ old('body_length_cm') }}" class="admin-form-input" placeholder="68-70">
            </div>

            <div class="admin-form-group">
                <label class="admin-form-label" for="notes">Notes</label>
                <textarea id="notes" name="notes" rows="3" class="admin-form-input" placeholder="Additional notes about this size">{{ old('notes') }}</textarea>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="{{ route('admin.size-guides.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
            <button type="submit" class="admin-btn admin-btn-primary">Create Size Guide</button>
        </div>
    </form>
</div>
@endsection
