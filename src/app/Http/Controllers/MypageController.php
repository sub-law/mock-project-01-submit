<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;

class MypageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $sellingProducts = Product::where('seller_id', $user->id)->get();
        $purchasedProducts = Purchase::where('user_id', $user->id)
            ->with('product')
            ->get()
            ->pluck('product');

        return view('mypage.mypage', compact('user', 'sellingProducts', 'purchasedProducts'));
    }
}
