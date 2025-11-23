<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Purchase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $product = Product::factory()->create(['seller_id' => $user->id]);
        $purchasedProduct = Product::factory()->create(['seller_id' => $seller->id]); 
        Purchase::factory()->create([
            'user_id'    => $user->id,          
            'product_id' => $purchasedProduct->id,
            'payment_method' => 'convenience',
        ]);

        /** @var \App\Models\User $user */

        $this->actingAs($user);

        $response = $this->get("/mypage");

        $response->assertStatus(200);
        $response->assertSee($user->profile_image);
        $response->assertSeeText($user->name);                
        $response->assertSeeText($product->name);
        $response->assertSee($product->image_path);
        $response->assertSeeText($purchasedProduct->name);
        $response->assertSee($purchasedProduct->image_path);
    }

    public function test_変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
            'profile_image' => 'profile.png',
            'name' => 'テストユーザー',
            'postal_code' => '123-4567',
            'address' => '東京都',
        ]);

        /** @var \App\Models\User $user */

        $this->actingAs($user);

        $response = $this->get("/mypage/profile");
        $response->assertStatus(200);
        $response->assertSee($user->profile_image);
        $response->assertSee($user->name);
        $response->assertSee($user->postal_code);
        $response->assertSee($user->address);
    }
}
