@extends("layouts.app")

@section("title")
Profile - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-3xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-12">Profile</h1>
                <div class="bg-surface border border-outline-variant/40">
                    <div class="px-8 py-6 border-b border-outline-variant/40">
                        <h2 class="font-headline-md text-xl">Personal Information</h2>
                    </div>
                    <form method="POST" action="{{ route('account.profile.update') }}" class="p-8 space-y-6">
                        @csrf
                        @method('PATCH')
                        <div class="flex items-center gap-6 mb-8">
                            <div class="w-20 h-20 bg-surface-container flex items-center justify-center">
                                <svg class="w-8 h-8 text-on-surface-variant" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <button type="button" class="border border-outline-variant/50 px-4 py-2 text-sm hover:bg-surface-container-high transition-colors">Change Avatar</button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">First Name</label>
                                <input type="text" value="John" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Last Name</label>
                                <input type="text" value="Doe" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            </div>
                        </div>
                        <div>
                            <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Email</label>
                            <input type="email" value="john@example.com" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>
                        <div>
                            <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Phone</label>
                                <input type="tel" value="+39 02 1234 5678" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>
                        <div class="pt-4">
                            <button type="submit" class="bg-surface-container-lowest text-tertiary px-10 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
@endsection
