<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;


class ProductFavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_いいねアイコンを押下することによって、いいねした商品として登録することができる。()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);

        $product = Product::factory()->create([
            'seller_id' => $seller->id,
        ]);

        /** @var \App\Models\User $user */
       
        $this->actingAs($user);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">0</span>', false);

        $this->post('/favorite/toggle', ['product_id' => $product->id]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">1</span>', false);
    }

    public function test_追加済みのアイコンは色が変化する()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
        ]);

        /** @var \App\Models\User $user */

        $this->actingAs($user);

        $response = $this->get("/item/{$product->id}");
        $response->assertDontSee('like-button liked');
        $response->assertSee('images/heart.png');

        $this->post('/favorite/toggle', ['product_id' => $product->id]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('like-button liked');
        $response->assertSee('images/heart.on.png');
    }

    public function test_再度いいねアイコンを押下することによって、いいねを解除することができる。()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
        ]);

        /** @var \App\Models\User $user */

        $this->actingAs($user);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">0</span>', false);

        $this->post('/favorite/toggle', ['product_id' => $product->id]);
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">1</span>', false);

        $this->post('/favorite/toggle', ['product_id' => $product->id]);
        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'product_id' => $product->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">0</span>', false);
    }
}
