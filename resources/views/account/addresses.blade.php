@extends("layouts.home")

@section("title")
    My Addresses - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                @include('account.sidebar')
            </aside>
            <div class="lg:col-span-3">
                <div class="flex items-center justify-between mb-12">
                    <h1 class="text-3xl md:text-4xl font-headline-md">My Addresses</h1>
                    <a href="{{ route('account.addresses.create') }}"
                        class="bg-black text-white px-6 py-3 text-sm tracking-widest uppercase hover:bg-neutral-800 transition-colors">Add
                        Address</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($addresses as $address)
                        <div class="bg-surface border border-outline-variant/40 p-8">
                            @if($address->is_default)
                                <span
                                    class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant mb-3 block">Default</span>
                            @endif
                            <h3 class="font-headline-md text-lg mb-2">{{ $address->label }}</h3>
                            <p class="text-sm text-on-surface-variant mb-4">{{ $address->address }}</p>
                            <p class="text-sm text-on-surface-variant">{{ $address->city }}, {{ $address->province }}
                                {{ $address->postal_code }}
                            </p>
                            <div class="flex gap-4 mt-6 pt-6 border-t border-outline-variant/40">
                                <a href="{{ route('account.addresses.edit', $address) }}"
                                    class="text-sm text-on-surface-variant hover:text-on-surface">Edit</a>
                                <form method="POST" action="{{ route('account.addresses.delete', $address) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-on-surface-variant hover:text-on-surface"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection