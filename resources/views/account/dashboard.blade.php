@extends("layouts.app")

@section("title")
My Account - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
<section class="py-12 px-6 md:px-12 lg:px-24">
            <div class="max-w-7xl mx-auto">
                <h1 class="text-3xl md:text-4xl font-headline-md mb-12">My Account</h1>
                <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                    <aside class="lg:col-span-1">
                        <nav class="space-y-1">
                            <a href="{{ route('account.dashboard') }}" class="block px-4 py-3 bg-surface-container-lowest text-tertiary text-sm tracking-wider">Dashboard</a>
                            <a href="{{ route('account.orders') }}" class="block px-4 py-3 border border-outline-variant/40 text-sm hover:bg-surface-container-high transition-colors">Orders</a>
                            <a href="{{ route('account.profile') }}" class="block px-4 py-3 border border-outline-variant/40 text-sm hover:bg-surface-container-high transition-colors">Profile</a>
                            <a href="{{ route('account.addresses') }}" class="block px-4 py-3 border border-outline-variant/40 text-sm hover:bg-surface-container-high transition-colors">Addresses</a>
                            <a href="{{ route('wishlist') }}" class="block px-4 py-3 border border-outline-variant/40 text-sm hover:bg-surface-container-high transition-colors">Wishlist</a>
                        </nav>
                    </aside>
                    <div class="lg:col-span-3">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
                            <div class="bg-surface border border-outline-variant/40 p-8">
                                <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant mb-2">Total Orders</p>
                                <p class="text-3xl font-headline-md">24</p>
                            </div>
                            <div class="bg-surface border border-outline-variant/40 p-8">
                                <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant mb-2">Total Spent</p>
                                <p class="text-3xl font-headline-md">$ 12.4M</p>
                            </div>
                            <div class="bg-surface border border-outline-variant/40 p-8">
                                <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant mb-2">Wishlist Items</p>
                                <p class="text-3xl font-headline-md">8</p>
                            </div>
                        </div>

                        <div class="bg-surface border border-outline-variant/40">
                            <div class="px-8 py-6 border-b border-outline-variant/40">
                                <h2 class="font-headline-md text-xl">Recent Orders</h2>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="border-b border-outline-variant/40">
                                        <tr class="text-left text-xs font-semibold tracking-widest uppercase text-on-surface-variant">
                                            <th class="px-8 py-4">Order</th>
                                            <th class="px-8 py-4">Date</th>
                                            <th class="px-8 py-4">Status</th>
                                            <th class="px-8 py-4 text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-outline-variant/30">
                                        <tr class="hover:bg-background">
                                            <td class="px-8 py-4 font-medium">#ORD-001</td>
                                            <td class="px-8 py-4 text-on-surface-variant">Sep 8, 2026</td>
                                            <td class="px-8 py-4"><span class="inline-block bg-surface-container-lowest text-tertiary text-xs px-2 py-1 tracking-wider uppercase">Processing</span></td>
                                            <td class="px-8 py-4 text-right">$ 1,250,000</td>
                                        </tr>
                                        <tr class="hover:bg-background">
                                            <td class="px-8 py-4 font-medium">#ORD-002</td>
                                            <td class="px-8 py-4 text-on-surface-variant">Sep 1, 2026</td>
                                            <td class="px-8 py-4"><span class="inline-block bg-surface-container text-on-surface text-xs px-2 py-1 tracking-wider uppercase">Shipped</span></td>
                                            <td class="px-8 py-4 text-right">$ 890,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="px-8 py-4 border-t border-outline-variant/40">
                                <a href="{{ route('account.orders') }}" class="text-sm text-on-surface-variant hover:text-on-surface">View all orders</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
@endsection
