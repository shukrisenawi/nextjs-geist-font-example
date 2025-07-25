<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with('category')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->limit(8)
            ->get();
            
        $categories = Category::where('is_active', true)
            ->limit(6)
            ->get();
            
        return view('customer.home', compact('featuredProducts', 'categories'));
    }

    public function about()
    {
        return view('customer.about');
    }

    public function contact()
    {
        return view('customer.contact');
    }
}
