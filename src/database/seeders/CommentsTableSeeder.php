<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentsTableSeeder extends Seeder
{
    public function run()
    {
        Comment::create([
            'user_id' => 3,
            'product_id' => 1,
            'content' => '素敵な腕時計ですね！',
        ]);

        Comment::create([
            'user_id' => 1,
            'product_id' => 6,
            'content' => 'カラオケ好きには必須アイテム',
        ]);

        Comment::create([
            'user_id' => 2,
            'product_id' => 5,
            'content' => 'このノートPC、スペック気になります',
        ]);
    }
}
