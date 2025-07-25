<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'price' => $product->base_price,
                    'total' => $product->base_price * $item['quantity']
                ];
                $subtotal += $product->base_price * $item['quantity'];
            }
        }

        $tax = $subtotal * 0.06; // 6% tax
        $shipping = 10.00; // Fixed shipping fee
        $total = $subtotal + $tax + $shipping;

        return view('customer.checkout.index', compact('cartItems', 'subtotal', 'tax', 'shipping', 'total'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        DB::beginTransaction();

        try {
            $subtotal = 0;
            $cartItems = [];

            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                if ($product) {
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $product->base_price,
                        'total' => $product->base_price * $item['quantity']
                    ];
                    $subtotal += $product->base_price * $item['quantity'];
                }
            }

            $tax = $subtotal * 0.06;
            $shipping = 10.00;
            $total = $subtotal + $tax + $shipping;

            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_fee' => $shipping,
                'total_amount' => $total,
                'status' => 'pending',
                'customer_remarks' => $request->notes,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['total'],
                ]);
            }

            // Clear cart
            session()->forget('cart');

            // Send confirmation email
            Mail::to($order->customer_email)->send(new \App\Mail\OrderConfirmation($order));

            DB::commit();

            return redirect()->route('checkout.success', $order)->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Error processing order. Please try again.');
        }
    }

    /**
     * Display order success page
     */
    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        return view('customer.checkout.success', compact('order'));
    }
}
