<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;

class ProductSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_「商品名」で部分一致検索ができる()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $user   = User::factory()->create(['email_verified_at' => now()]);

        $matchProduct = Product::factory()->create([
            'name' => 'Laravel本',
            'seller_id' => $seller->id,
        ]);

        $nonMatchProduct = Product::factory()->create([
            'name' => 'PHP入門',
            'seller_id' => $seller->id,
        ]);

        /** @var \App\Models\User $user */

        $this->actingAs($user);
        $response = $this->get('/search?query=Laravel');

        $response->assertStatus(200);
        $response->assertSee('Laravel本');
        $response->assertDontSee('PHP入門');
    }

    public function test_検索状態がマイリストでも保持されている()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $user   = User::factory()->create(['email_verified_at' => now()]);

        $matchProduct = Product::factory()->create([
            'name' => 'Laravel本',
            'seller_id' => $seller->id,
        ]);

        $nonMatchProduct = Product::factory()->create([
            'name' => 'PHP入門',
            'seller_id' => $seller->id,
        ]);

        Favorite::create(['user_id' => $user->id, 'product_id' => $matchProduct->id,]);

        /** @var \App\Models\User $user */

        $this->actingAs($user);
        $response = $this->get('/search?query=Laravel');
        $response->assertStatus(200);
        $response->assertSee('Laravel本');
        $response->assertDontSee('PHP入門');

        $response = $this->get('/search?tab=mylist&query=Laravel');
        $response->assertStatus(200);
        $response->assertSee('Laravel本');
        $response->assertDontSee('PHP入門');
    }
}
