@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Shopping Cart</h1>

        @if(session('cart') && count(session('cart')) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-md rounded-lg">
                        <div class="px-6 py-4 border-b">
                            <h2 class="text-lg font-semibold">Cart Items</h2>
                        </div>
                        
                        <div class="divide-y divide-gray-200">
                            @php
                                $subtotal = 0;
                            @endphp
                            
                            @foreach(session('cart') as $id => $item)
                                @php
                                    $product = \App\Models\Product::find($id);
                                    if($product) {
                                        $itemTotal = $product->base_price * $item['quantity'];
                                        $subtotal += $itemTotal;
                                    }
                                @endphp
                                
                                @if($product)
                                    <div class="p-6 flex items-center">
                                        <div class="flex-shrink-0 w-24 h-24 bg-gray-200 rounded-md flex items-center justify-center">
                                            <i class="fas fa-image text-2xl text-gray-400"></i>
                                        </div>
                                        
                                        <div class="ml-6 flex-1">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                                            <p class="text-gray-500">RM {{ number_format($product->base_price, 2) }} each</p>
                                            
                                            <div class="mt-2 flex items-center">
                                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" name="action" value="decrease" class="px-2 py-1 border rounded-l-md hover:bg-gray-100">
                                                        <i class="fas fa-minus text-sm"></i>
                                                    </button>
                                                    <span class="px-4 py-1 border-t border-b">{{ $item['quantity'] }}</span>
                                                    <button type="submit" name="action" value="increase" class="px-2 py-1 border rounded-r-md hover:bg-gray-100">
                                                        <i class="fas fa-plus text-sm"></i>
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('cart.remove', $id) }}" method="POST" class="ml-4">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <p class="text-lg font-medium text-gray-900">RM {{ number_format($itemTotal, 2) }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                        
                        @php
                            $tax = $subtotal * 0.06;
                            $shipping = 10.00;
                            $total = $subtotal + $tax + $shipping;
                        @endphp
                        
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>RM {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tax</span>
                                <span>RM {{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Shipping</span>
                                <span>RM {{ number_format($shipping, 2) }}</span>
                            </div>
                            <div class="border-t pt-2 flex justify-between font-semibold">
                                <span>Total</span>
                                <span>RM {{ number_format($total, 2) }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="mt-6 w-full bg-gray-900 text-white py-3 px-4 rounded-md hover:bg-gray-800 flex items-center justify-center">
                            <i class="fas fa-lock mr-2"></i>
                            Proceed to Checkout
                        </a>
                        
                        <a href="{{ route('products.index') }}" class="mt-3 w-full border border-gray-300 text-gray-700 py-3 px-4 rounded-md hover:bg-gray-50 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Continue Shopping
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Add some products to get started!</p>
                <a href="{{ route('products.index') }}" class="bg-gray-900 text-white px-6 py-3 rounded-md hover:bg-gray-800">
                    Browse Products
                </a>
            </div>
        @endif
    </div>
@endsection
