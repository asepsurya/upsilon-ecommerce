@extends("layouts.home")

@section("title")
    My Orders - {{ config('app.name', 'Upsilon') }}
@endsection

@section("content")
    <section class="py-12 px-6 md:px-12 lg:px-24">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-3xl md:text-4xl font-headline-md mb-12">My Orders</h1>
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <aside class="lg:col-span-1">
                    @include('account.sidebar')
                </aside>
                <div class="lg:col-span-3">
                    <div class="bg-surface border border-outline-variant/40">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b border-outline-variant/40">
                                    <tr
                                        class="text-left text-xs font-semibold tracking-widest uppercase text-on-surface-variant">
                                        <th class="px-8 py-4">Order</th>
                                        <th class="px-8 py-4">Date</th>
                                        <th class="px-8 py-4">Status</th>
                                        <th class="px-8 py-4">Items</th>
                                        <th class="px-8 py-4 text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/30">
                                    @forelse($orders as $order)
                                        <tr class="hover:bg-background">
                                            <td class="px-8 py-4">
                                                <a href="{{ route('account.order-detail', $order) }}"
                                                    class="font-medium hover:text-on-surface-variant">{{ $order->order_number }}</a>
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
                                            <td class="px-8 py-4 text-on-surface-variant">{{ $order->items->count() }} items
                                            </td>
                                            <td class="px-8 py-4 text-right">{{ currency_format($order->total) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-8 py-12 text-center text-on-surface-variant">
                                                You haven't placed any orders yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection