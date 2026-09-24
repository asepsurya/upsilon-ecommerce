@extends("layouts.app")

@section("title")
Contact Us - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-24 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <div class="text-center mb-16">
                    <span class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant">Get in Touch</span>
                    <h1 class="text-4xl md:text-5xl font-headline-md mt-4 mb-6">Contact Us</h1>
                    <div class="w-12 h-px bg-surface-container-lowest mx-auto"></div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-24">
                    <div class="space-y-8">
                        <div>
                            <h3 class="font-headline-md text-xl mb-3">Visit Us</h3>
                            <p class="text-on-surface-variant">Via Monte Napoleone 8<br>Milan, 20121<br>Italy</p>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-xl mb-3">Phone</h3>
                            <a href="tel:+390212345678" class="text-on-surface-variant hover:text-on-surface transition-colors">+39 02 1234 5678</a>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-xl mb-3">Hours</h3>
                            <p class="text-on-surface-variant">Mon - Fri: 9:00 AM - 6:00 PM<br>Sat: 10:00 AM - 4:00 PM<br>Sun: Closed</p>
                        </div>
                    </div>
                    <div class="bg-surface border border-outline-variant/40 p-8">
                        <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                            @csrf
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Your Name</label>
                                <input type="text" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Email</label>
                                <input type="email" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Subject</label>
                                <input type="text" required class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent">
                            </div>
                            <div>
                                <label class="text-sm font-semibold tracking-widest uppercase text-on-surface block mb-2">Message</label>
                                <textarea required rows="5" class="w-full border border-outline-variant/50 px-4 py-3 text-sm focus:outline-none focus:border-outline-variant bg-transparent"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-surface-container-lowest text-tertiary py-4 text-sm tracking-widest uppercase hover:bg-surface-container-low transition-colors duration-300">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection
