<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        Product::create([
            'seller_id' => 1,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'image_path' => 'watch.jpg',
            'condition' => '良好',
            'price' => 15000,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 1,
            'name' => 'HDD',
            'brand' => '西芝',
            'description' => '高速で信頼性の高いハードディスク',
            'image_path' => 'hdd.jpg',
            'condition' => '目立った傷や汚れなし',
            'price' => 5000,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 1,
            'name' => '玉ねぎ3束',
            'brand' => 'なし',
            'description' => '新鮮な玉ねぎ3束のセット',
            'image_path' => 'onion.jpg',
            'condition' => 'やや傷や汚れあり',
            'price' => 300,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 1,
            'name' => '革靴',
            'brand' => '',
            'description' => 'クラシックなデザインの革靴',
            'image_path' => 'shoes.jpg',
            'condition' => '状態が悪い',
            'price' => 4000,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 1,
            'name' => 'ノートPC',
            'brand' => '',
            'description' => '高性能なノートパソコン',
            'image_path' => 'notebook.jpg',
            'condition' => '良好',
            'price' => 45000,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 2,
            'name' => 'マイク',
            'brand' => 'なし',
            'description' => '高音質のレコーディング用マイク',
            'image_path' => 'microphone.jpg',
            'condition' => '目立った傷や汚れなし',
            'price' => 8000,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 2,
            'name' => 'ショルダーバッグ',
            'brand' => '',
            'description' => 'おしゃれなショルダーバッグ',
            'image_path' => 'bag.jpg',
            'condition' => 'やや傷や汚れあり',
            'price' => 3500,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 2,
            'name' => 'タンブラー',
            'brand' => 'なし',
            'description' => '使いやすいタンブラー',
            'image_path' => 'canteen.jpg',
            'condition' => '状態が悪い',
            'price' => 500,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 2,
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'description' => '手動のコーヒーミル',
            'image_path' => 'mill.jpg',
            'condition' => '良好',
            'price' => 4000,
            'status' => 'available',
        ]);

        Product::create([
            'seller_id' => 2,
            'name' => 'メイクセット',
            'brand' => '',
            'description' => '便利なメイクアップセット',
            'image_path' => 'cosmetics.jpg',
            'condition' => '目立った傷や汚れなし',
            'price' => 2500,
            'status' => 'available',
        ]);
    }
}
