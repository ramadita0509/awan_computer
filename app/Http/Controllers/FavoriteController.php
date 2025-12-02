<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $sessionId = session()->getId();
        $userId = Auth::id();

        // Check if already favorited
        $favorite = Favorite::where('product_id', $productId)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            return response()->json(['status' => 'removed', 'message' => 'Produk dihapus dari favorit']);
        } else {
            // Add to favorites
            Favorite::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $productId,
            ]);
            return response()->json(['status' => 'added', 'message' => 'Produk ditambahkan ke favorit']);
        }
    }

    public function index()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $favorites = Favorite::where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->with('product.category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.favorites', compact('favorites'));
    }

    public function check($productId)
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $isFavorited = Favorite::where('product_id', $productId)
            ->where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->exists();

        return response()->json(['is_favorited' => $isFavorited]);
    }

    public function count()
    {
        $sessionId = session()->getId();
        $userId = Auth::id();

        $count = Favorite::where(function($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->count();

        return response()->json(['count' => $count]);
    }
}
