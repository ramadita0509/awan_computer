<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        $cartItems = [];
        $total = 0;
        $totalItems = 0;
        $shipping = 50000; // Fixed shipping cost for Kurir Toko

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $itemTotal = $product->price * $item['quantity'];
                $total += $itemTotal;
                $totalItems += $item['quantity'];

                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemTotal
                ];
            }
        }

        $grandTotal = $total + $shipping;

        return view('frontend.checkout', compact('cartItems', 'total', 'totalItems', 'shipping', 'grandTotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'payment_method' => 'required|in:bank,cod,ewallet',
            'proof_of_payment' => 'required_if:payment_method,bank|nullable|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }

        // Fixed shipping cost for Kurir Toko
        $shipping = 50000;

        // Handle proof of payment upload
        $proofOfPaymentPath = null;
        if ($request->payment_method === 'bank' && $request->hasFile('proof_of_payment')) {
            $proofOfPaymentPath = $request->file('proof_of_payment')->store('proof_of_payments', 'public');
        }

        // Create order
        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'payment_method' => $request->payment_method,
            'proof_of_payment' => $proofOfPaymentPath,
            'courier' => 'kurir_toko',
            'status' => 'pending',
            'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
        ]);

        // Create order items
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $product->price * $item['quantity'],
                ]);
            }
        }

        // Clear cart
        Session::forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Pesanan Anda berhasil diproses!')->with('order_number', $order->order_number);
    }

    public function success()
    {
        return view('frontend.checkout-success');
    }
}
