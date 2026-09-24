@extends('admin.layouts.admin')

@section('title', 'Create Category - Admin')

@section('page-title', 'Create Category')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Create Category</h3>
            <p class="admin-card-description">Add a new product category</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Back to Categories</a>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="admin-form-group">
                <label class="admin-form-label">Category Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Slug</label>
                <input type="text" name="slug" value="{{ old('slug') }}" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Image</label>
                <input type="file" name="image" class="admin-form-input">
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Create Category</button>
        </form>
    </div>
</div>
@endsection
