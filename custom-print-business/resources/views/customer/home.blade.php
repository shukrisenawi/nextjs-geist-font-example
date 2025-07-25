@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-gray-900 to-gray-700 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">Custom Printing Solutions</h1>
                <p class="text-xl mb-8 text-gray-300">High-quality custom prints for your business and personal needs</p>
                <div class="space-x-4">
                    <a href="{{ route('products.index') }}" class="bg-white text-gray-900 px-8 py-3 rounded-md font-semibold hover:bg-gray-100">
                        Browse Products
                    </a>
                    <a href="#featured" class="border border-white text-white px-8 py-3 rounded-md font-semibold hover:bg-white hover:text-gray-900">
                        View Featured
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Popular Categories</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($categories as $category)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $category->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($category->description, 100) }}</p>
                            <a href="{{ route('products.category', $category) }}" class="text-gray-900 font-semibold hover:underline">
                                View Products →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="featured" class="py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-4xl text-gray-400"></i>
                        </div>
                        <div class="p-4">
                            <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 50) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                                <a href="{{ route('products.show', $product) }}" class="bg-gray-900 text-white px-4 py-2 rounded-md hover:bg-gray-800">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('products.index') }}" class="bg-gray-900 text-white px-8 py-3 rounded-md font-semibold hover:bg-gray-800">
                    View All Products
                </a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Start Your Custom Print Project?</h2>
            <p class="text-xl mb-8 text-gray-300">Get high-quality prints delivered to your doorstep</p>
            <a href="{{ route('products.index') }}" class="bg-white text-gray-900 px-8 py-3 rounded-md font-semibold hover:bg-gray-100">
                Get Started Now
            </a>
        </div>
    </section>
@endsection
