@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

        <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            @csrf
            
            <!-- Customer Information -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-md rounded-lg">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold">Customer Information</h2>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <div>
                            <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="customer_name" id="customer_name" 
                                   value="{{ old('customer_name', auth()->user()->name ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                            @error('customer_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="customer_email" id="customer_email" 
                                   value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                            @error('customer_email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="customer_phone" id="customer_phone" 
                                   value="{{ old('customer_phone') }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">
                            @error('customer_phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="customer_address" class="block text-sm font-medium text-gray-700">Shipping Address</label>
                            <textarea name="customer_address" id="customer_address" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">{{ old('customer_address') }}</textarea>
                            @error('customer_address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                            <textarea name="notes" id="notes" rows="3" 
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white shadow-md rounded-lg mt-6">
                    <div class="px-6 py-4 border-b">
                        <h2 class="text-lg font-semibold">Payment Information</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-2"></i>
                                Payment will be processed securely. You'll receive payment instructions after order confirmation.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-lg font-semibold mb-4">Order Summary</h2>
                    
                    <div class="space-y-4">
                        @php
                            $subtotal = 0;
                        @endphp
                        
                        @foreach(session('cart', []) as $id => $item)
                            @php
                                $product = \App\Models\Product::find($id);
                                if($product) {
                                    $itemTotal = $product->base_price * $item['quantity'];
                                    $subtotal += $itemTotal;
                                }
                            @endphp
                            
                            @if($product)
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-medium">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                    </div>
                                    <p class="font-medium">RM {{ number_format($itemTotal, 2) }}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    
                    @php
                        $tax = $subtotal * 0.06;
                        $shipping = 10.00;
                        $total = $subtotal + $tax + $shipping;
                    @endphp
                    
                    <div class="border-t mt-4 pt-4 space-y-2">
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
                        <div class="border-t pt-2 flex justify-between font-semibold text-lg">
                            <span>Total</span>
                            <span>RM {{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="mt-6 w-full bg-gray-900 text-white py-3 px-4 rounded-md hover:bg-gray-800 flex items-center justify-center">
                        <i class="fas fa-lock mr-2"></i>
                        Place Order
                    </button>
                    
                    <p class="text-xs text-gray-500 mt-4 text-center">
                        By placing this order, you agree to our terms and conditions.
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection
