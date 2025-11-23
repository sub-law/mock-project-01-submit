<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;

class PurchasesTableSeeder extends Seeder
{
    public function run()
    {
        $user = User::find(2);

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => 1,
            'payment_method' => 'credit',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building_name' => $user->building_name,
        ]);

        $product = Product::find(1);
        $product->buyer_id = $user->id;
        $product->status = 'sold';
        $product->save();
    }
}
