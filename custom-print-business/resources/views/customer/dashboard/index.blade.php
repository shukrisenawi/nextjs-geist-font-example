@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
            @if($recentOrders->count() > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach($recentOrders as $order)
                        <li class="py-2">
                            <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline">
                                {{ $order->order_number }} - {{ $order->created_at->format('d M Y') }} - <span class="capitalize">{{ $order->status }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>You have no recent orders.</p>
            @endif
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Account Information</h2>
            <p>Name: {{ auth()->user()->name }}</p>
            <p>Email: {{ auth()->user()->email }}</p>
            <a href="{{ route('profile') }}" class="text-blue-600 hover:underline mt-2 inline-block">Edit Profile</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Quick Links</h2>
            <ul class="list-disc list-inside space-y-2">
                <li><a href="{{ route('orders.index') }}" class="text-blue-600 hover:underline">View Orders</a></li>
                <li><a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Browse Products</a></li>
                <li><a href="{{ route('cart.index') }}" class="text-blue-600 hover:underline">View Cart</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
