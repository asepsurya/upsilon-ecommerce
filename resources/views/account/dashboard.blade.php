@extends("layouts.home")

@section("title")
    My Account - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-headline-md mb-12">My Account</h1>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    @include('account.sidebar')
                </aside>
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-12">
                        <div class="bg-surface border border-outline-variant/40 p-8">
                            <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant mb-2">Total
                                Orders</p>
                            <p class="text-3xl font-headline-md">{{ $totalOrders }}</p>
                        </div>
                        <div class="bg-surface border border-outline-variant/40 p-8">
                            <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant mb-2">Total
                                Spent</p>
                            <p class="text-3xl font-headline-md">{{ currency_format($totalSpent) }}</p>
                        </div>
                        <div class="bg-surface border border-outline-variant/40 p-8">
                            <p class="text-xs font-semibold tracking-[0.2em] uppercase text-on-surface-variant mb-2">
                                Wishlist Items</p>
                            <p class="text-3xl font-headline-md">{{ $wishlistCount }}</p>
                        </div>
                    </div>

                    <div class="bg-surface border border-outline-variant/40">
                        <div class="px-8 py-6 border-b border-outline-variant/40">
                            <h2 class="font-headline-md text-xl">Recent Orders</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b border-outline-variant/40">
                                    <tr
                                        class="text-left text-xs font-semibold tracking-widest uppercase text-on-surface-variant">
                                        <th class="px-8 py-4">Order</th>
                                        <th class="px-8 py-4">Date</th>
                                        <th class="px-8 py-4">Status</th>
                                        <th class="px-8 py-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/30">
                                    @forelse($recentOrders as $order)
                                        <tr class="hover:bg-background">
                                            <td class="px-8 py-4 font-medium">
                                                <a href="{{ route('account.order-detail', $order) }}" class="hover:text-on-surface-variant">{{ $order->order_number }}</a>
                                            </td>
                                            <td class="px-8 py-4 text-on-surface-variant">
                                                {{ $order->created_at->format('M d, Y') }}
                                            </td>
                                            <td class="px-8 py-4">
                                                @php
                                                    $statusClasses = [
                                                        'pending' => 'bg-surface-container text-on-surface',
                                                        'paid' => 'bg-blue-100 text-blue-900',
                                                        'processing' => 'bg-yellow-100 text-yellow-900',
                                                        'shipped' => 'bg-purple-100 text-purple-900',
                                                        'delivered' => 'bg-green-100 text-green-900',
                                                        'cancelled' => 'bg-red-100 text-red-900',
                                                    ];
                                                @endphp
                                                <span
                                                    class="inline-block {{ $statusClasses[$order->status] ?? 'bg-surface-container text-on-surface' }} text-xs px-2 py-1 tracking-wider uppercase">{{ $order->status }}</span>
                                            </td>
                                            <td class="px-8 py-4 text-right">{{ currency_format($order->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-8 py-12 text-center text-on-surface-variant">
                                                You haven't placed any orders yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="px-8 py-4 border-t border-outline-variant/40">
                            <a href="{{ route('account.orders') }}"
                                class="text-sm text-on-surface-variant hover:text-on-surface">View all orders</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection