<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($category)
    {
        // Find category by slug
        $categoryModel = Category::where('slug', $category)
            ->where('is_active', true)
            ->firstOrFail();

        // Get products for this category (newest first)
        $products = Product::where('category_id', $categoryModel->id)
            ->where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.category', [
            'category' => $category,
            'categoryModel' => $categoryModel,
            'products' => $products
        ]);
    }

    public function multiple(Request $request)
    {
        // Get category slugs from query parameter (comma-separated)
        $slugsParam = $request->get('categories', '');

        if (empty($slugsParam)) {
            // If no categories parameter, redirect to all products
            return redirect()->route('products.index');
        }

        $slugs = array_filter(array_map('trim', explode(',', $slugsParam)));

        if (empty($slugs)) {
            return redirect()->route('products.index');
        }

        // Find categories by slugs
        $categories = Category::whereIn('slug', $slugs)
            ->where('is_active', true)
            ->get();

        if ($categories->isEmpty()) {
            // If no categories found, redirect to all products
            return redirect()->route('products.index');
        }

        // Get category IDs
        $categoryIds = $categories->pluck('id')->toArray();

        // Get products from multiple categories (newest first)
        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        // Create a combined category name
        $categoryName = $categories->pluck('name')->join(' & ');

        return view('frontend.category', [
            'category' => implode(',', $slugs),
            'categoryModel' => (object) [
                'name' => $categoryName,
                'slug' => implode(',', $slugs),
                'description' => 'Koleksi ' . $categoryName
            ],
            'products' => $products
        ]);
    }
}
