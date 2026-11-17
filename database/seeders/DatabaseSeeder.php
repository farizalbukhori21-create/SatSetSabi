<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Denomination;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(['email' => 'admin@satsetsabi.test'], ['name' => 'SatSetSabi Admin', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::updateOrCreate(['email' => 'user@satsetsabi.test'], ['name' => 'Demo User', 'password' => Hash::make('password'), 'role' => 'user']);

        $category = Category::firstOrCreate(['slug' => 'mobile-games'], ['name' => 'Mobile Games', 'description' => 'Game populer untuk perangkat mobile.', 'is_active' => true]);
        $games = [
            ['name' => 'Mobile Legends', 'slug' => 'mobile-legends', 'description' => 'Top-Up Diamonds Mobile Legends.', 'prices' => [['name'=>'86 Diamonds','price'=>20000],['name'=>'172 Diamonds','price'=>39000],['name'=>'257 Diamonds','price'=>58000]]],
            ['name' => 'Free Fire', 'slug' => 'free-fire', 'description' => 'Top-Up Diamonds Free Fire.', 'prices' => [['name'=>'70 Diamonds','price'=>10000],['name'=>'140 Diamonds','price'=>20000],['name'=>'355 Diamonds','price'=>49000]]],
            ['name' => 'PUBG Mobile', 'slug' => 'pubg-mobile', 'description' => 'Top-Up UC PUBG Mobile.', 'prices' => [['name'=>'60 UC','price'=>16000],['name'=>'325 UC','price'=>79000],['name'=>'660 UC','price'=>155000]]],
        ];
        foreach ($games as $game) {
            $product = Product::firstOrCreate(['slug' => $game['slug']], ['category_id' => $category->id, 'name' => $game['name'], 'description' => $game['description'], 'is_active' => true]);
            foreach ($game['prices'] as $price) {
                Denomination::firstOrCreate(['product_id' => $product->id, 'name' => $price['name']], ['price' => $price['price'], 'is_active' => true]);
            }
        }
    }
}
