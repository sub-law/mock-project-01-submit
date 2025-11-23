<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');

        if ($tab === 'mylist' && auth()->check()) {
            $user = auth()->user();

            $products = $user->favorites
                ->map(function ($favorite) {
                    return $favorite->product;
                })
                ->filter(function ($product) use ($user) {
                    return $product && $product->seller_id !== $user->id;
                })
                ->values();
        } else {
            $products = Product::when(auth()->check(), function ($query) {
                $query->where('seller_id', '!=', auth()->id());
            })->get();
        }

        return view('products.index', compact('products'));
    }

    public function show($item_id, Request $request)
    {
        $product = Product::with(['favorites', 'comments', 'seller', 'categories'])->findOrFail($item_id);

        $isFavorited = false;
        $isOwner = Auth::check() && Auth::id() === $product->seller_id;
        $isFromMypage = $request->query('from') === 'mypage';
        $isReadonly = $isOwner || $isFromMypage;

        if (Auth::check()) {
            $isFavorited = $product->favorites->contains('user_id', Auth::id());
        }

        return view('products.product_show', compact('product', 'isFavorited', 'isReadonly'));
    }

    public function showpurchaseform($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user();

        if ($product->status === 'sold') {
            return redirect()->route('product_show', ['item_id' => $item_id])
                ->with('status', 'この商品はすでに購入されています');
        }

        return view('products.purchase', compact('product', 'user'));
    }
}
