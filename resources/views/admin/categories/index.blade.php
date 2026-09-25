@extends('admin.layouts.admin')

@section('title', 'Categories - Admin')

@section('page-title', 'Categories')

@section('content')
<div class="admin-card">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Categories</h3>
            <p class="admin-card-description">Organize products into categories</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">Add Category</a>
    </div>
    <div style="overflow-x: auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Products</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>
                            <div class="w-12 h-12 bg-white overflow-hidden border border-gray-200">
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                            </div>
                        </td>
                        <td class="font-medium">{{ $category->name }}</td>
                        <td class="text-muted">{{ $category->slug }}</td>
                        <td>
                            <span class="admin-badge admin-badge-info">{{ $category->products_count ?? 0 }}</span>
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
