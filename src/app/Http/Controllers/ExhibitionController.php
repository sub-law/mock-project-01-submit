<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;


class ExhibitionController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('products.sell_form', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $user = auth()->user();

        $data = [
            'seller_id'   => $user->id,
            'name'        => $request->name,
            'brand'       => $request->brand,
            'description' => $request->description,
            'condition'   => $request->condition,
            'price'       => $request->price,
            'status'      => 'available',
        ];

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('products', 'public');
            $data['image_path'] = basename($path);
        }

        $product = Product::create($data);

        $categoryIds = $request->input('category_ids', []);
        $product->categories()->sync($categoryIds);

        return redirect()->route('mypage')->with('status', '商品を出品しました！');
    }
}
