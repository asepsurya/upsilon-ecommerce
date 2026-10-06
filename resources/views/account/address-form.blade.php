@extends("layouts.home")

@section("title")
    {{ isset($address) ? 'Edit Address' : 'Add Address' }} - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                @include('account.sidebar')
            </aside>
            <div class="lg:col-span-3">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-12">{{ isset($address) ? 'Edit Address' : 'Add New Address' }}</h1>
                <div class="bg-surface border border-outline-variant/40">
                    <form method="POST" action="{{ isset($address) ? route('account.addresses.update', $address) : route('account.addresses.store') }}" class="p-8 space-y-6">
                        @csrf
                        @if(isset($address))
                            @method('PATCH')
                        @endif
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Full Name <span class="text-red-500">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name', $address->full_name ?? '') }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                                @error('full_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Phone <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" value="{{ old('phone', $address->phone ?? '') }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                                @error('phone')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Label <span class="text-red-500">*</span></label>
                            <input type="text" name="label" value="{{ old('label', $address->label ?? '') }}" placeholder="e.g. Home, Office" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                            @error('label')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Address <span class="text-red-500">*</span></label>
                            <textarea name="address" rows="3" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>{{ old('address', $address->address ?? '') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Province <span class="text-red-500">*</span></label>
                                <input type="text" name="province" value="{{ old('province', $address->province ?? '') }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                                @error('province')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">City <span class="text-red-500">*</span></label>
                                <input type="text" name="city" value="{{ old('city', $address->city ?? '') }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                                @error('city')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">District <span class="text-red-500">*</span></label>
                                <input type="text" name="district" value="{{ old('district', $address->district ?? '') }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                                @error('district')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Postal Code <span class="text-red-500">*</span></label>
                            <input type="text" name="postal_code" value="{{ old('postal_code', $address->postal_code ?? '') }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent" required>
                            @error('postal_code')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="checkbox" name="is_default" id="is_default" value="1" {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }} class="w-4 h-4 rounded border-outline-variant/50 text-black focus:ring-brand-orange">
                            <label for="is_default" class="text-sm text-on-surface">Set as default address</label>
                        </div>
                        <div class="flex gap-4 pt-4">
                            <button type="submit" class="bg-black text-white px-10 py-4 text-sm tracking-widest uppercase hover:bg-neutral-800 transition-colors">{{ isset($address) ? 'Update Address' : 'Save Address' }}</button>
                            <a href="{{ route('account.addresses') }}" class="border border-outline-variant/50 px-10 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-high transition-colors text-on-surface">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection