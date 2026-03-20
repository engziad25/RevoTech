<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Get user's cart
        if (Auth::check()) {
            $cart = Cart::with(['items.product'])
                ->where('user_id', Auth::id())
                ->first();
        } else {
            $sessionId = session()->getId();
            $cart = Cart::with(['items.product'])
                ->where('session_id', $sessionId)
                ->first();
        }

        // If cart is empty or doesn't exist, create empty cart object
        if (!$cart || $cart->items->isEmpty()) {
            $cart = new Cart();
            $cart->items = collect();
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_line1' => 'required|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'shipping_method' => 'required|in:standard,express,overnight',
            'payment_method' => 'required|in:credit_card,paypal',
            'notes' => 'nullable|string',
        ]);

        // Get cart
        if (Auth::check()) {
            $cart = Cart::with('items')->where('user_id', Auth::id())->first();
        } else {
            $sessionId = session()->getId();
            $cart = Cart::with('items')->where('session_id', $sessionId)->first();
        }

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = $cart->total;
        $shippingCost = match($request->shipping_method) {
            'express' => 20,
            'overnight' => 30,
            default => 10,
        };
        $tax = $subtotal * 0.1;
        $total = $subtotal + $tax + $shippingCost;

        // Create order
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'shipping' => $shippingCost,
                'total' => $total,
                'status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => json_encode([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address_line1' => $request->address_line1,
                    'address_line2' => $request->address_line2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                ]),
                'billing_address' => json_encode([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'address_line1' => $request->address_line1,
                    'address_line2' => $request->address_line2,
                    'city' => $request->city,
                    'state' => $request->state,
                    'zip_code' => $request->zip_code,
                    'country' => $request->country,
                ]),
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ]);

                // Update product stock
                $item->product->decrement('stock_quantity', $item->quantity);
                $item->product->increment('sales_count', $item->quantity);
            }

            // Clear cart
            $cart->items()->delete();
            $cart->delete();

            DB::commit();

            // Store order ID in session for success page
            session(['last_order' => $order->id]);

            return redirect()->route('checkout.success', $order);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while processing your order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        // Verify that this order belongs to the current user or session
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}