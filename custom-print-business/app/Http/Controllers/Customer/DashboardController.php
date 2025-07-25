<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $recentOrders = Order::where('user_id', $user->id)
            ->with('items')
            ->latest()
            ->limit(5)
            ->get();
            
        return view('customer.dashboard', compact('recentOrders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);
            
        return view('customer.orders.index', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('customer.orders.show', compact('order'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $user->update($request->all());
        
        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }
}
