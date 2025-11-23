<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'kiwi',
            'email' => 'kiwi@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'kiwi.png',
            'postal_code' => '123-4567',
            'address' => '東京都足立区',
            'building_name' => 'きのこビル101',
            'email_verified_at' => Carbon::now(),
        ]);

        User::create([
            'name' => 'orange',
            'email' => 'orange@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'orange.png',
            'postal_code' => '123-4567',
            'address' => '東京都足立区',
            'building_name' => 'きのこビル201',
        ]);

        User::create([
            'name' => 'watermelon',
            'email' => 'watermelon@example.com',
            'password' => Hash::make('password'),
            'profile_image' => 'watermelon.png',
        ]);
    }
}


