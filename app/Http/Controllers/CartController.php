<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected function getCart()
    {
        if (Auth::check()) {
            $cart = Cart::firstOrCreate([
                'user_id' => Auth::id()
            ]);
        } else {
            $sessionId = session()->getId();
            $cart = Cart::firstOrCreate([
                'session_id' => $sessionId
            ]);
        }

        return $cart->load('items.product');
    }

    public function index()
    {
        $cart = $this->getCart();
        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity
        ]);

        $cart = $this->getCart();
        
        $cartItem = $cart->items()->where('product_id', $product->id)->first();
        
        if ($cartItem) {
            // Update quantity if product already in cart
            $newQuantity = $cartItem->quantity + $request->quantity;
            if ($newQuantity <= $product->stock_quantity) {
                $cartItem->update([
                    'quantity' => $newQuantity,
                    'price' => $product->price
                ]);
            }
        } else {
            // Add new item to cart
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price' => $product->price,
                'subtotal' => $product->price * $request->quantity
            ]);
        }

        $cart->load('items.product');
        $cart->updateTotal();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product added to cart',
                'cart' => $cart,
                'cart_count' => $cart->items_count,
                'cart_total' => $cart->total
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->product->stock_quantity
        ]);

        $item->update([
            'quantity' => $request->quantity
        ]);

        if ($request->wantsJson()) {
            $cart = $item->cart->load('items.product');
            
            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'cart' => $cart,
                'item_total' => $item->subtotal,
                'cart_total' => $cart->total
            ]);
        }

        return redirect()->back()->with('success', 'Cart updated');
    }

    public function remove(Request $request, CartItem $item)
    {
        $cart = $item->cart;
        $item->delete();

        if ($request->wantsJson()) {
            $cart->load('items.product');
            
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart' => $cart,
                'cart_total' => $cart->total,
                'cart_count' => $cart->items_count
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function clear(Request $request)
    {
        $cart = $this->getCart();
        $cart->items()->delete();
        $cart->updateTotal();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart cleared'
            ]);
        }

        return redirect()->back()->with('success', 'Cart cleared');
    }

    public function getCount()
    {
        $cart = $this->getCart();
        
        return response()->json([
            'count' => $cart->items_count
        ]);
    }
}