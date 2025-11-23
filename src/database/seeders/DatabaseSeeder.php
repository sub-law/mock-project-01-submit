<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UsersTableSeeder::class,
            CategoriesSeeder::class,
            ProductsTableSeeder::class,
            CategoryProductSeeder::class,
            PurchasesTableSeeder::class,
            FavoritesTableSeeder::class,
            CommentsTableSeeder::class,
        ]);
    }
}
