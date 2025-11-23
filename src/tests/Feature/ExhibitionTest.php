<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\CategoriesSeeder::class);
    }

    public function test_商品出品画面にて必要な情報が保存できること（カテゴリ、商品の状態、商品名、ブランド名、商品の説明、販売価格）()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);

        /** @var \App\Models\User $seller */

        $this->actingAs($seller);

        $response = $this->get('/sell');
        $response->assertStatus(200);

        $response = $this->post('/sell', [
            'name' => '商品',
            'brand' => 'ノーブランド',
            'description' => 'それなりの品物',
            'category_ids' => [1],
            'image_path' => UploadedFile::fake()->create('aaa.jpg', 100),
            'condition' => '良好',
            'price' => 15000,
            'status' => 'available',
        ]);
        $response->assertStatus(302);

        $product = \App\Models\Product::first();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'seller_id' => $seller->id,
            'brand' => 'ノーブランド',
            'description' => 'それなりの品物',
            'condition' => '良好',
            'price' => 15000,
            'status' => 'available',
        ]);

        $this->assertDatabaseHas('category_product', [
            'product_id' => $product->id,
            'category_id' => 1,
        ]);

        $this->assertNotNull($product->image_path);
    }
}
