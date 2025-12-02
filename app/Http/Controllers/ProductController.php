<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('sort_order')->orderBy('name')->get();
        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('backend.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|string|max:255|url',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'original_price' => 'required|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Convert original_price from formatted string to numeric
        $originalPrice = str_replace('.', '', $validated['original_price']);
        $originalPrice = floatval($originalPrice);

        // Calculate final price based on discount
        $discount = floatval($validated['discount'] ?? 0);
        $finalPrice = $originalPrice - ($originalPrice * $discount / 100);

        $validated['price'] = $finalPrice;
        $validated['original_price'] = $originalPrice;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->image_url;
        }

        // Remove image_url and discount from validated as they're not in the database
        unset($validated['image_url']);
        unset($validated['discount']);

        $product = Product::create($validated);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/storage/' . $imagePath,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('backend.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        $product->load('images');
        return view('backend.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|string|max:255|url',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'nullable|integer|exists:product_images,id',
            'original_price' => 'required|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'stock' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Convert original_price from formatted string to numeric
        $originalPrice = str_replace('.', '', $validated['original_price']);
        $originalPrice = floatval($originalPrice);

        // Calculate final price based on discount
        $discount = floatval($validated['discount'] ?? 0);
        $finalPrice = $originalPrice - ($originalPrice * $discount / 100);

        $validated['price'] = $finalPrice;
        $validated['original_price'] = $originalPrice;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && strpos($product->image, '/storage/') !== false) {
                $oldImage = str_replace('/storage/', '', $product->image);
                Storage::disk('public')->delete($oldImage);
            }

            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = '/storage/' . $imagePath;
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->image_url;
        } else {
            // Keep existing image if no new image or URL provided
            $validated['image'] = $product->image;
        }

        // Remove image_url and discount from validated as they're not in the database
        unset($validated['image_url']);
        unset($validated['discount']);

        $product->update($validated);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            $maxSortOrder = $product->images()->max('sort_order') ?? -1;
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => '/storage/' . $imagePath,
                    'sort_order' => ++$maxSortOrder,
                ]);
            }
        }

        // Handle image deletion
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $productImage = ProductImage::find($imageId);
                if ($productImage) {
                    if (strpos($productImage->image_path, '/storage/') !== false) {
                        Storage::disk('public')->delete(str_replace('/storage/', '', $productImage->image_path));
                    }
                    $productImage->delete();
                }
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete main image if it was a local upload
        if ($product->image && strpos($product->image, '/storage/') !== false) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $product->image));
        }

        // Delete all product images
        foreach ($product->images as $image) {
            if (strpos($image->image_path, '/storage/') !== false) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $image->image_path));
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
