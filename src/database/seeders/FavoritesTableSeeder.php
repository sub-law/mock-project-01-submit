<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Favorite;

class FavoritesTableSeeder extends Seeder
{
    public function run()
    {
        Favorite::create([
            'user_id' => 1,
            'product_id' => 1,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 2,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 3,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 4,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 5,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 6,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 7,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 8,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 9,
        ]);

        Favorite::create([
            'user_id' => 1,
            'product_id' => 10,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 1,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 2,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 3,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 4,
        ]);

        Favorite::create([
            'user_id' => 2,
            'product_id' => 5,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 1,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 2,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 3,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 4,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 5,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 6,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 7,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 8,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 9,
        ]);

        Favorite::create([
            'user_id' => 3,
            'product_id' => 10,
        ]);

    }
}
