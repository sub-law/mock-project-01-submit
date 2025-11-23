<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class PurchaseController extends Controller
{
    public function showpurchaseform($item_id)
    {
        $product = Product::findOrFail($item_id);
        $user = Auth::user();

        if ($product->is_sold) {
            return redirect()->route('product_show', ['item_id' => $item_id])
                ->with('status', 'この商品はすでに購入されています');
        }

        return view('products.purchase', compact('product', 'user'));
    }

    public function purchaseconfirm(PurchaseRequest $request, $item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        if ($product->buyer_id !== null) {
            return redirect()->route('product_show', ['item_id' => $item_id])
                ->with('error', 'この商品はすでに購入されています');
        }

        if (empty($user->postal_code) || empty($user->address)) {
            return redirect()->route('address_edit', ['item_id' => $item_id])
                ->with('error', '配送先住所が未登録です。先に登録してください。');
        }

        $method = $request->input('payment_method');

        if ($method === 'convenience') {
            
            Purchase::create([
                'user_id' => $user->id,
                'postal_code' => $user->postal_code,
                'address' => $user->address,
                'building_name' => $user->building_name,
                'product_id' => $product->id,
                'payment_method' => 'convenience',
            ]);

            $product->buyer_id = $user->id;
            $product->status = 'sold';
            $product->save();

            return redirect()->route('index')->with('status', '購入が完了しました（コンビニ払い）');
        }

        if ($method === 'credit') {
            
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => ['name' => $product->name],
                        'unit_amount' => (int) $product->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('purchase.success', ['item_id' => $product->id]),
                'cancel_url' => route('purchase.cancel'),
            ]);

            return redirect($session->url);
        }

        return back()->withErrors(['payment_method' => '支払い方法を選択してください']);
    }

    public function success($item_id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($item_id);

        if ($product->buyer_id !== null) {
            return redirect()->route('product_show', ['item_id' => $item_id])
                ->with('status', 'この商品はすでに購入されています');
        }

        Purchase::create([
            'user_id' => $user->id,
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building_name' => $user->building_name,
            'product_id' => $product->id,
            'payment_method' => 'credit',
        ]);

        $product->buyer_id = $user->id;
        $product->status = 'sold';
        $product->save();

        return redirect()->route('index')->with('status', '購入が完了しました（カード支払い）');
    }
}
