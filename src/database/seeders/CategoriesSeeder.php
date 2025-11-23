<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['name' => 'ファッション'],//1
            ['name' => '家電'],//2
            ['name' => 'インテリア'],//3
            ['name' => 'レディース'],//4
            ['name' => 'メンズ'],//5
            ['name' => 'コスメ'],//6
            ['name' => '本'],//7
            ['name' => 'ゲーム'],//8
            ['name' => 'スポーツ'],//9
            ['name' => 'キッチン'],//10
            ['name' => 'ハンドメイド'],//11
            ['name' => 'アクセサリー'],//12
            ['name' => 'おもちゃ'],//13
            ['name' => 'ベビー・キッズ'],//14
        ]);
    }
}
