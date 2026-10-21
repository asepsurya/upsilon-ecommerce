@extends('layouts.home')

@section('title', 'Create Bundle | Upsilon')

@section('content')
    @include('components.promo-bar')

    <section class="bg-white py-12">
        <div class="mx-auto max-w-4xl px-4 lg:px-8">
            <div class="mb-8">
                <h1 class="text-3xl font-condensed font-black tracking-wide md:text-4xl">Create New Bundle</h1>
                <p class="mt-2 text-gray-600">Create a custom bundle with your choice of products and quantities</p>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
                    <ul class="space-y-1">
                        @foreach($errors->all() as $error)
                            <li class="text-red-700">* {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('home.create-bundle.store') }}" class="space-y-8" id="bundle-form">
                @csrf

                <div class="bg-gray-50 rounded-lg p-6 space-y-6">
                    <h2 class="text-xl font-condensed font-bold text-gray-900">Bundle Information</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Bundle Name *</label>
                            <input type="text" name="name" required value="{{ old('name') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                placeholder="Enter bundle name">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-medium text-gray-700">Bundle Price (Optional)</label>
                            <input type="number" name="bundle_price" value="{{ old('bundle_price') }}" step="0.01"
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                placeholder="Leave empty to calculate automatically">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                            placeholder="Enter bundle description...">{{ old('description') }}</textarea>
                    </div>
                </div>

                <div class="bg-gray-50 rounded-lg p-6 space-y-6">
                    <h2 class="text-xl font-condensed font-bold text-gray-900">Bundle Items</h2>
                    <p class="text-gray-600">Select products and set quantities for your bundle</p>

                    <div class="relative">
                        <div class="flex items-center space-x-2 mb-4">
                            <input type="text" id="bundle-product-search" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-transparent"
                                placeholder="Search products by name...">
                            <button type="button" id="bundle-select-all"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors">
                                Select All
                            </button>
                        </div>

                        <div class="max-h-96 overflow-y-auto border border-gray-200 rounded-lg bg-white">
                            <div class="sticky top-0 bg-gray-50 border-b border-gray-200 px-4 py-3">
                                <div class="grid grid-cols-12 gap-2 text-sm font-medium text-gray-700">
                                    <div class="col-span-1">
                                        <input type="checkbox" id="bundle-select-all-header" class="w-4 h-4">
                                    </div>
                                    <div class="col-span-5">Product</div>
                                    <div class="col-span-3">Price</div>
                                    <div class="col-span-3">Quantity</div>
                                </div>
                            </div>

                            <div class="divide-y divide-gray-200" id="bundle-products-list">
                                @php
                                    $products = $products ?? [];
                                @endphp

                                @forelse($products as $product)
                                    <div class="bundle-product-row px-4 py-3 hover:bg-gray-50 transition-colors"
                                         data-name="{{ strtolower($product->name) }}"
                                         data-id="{{ $product->id }}"
                                         data-price="{{ $product->base_price }}">
                                        <div class="grid grid-cols-12 gap-2 items-center">
                                            <div class="col-span-1">
                                                <input type="checkbox" name="selected_products[]" 
                                                    value="{{ $product->id }}" 
                                                    class="bundle-product-checkbox w-4 h-4">
                                            </div>
                                            <div class="col-span-5">
                                                <div class="font-medium text-gray-900">{{ $product->name }}</div>
                                                @if($product->variants->count() > 0)
                                                    <div class="text-xs text-gray-500 mt-1">
                                                        @foreach($product->variants->take(2) as $variant)
                                                            <span class="inline-block bg-gray-100 px-2 py-1 rounded text-xs mr-1 mb-1">
                                                                {{ $variant->size?->name ?? '' }} / {{ $variant->color?->name ?? '' }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-span-3">
                                                <div class="text-gray-700">
                                                    {{ currency_format($product->base_price) }}
                                                </div>
                                            </div>
                                            <div class="col-span-3">
                                                <input type="number" name="quantities[{{ $product->id }}]" 
                                                    value="1" min="1" 
                                                    class="bundle-product-quantity w-20 px-2 py-1 border border-gray-300 rounded text-sm"
                                                    placeholder="Qty">
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="px-4 py-8 text-center text-gray-500">
                                        No products available.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('home') }}" 
                        class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="px-6 py-2 bg-yellow-500 text-black font-bold rounded-md hover:bg-yellow-400 transition-colors">
                        Create Bundle
                    </button>
                </div>
            </form>
        </div>
    </section>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('bundle-select-all-header');
            const productCheckboxes = document.querySelectorAll('.bundle-product-checkbox');
            const selectAllButton = document.getElementById('bundle-select-all');
            const productSearch = document.getElementById('bundle-product-search');
            const productRows = document.querySelectorAll('.bundle-product-row');

            // Select All functionality
            function updateSelectAllState() {
                const visibleCheckboxes = Array.from(productCheckboxes).filter(cb => 
                    !cb.closest('.bundle-product-row').classList.contains('hidden')
                );
                const allChecked = visibleCheckboxes.length > 0 && 
                    visibleCheckboxes.every(cb => cb.checked);
                const anyChecked = visibleCheckboxes.some(cb => cb.checked);

                selectAllCheckbox.checked = allChecked;
                selectAllCheckbox.indeterminate = !allChecked && anyChecked;

                selectAllButton.textContent = allChecked ? 'Deselect All' : 'Select All';
                selectAllButton.className = allChecked ? 
                    'px-4 py-2 bg-red-200 text-red-800 rounded-md hover:bg-red-300 transition-colors' :
                    'px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition-colors';
            }

            // Select All checkbox click
            selectAllCheckbox.addEventListener('change', function() {
                productCheckboxes.forEach(cb => {
                    if (!cb.closest('.bundle-product-row').classList.contains('hidden')) {
                        cb.checked = this.checked;
                    }
                });
                updateSelectAllState();
            });

            // Individual checkboxes
            productCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateSelectAllState);
            });

            // Select All button click
            selectAllButton.addEventListener('click', function() {
                const allVisibleChecked = Array.from(productCheckboxes).every(cb => 
                    cb.closest('.bundle-product-row').classList.contains('hidden') || cb.checked
                );

                productCheckboxes.forEach(cb => {
                    if (!cb.closest('.bundle-product-row').classList.contains('hidden')) {
                        cb.checked = !allVisibleChecked;
                    }
                });
                updateSelectAllState();
            });

            // Product search functionality
            productSearch.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();

                productRows.forEach(row => {
                    const name = row.dataset.name || '';

                    if (query === '' || name.includes(query)) {
                        row.classList.remove('hidden');
                    } else {
                        row.classList.add('hidden');
                    }
                });

                updateSelectAllState();
            });
        });
    </script>
    @endpush
@endsection