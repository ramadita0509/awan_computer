<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // Get all active products (newest first)
        $products = Product::where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('frontend.products', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with(['category', 'images'])
            ->firstOrFail();

        // Get related products (same category, exclude current product)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->with('category')
            ->limit(4)
            ->get();

        return view('frontend.product-detail', compact('product', 'relatedProducts'));
    }
}

