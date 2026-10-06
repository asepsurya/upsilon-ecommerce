@extends("layouts.home")

@section("title")
    Profile - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <aside class="lg:col-span-1">
                @include('account.sidebar')
            </aside>
            <div class="lg:col-span-3">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-12">Profile</h1>
                <div class="bg-surface border border-outline-variant/40">
                    <div class="px-8 py-6 border-b border-outline-variant/40">
                        <h2 class="font-headline-md text-xl">Personal Information</h2>
                    </div>
                    <form method="POST" action="{{ route('account.profile.update') }}" class="p-8 space-y-6">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center gap-6 mb-8">
                            <div class="w-20 h-20 bg-surface-container flex items-center justify-center overflow-hidden rounded-full">
                                @if(auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <span class="text-2xl font-bold text-on-surface-variant">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-on-surface">{{ auth()->user()->name }}</p>
                                <button type="button" class="border border-outline-variant/50 px-4 py-2 text-sm hover:bg-surface-container-high transition-colors mt-2">Change Avatar</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Name</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                @error('name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @endif
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                                @error('email')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Phone</label>
                            <input type="tel" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            @error('phone')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @endif
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="bg-black text-white px-10 py-4 text-sm tracking-widest uppercase hover:bg-neutral-800 transition-colors">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection