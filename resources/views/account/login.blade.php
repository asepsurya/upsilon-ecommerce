@extends("layouts.app")

@section("title")
Login - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-md mx-auto">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-8">Login</h1>

                @if ($errors->any())
                    <div class="bg-error-container text-on-error-container px-4 py-3 mb-6">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="bg-surface border border-outline-variant/40">
                    <form method="POST" action="{{ route('login') }}" class="p-8 space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>

                        <div>
                            <label for="password" class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Password</label>
                            <input id="password" type="password" name="password" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="remember" class="border-outline-variant/50 bg-transparent">
                                <span class="text-sm text-on-surface-variant">Remember me</span>
                            </label>

                            <a href="#" class="text-sm text-primary hover:underline">Forgot password?</a>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="bg-surface-container-lowest text-tertiary px-10 py-4 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300 w-full">Login</button>
                        </div>

                        <p class="text-sm text-on-surface-variant text-center pt-4">
                            Don't have an account? <a href="{{ route('register') }}" class="text-primary hover:underline">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </section>
@endsection
