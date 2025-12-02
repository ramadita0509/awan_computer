<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        // Get all active categories for filter
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Start building query
        $query = Product::where('is_active', true)
            ->with('category');

        // Filter by category
        if ($request->has('category') && $request->category != 'all') {
            $category = Category::where('slug', $request->category)
                ->where('is_active', true)
                ->first();

            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by brand (extract from product name)
        if ($request->has('brand') && !empty($request->brand)) {
            $brands = is_array($request->brand) ? $request->brand : [$request->brand];
            $brands = array_filter($brands);
            if (!empty($brands)) {
                $query->where(function($q) use ($brands) {
                    foreach ($brands as $brand) {
                        $q->orWhere('name', 'like', '%' . $brand . '%');
                    }
                });
            }
        }

        // Filter by price range
        if ($request->has('min_price') && !empty($request->min_price)) {
            $query->where('price', '>=', str_replace('.', '', $request->min_price));
        }
        if ($request->has('max_price') && !empty($request->max_price)) {
            $query->where('price', '<=', str_replace('.', '', $request->max_price));
        }

        // Filter by discount
        if ($request->has('discount') && $request->discount == 'yes') {
            $query->whereNotNull('original_price')
                  ->whereRaw('original_price > price');
        }

        // Filter by featured
        if ($request->has('featured') && $request->featured == 'yes') {
            $query->where('is_featured', true);
        }

        // Filter by stock
        if ($request->has('stock') && $request->stock == 'in_stock') {
            $query->where('stock', '>', 0);
        }

        // Sort products
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Get unique brands from product names (extract common brands)
        $allProducts = Product::where('is_active', true)->pluck('name');
        $brands = [];
        $commonBrands = ['ASUS', 'Acer', 'HP', 'Lenovo', 'Dell', 'MSI', 'Apple', 'Samsung', 'Logitech', 'Razer', 'Corsair', 'SteelSeries'];
        foreach ($commonBrands as $brand) {
            if ($allProducts->filter(function($name) use ($brand) {
                return stripos($name, $brand) !== false;
            })->count() > 0) {
                $brands[] = $brand;
            }
        }

        // Paginate results
        $products = $query->paginate(12)->withQueryString();

        // Get price range for filter
        $minPrice = Product::where('is_active', true)->min('price');
        $maxPrice = Product::where('is_active', true)->max('price');

        return view('frontend.katalog', compact(
            'products',
            'categories',
            'brands',
            'minPrice',
            'maxPrice'
        ));
    }
}

