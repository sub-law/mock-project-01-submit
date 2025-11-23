<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Favorite;
use App\Models\Comment;
use App\Models\Category;

class ProductShowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\CategoriesSeeder::class);
    }

    public function test_必要な情報が表示される()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $favoriteUser = User::factory()->create(['email_verified_at' => now()]);
        $commentUser = User::factory()->create([
            'name' => 'コメント者',
            'email_verified_at' => now()
        ]);
        $viewer = User::factory()->create(['email_verified_at' => now()]);

        $showProduct = Product::factory()->create([
            'seller_id' => $seller->id,
            'name' => '商品',
            'brand' => 'ノーブランド',
            'description' => 'それなりの品物',
            'image_path' => 'aaa.jpg',
            'condition' => '良好',
            'price' => 15000,
            'status' => 'available',
        ]);

        $category = Category::where('name', 'ファッション')->first();
        $showProduct->categories()->sync([$category->id]);

        Favorite::factory()->create([
            'user_id' => $favoriteUser->id,
            'product_id' => $showProduct->id,
        ]);

        Comment::factory()->create([
            'user_id' => $commentUser->id,
            'product_id' => $showProduct->id,
            'content' => '古着',
        ]);

        /** @var \App\Models\User $viewer */

        $this->actingAs($viewer);
        $response = $this->get("/item/{$showProduct->id}");

        $response->assertStatus(200);
        $response->assertSee('商品');
        $response->assertSee('ノーブランド');
        $response->assertSee('それなりの品物');
        $response->assertSee('aaa.jpg');
        $response->assertSee('ファッション');
        $response->assertSee('良好');
        $response->assertSee('¥15,000');
        $response->assertSee('<span class="action-count">1</span>', false);
        $response->assertSee('コメント（1）');
        $response->assertSee('コメント者');
        $response->assertSee('古着');
        $this->assertStringContainsString('<img', $response->getContent());
    }

    public function test_複数選択されたカテゴリが表示されているか()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $viewer = User::factory()->create(['email_verified_at' => now()]);

        $showProduct = Product::factory()->create([
            'seller_id' => $seller->id,
        ]);

        $categories = Category::whereIn('name', ['ファッション', 'アクセサリー'])->get();
        $showProduct->categories()->sync($categories->pluck('id'));

        /** @var \App\Models\User $viewer */

        $this->actingAs($viewer);
        $response = $this->get("/item/{$showProduct->id}");

        $response->assertStatus(200);
        $response->assertSee('ファッション');
        $response->assertSee('アクセサリー');
    }
}
