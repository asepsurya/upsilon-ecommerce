@extends("layouts.app")

@section("title")
Register - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-md mx-auto">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-8">Register</h1>

                @if ($errors->any())
                    <div class="bg-error-container text-on-error-container px-4 py-3 mb-6">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="bg-surface border border-outline-variant/40">
                    <form method="POST" action="{{ route('register') }}" class="p-8 space-y-6">
                        @csrf

                        <div>
                            <label for="name" class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>

                        <div>
                            <label for="email" class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>

                        <div>
                            <label for="phone" class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Phone</label>
                            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>

                        <div>
                            <label for="password" class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Password</label>
                            <input id="password" type="password" name="password" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>

                        <div>
                            <label for="password_confirmation" class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Confirm Password</label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="bg-surface-container-lowest text-tertiary px-10 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300 w-full">Register</button>
                        </div>

                        <p class="text-sm text-on-surface-variant text-center pt-4">
                            Already have an account? <a href="{{ route('login') }}" class="text-primary hover:underline">Login</a>
                        </p>
                    </form>
                </div>
            </div>
        </section>
@endsection
