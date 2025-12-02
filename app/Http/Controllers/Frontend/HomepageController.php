<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        // Get all active categories
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Get latest active products (newest first) - Produk Terlaris
        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->limit(9)
            ->get();

        // Get promo products (products with discount > 15% or featured) - Promo Minggu Ini
        $promoProducts = Product::where('is_active', true)
            ->with('category')
            ->where(function($query) {
                $query->where('is_featured', true)
                      ->orWhere(function($q) {
                          $q->whereNotNull('original_price')
                            ->whereRaw('original_price > price')
                            ->whereRaw('((original_price - price) / original_price * 100) > 15');
                      });
            })
            ->orderBy('created_at', 'desc')
            ->limit(9)
            ->get();

        return view('frontend.homepage', compact('categories', 'products', 'promoProducts'));
    }
}
