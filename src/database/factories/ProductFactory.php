<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $conditions = [
            '良好',
            '目立った傷や汚れなし',
            'やや傷や汚れあり',
            '状態が悪い'
        ];

        return [
            'seller_id' => User::factory(),
            'buyer_id' => null,
            'name' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'status' => 'available',
            'description' => $this->faker->text(100), 
            'image_path' => 'sample.png', 
            'condition' => $this->faker->randomElement($conditions),
            'price' => $this->faker->numberBetween(1000, 50000),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $categories = Category::inRandomOrder()
                ->take(rand(1, 3))
                ->get();

            $product->categories()->attach($categories->pluck('id'));
        });
    }
}
