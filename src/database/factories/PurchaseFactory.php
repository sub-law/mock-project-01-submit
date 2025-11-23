<?php

namespace Database\Factories;

use App\Models\Purchase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'user_id'       => User::factory(),
            'product_id'    => Product::factory(),
            'payment_method' => $this->faker->randomElement(['convenience', 'credit']),
            'postal_code'   => $this->faker->regexify('[0-9]{3}-[0-9]{4}'),
            'address'       => $this->faker->city() . ' ' . $this->faker->streetAddress(),
            'building_name' => $this->faker->optional()->bothify('###ビル'),
        ];
    }

    public function convenience()
    {
        return $this->state(fn() => [
            'payment_method' => 'convenience',
        ]);
    }

    public function credit()
    {
        return $this->state(fn() => [
            'payment_method' => 'credit',
        ]);
    }
}
