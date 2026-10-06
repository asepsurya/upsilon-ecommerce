@extends('layouts.app')

@section('content')
<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md mx-auto space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-bold text-navy">Track Your Order</h2>
            <p class="mt-2 text-center text-sm text-navy/60">Enter your order details to track your shipment</p>
        </div>
        
        @if(session('success'))
            <div class="bg-green-50 text-green-800 p-4 rounded-lg text-sm" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 text-red-800 p-4 rounded-lg text-sm" role="alert">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form class="mt-8 space-y-6" method="POST" action="{{ route('track.order.submit') }}">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="order_number" class="sr-only">Order Number</label>
                    <input id="order_number" name="order_number" type="text" required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                        placeholder="Order Number (e.g. ORD-2024-001234)"
                        value="{{ old('order_number') }}">
                </div>
                
                <div>
                    <label for="email" class="sr-only">Email Address</label>
                    <input id="email" name="email" type="email" required
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
                        placeholder="Email Address"
                        value="{{ old('email') }}">
                </div>
            </div>

            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-navy hover:bg-navy/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Track Order
                </button>
            </div>
        </form>

        <div class="text-center">
            <p class="text-sm text-navy/60">
                Don't have an order number? 
                <a href="{{ route('contact') }}" class="font-medium text-primary hover:text-primary/80">Contact us</a>
            </p>
        </div>
    </div>
</div>
@endsection