@extends('admin.layouts.admin')

@section('title', 'Edit Category - Admin')

@section('page-title', 'Edit Category')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Edit Category</h3>
            <p class="admin-card-description">Update category details</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Back to Categories</a>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="admin-form-group">
                <label class="admin-form-label">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required class="admin-form-input">
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Current Image</label>
                @if($category->image)
                    <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-16 h-16 object-cover border border-gray-200">
                @endif
            </div>
            <div class="admin-form-group">
                <label class="admin-form-label">Change Image</label>
                <input type="file" name="image" class="admin-form-input">
            </div>
            <button type="submit" class="admin-btn admin-btn-primary">Update Category</button>
        </form>
    </div>
</div>
@endsection
