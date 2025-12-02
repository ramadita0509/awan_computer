<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $total = 0;
        $totalItems = 0;

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

        return view('frontend.cart', compact('cartItems', 'total', 'totalItems'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $request->input('quantity', 1);
        } else {
            $cart[$productId] = [
                'quantity' => $request->input('quantity', 1)
            ];
        }

        Session::put('cart', $cart);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk ditambahkan ke keranjang',
                'cart_count' => $this->getCartCount()
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function update(Request $request, $productId)
    {
        $cart = Session::get('cart', []);
        $quantity = $request->input('quantity', 1);

        if ($quantity <= 0) {
            return $this->remove($productId);
        }

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cart_count' => $this->getCartCount(),
                'cart_total' => $this->getCartTotal()
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui');
    }

    public function remove($productId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk dihapus dari keranjang',
                'cart_count' => $this->getCartCount(),
                'cart_total' => $this->getCartTotal()
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produk dihapus dari keranjang');
    }

    public function count()
    {
        return response()->json(['count' => $this->getCartCount()]);
    }

    private function getCartCount()
    {
        $cart = Session::get('cart', []);
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    private function getCartTotal()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $item['quantity'];
            }
        }
        return $total;
    }
}
