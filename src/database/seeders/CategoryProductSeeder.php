<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class CategoryProductSeeder extends Seeder
{
    public function run()
    {
        // 腕時計 → ファッション + メンズ
        if ($product = Product::find(1)) {
            $product->categories()->sync([1, 5]);
        }

        // HDD → 家電
        if ($product = Product::find(2)) {
            $product->categories()->sync([2]);
        }

        // 玉ねぎ3束 → キッチン
        if ($product = Product::find(3)) {
            $product->categories()->sync([10]);
        }

        // 革靴 → ファッション + メンズ
        if ($product = Product::find(4)) {
            $product->categories()->sync([1, 5]);
        }

        // ノートPC → 家電
        if ($product = Product::find(5)) {
            $product->categories()->sync([2]);
        }

        // マイク → 家電
        if ($product = Product::find(6)) {
            $product->categories()->sync([2]);
        }

        // ショルダーバッグ → ファッション + レディース + ハンドメイド
        if ($product = Product::find(7)) {
            $product->categories()->sync([1, 4, 11]);
        }

        // タンブラー → キッチン
        if ($product = Product::find(8)) {
            $product->categories()->sync([10]);
        }

        // コーヒーミル → キッチン + インテリア
        if ($product = Product::find(9)) {
            $product->categories()->sync([3, 10]);
        }

        // メイクセット → ファッション + レディース
        if ($product = Product::find(10)) {
            $product->categories()->sync([1, 4]);
        }
    }
}
