<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;

class MyListIndexTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\CategoriesSeeder::class);
    }

    public function test_いいねした商品だけが表示される()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $favoriteUser = User::factory()->create(['email_verified_at' => now()]);

        $favoriteProduct = Product::factory()->create([
            'name' => 'いいね商品',
            'seller_id' => $seller->id,
        ]);

        $unlikedProduct = Product::factory()->create([
            'name' => '非いいね商品',
            'seller_id' => $seller->id,
        ]);

        Favorite::factory()->create([
            'user_id' => $favoriteUser->id,
            'product_id' => $favoriteProduct->id,
        ]);

        /** @var \App\Models\User $favoriteUser */

        $this->actingAs($favoriteUser);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('いいね商品');
        $response->assertDontSee('非いいね商品');
    }

    public function test_購入済み商品には_Sold_ラベルが表示される()
    {
        $viewer = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $buyer = User::factory()->create(['email_verified_at' => now()]);

        $product = Product::factory()->create([
            'seller_id' => $seller->id,
            'buyer_id' => $buyer->id,
            'status' => 'sold',      
        ]);

        Favorite::factory()->create([
            'user_id' => $viewer->id,
            'product_id' => $product->id,
        ]);

        /** @var \App\Models\User $viewer */
        $this->actingAs($viewer);
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('Sold');
    }

    public function test_未認証の場合は何も表示されない()
    {
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);
        $response->assertSee('マイリスト機能を利用するにはログインしてください。');
    }
}
