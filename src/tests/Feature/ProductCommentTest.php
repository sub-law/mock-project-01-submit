<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;


class ProductCommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_ログイン済みのユーザーはコメントを送信できる()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $commentUser = User::factory()->create(['email_verified_at' => now()]);

        $product = Product::factory()->create([
            'seller_id' => $seller->id,
        ]);

        /** @var \App\Models\User $commentUser */

        $this->actingAs($commentUser);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">0</span>', false);

        $response = $this->post('/comments', [
            'product_id' => $product->id,
            'content' => 'テストコメント',
        ]);

        $this->assertDatabaseHas('comments', [
            'user_id' => $commentUser->id,
            'product_id' => $product->id,
            'content' => 'テストコメント',
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">1</span>', false);
    }

    public function test_ログイン前のユーザーはコメントを送信できない()
    {
        $seller = User::factory()->create(['email_verified_at' => now()]);
        $product = Product::factory()->create([
            'seller_id' => $seller->id,
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertStatus(200);

        $response->assertSee('textarea', false);

        $response = $this->post('/comments', [
            'product_id' => $product->id,
            'content' => 'ゲストコメント',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'product_id' => $product->id,
            'content' => 'ゲストコメント',
        ]);

        $response = $this->get("/item/{$product->id}");
        $response->assertSee('<span class="action-count">0</span>', false);
    }

    public function test_コメントが入力されていない場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $product = Product::factory()->create();

        /** @var \App\Models\User $user */

        $this->actingAs($user);

        $response = $this->post('/comments', [
            'product_id' => $product->id,
            'content' => '', 
        ]);

        $response->assertSessionHasErrors(['content']);
        $this->assertEquals(
            'コメントを入力してください',
            session('errors')->first('content')
        );
    }

    public function test_コメントが255字以上の場合、バリデーションメッセージが表示される()
    {
        $user = User::factory()->create(['email_verified_at' => now()]);
        $product = Product::factory()->create();

        /** @var \App\Models\User $user */

        $this->actingAs($user);

        $longComment = str_repeat('あ', 256); 
        $response = $this->post('/comments', [
            'product_id' => $product->id,
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors(['content']);
        $this->assertEquals(
            'コメントは255文字以内で入力してください',
            session('errors')->first('content')
        );
    }
}

